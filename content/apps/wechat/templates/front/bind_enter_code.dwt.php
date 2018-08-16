{nocache}
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head lang="zh-CN">
		<title>输入验证码</title>
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/touch.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/style.css" />
	</head>
	
	<header class="ecjia-header">
		<div class="ecjia-header-left">
		</div>
		<div class="ecjia-header-title">输入验证码</div>
	</header>
	<body>
		<div class="ecjia-form ecjia-login">
			<p class="ecjiaf-tac ecjia-margin-b">验证码已发送至+86 {$mobile}</p>
			
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
		    <p class="ecjiaf-tac blue resend_sms" data-url="{$resend_url}">重新发送验证码</p>
		</div>
		
		<script src="{$system_statics_url}/js/jquery.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/ecjia-js/ecjia.js" type="text/javascript"></script>
        
        <script src="{$front_url}/js/bind.js" type="text/javascript"></script>
        
        <script src="{$system_statics_url}/lib/chosen/chosen.jquery.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/js/jquery-migrate.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/lib/smoke/smoke.min.js" type="text/javascript"></script>
        <script src="{$system_statics_url}/js/jquery-cookie.min.js" type="text/javascript"></script>
        <script type="text/javascript">
       		 ecjia.bind.init();
        </script>
	</body>
</html>
{/nocache}