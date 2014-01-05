<option value="--">Any</option>
<?php foreach($positions as $position): ?>
	<option value="<?php echo $position['PositionID'] ?>"><?php echo $position['PositionName'] ?></option>
<?php endforeach; ?>