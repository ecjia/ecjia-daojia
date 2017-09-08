<?php
/*
Name: 支付提示模板
Description: 
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
<title>支付通知</title>

<style type="text/css">
body,html,div,p,h2,span{
    margin:0px;
    padding:0px;
}
</style>
<script type="text/javascript">
function goback() {
	var useragent = navigator.userAgent;
	if (useragent.indexOf("ECJiaBrowse") >= 0) {
		var url="ecjiaopen://app?open_type=main";  
		document.location = url;
	} else {
		window.history.go(-1);
	}  
}
</script>
</head>
<body >
    <div style="width:100%;overflow: hidden;margin:0px;padding:0px 0px;text-align: center;">
		<h2 style="background:#18B0EF;line-height:2.5em;height:2.5em;color: #fff;">提示信息</h2>
		<p style="font-size:1.5em; line-height:25px;min-height:100px;padding-top:2em;">{$msg}</p>
		<div class="two-btn" style="margin:1em">
            <a class="btn btn-info" href="'.$touch_url.'" style="display: inline-block;background:#4AB9EE;width: 48%;padding: 1em 0;border-radius: 6px;color: #fff;text-decoration: blink;margin-right: 2%;">去微商城购物</a>
			<a class="btn btn-info" href="javascript:goback()" style="display: inline-block;background:#4AB9EE;width: 48%;padding: 1em 0;border-radius: 6px;color: #fff;text-decoration: blink;">返回APP</a>
		</div>
	</div>
</body>
</html>
