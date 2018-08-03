/*=========================================================================================
	File Name: input-groups.js
	Description: Input Groups js
	----------------------------------------------------------------------------------------
	Item Name: Robust - Responsive Admin Template
	Version: 2.0
	Author: PIXINVENT
	Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/

(function(window, document, $) {
	'use strict';
	var $html = $('html');

	// Default Spin
	$(".touchspin").TouchSpin({
		buttondown_class: "btn btn-primary",
		buttonup_class: "btn btn-primary",
		buttondown_txt: '<i class="ft-minus"></i>',
		buttonup_txt: '<i class="ft-plus"></i>'
	});

	//vertical TouchSpin
	$(".touchspin-vertical").TouchSpin({
		verticalbuttons: true,
		verticalupclass: 'fa fa-angle-up',
		verticaldownclass: 'fa fa-angle-down',
		buttondown_class: "btn btn-primary",
		buttonup_class: "btn btn-primary",
	});


	// Disable mousewheel
	$(".touchspin-stop-mousewheel").TouchSpin({
		mousewheel: false,
		buttondown_class: "btn btn-primary",
		buttonup_class: "btn btn-primary",
		buttondown_txt: '<i class="ft-minus"></i>',
		buttonup_txt: '<i class="ft-plus"></i>'
	});

	// Color Options
	$( ".touchspin-color" ).each(function( index ) {
		var down = "btn btn-primary",
		up = "btn btn-primary",
		$this = $(this);
		if($this.data('bts-button-down-class')){
			down = $this.data('bts-button-down-class');
		}
		if($this.data('bts-button-up-class')){
			up = $this.data('bts-button-up-class');
		}
		$this.TouchSpin({
			mousewheel: false,
			buttondown_class: down,
			buttonup_class: up,
			buttondown_txt: '<i class="ft-minus"></i>',
			buttonup_txt: '<i class="ft-plus"></i>'
		});
	});

})(window, document, jQuery);