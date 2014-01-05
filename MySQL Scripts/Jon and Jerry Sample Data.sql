-- Jon and Jerry Sample Data.sql
-- Date: 12/21/2012
-- Authors: Peter DiSalvo, Jon Ditaranto, Jerry Packard
-- Creates the TAPU database and
-- inputs sample data

--
-- Table: tapu.account
--
INSERT INTO tapu.account (AccountNumber, FirstName, LastName, EmailAddress, PasswordHash, AccountTypeID) VALUES
(1, 'Jon', 'DiTaranto', 'Jon@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'M'),
(2, 'Tony', 'Mayer', 'Tony@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'M'),
(3, 'Nick', 'Orlando', 'Nick@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(4, 'Nick', 'Canova', 'NickC@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(5, 'Evan', 'Torrens', 'Evan@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(6, 'Jena', 'Atalia', 'Jena@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(7, 'Julia', 'Castaldi', 'Julia@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(8, 'Jon', 'Destefano', 'JonDestefano@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(9, 'Jackie', 'Karizara', 'Jackie@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(10, 'Tom', 'Dougless', 'Tom@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(11,'James', 'Fernando', 'James@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(12, 'Samantha', 'Davis', 'Samantha@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(13, 'Eddie', 'Daus', 'Eddie@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(14, 'Danielle', 'Paterno', 'Danielle@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(15, 'Brianna', 'Devine', 'Brianna@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(16, 'Rich', 'Melink', 'Rich@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(17, 'Steve', 'Byliki', 'Steve@gmail.com', '808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995', 'P'),
(101,'Bobby','Smith','bobsmith@gmail.com','808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995','P'),
(102,'Michael','Nillo','MicNil@gmail.com','808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995','P'),
(103,'Michelle','Obama','Mobama@gmail.com','808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995','M'),
(104,'Jill','McCormick','jillMc@gmail.com','808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995','M'),
(105,'Joe','Johnson','jjohnson@gmail.com','808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995','P'),
(106,'Jake','Jackson','jjack@gmail.com','808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995','P'),
(107,'Richie','Lipton','lipton430@gmail.com','808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995','M'),
(108,'Andy','Ton','andyton@gmail.com','808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995','M'),
(109,'James','Packer','jpack@gmail.com','808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995','M'),
(110,'Jackie','Reilly','jreillyh@gmail.com','808a1f044c827043f99717bd2eb3e77d02fb6b64d97823075f4fea7db05d216e9f24eea6c2fbc5621fc44e5fec653e7daf42bf6f1a89bbc748ef570abee78995','P');

--
-- Table: tapu.playerprofile
--
INSERT INTO tapu.playerprofile (PlayerAccountNumber, Bio, DateOfBirth, GenderID, City, StateAbbreviation, ZipCode, AccountTypeID) VALUES
(3, 'I have been playing sports my whole life.  Baseball has been my favorite sport and I have always played short stop.  Short stop is my favorite position', '1989-12-06', 'M', 'Massapequa', 'NY', '11758', 'P'),
(4, 'I love playing softaball.  I usually play outfield but i am open to playing any position.','1999-10-05', 'M', 'Farmingdale', 'NY', '11735', 'P'),
(5, 'I have never played softball on a league before, but i always play organized games with my fiends.  I can do anything from pitcher to outfield.', '1999-05-05', 'M', 'Summerfield', 'FL', '34491', 'P'),
(6, 'I have always played softball since I was little.  I have been thrown around to all different poisitions.  I am open to playing any position except catcher.','1988-04-21', 'F', 'Massapequa', 'NY', '11758', 'P'),
(7, 'All my years playing softball i have always played outfield.  I am also very good at batting.', '1987-08-19', 'F', 'Farmingdale', 'NY', '11735', 'P'),
(8, 'I have played every sport from bowling to softball.  I am very athletic and i enjoy softball the most out of any sport..  My favorite position is third base, but i have played every position before.', '1997-11-14', 'M', 'Massapequa', 'NY', '11758', 'P'),
(9, 'I am a great outfielder, and I always have been.  I played on my highschools'' varsity softball team.', '1989-12-15', 'F', 'Farmingdale', 'NY', '11735', 'P'),
(10, 'I have never played softball in a league before.  I am very athletic and i have played soccer before.', '1980-12-12', 'M', 'Ammityville', 'NY', '11762', 'P'),
(11, 'Baseball has always been my favorite sport.  I used to go to games with my dad all the time.  My favorite position is second base.', '1982-07-20', 'M', 'Farmingdale', 'NY', '11735', 'P'),
(12, 'I have played every sport from bowling to softball.  I am very athletic and i enjoy softball the most out of any sport.  My favorite position is third base, but i have played every position before.', '1987-05-19', 'F', 'Massapequa', 'NY', '11758', 'P'),
(13, 'Baseball has always been my favorite sport.  I used to go to games with my dad all the time.  My favorite position is second base.', '1988-04-14', 'M', 'Farmingdale', 'NY', '11735', 'P'),
(14, 'All my years playing softball i have always played outfield.  I am also very good at batting.', '1992-12-01', 'F', 'Farmingdale', 'NY', '11735', 'P'),
(15, 'I have played on a baseball team since i was little.  I would always look forward to playing the field but I am a really good batter.', '1989-07-07', 'F', 'Farmingdale', 'NY', '11735', 'P'),
(16, 'I have played every sport from tennis to softball.  I am very athletic and i enjoy softball the most out of any sport.  My favorite position is third base, but i have played every position before.', '1989-05-18', 'M', 'Massapequa', 'NY', '11758', 'P'),
(101,'Hey my name is Bobby and I love playing sports. I currently play basketball and softball','1980-05-19','M','Hicksville','NY', NULL,'P'),
(102,'Hey my name is Mike and I love playing sports. I currently play softball on Sundays','1989-11-19','M','Levittown','NY','11756','P'),
(103,'Hey my name is Michelle and currently looking to create any team','1990-06-22','F','Levittown','NY','11756','M'),
(104,'Hey my name is Jill, Im new to this site','1985-12-24','F','Levittown','NY','11756','M'),
(105,'Hey my name is Joe and I love basketball/softball','1992-11-19','M','Hicksville','NY','11756','P'),
(106,'The best around!!!','1983-05-22','M','Levittown','NY','11756','P'),
(107,'Manager of the month.','1977-02-17','M','Levittown','NY','11756','M'),
(108,'Andy Ton','1980-03-19','M','Levittown','NY','11756','M'),
(109,'Basketball,Baseball,Softball','1970-05-19','M','Levittown','NY','11756','M'),
(110,'Jackie.looking to play softball','1975-05-19','F','Levittown','NY','11756','P');

--
-- Table: tapu.playerprofileposition
--
INSERT INTO tapu.playerprofileposition (PlayerAccountNumber, SportID, PositionID, SkillLevelID, LookingStatus) VALUES
(3, 1, 5, 3, 0),
(6, 1, 1, 2, 0),
(6, 1, 3, 2, 0),
(6, 1, 4, 2, 1),
(6, 1, 5, 2, 0),
(6, 1, 6, 2, 1),
(6, 1, 7, 2, 0),
(6, 1, 10, 2, 0),
(6, 1, 11, 2, 0),
(4, 1, 7, 3, 0),
(4, 1, 10, 3, 1),
(4, 1, 11, 3, 1),
(4, 1, 1, 1, 0),
(4, 1, 2, 1, 0),
(4, 1, 3, 1, 0),
(4, 1, 4, 1, 0),
(4, 1, 5, 2, 0),
(4, 1, 6, 1, 0),
(13, 1, 4, 4, 1),
(14, 1, 12, 4, 1),
(14, 1, 7, 3, 0),
(14, 1, 10, 3, 0),
(14, 1, 11, 3, 0),
(105,1,3,3,1),
(105,1,1,2,1),
(101,1,10,4,1),
(101,1,4,4,0),
(110,1,8,1,1);

--
-- Table: tapu.teamprofile
--
INSERT INTO tapu.teamprofile (TeamID, TeamManagerAccountNumber, TeamName, SportID, Bio, SkillLevelID, AgeMinimum, AgeMaximum, SeasonStartDate, SeasonEndDate, TryoutRequired, LeagueName, LeagueDuesAmountPerPlayer, City, StateAbbreviation, ZipCode, AccountTypeID) VALUES
(111, 1, 'Metz', 1, 'We Play to Win', 3, 18, NULL, '2013-01-01', '2012-05-02', 1, 'Nassau Softaball League', '40.00', 'Farmindale', 'NY', '11735', 'M'),
(41,107,'Dragons Softball',1,'Started in 2007. Dragons softball is a growing team',2,19,35,'2013-02-19','2013-6-10',1,'ASA',80.00,'Levittown','NY','11756','M'),
(42,107,'Tank Town',1,'Started in 2010',1,19,55,'2013-02-19','2013-6-10',0,'ASA',75.00,'Levittown','NY','11756','M'),
(43,109,'The Warriors',1,'Started in 2007',1,19,28,'2013-03-22','2013-07-10',1,'ABA',100.00,'Hicksville','NY','11801','M'),
(44,109,'Lets GO',1,'Up and coming team',1,19,35,'2013-02-19','2013-6-10',1,'ABA',125.00,'Smithtown','NY','11787','M');

--
-- Table: tapu.teamgender
--
INSERT INTO tapu.teamgender (TeamID, GenderID) VALUES
(111, 'M'),
(111, 'F'),
(41,'M'),
(42,'M'),
(43,'M'),
(44,'M');

--
-- Table: tapu.teamroster
--
INSERT INTO tapu.teamroster (RosterID, TeamID, PlayerAccountNumber) VALUES
(1, 111, 3),
(2, 111, 4),
(3, 111, 6),
(4, 111, 7),
(5, 111, 8),
(6, 111, 9),
(11, 111, 10),
(8, 111, 11),
(7, 111, 12),
(9, 111, 13),
(10, 111, 14),
(12, 111, 15);

--
-- Table: tapu.teamrosterassignment
--
INSERT INTO tapu.teamrosterassignment (RosterID, TeamID, PositionID) VALUES
(6, 111, 1),
(4, 111, 2),
(5, 111, 3),
(2, 111, 5),
(4, 111, 7),
(1, 111, 8),
(6, 111, 8),
(3, 111, 10);