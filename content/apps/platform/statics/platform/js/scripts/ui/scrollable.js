/*=========================================================================================
	File Name: scrollable.js
	Description: scrollabr intialisations
	----------------------------------------------------------------------------------------
	Item Name: Robust - Responsive Admin Template
	Version: 2.0
	Author: Pixinvent
	Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(document).ready(function(){

	// Vertical Scroll
	$('.vertical-scroll').perfectScrollbar({
		suppressScrollX : true,
        theme: 'dark',
        wheelPropagation: true
	});

	// Horizontal Scroll
	$('.horizontal-scroll').perfectScrollbar({
		suppressScrollY : true,
        theme: 'dark',
        wheelPropagation: true
	});

	// Both Side Scroll
	$('.both-side-scroll').perfectScrollbar({
        theme: 'dark',
        wheelPropagation: true
	});

	// Always Visible Scroll
	$('.visible-scroll').perfectScrollbar({
        theme: 'dark',
        wheelPropagation: true
	});

	// Minimum Scroll Length
	$('.min-scroll-length').perfectScrollbar({
        minScrollbarLength: 200,
        wheelPropagation: true
	});

	// Scrollbar Margins
	$('.scrollbar-margins').perfectScrollbar({
		wheelPropagation: true
	});

	// Default Handlers
	$('.default-handlers').perfectScrollbar({
		wheelPropagation: true
	});

	// No Keyboard
	$('.no-keyboard').perfectScrollbar({
		handlers: ['click-rail', 'drag-scrollbar', 'wheel', 'touch'],
		wheelPropagation: true
	});

	// Click and Drag
	$('.click-drag-handler').perfectScrollbar({
		handlers: ['click-rail', 'drag-scrollbar'],
		wheelPropagation: true
	});

	// Default Wheel Speed : 1
	$('.default-wheel-speed').perfectScrollbar({
		wheelPropagation: true
	});

	// Higher Wheel Speed : 10
	$('.higher-wheel-speed').perfectScrollbar({
		wheelSpeed: 10,
		wheelPropagation: true
	});

	// Lower Wheel Speed : 10
	$('.lower-wheel-speed').perfectScrollbar({
		wheelSpeed: 0.1,
		wheelPropagation: true
	});
});