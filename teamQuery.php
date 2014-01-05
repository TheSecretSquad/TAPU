<?php
/*
** teamQuery.php
** Author: Peter DiSalvo
** Date: 12/14/2012
** Query teams with criteria.
*/
require_once('config.inc.php');
	// Get form values
	$teamName = !empty($_GET['teamName']) ? "'". $_GET['teamName'] ."'" : "NULL";
	$city = !empty($_GET['city']) ? "'".$_GET['city']."'" : "NULL";
	$stateAbbreviation = !empty($_GET['state']) && $_GET['state'] != '--' ? "'". $_GET['state'] ."'" : "NULL";
	$genderID = !empty($_GET['gender']) && $_GET['gender'] != '--' ? "'" . $_GET['gender'] . "'" : "NULL";
	$sportID = !empty($_GET['sport']) && $_GET['sport'] != '--' ? $_GET['sport'] : "NULL";
	$skillLevelID = !empty($_GET['skillLevel']) && $_GET['skillLevel'] != '--' ? $_GET['skillLevel'] : "NULL";
	$leagueName = !empty($_GET['leagueName']) && $_GET['leagueName'] != '--' ? "'". $_GET['leagueName'] ."'" : "NULL";
	$hasTryouts = !empty($_GET['hasTryouts']) && $_GET['hasTryouts'] != '--' ? $_GET['hasTryouts'] : "NULL";
	$hasLeagueDues = !empty($_GET['hasLeagueDues']) && $_GET['hasLeagueDues'] != '--' ? $_GET['hasLeagueDues'] : "NULL";
	$ageMin = !empty($_GET['ageMin']) && $_GET['ageMin'] != '--' ? $_GET['ageMin'] : "NULL";
	$ageMax = !empty($_GET['ageMax']) && $_GET['ageMax'] != '--' ? $_GET['ageMax'] : "NULL";
	$lookingStatus = !empty($_GET['lookingStatus']) && $_GET['lookingStatus'] != '--' ? $_GET['lookingStatus'] : "NULL";
	$lookingPosition = !empty($_GET['position']) && $_GET['position'] != '--' ? $_GET['position'] : "NULL";
	
	// Open database connection
	$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
	
	if (mysqli_connect_error())
	{
		die(Config::DB_ERROR_TEXT . mysqli_connect_errno() . ' ' . mysqli_connect_error());
	}

	$queryString = <<<SQL
	CALL teamSearch($teamName, $city, $stateAbbreviation, $genderID, $sportID, $skillLevelID, $leagueName, $hasTryouts,
						$hasLeagueDues, $ageMin, $ageMax, $lookingStatus, $lookingPosition);
SQL;

	$teamsResultSet = $mysqliConnection->query($queryString) or die($mysqliConnection->error);
	
	$teams = array();
	
	while($teamRecord = $teamsResultSet->fetch_array(MYSQLI_ASSOC))
	{
		$teams[] = $teamRecord;
	}
	
	$teamsResultSet->free();
	$mysqliConnection->close();
	
	require_once Config::CTMP_QRY_TEAM;
?>