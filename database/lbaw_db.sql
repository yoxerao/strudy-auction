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
    user_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE
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
    user_id INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
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
    seen BOOLEAN NOT NULL, 
    id_user INTEGER NOT NULL REFERENCES users (id) ON UPDATE CASCADE
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

CREATE INDEX auction_owner ON auction USING btree (user_id);
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

CREATE OR REPLACE FUNCTION create_bid_notifications() RETURNS TRIGGER AS 
$BODY$
DECLARE
    auction_id INTEGER;
    auction_name TEXT;
    owner_id INTEGER;
    outbid_user_id INTEGER;
    notification_id INTEGER;
BEGIN
    -- Get the auction and user IDs for the new bid
    SELECT id, name, user_id INTO auction_id, auction_name, owner_id FROM auction WHERE id = NEW.id_auction;

    -- Insert a new_bid notification for the owner of the auction
    INSERT INTO notification (content, seen, id_user)
    VALUES ('Your auction ' || auction_name || ' has received a new bid!', FALSE, owner_id)
    RETURNING id INTO notification_id;

    -- Insert a row into the new_bid table
    INSERT INTO new_bid (id_notification, id_bid)
    VALUES (notification_id, NEW.id);

    -- Get the user ID of the previous highest bidder (if any)
    SELECT user_id INTO outbid_user_id FROM bid WHERE id_auction = NEW.id_auction AND value = (SELECT MAX(value) FROM bid WHERE id_auction = NEW.id_auction AND id < NEW.id);

    -- If there was a previous highest bidder, insert an outbid notification for them
    IF outbid_user_id IS NOT NULL THEN
        INSERT INTO notification (content, seen, id_user)
        VALUES ('You have been outbid on auction ' || auction_name || '!', FALSE, outbid_user_id)
        RETURNING id INTO notification_id;

        -- Insert a row into the outbid table
        INSERT INTO outbid (id_notification, id_bid)
        VALUES (notification_id, NEW.id);
    END IF;

    RETURN NEW;
END;
$BODY$ 
LANGUAGE plpgsql;

CREATE TRIGGER create_bid_notifications
AFTER INSERT ON bid
FOR EACH ROW
EXECUTE PROCEDURE create_bid_notifications();

--------------------------------------------------------------------------------

CREATE OR REPLACE FUNCTION create_auction_notifications() RETURNS TRIGGER AS 
$BODY$
DECLARE
    auction_id INTEGER;
    auction_name TEXT;
    owner_id INTEGER;
    winner_id INTEGER;
    notification_id INTEGER;
BEGIN
    -- Get the auction and user IDs for the updated auction
    SELECT id, name, user_id, winner INTO auction_id, auction_name, owner_id, winner_id FROM auction WHERE id = NEW.id;

    -- Insert an end_of_auction notification for the owner of the auction
    INSERT INTO notification (content, seen, id_user)
    VALUES ('Auction ' || auction_name || ' has ended!', FALSE, owner_id)
    RETURNING id INTO notification_id;

    -- Insert a row into the end_of_auction table
    INSERT INTO end_of_auction (id_notification, id_auction)
    VALUES (notification_id, auction_id);

    -- Insert an auction_winner notification for the winner
    INSERT INTO notification (content, seen, id_user)
    VALUES ('You have won the auction ' || auction_name || '!', FALSE,  winner_id)
    RETURNING id INTO notification_id;

    -- Insert a row into the winner_auction table
    INSERT INTO winner_auction (id_notification, id_auction)
    VALUES (notification_id, auction_id);

    RETURN NEW;
END;
$BODY$ 
LANGUAGE plpgsql;

CREATE TRIGGER notif_auction
AFTER UPDATE ON auction
FOR EACH ROW
WHEN (OLD.winner IS DISTINCT FROM NEW.winner)
EXECUTE PROCEDURE create_auction_notifications();

--------------------------------------------------------------------------------

                                -- Populate --

--------------------------------------------------------------------------------

