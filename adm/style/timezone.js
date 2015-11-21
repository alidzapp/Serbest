(function($) { // Avoid conflicts with other libraries

"use strict";

$('#tz_date').change(function() {
	src.timezoneSwitchDate(false);
});

$(document).ready(
	src.timezoneEnableDateSelection
);

})(jQuery); // Avoid conflicts with other libraries
