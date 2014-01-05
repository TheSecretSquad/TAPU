<?php
/*
playerProfile.php
Authors: Gerard Packard, Peter DiSalvo
Date: 12/14/2012
*/
require_once 'config.inc.php';
require_once 'AccountSession.inc.php';

$currentSession = new AccountSession();

// Is user already logged in?
if($currentSession->isLoggedIn())
{
	// User is logged in, bypass login screen and go to profile.
	$currentSession->openProfilePage();
	exit;
}

$firstName = !empty($_POST['firstName']) ? $_POST['firstName'] : NULL; // Required
$lastName = !empty($_POST['lastName']) ? $_POST['lastName'] : NULL; // Required
$password = !empty($_POST['password']) ? $_POST['password'] : NULL; // Required
$email = !empty($_POST['email']) ? $_POST['email'] : NULL; // Required
$city = !empty($_POST['city']) ? $_POST['city'] : NULL; // Required
$selectedState = !empty($_POST['state']) ? $_POST['state'] : NULL; // Required
$zipCode = !empty($_POST['zipCode']) ? $_POST['zipCode'] : NULL;
$dateOfBirth = !empty($_POST['dateOfBirth']) ? date("Y-m-d", strtotime($_POST['dateOfBirth'])) : NULL; // Required
$gender = !empty($_POST['gender']) ? $_POST['gender'] : NULL; // Required for player
$accountType = !empty($_POST['accountType']) ? $_POST['accountType'] : NULL;
$submitted = !empty($_POST['submitted']) ? $_POST['submitted'] : NULL;

$errorText = '';
if(!empty($submitted))
{
	// Open database connection
	$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
	
	$emailDB = !is_null($email) ? $email : "NULL";
	$accountTypeDB = !is_null($accountType) ? $accountType : "NULL";
	
	// Test if account already exists
	$queryString =<<<SQL
	SELECT AccountNumber FROM account a WHERE a.EmailAddress = '{$emailDB}' AND a.AccountTypeID = '{$accountTypeDB}';
SQL;
	
	$accountResult = $mysqliConnection->query($queryString);
	if($accountResult->num_rows > 0)
	{
		$errorText = "Account already exists.";
	}
	else
	{
		// Account does not exist, create new account
		$passwordHash = $currentSession->hashPassword($email, $password);
		
		$firstName = !is_null($firstName) ? $firstName : "NULL";
		$lastName = !is_null($lastName) ? $lastName : "NULL";

		$queryString=<<<SQL
		INSERT INTO account (FirstName, LastName, EmailAddress, PasswordHash, AccountTypeID)
		VALUES ('{$firstName}', '{$lastName}','{$email}', '{$passwordHash}', '{$accountTypeDB}');
			
SQL;

		$mysqliConnection->query($queryString);
		$lastInsertID = $mysqliConnection->insert_id;
		
		// If it is a player account, create a player profile
		if($accountType == 'P')
		{			
			$stmt = $mysqliConnection->prepare(<<<SQL
				INSERT INTO playerprofile (PlayerAccountNumber, DateOfBirth, GenderID, City, StateAbbreviation, ZipCode, AccountTypeID)
				VALUES(?, ?, ?, ?, ?, ?, ?);
SQL
);
			$stmt->bind_param('issssss', $lastInsertID, $dateOfBirth, $gender, $city, $selectedState, $zipCode, $accountType);
			
			$stmt->execute();
			
			$stmt->close();
		}
		
		$mysqliConnection->close();
		
		// Log user in
		$_SESSION[AccountSession::SESS_ACCT_NUM_FLD] = $lastInsertID;
		$_SESSION[AccountSession::SESS_ACCT_TYPE_FLD] = $accountType;
		
		$currentSession->openProfilePage();
	}
}

// Open database connection
$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);
	
if (mysqli_connect_error())
{
	die(Config::DB_ERROR_TEXT . mysqli_connect_errno() . ' ' . mysqli_connect_error());
}

// Load States dropdown
$queryString = "SELECT StateAbbreviation, StateName FROM states;";

$statesResultSet = $mysqliConnection->query($queryString);

$states = array();
while($stateRecord = $statesResultSet->fetch_array(MYSQLI_ASSOC))
{
	$states[] = $stateRecord;
}

$statesResultSet->free();
$mysqliConnection->close();

$targetContent = Config::CTMP_CREATE_ACCT;
$pageTitle = 'Create Account';
$pageSpecificScripts[] = Config::SCRPT_CREATE_ACCT;

require_once Config::PAGE_GLOBAL;
?>