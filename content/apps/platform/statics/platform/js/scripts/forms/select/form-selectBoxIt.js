/*=========================================================================================
    File Name: form-selectBoxIt.js
    Description: Select Box It select field js
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/
(function(window, document, $) {
	'use strict';

	//Default SelectBoxIt
	$(".selectBox").selectBoxIt();

	// Default Label
	$(".selectBox-label-default").selectBoxIt({
		defaultText: "No City Selected"
	});

	// Open / Close Effects
	$(".selectBox-effect").selectBoxIt({
		showEffect: "fadeIn",	// Uses the jQuery 'fadeIn' effect when opening the drop down
		showEffectSpeed: 400,	// Sets the jQuery 'fadeIn' effect speed to 400 milleseconds
		hideEffect: "fadeOut",	// Uses the jQuery 'fadeOut' effect when closing the drop down
		hideEffectSpeed: 400	// Sets the jQuery 'fadeOut' effect speed to 400 milleseconds
	});

	// open/close animation
	$(".selectBox-animation").selectBoxIt({
		showEffect: "shake",	// Uses the jQuery 'fadeIn' effect when opening the drop down
		showEffectSpeed: 'slow',
		showEffectOptions: { times: 1 },	// Sets jQueryUI options to shake 1 time when opening the drop down
		hideEffect: "puff",	// Uses the jQuery 'fadeOut' effect when closing the drop down
		hideEffectSpeed: 'slow'	// Sets the jQuery 'fadeOut' effect speed to 400 milleseconds
	});

	// Hide First field of select
	$(".selectBox-hide-first").selectBoxIt({
		showFirstOption: false
	});

	// Change down arrow icon
	$(".selectBox-right-icon").selectBoxIt({
		downArrowIcon: "ft-arrow-down ml-1"	// Set a custom down arrow icon by adding new CSS class(s)
	});

	// Change aggressive
	$(".selectBox-aggressive").selectBoxIt({
		aggressiveChange: true		// Sets default text to appear for the drop down
	});

	// Native Mouse mode
	$(".selectBox-native-mouse").selectBoxIt({
		nativeMousedown: true	// Sets default text to appear for the drop down
	});

	// Bootstrap Custom Icon
	$('.selectboxit-arrow-container i').addClass("caret");
	$(".bootstrap-icon").bind({
		// Binds to the 'open' event on the original select box
		"open": function() {
			// Adds the Twitter Bootstrap 'dropup' class to the drop down
			$(this).data("selectBox-selectBoxIt").dropdown.addClass("dropup");
		},

		// Binds to the 'close' event on the original select box
		"close": function() {
			// Removes the Twitter Bootstrap 'dropup' class from the drop down
			$(this).data("selectBox-selectBoxIt").dropdown.removeClass("dropup");
		}
	});

	// Custom Bootstrap Up/Down Icon
	$(".custom-bootstrap-icon").selectBoxIt({
		downArrowIcon: "icon-hand-o-down"
	});
	$(".custom-bootstrap-icon").bind({

		"open": function() {
			$(this).data("selectBox-selectBoxIt").dropdown.find('.selectboxit-arrow-container i').removeClass();
			$(this).data("selectBox-selectBoxIt").dropdown.find('.selectboxit-arrow-container i').addClass('selectboxit-arrow icon-hand-o-up');
		},

		"close": function() {
			$(this).data("selectBox-selectBoxIt").dropdown.find('.selectboxit-arrow-container i').removeClass();
			$(this).data("selectBox-selectBoxIt").dropdown.find('.selectboxit-arrow-container i').addClass('selectboxit-arrow icon-hand-o-down');
		}
	});

	// Popover Tooltip
	$("[data-toggle='popover']").popover({ trigger: "hover", container: "body" });


	// Add options dynamically
	$(".selectBox.options-dynamic").data("selectBox-selectBoxIt").add({
		value: "London",
		text: "London"
	});

	// Remove first option dynamically
	$(".selectBox.option-remove").data("selectBox-selectBoxIt").remove(0);

	// Remove multiple options dynamically
	$(".selectBox.options-remove").data("selectBox-selectBoxIt").remove([0,1,2]);

	// Remove all options dynamically
	$('#remove-all').on('click', function() {
		$(".selectBox.remove-all").data("selectBox-selectBoxIt").remove();
	});

	// Hide current selected option
	$(".selectBox-hide-current").selectBoxIt({
		hideCurrent: true // Hides the currently selected option from appearing when the drop down is opened
	});

	// Single object
	$(".selectBox-single-object").selectBoxIt({
		// Populates the drop down using an array of strings
		populate: {
			value: "This is SelectBoxIt.",
			text: "This is SelectBoxIt."
		}
	});

	// HTML string
	$(".selectBox-html-string").selectBoxIt({
		populate: '<option value="No City Selected">No City Selected</option>' +
			'<option value="1">Amsterdam</option>'+
			'<option value="2">Antwerp</option>'+
			'<option value="3">Athens</option>'+
			'<option value="4">Barcelona</option>'+
			'<option value="5">Berlin</option>'
	});

	// Strings Array
	$(".selectBox-strings-array").selectBoxIt({
		populate: [
			"No City Selected",
			"Amsterdam",
			"Antwerp",
			"Athens",
			"Barcelona",
			"Berlin"
		]
	});

	// Array of objects
	$(".selectBox-objects-array").selectBoxIt({
		populate: [
			{value: "No City Selected", text: "No City Selected"},
			{value: "Amsterdam", text: "Amsterdam"},
			{value: "Antwerp", text: "Antwerp"},
			{value: "Athens", text: "Athens"},
			{value: "Barcelona", text: "Barcelona"},
			{value: "Berlin", text: "Berlin"}
		]
	});

	// JSON array
	$(".selectBox-json-array").selectBoxIt({
		populate: {"data": [
			{"text":"No City Selected","value":"No City Selected"},
			{"text":"Amsterdam","value":"Amsterdam"},
			{"text":"Antwerp","value":"Antwerp"},
			{"text":"Athens","value":"Athens"},
			{"text":"Barcelona","value":"Barcelona"},
			{"text":"Berlin","value":"Berlin"}
		]}
	});

	// jQuery deferred object
	$(".selectBox-deferred-object").selectBoxIt({
		autoWidth: false,
		defaultText: "Mojombo Github Repos",

		// Fills the drop down using a jQuery deferred object
		populate: function() {
			var deferred = $.Deferred(),
				arr = [],
				x = -1;
			$.ajax({
				url: 'https://api.github.com/users/mojombo/repos'
			}).done(function(data) {
				while(++x < data.length) {
					arr.push(data[x].name);
				}
				deferred.resolve(arr);
			});
			return deferred;
		}
	});
})(window, document, jQuery);
