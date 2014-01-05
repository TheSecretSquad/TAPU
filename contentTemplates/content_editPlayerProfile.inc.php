<div id="editPlayerAccount" class="editAccountContainer autoCentered">
	<form id="createPlayerAccountForm" class="styledForm userEntryForm roundedCorners" action="<?php echo Config::PAGE_PROF_EDIT_PLAYER; ?>" method="POST" enctype="multipart/form-data">
		<div class="editProfile">
		<p class="formMessage formError"><?php echo $errorText; ?></p>
		<p class="formMessage"><?php echo $formMessageText; ?></p>
			<label for="profilePic">Profile Picture</label>
			<input type="file" name="profilePic" id="profilePic" />
			<label for="bio">Bio</label>
			<textarea id="bio" class="bioInput" name="bio"><?php echo $player['Bio']; ?></textarea>
			<label for="firstName">Firstname</label>
			<input type="text" id="firstName" class="roundedCorners" name="firstName" value="<?php echo $player['FirstName']; ?>" />
			<label for="lastName">Lastname</label>
			<input type="text" id="lastName" class="roundedCorners" name="lastName" value="<?php echo $player['LastName']; ?>" />
			<label for="password">Password</label>
			<input type="password" id="password" class="roundedCorners" name="password" />
			<label for="passwordConfirm">Confirm Password</label>
			<input type="password" id="passwordConfirm" class="roundedCorners" name="passwordConfirm" />
			<label for="email">Email:</label>
			<input type="text"  id="email" class="roundedCorners" name="email" value="<?php echo $player['EmailAddress']; ?>" />
			<label for="emailConfirm">Confirm Email:</label>
			<input type="text" id="emailConfirm" class="roundedCorners" name="emailConfirm" />
			<label for="city">City</label>
			<input type="text" id="city" class="roundedCorners" name="city" value="<?php echo $player['City'] ?>" />
			<label for="stateSelect">State</label>
			<select id="stateSelect" class="roundedCorners" name="state">
			<option value="--">--</option>
				<?php foreach($states as $state): ?>
				<option value="<?php echo $state['StateAbbreviation']; ?>" <?php if($state['StateAbbreviation'] == $player['StateAbbreviation']) echo 'selected'; ?>><?php echo $state['StateName']; ?></option>
				<?php endforeach; ?>
			</select>
			<label for="zipCode">Zip Code</label>
			<input type="text" id="zipCode" class="roundedCorners" name="zipCode" value="<?php if(!empty($player['ZipCode'])) { echo $player['ZipCode']; } ?>" />
			<label for="dateOfBirth">Date of Birth</label>
			<input id="dateOfBirth" name="dateOfBirth" value="<?php echo date("m/d/Y", strtotime($player['DateOfBirth'])); ?>" />
			<div id="genderRadioGroup">
				<label for="gender">Gender</label>
				<input id="genderMale" type="radio" name="gender" value="M" <?php if($player['GenderID'] == 'M') echo 'checked'; ?>>Male</input>
				<input id="genderFemale" type="radio" name="gender" value="F" <?php if($player['GenderID'] == 'F') echo 'checked'; ?>>Female</input>
			</div>
			<input type="hidden" name="submitted" value="1" />
			<input type="submit" class="museoText roundedCorners" value="Save" />
			<div class="createAccountErrors">
				<p id="passwordMatch" class="formMessage formError">Passwords do not match.</p>
				<p id="emailFormat" class="formMessage formError">Email address invalid.</p>
				<p id="emailMatch" class="formMessage formError">Email addresses do not match.</p>
			</div>
		</div>
		<div class="createAccountFormContainer editProfilePositions">
			<label for="sportSelect">My Positions</label>
			<select id="sportSelect" class="roundedCorners" name="sport">
			<option value="--">--</option>
				<?php foreach($sports as $sport): ?>
				<option value="<?php echo $sport['SportID']; ?>"><?php echo $sport['SportName']; ?></option>
				<?php endforeach; ?>
			</select>
			<div id="positionChecks">
			</div>
		</div>
	</form>
</div>