<?php
/*
** recruitMessageBox.inc.php
** Author: Peter DiSalvo
** Date: 12/22/2012
** Recruit message box content.
*/
	$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
	
	if (mysqli_connect_error())
	{
		die(Config::DB_ERROR_TEXT . mysqli_connect_errno() . ' ' . mysqli_connect_error());
	}
	
	if($recruitingAccountType == 'M')
	{
		// Get teams of which the player is not already a member
		// and has no outstanding recruitments.
		$queryString = <<<SQL
		SELECT DISTINCT tp.TeamID,
				tp.TeamName
		FROM teamprofile tp
        LEFT OUTER JOIN teamroster tr
        	ON tp.TeamID = tr.TeamID
        WHERE tp.TeamManagerAccountNumber = {$recruitingParty}
        AND tp.TeamID NOT IN(SELECT TeamID FROM teamroster tr WHERE tr.PlayerAccountNumber = {$selectedAcctNum})
        AND tp.TeamID NOT IN(SELECT TeamID FROM recruitmessage rm WHERE rm.MessageStateID = 'U');
SQL;

		$teamsResultSet = $mysqliConnection->query($queryString) or die ($mysqliConnection->error);
		
		$messageTeams = array();
		while($messageTeam = $teamsResultSet->fetch_array(MYSQLI_ASSOC))
		{
			$messageTeams[] = $messageTeam;
		}
	}
	else if($recruitingAccountType == 'P')
	{
		// Get positions by team
		$queryString = <<<SQL
		SELECT 	p.PositionID,
				p.PositionName
		FROM sportposition sp
		INNER JOIN position p
			ON sp.PositionID = p.PositionID
		INNER JOIN teamprofile tp
			ON tp.SportID = sp.SportID
		WHERE tp.TeamID = {$selectedAcctNum};
SQL;
		$positionsResultSet = $mysqliConnection->query($queryString);

		$positions = array();
		
		while($positionRecord = $positionsResultSet->fetch_array(MYSQLI_ASSOC))
		{
			$positions[] = $positionRecord;
		}
		
		$positionsResultSet->free();
	}
	require_once Config::CTMP_MSG_SND_RECRUIT;
?>