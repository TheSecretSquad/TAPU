<?php
if(empty($allowRecruit))
{
	$allowRecruit = false;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php if(!empty($pageTitle)){ echo 'TAPU! ' . $pageTitle;} else { echo 'TAPU!';} ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" href="<?php echo Config::CSS_RESET; ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo Config::CSS_GLOBAL; ?>" />
		<link rel="stylesheet" type="text/css" href="<?php echo Config::CSS_JQUERY_UI; ?>" />
		<script type="text/javascript" src="<?php echo Config::SCRPT_GLOBAL; ?>"></script> 
		<script type="text/javascript" src="<?php echo Config::SCRPT_JQUERY; ?>"></script>
		<script type="text/javascript" src="<?php echo Config::SCRPT_JQUERY_UI; ?>"></script>
		<script type="text/javascript" src="<?php echo Config::SCRPT_MSG_BOX; ?>"></script>
		<?php
		if(!empty($pageSpecificScripts)):
		foreach($pageSpecificScripts as $script) : ?>
		<script type="text/javascript" src="<?php echo $script ?>"></script>
		<?php endforeach; ?>
		<?php endif; ?>
	</head>
	<body class="darkBackgroundPattern">
		<div id="bodyContentWrap">
			<div id="topContentWrap" class="fullWideContentWrapper darkBackgroundPattern">
				<div id="pageHeader" class="mainContentDimension autoCentered">
					<a href="<?php echo Config::PAGE_HOME; ?>" id="logo" class="sportText">TAPU<span class="museoTextBold exclamationPoint">!</span></a>
					<div id="topUserEntryLinks" class="pipeSeparatedSetRTL">
						<a href="<?php echo $topUserEntryLinks['xAccountUrl']; ?>" class="pipeSeparatedSetItem"><?php echo $topUserEntryLinks['xAccountText']; ?></a>
						<a href="<?php echo $topUserEntryLinks['LogxUrl']; ?>" class="pipeSeparatedSetItem"><?php echo $topUserEntryLinks['LogxText']; ?></a>
					</div>
				</div>
				<div class="chalkDashLine"></div>
				<nav id="mainNavigation" class="mainContentDimension autoCentered mainNav">
					<ul>
						<li class="mainNavItem"><a href="<?php echo Config::PAGE_SEARCH_PLAYER . '#pageTitle'; ?>" class="sportText mainNavLink specialNavLink roundedCorners">Players</a></li>
						<li class="mainNavItem"><a href="<?php echo Config::PAGE_SEARCH_TEAM . '#pageTitle'; ?>" class="sportText mainNavLink specialNavLink roundedCorners">Teams</a></li>
					</ul>
				</nav>
			</div>
			<!-- Begin Bottom Content -->
			<div id="bottomContentWrap" class="fullWideContentWrapper darkBackgroundPattern lightSeparatorBorder preFooterContent">
			<?php if(!empty($pageTitle)): ?>
			<h1 id="pageTitle" class="mainContentDimension autoCentered museoTextBold"><?php echo htmlspecialchars($pageTitle); ?></h1>
			<?php endif; ?>
				<div id="bottomContentContainer" class="mainContentDimension autoCentered">
					<?php
					if(!empty($targetContent))
					{
						require_once $targetContent;
					}
					?>
				</div>
			</div>
			<!-- End Bottom Content Wrap -->
			<div id="footerWrap" class="fullWideContentWrapper lightSeparatorBorder darkBackground">
				<div class="mainContentDimension autoCentered">
					<p>Teams and Players Unite! &copy; 2012</p>
				</div>
			</div>			
			<?php $currentSession = new AccountSession();
			if($currentSession->isLoggedIn() == true) : ?>
			<div id="messageBox" class="messageBox messageBoxContainer">
				<div class="messageBoxHeading museoTextBold">Messages</div>
				<ul id="messageList" class="messageList">
				<?php require_once 'messageBox.inc.php'; ?>
				</ul>
			</div>
			<?php endif; ?>
			<?php
			if(!empty($recruitingParty))
			{
				require_once 'recruitMessageBox.inc.php';
			}
			?>
		</div>
	</body>
</html>