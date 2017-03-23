// JavaScript Document
;
(function(app, $) {
	app.upgrade = {
		init: function() {
			//版本文件变动
			$('.old_version i').click(function() {
				//展开
				var $this = $(this);
				if ($this.attr('class') == 'fontello-icon-angle-double-down') {
					$this.attr('class','fontello-icon-angle-double-up')
					if (typeof($this.parent().next('ul').html()) == 'undefined') {
						var params = "v=" + $this.attr('data-ver');
						var url = $(".old_version").attr('data-url');
						$.ajax({
							type: 'post',
							url: url,
							data: params,
							async: false,
							success: function(result) {
								if (result.state == 'error') {
									smoke.alert(result.message, {ok: '确定',});
								} else if (result.state == 'success') {
									var files='<ul class=""><li>更新内容</li><li><pre>'+ result.readme +'</pre></li><li>文件变动</li><li><pre>'+ result.files +'</pre></li></ul>';
									$this.parent().css({'margin-bottom': 0, 'border-radius': '4px 4px 0 0'}).after(files);
								}
							},
							error:function(rs) {
								console.log(rs.responseText);
							}
						});
					} else {
						$this.parent().css({'margin-bottom': 0, 'border-radius': '4px 4px 0 0'}).next().show();
					}
				} else {
					//关闭
					$this.attr('class','fontello-icon-angle-double-down');
					$this.parent().css({'margin-bottom': '10px', 'border-radius': '4px'}).next('ul').hide();
				}
			});
		},

		//初始化配置必填项验证
		start: function() {
			var version_current = $('input[name="version_current"]').val();
			var version_last = $('input[name="version_last"]').val();
			//验证是否确认覆盖数据库
			if (version_current == version_last) {
				smoke.alert('当前版本已是最新版', {ok: '确定',});
				return false;
			}
			start_upgrade();
		},

	};

	var lf = "<br />";
	var notice = null;
	var notice_html = '';
	var correct_img = $('input[name="correct_img"]').val();
	var error_img = $('input[name="error_img"]').val();
	
	var count = ver_list.length;

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
	
	function start_upgrade() {
		$('body').scrollTop(0).css('height', '100%');
		$('#js_ecjia_intro').css('display', 'none');
		$('.path').children('li').removeClass('current').eq(1).addClass('current');

		progress(10);
		upgrade();
		return false;
	}

	//安装程序
	function upgrade() {
		$("#js-monitor").css('display', 'block');
		$('#js-monitor-notice').css('display', 'block');

		each_upgrade(ver_list, upgrade_post);
	}
	
	function each_upgrade(list, callback) {
		if (ver_list.length > 0) {
			$ver = list[0];
			callback($ver);
		}
		if (list.length == 0) {
			var url = $('input[name="done"]').val();
			window.setTimeout(function() {
				location.href = url;
			}, 1500);
		}
	}
	
	function upgrade_post(version) {
		var params = "v=" + version;
		var url = $(".ajax_upgrade_url").val();
		
		$.post(url, params, function(result) {
			if (result.state == 'error') {
				var msg = '正在升级至' + version;
				ErrorMsg(msg, result.message);
				return false;
			} 
			if (result.state == 'success') {
				var msg = '<div class="install_notice">正在升级至' + version + '</div>';
				SuccessMsg(msg);
				ver_list.shift();
				progress_step = parseInt((count - ver_list.length) / count * 100);
				progress(progress_step);
				each_upgrade(ver_list, upgrade_post);
			}
			if (typeof(result.state) == 'undefined') {
				var msg = '正在升级至' + version;
				ErrorMsg(msg, 0);
			}
		});
	}

	//提示程序安装终止信息
	function stopNotice() {
		$("#js-monitor-wait-please").html('安装进程已中止');
	};

	//显示完成（成功）信息
	function SuccessMsg($msg) {
		$msg += "<span class='install_correct'><img src=" + correct_img + "> 成功 </span>" + lf;
		$('#js-notice').append($msg);
	}

	//显示错误信息
	function ErrorMsg(result, tip) {
		stopNotice();
		notice_html += '<div class="install_notice">' + result + '</div>';
		notice_html += "<span class='install_error'><img src=" + error_img + "> 失败 </span></strong>" + lf;
		$("#js-monitor-notice").css('display', "block");
		if (tip) {
			notice_html += "<span class='m_l30' style='color:red'>提示：" + tip + "</span>" + lf;
		}
		$('#js-notice').append(notice_html);
		$('#js-install-return-once').css('display', 'block');
		return false;
	}

})(ecjia.front, jQuery);

//end