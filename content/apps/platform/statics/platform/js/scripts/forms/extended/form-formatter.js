/*=========================================================================================
	File Name: form-formatter.js
	Description: Format user input to match a specified pattern.
	----------------------------------------------------------------------------------------
	Item Name: Robust - Responsive Admin Template
	Version: 2.0
	Author: GeeksLabs
	Author URL: http://www.themeforest.net/user/geekslabs
==========================================================================================*/
(function(window, document, $) {
	'use strict';

	// Date dd/mm/yyyy
	$('.date-formatter').formatter({
		'pattern': "{{99}}/{{99}}/{{9999}}"
	});

	//Phone mask
	$('.phone-formatter').formatter({
		'pattern': "({{999}}) {{999}}-{{9999}}"
	});

	// Another Date mm-dd-yyyy
	$('.international-formatter').formatter({
		'pattern': "+{{9}}({{999}}){{999}}-{{9999}}"
	});

	//Phone with extra
	$('.xphone-formatter').formatter({
		'pattern': "({{999}}) {{999}}-{{9999}} / {{a999999}}"
	});

	// Purchase Order
	$('.purchase-formatter').formatter({
		'pattern': "{{aaaa}} {{9999}}-{{****}}"
	});

	// Credit Card Number
	$('.cc-formatter').formatter({
		'pattern': "{{9999}} {{9999}} {{9999}} {{9999}}"
	});

	// SSN
	$('.ssn-formatter').formatter({
		'pattern': "{{999}}-{{99}}-{{9999}}"
	});

	// ISBN
	$('.isbn-formatter').formatter({
		'pattern': "{{999}}-{{99}}-{{999}}-{{9999}}-{{9}}"
	});

	// Currency in USD
	$('.currency-formatter').formatter({
		'pattern': "${{9999}}"
	});

	// Percentage
	$('.percentage-formatter').formatter({
		'pattern': "{{99}}%"
	});

	// Decimal
	$('.decimal-formatter').formatter({
		'pattern': "{{999}}.{{999999}}"
	});

})(window, document, jQuery);