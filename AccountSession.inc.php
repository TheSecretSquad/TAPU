<?php
/*
** AccountSession.inc.php
** Author: Peter DiSalvo
** Date: 12/14/2012
** Class used for managing the current user session.
*/
require_once 'config.inc.php';
class AccountSession
{
	const SESS_ACCT_NUM_FLD = 'accountNumber';
	const SESS_ACCT_TYPE_FLD = 'accountType';
	
	public function __construct()
	{
		if(!isset($_SESSION))
		{
			session_start();
		}
	}
	
	public function isLoggedIn()
	{
		return !empty($_SESSION[self::SESS_ACCT_NUM_FLD]);
	}
	
	public function endSession()
	{
		unset($_SESSION);
		session_destroy();
	}
	
	public function openProfilePage()
	{
		if(!$this->isLoggedIn())
		{
			header("Location: " . Config::PAGE_LOGIN);
		}
		elseif($_SESSION[self::SESS_ACCT_TYPE_FLD] == 'P')
		{
			header("Location: " . Config::PAGE_PROF_PLAYER . "?" . http_build_query(array(Config::PARAM_PROF_ID => $_SESSION[self::SESS_ACCT_NUM_FLD])));
		}
		elseif($_SESSION[self::SESS_ACCT_TYPE_FLD] == 'M')
		{
			header("Location: " . Config::PAGE_PROF_MAN . "?" . http_build_query(array(Config::PARAM_PROF_ID => $_SESSION[self::SESS_ACCT_NUM_FLD])));
		}
		else
		{
			header("Location: " . Config::PAGE_HOME);
		}
	}
	
	public function authenticate($username, $accountType, $password)
	{
		$mysqliConnection = new mysqli(Config::DB_CONN, Config::DB_USER, Config::DB_PASS, Config::DB_NAME);

		if($mysqliConnection->connect_error)
		{
			die(Config::DB_ERROR_TEXT . $mysqli->connect_error);
		}

		$querystring=<<<sql
		SELECT a.AccountNumber, a.PasswordHash
		FROM account a
		WHERE a.EmailAddress='{$username}'
		AND a.AccountTypeID='{$accountType}';
sql;
		
		$results = $mysqliConnection->query($querystring);
		
		if($results->num_rows > 0)
		{
			$userRecord = $results->fetch_array(MYSQLI_ASSOC);

			if(self::matchPassword($password, $userRecord['PasswordHash']))
			{
				$_SESSION[self::SESS_ACCT_NUM_FLD] = $userRecord['AccountNumber'];
				$_SESSION[self::SESS_ACCT_TYPE_FLD] = $accountType;
				return true;
			}
		}
		
		return false;
	}
	
	private static function matchPassword($inputPassword, $storedHash)
	{
		// The first 64 characters of the hash is the salt.
		$salt = substr($storedHash, 0, 64);

		$hash = $salt . $inputPassword;

		// Hash the password as we did before.
		for ($i = 0; $i < 100000; ++$i)
		{
			$hash = hash('sha256', $hash);
		}

		$hash = $salt . $hash;

		return $hash == $storedHash;
	}
	
	public static function hashPassword($username, $password)
	{
		// Create a 256 bit (64 characters) long random salt.
		// Add random string 'prestige worldwide' and the username
		// to the salt as well for added security.
		$salt = hash('sha256', uniqid(mt_rand(), true) . 'prestige worldwide' . strtolower($username));

		// Prefix the password with the salt.
		$hash = $salt . $password;

		// Hash the salted password a bunch of times.
		for ($i = 0; $i < 100000; ++$i)
		{
			$hash = hash('sha256', $hash);
		}

		// Prefix the hash with the salt so we can find it later.
		return $hash = $salt . $hash;
	}
}

?>