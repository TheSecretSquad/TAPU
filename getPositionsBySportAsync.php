<?php
/*
** getPositionsBySportAsync.php
** Author: Peter DiSalvo
** Date: 12/14/2012
** Asynchronously called script to get the positions
** available for a given sport.
*/
	require_once('config.inc.php');
	
	$sportID = !empty($_GET['sport']) && $_GET['sport'] != '--' ? $_GET['sport'] : "NULL";
	
	// Open database connection
	$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
	
	if (mysqli_connect_error())
	{
		die('Error connecting to database' . mysqli_connect_errno() . ' ' . mysqli_connect_error());
	}
		
	$queryString = <<<SQL
	SELECT p.PositionID, p.PositionName
	FROM sportposition sp
	INNER JOIN position p
		ON sp.PositionID = p.PositionID
	WHERE sp.SportID = '{$sportID}';
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