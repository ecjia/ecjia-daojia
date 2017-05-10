/**
 * 后台综合js文件
 */
;
(function(ecjia, $) {
	ecjia.touch.franchisee = {
		init: function() {
			/*$("form[name='theForm']").on('submit',function(e){e.preventDefault();return false;}).Validform({
				tiptype:function(msg,o,cssctl){
				//msg：提示信息;
				//o:{obj:*,type:*,curform:*}, obj指向的是当前验证的表单元素（或表单对象），type指示提示的状态，值为1、2、3、4， 1：正在检测/提交数据，2：通过验证，3：验证失败，4：提示ignore状态, curform为当前form对象;
				//cssctl:内置的提示信息样式控制函数，该函数需传入两个参数：显示提示信息的对象 和 当前提示的状态（既形参o中的type）;
					if (o.type == 3){
						//alert(msg);
					}
				},
				ajaxPost: true,
				callback:function(data){
					ecjia.touch.showmessage(data);
				}
			});*/

			ecjia.touch.franchisee.validate_code();
			ecjia.touch.franchisee.next();

			$('.process_search').off('click').on('click', function() {
				var url = $(this).attr('data-url'),
					info = {
						'f_mobile': $("input[name='f_mobile']").val(),
						'f_code': $("input[name='f_code']").val()
					};
				$.post(url, info, function(data) {
					if (data.state == 'error') {
						alert(data.message);
					} else {
						if (typeof(data.pjaxurl) != 'undefined') {
							location.href = data.pjaxurl;
						}
					}
				});
			});
		},

		//商家入驻流程获取验证码
		validate_code: function() {
			var InterValObj; //timer变量，控制时间
			var count = 120; //间隔函数，1秒执行
			var curCount; //当前剩余秒数

			$(".settled-message").on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				var mobile = $("input[name='f_mobile']").val();
				if (mobile.length == 11) {
					url += '&mobile=' + mobile;
				} else {
					alert('请输入正确的手机号');
					return false;
				}

				$.get(url, function(data) {
					if (data.state == 'error') {
						var myApp = new Framework7();
						myApp.modal({
							title: '提示',
							text: data.message,
							buttons: [{
								text: '取消',
								onClick: function() {
									return false;
								}
							}, {
								text: '查看申请进度',
								onClick: function() {
									$('.modal').remove();
									$('.modal-overlay').remove();
									$(".ecjia-store-goods .a1n .a1x").css({
										overflow: "auto"
									}); //启用滚动条
									$('body').css('overflow-y', 'auto').off("touchmove"); //启用滚动条
									if (typeof(data.search_url) != 'undefined') {
										location.href = data.search_url;
									}
									return false;
								}
							}, ]
						});
					}
					if (data.state == 'success') {　curCount = count;
						$("#mobile").attr("readonly", "true");
						$("#get_code").attr("disabled", "true");
						$("#get_code").css("width", "7em");
						$("#get_code").css("right", "4%");
						$("#get_code").css("position", "absolute");
						$("#get_code").css("padding", "0");
						$("#get_code").css("margin", "0");
						$("#get_code").css("top", ".5em");
						$("#get_code").css("height", "2.2em");
						$("#get_code").val("重新发送" + curCount + "(s)");
						$("#get_code").attr("class", "btn btn-org login-btn settled-message btn-small");
						InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
					}
					ecjia.touch.showmessage(data);
				});
				
				//timer处理函数
				function SetRemainTime() {
					if (curCount == 0) {
						window.clearInterval(InterValObj); //停止计时器
						$("#mobile").removeAttr("readonly"); //启用按钮
						$("#get_code").removeAttr("disabled"); //启用按钮
						$("#get_code").val("重新发送");
						$("#get_code").attr("class", "btn btn-info login-btn btn-small settled-message");
					} else {
						curCount--;
						$("#get_code").attr("disabled", "true");
						$("#get_code").val("重新发送" + curCount + "(s)");
					}
				};
			});
		},

		//入驻页面下一步
		next: function() {
			$("input[name='next_button']").on('click', function(e) {
				e.preventDefault();
				var f_name = $("input[name='f_name']").val();
				var f_email = $("input[name='f_email']").val();
				var f_mobile = $("input[name='f_mobile']").val();
				var f_code = $("input[name='f_code']").val();
				var url = $("form[name='theForm']").attr('action');

				if (f_name == '') {
					alert('请输入真实姓名');
					return false;
				}

				if (f_email == '') {
					alert('请输入电子邮箱');
					return false;
				} else {
					var search_str = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
					if (!search_str.test(f_email)) {
						alert("请输入正确的邮箱格式 !");
						return false;
					}
				}

				if (f_mobile == '') {
					alert('请输入手机号码');
					return false;
				}

				if (f_code == '') {
					alert('验证码不能为空');
					return false;
				}

				var referer_url = $('input[name="referer_url"]').val();
				var info = {
					'f_name': f_name,
					'f_email': f_email,
					'f_mobile': f_mobile,
					'f_code': f_code
				};
				$.post(url, info, function(data) {
					if (data.state == 'error') {
						alert(data.message);
					} else {
						if (typeof(data.url) != 'undefined') {
							location.href = data.url;
						}
					}
				});
			});
		},

		//入驻页面下一步
		second: function() {
			$("input[name='franchisee_submit']").on('click', function(e) {
				e.preventDefault();
				var seller_name = $("input[name='seller_name']").val();
				var seller_category = $("input[name='seller_category_id']").val();
				var validate_type = $("input[name='validate_type']").val();
				var province = $("input[name='province_id']").val();
				var city = $("input[name='city_id']").val();
				var district = $("input[name='district_id']").val();
				var address = $("input[name='f_address']").val();
				var longitude = $("input[name='longitude']").val();
				var latitude = $("input[name='latitude']").val();
				var mobile = $("input[name='mobile']").val();
				var code = $("input[name='code']").val();
				$.cookie('seller', $("input[name='seller_category']").val(), {
					expires: 7
				});
				$.cookie('address', address, {
					expires: 7
				});
				$.cookie('seller_name', seller_name, {
					expires: 7
				});
				var url = $("form[name='theForm']").attr('action');
				if (seller_name == '') {
					alert('请输入店铺名称');
					return false;
				}
				if (seller_category == '') {
					alert('请选择店铺分类');
					return false;
				}
				if (validate_type == '') {
					alert('请选择入驻类型');
					return false;
				}
				if (province == '') {
					alert('请选择店铺所在省');
					return false;
				}
				if (city == '') {
					alert('请选择店铺所在市');
					return false;
				}
				if (district == '') {
					alert('请选择店铺所在区');
					return false;
				}
				if (address == '') {
					alert('请填写店铺详细地址');
					return false;
				}
				if (longitude == '' || latitude == '') {
					alert('请获取店铺坐标');
					return false;
				}

				var info = {
					'seller_name': seller_name,
					'seller_category': seller_category,
					'validate_type': validate_type,
					'province': province,
					'city': city,
					'district': district,
					'address': address,
					'longitude': longitude,
					'latitude': latitude,
					'mobile': mobile,
					'code': code
				};
				$.post(url, info, function(data) {
					if (data.state == 'error') {
						alert(data.message);
					} else {
						if (typeof(data.url) != 'undefined') {
							location.href = data.url;
						}
					}
				});
			});
		},

		//店铺入驻选择分类、入驻类型、店铺所在地
		choices: function() {
			//更新店铺名
			var myApp = new Framework7();
			$('input[name="seller_name"]').blur(function() {
				$.cookie('seller_name', $('input[name="seller_name"]').val(), {
					expires: 7
				});
			});

			var category_list = [];
			var category = eval('(' + $("input[name='category']").val() + ')')['data'];
			if (category == null) {
				$("input[name='seller_category']").val('暂无店铺分类，未能入驻');
				$.cookie('seller_category_id', '', {
					expires: 7
				});
			} else {
				for (i = 0; i < category.length; i++) {
					category_list.push(category[i]['name']);
				};
				var pickerDevice = myApp.picker({
					input: '.ecjia-franchisee-category',
					toolbarCloseText: '完成',
					cols: [{
						onChange: function(p, value) {
							$.cookie('seller', value, {
								expires: 7
							});
							for (i = 0; i < category.length; i++) {
								if (category[i]['name'] == value) {
									$.cookie('seller_category_id', category[i]['id']);
									$("input[name='seller_category_id']").val(category[i]['id']);
								}
							}
						},
						textAlign: 'center',
						values: category_list
					}]
				});
			}


			var category_test = $(".picker-selected").attr("data-picker-value");
			var pickerDevice = myApp.picker({
				input: '.ecjia-franchisee-type',
				toolbarCloseText: '完成',
				cols: [{
					textAlign: 'center',
					values: ['个人入驻', '企业入驻'],
					onChange: function(p, value) {
						$.cookie('validate_type', value, {
							expires: 7
						});
					}
				}]
			});

			var province_list = [];
			var province_array = [];

			var city_list = [];
			var city_array = [];

			var district_list = [];
			var district_array = [];

			var province = eval('(' + $("input[name='province']").val() + ')')['data']['regions'];

			for (i = 0; i < province.length; i++) {
				var name = province[i]['name'];
				var id = province[i]['id'];
				province_list.push(name);
				province_array.push({
					name: name,
					id: id
				});
			};

			var pickerProvince = myApp.picker({
				input: '.ecjia-franchisee-location_province',
				toolbarCloseText: '完成',
				formatValue: function(picker, values) {
					return values[1];
				},
				cols: [{
					textAlign: 'center',
					values: province_list,
					onChange: function(picker, city) {
						var province_id;
						for (i = 0; i < province_array.length; i++) {
							if (province_array[i]['name'] == city) {
								province_id = province_array[i]['id'];
								province_name = province_array[i]['name'];
								$(".ecjia-franchisee-location_province").val(province_array[i]['name']);
								break;
							}
						}

						$.cookie('province_id', province_id, {
							expires: 7
						});
						$.cookie('province_name', province_name, {
							expires: 7
						});
						$("input[name='province_id']").val(province_id);

						var url = $('#get_location_region').attr('data-url');
						$.ajax({
							type: "POST",
							url: url,
							data: {
								"parent_id": province_id,
							},
							dataType: "json",
							success: function(data) {
								data = data.content;
								city_list.length = 0;
								city_array.length = 0;
								for (i = 0; i < data.length; i++) {
									var name = data[i]['name'];
									var id = data[i]['id'];
									city_list.push(name);
									city_array.push({
										name: name,
										id: id
									});
								};
							}
						});
					}
				}, ]
			});

			var pickerCity = myApp.picker({
				input: '.ecjia-franchisee-location_city',
				toolbarCloseText: '完成',
				formatValue: function(picker, values) {
					return values[1];
				},
				cols: [{
					textAlign: 'center',
					values: city_list,
					onChange: function(picker, city) {
						var city_id;
						for (i = 0; i < city_array.length; i++) {
							if (city_array[i]['name'] == city) {
								city_id = city_array[i]['id'];
								city_name = city_array[i]['name'];
								$(".ecjia-franchisee-location_city").val(city_array[i]['name']);
								break;
							}
						}

						$.cookie('city_id', city_id, {
							expires: 7
						});
						$.cookie('city_name', city_name, {
							expires: 7
						});
						$("input[name='city_id']").val(city_id);

						var url = $('#get_location_region').attr('data-url');
						$.ajax({
							type: "POST",
							url: url,
							data: {
								"parent_id": city_id,
							},
							dataType: "json",
							success: function(data) {
								data = data.content;
								district_list.length = 0;
								district_array.length = 0;
								for (i = 0; i < data.length; i++) {
									var name = data[i]['name'];
									var id = data[i]['id'];
									district_list.push(name);
									district_array.push({
										name: name,
										id: id
									});
								};
							}
						});
					}
				}, ]
			});

			var pickerDistrict = myApp.picker({
				input: '.ecjia-franchisee-location_district',
				toolbarCloseText: '完成',
				formatValue: function(picker, values) {
					return values[1];
				},
				cols: [{
					textAlign: 'center',
					values: district_list,
					onChange: function(picker, city) {
						var district_id;
						for (i = 0; i < district_array.length; i++) {
							if (district_array[i]['name'] == city) {
								district_id = district_array[i]['id'];
								district_name = district_array[i]['name'];
								$(".ecjia-franchisee-location_district").val(district_array[i]['name']);
								break;
							}
						}
						$.cookie('district_id', district_id, {
							expires: 7
						});
						$.cookie('district_name', district_name, {
							expires: 7
						});
						$("input[name='district_id']").val(district_id);
					}
				}, ]
			});
		},


		//传参到获取精准坐标页
		coordinate: function() {
			var longitude = $("input[name='longitude']").val();
			var latitude = $("input[name='latitude']").val();
			var mobile = $("input[name='mobile']").val();
			var code = $("input[name='code']").val();
			if (longitude != '' && latitude != '') {
				$(".coordinate").html("经度：" + longitude + "；  " + "纬度：" + latitude);
			}

			$(".coordinate").on('click', function(e) {
				var seller_name = $("input[name='seller_name']").val();
				$.cookie('seller_name', seller_name, {
					expires: 7
				});
				var f_province = $("input[name='f_province']").val();
				var f_city = $("input[name='f_city']").val();
				var f_district = $("input[name='f_district']").val();
				var f_address = $("input[name='f_address']").val();

				if (f_province && f_district && f_district && f_address) {
					var url = $(this).attr("data-url");
					var url = url + '&province=' + f_province + '&city=' + f_city + '&district=' + f_district + '&address=' + f_address + '&mobile=' + mobile + '&code=' + code;
					location.href = url;
				} else {
					alert('请输入详细地址');
				}
			})
		},

		location: function() {
			$("#button").on('click', function(e) {
				e.preventDefault();
				var longitude = $("input[name='longitude']").val();
				var latitude = $("input[name='latitude']").val();
				var mobile = $("input[name='mobile']").val();
				var code = $("input[name='code']").val();
				var url = $(this).attr("data-url") + '&longitude=' + longitude + '&latitude=' + latitude + '&mobile=' + mobile + '&code=' + code;
				location.href = url;
			})
		},

		//撤销申请
		cancel_apply: function() {
			$('input[name="cancel"]').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('data-url');
				options = {
					'status': 'cancel',
				}
				var myApp = new Framework7({
					modalButtonCancel: '取消',
					modalButtonOk: '确定',
					modalTitle: '提示'
				});
				myApp.confirm('您确定要撤销申请吗？', function() {
					$.post(url, options, function(data) {
						if (data.log != '') {
							ecjia.pjax(data.cancel_url);
						}
					});
				});

			});
		},
	};

})(ecjia, jQuery);

//end