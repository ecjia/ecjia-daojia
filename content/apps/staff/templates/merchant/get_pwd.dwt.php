<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!DOCTYPE html>
<html class="login_page" lang="zh">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>{block name="title"}{if $form_act eq 'reset_fast_pwd'}{$ur_here_mobile}{else}{$ur_here_email}{/if} - {$shop_name}{/block}</title>
	<!-- {ecjia:hook id=merchant_print_styles} -->
    <!-- {ecjia:hook id=merchant_print_scripts} -->
</head>
<body>
	<!-- {if $form_act eq "forget_pwd"} -->
    <div class="container">
        <form class="form-login" action="{url path='staff/get_password/reset_pwd_mail'}" method="post" id="forget_form" name="theForm">
        	<div class="error-msg"></div>
        	<div class="store_logo">{$logo_display}</div>
            <h2 class="form-login-heading">{t domain="staff"}管理员密码找回{/t}</h2>
            <div class="login-wrap">
                <input class="form-control"  type="text"  id="name" name="name" placeholder='{t domain="staff"}用户名{/t}' value="" autocomplete="off" />
                <input class="form-control"  type="text"  id="email"    name="email" placeholder='{t domain="staff"}邮箱{/t}'   value="" autocomplete="off" />
                <button class="btn btn-lg btn-block btn-primary" type="submit">{t domain="staff"}确定{/t}</button>
                <div style="margin-top: 10px;">
                    <a href="{url path='staff/privilege/login'}">{t domain="staff"}返回登录{/t}</a>
                     <span class="pull-right">
                         <a style="" href="{url path='staff/get_password/forget_fast'}">{t domain="staff"}快速找回{/t}</a>
                    </span>
                </div>
            </div>
        </form>
     </div>
     <!-- {/if} -->

	<!-- {if $form_act eq "reset_pwd"} -->
	<div class="container">
        <form class="form-login" action="{url path='staff/get_password/reset_pwd'}" method="post" id="forget_form" name="theForm">
       		<div class="error-msg"></div>
       		<div class="store_logo">{$logo_display}</div>
            <h2 class="form-login-heading">{t domain="staff"}管理员密码找回{/t}</h2>
            <div class="login-wrap">
                <input class="form-control"  type="password"  id="password"      name="password"     placeholder='{t domain="staff"}新密码{/t}'   value="" autocomplete="off" />
                <input class="form-control"  type="password"  id="confirm_pwd"   name="confirm_pwd"  placeholder='{t domain="staff"}确认密码{/t}' value="" autocomplete="off" />
                <input type="hidden" name="adminid" value="{$adminid}" />
				<input type="hidden" name="code" value="{$code}" />
                <button class="btn btn-lg btn-block btn-primary" type="submit">{t domain="staff"}确定{/t}</button>
                <div class="text-center" style="margin-top: 10px;">
                    <a href="{url path='staff/privilege/login'}">{t domain="staff"}返回登录{/t}</a>
                </div>
            </div>
        </form>
    </div>
	<!-- {/if} -->
	
	<!-- {if $form_act eq "reset_fast_pwd"} -->
    <div class="container">
        <form class="form-login" action="{url path='staff/get_password/fast_reset_pwd'}" method="post" id="reset_fast_pwd" name="theForm">
        	<div class="error-msg"></div>
        	<div class="store_logo">{$logo_display}</div>
            <h2 class="form-login-heading">{t domain="staff"}手机号快速找回{/t}</h2>
            <div class="login-wrap">
                <input class="form-control"  type="text"  id="mobile" name="mobile" placeholder='{t domain="staff"}手机号{/t}' value="" autocomplete="off" />
                <button class="btn btn-lg btn-block btn-primary" type="submit">{t domain="staff"}下一步{/t}</button>
                <div style="margin-top: 10px;">
                    <a href="{url path='staff/privilege/login'}">{t domain="staff"}返回登录{/t}</a>
                     <span class="pull-right">
                         <a style="" href="{url path='staff/get_password/forget_pwd'}">{t domain="staff"}邮箱找回{/t}</a>
                    </span>
                </div>
            </div>
        </form>
	</div>
	<!-- {/if} -->
	
	<!-- {if $form_act eq "get_code"} -->
    <div class="container">
        <form class="form-getcode" action="{url path='staff/get_password/get_code_form'}" method="post" id="get_code" name="theForm">
        	<div class="error-msg"></div>
        	<div class="store_logo">{$logo_display}</div>
            <h2 class="form-login-heading">{t domain="staff"}手机号密码找回{/t}</h2>
            <div class="login-wrap">
             	<div><label for="mobile">{t domain="staff"}手机号：{/t}</label>{$mobile}</div><br>
                <div class="input-group">
                   <input type="text" class="form-control" name="code" placeholder='{t domain="staff"}请输入校验码{/t}'>
                   <span class="input-group-btn">
                        <input class="btn btn-info" id="get_code_value" data-url='{RC_Uri::url("staff/get_password/get_code_value", "mobile={$mobile}")}' type="button" value="获取短信校验码">
                   </span>
                </div>  
                <button class="btn btn-lg btn-block btn-primary" style= "margin-top: 20px;" type="submit">{t domain="staff"}提交{/t}</button>
                <div style="margin-top: 10px;">
                    <a href="{url path='staff/privilege/login'}">{t domain="staff"}返回登录{/t}</a>
                     <span class="pull-right">
                         <a href="{url path='staff/get_password/forget_pwd'}">{t domain="staff"}邮箱找回{/t}</a>
                    </span>
                </div>
            </div>
        </form>
	</div>
	<!-- {/if} -->
	
	<!-- {if $form_act eq "mobile_reset"} -->
	<div class="container">
        <form class="form-login" action="{url path='staff/get_password/mobile_reset_pwd'}" method="post" id="recharge" name="theForm">
       		<div class="error-msg"></div>
       		<div class="store_logo">{$logo_display}</div>
            <h2 class="form-login-heading">{t domain="staff"}重置密码{/t}</h2>
            <div class="login-wrap">
                <input class="form-control"  type="password"  id="password"       name="password"     placeholder='{t domain="staff"}新密码{/t}'   value="" autocomplete="off" />
                <input class="form-control"  type="password"  id="confirm_pwd"    name="confirm_pwd"  placeholder='{t domain="staff"}确认密码{/t}' value="" autocomplete="off" />
                <button class="btn btn-lg btn-block btn-primary" type="submit">{t domain="staff"}确定{/t}</button>
                <div class="text-center" style="margin-top: 10px;">
                    <a href="{url path='staff/privilege/login'}">{t domain="staff"}返回登录{/t}</a>
                </div>
            </div>
        </form>
    </div>
	<!-- {/if} -->
	
    <!-- {ecjia:hook id=merchant_print_footer_scripts} -->
    <script>
		$(function(){
			form_wrapper = $('.container');
			form_wrapper.animate({ marginTop : ( - ( form_wrapper.height() / 3) - 24) },400);	
		});

		//手机号邮箱比对
		$('#forget_form').on('submit', function(e){
			e.preventDefault();
			$this = $(this);
			$this.ajaxSubmit({
				dataType:"json",
				success:function(data){
					$('.popover').remove();
					state = data.state == 'success' ? 'alert-success' : 'alert-danger';
					var $info = $('<div class="staticalert alert ' + state + ' ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
					data.state == 'success' ? $info.appendTo('.error-msg') : $info.appendTo('.error-msg').delay(5000).hide(0);
				}
			});
		});

		//手机号快速找回
		$('#reset_fast_pwd').on('submit', function(e){
			e.preventDefault();
			$this = $(this);
			$this.ajaxSubmit({
				dataType:"json",
				success:function(data){
					if (data.state == 'success'){
						window.location.href = data.url;
					} else {
						var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
						$info.appendTo('.error-msg').delay(5000).hide(0);
					}
				}
			});
		});

		var InterValObj; 
		var count = 120; 
		var curCount;
		$("#get_code_value").on('click', function (e) {
             e.preventDefault();
             var url = $(this).attr('data-url');
             $.get(url, function (data) {
              	if (data.state == 'success') {
                	curCount = count;
            		$("#get_code_value").attr("disabled", "true");
            		$("#get_code_value").val("重新发送" + curCount + "(s)");
            		InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
				} else {
					var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
					$info.appendTo('.error-msg').delay(5000).hide(0);
				}
             }, 'json');
        });

		//timer处理函数
 		function SetRemainTime() {
            if (curCount == 0) {                
                window.clearInterval(InterValObj);
                $("#get_code_value").removeAttr("disabled");
                $("#get_code_value").val("重新发送验证码");
            } else {
                curCount--;
                $("#get_code_value").val("重新发送" + curCount + "(s)");
            }
	     }
		

        //判断用户输入的校验码是否正确然后才可以进入重置密码
		$('#get_code').on('submit', function(e){
			e.preventDefault();
			$this = $(this);
			$this.ajaxSubmit({
				dataType:"json",
				success:function(data){
					if (data.state == 'success') {
						window.location.href = data.url;
					} else {
						var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
						$info.appendTo('.error-msg').delay(5000).hide(0);
					}
				}
			});
		})
		
		//手机重置密码
		$('#recharge').on('submit', function(e){
			e.preventDefault();
			$this = $(this);
			$this.ajaxSubmit({
				dataType:"json",
				success:function(data){
					if (data.state == 'success') {
						window.location.href = data.url;
					} else {
						var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
						$info.appendTo('.error-msg').delay(5000).hide(0);
					}
				}
			});
		})
	</script>
</body>
</html>	