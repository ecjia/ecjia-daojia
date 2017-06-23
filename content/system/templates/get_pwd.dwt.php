<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!DOCTYPE html>
<html class="login_page" lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>{$cp_home}{if $ur_here} - {$ur_here}{/if}</title>
	<!-- {ecjia:hook id=admin_print_styles} -->
	<!-- {ecjia:hook id=admin_print_scripts} -->
</head>
<body>
	<!-- {if $form_act eq "forget_pwd"} -->
	<div class="login_box">
		<div class="logo"></div>
		<div class="error-msg"></div>
		<form id="forget_form" name="theForm" method="post" action="{url path='@get_password/reset_pwd_mail'}" >
			<div class="top_b">{t}管理员密码找回{/t}</div>
			<div class="cnt_b">
				<div class="formRow">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-user"></i></span>
						<input id="username" name="username" type="text" placeholder="{t}管理员用户名{/t}" value="" autocomplete="off" />
					</div>
				</div>
				<div class="formRow">
					<div class="input-prepend">
						<span class="add-on"><i class="icon-envelope"></i></span>
						<input id="email" name="email" type="email" placeholder="{t}管理员邮箱{/t}" value="" autocomplete="off" />
					</div>
				</div>
				<!-- {ecjia:hook id=admin_login_captcha} -->
			</div>
			<div class="btm_b clearfix">
				<input class="btn btn-inverse pull-right" type="submit" value="{t}确定{/t}" />
				<span class="link_reg"><a href="{url path='@privilege/login'}">{t}返回登陆{/t}</a></span>
			</div>  
		</form>
	</div>
	<!-- {/if} -->

	<!-- {if $form_act eq "reset_pwd"} -->
	<div class="login_box login_box_getpwd">
		<div class="logo"></div>
		<div class="error-msg"></div>
		<form id="forget_form" name="theForm" method="post" action="{url path='@get_password/reset_pwd'}" >
			<div class="top_b">{t}管理员密码找回{/t}</div>
			<div class="cnt_b">
				<div class="formRow">
					<div class="input-prepend">
						<span class="add-on">{t}新密码{/t}</span>
						<input id="username" type="password" name="password" placeholder="{t}新管理员密码{/t}" value="" autocomplete="off" />
					</div>
				</div>
				<div class="formRow">
					<div class="input-prepend">
						<span class="add-on">{t}重复新密码{/t}</span>
						<input id="email" type="password" name="confirm_pwd" placeholder="{t}重复管理员密码{/t}" value="" autocomplete="off" />
					</div>
				</div>
				<!-- {ecjia:hook id=admin_login_captcha} -->
			</div>
			<div class="btm_b clearfix">
				<input type="hidden" name="adminid" value="{$adminid}" />
				<input type="hidden" name="code" value="{$code}" />
				<input class="btn btn-inverse pull-right" type="submit" value="{t}确定{/t}" />
				<span class="link_reg"><a href="{url path='@privilege/login'}">{t}返回登陆{/t}</a></span>
			</div>  
		</form>
	</div>
	<!-- {/if} -->
	<!-- {ecjia:hook id=admin_print_footer_scripts} -->
	
	<script>
		$(function(){
			form_wrapper = $('.login_box');
			form_wrapper.animate({ marginTop : ( - ( form_wrapper.height() / 2) - 24) },400);	
		});
		$('#forget_form').on('submit', function(e){
			e.preventDefault();
			$this = $(this);
			$this.ajaxSubmit({
				dataType:"json",
				success:function(data){
					$('.popover').remove();
					state = data.state == 'success' ? 'alert-success' : 'alert-error';
					var $info = $('<div class="staticalert alert ' + state + ' ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
					data.state == 'success' ? $info.appendTo('.error-msg') : $info.appendTo('.error-msg').delay(5000).hide(0);
				}
			});
		})
	</script>
</body>
</html>