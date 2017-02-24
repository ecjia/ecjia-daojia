// JavaScript Document
;(function(app, $) {
	app.wechat_qrcode_list = {
		init : function() {
			$("form[name='searchForm'] .search_qrcode").on('click', function(e){
				e.preventDefault();
				var url = $("form[name='searchForm']").attr('action') + '&keywords=' +$("input[name='keywords']").val();
				ecjia.pjax(url);
			});		
			
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
	app.wechat_qrcode_edit = {
			init : function() {
				app.wechat_qrcode_edit.submit_form();
			},
			submit_form : function(formobj) {
				var $form = $("form[name='theForm']");
				var option = {
					rules : {
						functions : { required : true },
						scene_id : { required : true }
					},
					messages : {
						functions : { required : js_lang.qrcode_funcions_required },
						scene_id : { required : js_lang.application_adsense_required }
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