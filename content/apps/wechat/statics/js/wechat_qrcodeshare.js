// JavaScript Document
;(function(app, $) {
	app.wechat_qrcodeshare_list = {
			init : function() {		
				$(".ajaxswitch").on('click', function(e){
					e.preventDefault();
					var url = $(this).attr('href');
					$.get(url, function(data){
						ecjia.admin.showmessage(data);
					}, 'json');
				});	
				
				$(".ajaxwechat").on('click', function(e){
					e.preventDefault();
					var url = $(this).attr('href');
					$.get(url, function(data){
						ecjia.admin.showmessage(data);
					}, 'json');
				});	
			}
		};
	/* **编辑** */
	app.wechat_qrcodeshare_edit = {
			init : function() {
				app.wechat_qrcodeshare_edit.submit_form();
			},
			submit_form : function(formobj) {
				var $form = $("form[name='theForm']");
				var option = {
					rules : {
						username : { required : true },
						scene_id : { required : true },
						functions : { required : true }
					},
					messages : {
						username : { required : js_lang.qrcode_username_required },
						scene_id : { required : js_lang.qrcode_scene_id_required },
						functions : { required : js_lang.qrcode_funcions_required }
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