/*=========================================================================================
    File Name: navigations.js
    Description: jQuery UI navigations
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function(){

	/********************************
	*			Accordion			*
	********************************/

	// Default
	$( ".accordion-default" ).accordion();

	// Collapsible
	$( ".accordion-collapsible" ).accordion({
		collapsible: true
	});

	// No Auto Height
	$( ".accordion-height" ).accordion({
		heightStyle: "content"
    });

    // Sortable
    $(".accordion-sortable")
    .accordion({
		collapsible: true,
		heightStyle: "content",
        header: "> div > h3"
    })
    .sortable({
        axis: "y",
        handle: "h3",
        stop: function(event, ui) {
            // IE doesn't register the blur when sorting
            // so trigger focusout handlers to remove .ui-state-focus
            ui.item.children("h3").triggerHandler("focusout");

            // Refresh accordion to handle new order
            $(this).accordion("refresh");
        }
    });


    /************************************
    *               Menu				*
	************************************/

    // Default Menu
    $(".menu-default, .disabled-menu-items").menu();

    // Dsiabled Menu
    $(".menu-disabled").menu({
        disabled: true
    });

    $(".menu-category-header").menu({
        items: "> :not(.ui-widget-header)"
    });

    $(".menu-icons").menu({
        items: "> :not(.ui-widget-header)"
    });

    $(".menu-header-icons").menu({
        items: "> :not(.ui-widget-header)"
    });


    /************************************
    *               Tabs                *
    ************************************/

    // Default Tabs
    $( ".tabs-default" ).tabs();

    // Collapse Tabs
    $( ".tabs-collapse" ).tabs({
        collapsible: true
    });

    // Open on mouse over
    $( ".tabs-mouseover" ).tabs({
        event: "mouseover"
    });

    // Sortable Tabs
    var tabs = $( ".tabs-sortable" ).tabs();
    tabs.find( ".ui-tabs-nav" ).sortable({
      axis: "x",
      stop: function() {
        tabs.tabs( "refresh" );
      }
    });
});