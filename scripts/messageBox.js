$(document).ready(function() {
	$("#messageBox").on("click", ".messageBoxHeading", function (event) {
														if($("#messageBox").hasClass("open"))
														{
															closeMessageBox();
														}
														else
														{
															openMessageBox();
														}
													});
	$("#messageBox").on("click", ".messageCommand", doMessageActionAsync);
});

function openMessageBox() {
	$("#messageBox").addClass("open");
}

function closeMessageBox() {
	$("#messageBox").removeClass("open");
}

function doMessageActionAsync(event) {
	var url = $(this).prop("href");
	var qstring = url.split('?')[1];
	
	$.ajax({
            url: "messageAction.php?" + qstring,
            success: function(data) {
                $("#messageList").html(data);
            }
        });
	
	return false;
}