$(document).ready(function() {
	$("#dateOfBirth").datepicker();
	$("#createPlayerAccountForm").on("submit", function (event) {
													return validateAcctEditForm();
											});
	$("#sportSelect").on("change", function (event) {
									return getPositionsCheckboxesBySportAsync();
								});
});

function getPositionsCheckboxesBySportAsync() {
	var sportID = $("#sportSelect").val();
	var sportVariableName = $("#sportSelect").attr("name");
	
	$.ajax({
            url: "getPositionsCheckBoxesBySportAsync.php?" + sportVariableName + "=" + sportID,
            success: function(data) {
                $("#positionChecks").html(data)
            }
        });
	
	return false;
}

function validateAcctEditForm() {
	var returnVal = true;
	
	// Validate password
	var password = document.forms["createPlayerAccountForm"]["password"].value;
	var passwordConfirm = document.forms["createPlayerAccountForm"]["passwordConfirm"].value;

	if ((password !== undefined && password != "") || (passwordConfirm !== undefined && passwordConfirm != ""))
	{	
		if(password != passwordConfirm)
		{
			$("#passwordMatch").addClass("error");
			returnVal = false;
		}
		else
		{
			$("#passwordMatch").removeClass("error");
		}
	}
	
	// Validate email address
	var email = document.forms["createPlayerAccountForm"]["email"].value;
	var emailConfirm = document.forms["createPlayerAccountForm"]["emailConfirm"].value;

	if(emailConfirm !== undefined && emailConfirm != "")
	{	
		var atSignPosition = email.indexOf("@");
		var dotPosition = email.lastIndexOf(".");
		if (atSignPosition < 1 || dotPosition < atSignPosition + 2 || dotPosition + 2 >= email.length)
		{
			$("#emailFormat").addClass("error");
			returnVal = false;
		}
		else
		{
			$("#emailFormat").removeClass("error");
		}
	
		if(email != emailConfirm)
		{
			$("#emailMatch").addClass("error");
			returnVal = false;
		}
		else
		{
			$("#emailMatch").removeClass("error");
		}
	}

	return returnVal;
}