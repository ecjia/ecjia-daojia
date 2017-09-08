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
	   		<input name="mobile" type="hidden" value="{$mobile}" />
	    	<p class="text-st-mobile">绑定手机号：{$mobile}</p>
	        <p class="text-st">请输入收到的短信验证码</p>
	    	<div class="form-group small-text">
	    		<label class="input-1">
	    			<input name="code" type="text" value="" placeholder="输入验证码" />
	    		</label>
	    	</div>
	    	<div class="small-submit">
	            <a class="get_code btn" id="get_code" href="{url path='wechat/mobile_profile/get_code'}">获取验证码</a>
	        </div>
	    	 <div class="around">
	    	  <a class="next_pwd btn ecjia-login-margin-top" href="{url path='wechat/mobile_profile/next_pwd'}">下一步</a>
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