<?php
/*
** login.php
** Author: Peter DiSalvo
** Date: 12/14/2012
** User login process.
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

$username = !empty($_POST ['username']) ? $_POST ['username'] : NULL;
$password = !empty($_POST['password']) ? $_POST['password'] : NULL;
$accountType = !empty($_POST['accountType']) ? $_POST['accountType'] : NULL;
$submitted = !empty($_POST['submitted']) ? $_POST['submitted'] : NULL;

$errorText = '';
if(!empty($submitted))
{	
	if(empty($accountType))
	{
		$errorText = "Please select your account type.";
	}
	// If form was submitted, and username or password is empty
	elseif(empty($username) || empty($password))
	{
		$errorText = "Please enter your username and password.";
	}
	else
	{
		if(!$currentSession->authenticate($username, $accountType, $password))
		{
			$errorText = "Incorrect username or password.";
		}
		else
		{
			$currentSession->openProfilePage();
		}
	}
}

$targetContent = Config::CTMP_LOGIN;
$pageTitle = 'Login';
require_once Config::PAGE_GLOBAL;
?>