<div class="profileContent">
	<div class="profileBox">
	<?php
		$currentAccount = new AccountSession();
		if(!empty($_SESSION[AccountSession::SESS_ACCT_NUM_FLD]) &&  $_SESSION[AccountSession::SESS_ACCT_NUM_FLD] == $selectedAcctNum): ?>
		<a href="editManagerProfile.php" class="editAccountLink">Edit Account</a>
	<?php endif; ?>
		<h1 class="profileHeader museoTextBold">Teams</h1>
		<div class="teamManagerCommandBox">
			<a href="addTeam.php" class="teamManagerCommand teamManagerCommandText">Add Team</a>
		</div>
		<div class="sportList">
			<ul>
			<?php
				$categorizedTeams = categorizeBySport($managerTeams);
				foreach($categorizedTeams as $sport => $teams):
			?>
				<li class="sportPositionsBox">
				<h1><?php echo $sport ?></h1>
				<table class="profilesTable">
				<col class="profilesSportsCol1" />
				<col class="profilesSportsCol2" />
				<tbody>
				<tr>
					<th><!-- Logo --></th>
					<th>Team Name</th>
					<th>League Name</th>
					<th>Skill Level</th>
					<th>Min. Age</th>
					<th>Max. Age</th>
					<th>Season Start</th>
					<th>Season End</th>
					<th>Tryouts</th>
					<th>League Dues</th>
					<th><!-- Controls --></th>
				</tr>
					<?php foreach($teams as $team): ?>
					<tr>
						<td>
						<img class="profilePicSmall" src="<?php echo !empty($team['TeamLogoPath']) ? Config::DIR_IMG_UPLOAD . $team['TeamLogoPath'] : Config::IMG_PROF_DEFAULT; ?>" alt="Logo for team <?php echo htmlspecialchars($team['TeamName']); ?>" />
						</td>
						<td>
							<?php  $profilePageUrlQry = http_build_query(array(Config::PARAM_PROF_ID => $team['TeamID'])); ?>
							<a href="<?php echo Config::PAGE_PROF_TEAM . "?" . $profilePageUrlQry; ?>"><?php echo $team['TeamName']; ?></a>
						</td>
						<td>
							<?php echo $team['LeagueName']; ?>
						</td>
						<td>
							<?php echo $team['SkillLevelName']; ?>
						</td>
						<td>
							<?php echo $team['AgeMinimum']; ?>
						</td>
						<td>
							<?php echo $team['AgeMaximum']; ?>
						</td>
						<td>
							<?php echo date("D, M d, Y", strtotime($team['SeasonStartDate'])); ?>
						</td>
						<td>
							<?php echo date("D, M d, Y", strtotime($team['SeasonEndDate'])); ?>
						</td>
						<td>
							<?php echo $team['TryoutRequired'] == true ? "Yes" : "No"; ?>
						</td>
						<td>
							<?php echo htmlspecialchars(!empty($team['LeagueDuesAmountPerPlayer']) && $team['LeagueDuesAmountPerPlayer'] > 0 ? '$' . $team['LeagueDuesAmountPerPlayer'] : "None"); ?>
						</td>
						<td>
							<div class="teamManagerCommandBox">
								<a href="#" class="teamManagerCommand teamManagerCommandText">Manage</a>
							</div>
						</td>
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