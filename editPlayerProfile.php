<?php
/*
** editPlayerProfile.php
** Author: Peter DiSalvo
** Date: 12/17/2012
** Display the player profile edit page.
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
$profilePicFile = !empty($_FILES['profilePic']) ? $_FILES['profilePic'] : NULL;
$bio = !empty($_POST['bio']) ? $_POST['bio'] : NULL; // Required
$firstName = !empty($_POST['firstName']) ? $_POST['firstName'] : NULL; // Required
$lastName = !empty($_POST['lastName']) ? $_POST['lastName'] : NULL; // Required
$password = !empty($_POST['password']) ? $_POST['password'] : NULL; // Required
$passwordConfirm = !empty($_POST['passwordConfirm']) ? $_POST['passwordConfirm'] : NULL; // Required
$email = !empty($_POST['email']) ? $_POST['email'] : NULL; // Required
$emailConfirm = !empty($_POST['emailConfirm']) ? $_POST['emailConfirm'] : NULL;
$city = !empty($_POST['city']) ? $_POST['city'] : NULL; // Required
$selectedState = !empty($_POST['state']) ? $_POST['state'] : NULL; // Required
$zipCode = !empty($_POST['zipCode']) ? $_POST['zipCode'] : NULL;
$dateOfBirth = !empty($_POST['dateOfBirth']) ? date("Y-m-d", strtotime($_POST['dateOfBirth'])) : NULL; // Required
$gender = !empty($_POST['gender']) ? $_POST['gender'] : NULL; // Required for player
$submitted = !empty($_POST['submitted']) ? $_POST['submitted'] : NULL;

if(empty($emailConfirm))
{
	$email = NULL;
}

if(empty($passwordConfirm))
{
	$password = NULL;
}

$errorText = '';
$formMessageText = '';
if(!empty($submitted))
{
	$selectedSport = !empty($_POST['sport']) || $_POST['sport'] == '--' ? $_POST['sport'] : NULL;
	$selectedPositions = !empty($_POST['positions']) ? $_POST['positions'] : NULL;
	
	// Check uploaded image
	$profilePicPath = NULL;
	if(file_exists($profilePicFile['tmp_name']))
	{
		switch($profilePicFile['type'])
		{
			case 'image/jpeg':
			case 'image/png':
			case 'image/pjpeg':
				$fileNameExt = explode('.', $profilePicFile['name']);
				$extension = end($fileNameExt);
				if(in_array(strtolower($extension), $allowedExts) && $profilePicFile['size'] < $allowedFileSize)
				{
					$profilePicPath = 'profilePic_' . $_SESSION[AccountSession::SESS_ACCT_NUM_FLD] . '.' . $extension;
					move_uploaded_file($profilePicFile['tmp_name'], 'upload/' . $profilePicPath);
				}
				break;
			default:
				$errorText = 'Invalid file format.';
				break;
		}
	}

	// Open database connection
	$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);

	if(!empty($selectedPositions))
	{
		// Save positions
		$savePositionStmt = $mysqliConnection->prepare(<<<SQL
			INSERT INTO playerprofileposition (PlayerAccountNumber, SportID, PositionID, SkillLevelID, LookingStatus)
			VALUES(?, ?, ?, ?, ?)
			ON DUPLICATE KEY UPDATE SportID=VALUES(SportID),
									PositionID=VALUES(PositionID),
									SkillLevelID=VALUES(SkillLevelID),
									LookingStatus=VALUES(LookingStatus);
SQL
	);
		$savePositionStmt->bind_param('iiiii', 	$_SESSION[AccountSession::SESS_ACCT_NUM_FLD],
									$selectedSport,
									$dbPositionID,
									$dbSkillLevelID,
									$dbLookingStatus);
									
			$removePositionStmt = $mysqliConnection->prepare(<<<SQL
			DELETE FROM playerprofileposition
			WHERE PlayerAccountNumber = ? AND SportID = ? AND PositionID = ?;
SQL
	);
		$removePositionStmt->bind_param('iii', 	$_SESSION[AccountSession::SESS_ACCT_NUM_FLD],
									$selectedSport,
									$dbPositionID);
									
		foreach($selectedPositions as $positionID => $values)
		{
			$dbPositionID = $positionID;
			$dbSkillLevelID = $values['skillLevel'] == '--' ? NULL : $values['skillLevel'];
			$dbLookingStatus = !empty($values['lookingStatus']) ? $values['lookingStatus'] : false;
			
			if(!empty($dbSkillLevelID))
			{
				$savePositionStmt->execute() or die($mysqliConnection->error);
			}
			else
			{
				$removePositionStmt->execute() or die($mysqliConnection->error);
			}
		}
	}	
	
	// Get current values
	$stmt = $mysqliConnection->prepare(<<<SQL
		SELECT	a.FirstName,
				a.LastName,
				a.PasswordHash,
				a.EmailAddress,
				pp.ProfilePicturePath,
				pp.Bio,
				pp.City,
				pp.StateAbbreviation,
				pp.ZipCode,
				pp.DateOfBirth,
				pp.GenderID
		FROM account a
		INNER JOIN playerprofile pp
			ON a.AccountNumber = pp.PlayerAccountNumber
		WHERE a.AccountNumber = ?;
SQL
);

	$stmt->bind_param('i', $_SESSION[AccountSession::SESS_ACCT_NUM_FLD]);

	if($stmt->execute())
	{
		$formMessageText = 'Information saved.';
	}
	else
	{
		$errorText = "There was a problem saving.";
	}

	$stmt->bind_result($dbFirstName, $dbLastName, $dbPasswordHash, $dbEmail, $dbProfilePicPath, $dbBio,
					$dbCity, $dbStateAbbreviation, $dbZipCode, $dbDateOfBirth, $dbGender);

	$stmt->fetch();
	$stmt->close();
	
	// If user changed password, then check if they also submitted
	// a new email address and hash a new password using the new email
	// address, otherwise hash the new password with the old email address
	$passwordHash = null;
	if(!is_null($password))
	{
		$username = !empty($emailConfirm) ? $email : $dbEmail;
		$passwordHash = AccountSession::hashPassword($username, $password);
	}
	// passwordHash will be null if it was not submitted

	// Query ensures records are not corrupted by inserting the old
	// value if the submitted value is null.
	$stmt = $mysqliConnection->prepare(<<<SQL
		UPDATE account a
		INNER JOIN playerprofile pp
			ON a.AccountNumber = pp.PlayerAccountNumber
		SET	a.FirstName = COALESCE(?, ?),
			a.LastName = COALESCE(?, ?),
			a.EmailAddress = COALESCE(?, ?),
			a.PasswordHash = COALESCE(?, ?),
			pp.ProfilePicturePath = COALESCE(?, ?),
			pp.Bio = COALESCE(?, ?),
			pp.DateOfBirth = COALESCE(?, ?),
			pp.GenderID = COALESCE(?, ?),
			pp.City = COALESCE(?, ?),
			pp.StateAbbreviation = COALESCE(?, ?),
			pp.ZipCode = COALESCE(?, ?)
		WHERE a.AccountNumber = ?;
SQL
);

	$stmt->bind_param('ssssssssssssssssssssssi',
								$firstName, $dbFirstName,
								$lastName, $dbLastName,
								$email, $dbEmail,
								$passwordHash, $dbPasswordHash,
								$profilePicPath, $dbProfilePicPath,
								$bio, $dbBio,
								$dateOfBirth, $dbDateOfBirth,
								$gender, $dbGender,
								$city, $dbCity,
								$selectedState, $dbStateAbbreviation,
								$zipCode, $dbZipCode,
								$_SESSION[AccountSession::SESS_ACCT_NUM_FLD]);
	if($stmt->execute())
	{
		$formMessageText = 'Information saved.';
	}
	else
	{
		$errorText = "There was a problem saving.";
	}

	$stmt->close();
	
	$mysqliConnection->close();
}

// Open database connection
$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
	
if (mysqli_connect_error())
{
	die(Config::DB_ERROR_TEXT . mysqli_connect_errno() . ' ' . mysqli_connect_error());
}

// Get player data
$queryString = <<<SQL
	SELECT	a.FirstName,
			a.LastName,
			a.PasswordHash,
			a.EmailAddress,
			pp.Bio,
			pp.City,
			pp.StateAbbreviation,
			pp.ZipCode,
			pp.DateOfBirth,
			pp.GenderID
	FROM account a
	INNER JOIN playerprofile pp
		ON a.AccountNumber = pp.PlayerAccountNumber
	WHERE a.AccountNumber = {$_SESSION[AccountSession::SESS_ACCT_NUM_FLD]};
SQL;

$playerResultSet = $mysqliConnection->query($queryString);

$player = $playerResultSet->fetch_array(MYSQLI_ASSOC);
$playerResultSet->free();
// Load States dropdown
$queryString = 'SELECT StateAbbreviation, StateName FROM states;';

$statesResultSet = $mysqliConnection->query($queryString);

$states = array();
while($stateRecord = $statesResultSet->fetch_array(MYSQLI_ASSOC))
{
	$states[] = $stateRecord;
}

$statesResultSet->free();


// Get sport dropdown for editing positions
$queryString = <<<SQL
	SELECT	s.SportID,
			s.SportName
	FROM sport s;
SQL;

$sportsResultSet = $mysqliConnection->query($queryString);
$sports = array();
while($sport = $sportsResultSet->fetch_array(MYSQLI_ASSOC))
{
	$sports[] = $sport;
}

$sportsResultSet->free();

$mysqliConnection->close();

$targetContent = Config::CTMP_PROF_EDIT_PLAYER;
$pageTitle = 'Edit Profile';
$pageSpecificScripts[] = Config::SCRPT_EDIT_ACCT;
require_once Config::PAGE_GLOBAL;
?>