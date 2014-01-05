$(document).ready(function() {
	$("#searchForm").on("submit", function (event) {
									return queryTeamsAsync();
								});
	$("#ageMinimumSelector").spinner({ min: 18, max: 65 });
	$("#ageMaximumSelector").spinner({ min: 18, max: 65 });
	$("#ageMinimumSelector").on("spin", ageMinSpinnerChange);
	$("#ageMaximumSelector").on("spin", ageMaxSpinnerChange);	
	$("#lookingCheck").on("click", function(event){
		toggleDisable($(this), "#positionSelect");
		setSelectBoxToDefault("positionSelect", "--");
	});
});

function queryTeamsAsync() {
	// $.param returns and array of objects in the format [{formElementName:"name",formElementValue:"value"},...].
	var formElementValues = $("#searchForm").serializeArray();
	
	// serializeArray returns a URL query string.
	var GETQueryString = $.param(formElementValues);

	$.ajax({
            url: "teamQuery.php?" + GETQueryString,
            success: function(data) {
                $("#results").html(data)
            }
        });
	
	return false;
}