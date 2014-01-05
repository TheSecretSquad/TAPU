$(document).ready(function() {
	$("#sportSelect").on("change", function(event) {
									return getPositionsBySportAsync();
								});
	$("#searchForm").on("reset", function(event) {
					resetSelectBox("positionSelect", '--');
				});
});