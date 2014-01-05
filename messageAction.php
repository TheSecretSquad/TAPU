<?php
/*
** messageAction.php
** Author: Peter DiSalvo
** Date: 12/14/2012
** Performs the given action on a message in a message box.
*/
require_once 'config.inc.php';

if(!empty($_GET[Config::PARAM_MSG_ACT]))
{
	$messageAction = !empty($_GET[Config::PARAM_MSG_ACT]) ? $_GET[Config::PARAM_MSG_ACT] : "NULL";
	$messageID = !empty($_GET[Config::PARAM_MSG_ID]) ? $_GET[Config::PARAM_MSG_ID] : "NULL";

	$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
	
	if (mysqli_connect_error())
	{
		die(Config::DB_ERROR_TEXT . mysqli_connect_errno() . ' ' . mysqli_connect_error());
	}
	
	switch($messageAction)
	{
		case 'C':
			$updateMessageQueryString = <<<SQL
			DELETE FROM recruitmessage WHERE MessageID = {$messageID};
SQL;
			$mysqliConnection->query($updateMessageQueryString) or die($mysqliConnection->error);
			break;
		case 'RA':
			$updateMessageQueryString = <<<SQL
			UPDATE recruitmessage SET ResultAcknowledged = TRUE WHERE MessageID = {$messageID};
SQL;
			$mysqliConnection->query($updateMessageQueryString) or die($mysqliConnection->error);
			break;
		case 'A':
			// Add player to roster
			$addToRosterQueryString = <<<SQL
			INSERT INTO teamroster (TeamID, PlayerAccountNumber)
			SELECT rm.TeamID, rm.PlayerAccountNumber
			FROM recruitmessage rm
			WHERE rm.MessageID = {$messageID};
SQL;
			$mysqliConnection->query($addToRosterQueryString) or die($mysqliConnection->error);
			
			$rosterID = $mysqliConnection->insert_id;
			
			// Assign player to position
			$addPositionQueryString = <<<SQL
			INSERT INTO teamrosterassignment (RosterID, TeamID, PositionID)
			SELECT {$rosterID}, rm.TeamID, rm.PositionID
			FROM recruitmessage rm
			WHERE rm.MessageID = {$messageID}
			AND rm.PositionID IS NOT NULL;
SQL;
			$mysqliConnection->query($addPositionQueryString) or die($mysqliConnection->error);
			
			// Update message
			$updateMessageQueryString = <<<SQL
			UPDATE recruitmessage SET MessageStateID = '{$messageAction}', DateResponded = NOW() WHERE MessageID = {$messageID};
SQL;
			$mysqliConnection->query($updateMessageQueryString) or die($mysqliConnection->error);
			break;
		case 'D':
			$updateMessageQueryString = <<<SQL
			UPDATE recruitmessage SET MessageStateID = '{$messageAction}', DateResponded = NOW() WHERE MessageID = {$messageID};
SQL;
			$mysqliConnection->query($updateMessageQueryString) or die($mysqliConnection->error);
			break;
	}
	
	$mysqliConnection->close();
	
	require_once 'messageBox.inc.php';
}
?>