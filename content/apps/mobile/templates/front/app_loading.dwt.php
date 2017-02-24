<!-- {nocache} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
<title>{$page_title}</title>
<link href="{$front_url}/loading.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="pic">
		<img id="bannerImg" width="100%" src="{$upload_image}" />
	</div>
	<div class="btns" id="state1">
		<img id="state2Img" width="100%" src="{RC_App::apps_url('mobile/templates/front/image/btns.png')}" />
		<a class='android' data-url="{$android_upload_url}" href="javascript:;"></a>
		<a class='iphone' data-url="{$iphone_upload_url}" href="javascript:;"></a>
	</div>
	<div class="btns" id="state2">
		<img id="state2Img" width="100%" src="{RC_App::apps_url('mobile/templates/front/image/btn.png')}" />
		<a class='loading' href="javascript:;"></a>
	</div>
	
<!-- {* 包含脚本文件 *} -->
<script src="{$front_url}/js/jquery.min.js" type="text/javascript"></script>
<script src="{$ecjia_js}" type="text/javascript"></script>

<script src="{$front_url}/js/ecjia-front.js" type="text/javascript"></script>
<script src="{$front_url}/js/app_loading.js" type="text/javascript"></script>

<script type="text/javascript">
ecjia.front.loading.init();
</script>
{$js}
</body>
</html>
<!-- {/nocache} -->

