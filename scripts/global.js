function resetSelectBox(selectBoxID, keepValue) {
	$("#" + selectBoxID + " option").each(function() {
		if((keepValue === undefined) || $(this).val() != keepValue)
		{
			$(this).remove();
		}
	});
}

function setSelectBoxToDefault(selectBoxID, defaultValue)
{
	$("#" + selectBoxID + " option[value='" + defaultValue + "']").prop("selected", true);
}

function toggleDisplay(selector) {
	if($(selector).css("display") == "none")
	{
		$(selector).css("display", "block");
	}
	else
	{
		$(selector).css("display", "none");
	}
}

function toggleDisable(clickTarget, changeID) {
	if($(clickTarget).prop("checked") == true)
	{
		$(changeID).prop("disabled", false);
	}
	else
	{
		$(changeID).prop("disabled", true);
	}
}

function getPositionsBySportAsync() {
	var sportID = $("#sportSelect").val();
	var sportVariableName = $("#sportSelect").attr("name");
	
	$.ajax({
            url: "getPositionsBySportAsync.php?" + sportVariableName + "=" + sportID,
            success: function(data) {
                $("#positionSelect").html(data)
            }
        });
	
	return false;
}

function getPositionsByTeamAsync() {
	var teamID = $("#teamSelect").val();
	var teamVariableName = $("#teamSelect").prop("name");
	
	$.ajax({
			url: "getPositionsByTeamAsync.php?" + teamVariableName + "=" + teamID,
			success: function(data) {
				$("#positionSelect").html(data)
			}
        });
	
	return false;
}

function ageMinSpinnerChange(event, ui) {
	var ageMinCurrentValue = ui.value; // Get value to which the spinner was changed
	
	// Keep the min value of the max selector above the min selector's value
	$("#ageMaximumSelector").spinner("option", "min", ageMinCurrentValue == 65? ageMinCurrentValue : ageMinCurrentValue + 1);
	
	// The ui.value of the max selector is cached even after
	// the max selector is cleared using mouse + delete key.
	// Min selector is unable to increment because it is blocked
	// by max selector's old value. This checks if max selector is
	// really null, and resets the min selector's max limit.
	if($("#ageMaximumSelector").spinner("value") === null)
	{
		$("#ageMinimumSelector").spinner("option", "max", 65);
	}
}

function ageMaxSpinnerChange(event, ui) {
	var ageMaxCurrentValue = ui.value;	// Get value to which the spinner was changed
	
	// Keep the max value of the min selector below the max selector's value
	$("#ageMinimumSelector").spinner("option", "max", ageMaxCurrentValue == 18? ageMaxCurrentValue : ageMaxCurrentValue - 1);
	
	// The ui.value of the min selector is cached even after
	// the min selector is cleared using mouse + delete key.
	// Max selector is unable to decrement because it is blocked
	// by min selector's old value. This checks if min selector is
	// really null, and resets the max selector's min limit.
	if($("#ageMinimumSelector").spinner("value") === null)
	{
		$("#ageMaximumSelector").spinner("option", "min", 18);
	}
}