<div class="autoCentered loginFormContainer">
	<div class="userEntryForm styledForm lightBackground roundedCorners">
	<form id="loginForm" action="<?php echo Config::PAGE_LOGIN; ?>" method="POST">
		<p class="formMessage">Select your account type.</p>
		<input id="playerRadio" class="loginRadioButton" type="radio" name="accountType" value="P" <?php echo $accountType == 'P' ? 'checked' : ''; ?> />
		<label class="labelButton loginLabelButton roundedCorners" for="playerRadio">Player</label>
		<input id="managerRadio" class="loginRadioButton" type="radio" name="accountType" value="M" <?php echo $accountType == 'M' ? 'checked' : ''; ?>/>
		<label class="labelButton loginLabelButton roundedCorners" for="managerRadio">Team Manager</label>		
		<label for="username">Username</label>
		<input type="text" id="username" class="roundedCorners" name="username" value="<?php echo $username; ?>" />
		<label for="password">Password</label>
		<input type="password" id="password" class="roundedCorners" name="password" />
		<input class="museoText roundedCorners" type="submit" id="submit" value="Login" />
		<input type="hidden" name="submitted" value="1" />
		<p id="error" class="formMessage formError"><?php echo $errorText; ?></p>
	</form>
	</div>
</div>