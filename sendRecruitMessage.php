<?php
/*
** sendRecruitMessage.php
** Author: Peter DiSalvo
** Date: 12/21/2012
** Send a recruitment message.
*/
	require_once 'config.inc.php';
	require_once 'AccountSession.inc.php';
	
	$messageSubmitted = !empty($_POST['messageSubmitted']) ? $_POST['messageSubmitted'] : NULL;
	
	$currentSession = new AccountSession();
	
	if(empty($messageSubmitted))
	{
			$currentSession->openProfilePage();
	}
	else
	{
		$team = !empty($_POST['team']) ? $_POST['team'] : NULL;
		$player = !empty($_POST['player']) ? $_POST['player'] : NULL;
		$position = !empty($_POST['position']) && $_POST['position'] != '--' ? $_POST['position'] : "NULL";
		$note = !empty($_POST['note']) ? $_POST['note'] : "NULL";
		
		$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
		
		if (mysqli_connect_error())
		{
			die(Config::DB_ERROR_TEXT . mysqli_connect_errno() . ' ' . mysqli_connect_error());
		}
		
		if($_SESSION[AccountSession::SESS_ACCT_TYPE_FLD] == 'M')
		{
			$messageType = 'TP';
		}
		elseif($_SESSION[AccountSession::SESS_ACCT_TYPE_FLD] == 'P')
		{
			$messageType = 'TT';
		}
		
		$queryString = <<<SQL
		INSERT INTO recruitmessage (TeamID, PositionID, PlayerAccountNumber, MessageTypeID, Note)
		VALUES ({$team}, {$position}, {$player}, '{$messageType}', '{$note}');
SQL;
		$mysqliConnection->query($queryString) or die($mysqliConnection->error);
		
		$mysqliConnection->close();
	}
?>