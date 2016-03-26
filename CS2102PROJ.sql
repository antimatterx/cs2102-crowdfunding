CREATE TABLE person(
name VARCHAR(256) NOT NULL,
email VARCHAR(256) PRIMARY KEY,
password VARCHAR(256) NOT NULL
);

CREATE TABLE project (
id NUMERIC PRIMARY KEY,
creator VARCHAR(256) REFERENCES person(email),
title VARCHAR(256) NOT NULL,
description VARCHAR(2048),
start DATE,
expiry DATE CHECK(expiry > start),
country VARCHAR(64),
target NUMERIC CHECK(target > 0),
status VARCHAR(16) CHECK(status='ongoing' OR status='closed')
);

CREATE TABLE donation (
time TIMESTAMP, -- must be later than the project start and earlier than project end
donor VARCHAR(256) REFERENCES person(email),
amount NUMERIC NOT NULL CHECK(amount > 0),
project NUMERIC REFERENCES project(id),
PRIMARY KEY(time, donor, project)
);


CREATE TABLE category (
name VARCHAR(64) PRIMARY KEY
);

CREATE TABLE has_category (
id NUMERIC REFERENCES project(id),
tag VARCHAR(64) REFERENCES category(name),
PRIMARY KEY(id, tag)
);

CREATE TABLE image (
id NUMERIC PRIMARY KEY REFERENCES project(id),
data BYTEA
);


--PERSON
INSERT INTO person (name, email, password) VALUES ('Peter', 'im_not_spiderman@gmail.com', '123456');
INSERT INTO person (name, email, password) VALUES ('Jackson', 'spam_me@hotmail.com', '456789');
INSERT INTO person (name, email, password) VALUES ('Isaac', 'apple_on_my_head@hotmail.com', '098765');
INSERT INTO person (name, email, password) VALUES ('Lazarus', 'back_from_the_dead@yahoo.com', '876543');
INSERT INTO person (name, email, password) VALUES ('Zack Brown', 'zack_brown@gmail.com', 'password');
INSERT INTO person (name, email, password) VALUES ('April Foo', 'april_foo@hotmail.com', 'password1');
INSERT INTO person (name, email, password) VALUES ('John Doe', 'john_doe@hotmail.com', 'mypassword');
INSERT INTO person (name, email, password) VALUES ('Sam Loh', 'sam_loh@yahoo.com', 'verysmart');
INSERT INTO person (name, email, password) VALUES ('Sarah Lee', 'sarah_lee@gmail.com', 'abcdefgh');
INSERT INTO person (name, email, password) VALUES ('Able Too', 'able_too@gmail.com', 'supercapableperson');

--PROJECT
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (123, 'im_not_spiderman@gmail.com', 'study', 'GIB $$$ PLOX', '2015/09/22', '2016/10/24', 'Vietnam', 500, 'ongoing');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (234, 'spam_me@hotmail.com', 'dream', 'This is important!! MONEY PLS', '2015/09/25', '2016/10/27', 'Malaysia', 600, 'ongoing');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (567, 'apple_on_my_head@hotmail.com', 'business', 'Help more people and give me money', '2015/09/26', '2016/01/26', 'Indonesia', 1500, 'ongoing');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (897, 'back_from_the_dead@yahoo.com', 'overseas', 'snake oil', '2014/09/22', '2014/11/22', 'China', 200, 'closed');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (55, 'zack_brown@gmail.com', 'new art', 'A new way to create art', '2016/01/22', '2016/04/01', 'Vietnam', 5000, 'ongoing');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (56, 'april_foo@hotmail.com', 'learn fast', 'Learn without barriers with our special tool', '2016/02/01', '2016/04/27', 'Singapore', 650, 'ongoing');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (67, 'john_doe@hotmail.com', 'Waste Less', 'Reduce waste using this novel invention', '2016/01/01', '2016/06/30', 'Indonesia', 1500, 'ongoing');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (73, 'sam_loh@yahoo.com', 'Speed Mouse', 'Control the cursor like never before', '2016/02/08', '2016/03/08', 'USA', 200, 'closed');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (84, 'mark_twain@hotmail.com', 'High Res Camera', 'Take videos with 16k resolution', '2016/03/10', '2016/07/31', 'Britain', 100000, 'ongoing');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (72, 'sarah_lee@gmail.com', 'Digital Score', 'Scan and playback sheet music!', '2016/02/13', '2016/10/13', 'USA', 20000, 'ongoing');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (14, 'able_too@gmail.com', 'Food Maker', 'Cook twice the amount of food in half the time!', '2015/09/14', '2016/10/14', 'China', 3500, 'ongoing');

--DONATION
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-09-23 08:23:40', 1, 'im_not_spiderman@gmail.com', 123);
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-09-26 12:00:31', 200, 'spam_me@hotmail.com', 234);
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-09-26 01:21:08', 399, 'apple_on_my_head@hotmail.com', 234);
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-09-27 23:10:56', 100, 'im_not_spiderman@gmail.com', 567);
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-10-23 12:12:12', 99, 'im_not_spiderman@gmail.com', 567);
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-10-03 00:00:01', 1, 'apple_on_my_head@hotmail.com', 567);

--CATEGORY
INSERT INTO category (name) VALUES ('art');
INSERT INTO category (name) VALUES ('education');
INSERT INTO category (name) VALUES ('environment');
INSERT INTO category (name) VALUES ('gaming');
INSERT INTO category (name) VALUES ('music');
INSERT INTO category (name) VALUES ('technology');
INSERT INTO category (name) VALUES ('video');
INSERT INTO category (name) VALUES ('others');

--HAS_CATEGORY
INSERT INTO has_category (id, tag) VALUES (123, 'education');
INSERT INTO has_category (id, tag) VALUES (234, 'others');
INSERT INTO has_category (id, tag) VALUES (567, 'others');
INSERT INTO has_category (id, tag) VALUES (897, 'others');
INSERT INTO has_category (id, tag) VALUES (55, 'art');
INSERT INTO has_category (id, tag) VALUES (56, 'education');
INSERT INTO has_category (id, tag) VALUES (56, 'technology');
INSERT INTO has_category (id, tag) VALUES (67, 'environment');
INSERT INTO has_category (id, tag) VALUES (73, 'gaming');
INSERT INTO has_category (id, tag) VALUES (84, 'video');
INSERT INTO has_category (id, tag) VALUES (67, 'technology');
INSERT INTO has_category (id, tag) VALUES (73, 'technology');
INSERT INTO has_category (id, tag) VALUES (84, 'technology');
INSERT INTO has_category (id, tag) VALUES (72, 'music');
INSERT INTO has_category (id, tag) VALUES (14, 'others');

