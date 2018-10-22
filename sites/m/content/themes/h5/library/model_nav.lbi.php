<?php
/*
Name: 首页菜单
Description: 这是首页菜单
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {if $value.data} -->
<nav class="ecjia-mod container-fluid {if $count eq $key && !$data}ecjia-mod-pb35{/if}">
	<div class="ecjia-padding-b1">
		<ul class="row ecjia-row-nav index">
			<!--{foreach from=$value.data item=nav}-->
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
	</div>
</nav>
<!-- {/if} -->
