/*=========================================================================================
	File Name: tooltip.js
	Description: Tooltips are an updated version, which don’t rely on images, 
				use CSS3 for animations, and data-attributes for local title storage.
	----------------------------------------------------------------------------------------
	Item Name: Robust - Responsive Admin Template
	Version: 2.0
	Author: Pixinvent
	Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/
	(function(window, document, $) {
	'use strict';

	/******************/
	// Tooltip events //
	/******************/

	// onShow event
	$('#show-tooltip').tooltip({
		title: 'Tooltip Show Event',
		trigger: 'click',
		placement: 'right'
		}).on('show.bs.tooltip', function() {
			alert('Show event fired.');
	});

	// onShown event
	$('#shown-tooltip').tooltip({
		title: 'Tooltip Shown Event',
		trigger: 'click',
		placement: 'top'
	}).on('shown.bs.tooltip', function() {
		alert('Shown event fired.');
	});

	// onHide event
	$('#hide-tooltip').tooltip({
		title: 'Tooltip Hide Event',
		trigger: 'click',
		placement: 'bottom'
	}).on('hide.bs.tooltip', function() {
		alert('Hide event fired.');
	});

	// onHidden event
	$('#hidden-tooltip').tooltip({
		title: 'Tooltip Hidden Event',
		trigger: 'click',
		placement: 'left'
	}).on('hidden.bs.tooltip', function() {
		alert('Hidden event fired.');
	});


	/*******************/
	// Tooltip methods //
	/*******************/

	// Show method
	$('#show-method').on('click', function() {
		$(this).tooltip('show');
	});
	// Hide method
	$('#hide-method').on('mouseenter', function() {
		$(this).tooltip('show');
	});
	$('#hide-method').on('click', function() {
		$(this).tooltip('hide');
	});
	// Toggle method
	$('#toggle-method').on('click', function() {
		$(this).tooltip('toggle');
	});
	// Dispose method
	$('#dispose').on('click', function() {
		$('#dispose-method').tooltip('dispose');
	});

	/* Trigger*/
	$('.manual').on('click', function() {
		$(this).tooltip('show');
	});
	$('.manual').on('mouseout', function() {
		$(this).tooltip('hide');
	});

	/* Default template */
	$(".template").on('click', function(){
		console.log(
			'<div class="tooltip" role="tooltip">' +
			'<div class="tooltip-arrow"></div>' +
			'<div class="tooltip-inner"></div>' +
			'</div>'
		);
	});

	// Custom Tooltip
	$("[data-popup=tooltip-custom]").on('shown.bs.tooltip', function(){
		var bg = "",
		text = "",
		bgClass = "",
		textClass = "",
		$this = $(this);
		if($this.data("bg-color") !== undefined){
			bg = $this.data("bg-color");
			bgClass = "tooltip-bg-" +bg;
			$('.tooltip').addClass(bgClass);
		}
		if($this.data("text-color") !== undefined){
			text = $this.data("text-color");
			textClass = "tooltip-text-" +text;
			$('.tooltip').addClass(textClass);
		}
	});
	$("[data-popup=tooltip-custom]").on('hidden.bs.tooltip', function(){
		var bg = "",
		text = "",
		bgClass = "",
		textClass = "",
		$this = $(this);
		if($this.data("bg-color") !== undefined){
			bg = $this.data("bg-color");
			bgClass = "tooltip-bg-" +bg;
			$('.tooltip').removeClass(bgClass);
		}
		if($this.data("text-color") !== undefined){
			text = $this.data("text-color");
			textClass = "tooltip-text-" +text;
			$('.tooltip').removeClass(textClass);
		}
	});
})(window, document, jQuery);