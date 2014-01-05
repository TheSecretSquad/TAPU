<?php
/*
** getPositionsCheckBoxesBySportAsync.php
** Author: Peter DiSalvo
** Date: 12/15/2012
** Called asynchronously for players to select sports positions and
** while editing profile.
*/
	require_once('config.inc.php');
	require_once('AccountSession.inc.php');
	
	$currentSession = new AccountSession();
	
	$sportID = !empty($_GET['sport']) && $_GET['sport'] != '--' ? $_GET['sport'] : "NULL";
	
	// Open database connection
	$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
	
	if (mysqli_connect_error())
	{
		die('Error connecting to database' . mysqli_connect_errno() . ' ' . mysqli_connect_error());
	}
	
	// Get all positions including info about the positions the player plays
	$queryString = <<<SQL
	SELECT 	pos.PositionID,
			pos.PositionName,
			ppp.SkillLevelID,
			ppp.LookingStatus
	FROM sportposition sp
        INNER JOIN position pos
        ON sp.PositionID = pos.PositionID
	LEFT OUTER JOIN playerprofileposition ppp
		ON sp.PositionID = ppp.PositionID
		AND ppp.PlayerAccountNumber = {$_SESSION[AccountSession::SESS_ACCT_NUM_FLD]}
        where sp.SportID = '{$sportID}'
	ORDER BY pos.PositionName;
SQL;

	$positionsResultSet = $mysqliConnection->query($queryString);
	
	$positions = array();
	
	while($positionRecord = $positionsResultSet->fetch_array(MYSQLI_ASSOC))
	{
		$positions[] = $positionRecord;
	}
	
	$positionsResultSet->free();
	
	// Get skill level dropdown for editing positions
	$queryString = <<<SQL
		SELECT	sl.SkillLevelID,
				sl.SkillLevelName
		FROM skilllevel sl
		ORDER BY sl.SkillLevelID;
SQL;

	$skillLevelsResultSet = $mysqliConnection->query($queryString);
	$skillLevels = array();
	while($skillLevel = $skillLevelsResultSet->fetch_array(MYSQLI_ASSOC))
	{
		$skillLevels[] = $skillLevel;
	}

	$skillLevelsResultSet->free();
	
	$mysqliConnection->close();
	
	require_once Config::CTMP_OPT_POSITIONS_CHECK;
?>