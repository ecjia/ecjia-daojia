/*=========================================================================================
    File Name: date-pickers.js
    Description: jQuery UI date pickers
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function(){

	/************************************
	*			Date Pickers			*
	************************************/

	// Default
	$( ".datepicker-default" ).datepicker();

    // Animations
    $( ".datepicker-animation" ).datepicker();

    // ANimations dropdown change event
    $( ".dp-animation" ).on( "change", function() {
        $( ".datepicker-animation" ).datepicker( "option", "showAnim", $( this ).val() );
    });

    // Dates in other months
    $( ".dp-other-month" ).datepicker({
        showOtherMonths: true,
        selectOtherMonths: true
    });

    // Display button bar
    $( ".dp-button-bar" ).datepicker({
        showButtonPanel: true
    });

    // Display button bar
    $( ".dp-inline" ).datepicker();

    // Display Month & Year Menu
    $( ".dp-month-year" ).datepicker({
        changeMonth: true,
        changeYear: true
    });

    // Display Multiple Months
    $( ".dp-multiple-months" ).datepicker({
        numberOfMonths: 3,
        showButtonPanel: true
    });

    // Constrain Input
    $( ".dp-constrain-input" ).datepicker({
        constrainInput: true,
    });

    // Year Range
    $( ".dp-year-range" ).datepicker({
        yearRange: "2015:2016"
    });

    // Step Months
    $( ".dp-step-months" ).datepicker({
        stepMonths: 3
    });
    // Formate date
    $( ".dp-format-date" ).datepicker();
    $( ".date-formats" ).on( "change", function() {
        $( ".dp-format-date" ).datepicker( "option", "dateFormat", $( this ).val() );
    });

    // Icon Trigger
    $( ".dp-icon-trigger" ).datepicker({
        showOn: "button",
        buttonImage: "../../../app-assets/images/jqueryui/calendar.png",
        buttonImageOnly: true,
        buttonText: "Select date"
    });

    // Populate Alternate Field
    $( ".dp-for-alternate" ).datepicker({
        altField: ".dp-alternate",
        altFormat: "DD, d MM, yy"
    });

    // Restrict Date Range
    $( ".dp-date-range" ).datepicker({
        minDate: -20,
        maxDate: "+1M +10D"
    });

    // Show Week Of The Year
    $( ".dp-week-year" ).datepicker({
        showWeek: true,
        firstDay: 1
    });

    // Select Date Range
    var dateFormat = "mm/dd/yy",
        from = $(".dp-date-range-from")
        .datepicker({
            defaultDate: "+1w",
            changeMonth: true,
        })
        .on("change", function() {
            to.datepicker("option", "minDate", getDate(this));
        }),
        to = $(".dp-date-range-to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
        })
        .on("change", function() {
            from.datepicker("option", "maxDate", getDate(this));
        });

    function getDate(element) {
        var date;
        try {
            date = $.datepicker.parseDate(dateFormat, element.value);
        } catch (error) {
            date = null;
        }

        return date;
    }

    // Apply Skin
	$('.ui-datepicker').wrap('<div class="dp-skin"/>');

});