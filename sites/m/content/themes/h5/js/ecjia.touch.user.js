/**
 * 后台综合js文件
 */
;
(function(ecjia, $) {
	ecjia.touch.user = {
		init: function() {
			ecjia.touch.user.ecjia_login();
			ecjia.touch.user.ecjia_logout();
			ecjia.touch.user.show_goods_list_click();
			ecjia.touch.user.show_share_click();
//			ecjia.touch.user.loginout_click();
			ecjia.touch.user.clear_history();
			ecjia.touch.user.get_code();
			ecjia.touch.user.mobile_verification();
			ecjia.touch.user.fast_reset_pwd();
			ecjia.touch.user.register_password();
			ecjia.touch.user.mobile_register();
			ecjia.touch.user.reset_password();
			ecjia.touch.user.show_password();
			ecjia.touch.user.modify_username();
			ecjia.touch.user.record_cancel();
			ecjia.touch.user.account_bind();

			$(function() {
				$(".del").click(function() {
					if (!confirm('您确定要删除吗？')) {
						return false;
					}
					var obj = $(this);
					var url = obj.attr("href");
					$.get(url, '', function(data) {
						if ('success' == data.state) {
							if (obj.hasClass("history_clear")) {
								obj.closest(".ect-pro-list").html("<p class='text-center  ect-margin-tb ect-padding-tb'>暂无浏览记录，点击<a class='ect-color ect-margin-lr' href={url path='category/index')}>进入</a>浏览商品</p>");
								obj.parent().siblings("ul").remove();
							} else {
								if (obj.closest("li").siblings("li").length == 0) {
									obj.closest("ul").html("<p class='text-center  ect-margin-tb ect-padding-tb'>{$lang.no_data}</p>");
								}
								obj.closest("li").remove();
							}
						} else {
							alert("删除失败");
						}
					}, 'json');
					return false;
				});
			})
		},

		//ajax 表单提交验证
		submitForm: function() {
			$("form[name='theForm']").on('submit', function(e) {
				e.preventDefault();
				return false;
			}).Validform({
				tiptype: function(msg, o, cssctl) {
					//msg：提示信息;
					//o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
					//cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
					if (o.type == 3) {
						alert(msg);
					}
				},
				ajaxPost: true,
				callback: function(data) {
					ecjia.touch.showmessage(data);
				}
			});
		},
		//用户登录
		ecjia_login: function() {
			$('input[name="ecjia-login"]').on('click', function(e) {
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				e.preventDefault();
				var url = $(this).attr('data-url');
				var username = $('input[name="username"]').val();
				var password = $('input[name="password"]').val();
				var referer_url = $('input[name="referer_url"]').val();
				var info = {
					'username': username,
					'password': password,
					'referer_url': referer_url
				};
				$.post(url, info, function(data) {
					$('.la-ball-atom').remove();
					if (data.state == 'error') {
						var myApp = new Framework7({
							modalButtonOk: '确定',
							modalTitle: ''
						});
						myApp.alert(data.message);
					} else if (data.state == 'success'){
						location.href = data.url;
					}
				});
			});
		},

		//用户登出
		ecjia_logout: function() {
			$('input[name="logout"]').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				options = {
					'status': 'logout',
				}
				var myApp = new Framework7({
					modalButtonCancel: '取消',
					modalButtonOk: '确定',
					modalTitle: ''
				});
				myApp.confirm('是否确认退出？', function() {
					$.post(url, options, function(data) {
						if (data.log != '') {
							ecjia.pjax(data.logout_url);
						}
					});
				});

			});
		},

		//点击搜索结果事件
		location_list_click: function() {
			$('.ecjia-location-list-wrap li').on('click', function() {
				var title = $(this).find(".ecjia-location-list-title").text();
				var address = $(this).find(".ecjia-location-list-address").text();
				var url = $("#ecjia-zs").attr('data-url');
				url += '&address=' + address;
				url += '&address_info=' + title;
				ecjia.pjax(url);
			});
		},

		//编辑收货地址 失去焦点保存数据
		address_save: function() {
			$('input').on('blur', function() {
				var form_url = $("form[name='theForm']").attr('data-save-url');
				$("form[name='theForm']").ajaxSubmit({
					type: 'get',
					url: form_url,
					dataType: "json",
					success: function(data) {}
				});
			});
		},

		/*注册自动获取邀请码*/
		mobile_verification: function() {
			$("#mobile").bind('input propertychange', function(e) {
				e.preventDefault();
				var mobile = $('#mobile').val();
				var url = $('input[name="mobile_verification"]').attr('data-url');
				if (mobile.length == 11) {
					$.post(url, {
						'mobile': mobile
					}, function(data) {
						if (data.state == 'success') {
							$('input[name="verification"]').val(data.verification);
						}
					})
				}
			});
		},
		clear_history: function() {
			$('.clear_history').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('href');
				if (confirm('你确定要清除浏览历史记录吗？')) {
					$.get(url, '', function(data) {
						ecjia.touch.showmessage(data);
					})
				}
			});
		},
		/* 注册验证码 */
		get_code: function() {
			var InterValObj; //timer变量，控制时间
			var count = 120; //间隔函数，1秒执行
			var curCount; //当前剩余秒数
			$('#get_code').off('click').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				var mobile = $("input[name='mobile']").val();
				var search_str = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
				var email = $("input[name='email']").val();
				if (mobile || mobile == '') {
					if (mobile.length == 11) {
						url += '&mobile=' + mobile;
					} else {
						alert('请输入正确的手机号');
					}
				} else if (email || email == '') {
					if (!search_str.test(email)) {
						alert("请输入正确的邮箱格式");
					} else {
						url += '&email=' + email;
					}
				}
				$.get(url, function(data) {
					if (data.state == 'success') {　curCount = count;
						$("#mobile").attr("readonly", "true");
						$("#get_code").attr("disabled", "true");
						$("#get_code").val("重新发送" + curCount + "(s)");
						$("input[name='get_code']").attr("class", "btn btn-org login-btn");
						InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
					}
					ecjia.touch.showmessage(data);
				});
			});
			
			//timer处理函数
			function SetRemainTime() {
				if (curCount == 0) {
					window.clearInterval(InterValObj); 		//停止计时器
					$("#mobile").removeAttr("readonly");	//启用按钮
					$("#get_code").removeAttr("disabled"); 	//启用按钮
					$("#get_code").val("重新发送");
					$("input[name='get_code']").attr("class", "btn btn-info login-btn");
				} else {
					curCount--;
					$("#get_code").attr("disabled", "true");
					$("#get_code").val("重新发送" + curCount + "(s)");
				}
			};
		},

		/* 注册提交表单 */
		fast_reset_pwd: function() {
			$(".next-btn").on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-url'),
					mobile = $("input[name='mobile']").val().trim(),
					verification = $("input[name='verification']").val().trim(),
					code = $("input[name='code']").val().trim();
				if (code == '') {
					alert('请输入验证码');
					return false;
				}
				if (mobile == '') {
					alert('请输入手机号');
					return false;
				}
				var info = {
					'mobile': mobile,
					'verification': verification,
					'code': code
				};
				$.post(url, info, function(data) {
					ecjia.touch.showmessage(data);
				});
			});
		},
		/* 处理注册  */
		register_password: function() {
			$("#signin").on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-url'),
					username = $("input[name='username']").val().trim(),
					password = $("input[name='password']").val().trim();
				var info = {
					'username': username,
					'password': password
				};
				$.post(url, info, function(data) {
					ecjia.touch.showmessage(data);
				});
			});
		},
		/*找回密码重置密码*/
		mobile_register: function() {
			$("input[name='mobile_register']").on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-url'),
					mobile = $("input[name='mobile']").val().trim(),
					code = $("input[name='code']").val().trim();
				var info = {
					'mobile': mobile,
					'code': code
				};
				$.post(url, info, function(data) {
					ecjia.touch.showmessage(data);
				});
			});
		},
		/*设置新密码*/
		reset_password: function() {
			$("input[name='reset_password']").on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-url'),
					passwordf = $("input[name='passwordf']").val().trim();
				passwords = $("input[name='passwords']").val().trim();
				var info = {
					'passwordf': passwordf,
					'passwords': passwords
				};
				$.post(url, info, function(data) {
					ecjia.touch.showmessage(data);
				});
			});
		},
		/*查看密码*/
		show_password: function() {
			$("#password1").on('click', function(e) {
				if ($("#password-1").attr("type") == "password") {
					$("#password-1").attr("type", "text")
					$('#password1').css('color', '#47aa4d');
				} else {
					$("#password-1").attr("type", "password")
					$('#password1').css('color', '#ddd');
				}
			});
			$("#password2").on('click', function(e) {
				if ($("#password-2").attr("type") == "password") {
					$("#password-2").attr("type", "text")
					$('#password2').css('color', '#47aa4d');
				} else {
					$("#password-2").attr("type", "password")
					$('#password2').css('color', '#ddd');
				}
			});
		},
		/*修改用户名*/
		modify_username: function() {
			$("input[name='modify_username']").on('click', function(e) {
				e.preventDefault();
				var username = $('#username-modify').val();
				var url = $(this).attr('data-url');
				options = {
					'username': username
				}
				$.post(url, options, function(data) {
					if (data.state == 'error') {
						$("#modify-username-info").text(data.msg);
					} else {
						ecjia.pjax(data.msg);
					}
				});
			});
		},
		/*取消充值*/
		record_cancel: function() {
			$("input[name='record_cancel']").on('click', function(e) {
				e.preventDefault();
				var record_type = $("input[name='record_type']").val();
				var account_id = $("input[name='account_id']").val();
				var payment_id = $("input[name='payment_id']").val();
				var url = $(this).attr('data-url');
				options = {
					'record_type': record_type,
					'account_id': account_id,
					'payment_id': payment_id,
					'submit': '取消'
				}
				var myApp = new Framework7({
					modalButtonCancel: '取消',
					modalButtonOk: '确定',
					modalTitle: ''
				});
				myApp.confirm('你确定要取消吗？', function() {
					$.post(url, options, function(data) {
						ecjia.pjax(data.url);
					})
				});
			});

			$("input[name='record_sure']").on('click', function(e) {
				e.preventDefault();
				var amount = $("input[name='amount']").val();
				var account_id = $("input[name='account_id']").val();
				var payment_id = $("input[name='payment_id']").val();
				var url = $(this).attr('data-url');
				options = {
					'amount': amount,
					'account_id': account_id,
					'payment_id': payment_id,
					'submit': '充值'
				}
				$.post(url, options, function(data) {
					if (data.weixin_data) {
						$('.wei-xin-pay').html("");
						$('.wei-xin-pay').html(data.weixin_data);
						callpay();
					}
				})
			});
		},

		account_bind: function() {
			$("form[name='accountBind']").on('submit', function(e) {
				e.preventDefault();
				return false;
			}).Validform({
				tiptype: function(msg, o, cssctl) {
					//msg：提示信息;
					//o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
					//cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
//					if (o.type == 3){
//						alert(msg);
//					}
				},
				ajaxPost: true,
				callback: function(data) {
					if (data.state == 'success') {
						iosOverlay({
							text: "绑定成功!",
							duration: 2e3,
						});
						ecjia.touch.showmessage(data);
					} else {
						if (!data.message) {
							iosOverlay({
								text: '请填写完整信息!',
								duration: 2e3,
							});
						} else {
							iosOverlay({
								text: data.message,
								duration: 2e3,
							});
						}

					}
				}
			});
		},

		show_goods_list_click: function() {
			$('.order-detail-list li.hd').on('click', function() {
				if (!$(this).hasClass('active')) {
					$(this).addClass('active');
					$(this).next(".order-goods-detail").addClass('active');
				} else {
					$(this).removeClass('active');
					$(this).next(".order-goods-detail").removeClass('active');
				}
			})
		},

		show_share_click: function() {
			$('.commont-show-active .hd').on('click', function() {
				if (!$(this).parent('.user-share').hasClass('user-share-show')) {
					$(this).parent('.user-share').addClass('user-share-show');
				} else {
					$(this).parent('.user-share').removeClass('user-share-show');
				}
			})
		},
	};

	ecjia.touch.address_from = {
		init: function() {
			$("form[name='theForm']").on('submit', function(e) {
				e.preventDefault();
				return false;
			}).Validform({
				tiptype: function(msg, o, cssctl) {
					//msg：提示信息;
					//o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
					//cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
					if (o.type == 3) {
						alert(msg);
					}
				},
				ajaxPost: true,
				callback: function(data) {
					var url = $.localStorage('address_url');
					var title = $.localStorage('address_title');
					if (url != undefined && title != undefined) {
						var state = {
							id: uniqueId(),
							url: url,
							title: title,
							container: '.ecjia',
							timeout: 10000
						}
						window.history.replaceState(state, title, url);
					}
					ecjia.touch.showmessage(data);
				}
			});
		}
	};

	function uniqueId() {
		return (new Date).getTime()
	}
})(ecjia, jQuery);

//end