// JavaScript Document
;
(function(app, $) {
	app.install = {
		init: function() {
			//判断用户是否同意协议
            $("#agree").change(function() {   
                if ($("#agree").prop("checked")) {
                	$.cookie('agree', 1);
                    $("#ecjia_install").attr('disabled',false);//按钮可用  
                } else {  
                	$.cookie('agree', null);
                    $("#ecjia_install").attr('disabled',true);//按钮不可用  
                }   
            }); 

			//检查数据库账号密码是否正确，数据库版本是否小于5.5
			$('#dbpassword').blur(function() {
				var params = "db_host=" + $("#dbhost").val() + "&" 
					+ "db_port=" + $("#dbport").val() + "&" 
					+ "db_user=" + $("#dbuser").val() + "&" 
					+ "db_pass=" + $("#dbpassword").val() + "&" 
					+ "dbdatabase=" + $('#dbdatabase').val();
				var url = $('.check_db_correct').attr('data-url');
				$.ajax({
					type: 'post',
					url: url,
					data: params,
					async: false,
					success: function(result) {
						if (result.state == 'error') {
							$('input[name="database_config"]').val(0); //数据库账号密码错误
							smoke.alert(result.message, {ok: '确定',});
							return false;
						} else if (result.state == 'success') {
							$('input[name="database_config"]').val(1); //数据库账号密码正确
						}
					},
				});
			});

			//检查数据库是否存在
			$('#dbdatabase').blur(function() {
				var dbdatabase = $('#dbdatabase').val();
				var params = "db_host=" + $("#dbhost").val() + "&" 
					+ "db_port=" + $("#dbport").val() + "&" 
					+ "db_user=" + $("#dbuser").val() + "&" 
					+ "db_pass=" + $("#dbpassword").val() + "&" 
					+ "dbdatabase=" + $('#dbdatabase').val();
				var url = $('.check_db_exists').attr('data-url');
				$.ajax({
					type: 'post',
					url: url,
					data: params,
					async: false,
					success: function(result) {
						if (result.is_exist == true) {
							smoke.confirm('该数据库名称已存在，确定要覆盖该数据库信息吗？', function(e) {
								if (e) {
									$('input[name="is_create"]').val(0); //不创建数据库
								} else {
									$('#dbdatabase').val(dbdatabase).focus();
									$('input[name="is_create"]').val(1); //创建数据库
								}
							}, {
								ok: '确定',
								cancel: '取消'
							});
						} else {
							$('input[name="is_create"]').val(1); //创建数据库
						}
					},
				});
			});

			//用户名密码验证
			$('#userpassword').blur(function() {
				var password = $('#userpassword').val();
				var confirm_password = $('#confirmpassword').val();

				if (!(password.length >= 8 && /\d+/.test(password) && /[a-zA-Z]+/.test(password))) {
					$("#ecjia_install").prop("disabled", "true");
					if (!(password.length >= 8)) {
						$('.password-error').html('密码长度不能小于8');
					} else {
						$('.password-error').html('密码必须同时包含字母及数字');
					}
				} else {
					$('.password-error').html('');
					if (password == confirm_password) {
						$("#ecjia_install").prop("disabled", false);
						$('.confirmpassword-error').html('');
					} else {
						$("#ecjia_install").prop("disabled", "true");
						if (confirm_password != '') {
							$('.password-error').html('密码不相同');
						}
					}
				}
			});

			//确认用户名密码验证
			$('#confirmpassword').blur(function() {
				var password = $('#userpassword').val();
				var confirm_password = $('#confirmpassword').val();

				if (!(confirm_password.length >= 8 && /\d+/.test(confirm_password) && /[a-zA-Z]+/.test(confirm_password) && password == confirm_password)) {
					$("#ecjia_install").prop("disabled", "true");

					if (!(confirm_password.length >= 8)) {
						$('.confirmpassword-error').html('密码长度不能小于8');
					} else {
						if (password == confirm_password) {
							$('.confirmpassword-error').html('密码必须同时包含字母及数字');
						} else {
							$('.confirmpassword-error').html('密码不相同');
						}
					}
				} else {
					$("#ecjia_install").prop("disabled", false);
					$('.confirmpassword-error').html('');
					$('.password-error').html('');
				}
			});
		},

		//初始化配置必填项验证
		start: function() {
			var dbhost = $('#dbhost').val();
			var dbport = $('#dbport').val();
			var dbuser = $('#dbuser').val();
			var dbpassword = $('#dbpassword').val();
			var dbdatabase = $('#dbdatabase').val();
			var dbprefix = $('#dbprefix').val();
			var username = $('#username').val();
			var userpassword = $('#userpassword').val();
			var confirmpassword = $('#confirmpassword').val();
			var usermail = $('#usermail').val();
			var is_create = $('input[name="is_create"]').val();
			
			if ($.trim(dbhost) == '') {
				showmessage('dbhost', '请输入数据库主机名称');
				return false;
			}
			if ($.trim(dbport) == '') {
				showmessage('dbport', '请输入数据库端口号');
				return false;
			}
			if ($.trim(dbuser) == '') {
				showmessage('dbuser', '请输入数据库用户名');
				return false;
			}
			if ($.trim(dbdatabase) == '') {
				showmessage('dbdatabase', '请输入数据库名称');
				return false;
			}
			if ($.trim(dbprefix) == '') {
				showmessage('dbprefix', '请输入数据库前缀');
				return false;
			}
			if ($.trim(username) == '') {
				showmessage('username', '请输入管理员名称');
				return false;
			}
			if ($.trim(userpassword) == '') {
				showmessage('userpassword', '请输入管理员登录密码');
				return false;
			}
			if ($.trim(confirmpassword) == '') {
				showmessage('confirmpassword', '请输入管理员登录确认密码');
				return false;
			}
			var reg = /\w+[@]{1}\w+[.]\w+/;
			if ($.trim(usermail) == '') {
				showmessage('usermail', '请输入管理员电子邮箱');
				return false;
			} else if (!reg.test(usermail)) {
				showmessage('usermail', '请输入正确的email格式');
				return false;
			}
			
			//验证数据库密码是否正确
			var params = "db_host=" + dbhost + "&" 
				+ "db_port=" + dbport + "&" 
				+ "db_user=" + dbuser + "&" 
				+ "db_pass=" + dbpassword + "&" 
				+ "dbdatabase=" + dbdatabase;
			var url = $('.check_db_correct').attr('data-url');
			
			var status = true;
			$.ajax({
				type: 'post',
				url: url,
				data: params,
				async: false,
				success: function(result) {
					if (result.state == 'error') {
						smoke.alert(result.message, {ok: '确定',});
						status = false;
					}
				},
			});
			if (status == false) {
				return false;
			}
			
			//验证是否确认覆盖数据库
			if (is_create == 1) {
				var check_result;
				var url = $('.check_db_exists').attr('data-url');
				$.ajax({
					type: 'post',
					url: url,
					data: params,
					async: false,
					success: function(result) {
						check_result = result;
					},
				});
				if (check_result.is_exist == true) {
					smoke.confirm('该数据库名称已存在，确定要覆盖该数据库信息吗？', function(e) {
						if (e) {
							status = true;
							$('input[name="is_create"]').val(0); //覆盖数据库
							start_install();
						} else {
							status = false;
							$('#dbdatabase').val(dbdatabase).focus();
							return false;
						}
					}, {
						ok: '确定',
						cancel: '取消'
					});
				} else {
					start_install();
				}
			} else {
				start_install();
			}
		},

		return_setting: function() {
			$('body').css('height', 'auto');
			$('#js-ecjia_deploy').css('display', 'block');
			$('#js-monitor').css('display', 'none');
			$('#js-monitor-notice').css('display', 'none');

			$('input[name="is_create"]').val(1);
			$('.path').children('li').removeClass('current').eq(2).addClass('current');
			$('#js-install-return-once').css('display', 'none');
		},

		check: function() {
			if ($('.configuration_system_btn').hasClass('disabled')) {
				smoke.alert('当前配置不满足ECJIA到家安装需求，无法继续安装！', {ok: '确定',});
				return false;
			}
		},
	};

	var lf = "<br />";
	var notice = null;
	var notice_html = '';
	var correct_img = $('input[name="correct_img"]').val();
	var error_img = $('input[name="error_img"]').val();

	function progress(val) {
		var html;
		if (val == 100) {
			html = '安装完成'
		} else {
			html = val + '%';
		}
		$('.progress-bar').css('width', val + '%');
		$('.progress-bar').html(html);
	}

	//安装程序
	function install() {
		$("#js-monitor").css('display', 'block');
		$('#js-monitor-notice').css('display', 'block');
		createConfigFile();
	}

	//创建配置文件
	function createConfigFile() {
		var tzs = $("#js-timezones");
		var tz = tzs ? "timezone=" + tzs.val() : "";
		var params = "db_host=" + $("#dbhost").val() + "&" 
			+ "db_port=" + $("#dbport").val() + "&" 
			+ "db_user=" + $("#dbuser").val() + "&" 
			+ "db_pass=" + $("#dbpassword").val() + "&" 
			+ "db_name=" + $("#dbdatabase").val() + "&" 
			+ "db_prefix=" + $("#dbprefix").val() + "&" + tz;

		notice_html = '<div class="install_notice">创建配置文件</div>';
		$('#js-notice').html(notice_html);

		var url = $('input[name="create_config_file"]').val();
		var is_create = $('input[name="is_create"]').val();
		$.post(url, params, function(result) {
			if (result.state == 'error') {
				ErrorMsg(result.message);
			} else {
				SuccessMsg();
				progress(20);
				if (is_create == 1) {
					createDatabase();
				} else {
					installStructure();
				}
			}
		});
	}
	
	// 初始化数据库
	function createDatabase() {
		var params = "db_host=" + $("#dbhost").val() + "&" 
			+ "db_port=" + $("#dbport").val() + "&" 
			+ "db_user=" + $("#dbuser").val() + "&" 
			+ "db_pass=" + $("#dbpassword").val() + "&" 
			+ "db_name=" + $("#dbdatabase").val();

		notice_html += '<div class="install_notice">创建数据库</div>', $('#js-notice').html(notice_html);

		var url = $('input[name="create_database"]').val();
		$.post(url, params, function(result) {
			if (result.state == 'error') {
				ErrorMsg(result.message);
			} else {
				SuccessMsg();
				progress(40);
				installStructure();
			}
		});
	}

	//提示程序安装终止信息
	function stopNotice() {
		$("#js-monitor-wait-please").html('安装进程已中止');
	};

	//显示完成（成功）信息
	function SuccessMsg() {
		notice_html += "<span class='install_correct'><img src=" + correct_img + "> 成功 </span>" + lf;
		$('#js-notice').html(notice_html);
	}

	//显示错误信息
	function ErrorMsg(result) {
		stopNotice();
		notice_html += "<span class='install_error'><img src=" + error_img + "> 失败 </span>" + lf;
		$("#js-monitor-notice").css('display', "block");

		notice_html += "<strong class='m_l30' style='color:red'>提示：" + result + "</strong>";
		$('#js-notice').html(notice_html);
		$('#js-install-return-once').css('display', 'block');
	}

	//安装数据库结构
	function installStructure() {
		notice_html += '<div class="install_notice">安装数据库结构</div>';
		$('#js-notice').html(notice_html);

		var url = $('input[name="install_structure"]').val();
		$.post(url, '', function(result) {
			if (result.state == 'error') {
				ErrorMsg(result.message);
			} else {
				progress(60);
				SuccessMsg();
				installBaseData();
			}
		});
	}

	//安装基础数据
	function installBaseData() {
		notice_html += '<div class="install_notice">安装基础数据</div>';
		$('#js-notice').html(notice_html);

		var url = $('input[name="install_base_data"]').val();
		$.post(url, '', function(result) {
			if (result.state == 'error') {
				ErrorMsg(result.message);
			} else {
				progress(80);
				SuccessMsg();
				if ($("input[name='js-install-demo']").attr("checked")) {
					installDemoData();
				} else {
					createAdminPassport();
				}

			}
		});
	}

	//安装演示数据
	function installDemoData() {
		notice_html += '<div class="install_notice">安装演示数据</div>';
		$('#js-notice').html(notice_html);

		var url = $('input[name="install_demo_data"]').val();
		$.post(url, '', function(result) {
			if (result.state == 'error') {
				ErrorMsg(result.message);
			} else {
				progress(90);
				SuccessMsg();
				createAdminPassport();
			}
		});
	}

	//创建管理员帐号
	function createAdminPassport() {
		notice_html += '<div class="install_notice">创建管理员帐号</div>';
		$('#js-notice').html(notice_html);

		var params = "admin_name=" + $("#username").val() + "&" 
			+ "admin_password=" + $("#userpassword").val() + "&" 
			+ "admin_password2=" + $("#confirmpassword").val() + "&" 
			+ "admin_email=" + $("#usermail").val();

		var url = $('input[name="create_admin_passport"]').val();
		$.post(url, params, function(result) {
			if (result.state == 'error') {
				ErrorMsg(result.message);
			} else {
				progress(100);
				SuccessMsg();
				var url = $('input[name="done"]').val();
				window.setTimeout(function() {
					location.href = url;
				}, 1000);
			}
		});
	}

	//验证配置信息必填项
	function showmessage(id, msg) {
		$('.ui_showmessage').find('.close').parent().remove();
		$('.control-group').removeClass("error f_error");

		var html = $('<div class="staticalert alert alert-error ui_showmessage"><a class="close" data-dismiss="alert">×</a>' + msg + '</div>');
		$('#js-ecjia_deploy').before(html);

		$('#' + id).closest("li.control-group").addClass("error f_error");;
		$('body,html').animate({
			scrollTop: 0
		}, 300);

		$('.close').on('click', function() {
			$('.ui_showmessage').find('.close').parent().remove();
		});
		window.setTimeout(function() {
			html.remove()
		}, 3000);
	}
	
	function start_install() {
		$('.ui_showmessage').find('.close').parent().remove();
		$('.control-group').removeClass("error f_error");
		$('body').scrollTop(0).css('height', '100%');
		$('#js-ecjia_deploy').css('display', 'none');
		$('.path').children('li').removeClass('current').eq(3).addClass('current');

		progress(0);
		install();
		$.cookie('install_step4', 1);
		return false;
	}

})(ecjia.front, jQuery);

//end