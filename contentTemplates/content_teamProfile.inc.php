<div class="profileContent">
	<div class="profileBox bioProfileBox">
		<img class="profilePicture profilePicLarge" src="<?php echo !empty($teamLogo) ? Config::DIR_IMG_UPLOAD . $teamLogo : Config::IMG_PROF_DEFAULT; ?>" alt="Profile picture" />
		<div class="playerData">
		<?php if(!empty($alreadyOnTeam) && $alreadyOnTeam == true): ?>
			<p>You are on this team.</p>
		<?php elseif(!empty($outstandingRequest) && $outstandingRequest == true): ?>
			<p>Recruitment pending.</p>
		<?php elseif(!empty($recruitingParty)) : ?>
		<div class="teamManagerCommandBox">
			<a href="#" id="recruitMessageButton" class="teamManagerCommand teamManagerCommandText">Join</a>
		</div>
		<?php endif; ?>
		<table class="profilesTable">
			<col class="profilesFirstColWidthVer" />
			<tbody>
				<tr>
					<th>Gender:</th>
					<?php 	switch($teamGender)
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
				</tr>
				<?php if(!empty($teamMinAge) || !empty($teamMaxAge)): ?>
				<tr>
					<th>Ages:</th>
					<td>
					<?php echo !empty($teamMinAge) ? $teamMinAge : "Under"; ?>
					<?php echo !empty($teamMaxAge) ? ' - ' . $teamMaxAge : " and over" ?>
					</td>
				</tr>
				<?php endif; ?>
				<tr>
					<th>Location:</th>
					<td><?php echo htmlspecialchars($teamLocation); ?></td>
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
		<h1 class="profileHeader museoTextBold">Roster</h1>
		<?php if(empty($rosterPlayers)): ?>
		<h2>Empty</h2>
		<?php else: ?>
		<div class="sportList">
			<ul>
			<?php foreach($rosterPlayers as $rosterPlayer):	?>
				<li class="sportPositionsBox">
				<table class="profilesTable">
				<col class="profilesFirstColWidthVer" />
				<tbody>
					<tr>
						<td>
						<img class="iconLarge" src="<?php echo !empty($rosterPlayer['ProfilePicturePath']) ? Config::DIR_IMG_UPLOAD . $rosterPlayer['ProfilePicturePath'] : Config::IMG_PROF_DEFAULT; ?>" alt="Player looking for team" />
						</td>
						<td>
						<a href="<?php echo Config::PAGE_PROF_PLAYER . "?" . http_build_query(array(Config::PARAM_PROF_ID => $rosterPlayer['PlayerAccountNumber']));?>"><?php echo htmlspecialchars($rosterPlayer['LastName'] . ', ' . $rosterPlayer['FirstName']); ?></a>
						</td>
						<td>
							<?php echo !empty($rosterPlayer['PositionName']) ? $rosterPlayer['PositionName'] : 'Undeclared'; ?>
						</td>
					</tr>
				</tbody>
				</table>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>
	</div>
	<div class="profileBox">
		<?php if(empty($positionsRecruiting)): ?>
		<h1 class="profileHeader museoTextBold">Not currently recruiting</h1>
		<?php else: ?>
		<h1 class="profileHeader museoTextBold">Positions Open</h1>
		<div class="sportList">
		<table class="profilesTable">
			<tbody>
			<?php
				foreach($positionsRecruiting as $position):
				if($position['LookingStatus'] == true):
				?>
				
					<tr>
						<td>
						<?php if($position['LookingStatus'] == true): ?>
						<img class="icon" src="images/fistLight.png" alt="Team looking for player" />
						<?php endif; ?>
						</td>
						<td><?php echo htmlspecialchars($position['PositionName']); ?></td>
					</tr>
				<?php
				endif;
				endforeach;
			?>
			</tbody>
		</table>
		</div>
		<?php endif; ?>
	</div>
</div>