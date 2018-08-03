/*=========================================================================================
    File Name: dialog-tooltips.js
    Description: jQuery UI dialogs and tooltips
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function(){

	/****************************
	*		Basic Dialogs		*
	****************************/

	$( ".default-dialog" ).dialog({
		autoOpen: false,
		width: 400,
	});
	$( ".animation-dialog" ).dialog({
		autoOpen: false,
		width: 400,
		show: {
			effect: "fade",
			duration: 400
		},
		hide: {
			effect: "explode",
			duration: 1000
		},
		modal: true
	});
	$( ".overlay-dialog" ).dialog({
		autoOpen: false,
		width: 400,
		modal: true
	});
	$( ".append-to-dialog" ).dialog({
		autoOpen: false,
		width: 400,
		appendTo: ".content-wrapper",
		modal: true
	});
	$( ".title-dialog" ).dialog({
		autoOpen: false,
		width: 400,
		title: "Dialog Title",
		modal: true
	});
	$( ".conf-modal-dialog" ).dialog({
		autoOpen: false,
		resizable: false,
		height: "auto",
		width: 400,
		modal: true,
		buttons: {
			"Delete all items": function() {
				$( this ).dialog( "close" );
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		},
	});
	$( ".buttons-dialog" ).dialog({
		autoOpen: false,
		height: "auto",
		width: 400,
		buttons: [{
			text: "Ok",
			click: function() {
				$(this).dialog("close");
			},
		}],
		modal: true
	});
	$( ".icons-buttons-dialog" ).dialog({
		autoOpen: false,
		height: "auto",
		width: 400,
		buttons: [{
			text: "Ok",
			icon: "ft-heart",
			click: function() {
				$(this).dialog("close");
			}
		}],
		modal: true
	});
	$( ".disable-escape-dialog" ).dialog({
		autoOpen: false,
		height: "auto",
		width: 400,
		closeOnEscape: false,
		modal: true
	});
	$( ".close-text-dialog" ).dialog({
		autoOpen: false,
		height: "auto",
		width: 400,
		closeText: "hide",
		modal: true
	});
	$( ".disable-drag-dialog" ).dialog({
		autoOpen: false,
		height: "auto",
		width: 400,
		draggable: false,
		modal: true
	});
	$( ".disable-resize-dialog" ).dialog({
		autoOpen: false,
		height: "auto",
		width: 400,
		resizable: false,
		modal: true
	});
	$( ".position-left-top-dialog" ).dialog({
		autoOpen: false,
		height: "auto",
		width: 400,
		position: { my: "left top", at: "left top", of: window },
		modal: true
	});
	$( ".position-right-top-dialog" ).dialog({
		autoOpen: false,
		height: "auto",
		width: 400,
		position: { my: "right top", at: "right top", of: window },
		modal: true
	});
	$( ".position-left-bottom-dialog" ).dialog({
		autoOpen: false,
		height: "auto",
		width: 400,
		position: { my: "left bottom", at: "left bottom", of: window },
		modal: true
	});

	/********************************
	*		Open Basic Dialogs		*
	********************************/
	$( ".default-dialog-btn" ).on("click",function(){
		$( ".default-dialog" ).dialog("open");
	});
	$( ".animation-dialog-btn" ).on("click",function(){
		$( ".animation-dialog" ).dialog("open");
	});
	$( ".overlay-dialog-btn" ).on("click",function(){
		$( ".overlay-dialog" ).dialog("open");
	});
	$( ".append-to-dialog-btn" ).on("click",function(){
		$( ".append-to-dialog" ).dialog("open");
	});
	$( ".title-dialog-btn" ).on("click",function(){
		$( ".title-dialog" ).dialog("open");
	});
	$( ".conf-modal-dialog-btn" ).on("click",function(){
		$( ".conf-modal-dialog" ).dialog("open");
	});
	$( ".buttons-dialog-btn" ).on("click",function(){
		$( ".buttons-dialog" ).dialog("open");
	});
	$( ".icons-buttons-dialog-btn" ).on("click",function(){
		$( ".icons-buttons-dialog" ).dialog("open");
	});
	$( ".disable-escape-dialog-btn" ).on("click",function(){
		$( ".disable-escape-dialog" ).dialog("open");
	});
	$( ".close-text-dialog-btn" ).on("click",function(){
		$( ".close-text-dialog" ).dialog("open");
	});
	$( ".disable-drag-dialog-btn" ).on("click",function(){
		$( ".disable-drag-dialog" ).dialog("open");
	});
	$( ".disable-resize-dialog-btn" ).on("click",function(){
		$( ".disable-resize-dialog" ).dialog("open");
	});
	$( ".position-left-top-dialog-btn" ).on("click",function(){
		$( ".position-left-top-dialog" ).dialog("open");
	});
	$( ".position-right-top-dialog-btn" ).on("click",function(){
		$( ".position-right-top-dialog" ).dialog("open");
	});
	$( ".position-left-bottom-dialog-btn" ).on("click",function(){
		$( ".position-left-bottom-dialog" ).dialog("open");
	});


	/************************************
	*		Dialogs Height - Width		*
	************************************/
	$( ".height-dialog" ).dialog({
		autoOpen: false,
		height: 400,
		modal: true
	});

	$( ".width-dialog" ).dialog({
		autoOpen: false,
		width: 500,
		modal: true
	});

	$( ".max-height-dialog" ).dialog({
		autoOpen: false,
		maxHeight: 400,
		modal: true
	});

	$( ".max-width-dialog" ).dialog({
		autoOpen: false,
		maxWidth: 600,
		modal: true
	});

	$( ".min-height-dialog" ).dialog({
		autoOpen: false,
		minHeight: 200,
		modal: true
	});

	$( ".min-width-dialog" ).dialog({
		autoOpen: false,
		minWidth: 200,
		modal: true
	});

	$( ".percent-width-dialog" ).dialog({
		autoOpen: false,
		width: '50%',
		modal: true
	});

	$( ".full-width-dialog" ).dialog({
		autoOpen: false,
		width: '95%',
		modal: true
	});

	/****************************************
	*		Open Height- Width Dialogs		*
	****************************************/
	$( ".height-dialog-btn" ).on("click",function(){
		$( ".height-dialog" ).dialog("open");
	});

	$( ".width-dialog-btn" ).on("click",function(){
		$( ".width-dialog" ).dialog("open");
	});

	$( ".max-height-dialog-btn" ).on("click",function(){
		$( ".max-height-dialog" ).dialog("open");
	});

	$( ".max-width-dialog-btn" ).on("click",function(){
		$( ".max-width-dialog" ).dialog("open");
	});

	$( ".min-height-dialog-btn" ).on("click",function(){
		$( ".min-height-dialog" ).dialog("open");
	});

	$( ".min-width-dialog-btn" ).on("click",function(){
		$( ".min-width-dialog" ).dialog("open");
	});

	$( ".percent-width-dialog-btn" ).on("click",function(){
		$( ".percent-width-dialog" ).dialog("open");
	});

	$( ".full-width-dialog-btn" ).on("click",function(){
		$( ".full-width-dialog" ).dialog("open");
	});

	/****************************
	*		Form Dialogs		*
	****************************/
	$( ".basic-form-dialog" ).dialog({
		autoOpen: false,
		width: 400,
		modal: true
	});

	$( ".grid-form-dialog" ).dialog({
		autoOpen: false,
		width: 500,
		modal: true
	});

	$( ".inline-form-dialog" ).dialog({
		autoOpen: false,
		width: 550,
		modal: true
	});

	/********************************
	*		Open Form Dialogs		*
	********************************/
	$( ".basic-form-dialog-btn" ).on("click",function(){
		$( ".basic-form-dialog" ).dialog("open");
	});

	$( ".grid-form-dialog-btn" ).on("click",function(){
		$( ".grid-form-dialog" ).dialog("open");
	});

	$( ".inline-form-dialog-btn" ).on("click",function(){
		$( ".inline-form-dialog" ).dialog("open");
	});



	/********************************
	*			Tooltips			*
	********************************/
	$( ".default-tooltip" ).tooltip();

	$( ".tooltip-content" ).tooltip({
		items: "[title]",
		content: "Awesome title!"
	});

	$( ".show-tooltip-animation" ).tooltip({
		show: {
			effect: "slideDown",
			delay: 250
		}
	});

	$( ".hide-tooltip-animation" ).tooltip({
		hide: {
			effect: "explode",
			delay: 250
		}
	});

	$( ".custom-tooltip-animation" ).tooltip({
		show: null,
		position: {
			my: "left top",
			at: "left bottom"
		},
		open: function( event, ui ) {
			ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
		}
	});

	$( ".tooltip-track-mouse" ).tooltip({
		track: true
	});

	$( ".tooltip-position-top" ).tooltip({
		position: { my: "center bottom-15", at: "center top" }
	});

	$( ".tooltip-position-right" ).tooltip({
		position: { my: "left+15 center", at: "right center" }
	});

	$( ".tooltip-position-bottom" ).tooltip({
		position: { my: "center top+15", at: "center bottom" }
	});

	$( ".tooltip-position-left" ).tooltip({
		position: { my: "right-15 center", at: "left center" }
	});

	$( ".tooltip-primary" ).tooltip({
		tooltipClass: "bg-primary",
		position: { my: "center top+15", at: "center bottom" }
	});

	$( ".tooltip-info" ).tooltip({
		tooltipClass: "bg-info",
		position: { my: "center top+15", at: "center bottom" }
	});

	$( ".tooltip-warning" ).tooltip({
		tooltipClass: "bg-warning",
		position: { my: "center top+15", at: "center bottom" }
	});

	$( ".tooltip-success" ).tooltip({
		tooltipClass: "bg-success",
		position: { my: "center top+15", at: "center bottom" }
	});

	$( ".tooltip-danger" ).tooltip({
		tooltipClass: "bg-danger",
		position: { my: "center top+15", at: "center bottom" }
	});
});