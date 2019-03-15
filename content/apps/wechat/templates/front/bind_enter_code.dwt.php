{nocache}
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head lang="zh-CN">
		<title>{t domain="wechat"}输入验证码{/t}</title>
        {ecjia:hook id=front_enqueue_scripts}
        {ecjia:hook id=front_print_styles}
        {ecjia:hook id=front_print_scripts}
	</head>
	
	<header class="ecjia-header">
		<div class="ecjia-header-left">
		</div>
		<div class="ecjia-header-title">{t domain="wechat"}输入验证码{/t}</div>
	</header>
	<body>
		<div class="ecjia-form ecjia-login">
			<p class="ecjiaf-tac ecjia-margin-b">{t domain="wechat"}验证码已发送至{/t}+86 {$mobile}</p>
			
			<div id="payPassword_container">
				<div class="pass_container">
					<input class="input" type="tel" maxlength="1">  
					<input class="input" type="tel" maxlength="1">
					<input class="input" type="tel" maxlength="1">
					<input class="input" type="tel" maxlength="1">
					<input class="input" type="tel" maxlength="1">
					<input class="input" type="tel" maxlength="1">
				</div>
			</div>
			<input type="hidden" name="url" value="{$url}" />
		    <p class="ecjiaf-tac blue resend_sms" data-url="{$resend_url}">{t domain="wechat"}重新发送验证码{/t}</p>
		</div>

        {ecjia:hook id=front_print_footer_scripts}
        <script type="text/javascript">
       		 ecjia.bind.init();
        </script>
	</body>
</html>
{/nocache}