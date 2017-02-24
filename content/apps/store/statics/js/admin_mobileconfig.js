// JavaScript Document
;(function(app, $) {
	app.admin_mobileconfig = {
			init : function() {
				app.admin_mobileconfig.submit_form();
			},
			submit_form : function() {
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
			}
		}
})(ecjia.admin, jQuery);
// end
