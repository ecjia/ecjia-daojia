/*=========================================================================================
	File Name: form-validation.js
	Description: jquery bootsreap validation js
	----------------------------------------------------------------------------------------
	Item Name: Robust - Responsive Admin Template
	Version: 2.0
	Author: PIXINVENT
	Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

(function(window, document, $) {
	'use strict';

	// Input, Select, Textarea validations except submit button
	$("input,select,textarea").not("[type=submit]").jqBootstrapValidation();

	// Square Checkbox & Radio
    $('.skin-square input').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

	// Touch Spin
	$(".touchspin").TouchSpin();

	// Bootstrap Switch
	$(".switchBootstrap").bootstrapSwitch();

	var i = 0;
	if (Array.prototype.forEach) {
		var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery'));

		elems.forEach(function (html) {
			var switchery = new Switchery(html);
		});
	} else {
		var elems1 = document.querySelectorAll('.switchery');

		for (i = 0; i < elems1.length; i++) {
			var switchery = new Switchery(elems1[i]);
		}
	}
})(window, document, jQuery);