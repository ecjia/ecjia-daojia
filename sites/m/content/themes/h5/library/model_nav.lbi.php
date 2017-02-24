<?php
/*
Name: 快速导航
Description: 这是首页和用户中心页面的快速导航模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {if $navigator} -->
<nav class="ecjia-mod container-fluid user-nav">
	<ul class="row ecjia-row-nav index">
		<!--{foreach from=$navigator item=nav}-->
		<li class="col-sm-3 col-xs-2">
			<a href="{$nav.url}">
				<!-- {if $nav.image} -->
				<img src="{$nav.image}" />
				<!-- {else} -->
				<img src="{$theme_url}dist/images/default_icon.png" alt="">
				<!-- {/if} -->
				<p class="text-center">{$nav.text}</p>
			</a>
		</li>
		<!--{/foreach}-->
	</ul>
</nav>
<!-- {/if} -->
