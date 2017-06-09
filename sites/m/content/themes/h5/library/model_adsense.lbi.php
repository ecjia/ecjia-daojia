<?php
/*
Name: 首页广告
Description: 这是首页的广告模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-mod {if !$data && !$new_goods && !$promotion_goods}ecjia-mod-pb35{/if}">
	<ul class="ecjia-adsense-model">
	<!-- {foreach from=$adsense_group item=val} -->
		<li class="adsense-item">
			<div class="adsense-title">
				{if $val.title}
				<h2>{$val.title}</h2>
				{/if}
			</div>
			<ul class="adsense-group">
				<!-- {foreach from=$val.adsense key=key item=v} -->
				<li class="adsense-single {if $val.count eq 3}img-th-item{else if (($val.count eq 1 || $val.count eq 4) && $key gt 0)}img-item{/if}">
					<a href="{$v.url}"><img src="{$v.image}"></a>
				</li>
				<!-- {/foreach} -->
			</ul>
		</li>
	<!-- {/foreach} -->
	</ul>
</div>
