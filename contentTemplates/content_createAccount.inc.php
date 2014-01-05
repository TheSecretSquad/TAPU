<div class="autoCentered createAccountFormContainer">
<form id="createPlayerAccountForm" class="styledForm userEntryForm lightBackground roundedCorners"  method="POST" action="<?php echo Config::PAGE_CREATE_ACCT; ?>">
	<p class="formMessage">Select your account type.</p>
	<input id="playerRadio" class="loginRadioButton" type="radio" name="accountType" value="P" <?php if($accountType == 'P') echo 'checked'; ?> />
	<label class="labelButton loginLabelButton roundedCorners" for="playerRadio">Player</label>
	<input id="managerRadio" class="loginRadioButton" type="radio" name="accountType" value="M" <?php if($accountType == 'M') echo 'checked'; ?> />
	<label class="labelButton loginLabelButton roundedCorners" for="managerRadio">Team Manager</label>
	<label for="firstName">Firstname</label>
	<input type="text" id="firstName" class="roundedCorners" name="firstName" value="<?php echo $firstName; ?>" />
	<label for="lastName">Lastname</label>
	<input type="text" id="lastName" class="roundedCorners" name="lastName" value="<?php echo $lastName; ?>" />
	<label for="password">Password</label>
	<input type="password" id="password" class="roundedCorners" name="password" />
	<label for="passwordConfirm">Confirm Password</label>
	<input type="password" id="passwordConfirm" class="roundedCorners" name="passwordConfirm" />
	<label for="email">Email:</label>
	<input type="text"  id="email" class="roundedCorners" name="email" value="<?php echo $email; ?>" />
	<label for="emailConfirm">Confirm Email:</label>
	<input type="text" id="emailConfirm" class="roundedCorners" name="emailConfirm" />
	<label for="city">City</label>
	<input type="text" id="city" class="roundedCorners" name="city" value="<?php echo $city; ?>" />
	<label for="stateSelect">State</label>
	<select id="stateSelect" class="roundedCorners" name="state">
	<option value="--">--</option>
	<?php foreach($states as $state): ?>
	<option value="<?php echo $state['StateAbbreviation']; ?>" <?php if($state['StateAbbreviation'] == $selectedState) echo 'selected'; ?>><?php echo $state['StateName']; ?></option>
	<?php endforeach; ?>
	</select>
	<label for="zipCode">Zip Code</label>
	<input type="text" id="zipCode" class="roundedCorners" name="zipCode" value="<?php echo $zipCode; ?>" />
	<label for="dateOfBirth">Date of Birth</label>
	<input id="dateOfBirth" name="dateOfBirth" value="<?php echo $dateOfBirth; ?>" />
	<div id="genderRadioGroup">
	<label for="gender">Gender</label>
	<input id="genderMale" type="radio" name="gender" value="M" <?php if($gender == 'M') echo 'checked'; ?>>Male</input>
	<input id="genderFemale" type="radio" name="gender" value="F" <?php if($gender == 'F') echo 'checked'; ?>>Female</input>
	</div>
	<input type="hidden" name="submitted" value="1" />
	<input type="submit" class="museoText roundedCorners" value="Submit" />
	<div class="createAccountErrors">
	<p id="accountTypeMissing" class="formMessage formError">Account type missing.</p>
	<p id="firstNameMissing" class="formMessage formError">First name missing.</p>
	<p id="lastNameMissing" class="formMessage formError">Last name missing.</p>
	<p id="passwordMissing" class="formMessage formError">Password missing.</p>
	<p id="passwordMatch" class="formMessage formError">Passwords do not match.</p>
	<p id="emailMissing" class="formMessage formError">Email address missing.</p>
	<p id="emailFormat" class="formMessage formError">Email address invalid.</p>
	<p id="emailMatch" class="formMessage formError">Email addresses do not match.</p>
	<p id="cityMissing" class="formMessage formError">City missing.</p>
	<p id="stateMissing" class="formMessage formError">State missing.</p>
	<p id="dateOfBirthMissing" class="formMessage formError">Date of birth missing.</p>
	<p id="genderMissing" class="formMessage formError">Gender missing.</p>
	</div>
</form>
</div>