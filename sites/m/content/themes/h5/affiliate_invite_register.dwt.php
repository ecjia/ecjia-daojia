<?php
/*
Name: 邀请注册模板
Description: 这是邀请注册首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.affiliate();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-invite-register">
	<img style="width: 100%;" src="{$theme_url}images/invite.png">
	<div class="form">
		<form class="invite-form" name="inviteForm" action='{url path="affiliate/index/invite"}'>
			<div class="input-container"><input type="text" id="mobile" name="mobile" placeholder="输入手机号码"/></div>
			<div class="input-container">
				<span class="identify_code" data-url="{url path='affiliate/index/refresh'}"><img src="data:image/png;base64,{$captcha_image}"></span>
				<input class="code_captcha" type="text" name="code_captcha" placeholder="请输入左侧验证码"/>
				<span class="identify_code_btn" data-url="{url path='affiliate/index/check'}">验证</span>
			</div>
			<div class="input-container"><input type="text" name="code" placeholder="输入短信验证码"/></div>
			<input type="hidden" name="invite_code" value="{$invite_code}" />
			<input class="receive_btn" type="submit" value="立即领取" />
		</form>
	</div>
	<div class="invite-notice">
		<ul>
		<li><p><i>1.</i>好友通过您的邀请，打开链接，在活动页输入手机号码登录，即可获得奖励；</p></li>
		<li><p><i>2.</i>每邀请一位新人好友并完成注册都可获得相应的奖励；</p></li>
		<li><p><i>3.</i>奖励一经领取后，不可删除，不可提现，不可转赠；</p></li>
		<li><p><i>4.</i>新用户领取的奖励查看方式：【我的-我的钱包】查看；</p></li>
		<li><p><i>5.</i>如有任何的疑问请咨询官网客服人员。</p></li>
		</ul>
	</div>
</div>
<!-- {/block} -->