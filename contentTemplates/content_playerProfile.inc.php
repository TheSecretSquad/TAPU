<div class="profileContent">
	<div class="profileBox bioProfileBox">
	<?php
		$currentAccount = new AccountSession();
		if(!empty($_SESSION[AccountSession::SESS_ACCT_NUM_FLD]) &&  $_SESSION[AccountSession::SESS_ACCT_NUM_FLD] == $selectedAcctNum): ?>
		<a href="editPlayerProfile.php">Edit Profile</a>
	<?php endif; ?>
		<img class="profilePicture profilePicLarge" src="<?php echo !empty($playerProfilePic) ? Config::DIR_IMG_UPLOAD . $playerProfilePic : Config::IMG_PROF_DEFAULT; ?>" alt="Profile picture" />
		<div class="playerData">
		<?php if(!empty($alreadyOnTeam) && $alreadyOnTeam == true): ?>
			<p>You are on this team.</p>
		<?php elseif(!empty($outstandingRequest) && $outstandingRequest == true): ?>
			<p>Recruitment pending.</p>
		<?php elseif(!empty($recruitingParty)) : ?>
		<div class="teamManagerCommandBox">
			<a href="#" id="recruitMessageButton" class="teamManagerCommand teamManagerCommandText">Recruit</a>
		</div>
		<?php endif; ?>
		<table class="profilesTable">
			<col class="profilesFirstColWidthVer" />
			<tbody>
				<tr>
					<th>Gender:</th>
					<td><?php echo htmlspecialchars($playerGender); ?></td>
				</tr>
				<tr>
					<th>Age:</th>
					<td><?php echo htmlspecialchars($playerAge); ?></td>
				</tr>
				<tr>
					<th>Location:</th>
					<td><?php echo htmlspecialchars($playerLocation); ?></td>
				</tr>
			</tbody>
		</table>
		</div>
		<div class="bio">
		<?php if(!empty($bio)) : ?>
			<h2 class="museoTextBold">Bio</h2>
			<p><?php echo htmlspecialchars($bio); ?></p>
		<?php endif; ?>
		</div>
	</div>
	<div class="profileBox teamListProfileBox">
		<h1 class="profileHeader museoTextBold">Teams</h1>
		<div class="sportList">
			<ul>
			<?php
				$categorizedTeams = categorizeBySport($teams);
				foreach($categorizedTeams as $sport => $teams):
			?>
				<li class="sportPositionsBox">
				<h1><?php echo $sport ?></h1>
				<table class="profilesTable">
				<tbody>
					<?php foreach($teams as $team): ?>
					<tr>
						<td>
						<img class="iconLarge" src="<?php echo $team['TeamLogoPath']; ?>" alt="Player looking for team" />
						</td>
						<td><a href="<?php echo Config::PAGE_PROF_TEAM . '?' . Config::PARAM_PROF_ID . '=' . $team['TeamID']; ?>"><?php echo htmlspecialchars($team['TeamName']); ?></a></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
	<div class="profileBox">
		<h1 class="profileHeader museoTextBold">My Sports</h1>
		<div class="sportList">
			<ul>
			<?php
				$categorizedPositions = categorizeBySport($positions);
				foreach($categorizedPositions as $sport => $positions):
			?>
				<li class="sportPositionsBox">
				<h1><?php echo $sport ?></h1>
				<table class="profilesTable">
				<col class="profilesSportsCol1" />
				<col class="profilesSportsCol2" />
				<tbody>
					<?php foreach($positions as $position): ?>
					<tr>
						<td>
						<?php if($position['LookingStatus'] == true): ?>
						<img class="icon" src="images/fistLight.png" alt="Player looking for team" />
						<?php endif; ?>
						</td>
						<td><?php echo htmlspecialchars($position['PositionName']); ?></td>
						<td><?php echo htmlspecialchars($position['SkillLevelName']); ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
				</table>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
<?php
function categorizePositions($positions)
{
	$currentSport = null;
	$sportPositions = array();
	
	// Categorize players
	foreach($positions as $position)
	{	
		$currentSport = $position['SportName'] != NULL ? $position['SportName'] : "Unspecified";
		$sportPositions[$currentSport][] = $position;
	}
	return $sportPositions;
}

function categorizeBySport($items)
{
	$currentSport = null;
	$categorized = array();
	
	// Categorize players
	foreach($items as $item)
	{	
		$currentSport = $item['SportName'] != NULL ? $item['SportName'] : "Unspecified";
		$categorized[$currentSport][] = $item;
	}
	return $categorized;
}
?>