<div id="recruitMessageBox" class="recruitMessageBox userEntryForm styledForm lightBackground roundedCorners">
<div class="messageCommands">
<a href="#" id="recruitMessageClose" class="messageCommand messageCommandDecline">
	<p class="messageCommandIcon">&#x2716;</p>
</a>
</div>
	<form id="recruitMessageForm" action="#" method="POST">
		<?php if($recruitingAccountType == 'M'): ?>
			<?php $successMessageType = 'recruit'; ?>
			<label for="teamSelect">Team</label>
			<select id="teamSelect" name="team" class="roundedCorners">
			<option value="--">--</option>
			<?php var_dump($messageTeams); ?>
			<?php foreach($messageTeams as $messageTeam): ?>
				<option value="<?php echo $messageTeam['TeamID']; ?>"><?php echo $messageTeam['TeamName']; ?></option>
			<?php endforeach; ?>
			</select>
			<label for="positionSelect">Position</label>
			<select id="positionSelect" name="position" class="roundedCorners">
			</select>
			<label for="note">Note</label>
			<textarea id="note" name="note"></textarea>
			<input type="hidden" name="messageSubmitted" value="1" />
			<input type="hidden" name="player" value="<?php echo $selectedAcctNum; ?>" />
			<input type="submit" class="roundedCorners" />
			<p id="teamMissing" class="formMessage formError">Must select a team.</p>
		<?php elseif($recruitingAccountType == 'P'): ?>
			<?php $successMessageType = 'join'; ?>
			<h3><?php echo $pageTitle ?></h3>
			<input type="hidden" name="team" value="<?php echo $selectedAcctNum ?>" />
			<label for="positionSelect">Position</label>
			<select id="positionSelect" name="position" class="roundedCorners">
				<?php if($recruitingAccountType == 'P'): ?>
					<option value="--">Any</option>
					<?php foreach($positions as $position): ?>
						<option value="<?php echo $position['PositionID']; ?>"><?php echo $position['PositionName']; ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
			<label for="note">Note</label>
			<textarea id="note" name="note"></textarea>
			<input type="hidden" name="messageSubmitted" value="1" />
			<input type="hidden" name="player" value="<?php echo $recruitingParty; ?>" />
			<input type="submit" class="roundedCorners" />
		<?php endif; ?>	
	</form>
</div>

<div id="recruitSuccessMessage" class="recruitMessageBox userEntryForm lightBackground roundedCorners playerJoin">
<div class="messageCommands">
<a href="#" id="<?php echo $successMessageType; ?>SuccessClose" class="messageCommand messageCommandDecline">
	<p class="messageCommandIcon">&#x2716;</p>
</a>
</div>
<p>Message sent!</p>
</div>