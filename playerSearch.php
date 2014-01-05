<?php
/*
** playerSearch.php
** Author: Peter DiSalvo
** Date: 12/14/2012
** Display player search page.
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

// Load Gender dropdown	
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

$statesResultSet->free();
$gendersResultSet->free();
$sportsResultSet->free();
$mysqliConnection->close();

$pageTitle = "Search for Players";
$targetContent = Config::CTMP_SEARCH_PLAYER;
$pageSpecificScripts[] = Config::SCRPT_SEARCH_GLOBAL;
$pageSpecificScripts[] = Config::SCRPT_SEARCH_PLAYER;
require_once Config::PAGE_GLOBAL;
?>