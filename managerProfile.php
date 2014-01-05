<?php
/*
** managerProfile.php
** Author: Peter DiSalvo
** Date: 12/15/2012
** Display manager profile.
*/
require_once('config.inc.php');
require_once('AccountSession.inc.php');

$selectedAcctNum = !empty($_GET[Config::PARAM_PROF_ID]) ? $_GET[Config::PARAM_PROF_ID] : NULL;

if(is_null($selectedAcctNum))
{
	$accountSession = new AccountSession();
	$accountSession->openProfilePage();
	exit;
}

$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
	
if (mysqli_connect_error())
{
	die(Config::DB_ERROR_TEXT . mysqli_connect_errno() . ' ' . mysqli_connect_error());
}

$queryString =  <<<SQL
	SELECT
		a.FirstName,
		a.LastName
	FROM account a
	WHERE a.AccountNumber = {$selectedAcctNum};
SQL;

$managerResultSet = $mysqliConnection->query($queryString) or die($mysqliConnection->error);

if($managerResultSet->num_rows == 0)
{
	$pageTitle = "We could not find the page you were looking for!";
	$targetContent = null;
}
else
{
	// Get manager profile
	$managerRecord = $managerResultSet->fetch_array(MYSQLI_ASSOC);

	$pageTitle = htmlspecialchars($managerRecord['FirstName'] . ' ' . $managerRecord['LastName']);
	$targetContent = Config::CTMP_PROF_MAN;
	
	$managerResultSet->free();
	
	// Get manager's teams
	$queryString = <<<SQL
		SELECT	tp.TeamID,
				tp.TeamName,
				tp.TeamLogoPath,
				tp.SportID,
				s.SportName,
				tp.SkilllevelID,
				sl.SkillLevelName,
				tp.AgeMinimum,
				tp.AgeMaximum,
				tp.SeasonStartDate,
				tp.SeasonEndDate,
				tp.TryoutRequired,
				tp.LeagueName,
				tp.LeagueDuesAmountPerPlayer
        FROM teamprofile tp
        INNER JOIN sport s
			ON tp.SportID = s.SportID
		INNER JOIN skilllevel sl
			ON tp.SkillLevelID = sl.SkillLevelID
        WHERE tp.TeamManagerAccountNumber = {$selectedAcctNum}
		ORDER BY s.SportName;
SQL;

	$managerTeamsResultSet = $mysqliConnection->query($queryString) or die($mysqliConnection->error);        

	$managerTeams = array();
	while($teamRecord = $managerTeamsResultSet->fetch_array(MYSQLI_ASSOC))
	{
		$managerTeams[] = $teamRecord;
	}
	
	$managerTeamsResultSet->free();

	$mysqliConnection->close();
	
	require_once Config::PAGE_GLOBAL;
}
?>