$(document).ready(function() {
	$("#seasonStartDate").datepicker();
	$("#seasonEndDate").datepicker();
	$("#ageMinimumSelector").spinner({ min: 18, max: 65 });
	$("#ageMaximumSelector").spinner({ min: 18, max: 65 });
	$("#ageMinimumSelector").on("spin", ageMinSpinnerChange);
	$("#ageMaximumSelector").on("spin", ageMaxSpinnerChange);
	
	$("#createTeamAccountForm").on("submit", function (event) {
									return validateAcctCreateForm();
								});
});

function validateAcctCreateForm() {
	var returnVal = true;
	
	// Validate sport
	var sport = document.forms["createTeamAccountForm"]["sport"].value;
	if (sport == "--")
	{
		$("#sportMissing").addClass("error");
		returnVal = false;
	}
	else
	{
		$("#sportMissing").removeClass("error");
	}
	
	// Validate team name
	var teamName = document.forms["createTeamAccountForm"]["teamName"].value;
	if (teamName === undefined || teamName  == "")
	{
		$("#teamNameMissing").addClass("error");
		returnVal = false;
	}
	else
	{
		$("#teamNameMissing").removeClass("error");
	}

	// Validate skill level
	var skillLevel = document.forms["createTeamAccountForm"]["skillLevel"].value;
	if (skillLevel == "--")
	{
		$("#skillLevelMissing").addClass("error");
		returnVal = false;
	}
	else
	{
		$("#skillLevelMissing").removeClass("error");
	}
	
	// Validate city
	var city = document.forms["createTeamAccountForm"]["city"].value;

	if (city === undefined || city == "")
	{
		$("#cityMissing").addClass("error");
		returnVal = false;
	}
	else
	{
		$("#cityMissing").removeClass("error");
	}
	
	// Validate state
	var state = document.forms["createTeamAccountForm"]["state"].value;

	if (state == "--")
	{
		$("#stateMissing").addClass("error");
		returnVal = false;
	}
	else
	{
		$("#stateMissing").removeClass("error");
	}
	
	// Validate  gender
	var gender = document.forms["createTeamAccountForm"]["gender"].value;
	if(gender == "--")
	{
		$("#genderMissing").addClass("error");
		returnVal = false;
	}
	else
	{
		$("#genderMissing").removeClass("error");
	}
	
	return returnVal;
}

