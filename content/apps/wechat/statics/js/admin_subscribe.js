// JavaScript Document
;(function(app, $) {
	app.subscribe_message = {
		init : function () {
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
								var is_myself = data.msg_list[i].iswechat == 1 ? 1 : 0;
								var options = {
									send_time	: data.msg_list[i].send_time, 
									tr_msg		: data.msg_list[i].msg, 
									chat_user	: data.msg_list[i].nickname, 
									is_myself	: is_myself, 
									oldstart	: 1
								};
								app.subscribe_message.addMsgItem(options);
							};
							var new_last_id = data.last_id ? data.last_id : parseInt(last_id) - 10;
							$this.attr('data-lastid', new_last_id);
							data.msg_list.length < 10 && $this.text(data.message).attr('disabled', 'disabled');
							$('.msg_window').prepend($this.parents('.chat_msg'));
						} else {
							$this.text(data.message).attr('disabled','disabled');
						}
					})
				}
			});
			
			$('.send_msg').on('click', function(e) {
				app.subscribe_message.sendMsg();
				e.preventDefault();
			});
			
			$(".set-label-btn").on('click', function(e) {
				var openid = $(this).attr('data-openid');
				var uid = $(this).attr('data-uid');
				$('input[name="openid"]').val(openid);
				$('input[name="uid"]').val(uid);
				searchURL = $(this).attr('data-url');
				var filters = {
					'uid'	: uid,
				};
				$('.popover_tag_list').html('');
				$.post(searchURL, filters, function(data) {
					app.subscribe_message.load_opt(data);
				}, "JSON");
				$('#set_label').modal('show');
			});
			
			$(".set_label").on('click', function(e) {
				var $form = $("form[name='label_form']"); 
				$form.ajaxSubmit({
					dataType : "json",
					success : function(data) {
						ecjia.admin.showmessage(data);
						$('#set_label').modal('hide');
					}
				});
			});
			app.subscribe_message.edit_customer_remark();
		},	
		
		load_opt : function(data){
			if (data.content.length > 0) {
				for (var i = 0; i < data.content.length; i++) {
					if (data.content[i].checked == 1) {
						var $opt = $('<label class="frm_checkbox_label"><input type="checkbox" class="frm_checkbox" checked="checked" name="tag_id[]" value="'+data.content[i].tag_id+'"><span class="lbl_content">'+data.content[i].name+'</span></label>');
					} else {
						var $opt = $('<label class="frm_checkbox_label"><input type="checkbox" class="frm_checkbox" name="tag_id[]" value="'+data.content[i].tag_id+'"><span class="lbl_content">'+data.content[i].name+'</span></label>');
					}
					$('.popover_tag_list').append($opt);
					$('input[type="checkbox"]').uniform();
				}
			}
			$('.frm_checkbox_label').click(function() {
				$("input[name='tag_id[]']").attr('disabled', true);
				if ($("input[name='tag_id[]']:checked").length >= 3) {
					$("input[name='tag_id[]']:checked").attr('disabled', false);
				} else {
					$("input[name='tag_id[]']").attr('disabled', false);
				}
			});
		},
		
		//编辑备注
		edit_customer_remark : function() {
			$('.edit_remark_icon').on('click', function(e) {
				e.preventDefault();
				var remark = $('input[name="remark"]').val();
				$('.remark_info').hide();
				$('.edit_remark_icon').hide();
				$('.remark').show();
			});
			
			$('.remark_ok').on('click', function(e) {
				e.preventDefault();
				var $this = $(this),
					remark = $('input[name="remark"]').val(),
					url = $('.edit_remark_url').attr('data-url'),
					openid = $('.edit_remark_url').attr('data-openid'),
					page = $('.edit_remark_url').attr('data-page'),
					uid = $('.edit_remark_url').attr('data-uid'),
					old_remark = $('.edit_remark_url').attr('data-remark'),
					info = {remark : remark, openid : openid, page : page, uid : uid};
				if (remark == old_remark) {
					$('.remark_info').show();
					$('.edit_remark_icon').show();
					$('.remark').hide();
				} else {
					$.post(url, info, function(data) {
						ecjia.admin.showmessage(data);
					}, 'json');
				}
			});
			
			$('.remark_cancel').on('click', function(e) {
				e.preventDefault();
				var remark = $('input[name="remark"]').val();
				$('.remark_info').show();
				$('.edit_remark_icon').show();
				$('.remark').hide();
			});
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
					app.subscribe_message.addMsgItem(options);
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
	
	app.admin_subscribe = {
		init : function() {
			$(".ajaxswitch").on('click', function(e){
				e.preventDefault();
				var url = $(this).attr('href');
				$.get(url, function(data){
					ecjia.admin.showmessage(data);
				}, 'json');
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
								"<label class='label-title'>"+ js_lang.label_subscribe_time +"</label>" +
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

			$('.search-btn').on('click', function(e) {
				e.preventDefault();
				var keywords	= $("input[name='keywords']").val();
				var url			= $("form[name='search_from']").attr('action'); //请求链接
				if(keywords     == 'undefind')keywords='';
				if(url         	== 'undefind')url='';
				
				if (keywords == '') {
					ecjia.pjax(url);
				} else {
					ecjia.pjax(url + '&keywords=' + keywords);
				}
			});
			
			app.admin_subscribe.edit_tag();
			
			$(".ajaxmenu").on('click', function(e){
				e.preventDefault();
				var $this = $(this);
				$this.html(js_lang.getting).addClass('disabled');
				
				var info = '';
				var value = $(this).attr('data-value');
				if (value == 'get_usertag') {
					info = js_lang.get_user_tag;
				} else {
					info = js_lang.get_user_info;
				}
				
				var url = $(this).attr('data-url');
				var message = $(this).attr('data-msg');
				if (message) {
					smoke.confirm(message,function(e){
						e && $.ajax({
							type: "get",
							url: url,
							dataType: "json",
							success: function(data){
								$this.html(info).removeClass('disabled');
								ecjia.admin.showmessage(data); 
							}
						});
					}, {ok:js_lang.ok, cancel:js_lang.cancel});
				} else { 
					app.admin_subscribe.get_userinfo(url);
				}
			});	
			
			app.admin_subscribe.batch_set_label();
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
						app.admin_subscribe.get_userinfo(url + '&p=' + data.p);
					}
				}
			});
		},
		
		edit_tag : function() {
			$('.subscribe-icon-edit').die().live('click',function() {
				$('input[name="new_tag"]').val('');
				var old_tag_name = $(this).attr('data-name');
				$('.old_tag').html(old_tag_name);
				$('.old_tag_name').show();
				var id = $(this).attr('value');
				$('#edit_tag input[name="id"]').val(id);
				
				var $form = $("form[name='edit_tag']");
				var option = {
					rules:{
						new_tag : {required:true, maxlength:6},
					},
					messages:{
						new_tag : {
							required:js_lang.tag_name_required, maxlength:js_lang.tag_name_maxlength
						}
					},
					submitHandler : function() {
						var new_tag_name = $('input[name="new_tag"]').val();
						if (new_tag_name == old_tag_name) {
							$('#edit_tag').modal('hide');
							return false;
						}
						$form.ajaxSubmit({
							dataType : "json",
							success : function(data) {
								ecjia.admin.showmessage(data);
								$('#edit_tag').modal('hide');
							}
						});
					}
				}
				var options = $.extend(ecjia.admin.defaultOptions.validate, option);
				$form.validate(options);
			});	
			
			$('.subscribe-icon-plus').die().live('click',function() {
				$('input[name="new_tag"]').val('');
				var $form = $("form[name='add_tag']");
				var option = {
					rules:{
						new_tag : {required:true, maxlength:6},
					},
					messages:{
						new_tag : {required:js_lang.tag_name_required, maxlength:js_lang.tag_name_maxlength}
					},
					submitHandler : function() {
						$form.ajaxSubmit({
							dataType : "json",
							success : function(data) {
								ecjia.admin.showmessage(data);
								$('#add_tag').modal('hide');
							}
						});
					}
				}
				var options = $.extend(ecjia.admin.defaultOptions.validate, option);
				$form.validate(options);
			});	
		},
		
		batch_set_label : function() {
			$(".set-label-btn").on('click', function(e) {
				var openid = $(this).attr('data-openid');
				var uid = $(this).attr('data-uid');
				searchURL = $(this).attr('data-url');
				var filters = {
					'uid'	: uid,
				};
				if (openid != '' &&　openid != undefined) {
					$('input[name="openid"]').val(openid);
					$('input[name="uid"]').val(uid);
				} else {
					var checkboxes = [];
					$(".checkbox:checked").each(function() {
						checkboxes.push($(this).val());
					});
					if (checkboxes == '') {
						smoke.alert(js_lang.pls_select_user);
						return false;
					} else {
						$('input[name="openid"]').val(checkboxes);
					}
				}
				$('.popover_tag_list').html('');
				$.post(searchURL, filters, function(data) {
					app.admin_subscribe.load_opt(data);
				}, "JSON");
				$('#set_label').modal('show');
			});
			
			$(".set_label").on('click', function(e) {
				var $form = $("form[name='label_form']"); 
				$form.ajaxSubmit({
					dataType : "json",
					success : function(data) {
						ecjia.admin.showmessage(data);
						$('#set_label').modal('hide');
					}
				});
			});
		},
		
		load_opt : function(data){
			if (data.content.length > 0) {
				for (var i = 0; i < data.content.length; i++) {
					if (data.content[i].checked == 1) {
						var $opt = $('<label class="frm_checkbox_label"><input type="checkbox" class="frm_checkbox" checked="checked" name="tag_id[]" value="'+data.content[i].tag_id+'"><span class="lbl_content">'+data.content[i].name+'</span></label>');
					} else {
						var $opt = $('<label class="frm_checkbox_label"><input type="checkbox" class="frm_checkbox" name="tag_id[]" value="'+data.content[i].tag_id+'"><span class="lbl_content">'+data.content[i].name+'</span></label>');
					}
					$('.popover_tag_list').append($opt);
					$('input[type="checkbox"]').uniform();
				}
			}
			$('.frm_checkbox').click(function() {
				var c = $("input[name='tag_id[]']:checked").length-1, limit = 3;

				$(this).attr('checked') == 'checked' ? c++ : c--;
				if (c > limit){ 
					$(this).attr('checked', false);
					$.uniform.update($(this));
					$(".label_block").show();
					c--;
				} else {
					$(".label_block").hide();
				}
			});
		},
	};
})(ecjia.admin, jQuery);

// end