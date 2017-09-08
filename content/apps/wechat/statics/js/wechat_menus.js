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
						$('#weappdiv').hide();
						$("input[name='url']").val("");
					} else if ($("input[name='type']:checked").val() == 'view') {
						$('#keydiv').hide();
						$('#urldiv').show();
						$('#weappdiv').hide();
						$("input[name='key']").val("");
					} else {
						$('#keydiv').hide();
						$('#urldiv').hide();
						$('#weappdiv').show();
						$("input[name='url']").val("");
						$("input[name='key']").val("");
					}
				});
				$('input[name="type"]:checked').trigger('click');
				
				$('form').on('submit', function(e) {
					e.preventDefault();
					$(this).ajaxSubmit({
						dataType : "json",
						success : function(data) {
							ecjia.admin.showmessage(data);
						}
					});
				});
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