SET search_path TO lbaw22121;

DROP SCHEMA IF EXISTS lbaw22121 CASCADE;

CREATE SCHEMA lbaw22121;




CREATE TABLE administrator (
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL CONSTRAINT administrator_username_uk UNIQUE,
    email TEXT NOT NULL CONSTRAINT administrator_email_uk UNIQUE,
    password TEXT NOT NULL,
    name TEXT NOT NULL
);

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    balance NUMERIC NOT NULL,
    rating NUMERIC CONSTRAINT users_rating_ck CHECK (rating >= 0 AND rating <= 5),
    blocked BOOLEAN NOT NULL DEFAULT FALSE,
    banned BOOLEAN NOT NULL DEFAULT FALSE,
    terminated BOOLEAN NOT NULL DEFAULT FALSE,
    username TEXT NOT NULL CONSTRAINT user_username_uk UNIQUE,
    email TEXT NOT NULL CONSTRAINT user_email_uk UNIQUE,
    password TEXT NOT NULL,
    name TEXT NOT NULL
);

CREATE TABLE auction (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    buyout_value NUMERIC NOT NULL,
    min_bid NUMERIC NOT NULL,
    description TEXT,
    start_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    end_date TIMESTAMP WITH TIME ZONE NOT NULL,
    winner INTEGER REFERENCES users (id) ON UPDATE CASCADE,
    owner INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE
);


CREATE TABLE image (
    id SERIAL PRIMARY KEY,
    path_name TEXT NOT NULL CONSTRAINT image_pathname_uk UNIQUE,
    id_auction INTEGER REFERENCES auction (id) ON UPDATE CASCADE,
    id_user INTEGER REFERENCES users (id) ON UPDATE CASCADE
);


CREATE TABLE bid (
    id SERIAL PRIMARY KEY,
    value NUMERIC NOT NULL,
    date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    winner BOOLEAN NOT NULL DEFAULT FALSE,
    bidder INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
    id_auction INTEGER NOT NULL REFERENCES auction (id) ON UPDATE CASCADE
);

CREATE TABLE deposit (
    id SERIAL PRIMARY KEY,
    value NUMERIC NOT NULL,
    date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    author INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE
);



CREATE TABLE rates (
    rating INTEGER NOT NULL CONSTRAINT user_rate_ck CHECK ((rating = 0) OR (rating = 1) OR (rating = 2) OR (rating = 3) OR (rating = 4) OR (rating = 5)), 
    id_rater INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
    id_rated INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_rater, id_rated)
);

CREATE TABLE notification (
    id SERIAL PRIMARY KEY,
    content TEXT NOT NULL,
    creation_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    seen BOOLEAN NOT NULL
);

CREATE TABLE user_notification (
    id_user INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
    id_notification INTEGER NOT NULL REFERENCES notification (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_user, id_notification) 
);

CREATE TABLE new_bid(
    id_notification INTEGER PRIMARY KEY REFERENCES notification (id) ON UPDATE CASCADE,
    id_bid INTEGER NOT NULL REFERENCES bid (id) ON UPDATE CASCADE
);

CREATE TABLE outbid(
    id_notification INTEGER PRIMARY KEY REFERENCES notification (id) ON UPDATE CASCADE,
    id_bid INTEGER NOT NULL REFERENCES bid (id) ON UPDATE CASCADE
);

CREATE TABLE end_of_auction(
    id_notification INTEGER PRIMARY KEY REFERENCES notification (id) ON UPDATE CASCADE,
    id_auction INTEGER NOT NULL REFERENCES auction (id) ON UPDATE CASCADE
);

CREATE TABLE winner_auction(
    id_notification INTEGER PRIMARY KEY REFERENCES notification (id) ON UPDATE CASCADE,
    id_auction INTEGER NOT NULL REFERENCES auction (id) ON UPDATE CASCADE
);

CREATE TABLE report (
    id SERIAL PRIMARY KEY,
    reason TEXT NOT NULL,
    date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    author INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
    reported INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE
);

CREATE TABLE validation (
    id_report INTEGER PRIMARY KEY REFERENCES report (id) ON UPDATE CASCADE,
    id_administrator INTEGER NOT NULL REFERENCES administrator (id) ON UPDATE CASCADE,
    banned BOOLEAN NOT NULL,
    date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL
);

CREATE TABLE comment (
    id SERIAL PRIMARY KEY,
    author INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
    id_auction INTEGER NOT NULL REFERENCES auction (id) ON UPDATE CASCADE,
    creation_date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    content TEXT NOT NULL
);



CREATE TABLE category (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL
);

CREATE TABLE auction_category (
    id_auction INTEGER NOT NULL REFERENCES auction (id) ON UPDATE CASCADE,
    id_category INTEGER NOT NULL REFERENCES category (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_auction, id_category)
);



CREATE TABLE user_follow_auction (
    id_user INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
    id_auction INTEGER NOT NULL REFERENCES auction (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_user, id_auction)
);
--------------------------------------------------------------------------------

                                -- INDEXES --

--------------------------------------------------------------------------------

CREATE INDEX auction_owner ON auction USING btree (owner);
CLUSTER auction USING auction_owner;

CREATE INDEX auction_winner ON auction USING hash (winner);

CREATE INDEX auction_bids ON bid USING hash (id_auction);

ALTER TABLE auction ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION auction_search() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN NEW.tsvectors = (setweight(to_tsvector('english',NEW.name), 'A') ||
                                setweight(to_tsvector('english',NEW.description), 'B'));
    END IF;
    IF TG_OP = 'UPDATE' THEN 
        IF (NEW.name <> OLD.name OR NEW.description <> OLD.description) THEN
            NEW.tsvectors = (setweight(to_tsvector('english',NEW.name), 'A') ||
            setweight(to_tsvector('english',NEW.description), 'B'));
        END IF;
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER auction_search 
BEFORE INSERT OR UPDATE ON auction 
FOR EACH ROW 
EXECUTE PROCEDURE auction_search();

CREATE INDEX auction_search_idx ON auction USING GIN (tsvectors);


--------------------------------------------------------------------------------

                                -- TRIGGERS --

--------------------------------------------------------------------------------

CREATE FUNCTION rating_user() RETURNS TRIGGER AS 
$BODY$
DECLARE final_rate NUMERIC = (SELECT avg(rating) FROM rates WHERE NEW.id_rated=rates.id_rated);
BEGIN
    UPDATE users SET rating=final_rate WHERE NEW.id_rated=users.id;
    RETURN null;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER rating_user
    AFTER INSERT ON rates
    FOR EACH ROW
    EXECUTE FUNCTION rating_user();

--------------------------------------------------------------------------------

CREATE FUNCTION deposit_balance() RETURNS TRIGGER AS 
$BODY$
BEGIN
    UPDATE users SET balance = balance + NEW.value WHERE NEW.author=users.id;
    RETURN null;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER deposit_balance
    AFTER INSERT ON deposit
    FOR EACH ROW
    EXECUTE FUNCTION deposit_balance();

--------------------------------------------------------------------------------

CREATE FUNCTION is_banned() RETURNS TRIGGER AS 
$BODY$
DECLARE reported INTEGER = (SELECT reported FROM report WHERE NEW.id_report=report.id);
BEGIN
    UPDATE users SET banned=NEW.banned WHERE reported=users.id;
    RETURN null;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER is_banned
    AFTER INSERT ON validation
    FOR EACH ROW
    EXECUTE FUNCTION is_banned();

--------------------------------------------------------------------------------

CREATE FUNCTION notif_bid() RETURNS TRIGGER AS 
$BODY$
DECLARE id_owner INTEGER = (SELECT owner FROM auction WHERE NEW.id_auction=auction.id);
DECLARE max_val NUMERIC = (SELECT max(value) FROM bid WHERE NEW.id_auction=bid.id_auction AND value NOT IN (SELECT max(value) FROM bid WHERE NEW.id_auction=bid.id_auction));
DECLARE id_bidder INTEGER = (SELECT bidder FROM bid WHERE NEW.id_auction=bid.id_auction AND value = max_val);
DECLARE notif_id INTEGER;
DECLARE notif_id2 INTEGER;
DECLARE text1 TEXT = 'Your auction ' || NEW.id_auction || ' has recieved a new bid!'; -- mudar para titulo da auction
DECLARE text2 TEXT = 'You have been outbid on auction ' || NEW.id_auction || '!'; -- mudar para titulo da auction
BEGIN

    INSERT INTO notification(id, content, creation_date, seen) 
        VALUES(DEFAULT, text1, DEFAULT, FALSE)
            RETURNING id INTO notif_id;

    INSERT INTO new_bid(id_notification, id_bid)
        VALUES(notif_id, NEW.id);

    INSERT INTO user_notification(id_user, id_notification)
        VALUES(id_owner, notif_id);

    IF (SELECT COUNT(*) FROM bid WHERE NEW.id_auction=bid.id_auction) > 1 THEN

        INSERT INTO notification(id, content, creation_date, seen) 
            VALUES(DEFAULT, text2, DEFAULT, FALSE)
                RETURNING id INTO notif_id2;

        INSERT INTO outbid(id_notification, id_bid)
            VALUES(notif_id2, NEW.id);

        INSERT INTO user_notification(id_user, id_notification)
            VALUES(id_bidder, notif_id2);
    END IF;

    RETURN NULL;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notif_bid
    AFTER INSERT ON bid
    FOR EACH ROW
    EXECUTE PROCEDURE notif_bid();

--------------------------------------------------------------------------------

CREATE FUNCTION notif_auction() RETURNS TRIGGER AS 
$BODY$
DECLARE id_owner INTEGER = (SELECT owner FROM auction WHERE NEW.id_auction=auction.id);
DECLARE winner INTEGER = (SELECT winner FROM auction WHERE NEW.id_auction=auction.id);
DECLARE notif_id INTEGER;
DECLARE notif_id2 INTEGER;
DECLARE text1 TEXT = 'Auction ' || NEW.name || ' has ended!';
DECLARE text2 TEXT = 'You have won the auction ' || NEW.name || '!'; 
BEGIN
    
    
    INSERT INTO notification(id_notification, content, creation_date, seen)
        VALUES(DEFAULT, text1, DEFAULT, FALSE)
            RETURNING id INTO notif_id;

    INSERT INTO user_notification(id_user, id_notification)  -- futuramente tem de dar insert em tds os users q dem follow a auction
        VALUES(id_owner, notif_id);

    INSERT INTO end_of_auction(id_notification, id_auction)
        VALUES(notif_id, id_auction);

    INSERT INTO notification(id_notification, content, creation_date, seen)
        VALUES(DEFAULT, text2, DEFAULT, FALSE)
            RETURNING id INTO notif_id2;

    INSERT INTO user_notification(id_user, id_notification)
        VALUES(winner, notif_id2);

    INSERT INTO auction_winner(id_notification, id_auction)
        VALUES(notif_id2, id_auction);
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notif_aucion
    AFTER UPDATE OF winner ON auction
    FOR EACH ROW
    EXECUTE PROCEDURE notif_auction();


insert into administrator (id, username, email, password, name) values (1, 'sbentson0', 'sbentson0@sun.com', 'tjdXVp2l', 'Sandra Bentson');

insert into users (id, balance, rating, blocked, banned, terminated, username, email, password, name) values (1, 2828.88, 2.42, false, false, false, 'lkrebs0', 'lkrebs0@comsenz.com', 'KJH6ZuMqThbV', 'Lilly Krebs');
insert into users (id, balance, rating, blocked, banned, terminated, username, email, password, name) values (2, 8004.5, null, true, true, false, 'rscoines1', 'rscoines1@blogger.com', '5KnFC0qwFS', 'Russ Scoines');

insert into auction (id, name, buyout_value, min_bid, description, start_date, end_date, winner, owner) values (1, 'mock item 1', 701.31, 81.42, 'This is an item description', '2022-10-30', '2022-11-01', null, 1);

insert into image (id, path_name, id_auction, id_user) values (1, 'http://dummyimage.com/210x249.png/5fa2dd/ffffff', 1, null);
insert into image (id, path_name, id_auction, id_user) values (2, 'http://dummyimage.com/102x186.png/5fa2dd/ffffff', null, 1);
insert into image (id, path_name, id_auction, id_user) values (3, 'http://dummyimage.com/181x156.png/ff4444/ffffff', null, 2);

insert into bid (id, value, date, winner, bidder, id_auction) values (1, 40.67, '2022-10-30', false, 1, 1);
insert into bid (id, value, date, winner, bidder, id_auction) values (2, 99.72, '2022-10-30', false, 2, 1);

insert into deposit (id, value, date, author) values (1, 61.19, '2022-10-15', 2);
insert into deposit (id, value, date, author) values (2, 500.87, '2022-10-27', 1);

insert into rates (rating, id_rater, id_rated) values (5, 2, 1);

insert into report (id, reason, date, author, reported) values (1, 'mock reason', '2022-10-21', 1, 2);

insert into validation (id_report, id_administrator, banned, date) values (1, 1, false, '2022-10-30');

insert into comment (id, author, id_auction, creation_date, content) values (1, 2, 1, '2022-10-09', 'mock comment');

insert into category (id, name) values (1, 'art');
insert into category (id, name) values (2, 'furniture');
insert into category (id, name) values (3, 'tools');
insert into category (id, name) values (4, 'clothing');
insert into category (id, name) values (5, 'toys');

insert into auction_category (id_auction, id_category) values (1, 5);

insert into user_follow_auction (id_user, id_auction) values (2, 1);

