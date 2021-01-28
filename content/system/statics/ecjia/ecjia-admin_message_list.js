;(function(admin, $) {
	
	function is_touch_device() {
		return !!('ontouchstart' in window);
	}
	
	admin.message_list = {
		init : function() {
			if (!is_touch_device()) {
				chatEditor = $("#chat_editor").cleditor({
					width		: "100%",
					height		: "120px",
					controls	: "bold italic underline"
				})[0];
			}

			$('.send_msg').on('click', function(e) {
				admin.message_list.sendMsg();
				e.preventDefault();
			});

			$('.msg_window').stop().animate({
				scrollTop : 9999
			}, 1000);
			admin.message_list.searchMsg();
		},

		/*
		 * 轮询信息
		 */
		searchMsg: function() {
			$('.readed_message').on('click', function(e) {
				var $this 		= $(this),
					admin_id 	= $this.attr('data-id'),
					url 		= $this.attr('data-href'),
					chat_id 	= $this.attr('data-chatid'),
					last_id 	= $this.attr('data-lastid'),
					info 		= {last_id : last_id, chat_id : chat_id};
				e.preventDefault();
				if (!$this.attr('disabled')) {
					$.get(url, info, function(data) {
						if (data.msg_list) {
							for (var i = data.msg_list.length - 1; i >= 0; i--) {
								var is_myself = data.msg_list[i].sender_id == admin_id ? 1 : 0;
								var options = {
									sent_time	: data.msg_list[i].sent_time, 
									tr_msg		: data.msg_list[i].message, 
									chat_user	: data.msg_list[i].user_name, 
									is_myself	: is_myself, 
									oldstart	: 1
								};
								admin.message_list.addMsgItem(options);
							};
							var new_last_id = data.last_id ? data.last_id : parseInt(last_id) - 10;
							$this.attr('data-lastid', new_last_id);
							data.msg_list.length < 10 && $this.text(data.message).attr('disabled', 'disabled');
							$('.msg_window').prepend($this.parents('.chat_msg'));
						}else{
							$this.text(data.message).attr('disabled','disabled');
						}
					})
				}
			});
		},

		/*
		 * 发送信息
		 */
		sendMsg: function() {
			!is_touch_device() && chatEditor.updateTextArea();
			var msg 		= $("#chat_editor").val(),
				post_url	= $('.chat_box').attr('data-url'),
				chat_user	= $('#chat_user').val(),
				info		= {message : msg};
			tr_msg = msg.replace(/(^(<p>&nbsp;<\/p>)+|(<p>&nbsp;<\/p>)$)/g,"").replace(/(^(<div><br><\/div>)+|(<div><br><\/div>)$)/g,"").replace(/(^(<br>)+|(<br>)+$)/g,"");
			if (tr_msg != "") {
				$.post(post_url, info, function(data) {
					var options = {sent_time: data.sent_time, tr_msg : tr_msg, chat_user : chat_user, is_myself : 1};
					admin.message_list.addMsgItem(options);
				}, 'json');
			}
			!is_touch_device() && chatEditor.clear().focus();
		},

		/*
		 * 添加信息节点到聊天框中
		 */
		addMsgItem: function(options) {
			var msg_cloned = $('.msg_clone').clone();
			options.oldstart ? $('.msg_window').prepend(msg_cloned) : $('.msg_window').append(msg_cloned);
			msg_cloned.find('.chat_msg_date').html(options.sent_time);
			msg_cloned.find('.chat_msg_body').html(options.tr_msg);
			msg_cloned.find('.chat_user_name').html(options.chat_user);
			!options.is_myself && msg_cloned.removeClass('chat-msg-mine');
			msg_cloned.removeClass('msg_clone').show();
			$('.msg_window').stop().animate({
				scrollTop: options.oldstart ? msg_cloned.offset().top : 9999999
			}, 1000);
		},
	};
 
})(ecjia.admin, jQuery);
