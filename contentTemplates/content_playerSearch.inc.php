<div id="searchFormContainer" class="profilesContainer">
<form id="searchForm" class="searchForm styledForm" method="post" action="#">
	<table>
		<tr>
			<td>
				<label for="playerLastNameTextBox">Last Name</label>
				<input type="text" id="playerLastNameTextBox" class="roundedCorners" name="playerLastName" />
			</td>
			<td>
				<label for="cityTextBox">City</label>
				<input type="text" id="cityTextBox" class="roundedCorners" name="city" />
			</td>
			<td>
				<label for="stateSelect">State</label>
				<select id="stateSelect" class="roundedCorners" name="state">
					<option value="--">Any</option>
					<?php foreach($states as $state): ?>
					<option value="<?php echo $state['StateAbbreviation']; ?>"><?php echo $state['StateName']; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<label for="genderSelect">Gender</label>
				<select id="genderSelect" class="roundedCorners" name="gender">
					<option value="--">Any</option>
					<?php foreach($genders as $gender): ?>
					<option value="<?php echo $gender['GenderID']; ?>"><?php echo $gender['GenderName']; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<label for="sportSelect">Sport</label>
				<select id="sportSelect" class="roundedCorners" name="sport">
					<option value="--">Any</option>
					<?php foreach($sports as $sport): ?>
					<option value="<?php echo $sport['SportID']; ?>"><?php echo $sport['SportName']; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<label for="positionSelect">Position</label>
				<select id="positionSelect" class="roundedCorners" name="position">
					<option value="--">Any</option>
				</select>
			</td>
			<td>
				<label for="lookingCheck"><img class="icon" src="images/fistLight.png" alt="Looking for a team" /></label>
				<input type="checkbox" id="lookingCheck" class="roundedCorners" name="lookingStatus" value="1" />
			</td>
			<td>
				<input class="museoText roundedCorners" type="submit" value="Search" />
			</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td>
				<input id="formReset" class="museoText roundedCorners" type="reset" value="Clear" />
			</td>
		</tr>
	</table>
</form>
<div id="results" class="profilesContainer"></div>
</div>