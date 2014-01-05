$(document).ready(function() {
	$("#searchForm").on("submit", queryPlayersAsync);
});

function queryPlayersAsync(event) {
	// $.param returns and array of objects in the format [{formElementName:"name",formElementValue:"value"},...].
	var formElementValues = $("#searchForm").serializeArray();
	
	// serializeArray returns a URL query string.
	var GETQueryString = $.param(formElementValues);

	$.ajax({
            url: "playerQuery.php?" + GETQueryString,
            success: function(data) {
                $("#results").html(data)
            }
        });
	
	return false;
}