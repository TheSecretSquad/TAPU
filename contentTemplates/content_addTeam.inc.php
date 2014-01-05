<div id="editPlayerAccount" class="editAccountContainer autoCentered">
	<form id="createTeamAccountForm" class="styledForm userEntryForm roundedCorners" action="<?php echo Config::PAGE_PROF_ADD_TEAM; ?>" method="POST" enctype="multipart/form-data">
		<div class="editProfile">
		<p class="formMessage formError"><?php echo $errorText; ?></p>
		<p class="formMessage"><?php echo $formMessageText; ?></p>
		<label for="sport">Sport</label>
		<select id="sport" class="roundedCorners" name="sport">
			<option value="--">--</option>
			<?php foreach($sports as $sport): ?>
			<option value="<?php echo $sport['SportID']; ?>"><?php echo $sport['SportName']; ?></option>
			<?php endforeach; ?>
		</select>
			<label for="teamName">Team Name</label>
			<input type="text" class="roundedCorners" id="teamName" name="teamName" />
			<label for="teamLogoFile">Team Logo</label>
			<input type="file" name="teamLogoFile" id="teamLogoFile" />
			<div>
			<label for="bio">Bio</label>
			<textarea id="bio" class="bioInput" name="bio"></textarea>
			</div>
			<label for="skillLevel">Skill Level</label>
			<select id="skillLevel" class="roundedCorners" name="skillLevel">
			<option value="--">--</option>
				<?php foreach($skillLevels as $skillLevel): ?>
				<option value="<?php echo $skillLevel['SkillLevelID']; ?>"><?php echo $skillLevel['SkillLevelName']; ?></option>
				<?php endforeach; ?>
			</select>
			<div class="spinner">
			<label for="ageMinimumSelector">Min. Age</label>
			<input id="ageMinimumSelector" class="numberSelect" name="ageMin" />
			</div>
			<div class="spinner">
			<label for="ageMaximumSelector">Max. Age</label>
			<input id="ageMaximumSelector" class="numberSelect" name="ageMax" />
			</div>
			<label for="city">City</label>
			<input type="text" id="city" class="roundedCorners" name="city" />
			<label for="stateSelect">State</label>
			<select id="stateSelect" class="roundedCorners" name="state">
			<option value="--">--</option>
				<?php foreach($states as $state): ?>
				<option value="<?php echo $state['StateAbbreviation']; ?>"><?php echo $state['StateName']; ?></option>
				<?php endforeach; ?>
			</select>
			<label for="zipCode">Zip Code</label>
			<input type="text" id="zipCode" class="roundedCorners" name="zipCode" />
			<label for="seasonStartDate">Season Start Date</label>
			<input id="seasonStartDate" name="seasonStartDate" />
			<label for="seasonEndDate">Season End Date</label>
			<input id="seasonEndDate" name="seasonEndDate" />
			<label for="genderSelect">Gender</label>
			<select id="genderSelect" class="roundedCorners" name="gender">
			<option value="--">--</option>
			<option value="C">Coed</option>
				<?php foreach($genders as $gender): ?>
				<option value="<?php echo $gender['GenderID']; ?>"><?php echo $gender['GenderName']; ?></option>
				<?php endforeach; ?>
			</select>
			<label for="leagueName">League Name</label>
			<input type="text" id="leagueName" class="roundedCorners" name="leagueName" />
			<label for="leagueDuesAmt">League Dues Amount</label>
			<input type="text" id="leagueDuesAmt" class="roundedCorners" name="leagueDuesAmt" />
			<div>
			<label for="hasTryouts">Tryouts Required</label>
			<input type="checkbox" id="hasTryouts" class="roundedCorners" name="hasTryouts" />
			</div>
			<input type="hidden" name="submitted" value="1" />
			<input type="submit" class="museoText roundedCorners" value="Save" />
			<div class="createAccountErrors">
				<p id="sportMissing" class="formMessage formError">Please select a sport.</p>
				<p id="teamNameMissing" class="formMessage formError">Please supply a team name.</p>
				<p id="skillLevelMissing" class="formMessage formError">Please select a skill level.</p>
				<p id="stateMissing" class="formMessage formError">Please select a state.</p>
				<p id="cityMissing" class="formMessage formError">Please select a city.</p>
				<p id="genderMissing" class="formMessage formError">Please select a gender.</p>
			</div>
		</div>
	</form>
</div>