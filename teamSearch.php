<?php
/*
** teamSearch.php
** Author: Peter DiSalvo
** Date: 12/14/2012
** Display the team search page.
*/
require_once('config.inc.php');

// Open database connection
$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
	
if (mysqli_connect_error())
{
	die(Config::DB_ERROR_TEXT . mysqli_connect_errno() . ' ' . mysqli_connect_error());
}
	
// Load States dropdown
$queryString = "SELECT StateAbbreviation, StateName FROM states;";

$statesResultSet = $mysqliConnection->query($queryString);

$states = array();
while($stateRecord = $statesResultSet->fetch_array(MYSQLI_ASSOC))
{
	$states[] = $stateRecord;
}

// Load States dropdown	
$queryString = "SELECT GenderID, GenderName FROM gender;";

$gendersResultSet = $mysqliConnection->query($queryString);

$genders = array();
while($genderRecord = $gendersResultSet->fetch_array(MYSQLI_ASSOC))
{
	$genders[] = $genderRecord;
}

// Load Sports dropdown
$queryString = "SELECT s.SportID, s.SportName FROM sport s;";

$sportsResultSet = $mysqliConnection->query($queryString);

$sports = array();
while($sportRecord = $sportsResultSet->fetch_array(MYSQLI_ASSOC))
{
	$sports[] = $sportRecord;
}

// Load Skill Level dropdown
$queryString = "SELECT sl.SkillLevelID, sl.SkillLevelName FROM skilllevel sl ORDER BY sl.SkillLevelID;";

$skillLevelResultSet = $mysqliConnection->query($queryString);

$skillLevels = array();
while($skillLevelRecord = $skillLevelResultSet->fetch_array(MYSQLI_ASSOC))
{
	$skillLevels[] = $skillLevelRecord;
}

$statesResultSet->free();
$gendersResultSet->free();
$sportsResultSet->free();
$skillLevelResultSet->free();
$mysqliConnection->close();

$pageTitle = "Search for Teams";
$targetContent = Config::CTMP_SEARCH_TEAM;
$pageSpecificScripts[] = Config::SCRPT_SEARCH_GLOBAL;
$pageSpecificScripts[] = Config::SCRPT_SEARCH_TEAM;
require_once Config::PAGE_GLOBAL;
?>