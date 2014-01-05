<?php
/*
** playerProfile.php
** Author: Greg Siele, Peter DiSalvo
** Date: 12/14/2012
** Display player profile page.
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
// Get player profile
$queryString =  <<<SQL
	SELECT
		a.FirstName,
		a.LastName,
		g.GenderName,
		pp.ProfilePicturePath,
		pp.City,
		pp.StateAbbreviation,
		YEAR(NOW()) - YEAR(pp.DateOfBirth) AS Age,
		pp.Bio		
	FROM account a
	INNER JOIN playerprofile pp
		ON a.AccountNumber = pp.PlayerAccountNumber
	INNER JOIN gender g
		ON pp.GenderID = g.GenderID
	WHERE a.AccountNumber = {$selectedAcctNum};
SQL;

$playerResultSet = $mysqliConnection->query($queryString) or die($mysqliConnection->error);

if($playerResultSet->num_rows == 0)
{
	$pageTitle = "We could not find the player you were looking for!";
	$targetContent = null;
}
else
{
	// Player exists, get profile data
	$playerRecord = $playerResultSet->fetch_array(MYSQLI_ASSOC);

	$pageTitle = htmlspecialchars($playerRecord['FirstName'] . ' ' . $playerRecord['LastName']);
	$targetContent = Config::CTMP_PROF_PLAYER;
	
	$playerProfilePic = $playerRecord['ProfilePicturePath'];
	$playerGender = $playerRecord['GenderName'];
	$playerAge = $playerRecord['Age'];
	$playerLocation = $playerRecord['City'] . ', ' . $playerRecord['StateAbbreviation'];
	$bio = $playerRecord['Bio'];
	
	$playerResultSet->free();
	
	// Get player positions
	$queryString = <<<SQL
		SELECT	ppp.SportID,
				s.SportName,
				ppp.PositionID,
				pos.PositionName,
				ppp.LookingStatus,
				ppp.SkillLevelID,
				sl.SkillLevelName
        FROM playerprofileposition ppp
        INNER JOIN position pos
			ON ppp.PositionID = pos.PositionID
        INNER JOIN sport s
			ON ppp.SportID = s.SportID
		INNER JOIN skilllevel sl
			ON ppp.SkillLevelID = sl.SkillLevelID
        WHERE ppp.PlayerAccountNumber = {$selectedAcctNum};
SQL;

	$positionsResultSet = $mysqliConnection->query($queryString) or die($mysqliConnection->error);        

	$positions = array();
	while($positionRecord = $positionsResultSet->fetch_array(MYSQLI_ASSOC))
	{
		$positions[] = $positionRecord;
	}
	
	$positionsResultSet->free();
	
	// Get player teams
	$queryString = <<<SQL
		SELECT  tr.TeamID,
				tp.TeamName,
				tp.TeamLogoPath,
				tp.SportID,
				s.SportName
		FROM teamroster tr
		INNER JOIN teamprofile tp
			ON tr.TeamID = tp.TeamID
		INNER JOIN sport s
			ON tp.SportID = s.SportID
		WHERE tr.PlayerAccountNumber = {$selectedAcctNum};
SQL;

	$teamsResultSet = $mysqliConnection->query($queryString) or die($mysqliConnection->error);        

	$teams = array();
	while($teamRecord = $teamsResultSet->fetch_array(MYSQLI_ASSOC))
	{
		if(empty($teamRecord['TeamLogoPath']))
		{
			$teamRecord['TeamLogoPath'] = Config::IMG_PROF_DEFAULT;
		}
		$teams[] = $teamRecord;
	}
	
	$teamsResultSet->free();

	// Enable/disable recruit button
	$accountSession = new AccountSession();
	$recruitingParty = null; // Account number of user looking to recruit/join
	
	if($accountSession->isLoggedIn() && $_SESSION[AccountSession::SESS_ACCT_TYPE_FLD] == 'M')
	{
		$recruitingAccountType = $_SESSION[AccountSession::SESS_ACCT_TYPE_FLD];
		
		$alreadyOnTeam = false;
		$outstandingRequest = false;
		
		// Check if player is already on the team.
		$queryString = <<<SQL
			SELECT PlayerAccountNumber
			FROM teamroster tr
			WHERE PlayerAccountNumber = {$selectedAcctNum}
			AND TeamID = {$_SESSION[AccountSession::SESS_ACCT_NUM_FLD]};
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
			WHERE PlayerAccountNumber = {$selectedAcctNum}
			AND TeamID = {$_SESSION[AccountSession::SESS_ACCT_NUM_FLD]}
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
				// Set recruiting party to logged in user who is viewing the profile
				$recruitingParty = $_SESSION[AccountSession::SESS_ACCT_NUM_FLD];
			}
		}
	}
	
	$mysqliConnection->close();
}
$pageSpecificScripts[] = Config::SCRPT_MSG_SND_RECRUIT;
require_once Config::PAGE_GLOBAL;
?>