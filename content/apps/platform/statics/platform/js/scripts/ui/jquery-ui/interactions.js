/*=========================================================================================
    File Name: interactions.js
    Description: jQuery UI interactions
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function(){

	/********************************
	*			Draggable			*
	********************************/

	// Default
	$( ".draggable-ele" ).draggable({
		containment: ".draggable-container",
		scroll: false
	});

	// Vertically Draggable
	$( ".draggable-vert" ).draggable({
		axis: "y",
		containment: ".constrain-movement-container",
		scroll: false
	});

	// Horizontally Draggable
	$( ".draggable-horz" ).draggable({
		axis: "x",
		containment: ".constrain-movement-container",
		scroll: false
	});

	// Draggable in all the directions
	$( ".draggable-both" ).draggable({
		containment: ".constrain-movement-container",
		scroll: false
	});

	// Cursor Style Move While Dragging
	$( ".draggable-move" ).draggable({
		cursor: "move",
		cursorAt: { top: 56, left: 56 },
		containment: ".draggable-cursor-style",
		scroll: false
	});

	// Cursor Style crosshair
	$( ".draggable-crosshair" ).draggable({
		cursor: "crosshair",
		cursorAt: { top: -5, left: -5 },
		containment: ".draggable-cursor-style",
		scroll: false
	});

	// Cursor Style help
	$( ".draggable-help" ).draggable({
		cursor: "help",
		cursorAt: { bottom: 0 },
		containment: ".draggable-cursor-style",
		scroll: false
	});

	var $start_counter = $( ".draggable-start" ),
		$drag_counter = $( ".draggable-drag" ),
		$stop_counter = $( ".draggable-stop" ),
		counts = [ 0, 0, 0 ];

	// Drag Start
	$start_counter.draggable({
		start: function() {
			counts[ 0 ]++;
			updateCounterStatus( $start_counter, counts[ 0 ] );
		},
		containment: ".events-container",
		scroll: false
	});

	// Dragging
	$drag_counter.draggable({
		drag: function() {
			counts[ 1 ]++;
			updateCounterStatus( $drag_counter, counts[ 1 ] );
		},
		containment: ".events-container",
		scroll: false
	});

	// Drag Stop
	$stop_counter.draggable({
		stop: function() {
			counts[ 2 ]++;
			updateCounterStatus( $stop_counter, counts[ 2 ] );
		},
		containment: ".events-container",
		scroll: false
	});

	function updateCounterStatus( $event_counter, new_count ) {
		// first update the status visually...
		if ( !$event_counter.hasClass( "ui-state-hover" ) ) {
		$event_counter.addClass( "ui-state-hover" )
			.siblings().removeClass( "ui-state-hover" );
		}
		// ...then update the numbers
		$( "span.count", $event_counter ).text( new_count );
    }

    // Drag using text only
	$( ".draggable-text-ele" ).draggable({
		handle: ".draggable-text",
		containment: ".draggable-handles-container",
		scroll: false
	});

	// Drag using element
	$( ".draggable-elem" ).draggable({
		containment: ".draggable-handles-container",
		scroll: false
	});

	// Drag cancel
	$( ".draggable-cancel" ).draggable({
		cancel: ".draggable-cancel",
		containment: ".draggable-handles-container",
		scroll: false
	});

	// Return Draggable
	$( ".draggable-revert-orgi" ).draggable({
		revert: true,
		containment: ".return-draggable",
		scroll: false
	});

	// Return The Helper
	$( ".draggable-revert-helper" ).draggable({
		revert: true,
		helper: "clone",
		containment: ".return-draggable",
		scroll: false
	});

	/********************************
	*			Droppable			*
	********************************/

	// Draggable
	$( ".draggable-drop-ele" ).draggable({
		containment: ".droppable-container",
		scroll: false
	});

    $( ".droppable-ele" ).droppable({
		drop: function( event, ui ) {
			$( this )
				.addClass( "ui-state-highlight" )
				.find( "span" )
					.html( "Dropped!" );
		}
    });

    // Draggable Accept / Reject Elements
	$( ".droppable-accept, .droppable-reject" ).draggable({
		containment: ".accept-drop-container",
		scroll: false
	});

    $( ".droppable-accept-ele" ).droppable({
		accept: ".droppable-accept",
		classes: {
			"ui-droppable-active": "ui-state-active",
			"ui-droppable-hover": "ui-state-hover"
		},
		drop: function( event, ui ) {
			$( this )
				.addClass( "ui-state-highlight" )
				.find( "span" )
					.html( "Dropped!" );
		}
    });

    // Draggable Accept / Reject Elements
	$( ".valid-drop-revert" ).draggable({
		revert: "valid",
		containment: ".revert-droppable-container",
		scroll: false
	});

	$( ".invalid-drop-revert" ).draggable({
		revert: "invalid",
		containment: ".revert-droppable-container",
		scroll: false
	});

    $( ".revert-droppable-ele" ).droppable({
		classes: {
			"ui-droppable-active": "ui-state-active",
			"ui-droppable-hover": "ui-state-hover"
		},
		drop: function( event, ui ) {
			$( this )
				.addClass( "ui-state-highlight" )
				.find( "span" )
					.html( "Dropped!" );
		}
    });

    // Draggable feedback
	$( ".draggable-feedback" ).draggable({
		containment: ".visual-feedback-container",
		scroll: false
	});

	$( ".droppable-hover-feedback" ).droppable({
		classes: {
			"ui-droppable-hover": "ui-state-hover"
		},
		drop: function( event, ui ) {
		$( this )
			.addClass( "ui-state-highlight" )
			.find( "span" )
				.html( "Dropped!" );
		}
    });

    $( ".droppable-active-feedback" ).droppable({
		accept: ".draggable-feedback",
		classes: {
			"ui-droppable-active": "ui-state-default"
		},
		drop: function( event, ui ) {
		$( this )
			.addClass( "ui-state-highlight" )
			.find( "span" )
				.html( "Dropped!" );
		}
    });

	/********************************
	*			Resizable			*
	********************************/

	// Simple Resize
	$('.resize-ele').resizable();

	// Resize with animation
	$('.resize-animate').resizable({
		animate: true
	});

	// Constrain resize area
	$( ".resize-constrain" ).resizable({
		containment: ".resize-container"
    });

	// Resize hlper
	$( ".resize-aspect-ratio" ).resizable({
		aspectRatio: 16 / 9
    });

	/********************************
	*			Selectable			*
	********************************/

	// Simple Select
	$( ".selectable" ).selectable();

	// Serialize select
	$(".selectable-serialize").selectable({
		stop: function() {
			var result = $(".select-result").empty();
			$(".ui-selected", this).each(function() {
				var index = $(".selectable-serialize li").index(this);
				result.append(" #" + (index + 1));
			});
		}
	});

	/********************************
	*			Sortable			*
	********************************/

	// Simple Sort
	$( ".sortable" ).sortable();
	// Disable the selection for sort to work
    $( ".sortable" ).disableSelection();

    // Connect Lists
    $( ".connect-list1, .connect-list2" ).sortable({
      connectWith: ".connectedSortable"
    }).disableSelection();

    // Drop Placeholder
    $( ".sortable-placeholder" ).sortable({
      placeholder: "ui-state-highlight"
    });
    $( ".sortable-placeholder" ).disableSelection();

    // Sortable and disabled drop targets
    $( ".sortable-list1" ).sortable({
      items: "li:not(.ui-state-disabled)"
    });

    // Cancel sorting only
    $( ".sortable-list2" ).sortable({
      cancel: ".ui-state-disabled"
    });

    $( ".sortable-list1 li, .sortable-list2 li" ).disableSelection();
});