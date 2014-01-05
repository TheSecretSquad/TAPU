<?php if(empty($players)): ?>
<h1 class="autoCentered profilesNotFound">No results</h1>
<?php else: ?>
<table class="profilesTable profilesEndBorder">
<colgroup>
    <col class="profilesSearchPhoto">
	<col>
	<col>
	<col>
	<col>
	<col>
	<col class="profilesSearchLookingStatus">
  </colgroup>
	<thead>
		<tr>
			<th><!-- Photo --></th>
			<th>Name</th>
			<th>City</th>
			<th>State</th>
			<th>Gender</th>
			<th>Age</th>
			<th><img class="icon" src="images/fistLight.png" alt="Looking for a team" /></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($players as $player):
			$playerProfilePic = !empty($player['ProfilePicturePath']) ? Config::DIR_IMG_UPLOAD . $player['ProfilePicturePath'] : Config::IMG_PROF_DEFAULT;
		?>
			<tr>
				<td><img class="profilePicSmall" src="<?php echo htmlspecialchars($playerProfilePic); ?>" alt="Profile picture for <?php echo htmlspecialchars($player['PlayerName']); ?>" /></td>
				<?php  $profilePageUrlQry = http_build_query(array(Config::PARAM_PROF_ID => $player['AccountNumber'])); ?>
				<td><a href="<?php echo Config::PAGE_PROF_PLAYER . "?" . $profilePageUrlQry; ?>"><?php echo htmlspecialchars($player['PlayerName']); ?></a></td>
				<td><?php echo htmlspecialchars($player['City']); ?></td>
				<td><?php echo htmlspecialchars($player['StateAbbreviation']); ?></td>
				<td><?php echo htmlspecialchars($player['GenderName']); ?></td>
				<td><?php echo htmlspecialchars($player['Age']); ?></td>
				<td><?php if($player['LookingStatus'] == true) : ?>
				<img class="icon" src="images/fistLight.png" alt="Player <?php echo htmlspecialchars($player['PlayerName']) ?> is looking for a team" />
				<?php endif; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	<tbody>
</table>
<?php endif; ?>