-- Create TAPU Database.sql 
-- Date: 12/17/2012
-- Author: Peter DiSalvo
-- Creates the empty TAPU database

-- 
-- Database Creation
-- ------------------------------

CREATE DATABASE tapu
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- 
-- Table Creation
-- ------------------------------

--
-- Table: Tapu.AccountType
--
CREATE TABLE tapu.accounttype
(
	AccountTypeID char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	AccountTypeName varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	CONSTRAINT PK_AccountType PRIMARY KEY(AccountTypeID),
	CONSTRAINT IX_AccountType_AccountTypeName UNIQUE INDEX USING BTREE (AccountTypeName)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.Gender
--
CREATE TABLE tapu.gender
(
	GenderID char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	GenderName varchar(6) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	CONSTRAINT PK_Gender PRIMARY KEY(GenderID),
	CONSTRAINT IX_Gender_GenderName UNIQUE INDEX USING BTREE (GenderName)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.States
--
CREATE TABLE tapu.states
(
	StateAbbreviation char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	StateName varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	CONSTRAINT PK_States PRIMARY KEY(StateAbbreviation),
	CONSTRAINT IX_States_StateName UNIQUE INDEX USING BTREE (StateName)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.Sport
--
CREATE TABLE tapu.sport
(
	SportID smallint UNSIGNED NOT NULL,
	SportName varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	CONSTRAINT PK_Sport PRIMARY KEY(SportID),
	CONSTRAINT IX_Sport_SportName UNIQUE INDEX USING BTREE (SportName)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.Position
--
CREATE TABLE tapu.position
(
	PositionID smallint UNSIGNED NOT NULL,
	PositionName varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	CONSTRAINT PK_Position PRIMARY KEY(PositionID),
	CONSTRAINT IX_Position_PositionName UNIQUE INDEX USING BTREE (PositionName)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.SportPosition
--
CREATE TABLE tapu.sportposition
(
	SportID smallint UNSIGNED NOT NULL,
	PositionID smallint UNSIGNED NOT NULL,
	CONSTRAINT PK_SportPosition PRIMARY KEY(SportID, PositionID)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.Account
--
CREATE TABLE tapu.account
(
	AccountNumber int UNSIGNED NOT NULL AUTO_INCREMENT,
	FirstName varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	LastName varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	EmailAddress varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	PasswordHash varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	AccountTypeID char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	LastModified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT PK_Account PRIMARY KEY(AccountNumber),
	CONSTRAINT IX_Account_EmailAddress UNIQUE INDEX USING BTREE (EmailAddress, AccountTypeID),
	INDEX IX_Account_ForProfiles USING BTREE (AccountNumber, AccountTypeID)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.PlayerProfile
--
CREATE TABLE tapu.playerprofile
(
	PlayerAccountNumber int UNSIGNED NOT NULL,
	Bio varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	ProfilePicturePath varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	DateOfBirth date NOT NULL,
	GenderID char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	City varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	StateAbbreviation char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	ZipCode char(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	AccountTypeID char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'P',
	LastModified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT PK_PlayerProfile PRIMARY KEY(PlayerAccountNumber)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.PlayerProfilePosition
--
CREATE TABLE tapu.playerprofileposition
(
	PlayerAccountNumber int UNSIGNED NOT NULL,
	SportID smallint UNSIGNED NOT NULL,
	PositionID smallint UNSIGNED NOT NULL,
	SkillLevelID tinyint UNSIGNED NOT NULL,
	LookingStatus boolean NOT NULL DEFAULT FALSE,
	CONSTRAINT PK_PlayerProfilePosition PRIMARY KEY(PlayerAccountNumber, SportID, PositionID)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.TeamProfile
--
CREATE TABLE tapu.teamprofile
(
	TeamID int UNSIGNED NOT NULL AUTO_INCREMENT,
	TeamManagerAccountNumber int UNSIGNED NOT NULL,
	TeamName varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	SportID smallint UNSIGNED NOT NULL,
	Bio varchar(1000) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	TeamLogoPath varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	SkillLevelID tinyint UNSIGNED NOT NULL,
	AgeMinimum tinyint UNSIGNED,
	AgeMaximum tinyint UNSIGNED,
	SeasonStartDate date,
	SeasonEndDate date,
	TryoutRequired boolean NOT NULL DEFAULT FALSE,
	LeagueName varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	LeagueDuesAmountPerPlayer DECIMAL(5,2),
	City varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	StateAbbreviation char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	ZipCode char(5) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	AccountTypeID char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'M',
	LastModified timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	CONSTRAINT PK_TeamProfile PRIMARY KEY(TeamID),
	INDEX IX_TeamProfile_ForTeamProfilePosition USING BTREE (TeamID, SportID)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

DELIMITER $$

CREATE TRIGGER tapu.addTeamSportPositions AFTER INSERT ON tapu.teamprofile
	FOR EACH ROW BEGIN
		INSERT INTO tapu.teamprofileposition (TeamID, PositionID, SportID, TeamSportID)
			SELECT NEW.TeamID, sp.PositionID, sp.SportID, NEW.SportID
			FROM tapu.teamprofile tp
			INNER JOIN tapu.sportposition sp
			ON tp.SportID = sp.SportID
			WHERE tp.teamID = NEW.teamID;
	END;
$$

DELIMITER ;

--
-- Table: Tapu.TeamGender
--
CREATE TABLE tapu.teamgender
(
	TeamID int UNSIGNED NOT NULL,
	GenderID char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	CONSTRAINT PK_TeamGender PRIMARY KEY(TeamID, GenderID)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.TeamProfilePosition
--
CREATE TABLE tapu.teamprofileposition
(
	TeamID int UNSIGNED NOT NULL,
	PositionID smallint UNSIGNED NOT NULL,
	SportID smallint UNSIGNED NOT NULL,
	TeamSportID smallint UNSIGNED NOT NULL,
	LookingStatus boolean NOT NULL DEFAULT FALSE,
	CONSTRAINT PK_TeamProfilePosition PRIMARY KEY(TeamID, PositionID)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.TeamRoster
--
CREATE TABLE tapu.teamroster
(
	RosterID int UNSIGNED NOT NULL AUTO_INCREMENT,
	TeamID int UNSIGNED NOT NULL,
	PlayerAccountNumber int UNSIGNED NOT NULL,
	CONSTRAINT PK_TeamRoster PRIMARY KEY(RosterID),
	CONSTRAINT IX_TeamRoster_TeamPlayer UNIQUE INDEX USING BTREE (TeamID, PlayerAccountNumber)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.TeamRosterAssignment
--
CREATE TABLE tapu.teamrosterassignment
(
	RosterID int UNSIGNED NOT NULL,
	TeamID int UNSIGNED NOT NULL,
	PositionID smallint UNSIGNED NOT NULL,
	CONSTRAINT PK_TeamRosterAssignment PRIMARY KEY(RosterID, PositionID, TeamID)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.SkillLevel
--
CREATE TABLE tapu.skilllevel
(
	SkillLevelID tinyint UNSIGNED NOT NULL,
	SkillLevelName varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	SkillLevelDescription varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	CONSTRAINT PK_SkillLevel PRIMARY KEY(SkillLevelID),
	CONSTRAINT IX_SkillLevel_SkillLevelName UNIQUE INDEX USING BTREE (SkillLevelName),
	CONSTRAINT IX_SkillLevel_SkillLevelDescription UNIQUE INDEX USING BTREE (SkillLevelDescription)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.MessageType
--
CREATE TABLE tapu.messagetype
(
	MessageTypeID char(2) NOT NULL,
	MessageTypeName varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	CONSTRAINT PK_MessageType PRIMARY KEY(MessageTypeID),
	CONSTRAINT IX_MessageType_MessageTypeName UNIQUE INDEX USING BTREE (MessageTypeName)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.MessageState
--
CREATE TABLE tapu.messagestate
(
	MessageStateID char(1) NOT NULL,
	MessageStateName varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	CONSTRAINT PK_MessageState PRIMARY KEY(MessageStateID),
	CONSTRAINT IX_MessageState_MessageStateName UNIQUE INDEX USING BTREE (MessageStateName)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Table: Tapu.RecruitMessage
--
CREATE TABLE tapu.recruitmessage
(
	MessageID int UNSIGNED NOT NULL AUTO_INCREMENT,
	TeamID int UNSIGNED NOT NULL,
	PositionID smallint UNSIGNED,
	PlayerAccountNumber int UNSIGNED NOT NULL,
	MessageTypeID char(2) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	MessageStateID char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'U',
	DateSent datetime NOT NULL,
	DateResponded datetime DEFAULT NULL,
	Note varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci,
	ResultAcknowledged boolean NOT NULL DEFAULT FALSE,
	CONSTRAINT PK_RecruitMessage PRIMARY KEY(MessageID),
	CONSTRAINT IX_RecruitMessage_MessageFields UNIQUE INDEX USING BTREE (TeamID, PositionID, PlayerAccountNumber, MessageStateID)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

--
-- Foreign Key Creation
-- ------------------------------

--
-- Table: Tapu.SportPosition
--
ALTER TABLE tapu.sportposition ADD CONSTRAINT FK_SportPosition_Sport
FOREIGN KEY (SportID) REFERENCES tapu.sport(SportID);

ALTER TABLE tapu.sportposition ADD CONSTRAINT FK_SportPosition_Position
FOREIGN KEY (PositionID) REFERENCES tapu.position(PositionID);

--
-- Table: Tapu.Account
--
ALTER TABLE tapu.account ADD CONSTRAINT FK_Account_AccountType
FOREIGN KEY (AccountTypeID) REFERENCES tapu.accounttype(AccountTypeID);

--
-- Table: Tapu.PlayerProfile
--
ALTER TABLE tapu.playerprofile ADD CONSTRAINT FK_PlayerProfile_Account
FOREIGN KEY (PlayerAccountNumber, AccountTypeID) REFERENCES tapu.account(AccountNumber, AccountTypeID);

ALTER TABLE tapu.playerprofile ADD CONSTRAINT FK_PlayerProfile_Gender
FOREIGN KEY (GenderID) REFERENCES tapu.gender(GenderID);

ALTER TABLE tapu.playerprofile ADD CONSTRAINT FK_PlayerProfile_States
FOREIGN KEY (StateAbbreviation) REFERENCES tapu.states(StateAbbreviation);

--
-- Table: Tapu.TeamProfile
--
ALTER TABLE tapu.teamprofile ADD CONSTRAINT FK_TeamProfile_Account
FOREIGN KEY (TeamManagerAccountNumber, AccountTypeID) REFERENCES tapu.account(AccountNumber, AccountTypeID);

ALTER TABLE tapu.teamprofile ADD CONSTRAINT FK_TeamProfile_Sport
FOREIGN KEY (SportID) REFERENCES tapu.sport(SportID);

ALTER TABLE tapu.teamprofile ADD CONSTRAINT FK_TeamProfile_States
FOREIGN KEY (StateAbbreviation) REFERENCES tapu.states(StateAbbreviation);

ALTER TABLE tapu.teamprofile ADD CONSTRAINT FK_TeamProfile_SkillLevel
FOREIGN KEY (SkillLevelID) REFERENCES tapu.skilllevel(SkillLevelID);

--
-- Table: Tapu.TeamGender
--
ALTER TABLE tapu.teamgender ADD CONSTRAINT FK_TeamGender_Team
FOREIGN KEY (TeamID) REFERENCES tapu.teamprofile(TeamID);

ALTER TABLE tapu.teamgender ADD CONSTRAINT FK_TeamGender_Gender
FOREIGN KEY (GenderID) REFERENCES tapu.gender(GenderID);

--
-- Table: Tapu.PlayerProfilePosition
--
ALTER TABLE tapu.playerprofileposition ADD CONSTRAINT FK_PlayerProfilePosition_PlayerProfile
FOREIGN KEY (PlayerAccountNumber) REFERENCES tapu.playerprofile(PlayerAccountNumber);

ALTER TABLE tapu.playerprofileposition ADD CONSTRAINT FK_PlayerProfilePosition_SportPosition
FOREIGN KEY (SportID, PositionID) REFERENCES tapu.sportposition(SportID, PositionID);

ALTER TABLE tapu.playerprofileposition ADD CONSTRAINT FK_PlayerProfilePosition_SkillLevel
FOREIGN KEY (SkillLevelID) REFERENCES tapu.skilllevel(SkillLevelID);

--
-- Table: Tapu.TeamProfilePosition
--
ALTER TABLE tapu.teamprofileposition ADD CONSTRAINT FK_TeamProfilePosition_TeamProfile
FOREIGN KEY (TeamID, TeamSportID) REFERENCES tapu.teamprofile(TeamID, SportID);

ALTER TABLE tapu.teamprofileposition ADD CONSTRAINT FK_TeamProfilePosition_SportPosition
FOREIGN KEY (SportID, PositionID) REFERENCES tapu.sportposition(SportID, PositionID);

--
-- Table: Tapu.TeamRoster
--
ALTER TABLE tapu.teamroster ADD CONSTRAINT FK_TeamRoster_TeamProfile
FOREIGN KEY (TeamID) REFERENCES tapu.teamprofile(TeamID);

ALTER TABLE tapu.teamroster ADD CONSTRAINT FK_TeamRoster_PlayerProfile
FOREIGN KEY (PlayerAccountNumber) REFERENCES tapu.playerprofile(PlayerAccountNumber);

--
-- Table: Tapu.TeamRoster
--
ALTER TABLE tapu.teamrosterassignment ADD CONSTRAINT FK_TeamRosterAssignment_TeamProfilePosition
FOREIGN KEY (TeamID, PositionID) REFERENCES tapu.teamprofileposition(TeamID, PositionID);

ALTER TABLE tapu.teamrosterassignment ADD CONSTRAINT FK_TeamRosterAssignment_TeamRoster
FOREIGN KEY (RosterID) REFERENCES tapu.teamroster(RosterID);

--
-- Table: Tapu.RecruitMessage
--
ALTER TABLE tapu.recruitmessage ADD CONSTRAINT FK_RecruitMessage_MessageType
FOREIGN KEY (MessageTypeID) REFERENCES tapu.messagetype(MessageTypeID);

ALTER TABLE tapu.recruitmessage ADD CONSTRAINT FK_RecruitMessage_MessageState
FOREIGN KEY (MessageStateID) REFERENCES tapu.messagestate(MessageStateID);

ALTER TABLE tapu.recruitmessage ADD CONSTRAINT FK_RecruitMessage_TeamProfilePosition
FOREIGN KEY (TeamID, PositionID) REFERENCES tapu.teamprofileposition(TeamID, PositionID);

ALTER TABLE tapu.recruitmessage ADD CONSTRAINT FK_RecruitMessage_PlayerProfile
FOREIGN KEY (PlayerAccountNumber) REFERENCES tapu.playerprofile(PlayerAccountNumber);

--
-- Stored Procedures
-- ------------------------------

--
-- Stored Procedure: Tapu.PlayerSearch
-- Gets all players based on the filter criteria.
--
DELIMITER $$

CREATE PROCEDURE tapu.playerSearch(p_playerLastName varchar(30), p_city varchar(50), p_stateAbbreviation char(2), p_genderID char(1), p_sportID smallint, p_positionID smallint, p_lookingStatus boolean)
BEGIN
	SELECT
		a.AccountNumber,
		pp.ProfilePicturePath,
		CONCAT(a.LastName, ', ', a.FirstName) AS PlayerName,
		pp.City,
		pp.StateAbbreviation,
		g.GenderName,
		YEAR(NOW()) - YEAR(pp.DateOfBirth) AS Age,
		ppp.LookingStatus
		FROM account a
		INNER JOIN playerprofile pp
			ON a.AccountNumber = pp.PlayerAccountNumber
		INNER JOIN gender g
			ON pp.GenderID = g.GenderID
		LEFT OUTER JOIN playerprofileposition ppp
			ON pp.PlayerAccountNumber = ppp.PlayerAccountNumber
		WHERE (p_playerLastName IS NULL OR a.Lastname = p_playerLastName)
		AND (p_city IS NULL OR pp.City = p_city)
		AND (p_stateAbbreviation IS NULL OR pp.StateAbbreviation = p_stateAbbreviation)
		AND (p_genderID IS NULL OR pp.GenderID = p_genderID)
		AND (p_sportID IS NULL OR ppp.SportID = p_sportID)
		AND (p_positionID IS NULL OR ppp.PositionID = p_positionID)
		AND (p_lookingStatus IS NULL OR ppp.LookingStatus = p_lookingStatus)
		GROUP BY a.accountnumber
		ORDER BY a.LastName, pp.City, pp.StateAbbreviation;
END;
$$

DELIMITER ;

--
-- Stored Procedure: Tapu.TeamSearch
-- Gets all teams based on the filter criteria.
--
DELIMITER $$

CREATE PROCEDURE tapu.teamSearch(p_teamName varchar(30), p_city varchar(50), p_stateAbbreviation char(2), p_genderID char(1), p_sportID smallint, p_skillLevelID tinyint,
								p_leagueName varchar(30), p_tryoutRequired boolean, p_leagueDuesRequired boolean, p_ageMin tinyint(3), p_ageMax tinyint(3), p_lookingStatus boolean, p_lookingPosition smallint)
BEGIN
	SELECT	tp.TeamID,
			tp.TeamLogoPath,
			tp.TeamName,
			tp.SportID,
			s.SportName,
			tp.SkillLevelID,
			sl.SkillLevelName,
			tp.AgeMinimum,
			tp.AgeMaximum,
			COALESCE(multigenderteams.GenderID, tg.GenderID) AS Gender,
			tp.SeasonStartDate,
			tp.City,
			tp.StateAbbreviation,
			MAX(tpp.LookingStatus) AS LookingStatus
	FROM teamProfile tp
	INNER JOIN teamgender tg
		ON tp.TeamID = tg.TeamID
	INNER  JOIN sport s
		ON tp.SportID = s.SportID
	INNER JOIN skilllevel sl
		ON tp.SkillLevelID = sl.SkillLevelID
	INNER JOIN teamprofileposition tpp
		ON tp.TeamID = tpp.TeamID
	LEFT OUTER JOIN	(	SELECT 'C' AS GenderID, tp.teamid
						FROM teamprofile tp
						INNER JOIN teamgender tg
							ON tp.TeamID = tg.TeamID
						GROUP BY tp.TeamID
						HAVING COUNT(tg.GenderID) > 1) AS multigenderteams
		ON tp.teamid = multigenderteams.teamid
	WHERE (p_teamName IS NULL OR tp.TeamName = p_teamName)
		AND (p_city IS NULL OR tp.City = p_city)
		AND (p_stateAbbreviation IS NULL OR tp.StateAbbreviation = p_stateAbbreviation)
		AND (p_genderID IS NULL OR (p_genderID = 'C' AND multigenderteams.GenderID = p_genderID) OR (tg.GenderID = p_genderID AND multigenderteams.GenderID IS NULL))
		AND (p_sportID IS NULL OR tp.SportID = p_sportID)
		AND (p_skillLevelID IS NULL OR tp.SkillLevelID = p_skillLevelID)
		AND (p_leagueName IS NULL OR tp.LeagueName = p_leagueName)
		AND (p_tryoutRequired IS NULL OR tp.TryoutRequired = p_tryoutRequired)
		AND (p_leagueDuesRequired IS NULL OR tp.LeagueDuesAmountPerPlayer > 0)
		AND (p_ageMin IS NULL OR tp.AgeMinimum >= p_ageMin)
		AND (p_ageMax IS NULL OR tp.AgeMaximum <= p_ageMax)
		AND (p_lookingStatus IS NULL OR tpp.LookingStatus = p_lookingStatus)
		AND (p_lookingPosition IS NULL OR tpp.PositionID = p_lookingPosition)
	GROUP BY tp.TeamID
	ORDER BY tp.teamID, tp.City, tp.StateAbbreviation;
END;
$$

DELIMITER ;

-- Can be nested in playerSearch if needed. Might need later

-- select a.AccountNumber, group_concat(pos.positionname separator ', ')
-- from tapu.account a
-- inner join tapu.playerprofile pp
-- on a.accountnumber = pp.playeraccountnumber
-- inner join tapu.playerprofileposition ppp
-- on pp.playeraccountnumber = ppp.playeraccountnumber
-- inner join tapu.position pos
-- on ppp.positionid = pos.positionid
-- group by a.accountnumber


--
-- Stored Procedure: Tapu.PlayerSearchCategorized
-- Gets all players based on the filter criteria
-- categorized by sport, and position.
-- Includes players who have not declared any sports/positions.
--
DELIMITER $$

CREATE PROCEDURE tapu.playerSearchCategorized(playerLastName varchar(30), city varchar(50), stateAbbreviation char(2), genderID char(1), sportID int, positionID int)
BEGIN
	SELECT
		pp.ProfilePicturePath,
		CONCAT(a.LastName, ', ', a.FirstName) AS PlayerName,
		pp.City,
		pp.StateAbbreviation,
		pp.ZipCode,
		LEFT(pp.Bio, 50) AS BioSnippet,
		g.GenderName,
		YEAR(NOW()) - YEAR(pp.DateOfBirth) AS Age,
		s.SportName,
		p.PositionName,
		sl.SkillLevelName
		FROM account a
		INNER JOIN playerprofile pp
			ON a.AccountNumber = pp.PlayerAccountNumber
		INNER JOIN gender g
			ON pp.GenderID = g.GenderID
		LEFT OUTER JOIN playerprofileposition ppp
			ON pp.PlayerAccountNumber = ppp.PlayerAccountNumber
		LEFT OUTER JOIN skilllevel sl
			ON ppp.SkillLevelID = sl.SkillLevelID
		LEFT OUTER JOIN sport s
			ON ppp.SportID = s.SportID
		LEFT OUTER JOIN position p
			ON ppp.PositionID = p.PositionID
	WHERE (a.Lastname = playerLastName OR playerLastName IS NULL)
		AND (pp.City = city OR city IS NULL)
		AND (pp.StateAbbreviation = stateAbbreviation OR stateAbbreviation IS NULL)
		AND (pp.GenderID = genderID OR genderID IS NULL)
		AND (ppp.SportID = sportID OR sportID IS NULL)
		AND (ppp.PositionID = positionID OR positionID IS NULL)
		GROUP BY s.SportName, p.PositionName, a.LastName, pp.City, pp.StateAbbreviation;
END;
$$

DELIMITER ;

-- 
-- Data Input
-- ------------------------------

--
-- Table: Tapu.AccountType
--
INSERT INTO tapu.accounttype VALUES ('P', 'Player');
INSERT INTO tapu.accounttype VALUES ('M', 'Manager');

--
-- Table: Tapu.Gender
--
INSERT INTO tapu.gender VALUES('M', 'Male');
INSERT INTO tapu.gender VALUES('F', 'Female');

--
-- Table: Tapu.MessageType
--
INSERT INTO tapu.messagetype VALUES('TT', 'To Team');
INSERT INTO tapu.messagetype VALUES('TP', 'To Player');

--
-- Table: Tapu.MessageType
--
INSERT INTO tapu.messagestate VALUES('U', 'Unchecked');
INSERT INTO tapu.messagestate VALUES('A', 'Accepted');
INSERT INTO tapu.messagestate VALUES('D', 'Declined');

--
-- Table: Tapu.SkillLevel
--
INSERT INTO tapu.skilllevel VALUES(1, 'Beginner', 'Beginner description');
INSERT INTO tapu.skilllevel VALUES(2, 'Intermediate', 'Intermediate description');
INSERT INTO tapu.skilllevel VALUES(3, 'Advanced', 'Advanced description');
INSERT INTO tapu.skilllevel VALUES(4, 'Expert', 'Expert description');

--
-- Table: Tapu.States
--
INSERT INTO tapu.states VALUES('AL', 'Alabama');
INSERT INTO tapu.states VALUES('AK', 'Alaska');
INSERT INTO tapu.states VALUES('AZ', 'Arizona');
INSERT INTO tapu.states VALUES('AR', 'Arkansas');
INSERT INTO tapu.states VALUES('CA', 'California');
INSERT INTO tapu.states VALUES('CO', 'Colorado');
INSERT INTO tapu.states VALUES('CT', 'Connecticut');
INSERT INTO tapu.states VALUES('DE', 'Delaware');
INSERT INTO tapu.states VALUES('FL', 'Florida');
INSERT INTO tapu.states VALUES('GA', 'Georgia');
INSERT INTO tapu.states VALUES('HI', 'Hawaii');
INSERT INTO tapu.states VALUES('ID', 'Idaho');
INSERT INTO tapu.states VALUES('IL', 'Illinois');
INSERT INTO tapu.states VALUES('IN', 'Indiana');
INSERT INTO tapu.states VALUES('IA', 'Iowa');
INSERT INTO tapu.states VALUES('KS', 'Kansas');
INSERT INTO tapu.states VALUES('KY', 'Kentucky');
INSERT INTO tapu.states VALUES('LA', 'Louisiana');
INSERT INTO tapu.states VALUES('ME', 'Maine');
INSERT INTO tapu.states VALUES('MD', 'Maryland');
INSERT INTO tapu.states VALUES('MA', 'Massachusetts');
INSERT INTO tapu.states VALUES('MI', 'Michigan');
INSERT INTO tapu.states VALUES('MN', 'Minnesota');
INSERT INTO tapu.states VALUES('MS', 'Mississippi');
INSERT INTO tapu.states VALUES('MO', 'Missouri');
INSERT INTO tapu.states VALUES('MT', 'Montana');
INSERT INTO tapu.states VALUES('NE', 'Nebraska');
INSERT INTO tapu.states VALUES('NV', 'Nevada');
INSERT INTO tapu.states VALUES('NH', 'New Hampshire');
INSERT INTO tapu.states VALUES('NJ', 'New Jersey');
INSERT INTO tapu.states VALUES('NM', 'New Mexico	');
INSERT INTO tapu.states VALUES('NY', 'New York');
INSERT INTO tapu.states VALUES('NC', 'North Carolina');
INSERT INTO tapu.states VALUES('ND', 'North Dakota');
INSERT INTO tapu.states VALUES('OH', 'Ohio');
INSERT INTO tapu.states VALUES('OK', 'Oklahoma');
INSERT INTO tapu.states VALUES('OR', 'Oregon');
INSERT INTO tapu.states VALUES('PA', 'Pennsylvania');
INSERT INTO tapu.states VALUES('RI', 'Rhode Island');
INSERT INTO tapu.states VALUES('SC', 'South Carolina');
INSERT INTO tapu.states VALUES('SD', 'South Dakota');
INSERT INTO tapu.states VALUES('TN', 'Tennessee');
INSERT INTO tapu.states VALUES('TX', 'Texas');
INSERT INTO tapu.states VALUES('UT', 'Utah');
INSERT INTO tapu.states VALUES('VT', 'Vermont');
INSERT INTO tapu.states VALUES('VA', 'Virginia');
INSERT INTO tapu.states VALUES('WA', 'Washington');
INSERT INTO tapu.states VALUES('WV', 'West Virginia');
INSERT INTO tapu.states VALUES('WI', 'Wisconsin');
INSERT INTO tapu.states VALUES('WY', 'Wyoming');

--
-- Table: Tapu.Sport
--
INSERT INTO tapu.sport VALUES(1, 'Softball');
INSERT INTO tapu.sport VALUES(2, 'Basketball');

--
-- Table: Tapu.Position
--
INSERT INTO tapu.position VALUES(1, 'Pitcher');
INSERT INTO tapu.position VALUES(2, 'Catcher');
INSERT INTO tapu.position VALUES(3, 'First Base');
INSERT INTO tapu.position VALUES(4, 'Second Base');
INSERT INTO tapu.position VALUES(5, 'Shortstop');
INSERT INTO tapu.position VALUES(6, 'Third Base');
INSERT INTO tapu.position VALUES(7, 'Center Field');
INSERT INTO tapu.position VALUES(8, 'Left-Center Field');
INSERT INTO tapu.position VALUES(9, 'Right-Center Field');
INSERT INTO tapu.position VALUES(10, 'Left Field');
INSERT INTO tapu.position VALUES(11, 'Right Field');
INSERT INTO tapu.position VALUES(12, 'Hitter');
INSERT INTO tapu.position VALUES(13, 'Point Guard');
INSERT INTO tapu.position VALUES(14, 'Shooting Guard');
INSERT INTO tapu.position VALUES(15, 'Small Forward');
INSERT INTO tapu.position VALUES(16, 'Power Forward');
INSERT INTO tapu.position VALUES(17, 'Center');

--
-- Table: Tapu.SportPosition
--
INSERT INTO tapu.sportposition VALUES(1, 1);
INSERT INTO tapu.sportposition VALUES(1, 2);
INSERT INTO tapu.sportposition VALUES(1, 3);
INSERT INTO tapu.sportposition VALUES(1, 4);
INSERT INTO tapu.sportposition VALUES(1, 5);
INSERT INTO tapu.sportposition VALUES(1, 6);
INSERT INTO tapu.sportposition VALUES(1, 7);
INSERT INTO tapu.sportposition VALUES(1, 8);
INSERT INTO tapu.sportposition VALUES(1, 9);
INSERT INTO tapu.sportposition VALUES(1, 10);
INSERT INTO tapu.sportposition VALUES(1, 11);
INSERT INTO tapu.sportposition VALUES(1, 12);
INSERT INTO tapu.sportposition VALUES(2, 13);
INSERT INTO tapu.sportposition VALUES(2, 14);
INSERT INTO tapu.sportposition VALUES(2, 15);
INSERT INTO tapu.sportposition VALUES(2, 16);
INSERT INTO tapu.sportposition VALUES(2, 17);