<div id="editPlayerAccount" class="editAccountContainer autoCentered">
	<form id="createPlayerAccountForm" class="styledForm userEntryForm roundedCorners" action="<?php echo Config::PAGE_PROF_EDIT_MAN; ?>" method="POST">
		<div class="createAccountFormContainer">
			<p class="formMessage formError"><?php echo $errorText; ?></p>
			<label for="firstName">Firstname</label>
			<input type="text" id="firstName" class="roundedCorners" name="firstName" value="<?php echo $manager['FirstName']; ?>" />
			<label for="lastName">Lastname</label>
			<input type="text" id="lastName" class="roundedCorners" name="lastName" value="<?php echo $manager['LastName']; ?>" />
			<label for="password">Password</label>
			<input type="password" id="password" class="roundedCorners" name="password" />
			<label for="passwordConfirm">Confirm Password</label>
			<input type="password" id="passwordConfirm" class="roundedCorners" name="passwordConfirm" />
			<label for="email">Email:</label>
			<input type="text"  id="email" class="roundedCorners" name="email" value="<?php echo $manager['EmailAddress']; ?>" />
			<label for="emailConfirm">Confirm Email:</label>
			<input type="text" id="emailConfirm" class="roundedCorners" name="emailConfirm" />
			<input type="hidden" name="submitted" value="1" />
			<div class="createAccountErrors">
				<p id="passwordMatch" class="formMessage formError">Passwords do not match.</p>
				<p id="emailFormat" class="formMessage formError">Email address invalid.</p>
				<p id="emailMatch" class="formMessage formError">Email addresses do not match.</p>
			</div>
			<input type="submit" class="museoText roundedCorners" value="Save" />
			<p class="formMessage"><?php echo $formMessageText; ?></p>
		</div>		
	</form>
</div>