<?php
/*
Name: 用户中心模板
Description: 这是推广页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
var title = '{$share_title}',
	link = '{$invite_user.invite_url}',
	image = '{$image}';
ecjia.touch.spread.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<div class="ecjia-spread">
	<div class="ecjia-bg-qr-code">
		<div class="bg-img"></div>
		<div class="qrcode_image">
			<img src="{$invite_user.invite_qrcode_image}" />
		</div>
		<div class="my-invite-code">
			<p>我的邀请码</p>
			<div class="code-style">{$invite_user.invite_code}</div>
		</div>
	</div>
	<div class="invite-template">
		<textarea class="invite-template-style" name="invite_template">{$invite_user.invite_template}</textarea>
	</div>
	<div class="go-to-spread">
		<a class="show_spread_share nopjax external" href="javascript:;"><div class="would-spread">我要推广</div></a>
	</div>
	
	<div class="ecjia-my-reward">
		<a class="nopjax external" href="{url path='user/bonus/my_reward'}"><div class="my_reward">查看我的奖励</div></a>
	</div>
	<input type="hidden" name="spread_url" value="{$url}" />
	
	<div class="invite_explain"> 
		<p class="invite_explain-literal">邀请说明：</p>
		<div class="invite_explain-content">
			{if $invite_user.invite_explain_new}
				<!--{foreach from=$invite_user.invite_explain_new item=invite}-->
					{if $invite}
						<p>{$invite}；</p>
					{/if}
				<!--{/foreach}-->
			{else}
				{$invite_user.invite_explain}
			{/if}
		</div>
	</div>
	<div class="ecjia-spread-share hide"><img src="{$theme_url}images/spread.png"></div>
</div>
<!-- {/block} -->