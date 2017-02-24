<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!DOCTYPE html>
<html class="login_page" lang="zh">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>{$ecjia_admin_cptitle}{if $ur_here} - {$ur_here}{/if}</title>
	<!-- {ecjia:hook id=admin_print_styles} -->
	<!-- {ecjia:hook id=admin_print_scripts} -->
</head>
<body>
	<div class="login_box">
		{$logo_display}
		<div class="error-msg"></div>
		<form action="{$form_action}" method="post" id="login_form" name="theForm" >
			<div class="top_b">{t}管理员登录{/t}</div>
			<div class="cnt_b">
				<div class="formRow">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-user"></i></span>
						<input id="username" name="username" type="text" placeholder="{t}管理员姓名：{/t}" value="" autocomplete="off" />
					</div>
				</div>
				<div class="formRow">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-lock"></i></span>
						<input id="password" name="password" type="password" placeholder="{t}管理员密码：{/t}" value="" autocomplete="off" />
					</div>
				</div>
				<!-- {ecjia:hook id=admin_login_captcha} -->
				<div class="formRow clearfix">
					<label>
						<input class="f_l" type="checkbox" name="remember" />{t}请保存我这次的登录信息。{/t}
					</label>
				</div>
			</div>
			<div class="btm_b clearfix">
				<input type="hidden" name="act" value="signin" />
				<button class="btn btn-inverse pull-right" type="submit">{t}进入管理中心{/t}</button>
				<span class="link_reg"><a href="index.php">{t}返回首页{/t}</a></span>
			</div>
		</form>
		<div class="links_b links_btm clearfix">
			{assign var=get_password_url value=RC_Uri::url('@get_password/forget_pwd')}
			<span class="linkform"><a href="{$get_password_url}">{t}您忘记了密码吗?{/t}</a></span>
		</div>
	</div>
	<!-- {ecjia:hook id=admin_print_footer_scripts} -->
	<script>
		{literal}
		$(document).ready(function(){
			//* boxes animation 开场动画
			form_wrapper = $('.login_box');
			form_wrapper.animate({ marginTop : ( - ( form_wrapper.height() / 2) - 24) },400);	

		});

		$('#login_form').on('submit', function(e){
			e.preventDefault();
			$this = $(this);
			$this.ajaxSubmit({
				dataType:"json",
				success:function(data){
					$('.popover').remove();
					if(data.state == 'success'){
						window.location.href = data.url;
					}else{
						var $info = $('<div class="staticalert alert alert-error ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
						$info.appendTo('.error-msg').delay(5000).hide(0);
					}
				}
			});
		})
		{/literal}
	</script>
</body>
</html>