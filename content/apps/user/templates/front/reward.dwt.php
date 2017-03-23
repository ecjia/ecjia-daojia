<!-- {nocache} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Description" content="" />
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
<title>{$title}</title>
<link href="{$front_url}/css/mobile_reward.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="reward-img">
		<img width="100%" src="{RC_App::apps_url('user/statics/front/images/reward_header.png')}" />
	</div>
	<div class="reward-content">
		<div class="reward-button" data-url="{url path='user/mobile_reward/recieve'}">
			<button type="button" class="receive_btn">我要领取</button>
			<input type="hidden" name='token' value="{$token}" />
		</div>
		<div class="reward-content-title">
			活动规则
		</div>
		<div class="reward-content-article">
			{$mobile_signup_reward_notice}
		</div>
	</div>
	<div id="cover">
	</div>
	<div class="success-image">
		<img src="{RC_App::apps_url('user/statics/front/images/receive-success.png')}" />
		<div class="close" data-url=""></div>
		<div class="to-use" data-url=""></div>
	</div>
</body>
</html>
<!-- {* 包含脚本文件 *} -->
<script src="{$front_url}/js/jquery.min.js" type="text/javascript"></script>
<script src="{$front_url}/js/ecjia.js" type="text/javascript"></script>
<script src="{$front_url}/js/ecjia-front.js" type="text/javascript"></script>
<script src="{$front_url}/js/mobile_reward.js" type="text/javascript"></script>

<script type="text/javascript">
ecjia.front.reward.init();
</script>
<!-- {/nocache} -->