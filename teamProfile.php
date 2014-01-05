<?php
/*
** teamProfile.php
** Author: Jon Ditaranto, Peter DiSalvo
** Date: 12/17/2012
** Display the team profile page.
*/
require_once 'config.inc.php';
require_once 'AccountSession.inc.php';

$selectedAcctNum = !empty($_GET [Config::PARAM_PROF_ID]) ? $_GET [Config::PARAM_PROF_ID] : NULL;

if(is_null($selectedAcctNum))
{
	header("Location: " . Config::PAGE_HOME);
	exit;
}

$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
	
if (mysqli_connect_error())
{
	die(Config::DB_ERROR_TEXT . mysqli_connect_errno() . ' ' . mysqli_connect_error());
}

$queryString =  <<<SQL
	SELECT	DISTINCT
			tp.TeamID,
			tp.TeamLogoPath,
			tp.TeamName,
			tp.Bio,
			tp.SportID,
			s.SportName,
			tp.SkillLevelID,
			sl.SkillLevelName,
			tp.AgeMinimum,
			tp.AgeMaximum,
			COALESCE(multigenderteams.GenderID, tg.GenderID) AS Gender,
			tp.SeasonStartDate,
			tp.SeasonEndDate,
			tp.City,
			tp.StateAbbreviation
	FROM teamProfile tp
	INNER JOIN teamgender tg
		ON tp.TeamID = tg.TeamID
	INNER  JOIN sport s
		ON tp.SportID = s.SportID
	INNER JOIN skilllevel sl
		ON tp.SkillLevelID = sl.SkillLevelID
	LEFT OUTER JOIN	(	SELECT 'C' AS GenderID, tp.teamid
						FROM teamprofile tp
						INNER JOIN teamgender tg
							ON tp.TeamID = tg.TeamID
						GROUP BY tp.TeamID
						HAVING COUNT(tg.GenderID) > 1) AS multigenderteams
		ON tp.teamid = multigenderteams.teamid
		WHERE tp.teamID = {$selectedAcctNum};
SQL;

$teamResultSet = $mysqliConnection->query($queryString) or die($mysqliConnection->error);

if(is_null($teamResultSet) || $teamResultSet->num_rows == 0)
{
	$pageTitle = "We could not find the team you were looking for!";
	$targetContent = null;
}
else
{
	// Get team profile
	$teamRecord = $teamResultSet->fetch_array(MYSQLI_ASSOC);

	$pageTitle = htmlspecialchars($teamRecord['TeamName']);
	$targetContent = Config::CTMP_PROF_TEAM;
	
	$teamLogo = $teamRecord['TeamLogoPath'];
	$teamGender = $teamRecord['Gender'];
	$teamMinAge = $teamRecord['AgeMinimum'];
	$teamMaxAge = $teamRecord['AgeMaximum'];
	$teamLocation = $teamRecord['City'] . ', ' . $teamRecord['StateAbbreviation'];
	$bio = $teamRecord['Bio'];
	
	$teamResultSet->free();
	
	// Get team positions
	$queryString = <<<SQL
		SELECT	tpp.SportID,
				s.SportName,
				tpp.PositionID,
				pos.PositionName,
				tpp.LookingStatus
        FROM teamprofileposition tpp
        INNER JOIN position pos
			ON tpp.PositionID = pos.PositionID
        INNER JOIN sport s
			ON tpp.SportID = s.SportID
        WHERE tpp.TeamID = {$selectedAcctNum};
SQL;

	$positionsResultSet = $mysqliConnection->query($queryString) or die($mysqliConnection->error);        

	$positionsRecruiting = array();
	while($positionRecord = $positionsResultSet->fetch_array(MYSQLI_ASSOC))
	{
		if($positionRecord['LookingStatus'] == true)
		{
			$positionsRecruiting[] = $positionRecord;
		}
	}
	
	$positionsResultSet->free();
	
	// Get team roster
	$queryString = <<<SQL
		SELECT  tr.PlayerAccountNumber,
				a.FirstName,
				a.LastName,
				pp.ProfilePicturePath,
				pos.PositionName
		FROM teamroster tr
		LEFT OUTER JOIN teamrosterassignment tra
			ON tr.RosterID = tra.RosterID
		LEFT OUTER JOIN account a
			ON a.AccountNumber = tr.PlayerAccountNumber
		LEFT OUTER JOIN playerprofile pp
			ON pp.PlayerAccountNumber = tr.PlayerAccountNumber
		LEFT OUTER JOIN position pos
			ON pos.PositionID = tra.PositionID
		WHERE tr.TeamID = {$selectedAcctNum};
SQL;

	$rosterResultSet = $mysqliConnection->query($queryString) or die($mysqliConnection->error);        

	$rosterPlayers = array();
	while($rosterRecord = $rosterResultSet->fetch_array(MYSQLI_ASSOC))
	{
		$rosterPlayers[] = $rosterRecord;
	}
	
	$rosterResultSet->free();

	// Enable/disable recruit button.
	$accountSession = new AccountSession();
	$recruitingParty = null;
	
	if($accountSession->isLoggedIn() && $_SESSION[AccountSession::SESS_ACCT_TYPE_FLD] == 'P')
	{
		$recruitingAccountType = $_SESSION[AccountSession::SESS_ACCT_TYPE_FLD];
		
		$alreadyOnTeam = false;
		$outstandingRequest = false;
		
		// Check if player is already on the team.
		$queryString = <<<SQL
			SELECT PlayerAccountNumber
			FROM teamroster tr
			WHERE PlayerAccountNumber = {$_SESSION[AccountSession::SESS_ACCT_NUM_FLD]}
			AND TeamID = {$selectedAcctNum};
SQL;

		$resultSet = $mysqliConnection->query($queryString);

		if($resultSet && ($resultSet->num_rows > 0))
		{
			// Player is already on team
			$alreadyOnTeam = true;
		}
		else
		{
			// Player is not on the team, but
			// check if player has pending requests to join the team
			// or if team has pending recruitments
			$queryString = <<<SQL
			SELECT PlayerAccountNumber
			FROM recruitmessage rm
			WHERE PlayerAccountNumber = {$_SESSION[AccountSession::SESS_ACCT_NUM_FLD]}
			AND TeamID = {$selectedAcctNum}
			AND rm.MessageStateID = 'U';
SQL;
			$resultSet = $mysqliConnection->query($queryString);
			
			if($resultSet && ($resultSet->num_rows > 0))
			{
				// Player is already on team
				$outstandingRequest = true;
			}
			else
			{
				// Player is not already on team and player has no outstanding requests to the team
				$recruitingParty = $_SESSION[AccountSession::SESS_ACCT_NUM_FLD];
			}
		}
	}
	
	$mysqliConnection->close();
}

$pageSpecificScripts[] = Config::SCRPT_MSG_SND_RECRUIT;
require_once Config::PAGE_GLOBAL;
?>