// JavaScript Document
;(function(app, $) {	
	app.wechat_menus_edit = {
			init : function() {
				$(".ajaxswitch").on('click', function(e){
					e.preventDefault();
					var url = $(this).attr('href');
					$.get(url, function(data){
						ecjia.admin.showmessage(data);
					}, 'json');
				});	
				
				$(document).on('click', 'input[name="type"]', function(e){
					if ($("input[name='type']:checked").val() == 'click') {
						$('#keydiv').show();
						$('#urldiv').hide();
					} else if ($("input[name='type']:checked").val() == 'view') {
						$('#keydiv').hide();
						$('#urldiv').show();
					}
				});
				$('input[name="type"]:checked').trigger('click');
				
				app.wechat_menus_edit.submit_form();
			},
			submit_form : function(formobj) {
				var $form = $("form[name='theForm']");
				var option = {
					rules:{
						name : { required : true },
	                    url : {required:true,url:true}

					},
					messages:{
						name : { required : js_lang.menu_name_required },
						url : {required : js_lang.menu_url_required, url : js_lang.menu_url_url}
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
	
	
	app.wechat_menus_list = {
		init : function() {
			$(".ajaxswitch").on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('href');
				$.get(url, function(data){
					ecjia.admin.showmessage(data);
				}, 'json');
			});	
			
			
			$(".ajaxmenu").on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('data-url');
				var message = $(this).attr('data-msg');
				if (message) {
					smoke.confirm(message,function(e){
						e && $.get(url, function(data){
							ecjia.admin.showmessage(data);
						}, 'json');
					}, {ok:js_lang.ok, cancel:js_lang.cancel});
				} else {
					$.get(url, function(data){
						ecjia.admin.showmessage(data);
					}, 'json');
				}
			});	
			
		}
	};
	
})(ecjia.admin, jQuery);

// end