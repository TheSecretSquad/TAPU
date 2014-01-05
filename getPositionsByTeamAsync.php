<?php
/*
** getPositionsByTeamAsync.php
** Author: Peter DiSalvo
** Date: 12/14/2012
** Gets the positions for a given team. Used in javascript
** async call in team search.
*/
	require_once('config.inc.php');
	
	$teamID = !empty($_GET['team']) && $_GET['team'] != '--' ? $_GET['team'] : "NULL";
	
	// Open database connection
	$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
	
	if (mysqli_connect_error())
	{
		die('Error connecting to database' . mysqli_connect_errno() . ' ' . mysqli_connect_error());
	}
	
	// Load Positions dropdown
		
	$queryString = <<<SQL
	SELECT p.PositionID, p.PositionName
	FROM sportposition sp
	INNER JOIN position p
		ON sp.PositionID = p.PositionID
	INNER JOIN teamprofile tp
		ON tp.SportID = sp.SportID
	WHERE tp.TeamID = '{$teamID}';
SQL;

	$positionsResultSet = $mysqliConnection->query($queryString);
	
	$positions = array();
	
	while($positionRecord = $positionsResultSet->fetch_array(MYSQLI_ASSOC))
	{
		
		$positions[] = $positionRecord;
	}
	
	$positionsResultSet->free();
	$mysqliConnection->close();

	require_once Config::CTMP_OPT_POSITIONS;
?>