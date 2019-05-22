<?php
/*
Name: 关注店铺列表
Description: 关注店铺列表
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.category.follow_store();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-mod ecjia-store-model">
	<div class="ecjia-suggest-store-content">
		<ul class="ecjia-suggest-store ecjia-follow-list" id="suggest_store_list" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/follow/ajax_follow_list'}" data-page="1">
		</ul>
	</div>
</div>
<!-- {/block} -->
{/nocache}