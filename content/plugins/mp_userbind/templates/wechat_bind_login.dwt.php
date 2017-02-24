<!-- {nocache} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>绑定账号</title>
<link rel="stylesheet" type="text/css" href="{$css_url}">
</head>
<body class="ff-defaultfont pr" style="background: #dff4fe;">
	<div class="ml40 mr40  mt80 tc" >
		<div class="tc">
			<span class="f36 text">欢迎来到{$wechat_name}公众平台</span>
		</div>
		<div class=" mt40 ml20 mr20 text">
			<span class="inlblock f28">如果您已有{$wechat_name}会员账号，可以在此登录绑定{$wechat_name}的账号</span>
		</div>
	</div>
	<form class="form-horizontal" action="{$form_action}" method="post" name="theForm" >
		<div class="mt60 ml80 mr80">
			<div class="mt40">
				<input type="text" name="user_name" autocomplete="off" class="bind_input" placeholder="请输入用户名" value=""/>
			</div>
			<div class="mt40">
				<input type="password" name="password" autocomplete="off" class="bind_input" placeholder="请输入密码" value=""/>
			</div>
		</div>
		<div class="mt60 ml80 mr80">
			<div class="">
			 	<button type="submit" class="bind_btn bglightBlue white">确定</button>
			</div>
		</div>
	</form>
</body>
</html>
<!-- {/nocache} -->
