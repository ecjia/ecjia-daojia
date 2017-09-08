{nocache}
<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<head lang="zh-CN">
		<title>绑定账号</title>
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/touch.css" />
		<link rel="stylesheet" type="text/css" href="{$front_url}/css/style.css" />
	</head>

	<body >
		<div class="ecjia-login">
		    <div class="user-img"><img src="{$data.wechat_image}"></div>
		    <div class="ecjia-margin-l">
		        <p class="p-top3 text-size">
		        <span class="text-color">亲爱的用户：</span>
		        <span><big>{$data.wechat_nickname}</big></span>
		        </p>
		        <p class="text-size">为了给您更多的福利，请关联一个账号</p>
		    </div>
			<div class="ecjia-login-b ecjia-margin-b ecjia-margin-t">
			    <p class="select-title ecjia-margin-l">还没有账号？</p>
		        <a href="{$data.register_url}" class="btn">快速注册</a>
			</div>
			<div class="ecjia-login-b ecjia-margin-t">
			    <p class="select-title ecjia-margin-l">已有账号</p>
		        <a href="{$data.bind_url}" class="btn btn-hollow">立即关联</a>
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
//             ecjia.front.bind.init();
        </script>
	</body>
</html>
{/nocache}