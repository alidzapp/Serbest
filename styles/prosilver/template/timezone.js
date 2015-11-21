/* global src */

(function($) { // Avoid conflicts with other libraries

'use strict';

$('#tz_date').change(function() {
	src.timezoneSwitchDate(false);
});

$('#tz_select_date_suggest').click(function(){
	src.timezonePreselectSelect(true);
});

$(function () {
	src.timezoneEnableDateSelection();
	src.timezonePreselectSelect($('#tz_select_date_suggest').attr('timezone-preselect') === 'true');
});

})(jQuery); // Avoid conflicts with other libraries
