<?php if(empty($teams)): ?>
<h1 class="autoCentered profilesNotFound">No results</h1>
<?php else: ?>
<table class="profilesTable profilesEndBorder">
<colgroup>
    <col class="profilesFirstColWidthHor">
  </colgroup>
	<thead>
		<tr>
			<th>Logo</th>
			<th>Team Name</th>
			<th>Sport</th>
			<th>Skill Level</th>
			<th>Age Min</th>
			<th>Age Max</th>
			<th>Gender</th>
			<th>Season Start</th>
			<th>City</th>
			<th>State</th>
			<th><img class="icon" src="<?php echo Config::DIR_IMG_SITE ?>fistLight.png" alt="Looking for players" /></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($teams as $team):
			$teamLogo = !empty($team['TeamLogoPath']) ? Config::DIR_IMG_UPLOAD . $team['TeamLogoPath'] : Config::IMG_PROF_DEFAULT;
		?>
			<tr>
				<td><img class="profilePicSmall" src="<?php echo htmlspecialchars($teamLogo); ?>" alt="Profile picture for <?php echo htmlspecialchars($team['TeamName']); ?>" /></td>
				<?php  $profilePageUrlQry = http_build_query(array(Config::PARAM_PROF_ID => $team['TeamID'])); ?>
				<td><a href="<?php echo Config::PAGE_PROF_TEAM . "?" . $profilePageUrlQry; ?>"><?php echo htmlspecialchars($team['TeamName']); ?></a></td>
				<td><?php echo htmlspecialchars($team['SportName']); ?></td>
				<td><?php echo htmlspecialchars($team['SkillLevelName']); ?></td>
				<td><?php echo htmlspecialchars($team['AgeMinimum']); ?></td>
				<td><?php echo htmlspecialchars($team['AgeMaximum']); ?></td>
				<?php 	switch($team['Gender'])
							{
								case 'M': $genderName = 'Male';
								break;
								case 'F': $genderName = 'Female';
								break;
								case 'C': $genderName = 'Coed';
								break;
							}
					?>
				<td><?php echo htmlspecialchars($genderName); ?></td>
				<td><?php echo htmlspecialchars($team['SeasonStartDate']); ?></td>
				<td><?php echo htmlspecialchars($team['City']); ?></td>
				<td><?php echo htmlspecialchars($team['StateAbbreviation']); ?></td>
				<td><?php if($team['LookingStatus'] == true) : ?>
				<img class="icon" src="images/fistLight.png" alt="Team <?php echo htmlspecialchars($team['TeamName']) ?> is looking for players" />
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	<tbody>
</table>
<?php endif; ?>