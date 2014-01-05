<?php
/*
** config.inc.php
** Author: Peter DiSalvo
** Date: 12/14/2012
** Global configuration constants.
*/
class Config
{
	// Database
	const DB_CONN = 'localhost';
	const DB_USER = 'root';
	const DB_PASS = 'Bo@t5nHo3s';
	const DB_NAME = 'tapu';
	const DB_ERROR_TEXT = 'Error connecting to database.';
	
	// Directories
	
	const DIR_IMG_SITE = 'images/';
	const DIR_IMG_UPLOAD = 'upload/';
	
	// Images
	const IMG_PROF_DEFAULT = 'images/gookie.png';
	
	// Pages
	const PAGE_GLOBAL = 'global.inc.php';
	const PAGE_HOME = 'index.php';
	const PAGE_LOGIN = 'login.php';
	const PAGE_LOGOUT = 'logout.php';
	const PAGE_CREATE_ACCT = 'createAccount.php';
	const PAGE_PROF_PLAYER = 'playerProfile.php';
	const PAGE_PROF_TEAM = 'teamProfile.php';
	const PAGE_PROF_MAN = 'managerProfile.php';
	const PAGE_PROF_EDIT_PLAYER = 'editPlayerProfile.php';
	const PAGE_PROF_EDIT_MAN = 'editManagerProfile.php';
	const PAGE_PROF_ADD_TEAM = 'addTeam.php';
	const PAGE_SEARCH_PLAYER = 'playerSearch.php';
	const PAGE_SEARCH_TEAM = 'teamSearch.php';
	
	// Content templates
	const CTMP_GLOBAL = 'contentTemplates/content_global.inc.php';
	const CTMP_HOME = 'contentTemplates/content_index.inc.php';
	const CTMP_CREATE_ACCT = 'contentTemplates/content_createAccount.inc.php';
	const CTMP_LOGIN = 'contentTemplates/content_login.inc.php';
	const CTMP_LOGOUT = 'contentTemplates/content_logout.inc.php';
	const CTMP_PROF_PLAYER = 'contentTemplates/content_playerProfile.inc.php';
	const CTMP_PROF_TEAM = 'contentTemplates/content_teamProfile.inc.php';
	const CTMP_PROF_MAN = 'contentTemplates/content_managerProfile.inc.php';
	const CTMP_PROF_EDIT_PLAYER = 'contentTemplates/content_editPlayerProfile.inc.php';
	const CTMP_PROF_EDIT_MAN = 'contentTemplates/content_editManagerProfile.inc.php';
	const CTMP_PROF_ADD_TEAM = 'contentTemplates/content_addTeam.inc.php';
	const CTMP_SEARCH_PLAYER = 'contentTemplates/content_playerSearch.inc.php';
	const CTMP_QRY_PLAYER = 'contentTemplates/content_playerQuery.inc.php';
	const CTMP_SEARCH_TEAM = 'contentTemplates/content_teamSearch.inc.php';
	const CTMP_QRY_TEAM = 'contentTemplates/content_teamQuery.inc.php';
	const CTMP_OPT_POSITIONS = 'contentTemplates/content_positionOptions.inc.php';
	const CTMP_OPT_POSITIONS_CHECK = 'contentTemplates/content_positionOptionsCheck.inc.php';
	const CTMP_MSG = 'contentTemplates/content_messages.inc.php';
	const CTMP_MSG_SND_RECRUIT = 'contentTemplates/content_sendRecruitMessageBox.inc.php';
	
	// CSS
	const CSS_RESET = 'styles/reset.css';
	const CSS_GLOBAL = 'styles/styles.css';
	const CSS_JQUERY_UI = 'styles/jquery-ui-1.9.2.custom.min.css';
	
	// Parameters
	const PARAM_PROF_ID = 'pID'; // Http query string parameter for profile pages.
	const PARAM_MSG_ID = 'msgID';
	const PARAM_MSG_ACT = 'msgAction';
	
	// Scripts
	const SCRPT_GLOBAL = 'scripts/global.js';
	const SCRPT_CREATE_ACCT = 'scripts/createAccount.js';
	const SCRPT_EDIT_ACCT = 'scripts/editAccount.js';
	const SCRPT_ADD_TEAM = 'scripts/addTeam.js';
	const SCRPT_JQUERY = 'scripts/jquery-1.8.3.js';
	const SCRPT_JQUERY_UI = 'scripts/jquery-ui-1.9.2.custom.min.js';
	const SCRPT_MSG_BOX = 'scripts/messageBox.js';
	const SCRPT_MSG_SND_RECRUIT = 'scripts/sendRecruitMessage.js';
	const SCRPT_SEARCH_PLAYER = 'scripts/playerSearch.js';
	const SCRPT_SEARCH_GLOBAL = 'scripts/search.js';
	const SCRPT_SEARCH_TEAM = 'scripts/teamSearch.js';
}
?>