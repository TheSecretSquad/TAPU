$(document).ready(function() {
	$("#dateOfBirth").datepicker();
	$("#createPlayerAccountForm").on("submit", function (event) {
													return validateAcctCreateForm();
											});
	
	$("#playerRadio, #managerRadio").on("click", function (event) {
													displayFormForSelectedAcctType();
											});
	resetForm();
});

function resetForm()
{
		$("label[for='firstName']").hide();
		$("#firstName").hide();
		
		$("label[for='lastName']").hide();
		$("#lastName").hide();
		
		$("label[for='password']").hide();
		$("#password").hide();
		
		$("label[for='passwordConfirm']").hide();
		$("#passwordConfirm").hide();
		
		$("label[for='email']").hide();
		$("#email").hide();
		
		$("label[for='emailConfirm']").hide();
		$("#emailConfirm").hide();
	
		$("label[for='city']").hide();
		$("#city").hide();
		
		$("label[for='stateSelect']").hide();
		$("#stateSelect").hide();
		
		$("label[for='zipCode']").hide();
		$("#zipCode").hide();
		
		$("label[for='dateOfBirth']").hide();
		$("#dateOfBirth").hide();
		
		$("#genderRadioGroup").hide();
		
		$("input[type='submit']").hide();
}


function displayFormForSelectedAcctType() {
	$('input[name="gender"]').prop("checked", false);
	
	$("label[for='firstName']").show();
	$("#firstName").show();
	
	$("label[for='lastName']").show();
	$("#lastName").show();
	
	$("label[for='password']").show();
	$("#password").show();
	
	$("label[for='passwordConfirm']").show();
	$("#passwordConfirm").show();
	
	$("label[for='email']").show();
	$("#email").show();
	
	$("label[for='emailConfirm']").show();
	$("#emailConfirm").show();
	
	$("label[for='dateOfBirth']").show();
	$("#dateOfBirth").show();
	
	if($("#playerRadio").prop("checked"))
	{
		$("label[for='city']").show();
		$("#city").show();
		
		$("label[for='stateSelect']").show();
		$("#stateSelect").show();
		
		$("label[for='zipCode']").show();
		$("#zipCode").show();
		
		$("#genderRadioGroup").show();
		
		$("input[type='submit']").show();
	}
	else if($("#managerRadio").prop("checked"))
	{
		$("label[for='city']").hide();
		$("#city").hide();
		
		$("label[for='stateSelect']").hide();
		$("#stateSelect").hide();
		
		$("label[for='zipCode']").hide();
		$("#zipCode").hide();
		
		$("#genderRadioGroup").hide();
		
		$("input[type='submit']").show();
	}
	
	// Clear errors
	$(".error").removeClass("error");
}

function validateAcctCreateForm() {
	var returnVal = true;
	
	// Validate account type selection
	var accountTypeRadios = document.forms["createPlayerAccountForm"]["accountType"];
	if (accountTypeRadios[0].checked == false && accountTypeRadios[1].checked == false)
	{
		$("#accountTypeMissing").addClass("error");
		returnVal = false;
	}
	else
	{
		$("#accountTypeMissing").removeClass("error");
	}
	
	// Validate first name
	var firstName = document.forms["createPlayerAccountForm"]["firstName"].value;
	if (firstName === undefined || firstName  == "")
	{
		$("#firstNameMissing").addClass("error");
		returnVal = false;
	}
	else
	{
		$("#firstNameMissing").removeClass("error");
	}

	// Validate last name
	var lastName = document.forms["createPlayerAccountForm"]["lastName"].value;
	if (lastName === undefined || lastName == "")
	{
		$("#lastNameMissing").addClass("error");
		returnVal = false;
	}
	else
	{
		$("#lastNameMissing").removeClass("error");
	}
	
	// Validate password
	var password = document.forms["createPlayerAccountForm"]["password"].value;
	var passwordConfirm = document.forms["createPlayerAccountForm"]["passwordConfirm"].value;

	if (password === undefined || password == "")
	{
		$("#passwordMissing").addClass("error");
		returnVal = false;
	}
	else
	{
		$("#passwordMissing").removeClass("error");
	}
	
	if(password != passwordConfirm)
	{
		$("#passwordMatch").addClass("error");
		returnVal = false;
	}
	else
	{
		$("#passwordMatch").removeClass("error");
	}
	
	// Validate email address
	var email = document.forms["createPlayerAccountForm"]["email"].value;
	if(email === undefined || email == "")
	{
		$("#emailMissing").addClass("error");
		returnVal = false;
	}
	else
	{
		$("#emailMissing").removeClass("error");
	}
	
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
	
	var emailConfirm = document.forms["createPlayerAccountForm"]["emailConfirm"].value;

	if(email != emailConfirm)
	{
		$("#emailMatch").addClass("error");
		returnVal = false;
	}
	else
	{
		$("#emailMatch").removeClass("error");
	}
	
	var dateOfBirth = document.forms["createPlayerAccountForm"]["dateOfBirth"].value;
		if (dateOfBirth === undefined || dateOfBirth == "")
		{
			$("#dateOfBirthMissing").addClass("error");
			returnVal = false;
		}
		else
		{
			$("#dateOfBirthMissing").removeClass("error");
		}

	if(accountTypeRadios[0].checked == true)
	{
		// Validate city
		var city = document.forms["createPlayerAccountForm"]["city"].value;
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
		var state = document.forms["createPlayerAccountForm"]["state"].value;
		if (state == "--")
		{
			$("#stateMissing").addClass("error");
			returnVal = false;
		}
		else
		{
			$("#stateMissing").removeClass("error");
		}
		
		var genderRadios = document.forms["createPlayerAccountForm"]["gender"];
		if (genderRadios[0].checked == false && genderRadios[1].checked == false)
		{
			$("#genderMissing").addClass("error");
			returnVal = false;
		}
		else
		{
			$("#genderMissing").removeClass("error");
		}
	}
	
	return returnVal;
}