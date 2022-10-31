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
