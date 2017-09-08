;
(function(ecjia, $) {
	ecjia.bind = {
		init: function() {
			//绑定
			$('.ecjia-bind-login').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('href');
				var username = $('input[name="username"]').val();
				var password = $('input[name="password"]').val();
				var openid = $('input[name="openid"]').val();
				var uuid = $('input[name="uuid"]').val();
				var info = {
					'username': username,
					'password': password,
					'openid': openid,
					'uuid': uuid,
				};
				$.post(url, info, function(data) {
					if (data.state == 'error') {
						alert(data.message);
					} else if (data.state == 'success'){
						location.href = data.url;
					}
				});
				
			});
			
			//重设密码
			$('.reset_pwd').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('href');
				var mobile_value = $('input[name="mobile_value"]').val();
				if(mobile_value =='') {
					alert('请先绑定手机号');
				} else {
					location.href = url;
				}
			});
			
			ecjia.bind.get_code();
			ecjia.bind.next_pwd();
			ecjia.bind.finish_pwd();
			ecjia.bind.bind_mobile();
			
		},
		
		//重设密码获取验证码请求
		get_code: function() {
			var InterValObj; //timer变量，控制时间
			var count = 120; //间隔函数，1秒执行
			var curCount; //当前剩余秒数
			
			$('#get_code').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('href');
				var mobile = $("input[name='mobile']").val();
				var info = {'mobile': mobile};
				
				var date = new Date();
				date.setTime(date.getTime() + (30 * 60 * 1000));
				$.cookie('wechat_get_code_url', url, {expires: date});
				$.post(url, info, function(data) {
					if (data.state == 'success') {　
						curCount = count;
						$("#get_code").text("重新发送" + curCount + "(s)");
						$('#get_code').attr('href','JavaScript:return false;'); 
						$('#get_code').css("cursor", "default");
						$('#get_code').attr("class", "btn-org");
						InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
					}
					alert(data.message);
				});
			});
			
			//timer处理函数
			function SetRemainTime() {
				if (curCount == 0) {
					var url = $.cookie('wechat_get_code_url');
		            window.clearInterval(InterValObj);//停止计时器
		            $("#get_code").text("重新发送");//启用按钮
		            $('#get_code').attr('href', url);
		            $('#get_code').css("cursor", "pointer");
		            $('#get_code').attr("class", "btn");
				} else {
					curCount--;
					$("#get_code").text("重新发送" + curCount + "(s)");
				}
			};
		},
		
		
		//验证码输入校验请求
		next_pwd:function() {
			$('.next_pwd').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('href');
				var code = $('input[name="code"]').val();
				var info = {'code': code};
				$.post(url, info, function(data) {
					if (data.state == 'error') {
						alert(data.message);
					} else if (data.state == 'success'){
						location.href = data.url;
					}
				});
	
			});
		},

		/*设置新密码*/
		finish_pwd: function() {
			$('.finish_pwd').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('href');
				var password         = $("input[name='password']").val();
				var confirm_password = $("input[name='confirm_password']").val();
				var info = {
					'password': password,
					'confirm_password': confirm_password
				};
				$.post(url, info, function(data) {
					if (data.state == 'error') {
						alert(data.message);
					} else if (data.state == 'success'){
						location.href = data.url;
					}
				});
			});
		},
		
		//绑定手机号
		bind_mobile:function() {
			$('.bind_mobile').on('click', function(e) {
				e.preventDefault();
				var url = $(this).attr('href');
				var code = $('input[name="code"]').val();
				var mobile = $('input[name="mobile"]').val();
				var info = {'code': code,'mobile':mobile};
				$.post(url, info, function(data) {
					if (data.state == 'error') {
						alert(data.message);
					} else if (data.state == 'success'){
						alert(data.message);
						location.href = data.url;
					}
				});
	
			});
		}
	};
})(ecjia, jQuery);

//end