<?php
/*
** global.inc.php
** Author: Peter DiSalvo
** Date: 12/14/2012
** Creates page elements that exist for all users, like the login and account links.
*/
require_once 'config.inc.php';
require_once 'AccountSession.inc.php'; 

$currentSession = new AccountSession();

$topUserEntryLinks = array();

if($currentSession->isLoggedIn())
{
	// Logx means Login/Logout
	// xAccount means Create Account/My Account
	$topUserEntryLinks['LogxText'] = 'Logout';
	$topUserEntryLinks['LogxUrl'] = Config::PAGE_LOGOUT;
	$topUserEntryLinks['xAccountText'] = 'My Account';
	
	$httpQuery = http_build_query(array(Config::PARAM_PROF_ID => $_SESSION[AccountSession::SESS_ACCT_NUM_FLD]));

	if($_SESSION[AccountSession::SESS_ACCT_TYPE_FLD] == 'P')
	{
		$topUserEntryLinks['xAccountUrl'] = Config::PAGE_PROF_PLAYER . "?" . $httpQuery;
	}
	elseif($_SESSION[AccountSession::SESS_ACCT_TYPE_FLD] == 'M')
	{
		$topUserEntryLinks['xAccountUrl'] = Config::PAGE_PROF_MAN . "?" . $httpQuery;
	}
}
else
{
	$topUserEntryLinks['LogxText'] = 'Login';
	$topUserEntryLinks['LogxUrl'] = Config::PAGE_LOGIN;
	$topUserEntryLinks['xAccountText'] = 'Create Account';
	$topUserEntryLinks['xAccountUrl'] = Config::PAGE_CREATE_ACCT;
}

require_once Config::CTMP_GLOBAL;
?>

