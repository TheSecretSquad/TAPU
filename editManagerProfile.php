<?
/*
** editManagerProfile.php
** Author: Peter DiSalvo
** Date: 12/16/2012
** Display the manager profile edit page.
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

$firstName = !empty($_POST['firstName']) ? $_POST['firstName'] : NULL; // Required
$lastName = !empty($_POST['lastName']) ? $_POST['lastName'] : NULL; // Required
$password = !empty($_POST['password']) ? $_POST['password'] : NULL; // Required
$email = !empty($_POST['email']) ? $_POST['email'] : NULL; // Required
$emailConfirm = !empty($_POST['emailConfirm']) ? $_POST['emailConfirm'] : NULL;
$submitted = !empty($_POST['submitted']) ? $_POST['submitted'] : NULL;

$errorText = '';
$formMessageText = '';
if(!empty($submitted))
{
	// Open database connection
	$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);	
	// Get current values
	$stmt = $mysqliConnection->prepare(<<<SQL
		SELECT	a.FirstName,
				a.LastName,
				a.PasswordHash,
				a.EmailAddress
		FROM account a
		WHERE a.AccountNumber = ?;
SQL
);

	$stmt->bind_param('i', $_SESSION[AccountSession::SESS_ACCT_NUM_FLD]);

	$stmt->execute();

	$stmt->bind_result($dbFirstName, $dbLastName, $dbPasswordHash, $dbEmail);

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
		SET	a.FirstName = COALESCE(?, ?),
			a.LastName = COALESCE(?, ?),
			a.EmailAddress = COALESCE(?, ?),
			a.PasswordHash = COALESCE(?, ?)
		WHERE a.AccountNumber = ?;
SQL
);

	$stmt->bind_param('ssssssssi',
								$firstName, $dbFirstName,
								$lastName, $dbLastName,
								$email, $dbEmail,
								$passwordHash, $dbPasswordHash,
								$_SESSION[AccountSession::SESS_ACCT_NUM_FLD]);
	if($stmt->execute())
	{
		$formMessageText = "Information saved.";
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
			a.EmailAddress
	FROM account a
	WHERE a.AccountNumber = {$_SESSION[AccountSession::SESS_ACCT_NUM_FLD]};
SQL;

$managerResultSet = $mysqliConnection->query($queryString);

$manager = $managerResultSet->fetch_array(MYSQLI_ASSOC);
$managerResultSet->free();

$mysqliConnection->close();

$targetContent = Config::CTMP_PROF_EDIT_MAN;
$pageTitle = 'Edit Account';
$pageSpecificScripts[] = Config::SCRPT_EDIT_ACCT;
require_once Config::PAGE_GLOBAL;
?>