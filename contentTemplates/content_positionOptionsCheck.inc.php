<?php if(!empty($positions)): ?>
<table class="profilesTable">
<thead>
	<tr>
		<th>Position</th>
		<th>Skill Level</th>
		<th><img class="icon" src="images/fistLight.png" alt="Looking for players" /></th>
	</tr>
</thead>
	<tbody>
		<?php foreach($positions as $position): ?>
		<tr>
			<td><label for="positionSkillLevel<?php echo $position['PositionID']; ?>"><?php echo $position['PositionName']; ?></label></td>
			<td>
				<select id="positionSkillLevel<?php echo $position['PositionID']; ?>" class="roundedCorners" name="positions[<?php echo $position['PositionID']; ?>][skillLevel]">
				<option value="--">Don't Play</option>
				<?php foreach($skillLevels as $skillLevel): ?>
				<option value="<?php echo $skillLevel['SkillLevelID']; ?>" <?php if($skillLevel['SkillLevelID'] == $position['SkillLevelID']){ echo 'selected';} ?>><?php echo $skillLevel['SkillLevelName']; ?></option>
				<?php endforeach; ?>
				</select>
			</td>
			<td>
				<input id="positionLooking<?php echo $position['PositionID']; ?>" type="checkbox" value="1" name="positions[<?php echo $position['PositionID']; ?>][lookingStatus]" <?php if($position['LookingStatus'] == true){ echo 'checked'; } ?> />
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php endif; ?>