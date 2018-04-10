// JavaScript Document
;
(function(app, $) {
	app.order_com = {
		init : function() {
			app.order_com.subForm();
		},

		subForm : function () {
			
			var $form = $("form[name='theForm']");
			var option = {
				
				submitHandler : function() {
					$form.ajaxSubmit({
						dataType : "json",
						success : function(data) {
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$form.validate(options);
		},
		
	};
})(ecjia.admin, jQuery);

// end