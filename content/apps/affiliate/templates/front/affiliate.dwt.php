<!-- {nocache} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Description" content="" />
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
<title>{$title}</title>
<link href="{$front_url}/css/affiliate.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="affiliate-body">
		<div class="affiliate-img">
			<img width="70%" src="{$front_url}/images/tuijian.png" />
		</div>
		<div class="affiliate-note">{$note}</div>
		<div class="affiliate-note2">{$affiliate_note}</div>
		<form action="{url path='affiliate/mobile/invite'}" method="post" name="invite">
			<div class="affiliate-mobile">
				<div class="affiliate-mobile-no">
				+86
				</div>
				<input class="affiliate-input" type='text' name='mobile_phone' placeholder="{t}请输入您的手机号{/t}"/>
			</div>
			<button class="affilidate-btn">{if $is_h5} 立即注册 {else} 下载应用程序  {/if}</button>
			<input type="hidden" name="invite_code" value="{$invite_code}" />
		</form>
	</div>
	<div class="wx-affiliate hide"><img src="{RC_App::apps_url('affiliate/statics/front/images/wx_affiliate.png')}"></div>
</body>
</html>
<!-- {* 包含脚本文件 *} -->
<script src="{$front_url}/js/jquery.min.js" type="text/javascript"></script>
<script src="{$front_url}/js/ecjia.js" type="text/javascript"></script>
<script src="{$front_url}/js/ecjia-front.js" type="text/javascript"></script>
<script src="{$front_url}/js/affiliate.js" type="text/javascript"></script>

<script type="text/javascript">
ecjia.front.affiliate.init();
</script>
<!-- {/nocache} -->