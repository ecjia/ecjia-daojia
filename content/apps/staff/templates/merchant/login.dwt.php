<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!DOCTYPE html>
<html class="login_page" lang="zh">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
	<title>{block name="title"}{if $ur_here}{$ur_here} - {/if}{$shop_name}{/block}</title>
	<!-- {ecjia:hook id=merchant_print_styles} -->
    <!-- {ecjia:hook id=merchant_print_scripts} -->
    

</head>
<body>
    <div class="container">
        <form class="form-login" action="{$form_action}" method="post" id="login_form" name="theForm">
         <div class="error-msg"></div>
         <div class="store_logo">{$logo_display}</div>
            <h2 class="form-login-heading">{t domain="staff"}商家登录{/t}</h2>
            <div class="login-wrap">
                <input type="text" class="form-control"  id="mobile" name="mobile" placeholder='{t domain="staff"}手机号{/t}' value="" autofocus>
                <input type="password" id="password" name="password" class="form-control"  value="" placeholder='{t domain="staff"}密码{/t}'>
                <!-- {ecjia:hook id=merchant_login_captcha} -->
                <div class="checkbox">
                     <input id="remember" type="checkbox" name="remember" value="remember-me">
                     <label for="remember">{t domain="staff"}记住我{/t}</label>
                </div>
                <input type="hidden" name="act" value="signin" />
                <button class="btn btn-lg btn-block btn-primary" type="submit">{t domain="staff"}进入管理中心{/t}</button>
                <div  class="text-center" style="margin-top: 10px;">
                    <a href="{url path='staff/get_password/forget_fast'}">{t domain="staff"}忘记密码？{/t}</a>
                </div>
            </div>
        </form>
    </div>
    <!-- {ecjia:hook id=merchant_print_footer_scripts} -->
    <script>
		{literal}
		$(document).ready(function(){
			//* boxes animation 开场动画
			form_wrapper = $('.container');
			form_wrapper.animate({ marginTop : ( - ( form_wrapper.height() / 3) - 24) },500);	
		});

		$('#login_form').on('submit', function(e){
			e.preventDefault();
			$this = $(this);
			$this.ajaxSubmit({
				dataType:"json",
				success:function(data){
					$('.popover').remove();
					if (data.state == 'success') {
						window.location.href = data.url;
					} else {
						var $info = $('<div class="staticalert alert alert-danger ui_showmessage"><a data-dismiss="alert" class="close">×</a>' + data.message + '</div>');
						$info.appendTo('.error-msg').delay(5000).hide(0);
					}
				}
			});
		})
		{/literal}
	</script>
	{if ecjia::config('stats_code')}
		{stripslashes(ecjia::config('stats_code'))}
	{/if}
</body>
</html>	