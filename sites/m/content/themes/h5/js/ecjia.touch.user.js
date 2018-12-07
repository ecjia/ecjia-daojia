/**
 * 后台综合js文件
 */
;
(function (ecjia, $) {
	ecjia.touch.user = {
		init: function () {
			ecjia.touch.user.ecjia_login();
			ecjia.touch.user.ecjia_logout();
			ecjia.touch.user.show_goods_list_click();
			ecjia.touch.user.show_share_click();
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
			ecjia.touch.user.cancel_order();
			ecjia.touch.user.return_order();
			ecjia.touch.user.affiliate();
			ecjia.touch.user.resend_sms();

			$(function () {
				$(".del").click(function () {
					if (!confirm('您确定要删除吗？')) {
						return false;
					}
					var obj = $(this);
					var url = obj.attr("href");
					$.get(url, '', function (data) {
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
		submitForm: function () {
			$("form[name='theForm']").on('submit', function (e) {
				e.preventDefault();
				return false;
			}).Validform({
				tiptype: function (msg, o, cssctl) {
					//msg：提示信息;
					//o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
					//cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
					if (o.type == 3) {
						alert(msg);
					}
				},
				ajaxPost: true,
				callback: function (data) {
					ecjia.touch.showmessage(data);
				}
			});
		},
		//用户登录
		ecjia_login: function () {
			$('input[name="ecjia-login"]').off('click').on('click', function (e) {
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
				$.post(url, info, function (data) {
					$('.la-ball-atom').remove();
					if (data.state == 'error') {
						var myApp = new Framework7({
							modalButtonOk: '确定',
							modalTitle: ''
						});
						myApp.alert(data.message);
					} else if (data.state == 'success') {
						location.href = data.url;
					}
				});
			});

			$('input[name="ecjia-mobile-login"]').off('click').on('click', function (e) {
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				e.preventDefault();
				var url = $(this).attr('data-url');
				var mobile_phone = $('input[name="mobile_phone"]').val();

				var info = {
					'mobile_phone': mobile_phone,
				};
				$.post(url, info, function (data) {
					$('.la-ball-atom').remove();
					if (data.state == 'error') {
						alert(data.message);
					}
					ecjia.touch.showmessage(data);
				});
			});

			$('.refresh_captcha').off('click').on('click', function (e) {
				var url = $(this).attr('data-url');
				$.post(url, function (data) {
					if (data.state == 'error') {
						ecjia.touch.showmessage(data);
						return false;
					}
					$('.captcha').children('img').attr('src', 'data:image/png;base64,' + data.message);
				});
			});

			$('input[name="ecjia-captcha-validate"]').off('click').on('click', function (e) {
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				e.preventDefault();
				var url = $(this).attr('data-url');
				var code_captcha = $('input[name="code_captcha"]').val();

				var info = {
					'code_captcha': code_captcha
				};
				$.post(url, info, function (data) {
					$('.la-ball-atom').remove();
					if (data.state == 'error') {
						alert(data.message);
					}
					ecjia.touch.showmessage(data);
				});
			});

			var $input = $(".pass_container input");
			$(".pass_container input").on("input", function () {
				var val = $(this).val();
				if (val == '') {
					var index = parseInt($(this).index()) - 1;
					if (index < 0) {
						index = 0;
					}
					$(this).blur();
					$input.eq("" + index + "").focus();
				} else {
					var index = parseInt($(this).index()) + 1;
					$(this).blur();
					$input.eq("" + index + "").focus();
				}
				var value = '';
				$input.each(function () {
					value += $(this).val();
				})
				if (value.length == 6) {
					var type = $('input[name="type"]').val();
					var mobile = $('input[name="mobile"]').val();
					var url = $('input[name="url"]').val();

					var not_auto_post = $('input[name="not_auto_post"]').val();
					if (not_auto_post == 1) {
						$('input[name="confirm_password"]').val(value);
						return false;
					}
					var info = {
						'type': type,
						'password': value,
						'mobile': mobile
					}
					$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
					$.post(url, info, function (data) {
						$('.la-ball-atom').remove();
						if (data.state == 'error') {
							alert(data.message);
						} else if (data.state == 'success') {
							location.href = data.url;
						}
					})
					return false;
				}
			});

			$('.i-block i').off('click').on('click', function () {
				$('input[name="payPassword_rsainput"]').focus();
			});

			$('input[name="show_verification"]').off('change').on('change', function () {
				var val = $('input[name="show_verification"]:checked').val();
				if (val == 1) {
					$('.verification_div').show();
					$(this).parent('label').addClass('ecjia-checkbox-checked');
				} else {
					$('.verification_div').hide();
					$(this).parent('label').removeClass('ecjia-checkbox-checked');
				}
			});
		},

		resend_sms: function () {
			$('.resend_sms').off('click').on('click', function () {
				var $this = $(this),
					url = $this.attr('data-url');
				$.post(url, {
					'type': 'resend'
				}, function (data) {
					ecjia.touch.showmessage(data);
				});
			});

			var InterValObj; //timer变量，控制时间
			var count = 60; //间隔函数，1秒执行
			var curCount; //当前剩余秒数
			curCount = count;
			$(".resend_sms").addClass("disabled");
			InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次

			//timer处理函数
			function SetRemainTime() {
				if (curCount == 0) {
					window.clearInterval(InterValObj); //停止计时器
					$(".resend_sms").removeClass("disabled"); //启用按钮
				} else {
					curCount--;
				}
			};
		},

		//用户登出
		ecjia_logout: function () {
			$('input[name="logout"]').on('click', function (e) {
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
				myApp.confirm('是否确认退出？', function () {
					$.post(url, options, function (data) {
						if (data.log != '') {
							ecjia.pjax(data.logout_url);
						}
					});
				});

			});
		},

		//点击搜索结果事件
		location_list_click: function () {
			$('.ecjia-location-list-wrap li').on('click', function () {
				var title = $(this).find(".ecjia-location-list-title").text();
				var address = $(this).find(".ecjia-location-list-address").text();
				var url = $("#ecjia-zs").attr('data-url');
				url += '&address=' + address;
				url += '&address_info=' + title;
				ecjia.pjax(url);
			});
		},

		//编辑收货地址 失去焦点保存数据
		address_save: function () {
			$('input').on('blur', function () {
				var form_url = $("form[name='theForm']").attr('data-save-url');
				$("form[name='theForm']").ajaxSubmit({
					type: 'get',
					url: form_url,
					dataType: "json",
					success: function (data) {}
				});
			});
		},

		/*注册自动获取邀请码*/
		mobile_verification: function () {
			$("#mobile").bind('input propertychange', function (e) {
				e.preventDefault();
				var mobile = $('#mobile').val();
				var url = $('input[name="mobile_verification"]').attr('data-url');
				if (mobile.length == 11) {
					$.post(url, {
						'mobile': mobile
					}, function (data) {
						if (data.state == 'success') {
							$('input[name="verification"]').val(data.verification);
						}
					})
				}
			});
		},
		clear_history: function () {
			$('.clear_history').on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('href');
				if (confirm('你确定要清除浏览历史记录吗？')) {
					$.get(url, '', function (data) {
						ecjia.touch.showmessage(data);
					})
				}
			});
		},
		/* 注册验证码 */
		get_code: function () {
			var InterValObj; //timer变量，控制时间
			var count = 60; //间隔函数，1秒执行
			var curCount; //当前剩余秒数
			$('#get_code').off('click').on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				var mobile = $("input[name='mobile']").val();
				var search_str = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
				var email = $("input[name='email']").val();
				var set_count = $(this).attr('data-time');
				if (set_count != undefined) {
					count = set_count;
				}
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
				$.get(url, function (data) {
					if (data.state == 'success') {　
						curCount = count;
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
					window.clearInterval(InterValObj); //停止计时器
					$("#mobile").removeAttr("readonly"); //启用按钮
					$("#get_code").removeAttr("disabled"); //启用按钮
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
		fast_reset_pwd: function () {
			$(".next-btn").on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('data-url'),
					mobile = $("input[name='mobile']").val().trim(),
					verification = $("input[name='verification']").val(),
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
				$.post(url, info, function (data) {
					ecjia.touch.showmessage(data);
				});
			});
		},
		/* 处理注册  */
		register_password: function () {
			$("#signin").off('click').on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('data-url'),
					username = $("input[name='username']").val().trim(),
					password = $("input[name='password']").val().trim(),
					show_verification = $("input[name='show_verification']:checked").val(),
					verification = $("input[name='verification']").val();
				var info = {
					'username': username,
					'password': password,
					'show_verification': show_verification,
					'verification': verification
				};
				$.post(url, info, function (data) {
					ecjia.touch.showmessage(data);
				});
			});
		},
		/*找回密码重置密码*/
		mobile_register: function () {
			$("input[name='mobile_register']").off('click').on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('data-url'),
					mobile = $("input[name='mobile']").val().trim(),
					code = $("input[name='code']").val().trim();
				var info = {
					'mobile': mobile,
					'code': code
				};
				$.post(url, info, function (data) {
					ecjia.touch.showmessage(data);
				});
			});
		},
		/*设置新密码*/
		reset_password: function () {
			$("input[name='reset_password']").on('click', function (e) {
				e.preventDefault();
				var url = $(this).attr('data-url'),
					passwordf = $("input[name='passwordf']").val().trim();
				passwords = $("input[name='passwords']").val().trim();
				var info = {
					'passwordf': passwordf,
					'passwords': passwords
				};
				$.post(url, info, function (data) {
					ecjia.touch.showmessage(data);
				});
			});
		},
		/*查看密码*/
		show_password: function () {
			$("#password1").on('click', function (e) {
				if ($("#password-1").attr("type") == "password") {
					$("#password-1").attr("type", "text")
					$('#password1').css('color', '#47aa4d');
				} else {
					$("#password-1").attr("type", "password")
					$('#password1').css('color', '#ddd');
				}
			});
			$("#password2").on('click', function (e) {
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
		modify_username: function () {
			$("input[name='modify_username']").on('click', function (e) {
				e.preventDefault();
				var username = $('#username-modify').val();
				var url = $(this).attr('data-url');
				options = {
					'username': username
				}
				$.post(url, options, function (data) {
					ecjia.touch.showmessage(data);
				});
			});
		},
		/*取消充值*/
		record_cancel: function () {
			$("input[name='record_cancel']").on('click', function (e) {
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
				myApp.confirm('你确定要取消吗？', function () {
					$.post(url, options, function (data) {
						ecjia.touch.showmessage(data);
					})
				});
			});

			$("input[name='record_sure']").on('click', function (e) { //微信充值
				e.preventDefault();
				var amount = $("input[name='amount']").val();
				var account_id = $("input[name='account_id']").val();
				var payment_id = $("input[name='payment_id']").val();
				var brownser_wx = $("input[name='brownser_wx']").val();
				var brownser_other = $("input[name='brownser_other']").val();
				var url = $(this).attr('data-url');
				options = {
					'amount': amount,
					'account_id': account_id,
					'payment_id': payment_id,
					'submit': '充值',
					'brownser_other': brownser_other,
					'brownser_wx': brownser_wx,
				}
				$.post(url, options, function (data) {
					if (data.state == 'error') {
						ecjia.touch.showmessage(data);
						return false;
					}
					if (data.weixin_data) {
						$('.wei-xin-pay').html("");
						$('.wei-xin-pay').html(data.weixin_data);
						callpay();
					}
				})
			});
		},

		account_bind: function () {
			$("form[name='accountBind']").on('submit', function (e) {
				e.preventDefault();
				return false;
			}).Validform({
				tiptype: function (msg, o, cssctl) {
					//msg：提示信息;
					//o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
					//cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
					//					if (o.type == 3){
					//						alert(msg);
					//					}
				},
				ajaxPost: true,
				callback: function (data) {
					if (data.state == 'success') {
						iosOverlay({
							text: "绑定成功！",
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

			$("form[name='payPassForm']").on('submit', function (e) {
				e.preventDefault();
				return false;
			}).Validform({
				tiptype: function (msg, o, cssctl) {},
				ajaxPost: true,
				callback: function (data) {
					if (data.state == 'success') {
						ecjia.touch.showmessage(data);
					} else {
						if (!data.message) {
							iosOverlay({
								text: '请输入验证码！',
								duration: 2e3,
							});
						} else {
							if (data.type == 'alert') {
								alert(data.message);
							} else {
								iosOverlay({
									text: data.message,
									duration: 2e3,
								});
							}
						}
					}
				}
			});
		},

		cancel_order: function () {
			//未付款订单
			$('.cancel_order_unpay').off('click').on('click', function (e) {
				e.preventDefault();
				var myApp = new Framework7();
				var url = $(this).attr('href');
				myApp.modal({
					title: '您确定要取消该订单吗？',
					buttons: [{
						text: '取消',
					}, {
						text: '确定',
						onClick: function () {
							$.post(url, function (data) {
								ecjia.touch.showmessage(data);
							});
						},
					}]
				});
			});

			$('.affirm_received').off('click').on('click', function (e) {
				e.preventDefault();
				var myApp = new Framework7();
				var url = $(this).attr('href');
				myApp.modal({
					title: '您确定要确认收货吗？',
					buttons: [{
						text: '取消',
					}, {
						text: '确定',
						onClick: function () {
							$.post(url, function (data) {
								ecjia.touch.showmessage(data);
							});
						},
					}]
				});
			});


			var App = new Framework7();
			var reason_list = eval($('input[name="reason_list"]').val());
			var reason_id = [];
			var reason_value = [];
			if (reason_list == undefined) {
				return false;
			}

			for (i = 0; i < reason_list.length; i++) {
				var id = reason_list[i]['reason_id'];
				var name = reason_list[i]['reason_name'];
				reason_id.push(id);
				reason_value.push(name);
			};

			var pickerStreetToolbar = App.picker({
				input: '.cancel_order',
				cssClass: 'cancel_order_reason',
				toolbarTemplate: '<div class="toolbar">' +
					'<div class="toolbar-inner">' +
					'<div class="left">' +
					'<a href="javascript:;" class="link close-picker external">取消</a>' +
					'</div>' +
					'<div class="center">' + '订单取消原因' + '</div>' +
					'<div class="right">' +
					'<a href="javascript:;" class="link save-picker external">确定</a>' +
					'</div>' +
					'</div>' +
					'</div>',
				cols: [{
					values: reason_id,
					displayValues: reason_value
				}, ],
				onOpen: function (picker) {
					var $pick_overlay = '<div class="picker-modal-overlay"></div>';
					if ($('.picker-modal').hasClass('modal-in')) {
						$('.picker-modal').after($pick_overlay);
					}

					picker.container.find('.save-picker').on('click', function () {
						picker.close();
						remove_overlay();

						var reason_id = picker.cols[0].container.find('.picker-selected').attr('data-picker-value');
						var url = $('.cancel_order').attr('href');
						if (reason_id != undefined) {
							url += '&reason_id=' + reason_id;
						}
						$.post(url, function (data) {
							ecjia.touch.showmessage(data);
						});
					});
					picker.container.find('.close-picker').on('click', function () {
						picker.close();
						remove_overlay();
					});
				},
				onClose: function (picker) {
					picker.close();
					remove_overlay();
				}
			});
		},

		return_order: function () {
			ecjia.touch.user.photo();
			ecjia.touch.user.remove_goods_img();
			ecjia.touch.user.choose_reason();
			ecjia.touch.user.undo_reply();
			ecjia.touch.user.copy_btn();
			ecjia.touch.user.form();
			ecjia.touch.user.shipping_fee_notice();
			ecjia.touch.user.select_pickup_time();
		},

		//评价晒单上传图片，并且不能超过5张。
		photo: function () {
			$('.push_photo').hide();
			var length = $('.push_photo_img').children().length;
			if (length != 0 && length != undefined) {
				$('.push_img').find('.push_photo').eq(length).show();
			} else {
				$('#result0').show();
			}
			$(".push_img_btn").on('change', function () {
				var f = $(this)[0].files[0];
				if (f) {
					var fr = new FileReader();
					fr.onload = function () {
						var _img = new Image();
						_img.src = this.result;

						var num = [];
						$(".push_photo").each(function () {
							if (!$(this).is(':hidden')) {
								var id = $(this).attr('id');
								var number = id.substr(id.length - 1, 1);
								num.push(number);
							}
						});
						var num = parseInt(num[0]);

						var check_push_rm = "check_push_rm" + num;
						var img_span = "<i class='a4y'>X</i>";
						var url = "<div class='" + check_push_rm + "'></div>";

						$(url).appendTo(".push_photo_img");
						$(_img).appendTo("." + check_push_rm);
						$(img_span).appendTo("." + check_push_rm);
						ecjia.touch.user.remove_goods_img();

						var result = [];
						$(".push_photo").each(function () {
							if ($(this).is(':hidden')) {
								var id = $(this).attr('id');
								var number = id.substr(id.length - 1, 1);
								var check_push_rm = ".check_push_rm" + number;

								if ($(check_push_rm).length == 0) {
									result.push(id);
								}
							}
						});
						var result = "#" + result[0];
						$('.push_photo').hide();
						$(result).show();

						if ($(".push_photo_img img").length > 4) {
							$(".push_photo").hide();
						}
						if ($(".push_photo_img img").length >= 1) {
							$(".push_result_img").css("margin-left", "0");
						}
					}
					fr.readAsDataURL(f);
				}
			})
		},

		remove_goods_img: function () {
			$(".a4y").on('click', function (e) {
				e.preventDefault();

				var path = $(this).parent();
				var myApp = new Framework7({
					modalButtonCancel: '取消',
					modalButtonOk: '确定',
					modalTitle: ''
				});
				myApp.confirm('您确定要删除照片？', function () {
					if ($(".push_photo_img img").length <= 5) {
						$(".push_photo").show();
					}
					path.remove();
					var c_name = path[0].className;
					var num = c_name.substr(c_name.length - 1, 1);
					if (isNaN(parseInt(num))) num = 0;
					var result = "#result" + num;
					var filechooser = "#filechooser" + num;
					$('.push_photo').hide();

					$(filechooser).val('');
					$(result).show();
					if ($(".push_photo_img img").length < 1) {
						$(".push_result_img").css("margin-left", "0.3em");
					}
				});
			})
		},

		choose_reason: function () {
			var App = new Framework7();
			var reason_list = eval($('input[name="reason_list"]').val());
			var reason_id = [];
			var reason_value = [];
			if (reason_list == undefined) {
				return false;
			}

			for (i = 0; i < reason_list.length; i++) {
				var id = reason_list[i]['reason_id'];
				var name = reason_list[i]['reason_name'];
				reason_id.push(id);
				reason_value.push(name);
			};
			var pickerStreetToolbar = App.picker({
				input: '.choose_reason',
				cssClass: 'choose_reason_modal',
				toolbarTemplate: '<div class="toolbar">' +
					'<div class="toolbar-inner">' +
					'<div class="left">' +
					'<a href="javascript:;" class="link close-picker external">取消</a>' +
					'</div>' +
					'<div class="right">' +
					'<a href="javascript:;" class="link save-picker external">确定</a>' +
					'</div>' +
					'</div>' +
					'</div>',
				cols: [{
					values: reason_id,
					displayValues: reason_value
				}, ],
				onOpen: function (picker) {
					var $pick_overlay = '<div class="picker-modal-overlay"></div>';
					if ($('.picker-modal').hasClass('modal-in')) {
						$('.picker-modal').after($pick_overlay);
					}
					var current_reason_id = $('input[name="reason_id"]').val();
					if (current_reason_id != undefined && current_reason_id != '') {
						picker.setValue([current_reason_id]); //设置选中值
					}

					picker.container.find('.save-picker').on('click', function () {
						var reason_name = picker.cols[0].container.find('.picker-selected').html();
						var reason_id = picker.cols[0].container.find('.picker-selected').attr('data-picker-value');
						$('.choose_reason').children('span').html(reason_name);
						$('input[name="reason_id"]').val(reason_id);
						picker.close();
						remove_overlay();
					});
					picker.container.find('.close-picker').on('click', function () {
						picker.close();
						remove_overlay();
					});
				},
				onClose: function (picker) {
					picker.close();
					remove_overlay();
				}
			});
		},

		undo_reply: function () {
			$('.undo_reply').off('click').on('click', function (e) {
				e.preventDefault();
				var myApp = new Framework7();
				var url = $(this).attr('href');
				myApp.modal({
					title: '您确定要撤销申请？',
					buttons: [{
						text: '取消',
					}, {
						text: '确定',
						onClick: function () {
							$.post(url, function (data) {
								ecjia.touch.showmessage(data);
							});
						},
					}]
				});
			});
		},

		copy_btn: function () {
			var clipboard = new Clipboard('.copy-btn');
			clipboard.on('success', function (e) {
				alert("复制成功！");
			});
		},

		form: function () {
			$('input[name="add-return-btn"]').on('click', function (e) {
				e.preventDefault();
				var url = $("form[name='theForm']").attr('action');
				$('body').append('<div class="la-ball-atom"><div></div><div></div><div></div><div></div></div>');
				$("form[name='theForm']").ajaxSubmit({
					type: 'post',
					url: url,
					dataType: "json",
					success: function (data) {
						$('.la-ball-atom').remove();
						ecjia.touch.showmessage(data);
					}
				});
			});
		},

		shipping_fee_notice: function () {
			$('.shipping_fee_notice').off('click').on('click', function () {
				var $this = $(this);
				var myApp = new Framework7();
				//禁用滚动条
				$('body').css('overflow-y', 'hidden').on('touchmove', function (event) {
					event.preventDefault;
				}, false);

				var wHeight = $(window).height();
				var scrollTop = $(document).scrollTop();
				var top;
				if (wHeight - 400 < 0) {
					top = scrollTop;
				} else {
					var ua = navigator.userAgent.toLowerCase();
					if (ua.match(/MicroMessenger/i) == "micromessenger") {
						top = scrollTop + (wHeight - 230) / 2;
					} else {
						top = scrollTop + (wHeight - 200) / 2;
					}
				}
				$('.ecjia-shipping-fee-modal').show().css('top', top);
				$('.ecjia-shipping-fee-overlay').show();

				myApp.openModal('.ecjia-shipping-fee-modal');
				$('.modal-overlay').remove();
				return false;
			});

			$('.ecjia-shipping-fee-overlay').on('click', function () {
				$('.ecjia-shipping-fee-modal').hide();
				$('.ecjia-shipping-fee-overlay').hide();
				$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
			});
		},

		select_pickup_time: function () {
			//显示送达时间选择框
			$('input[name="expect_pickup_time"]').off('click').on('click', function () {
				$('.mod_address_slide').addClass('show');
			});
			//关闭送达时间选择框
			$('.mod_address_slide_head .icon-close').off('click').on('click', function () {
				$('.mod_address_slide').removeClass('show');
			});

			//点击日期
			$('.mod_address_slide_tabs li').off('click').on('click', function () {
				var $this = $(this),
					date = $this.attr('data-date');
				$this.addClass('active').siblings('li').removeClass('active');
				$('.mod_address_slide_list').removeClass('hide');
				$('.mod_address_slide_list li').each(function () {
					$(this).removeClass('active');
				});
			});

			//点击时间
			$('.mod_address_slide_list li').off('click').on('click', function () {
				var $this = $(this);
				date = $('.mod_address_slide_tabs').find('li.active').attr('data-date'),
					time = $this.attr('data-time');
				$('.mod_address_slide_list').find('li').removeClass('active');
				$this.addClass('active');

				var val = date + ' ' + time;
				$('input[name="expect_pickup_time"]').val(val);

				$('.mod_address_slide').removeClass('show');
			});
		},

		show_goods_list_click: function () {
			$('.order-detail-list li.hd').on('click', function () {
				if (!$(this).hasClass('active')) {
					$(this).addClass('active');
					$(this).next(".order-goods-detail").addClass('active');
				} else {
					$(this).removeClass('active');
					$(this).next(".order-goods-detail").removeClass('active');
				}
			})
		},

		show_share_click: function () {
			$('.commont-show-active .hd').on('click', function () {
				if (!$(this).parent('.user-share').hasClass('user-share-show')) {
					$(this).parent('.user-share').addClass('user-share-show');
				} else {
					$(this).parent('.user-share').removeClass('user-share-show');
				}
			})
		},

		affiliate: function () {
			var InterValObj; //timer变量，控制时间
			var count = 60; //间隔函数，1秒执行
			var curCount; //当前剩余秒数

			$('.identify_code_btn').off('click').on('click', function () {
				var $this = $(this),
					mobile = $('input[name="mobile"]').val(),
					code_captcha = $('input[name="code_captcha"]').val(),
					url = $this.attr('data-url');
				if ($this.attr('disabled') == 'disabled') {
					return false;
				}
				if (mobile || mobile == '') {
					if (mobile.length == 11) {
						url += '&mobile=' + mobile;
					} else {
						alert('请输入正确的手机号');
						return false;
					}
				}

				if (code_captcha || code_captcha == '') {
					if (code_captcha == '') {
						alert("请输入验证码");
						return false;
					} else {
						url += '&code_captcha=' + code_captcha;
					}
				}

				$.get(url, function (data) {
					if (data.state == 'success') {　
						curCount = count;
						$("#mobile").attr("readonly", "true");
						$(".identify_code_btn").attr("disabled", "true");
						$('.identify_code').addClass('disabled');
						$(".identify_code_btn").html(curCount + "s");
						InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
					}
					if (data.registered == 1) {
						var myApp = new Framework7({
							modalButtonCancel: '取消',
							modalButtonOk: '确定',
							modalTitle: ''
						});
						var url = data.url;
						myApp.confirm(data.message, function () {
							ecjia.pjax(url);
						});
						return false;
					}
					ecjia.touch.showmessage(data);
				});
			});

			$('.identify_code').off('click').on('click', function () {
				var $this = $(this),
					url = $this.attr('data-url');
				if ($this.hasClass('disabled')) {
					return false;
				}
				$.post(url, function (data) {
					if (data.state == 'error') {
						ecjia.touch.showmessage(data);
						return false;
					}
					$this.find('img').attr('src', 'data:image/png;base64,' + data.message);
				});
			});

			//timer处理函数
			function SetRemainTime() {
				if (curCount == 0) {
					window.clearInterval(InterValObj); //停止计时器
					$("#mobile").removeAttr("readonly"); //启用按钮
					$(".identify_code_btn").removeAttr("disabled"); //启用按钮
					$(".identify_code_btn").html("验证");
					$('.identify_code').removeClass('disabled');
				} else {
					curCount--;
					$(".identify_code_btn").attr("disabled", "true");
					$(".identify_code_btn").html(curCount + "s");
				}
			};

			$("form[name='inviteForm']").on('submit', function (e) {
				e.preventDefault();
				return false;
			}).Validform({
				tiptype: function (msg, o, cssctl) {
					if (o.type == 3) {
						alert(msg);
					}
				},
				ajaxPost: true,
				callback: function (data) {
					ecjia.touch.showmessage(data);
				}
			});
		}
	};

	ecjia.touch.address_form = {
		init: function () {
			ecjia.touch.address_form.choose_pcd();
			ecjia.touch.address_form.choose_street();

			$("form[name='theForm']").on('submit', function (e) {
				e.preventDefault();
				return false;
			}).Validform({
				tiptype: function (msg, o, cssctl) {
					//msg：提示信息;
					//o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
					//cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
					if (o.type == 3) {
						alert(msg);
					}
				},
				ajaxPost: true,
				callback: function (data) {
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
		},

		choose_pcd: function () {
			var province = $("input[name='province_list']").val();
			var city = $("input[name='city_list']").val();
			var district = $("input[name='district_list']").val();

			var clear = $("input[name='clear']").val();
			if (clear == 1) {
				sessionStorage.removeItem('province_id');
				sessionStorage.removeItem('province_name');
				sessionStorage.removeItem('city_id');
				sessionStorage.removeItem('city_name');
				sessionStorage.removeItem('district_id');
				sessionStorage.removeItem('district_name');
				sessionStorage.removeItem('street_id');
				sessionStorage.removeItem('street_name');
			} else if (clear == 2) {
				var temp_data = {
					'province_id': $("input[name='province']").val(),
					'province_name': $("input[name='province_name']").val(),
					'city_id': $("input[name='city']").val(),
					'city_name': $("input[name='city_name']").val(),
					'district_id': $("input[name='district']").val(),
					'district_name': $("input[name='district_name']").val(),
					'street_id': $("input[name='street']").val(),
					'street_name': $("input[name='street_name']").val()
				};
				save_temp(temp_data);
			} else {
				var temp_province_id = sessionStorage.getItem('province_id');
				if (temp_province_id != null) {
					$('input[name="province"]').val(temp_province_id);
				}
				var temp_city_id = sessionStorage.getItem('city_id');
				if (temp_city_id != null) {
					$('input[name="city"]').val(temp_city_id);
				}
				var temp_district_id = sessionStorage.getItem('district_id');
				if (temp_district_id != null) {
					$('input[name="district"]').val(temp_district_id);
				}
				var temp_street_id = sessionStorage.getItem('street_id');
				if (temp_street_id != null) {
					$('input[name="street"]').val(temp_street_id);
				}

				var val = '';
				var temp_province_name = sessionStorage.getItem('province_name');
				if (temp_province_name != null) {
					val += temp_province_name;
				}
				var temp_city_name = sessionStorage.getItem('city_name');
				if (temp_city_name != null) {
					val += '-' + temp_city_name;
				}
				var temp_district_name = sessionStorage.getItem('district_name');
				if (temp_district_name != null) {
					val += '-' + temp_district_name;
				}
				if (val != '') {
					$('.ecjia_user_address_picker').html(val);
				}
				var temp_street_name = sessionStorage.getItem('street_name');

				if (temp_street_name != null) {
					$('.ecjia_user_address_street_picker').html(temp_street_name);
				}
			}

			if ($.localStorage('province') == undefined) {
				$.localStorage('province', province);
			}
			if ($.localStorage('city') == undefined) {
				$.localStorage('city', city);
			}
			if ($.localStorage('district') == undefined) {
				$.localStorage('district', district);
			}
			var data = region_data('', '', '');

			var province_list = data[0];
			var province_list_name = data[1];
			var city_list = data[2];
			var city_list_name = data[3];
			var district_list = data[4];
			var district_list_name = data[5];

			var url = $('.ecjia_user_address_picker').attr('data-url');
			var myApp = new Framework7();

			var pickerCustomToolbar = myApp.picker({
				input: '.ecjia_user_address_picker',
				cssClass: 'ecjia-user-address-picker',
				toolbarTemplate: '<div class="toolbar">' +
					'<div class="toolbar-inner">' +
					'<div class="left">' +
					'<a href="javascript:;" class="link close-picker external">取消</a>' +
					'</div>' +
					'<div class="right">' +
					'<a href="javascript:;" class="link save-picker external">完成</a>' +
					'</div>' +
					'</div>' +
					'</div>',
				cols: [{
						values: province_list,
						displayValues: province_list_name,
						onChange: function (picker, value) {
							var data = region_data(value, '', '');
							if (picker.cols[1].replaceValues) {
								picker.cols[1].replaceValues(data[2], data[3]);
							}
							if (picker.cols[2].replaceValues) {
								picker.cols[2].replaceValues(data[4], data[5]);
							}
						}
					},
					{
						values: city_list,
						displayValues: city_list_name,
						onChange: function (picker, value) {
							var data = region_data('', value, '');
							if (picker.cols[2].replaceValues) {
								picker.cols[2].replaceValues(data[4], data[5]);
							}
						}
					},
					{
						values: district_list,
						displayValues: district_list_name
					},
				],
				onOpen: function (picker) {
					var $pick_overlay = '<div class="picker-modal-overlay"></div>';
					if ($('.picker-modal').hasClass('modal-in')) {
						$('.picker-modal').after($pick_overlay);
					}

					var province = $('input[name="province"]').val();
					var city = $('input[name="city"]').val();
					var district = $('input[name="district"]').val();
					picker.setValue([province, city, district]); //设置选中值

					picker.container.find('.save-picker').on('click', function () {
						var district_value = $('input[name="district"]').val();
						var col0 = picker.cols[0].container.find('.picker-selected');
						var col1 = picker.cols[1].container.find('.picker-selected');
						var col2 = picker.cols[2].container.find('.picker-selected');

						var html = col0.html();
						$('input[name="province_name"]').val(html);

						if (col1.html() != '暂无') {
							html += '-' + col1.html();
							$('input[name="city_name"]').val(col1.html());
						}
						if (col2.html() != '暂无') {
							html += '-' + col2.html();
							$('input[name="district_name"]').val(col2.html());
						}
						$('.ecjia_user_address_picker').html(html);

						var col0Value = col0.attr('data-picker-value');
						var col1Value = col1.attr('data-picker-value');
						var col2Value = col2.attr('data-picker-value');
						$('input[name="province"]').val(col0Value);
						$('input[name="city"]').val(col1Value);
						$('input[name="district"]').val(col2Value);

						if (district_value != col2Value) {
							$('.ecjia_user_address_street_picker').html('请选择街道');
							$('input[name="street"]').val('');
						}

						var key = 'street_' + col2Value;
						if ($.localStorage(key) == undefined) {
							$.post(url, {
								district_id: col2Value
							}, function (data) {
								$('input[name="street_list"]').val(data.street_list);
								$.localStorage(key, data.street_list);
							});
						}

						var temp_data = {
							'province_id': col0Value,
							'province_name': col0.html(),
							'city_id': col1Value,
							'city_name': col1.html(),
							'district_id': col2Value,
							'district_name': col2.html(),
						};
						save_temp(temp_data);
						picker.close();
						remove_overlay();
					});
					picker.container.find('.close-picker').on('click', function () {
						picker.close();
						remove_overlay();
					});
				},
				onClose: function (picker) {
					picker.close();
					remove_overlay();
				}
			});

			$('.ecjia_user_address_street_picker').off('click').on('click', function () {
				var province = $('input[name="province"]').val();
				var city = $('input[name="city"]').val();
				var district = $('input[name="district"]').val();
				if (province == '' || city == '' || district == '') {
					alert('请先选择所在地区');
					return false;
				}
			});
		},

		choose_street: function () {
			var App = new Framework7();
			var pickerStreetToolbar = App.picker({
				input: '.ecjia_user_address_street_picker',
				cssClass: 'ecjia-user-address-street-picker',
				toolbarTemplate: '<div class="toolbar">' +
					'<div class="toolbar-inner">' +
					'<div class="left">' +
					'<a href="javascript:;" class="link close-picker external">取消</a>' +
					'</div>' +
					'<div class="right">' +
					'<a href="javascript:;" class="link save-picker external">完成</a>' +
					'</div>' +
					'</div>' +
					'</div>',
				cols: [{
					values: [''],
					displayValues: ['请选择所在街道'],
				}, ],
				onOpen: function (picker) {
					var $pick_overlay = '<div class="picker-modal-overlay"></div>';
					if ($('.picker-modal').hasClass('modal-in')) {
						$('.picker-modal').after($pick_overlay);
					}

					var district = $('input[name="district"]').val();
					var key = 'street_' + district;
					if ($.localStorage(key) == undefined) {
						var street_list = $("input[name='street_list']").val();
						$.localStorage(key, street_list);
					}
					var data = region_data('', '', district);
					picker.cols[0].replaceValues(data[6], data[7]);
					var street = $('input[name="street"]').val();
					picker.setValue([street]); //设置选中值

					picker.container.find('.save-picker').on('click', function () {
						var col0 = picker.cols[0].container.find('.picker-selected');
						var col0Value = col0.attr('data-picker-value');
						if (col0Value.length != 0) {
							var html = col0.html();
							$('input[name="street_name"]').val(html);

							$('.ecjia_user_address_street_picker').html(html);
							$('input[name="street"]').val(col0Value);
							var temp_data = {
								'street_id': col0Value,
								'street_name': html
							};
							save_temp(temp_data);
						}
						picker.close();
						remove_overlay();
					});
					picker.container.find('.close-picker').on('click', function () {
						picker.close();
						remove_overlay();
					});
				},
				onClose: function (picker) {
					picker.close();
					remove_overlay();
				}
			});
		}
	};

	function uniqueId() {
		return (new Date).getTime()
	}

	//处理地区数据
	function region_data(province_id, city_id, district_id) {
		var province = eval($.localStorage('province'));
		var city = eval($.localStorage('city'));
		var district = eval($.localStorage('district'));
		var street = eval($.localStorage('street_' + district_id));

		var province_value = [];
		var province_display_value = [];
		if (district_id == '') {
			for (i = 0; i < province.length; i++) {
				var name = province[i]['name'];
				var id = province[i]['id'];
				province_value.push(id);
				province_display_value.push(name);
			};
		}
		if (province_id == '') {
			province_id = province_value[0];
		}

		var city_value = [];
		var city_display_value = [];
		if (district_id == '') {
			for (i = 0; i < city.length; i++) {
				if (city[i]['parent_id'] == province_id) {
					var name = city[i]['name'];
					var id = city[i]['id'];
					city_value.push(id);
					city_display_value.push(name);
				}
			};
		}
		if (city_id == '') {
			city_id = city_value[0];
		}
		var district_value = [];
		var district_display_value = [];
		if (district_id == '') {
			for (i = 0; i < district.length; i++) {
				if (district[i]['parent_id'] == city_id) {
					var name = district[i]['name'];
					var id = district[i]['id'];
					district_value.push(id);
					district_display_value.push(name);
				}
			};
		}

		if (district_id == '') {
			district_id = district_value[0];
		}

		var street_value = [];
		var street_display_value = [];
		if (street != undefined) {
			for (i = 0; i < street.length; i++) {
				if (street[i]['parent_id'] == district_id) {
					var name = street[i]['name'];
					var id = street[i]['id'];
					street_value.push(id);
					street_display_value.push(name);
				}
			};
		}
		if (district_value.length == 0 || district_display_value.length == 0) {
			district_value = [''];
			district_display_value = ['暂无'];
		}
		if (street_value.length == 0 || street_display_value.length == 0) {
			street_value = [''];
			street_display_value = ['暂无'];
		}
		return [province_value, province_display_value, city_value, city_display_value, district_value, district_display_value, street_value, street_display_value];
	}

	function save_temp(arr) {
		for (var i in arr) {
			sessionStorage.setItem(i, arr[i]);
			if (arr['street_id'] == undefined) {
				sessionStorage.removeItem('street_id');
				sessionStorage.removeItem('street_name');
			}
		}
	}

	function remove_overlay() {
		$('.modal-overlay').remove();
		$('.picker-modal-overlay').remove();
	}
})(ecjia, jQuery);

//end