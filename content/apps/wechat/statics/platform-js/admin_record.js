// JavaScript Document
;
(function (app, $) {
	app.admin_record = {
		init: function () {
			$(".ajaxswitch").on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('href');
				$.get(url, function (data) {
					ecjia.platform.showmessage(data);
				}, 'json');
			});

			$("select[name='kf_account']").change(function (e) {
				e.preventDefault();
				var kf_account = $("select[name='kf_account'] option:selected").val();
				var url = $(".choost_list").attr('data-url');
				if (!kf_account || kf_account == -1) {
					ecjia.pjax(url);
				} else {
					ecjia.pjax(url + '&kf_account=' + kf_account);
				}
			});

			$('.readed_message').on('click', function (e) {
				var $this = $(this),
					admin_id = $this.attr('data-id'),
					url = $this.attr('data-href'),
					chat_id = $this.attr('data-chatid'),
					last_id = $this.attr('data-lastid'),
					info = {
						last_id: last_id,
						chat_id: chat_id
					};
				e.preventDefault();
				if (!$this.attr('disabled')) {
					$.get(url, info, function (data) {
						if (data.msg_list) {
							for (var i = data.msg_list.length - 1; i >= 0; i--) {
								var is_myself = data.msg_list[i].opercode == 2003 ? 1 : 0;
								var options = {
									send_time: data.msg_list[i].time,
									tr_msg: data.msg_list[i].text,
									chat_user: data.msg_list[i].opercode == 2003 ? data.msg_list[i].nickname : data.msg_list[i].kf_account,
									is_myself: is_myself,
									oldstart: 1
								};
								app.admin_record.addMsgItem(options);
							};
							var new_last_id = data.last_id ? data.last_id : parseInt(last_id) - 10;
							$this.attr('data-lastid', new_last_id);
							data.msg_list.length < 10 && $this.text(data.message).attr('disabled', 'disabled');
							$('.chat_msg.media-list').prepend($this.parents('.chat_msg'));
						} else {
							$this.text(data.message).attr('disabled', 'disabled');
						}
					})
				}
			});

			$(".ajaxmenu").off('click').on('click', function (e) {
				e.preventDefault();
				var $this = $(this);
				if ($this.hasClass('disabled')) {
					return false;
				}
				$this.html(js_lang.getting).addClass('disabled');
				var url = $(this).attr('data-url');
				app.admin_record.get_record(url);
			});
		},

		/*
		 * 添加信息节点到聊天框中
		 */
		addMsgItem: function (options) {
			var msg_cloned = $('.msg_clone').clone();
			options.oldstart ? $('.chat_msg.media-list').prepend(msg_cloned) : $('.chat_msg.media-list').append(msg_cloned);
			msg_cloned.find('.chat_msg_date').html(options.send_time);
			msg_cloned.find('.chat_user_name').html(options.chat_user);
			msg_cloned.find('.media-text').html(options.tr_msg);

			!options.is_myself && msg_cloned.removeClass('chat-msg-you').addClass('chat-msg-mine');
			msg_cloned.removeClass('msg_clone').show();
			$('.chat_msg.media-list').stop().animate({
				scrollTop: options.oldstart ? msg_cloned.offset().top : 9999999
			}, 1000);
		},

		get_record: function (url) {
			$.get(url, function(data) {
				$(".ajaxmenu").html(js_lang.get_customer_record).removeClass('disabled');
				ecjia.platform.showmessage(data);
			});
		},
	};
})(ecjia.platform, jQuery);

// end