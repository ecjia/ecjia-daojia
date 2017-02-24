// JavaScript Document
;(function(app, $) {
	/* **编辑** */
	app.oauth_edit = {
			init : function() {
				$(".ajaxswitch").on('click', function(e){
					e.preventDefault();
					var url = $(this).attr('href');
					$.get(url, function(data){
						ecjia.admin.showmessage(data);
					}, 'json');
				});	
				app.oauth_edit.submit_form();
			},
			submit_form : function(formobj) {
				var $form = $("form[name='theForm']");
				var option = {
					rules : {
						oauth_redirecturi : { required : true },
					},
					messages : {
						oauth_redirecturi : { required : js_lang.oauth_redirecturi_required },
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
		};
	
})(ecjia.admin, jQuery);

// end