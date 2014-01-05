<?php
/*
** addTeam.php
** Author: Peter DiSalvo
** Date: 12/17/2012
** Display the add team page for team managers.
*/
require_once 'config.inc.php';
require_once 'AccountSession.inc.php';

$currentSession = new AccountSession();

// Is user already logged in?
if(!$currentSession->isLoggedIn())
{
	// User is not logged in, go to login screen
	header('Location:' . Config::PAGE_LOGIN);
	exit;
}

$allowedExts = array('jpg', 'jpeg', 'gif', 'png');
$allowedFileSize = 500000;
$teamLogoFile = !empty($_FILES['teamLogoFile']) ? $_FILES['teamLogoFile'] : NULL;
$teamName = !empty($_POST['teamName']) ? $_POST['teamName'] : NULL; // Required
$skillLevel = !empty($_POST['skillLevel']) ? $_POST['skillLevel'] : NULL; // Required
$bio = !empty($_POST['bio']) ? $_POST['bio'] : NULL;
$ageMin = !empty($_POST['ageMin']) ? $_POST['ageMin'] : NULL;
$ageMax = !empty($_POST['ageMax']) ? $_POST['ageMax'] : NULL;
$seasonStartDate = !empty($_POST['seasonStartDate']) ? date("Y-m-d", strtotime($_POST['seasonStartDate'])) : NULL;
$seasonEndDate = !empty($_POST['seasonEndDate']) ? date("Y-m-d", strtotime($_POST['seasonEndDate'])) : NULL;
$leagueDuesAmt = !empty($_POST['leagueDuesAmt']) ? $_POST['leagueDuesAmt'] : NULL;
$hasTryouts = !empty($_POST['hasTryouts']) ? $_POST['hasTryouts'] : NULL;
$leagueName = !empty($_POST['leagueName']) ? $_POST['leagueName'] : NULL;
$city = !empty($_POST['city']) ? $_POST['city'] : NULL; // Required
$state = !empty($_POST['state']) ? $_POST['state'] : NULL; // Required
$zipCode = !empty($_POST['zipCode']) ? $_POST['zipCode'] : NULL;
$sport = !empty($_POST['sport']) ? $_POST['sport'] : NULL; // Required
$gender = !empty($_POST['gender']) ? $_POST['gender'] : NULL; // Required
$submitted = !empty($_POST['submitted']) ? $_POST['submitted'] : NULL;

$errorText = '';
$formMessageText = '';
if(!empty($submitted))
{
	// Open database connection
	$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
	
	$stmt = $mysqliConnection->prepare(<<<SQL
		INSERT INTO teamprofile (TeamManagerAccountNumber, TeamName, SportID, Bio, 
								SkillLevelID, AgeMinimum, AgeMaximum, SeasonStartDate, SeasonEndDate,
								TryoutRequired, LeagueName, LeagueDuesAmountPerPlayer, City,
								StateAbbreviation, ZipCode)
		VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, COALESCE(?, FALSE), ?, ?, ?, ?, ?);
SQL
);

	$stmt->bind_param('isisiiissisisss',
								$_SESSION[AccountSession::SESS_ACCT_NUM_FLD],
								$teamName,
								$sport,
								$bio,
								$skillLevel,
								$ageMin,
								$ageMax,
								$seasonStartDate,
								$seasonEndDate,
								$hasTryouts,
								$leagueName,
								$leagueDuesAmt,
								$city,
								$state,
								$zipCode);
								
								
	if($stmt->execute() or die($mysqliConnection->error))
	{
		$formMessageText = "Information saved.";
	}
	else
	{
		$errorText = "There was a problem saving.";
	}

	$lastInsertID = $stmt->insert_id;
	$stmt->close();
	
	$stmt = $mysqliConnection->prepare(<<<SQL
	INSERT INTO teamgender (TeamID, GenderID)
	VALUES(?, ?);
SQL
);

	if($gender == 'C')
	{
		$realGender = 'F';
		
		$stmt->bind_param('is', $lastInsertID, $realGender);
		$realGender = 'M';
		$stmt->execute();
	}
	else
	{
		$stmt->bind_param('is', $lastInsertID, $gender);
		$stmt->execute();
	}

	// Check uploaded image
	$teamLogoPath = NULL;

	if(file_exists($teamLogoFile['tmp_name']))
	{
		switch($teamLogoFile['type'])
		{
			case 'image/jpeg':
			case 'image/png':
			case 'image/pjpeg':
				$fileNameExt = explode('.', $teamLogoFile['name']);
				$extension = end($fileNameExt);
				if(in_array(strtolower($extension), $allowedExts) && $teamLogoFile['size'] < $allowedFileSize)
				{
					$teamLogoPath = 'teamLogo_' . $_SESSION[AccountSession::SESS_ACCT_NUM_FLD] . '_' . $lastInsertID . '.' . $extension;
					move_uploaded_file($teamLogoFile['tmp_name'], Config::DIR_IMG_UPLOAD . $teamLogoPath);
				}
				break;
			default:
				$errorText = 'Invalid file format.';
				break;
		}
	}
	
	$stmt = $mysqliConnection->prepare(<<<SQL
		UPDATE teamprofile SET TeamLogoPath = ?
		WHERE TeamID = ?;
SQL
);
	$stmt->bind_param('si', $teamLogoPath, $lastInsertID);

	if($stmt->execute())
	{
		$formMessageText = "Information saved.";
	}
	else
	{
		$errorText = "There was a problem saving.";
	}
	
	$mysqliConnection->close();
}

// Open database connection
$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);

$queryString = <<<SQL
	SELECT 	sl.SkillLevelID,
			sl.SkillLevelName
	FROM skilllevel sl
	ORDER BY sl.SkillLevelID;
SQL;

$skillLevelResultSet = $mysqliConnection->query($queryString);

$skillLevels = array();
while($skillLevel = $skillLevelResultSet->fetch_array(MYSQLI_ASSOC))
{
	$skillLevels[] = $skillLevel;
}

$queryString = <<<SQL
	SELECT 	g.GenderID,
			g.GenderName
	FROM gender g;
SQL;

$genderResultSet = $mysqliConnection->query($queryString);

$genders = array();
while($gender = $genderResultSet->fetch_array(MYSQLI_ASSOC))
{
	$genders[] = $gender;
}

$queryString = <<<SQL
	SELECT 	s.StateAbbreviation,
			s.StateName
	FROM states s;
SQL;

$statesResultSet = $mysqliConnection->query($queryString);

$states = array();
while($state = $statesResultSet->fetch_array(MYSQLI_ASSOC))
{
	$states[] = $state;
}

$queryString = <<<SQL
	SELECT 	sp.SportID,
			sp.SportName
	FROM sport sp;
SQL;

$sportsResultSet = $mysqliConnection->query($queryString);

$sports = array();
while($sport = $sportsResultSet->fetch_array(MYSQLI_ASSOC))
{
	$sports[] = $sport;
}

$targetContent = Config::CTMP_PROF_ADD_TEAM;
$pageTitle = 'Create Team';
$pageSpecificScripts[] = Config::SCRPT_ADD_TEAM;
require_once Config::PAGE_GLOBAL;
?>