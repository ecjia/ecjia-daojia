<?php
/*
Name: 邀请注册模板
Description: 这是邀请注册首页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.affiliate();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-invite-register">
	<div class="invite-top" style="position: relative;">
		<img style="width: 100%; height: 34em;" src="{$theme_url}images/invite_01.png">
		<div class="form">
			<form class="invite-form" name="inviteForm" action='{url path="affiliate/index/invite"}'>
				<div class="input-container">
					<input type="text" id="mobile" name="mobile" placeholder='{t domain="h5"}输入手机号码{/t}'/>
				</div>
				<div class="input-container">
					<span class="identify_code" data-url="{url path='affiliate/index/refresh'}"><img src="data:image/png;base64,{$captcha_image}"></span>
					<input class="code_captcha" type="text" name="code_captcha" placeholder='{t domain="h5"}请输入左侧验证码{/t}'/>
					<span class="identify_code_btn" data-url="{url path='affiliate/index/check'}">{t domain="h5"}验证{/t}</span>
				</div>
				<div class="input-container">
					<input type="text" name="code" placeholder='{t domain="h5"}输入短信验证码{/t}'/>
				</div>
				<input type="hidden" name="invite_code" value="{$invite_code}"/>
				<input class="receive_btn" type="submit" value='{t domain="h5"}立即领取{/t}'/>
			</form>
		</div>
	</div>
	
	<div class="invite-bottom" style="position: relative; height: 19em;">
		<img style="width: 100%;height: 5.4em;" src="{$theme_url}images/invite_02.png">
		<div class="invite-notice">
			<ul>
				<!--{foreach from=$invite_user.invitee_rule_explain item=invite}-->
				{if $invite}
				<li>
					<p>
						{$invite}
					</p>
				</li>
				{/if}
				<!--{/foreach}-->
			</ul>
		</div>
	</div>
</div>
<!-- {/block} -->
{/nocache}