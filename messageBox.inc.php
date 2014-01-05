<?php
/*
** messageBox.inc.php
** Author: Peter DiSalvo
** Date: 12/14/2012
** Builds the message box.
*/

	require_once 'AccountSession.inc.php';

	if(!isset($currentSession))
	{
		$currentSession = new AccountSession();
	}

	$userAccountType = $_SESSION[AccountSession::SESS_ACCT_TYPE_FLD];
	
	$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
		
	if (mysqli_connect_error())
	{
		die(Config::DB_ERROR_TEXT . mysqli_connect_errno() . ' ' . mysqli_connect_error());
	}

	switch ($userAccountType)
	{
		case 'P':	
		$queryString = <<<SQL
		SELECT	rm.MessageID,
				tp.TeamName,
				tp.TeamLogoPath,
				s.SportName,
				pos.PositionName,
				rm.Note,
				rm.DateSent,
				rm.MessageTypeID,
				rm.MessageStateID,
				rm.ResultAcknowledged
		FROM recruitmessage rm
		INNER JOIN teamprofile tp
			ON rm.TeamID = tp.TeamID
		INNER JOIN sport s
			ON tp.SportID = s.SportID
		LEFT OUTER JOIN position pos
			ON rm.PositionID = pos.PositionID
		WHERE rm.PlayerAccountNumber = {$_SESSION[AccountSession::SESS_ACCT_NUM_FLD]}
		AND ((rm.MessageTypeID = 'TP' AND rm.MessageStateID = 'U') OR (rm.MessageTypeID = 'TT' AND (rm.MessageStateID = 'U' OR (rm.ResultAcknowledged = FALSE AND (rm.MessageStateID = 'A' OR rm.MessageStateID = 'D')))));
SQL;
			break;
		case 'M':	
			$queryString = <<<SQL
		SELECT	rm.MessageID,
				tp.TeamName,
				pp.ProfilePicturePath,
				CONCAT(a.FirstName,' ', a.LastName) AS PlayerName,
				s.SportName,
				pos.PositionName,
				rm.Note,
				rm.DateSent,
				rm.MessageTypeID,
				rm.MessageStateID,
				rm.ResultAcknowledged
		FROM recruitmessage rm
		INNER JOIN playerprofile pp
			ON rm.PlayerAccountNumber = pp.PlayerAccountNumber
		INNER JOIN account a
			ON pp.PlayerAccountNumber = a.AccountNumber
		INNER JOIN teamprofile tp
			ON rm.TeamID = tp.TeamID
		INNER JOIN sport s
			ON tp.SportID = s.SportID
		LEFT OUTER JOIN position pos
			ON rm.PositionID = pos.PositionID
		WHERE tp.TeamManagerAccountNumber = {$_SESSION[AccountSession::SESS_ACCT_NUM_FLD]}
		AND ((rm.MessageTypeID = 'TT' AND rm.MessageStateID = 'U') OR (rm.MessageTypeID = 'TP' AND (rm.MessageStateID = 'U' OR (rm.ResultAcknowledged = FALSE AND (rm.MessageStateID = 'A' OR rm.MessageStateID = 'D')))));
SQL;
			break;
	}
	
	$messagesResultSet = $mysqliConnection->query($queryString) or die($mysqliConnection->error);

	if($messagesResultSet->num_rows != 0)
	{
		$messages = array();
		while($messageRecord = $messagesResultSet->fetch_array(MYSQLI_ASSOC))
		{
			$messages[] = $messageRecord;
		}
		
		$messagesResultSet->free();
		
		$mysqliConnection->close();
		
		require_once Config::CTMP_MSG;
	}
?>
	
<?php
/*
	<li class="message"><img class="iconLarge" src="images/gookie.png" /><p class="messageText">The tigers are recruiting you to play left-field on their softball team.</p></li>
*/
?>