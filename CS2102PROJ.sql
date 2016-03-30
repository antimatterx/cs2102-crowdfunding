CREATE TABLE person(
firstname VARCHAR(128) NOT NULL,
lastname VARCHAR(128),
email VARCHAR(256) PRIMARY KEY,
password VARCHAR(256) NOT NULL,
sex CHAR CHECK(sex='M' OR sex='F' OR sex='O') NOT NULL,
address VARCHAR(512),
register_date DATE NOT NULL,
phone NUMERIC NOT NULL,
admin CHAR CHECK(admin='Y' OR admin='N') NOT NULL
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
donor VARCHAR(256) REFERENCES person(email) ON DELETE CASCADE ON UPDATE CASCADE,
amount NUMERIC NOT NULL CHECK(amount > 0),
project NUMERIC REFERENCES project(id) ON DELETE CASCADE,
PRIMARY KEY(time, donor, project)
);

CREATE TABLE category (
name VARCHAR(64) PRIMARY KEY
);

CREATE TABLE has_category (
id NUMERIC REFERENCES project(id) ON DELETE CASCADE,
tag VARCHAR(64) REFERENCES category(name) ON DELETE CASCADE ON UPDATE CASCADE,
PRIMARY KEY(id, tag)
);

CREATE TABLE image (
id NUMERIC PRIMARY KEY REFERENCES project(id) ON DELETE CASCADE ON UPDATE CASCADE,
data BYTEA
);


--PERSON
INSERT INTO person (firstname, lastname, email, password, sex, address, register_date, phone, admin) VALUES ('Admin', 'Master', 'im_an_admin@gmail.com', 'unbreakablepassword', 'O', '1st Avenue', '2011-11-11', 12345678, 'Y');
INSERT INTO person (firstname, lastname, email, password, sex, address, register_date, phone, admin) VALUES ('Peter', 'Pan', 'im_not_spiderman@gmail.com', '123456', 'M', 'Block 345, Clementi Street 4', '2013-01-01', 9123456, 'N');
INSERT INTO person (firstname, lastname, email, password, sex, address, register_date, phone, admin) VALUES ('Jackson', 'Tan', 'spam_me@hotmail.com', '456789', 'M', 'Block 1 Unity Street', '2011-10-12', 90845678, 'N');
INSERT INTO person (firstname, lastname, email, password, sex, address, register_date, phone, admin) VALUES ('Isaac', 'Newton', 'apple_on_my_head@hotmail.com', '098765', 'M', '37 Cambridge Road', '1956-01-01', 12345612, 'N');
INSERT INTO person (firstname, email, password, sex, address, register_date, phone, admin) VALUES ('Lazarus', 'back_from_the_dead@yahoo.com', '876543', 'M', '4 Jerusalem Street', '2000-10-10', 87652345, 'N');
INSERT INTO person (firstname, lastname, email, password, sex, address, register_date, phone, admin) VALUES ('Zack', 'Brown', 'zack_brown@gmail.com', 'password', 'M', '54 Wisconsin Drive', '2014-12-12', 78945671223, 'N');
INSERT INTO person (firstname, lastname, email, password, sex, address, register_date, phone, admin) VALUES ('April', 'Foo', 'april_foo@hotmail.com', 'password1', 'F', '1 Clown Way', '2015-02-02', 99087653, 'N');
INSERT INTO person (firstname, lastname, email, password, sex, address, register_date, phone, admin) VALUES ('John', 'Doe', 'john_doe@hotmail.com', 'mypassword', 'O', '404 Not Found', '2008-08-08', 89341764, 'N');
INSERT INTO person (firstname, lastname, email, password, sex, address, register_date, phone, admin) VALUES ('Sam', 'Loh', 'sam_loh@yahoo.com', 'verysmart', 'M', 'Block 409, Tampines Avenue 8', '2009-05-16', 86578754, 'N');
INSERT INTO person (firstname, lastname, email, password, sex, address, register_date, phone, admin) VALUES ('Sarah', 'Lee', 'sarah_lee@gmail.com', 'abcdefgh', 'F', 'Block 32 Changi Park', '2010-03-08', 92345654, 'N');
INSERT INTO person (firstname, lastname, email, password, sex, address, register_date, phone, admin) VALUES ('Able', 'Too', 'able_too@gmail.com', 'supergood', 'M', '9 Brown Drive', '2003-09-10', 1234325679, 'N');
INSERT INTO person (firstname, lastname, email, password, sex, address, register_date, phone, admin) VALUES ('Jack', 'Goh', 'jack_goh@yahoo.com', 'mypassword', 'M', '23 Guang Zhou Road 1', '2012-12-12', 67587456, 'N');
INSERT INTO person (firstname, lastname, email, password, sex, address, register_date, phone, admin) VALUES ('Mary', 'Johnson', 'mary_john@gmail.com', 'secret', 'F', '15 Madison Avenue', '2015-09-10', 92345124, 'N');
INSERT INTO person (firstname, lastname, email, password, sex, address, register_date, phone, admin) VALUES ('Molly', 'Miller', 'molly_miller@gmail.com', 'dontknow', 'F', '89 Hellow Wing', '2014-07-10', 87981234, 'N');

--PROJECT
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (2, 'back_from_the_dead@yahoo.com', 'Innovative Gaming Controller', 'Special controller for gaming, for improved peformance', '2014/09/22', '2014/11/22', 'China', 300, 'closed');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (55, 'zack_brown@gmail.com', 'New Art', 'A new way to create art', '2016/01/22', '2016/04/01', 'Vietnam', 5000, 'ongoing');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (56, 'april_foo@hotmail.com', 'Learn Fast', 'Learn without barriers with our special tool', '2016/02/01', '2016/04/27', 'Singapore', 650, 'ongoing');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (67, 'john_doe@hotmail.com', 'Waste Less', 'Reduce waste using this novel invention', '2016/01/01', '2016/06/30', 'Indonesia', 1500, 'ongoing');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (73, 'sam_loh@yahoo.com', 'Speed Mouse', 'Control the cursor like never before', '2016/02/08', '2016/03/08', 'USA', 200, 'closed');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (84, 'john_doe@hotmail.com', 'High Res Camera', 'Take videos with 16k resolution', '2016/03/10', '2016/07/31', 'Britain', 100000, 'ongoing');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (72, 'sarah_lee@gmail.com', 'Digital Score', 'Scan and playback sheet music!', '2016/02/13', '2016/10/13', 'USA', 20000, 'ongoing');
INSERT INTO project (id, creator, title, description, start, expiry, country, target, status) VALUES (14, 'able_too@gmail.com', 'Food Maker', 'Cook twice the amount of food in half the time!', '2015/09/14', '2016/10/14', 'China', 3500, 'ongoing');

--DONATION
INSERT INTO donation (time, amount, donor, project) VALUES ('2016-02-23 08:23:40', 1, 'im_not_spiderman@gmail.com', 73);
INSERT INTO donation (time, amount, donor, project) VALUES ('2014-10-26 12:00:31', 200, 'spam_me@hotmail.com', 2);
INSERT INTO donation (time, amount, donor, project) VALUES ('2014-11-02 01:21:08', 100, 'apple_on_my_head@hotmail.com', 2);
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-09-27 23:10:56', 100, 'im_not_spiderman@gmail.com', 67);
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-10-23 12:12:12', 99, 'im_not_spiderman@gmail.com', 84);
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-10-03 00:00:01', 1, 'apple_on_my_head@hotmail.com', 14);
INSERT INTO donation (time, amount, donor, project) VALUES ('2016-02-02 10:10:10', 99, 'molly_miller@gmail.com', 67);
INSERT INTO donation (time, amount, donor, project) VALUES ('2016-03-01 00:00:01', 5000, 'mary_john@gmail.com', 55);
INSERT INTO donation (time, amount, donor, project) VALUES ('2016-02-03 12:12:12', 23, 'sam_loh@yahoo.com', 67);
INSERT INTO donation (time, amount, donor, project) VALUES ('2015-10-03 00:00:01', 1, 'sarah_lee@gmail.com', 67);
INSERT INTO donation (time, amount, donor, project) VALUES ('2016-02-014 10:10:10', 5, 'john_doe@hotmail.com', 72);
INSERT INTO donation (time, amount, donor, project) VALUES ('2016-02-28 00:00:01', 400, 'zack_brown@gmail.com', 72);


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
INSERT INTO has_category (id, tag) VALUES (2, 'gaming');
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

