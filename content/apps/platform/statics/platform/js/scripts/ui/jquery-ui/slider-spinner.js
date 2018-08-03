/*=========================================================================================
    File Name: slider-spinner.js
    Description: jQuery UI sliders and spinners
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function(){

	/****************************
	*			Slider			*
	*****************************/

	// Default
	$( ".jui-slider-default" ).slider();

	$( ".jui-slider-custom-start" ).slider({
		value: 60
	});

	$( ".jui-slider-increment-steps" ).slider({
		value:20,
        min: 0,
        max: 100,
        step: 5
	});

	$( ".jui-slider-animation" ).slider({
		value:40,
        min: 0,
        max: 100,
		animate: "fast"
	});

	// Fixed minimum
    $(".jui-slider-min").slider({
        range: "min",
        value: 15,
        min: 1,
        max: 150
    });

    // Fixed maximum
    $(".jui-slider-max").slider({
        range: "max",
        min: 1,
        max: 100,
        value: 10
    });

	$( ".jui-slider-range" ).slider({
		range: true,
		min: 0,
		max: 500,
		values: [ 75, 300 ],
	});

	$( ".jui-slider-disabled" ).slider({
		value: 20,
		disabled: true
	});

	/************************************
	*			Advance Sliders			*
	************************************/
	// Show All Labels
	$(".jui-slider-all-labels")
    .slider({
        max: 12
    })
    .slider("pips", {
        rest: "label"
    });

    // Hide Labels & Pips
    $(".jui-slider-hide-labels-pips")
    .slider({
        max: 20,
        range: true,
        values: [5, 15]
    })
    .slider("pips", {
        rest: false
    });

    // Only Show Pips
    $(".jui-slider-only-pips")
    .slider({
        max: 30
    })
    .slider("pips", {
        first: "pip",
        last: "pip"
    });

    // Prefix / Suffix
    $(".jui-slider-prefix-suffix")
    .slider({
        min: 0,
        max: 90,
        value: 50,
        step: 10
    })
    .slider("pips", {
        rest: "label",
        prefix: "$",
        suffix: ".00¢"
    });

    // Months
    // set up an array to hold the months
	var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	// lets be fancy for the demo and select the current month.
	var activeMonth = new Date().getMonth();

	$(".jui-slider-months")

    // activate the slider with options
    .slider({
        min: 0,
        max: months.length-1,
        value: activeMonth
    })

    // add pips with the labels set to "months"
    .slider("pips", {
        rest: "label",
        labels: months
    });

    // More Custom Labels
    var hanzi = ["一", "二", "三", "四", "五", "六", "七", "八", "九", "十"];

	$(".jui-slider-more-custom-labels")

    .slider({
        min: 0,
        max: hanzi.length-1,
        value: 3
    })

    .slider("pips", {
        rest: "label",
        labels: hanzi
    })

    .slider("float", {
        labels: hanzi
    });

    // Steps
    $(".jui-slider-pip-steps")

    .slider({
        min: 0,
        max: 100,
        step: 20
    })

    .slider("pips", {
        rest: "label"
    });

    $(".jui-slider-multiplicative-steps")

	.slider({
		min: 0,
		max: 100,
		step: 10
	})

	.slider("pips", {
		rest: "label",
		step: 2
	})

	.slider("float");

	/************************************
	*			Vertical Sliders		*
	************************************/
	// Default
    $(".jui-vert-slider-default > span").each(function() {

        // Read initial values
        var val = parseInt( $( this ).text(), 10 );

        // Empty span text
        $( this ).empty();

        $( this ).slider({
            value: val,
            animate: "fast",
            orientation: "vertical"
        });
    });


    // Min Range slider
    $(".jui-vert-min-range-slider > span").each(function() {

        // Read initial values
        var val = parseInt( $( this ).text(), 10 );

        // Empty span text
        $( this ).empty();

        $( this ).slider({
            value: val,
            range: "min",
            animate: true,
            orientation: "vertical"
        }).slider('float');
    });

    // Max Range slider
    $(".jui-vert-max-range-slider > span").each(function() {

        // Read initial values
        var val = parseInt( $( this ).text(), 10 );

        // Empty span text
        $( this ).empty();

        $( this ).slider({
            value: val,
            range: "max",
            animate: true,
            orientation: "vertical"
        }).slider('float');
    });

    /********************************************
	*			Vertical Advance Sliders		*
	********************************************/
	// Only Pips
    $(".jui-vert-slider-pips > span").each(function() {
        var val = parseInt($(this).text(), 10);

        $(this).empty();

        $(this).slider({
            min: 0,
            max: 25,
            value: val,
            animate: "fast",
            range: 'min',
            orientation: "vertical"
        });
    });
    $(".jui-vert-slider-pips > span").slider("pips", {
        first: "pip",
        last: "pip"
    });
    $(".jui-vert-slider-pips > span").slider("float");


    // With labels
    $( ".jui-vert-slider-pips-lables > span" ).each(function() {
        var val = parseInt($(this).text(), 10);

        $(this).empty();

        $(this).slider({
            min: 0,
            max: 8,
            value: val,
            animate: "fast",
            range: 'min',
            orientation: "vertical"
        });
    });
    $(".jui-vert-slider-pips-lables > span").slider("pips" , {
        rest: "label"
    });
    $(".jui-vert-slider-pips-lables > span").slider("float");


    // Hide Labels & Pips
    $( ".jui-vert-hide-label-pip > span" ).each(function() {
        var val = parseInt($(this).text(), 10);
        $(this).empty();
        $(this).slider({
            min: 0,
            max: 10,
            value: val,
            animate: "fast",
            range: 'min',
            orientation: "vertical"
        });
    });
    $(".jui-vert-hide-label-pip > span").slider("pips",{
		rest: false
    });
    $(".jui-vert-hide-label-pip > span").slider("float");

    /********************************************
	*			Vertical Sliders Sizing			*
	********************************************/
    $(".jui-vert-slider-size-default > span").each(function() {

        // Read initial values
        var val = parseInt( $( this ).text(), 10 );

        // Empty span text
        $( this ).empty();

        $( this ).slider({
            value: val,
            range: "min",
            animate: true,
            orientation: "vertical"
        }).slider('float');
    });

    $(".jui-vert-slider-size-pips > span").each(function() {

        // Read initial values
        var val = parseInt( $( this ).text(), 10 );

        // Empty span text
        $( this ).empty();

        $( this ).slider({
			min: 0,
            max: 10,
            value: val,
            range: "min",
            animate: true,
            orientation: "vertical"
        })
		.slider('pips')
		.slider('float');
    });

    // Fixed maximum
    $(".ui-slider-vertical-range-max > span").each(function() {

        // Read initial values from markup and remove that
        var value = parseInt( $( this ).text(), 10 );
        $( this ).empty().slider({
            value: value,
            range: "max",
            animate: true,
            orientation: "vertical"
        });
    });


    // Default handle
    $(".ui-slider-vertical-handle-default > span").each(function() {

        // Read initial values from markup and remove that
        var value = parseInt( $( this ).text(), 10 );
        $( this ).empty().slider({
            value: value,
            range: "min",
            animate: true,
            orientation: "vertical"
        });
    });

	/************************************
	*			Color Sliders			*
	************************************/
	$( ".jui-default-color-slider, .jui-primary-color-slider, .jui-info-color-slider, .jui-success-color-slider, .jui-warning-color-slider, .jui-danger-color-slider" ).slider({
		range: true,
		min: 0,
		max: 500,
		values: [ 100, 400 ],
	});

	/************************************
	*			Sliders	Sizing			*
	************************************/

	$( ".jui-slider-sizing-xl, .jui-slider-sizing-lg, .jui-slider-sizing-default, .jui-slider-sizing-sm, .jui-slider-sizing-xs" ).slider({
		range: true,
		min: 0,
		max: 500,
		values: [ 100, 400 ],
	});

	// With Pips & Float
	$( ".jui-slider-sizing-pips-xl, .jui-slider-sizing-pips-lg, .jui-slider-sizing-pips-default, .jui-slider-sizing-pips-sm, .jui-slider-sizing-pips-xs" )
    .slider({
        max: 50,
        min: 0,
        range: true,
        values: [10, 40]
    })
    .slider("pips", {
        first: "pip",
        last: "pip"
    })
    .slider("float");



    /**********************************
    *           Progress Bars         *
    **********************************/
    $( ".pgbar-basic" ).progressbar({
        value: 67
    });

    $( ".pgbar-striped" ).progressbar({
        value: 34
    });

    $( ".pgbar-striped-animated" ).progressbar({
        value: 86
    });

    $( ".pgbar-custom-label" ).progressbar({
        value: 67
    });

    var progressbar = $(".pgbar-custom-label-bar"),
        progressLabel = $(".pgbar-custom-label");

    progressbar.progressbar({
        value: false,
        change: function() {
            progressLabel.text(progressbar.progressbar("value") + "%");
        },
        complete: function() {
            progressLabel.text("Complete!");
        }
    });

    function progress() {
        var val = progressbar.progressbar("value") || 0;

        progressbar.progressbar("value", val + 2);

        if (val < 99) {
            setTimeout(progress, 80);
        }
    }

    setTimeout(progress, 2000);

    $( ".pgbar-max" ).progressbar({
        max: 1024,
        value: 840
    });

    $( ".pgbar-disabled" ).progressbar({
        disabled: true,
        value: 86
    });




	/****************************
	*			Spinner			*
	*****************************/

	// Default
	$( ".jui-spinner-default" ).spinner();

	// Decimal
	$( ".jui-spinner-decimal" ).spinner({
		step: 0.01,
		numberFormat: "n"
    });

    $( ".change-decimal-culture" ).on( "change", function() {
		var current = $( ".jui-spinner-decimal" ).spinner( "value" );
		Globalize.culture( $(this).val() );
		$( ".jui-spinner-decimal" ).spinner( "value", current );
    });

    // Currency
    $( ".change-currency" ).on( "change", function() {
		$( ".jui-spinner-currency" ).spinner( "option", "culture", $( this ).val() );
    });

    $( ".jui-spinner-currency" ).spinner({
		min: 5,
		max: 2500,
		step: 25,
		start: 1000,
		numberFormat: "C"
    });

    // Max
    $( ".jui-spinner-max" ).spinner({
		max: 50
	});

	// Min
    $( ".jui-spinner-min" ).spinner({
		min: 5
	});

    // Overflow
    $(".jui-spinner-overflow").spinner({
		spin: function(event, ui) {
			if (ui.value > 10) {
				$(this).spinner("value", -10);
				return false;
			} else if (ui.value < -10) {
				$(this).spinner("value", 10);
				return false;
			}
		}
	});

	// Time
	$.widget("ui.timespinner", $.ui.spinner, {
		options: {
			// seconds
			step: 60 * 1000,
			// hours
			page: 60
		},

		_parse: function(value) {
			if (typeof value === "string") {
				// already a timestamp
				if (Number(value) == value) {
					return Number(value);
				}
				return +Globalize.parseDate(value);
			}
			return value;
		},

		_format: function(value) {
			return Globalize.format(new Date(value), "t");
		}
	});

	$(".jui-spinner-time").timespinner();

	$(".change-time-culture").on("change", function() {
		var current = $(".jui-spinner-time").timespinner("value");
		Globalize.culture($(this).val());
		$(".jui-spinner-time").timespinner("value", current);
	});

	// Set Value
	$( '.jui-spinner-set-value' ).spinner();
	$( ".spinner-set-value-btn" ).on( "click", function() {
		$( '.jui-spinner-set-value' ).spinner( "value", 5 );
    });

	// Step
	$( ".jui-spinner-steps" ).spinner({
		step: 10
	});

	// Change Buttons
	$.widget( "ui.customspinner", $.ui.spinner, {
		_buttonHtml: function() {
			return "" +
				"<a tabindex='-1' aria-hidden='true' class='ui-spinner-button ui-spinner-up btn-success' role='button'>" +
					"<span class='ui-button-icon ui-icon'></span>" +
					"<span class='ui-button-icon-space'></span>" +
				"</a>" +
				"<a tabindex='-1' aria-hidden='true' class='ui-spinner-button ui-spinner-up btn-danger' role='button'>" +
					"<span class='ui-button-icon ui-icon'></span>" +
					"<span class='ui-button-icon-space'></span>" +
				"</a>";
		}
	});
	$( ".jui-spinner-color-buttons" ).customspinner();

    // Disabled
    $( ".jui-spinner-disabled" ).spinner({
		disabled: true
    });
});