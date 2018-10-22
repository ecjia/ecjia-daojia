<?php
/*
Name: 首页广告
Description: 这是首页的广告模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {if $value.data} -->
<div class="ecjia-mod {if $count eq $key && !$data}ecjia-mod-pb35{/if}">
	<ul class="ecjia-adsense-model">
	<!-- {foreach from=$value.data item=val} -->
		<li class="adsense-item">
			{if $val.title}
			<div class="adsense-title">
				<h2>{$val.title}</h2>
			</div>
			{/if}
			<ul class="adsense-group">
				<!-- {foreach from=$val.adsense key=key item=v} -->
				{if $val.count eq 2 || $val.count eq 4}
				<li class="adsense-single {if $val.count eq 2}img-two-item{else if $val.count eq 4}img-four-item{/if}">
					<a href="{$v.url}"><img src="{$v.image}"></a>
				</li>
				{else if $val.count eq 3}
				<li class="adsense-single img-three-item">
					<a href="{$v.url}"><img src="{$v.image}"></a>
				</li>
				{/if}
				<!-- {/foreach} -->
			</ul>
		</li>
	<!-- {/foreach} -->
	</ul>
</div>
<!-- {/if} -->