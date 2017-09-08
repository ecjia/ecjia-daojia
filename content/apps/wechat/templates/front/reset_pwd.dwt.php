{nocache}
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head lang="zh-CN">
		<title>重设密码</title>
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/touch.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/style.css" />
	</head>
	
	<header class="ecjia-header">
		<div class="ecjia-header-left">
		</div>
		<div class="ecjia-header-title">设置新密码</div>
	</header>
	<body>
	   <div class="ecjia-form ecjia-login">
			<div class="form-group margin-right-left">
				<label class="input">
					<i class="iconfont icon-attention ecjia-login-margin-l" id="password1"></i>
					<input class="padding-left05" type="password"  id="password" name="password" placeholder="请输入新密码"  />
				</label>
			</div>
			<div class="form-group ecjia-login-margin-top margin-right-left">
				<label class="input">
					<i class="iconfont icon-attention ecjia-login-margin-l show-password" id="password2"></i>
					<input class="padding-left05" type="password"  id="confirm_password" name="confirm_password" placeholder="请再次输入新密码"/>
				</label>
			</div>
			<div class="ecjia-login-b ecjia-login-margin-top">
			    <div class="around">
		            <a class="finish_pwd btn" href="{url path='wechat/mobile_profile/reset_pwd_update'}">完成</a>
			    </div>	
			</div>
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