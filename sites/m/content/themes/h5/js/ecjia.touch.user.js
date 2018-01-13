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
			ecjia.touch.user.cancel_order();

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

		cancel_order: function() {
			$('.cancel_order').off('click').on('click', function(e) {
				e.preventDefault();
				var myApp = new Framework7();
				var url = $(this).attr('href');
				myApp.modal({
					title: '您确定要取消该订单吗？',
					buttons: [{
						text: '取消',
					}, {
						text: '确定',
						onClick: function() {
							$.post(url, function(data) {
								ecjia.touch.showmessage(data);
							});
						},
					}]
				});
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

	ecjia.touch.address_form = {
		init: function() {
			ecjia.touch.address_form.choose_pcd();
			ecjia.touch.address_form.choose_street();
			
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
		},
		
		choose_pcd: function() {
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
				var temp_province_name 	= sessionStorage.getItem('province_name');
				if (temp_province_name != null) {
					val += temp_province_name;
				}
				var temp_city_name 		= sessionStorage.getItem('city_name');
				if (temp_city_name != null) {
					val += '-' + temp_city_name;
				}
				var temp_district_name 	= sessionStorage.getItem('district_name');
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
			
			var province_list 	= data[0];
			var province_list_name 	= data[1];
			var city_list 		= data[2];
			var city_list_name 		= data[3];
			var district_list 	= data[4];
			var district_list_name 	= data[5];
			
			var url = $('.ecjia_user_address_picker').attr('data-url');
			var myApp = new Framework7();

			var pickerCustomToolbar = myApp.picker({
			    input: '.ecjia_user_address_picker',
			    cssClass: 'ecjia-user-address-picker',
			    toolbarTemplate: 
			        '<div class="toolbar">' +
			            '<div class="toolbar-inner">' +
			                '<div class="left">' +
			                    '<a href="javascript:;" class="link close-picker external">取消</a>' +
			                '</div>' +
			                '<div class="right">' +
			                    '<a href="javascript:;" class="link save-picker external">完成</a>' +
			                '</div>' +
			            '</div>' +
			        '</div>',
			    cols: [
			        {
			            values: province_list,
			            displayValues: province_list_name,
			            onChange: function(picker, value) {
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
			            onChange: function(picker, value) {
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
			    	var province = $('input[name="province"]').val();
					var city = $('input[name="city"]').val();
					var district = $('input[name="district"]').val();
			    	picker.setValue([province, city, district]);//设置选中值
			    	
			        picker.container.find('.save-picker').on('click', function () {
			        	var district_value = $('input[name="district"]').val();
			        	var col0 = picker.cols[0].container.find('.picker-selected');
			        	var col1 = picker.cols[1].container.find('.picker-selected');
			        	var col2 = picker.cols[2].container.find('.picker-selected');
			        	
		        		var html = col0.html();
		        		$('input[name="province_name"]').val(html);
		        		
		        		if (col1.html() != '暂无') {
		        			html += '-'+col1.html();
		        			$('input[name="city_name"]').val(col1.html());
		        		}
		        		if (col2.html() != '暂无') {
		        			html += '-'+col2.html();
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
		        		$.post(url, {district_id:col2Value}, function(data) {
							$('input[name="street_list"]').val(data.street_list);
							var key = 'street_' + col2Value;
					    	$.localStorage(key, data.street_list);
						});
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
						$('.modal-overlay').remove();
			        });
			        picker.container.find('.close-picker').on('click', function () {
			    		picker.close();
				    	$('.modal-overlay').remove();
			    	});
			    },
			    onClose: function(picker) {
			    	picker.close();
			    	$('.modal-overlay').remove();
			    }
			});
			
			$('.ecjia_user_address_street_picker').off('click').on('click', function() {
				var province = $('input[name="province"]').val();
				var city = $('input[name="city"]').val();
				var district = $('input[name="district"]').val();
				if (province == '' || city == '' || district == '') {
					alert('请先选择所在地区');
					return false;
				}
			});
		},
		
		choose_street: function() {
			var App = new Framework7();
			var pickerStreetToolbar = App.picker({
			    input: '.ecjia_user_address_street_picker',
			    cssClass: 'ecjia-user-address-street-picker',
			    toolbarTemplate: 
			        '<div class="toolbar">' +
			            '<div class="toolbar-inner">' +
			                '<div class="left">' +
			                    '<a href="javascript:;" class="link close-picker external">取消</a>' +
			                '</div>' +
			                '<div class="right">' +
			                    '<a href="javascript:;" class="link save-picker external">完成</a>' +
			                '</div>' +
			            '</div>' +
			        '</div>',
			    cols: [
			        {
			            values: [''],
			            displayValues: ['请选择所在街道'],
			        },
			    ],
			    onOpen: function (picker) {
			    	var district = $('input[name="district"]').val();
			    	var key = 'street_' + district;
			    	if ($.localStorage(key) == undefined) {
			    		var street_list = $("input[name='street_list']").val();
				    	$.localStorage(key, street_list);
			    	}
			    	var data = region_data('', '', district);
			    	picker.cols[0].replaceValues(data[6], data[7]);
			    	var street = $('input[name="street"]').val();
			    	picker.setValue([street]);//设置选中值
			    	
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
						$('.modal-overlay').remove();
			        });
			        picker.container.find('.close-picker').on('click', function () {
			    		picker.close();
				    	$('.modal-overlay').remove();
			    	});
			    },
			    onClose: function(picker) {
			    	picker.close();
			    	$('.modal-overlay').remove();
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
})(ecjia, jQuery);

//end