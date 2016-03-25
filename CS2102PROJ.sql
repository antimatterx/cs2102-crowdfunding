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
current NUMERIC,
status VARCHAR(16) CHECK(status='ongoing' OR status='closed'),
contributors NUMERIC
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

--PROJECT
INSERT INTO project (id, creator, title, description, start, expiry, country, target, current, status, contributors) VALUES (123, 'im_not_spiderman@gmail.com', 'study', 'GIB $$$ PLOX', '2015/09/22', '2015/10/24', 'Vietnam', 500, 1, 'ongoing', 1);
INSERT INTO project (id, creator, title, description, start, expiry, country, target, current, status, contributors) VALUES (234, 'spam_me@hotmail.com', 'dream', 'This is important!! MONEY PLS', '2015/09/25', '2015/10/27', 'Malaysia', 600, 599, 'ongoing', 2);
INSERT INTO project (id, creator, title, description, start, expiry, country, target, current, status, contributors) VALUES (567, 'apple_on_my_head@hotmail.com', 'business', 'Help more people and give me money', '2015/09/26', '2015/11/26', 'Indonesia', 1500, 2, 'ongoing', 3);
INSERT INTO project (id, creator, title, description, start, expiry, country, target, current, status, contributors) VALUES (897, 'back_from_the_dead@yahoo.com', 'overseas', 'snake oil', '2014/09/22', '2014/11/22', 'China', 200, 0, 'closed', 0);

--DONATION
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-09-23 08:23:40', 1, 'im_not_spiderman@gmail.com', 123);
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-09-26 12:00:31', 200, 'spam_me@hotmail.com', 234);
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-09-26 01:21:08', 399, 'apple_on_my_head@hotmail.com', 234);
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-09-27 23:10:56', 100, 'im_not_spiderman@gmail.com', 567);
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-10-23 12:12:12', 99, 'im_not_spiderman@gmail.com', 567);
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-10-03 00:00:01', 1, 'apple_on_my_head@hotmail.com', 567);

--CATEGORY
INSERT INTO category (name) VALUES ('education');
INSERT INTO category (name) VALUES ('trip');
INSERT INTO category (name) VALUES ('start-up');
INSERT INTO category (name) VALUES ('dream');

--HAS_CATEGORY
INSERT INTO has_category (id, tag) VALUES (123, 'education');
INSERT INTO has_category (id, tag) VALUES (234, 'dream');
INSERT INTO has_category (id, tag) VALUES (234, 'start-up');
INSERT INTO has_category (id, tag) VALUES (567, 'start-up');
INSERT INTO has_category (id, tag) VALUES (897, 'trip');
