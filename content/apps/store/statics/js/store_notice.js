// JavaScript Document
;(function(app, $) {
	app.store_notice = {
			init : function() {
				app.store_notice.submit_form();
			},
			submit_form : function() {
				var $form = $("form[name='theForm']");
				var option = {
						rules : {
							title : { required : true }
						},
						messages : {
							title : { required : "请输入商家公告标题！" }
						},
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

//end