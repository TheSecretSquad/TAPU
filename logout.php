<?php
/*
** logout.php
** Author: Peter DiSalvo
** Date: 12/14/2012
** Logout the logged in user.
*/
require_once 'config.inc.php';
require_once 'AccountSession.inc.php';

$currentSession = new AccountSession();

// Is user already logged in?
if($currentSession->isLoggedIn())
{
	$currentSession->endSession();
	
	$targetContent = Config::CTMP_LOGOUT;
	
	require_once Config::PAGE_GLOBAL;
}
else
{
	header("Location: " . Config::PAGE_LOGIN);
}
?>