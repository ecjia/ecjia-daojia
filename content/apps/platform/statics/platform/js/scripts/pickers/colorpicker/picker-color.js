/*=========================================================================================
    File Name: picker-color.js
    Description: Bootstrap Color Picker , minicolors , spectrum js
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: GeeksLabs
    Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/

(function(window, document, $) {
	'use strict';

	/************  jQuery MiniColors  *************/

	$('.minicolors').each( function() {
		//
		// Dear reader, it's actually very easy to initialize MiniColors. For example:
		//
		//  $(selector).minicolors();
		//
		// The way I've done it below is just for the demo, so don't get confused
		// by it. Also, data- attributes aren't supported at this time...they're
		// only used for this demo.
		//
		$(this).minicolors({
			control: $(this).attr('data-control') || 'hue',
			defaultValue: $(this).attr('data-defaultValue') || '',
			format: $(this).attr('data-format') || 'hex',
			keywords: $(this).attr('data-keywords') || '',
			inline: $(this).attr('data-inline') === 'true',
			letterCase: $(this).attr('data-letterCase') || 'lowercase',
			opacity: $(this).attr('data-opacity'),
			position: $(this).attr('data-position') || 'bottom left',
			swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
			change: function(value, opacity) {
				if( !value ) return;
				if( opacity ) value += ', ' + opacity;
			},
			theme: 'bootstrap'
		});
	});

	/************  Specturm  *************/

	// Color palette
	var colorPalette = [
		["#000","#333","#666","#999","#bbb","#ddd","#f3f3f3","#fff"],
		["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
		["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
		["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
		["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
		["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
		["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
		["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
	]

	// Basic Picker
	$(".spectrum").spectrum();

	// Disabled Picker
	var isDisabled = true;

	// Toggle on icon click
	$(".disable-toggle").on('click', function() {
		if (isDisabled) {
			$(".spectrum-disabled").spectrum("enable");
		}
		else {
			$(".spectrum-disabled").spectrum("disable");
		}
		isDisabled = !isDisabled;
		return false;
	});
	$(".spectrum-disabled").spectrum({
		disabled: true
	});

	// Picker Color Option
	$(".spectrum-container-class").spectrum({
		containerClassName: 'bg-blue-grey'
	});

	// Change selector color
	$(".spectrum-replacer-class").spectrum({
		replacerClassName: 'bg-blue-grey',
	});

	// Clear selection
	$(".spectrum-clear").spectrum({
		allowEmpty: true
	});

	// Show initial color
	$(".spectrum-initial-color").spectrum({
		showInitial: true
	});

	// Show with input and initial color
	$(".spectrum-with-input").spectrum({
		showInitial: true,
		showInput: true
	});

	// Full featured color picker
	$(".spectrum-featured").spectrum({
		showInitial: true,
		showInput: true,
		showAlpha: true,
		allowEmpty: true
	});

	// Display alpha channel
	$(".spectrum-transparancy").spectrum({
		showAlpha: true
	});

	// Show color palette
	$(".spectrum-palette").spectrum({
		showPalette: true,
		palette: colorPalette
	});

	// Show Palette Only
	$(".showPaletteOnly").spectrum({
		showPaletteOnly: true,
		showPalette:true,
		palette: colorPalette
	});

	// Toggle Palette Only
	$(".togglePaletteOnly").spectrum({
		showPaletteOnly: true,
		togglePaletteOnly: true,
		togglePaletteMoreText: 'View More',
		togglePaletteLessText: 'Show Less',
		palette: colorPalette
	});

	// Show Selection Palette
	$(".showSelectionPalette").spectrum({
		showPalette: true,
		showSelectionPalette: true, // true by default
		palette: [ ]
	});

	// Preffered Format

	$(".preferredHex").spectrum({
		preferredFormat: "hex",
		showInput: true,
		showPalette: true,
		palette: [["red", "rgba(0, 255, 0, .5)", "rgb(0, 0, 255)"]]
	});
	$(".preferredHex3").spectrum({
		preferredFormat: "hex3",
		showInput: true,
		showPalette: true,
		palette: [["red", "rgba(0, 255, 0, .5)", "rgb(0, 0, 255)"]]
	});
	$(".preferredHsl").spectrum({
		preferredFormat: "hsl",
		showInput: true,
		showPalette: true,
		palette: [["red", "rgba(0, 255, 0, .5)", "rgb(0, 0, 255)"]]
	});
	$(".preferredRgb").spectrum({
		preferredFormat: "rgb",
		showInput: true,
		showPalette: true,
		palette: [["red", "rgba(0, 255, 0, .5)", "rgb(0, 0, 255)"]]
	});
	$(".preferredName").spectrum({
		preferredFormat: "name",
		showInput: true,
		showPalette: true,
		palette: [["red", "rgba(0, 255, 0, .5)", "rgb(0, 0, 255)"]]
	});
	$(".preferredNone").spectrum({
		showInput: true,
		showPalette: true,
		palette: [["red", "rgba(0, 255, 0, .5)", "rgb(0, 0, 255)"]]
	});

	/* Events*/

	// Show event
	$(".showEvent").spectrum({
		show: function(c) {
			var label = $(".show-result");
			label.removeClass('hidden').html('Show called: ' + '<span class="text-semibold">' + c.toHexString() + '</span>');
		}
	});

	// Drag start event
	$(".dragStart").spectrum();
	// Attach event
	$(".dragStart").on("dragstart.spectrum", function (e, c) {
		var label = $(".drag-result");
		label.removeClass('hidden').html('Dragstart called: ' + '<span class="text-semibold">' + c.toHexString() + '</span>');
	});

	// Move event
	$(".moveEvent").spectrum({
		move: function(c) {
			var label = $(".move-result");
			label.removeClass('hidden').html('Move called: ' + '<span class="text-semibold">' + c.toHexString() + '</span>');
		}
	});

	// Basic Flat Picker
	$(".flatPicker").spectrum({
		flat: true
	});

	// Flat color palette
	$(".flatPalette").spectrum({
		flat: true,
		showPalette: true,
		showPaletteOnly: true,
		togglePaletteOnly: true,
		togglePaletteMoreText: 'Show Picker',
		togglePaletteLessText: 'Hide Picker',
		palette: colorPalette
	});

	// Full featued flat picker
	$(".flatFeaturedPicker").spectrum({
		flat: true,
		showInitial: true,
		showInput: true,
		showAlpha: true,
		allowEmpty: true
	});

})(window, document, jQuery);