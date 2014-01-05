$(document).ready(function() {
	$("#teamSelect").on("change", function(event) {
									return getPositionsByTeamAsync();
								});
						
	$("#recruitMessageForm").on("submit", function(event) {
									if(validateRecruitMessage())
									{
										return sendRecruitMessageAsync();
									}
									return false;
								});
								
	$("#recruitMessageButton, #recruitMessageClose").on("click", function(event) {
											toggleDisplay("#recruitMessageBox");
										});
	$("#recruitSuccessClose").on("click", function(event) {
									// Close success box
									toggleDisplay("#recruitSuccessMessage");
									// Make sure the message box is open.
									//openMessageBox();
									// Reload message box on success.
									//$("#messageBox").load('global.inc.php .messageBoxHeading, #messageList');
									// Clear the recruit message form
									//$("#recruitMessageForm")[0].reset();
									//resetSelectBox("positionSelect");
									location.reload();
								});
	$("#joinSuccessClose").on("click", function(event) {
									// Close success box
									toggleDisplay("#recruitSuccessMessage");
									// Make sure the message box is open.
									//openMessageBox();
									// Reload message box on success.
									//$("#messageBox").load('global.inc.php .messageBoxHeading, #messageList');
									// Clear the recruit message form
									//$("#recruitMessageForm")[0].reset();
									location.reload();
								});
});

function validateRecruitMessage() {
	var returnVal = true;
	
	var team = document.forms["recruitMessageForm"]["team"].value;
	if (team === undefined || team  == "--")
	{
		$("#teamMissing").addClass("error");
		returnVal = false;
	}
	else
	{
		$("#teamMissing").removeClass("error");
	}
	
	return returnVal;
}

function sendRecruitMessageAsync() {
	// $.param returns and array of objects in the format [{formElementName:"name",formElementValue:"value"},...].
	var formElementValues = $("#recruitMessageForm").serializeArray();
	
	// serializeArray returns a URL query string.
	var GETQueryString = $.param(formElementValues);

	$.ajax({
			type: "POST",
            url: "sendRecruitMessage.php",
			data: GETQueryString,
            success: function(data) {
                toggleDisplay("#recruitMessageBox");
				toggleDisplay("#recruitSuccessMessage");
            }
        });

	return false;
}