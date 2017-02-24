// JavaScript Document
;(function(app, $) {
app.admin_record = {
	init : function() {
		$(".ajaxswitch").on('click', function(e){
			e.preventDefault();
			var url = $(this).attr('href');
			$.get(url, function(data){
				ecjia.admin.showmessage(data);
			}, 'json');
		});	
		
		$("select[name='kf_account']").change( function(e) {
			e.preventDefault();
			var kf_account = $("select[name='kf_account'] option:selected").val();
			var url = $(".choost_list").attr('data-url');
			if (!kf_account || kf_account == -1) {
				ecjia.pjax(url);
			} else {
				ecjia.pjax(url + '&kf_account=' + kf_account);
			}
		});
		
        $('[data-toggle="popover"]').each(function() {
		    var el = $(this),
		    	url = el.attr('data-url');
	    	$.ajax({
				type: "get",
				url: url,
				dataType: "json",
				async: true, 
				success: function(data){
					if (data.content == null) {
						return false;
					}
					var sex ='';
					if (data.content.sex == 1) {
						sex = js_lang.male;
					} else if (data.content.sex == 2) {
						sex = js_lang.female;
					}
					if (data.content.user_name) {
						user_name = data.content.user_name;
					} else {
						user_name = js_lang.not_bind_yet;
					}
					var content = "<div class='accordion-body in collapse' id='customer_info'><div class='accordion-inner ecjiaf-border'>" +
						"<div class='control-group control-group-small formSep'>" +
							"<label class='label-title'>"+ js_lang.label_nick +"</label>" +
							"<div class='controls l_h30'><span class='p_l10'>"+ data.content.nickname +"</span></div>" +
						"</div>" +
						"<div class='control-group control-group-small formSep'>" +
							"<label class='label-title'>"+ js_lang.label_remark +"</label>" +
							"<div class='controls l_h30'>" +
								"<span class='p_l10'>"+ data.content.remark +"</span></div>" +
						"</div>" +
						"<div class='control-group control-group-small formSep'>" +
							"<label class='label-title'>"+ js_lang.label_sex +"</label>" +
							"<div class='controls l_h30'>" +
							"<span class='p_l10'>"+ sex +"</span></div>" +
						"</div>" +
						"<div class='control-group control-group-small formSep'>" +
							"<label class='label-title'>"+ js_lang.label_province +"</label>" +
							"<div class='controls l_h30'>" +
							"<span class='p_l10'>"+ data.content.province + ' - ' + data.content.city +"</span></div>" +
						"</div>" +
						"<div class='control-group control-group-small formSep'>" +
							"<label class='label-title'>"+ js_lang.label_user_tag +"</label>" +
							"<div class='controls l_h30'>" +
								"<span class='p_l10'>"+ data.content.tag_name +"</span></div>" +
						"</div>" +
						"<div class='control-group control-group-small formSep'>" +
							"<label class='label-title'>"+ data.content.subscribe_time +"</label>" +
							"<div class='controls l_h30'>" +
							"<span class='p_l10'>"+ data.content.subscribe_time +"</span></div>" +
						"</div>" +
						"<div class='control-group control-group-small formSep'>" +
							"<label class='label-title'>"+ js_lang.label_bind_user +"</label>" +
							"<div class='controls l_h30'>" +
							"<span class='p_l10'>"+ user_name +"</span></div>" +
						"</div>" +
					"</div></div>";
					$("#popover-content_" + data.content.uid).html(content);
				}
			});
		});
		
		$('[data-toggle="popover"]').popover({ 
    		html: true,
    		content: function() {
    			var uid = $(this).attr('data-uid');
    			return $("#popover-content_" + uid).html();
    		},
		});
		
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
							var is_myself = data.msg_list[i].opercode == 2003 ? 1 : 0;
							var options = {
								send_time	: data.msg_list[i].time, 
								tr_msg		: data.msg_list[i].text, 
								chat_user	: data.msg_list[i].opercode == 2003 ? data.msg_list[i].nickname : data.msg_list[i].kf_account,
								is_myself	: is_myself, 
								oldstart	: 1
							};
							app.admin_record.addMsgItem(options);
						};
						var new_last_id = data.last_id ? data.last_id : parseInt(last_id) - 10;
						$this.attr('data-lastid', new_last_id);
						data.msg_list.length < 10 && $this.text(data.message).attr('disabled', 'disabled');
						$('.msg_windows').prepend($this.parents('.chat_msg'));
					} else {
						$this.text(data.message).attr('disabled','disabled');
					}
				})
			}
		});
		
		$(".ajaxmenu").on('click', function(e){
			e.preventDefault();
			var $this = $(this);
			$this.html(js_lang.getting).addClass('disabled');
			
			var info = js_lang.get_message_record;
			var url = $(this).attr('data-url');
			var message = $(this).attr('data-msg');
			$.ajax({
				type: "get",
				url: url,
				dataType: "json",
				success: function(data){
					$this.html(info).removeClass('disabled');
					ecjia.admin.showmessage(data); 
				}
			});
		});
	},
	
	/*
	 * 添加信息节点到聊天框中
	 */
	addMsgItem: function(options) {
		var msg_cloned = $('.msg_clone').clone();
		options.oldstart ? $('.msg_windows').prepend(msg_cloned) : $('.msg_windows').append(msg_cloned);
		msg_cloned.find('.chat_msg_date').html(options.send_time);
		msg_cloned.find('.chat_msg_body').html(options.tr_msg);
		msg_cloned.find('.chat_user_name').html(options.chat_user);
		!options.is_myself && msg_cloned.removeClass('chat-msg-mine').addClass('chat-msg-you');
		msg_cloned.removeClass('msg_clone').show();
		$('.msg_windows').stop().animate({
			scrollTop: options.oldstart ? msg_cloned.offset().top : 9999999
		}, 1000);
	},
	
	get_userinfo : function(url){
		$.ajax({
			type: "get",
			url: url,
			dataType: "json",
			success: function(data){
				ecjia.admin.showmessage(data);
				if (data.notice == 1) {
					var url = data.url;
					app.admin_record.get_userinfo(url + '&p=' + data.p);
				}
			}
		});
	},
};
})(ecjia.admin, jQuery);

// end