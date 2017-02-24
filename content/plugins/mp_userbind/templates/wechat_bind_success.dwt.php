<!-- {nocache} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
<meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>绑定账号</title>
<link rel="stylesheet" type="text/css" href="{$css_url}">
<script type="text/javascript" src="{$jq_url}"></script>
<script type="text/javascript">
function triggle_cick() {
	if (!$('.show').hasClass('none')) {
		$('.set_password').html('设置密码').css({ color: "#53bbe9"});
		$('.show').addClass('none');
	} else {
		$('.set_password').html('暂不设置').css({ color: "#53bbe9"});
		$('.show').removeClass('none');
	}
}
</script>
</head>

<body class="ff-defaultfont pr" style="background: #dff4fe;">
<div class="ml40 mr40  mt80 tc" >
	<div class="tc">
		<span class="f36 text">您已成功绑定！</span>
	</div>
	<div class=" mt40 ml20 mr20 text">
		<span class="inlblock f28">您的用户名：{$username}</span>
	</div>
	
	{if $point_value}
	<div class=" mt40 ml20 mr20 text">
		<span class="inlblock f28">当前获得积分：{$point_value}分</span>
	</div>
	{/if}
	
	{if $type_money}
	<div class=" mt40 ml20 mr20 text">
		<span class="inlblock f28">当前获得红包：{$type_money}元</span>
	</div>
	{/if}
	
	
	{if $action neq 'cancel'}
	<div class="mt60 ml80 mr80">
		<a class="inlblock f28 set_password hand" onclick="triggle_cick()" ><font color="#53bbe9" >设置密码</font></a>
	</div>
	</div>
	<div class="show none">
		{if $one eq 'one'}
			<form class="form-horizontal" action="{$form_action}" method="post" name="theForm" >
				<div class="mt60 ml80 mr80">
					<div class="mt40">
						<input type="password" name="newpassword" autocomplete="off" class="bind_input" placeholder="请设置新密码" value=""/>
					</div>
					
					<div class="mt40">
						<input type="password" name="confirm_password" autocomplete="off" class="bind_input" placeholder="请再次确认密码" value=""/>
					</div>
				</div>
				<div class="mt60 ml80 mr80">
					<div class="">
						<button type="submit" class="bind_btn bglightBlue white">确定</button>
					</div>
				</div>
			</form>	
		{else}
			<form class="form-horizontal" action="{$form_action}" method="post" name="theForm" >
				<div class="mt60 ml80 mr80">
					<div class="mt40">
						<input type="password" name="oldpassword" autocomplete="off" class="bind_input" placeholder="请输入原密码" value=""/>
					</div>
					
					<div class="mt40">
						<input type="password" name="newpassword" autocomplete="off" class="bind_input" placeholder="请设置新密码" value=""/>
					</div>
					
					<div class="mt40">
						<input type="password" name="confirm_password" autocomplete="off" class="bind_input" placeholder="请再次确认密码" value=""/>
					</div>
				</div>
				<div class="mt60 ml80 mr80">
					<div class="">
						<input type="hidden" name="again" value="again"/>
						<button type="submit" class="bind_btn bglightBlue white">确定</button>
					</div>
				</div>
			</form>	
		{/if}
	</div>	
	{/if}
</body>
</html>
<!-- {/nocache} -->