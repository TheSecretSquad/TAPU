<div id="searchFormContainer" class="profilesContainer">
<form id="searchForm" class="searchForm styledForm" method="post" action="<?php echo Config::PAGE_SEARCH_TEAM; ?>">
	<table>
		<tr>
			<td>
				<label for="teamNameTextBox">Team Name</label>
				<input type="text" id="teamNameTextBox" class="roundedCorners" name="teamName" />
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
					<option value="C">Coed</option>
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
				<label for="skillLevelSelect">Skill Level</label>
				<select id="skillLevelSelect" class="roundedCorners" name="skillLevel">
					<option value="--">Any</option>
					<?php foreach($skillLevels as $skillLevel): ?>
					<option value="<?php echo $skillLevel['SkillLevelID']; ?>"><?php echo $skillLevel['SkillLevelName']; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<input class="museoText roundedCorners" type="submit" value="Search" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="leagueNameTextBox">League Name</label>
				<input type="text" id="leagueNameTextBox" class="roundedCorners" name="leagueName" />
			</td>
			<td>
				<div class="spinner">
				<label for="ageMinimumSelector">Min. Age</label>
				<input id="ageMinimumSelector" class="numberSelect" name="ageMin" />
				</div>
				<div class="spinner">
				<label for="ageMaximumSelector">Max. Age</label>
				<input id="ageMaximumSelector" class="numberSelect" name="ageMax" />
				</div>
			</td>
			<td>
				<label for="tryOutsCheck">Tryouts Required</label>
				<input type="checkbox" id="tryOutsCheck" class="checkBox" name="hasTryouts" value="1" />
			</td>
			<td>
				<label for="leagueDuesCheck">League Dues Required</label>
				<input type="checkbox" id="leagueDuesCheck" class="checkBox" name="hasLeagueDues" value="1" />
			</td>
			<td>
				<label for="lookingCheck"><img class="icon" src="images/fistLight.png" alt="Looking for a team" /></label>
				<input type="checkbox" id="lookingCheck" class="roundedCorners" name="lookingStatus"  value="1" />
			</td>
			<td>
				<label for="positionSelect">Position</label>
				<select id="positionSelect" class="roundedCorners" name="position" disabled>
					<option value="--">Any</option>
				</select>
			</td>
			<td>
				<input class="museoText roundedCorners" type="reset" value="Clear" />
			</td>
		</tr>
	</table>
</form>
<div id="results" class="profilesContainer"></div>
</div>