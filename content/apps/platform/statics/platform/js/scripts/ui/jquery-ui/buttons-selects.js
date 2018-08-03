/*=========================================================================================
    File Name: buttons-selects.js
    Description: jQuery UI buttons-selects
    ----------------------------------------------------------------------------------------
    Item Name: Robust - Responsive Admin Template
    Version: 2.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

$(document).ready(function(){

	/********************************
	*			Buttons				*
	********************************/

	// Default
	$( ".jui-btn-default, .jui-input-btn-default, .jui-anchor-default" ).button();

	/****************************************
	*			Checkbox & Radios			*
	****************************************/
	$( ".jui-radio-buttons, .jui-checkbox, .jui-nested-checkbox" ).checkboxradio();
	$( ".jui-ni-radio-buttons, .jui-ni-checkbox, .jui-ni-nested-checkbox" ).checkboxradio({
		icon: false
	});

	/********************************
	*			Selects				*
	********************************/

	// Default
	$( ".jui-select-default, .jui-select-categories" ).selectmenu({
		width: '100%'
	});

	// Select Number
	$( ".jui-select-number" )
		.selectmenu({
			width: '100%'
		})
		.selectmenu( "menuWidget" )
		.addClass( "overflow" );

	$( ".jui-select-salutation" ).selectmenu({
		width: '100%'
	});

	$.widget("custom.iconselectmenu", $.ui.selectmenu, {
		_renderItem: function(ul, item) {
			var li = $("<li>"),
				wrapper = $("<div>", {
					text: item.label
				});

			if (item.disabled) {
				li.addClass("ui-state-disabled");
			}

			$("<span>", {
				style: item.element.attr("data-style"),
				"class": "ui-icon " + item.element.attr("data-class")
			})
			.appendTo(wrapper);

			return li.append(wrapper).appendTo(ul);
		}
	});

	$( ".jui-select-podcasts" )
		.iconselectmenu({width: '100%'})
		.iconselectmenu( "menuWidget" )
			.addClass( "ui-menu-icons customicons" );

	// Disabled select
    $(".jui-select-disabled").selectmenu({
        width: '100%',
        disabled: true
    });
});