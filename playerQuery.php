<?php
/*
** playerQuery.php
** Author: Peter DiSalvo
** Date: 12/14/2012
** Search for players with given criteria.
*/
require_once('config.inc.php');
	// Get form values
	$playerLastName = !empty($_GET['playerLastName']) ? "'". $_GET['playerLastName'] ."'" : "NULL";
	$city = !empty($_GET['city']) ? "'". $_GET['city'] ."'" : "NULL";
	$stateAbbreviation = !empty($_GET['state']) && $_GET['state'] != '--' ? "'". $_GET['state'] ."'" : "NULL";
	$genderID = !empty($_GET['gender']) && $_GET['gender'] != '--' ? "'" . $_GET['gender'] . "'" : "NULL";
	$sportID = !empty($_GET['sport']) && $_GET['sport'] != '--' ? $_GET['sport'] : "NULL";
	$positionID = !empty($_GET['position']) && $_GET['position'] != '--' ? $_GET['position'] : "NULL";
	$lookingStatus = !empty($_GET['lookingStatus']) && $_GET['lookingStatus'] != '--' ? $_GET['lookingStatus'] : "NULL";
	
	// Open database connection
	$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
	
	if (mysqli_connect_error())
	{
		die(Config::DB_ERROR_TEXT . mysqli_connect_errno() . ' ' . mysqli_connect_error());
	}

	$queryString = <<<SQL
	CALL playerSearch($playerLastName, $city, $stateAbbreviation, $genderID, $sportID, $positionID, $lookingStatus);
SQL;

	$playersResultSet = $mysqliConnection->query($queryString) or die($mysqliConnection->error);
	
	$players = array();
	
	while($playerRecord = $playersResultSet->fetch_array(MYSQLI_ASSOC))
	{
		$players[] = $playerRecord;
	}
	
	$playersResultSet->free();
	$mysqliConnection->close();
	
	require_once Config::CTMP_QRY_PLAYER;
?>