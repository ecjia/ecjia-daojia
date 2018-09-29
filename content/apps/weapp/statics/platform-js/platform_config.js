// JavaScript Document
;(function(app, $) {
	app.platform = {
		init : function() {
			ecjia.platform.platform.generate_token();
			ecjia.platform.platform.theForm();
			ecjia.platform.platform.copy();
		},

        generate_token: function() {
            $('.generate_token').off('click').on('click', function (e) {
                e.preventDefault();
                var $this = $(this);
                var url = $this.attr('data-url');
                 $.post(url, function (data) {
                 	var value = data.val
                 	$('input[name="token"]').val(value);
                 }, 'json');
            });
        },
		
		theForm : function() {
			var $form = $('form[name="theForm"]');
			var option = {
				rules:{
					server_url: {required : true},
					server_token : {required : true, rangelength:[3, 32]},
					aeskey : {required : true, rangelength: [42, 44]},
				},
				messages:{
					server_url: {required : '请输入URL(服务器地址)'},
					server_token : {required : '请输入Token(令牌)', rangelength: '请输入一个长度介于 3 和 32 之间的字符串'},
					aeskey : {required : '请输入EncodingAESKey(消息加密密钥)', rangelength: '长度必须为43位字符'},
				},	
				submitHandler : function() {
					$form.ajaxSubmit({
						dataType : "json",
						success : function(data) {
							ecjia.platform.showmessage(data); 
						}
					});
				}
			}
			var options = $.extend(ecjia.platform.defaultOptions.validate, option);
			$form.validate(options);
		},

		copy: function() {
			$(".copy-url-btn").off('click').on('click', function (e) {
	        	var url_clipboard = new ClipboardJS('.copy-url-btn');
	        	url_clipboard.on('success', function(e) {
	        		ecjia.platform_ui.alert('复制成功', {ok: '确定'});
	        		e.clearSelection();
	        		url_clipboard.destroy();
	 		    });
	        	url_clipboard.on('error', function(e) {
	 		    	ecjia.platform_ui.alert('复制失败，请手动复制', {ok: '确定'});
	 		    	e.clearSelection();
	 		    	url_clipboard.destroy();
	 		    });
			});
        	
			$(".copy-token-btn").off('click').on('click', function (e) {
	        	var token_clipboard = new ClipboardJS('.copy-token-btn');
	        	token_clipboard.on('success', function(e) {
	        		ecjia.platform_ui.alert('复制成功', {ok: '确定'});
	        		e.clearSelection();
	        		token_clipboard.destroy();
	 		    });
	        	token_clipboard.on('error', function(e) {
	 		    	ecjia.platform_ui.alert('复制失败，请手动复制', {ok: '确定'});
	 		    	e.clearSelection();
	 		    	token_clipboard.destroy();
	 		    });
			});
		}
	};
})(ecjia.platform, jQuery);

//end