// JavaScript Document
;(function(app, $) {
	app.wechat_customer = {
		init : function() {
			app.wechat_customer.submit_form();
			app.wechat_customer.bind_wx();
			
			$('.send_msg').on('click', function(e) {
				app.wechat_customer.sendMsg();
				e.preventDefault();
			});
			
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
					}, {ok: js_lang.ok, cancel: js_lang.cancel});
				} else {
					$.get(url, function(data){
						ecjia.admin.showmessage(data);
					}, 'json');
				}
			});	
			
			$('[data-trigger="toggle_CustomerState"]').on('click', function(e){
				var $this   = $(this);
				var url     = $this.attr('data-url');
				var id      = $this.attr('data-id');
				var val     = $this.hasClass('fontello-icon-cancel') ? 1 : 0;
				var type    = $this.attr('data-type') ? $this.attr('data-type') : "POST";

				var option  = {obj : $this, url : url, id : id, val : val, type : type};
				e.preventDefault();
				var message = $(this).attr('data-msg');
				smoke.confirm(message,function(e){
					e && $.ajax({
						url: option.url,
						data: {id : option.id , val : option.val},
						type: option.type,
						dataType: "json",
						success: function(data){
							data.content ? option.obj.removeClass('fontello-icon-cancel').addClass('fontello-icon-ok') : option.obj.removeClass('fontello-icon-ok').addClass('fontello-icon-cancel');
							data.pjaxurl ? ecjia.admin.showmessage(data) : ecjia.admin.showmessage(js_lang.status_edit_success);
						}
					});
				}, {ok:js_lang.ok, cancel:js_lang.cancel});
			});
			
			$('.bind_wx').on('click', function(){
				$this = $(this);
				var val = $this.attr('data-val');
				$('input[name="kf_account"]').val(val);
			});
		},
		
		submit_form : function(formobj) {
			var $form = $("form[name='theForm']");
			var kf_account = $("input[name='kf_account']").val();
			if (kf_account == '') {
				var option = {
					rules : {
						'kf_account' : { required : true },
						'kf_nick' : { required : true },
						'password' : { required : true },
					},
					messages : {
						'kf_account' : { required : js_lang.kf_account_required },
						'kf_nick' : { required : js_lang.kf_nick_required },
						'password' : { required : js_lang.password_required },
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
			} else {
				var option = {
					rules : {
						'kf_account' : { required : true },
						'kf_nick' : { required : true },
					},
					messages : {
						'kf_account' : { required : js_lang.kf_account_required },
						'kf_nick' : { required : js_lang.kf_nick_required },
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
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$form.validate(options);
		},
		
		bind_wx : function(formobj) {
			var $form = $("form[name='bind_form']");
			var option = {
				rules : {
					'kf_wx' : { required : true },
				},
				messages : {
					'kf_wx' : { required : js_lang.kf_wx_required },
				},
				submitHandler : function() {
					$form.ajaxSubmit({
						dataType : "json",
						success : function(data) {
							$('#bind_wx').modal('hide');
							ecjia.admin.showmessage(data);
						}
					});
				}
			}
			var options = $.extend(ecjia.admin.defaultOptions.validate, option);
			$form.validate(options);
		},
		
		/*
		 * 发送信息
		 */
		sendMsg: function() {
			var msg 			= $("#chat_editor").val(),
				post_url		= $('.chat_box').attr('data-url'),
				chat_user		= $('#chat_user').val(),
				nickname    	= $('#nickname').val(),
				openid			= $('#openid').val(),
				platform_name   = $('#platform_name').val();
				info			= {message : msg, uid : chat_user, openid : openid};
			tr_msg = msg.replace(/(^(<p>&nbsp;<\/p>)+|(<p>&nbsp;<\/p>)$)/g,"").replace(/(^(<div><br><\/div>)+|(<div><br><\/div>)$)/g,"").replace(/(^(<br>)+|(<br>)+$)/g,"");
			if (tr_msg != "") {
				$.post(post_url, info, function(data) {
					if (data.state == 'error') {
						ecjia.admin.showmessage(data);
						return false;
					}
					var options = {send_time: data.send_time, tr_msg : tr_msg, chat_user : platform_name, is_myself : 1};
					app.wechat_customer.addMsgItem(options);
				}, 'json');
			} else {
				$('#chat_editor').focus();
			}
			$('#chat_editor').val('');
		},
		
		/*
		 * 添加信息节点到聊天框中
		 */
		addMsgItem: function(options) {
			var msg_cloned = $('.msg_clone').clone();
			options.oldstart ? $('.msg_window').prepend(msg_cloned) : $('.msg_window').append(msg_cloned);
			msg_cloned.find('.chat_msg_date').html(options.send_time);
			msg_cloned.find('.chat_msg_body').html(options.tr_msg);
			msg_cloned.find('.chat_user_name').html(options.chat_user);
			!options.is_myself && msg_cloned.removeClass('chat-msg-mine').addClass('chat-msg-you');
			msg_cloned.removeClass('msg_clone').show();
			$('.msg_window').stop().animate({
				scrollTop: options.oldstart ? msg_cloned.offset().top : 9999999
			}, 1000);
		},
	};
})(ecjia.admin, jQuery);

// end