<?php
/*
Name: 首页header模块
Description: 这是首页的header模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>

{if $address}
<div class="ecjia-mod ecjia-header ecjia-header-index" style="height:5.5em" id="location">
	<div class="ecjia-web">
		<div class="ecjia-address">
			<a href="{url path='location/index/select_location'}">
				<p class="address-text">{$smarty.cookies.location_name}</p>
				<i class="bottom-jiantou"></i>
			</a>
		</div>
	</div>
	
	<div class="ecjia-search-header">
		<span class="bg search-goods" style="margin-top:2em;" data-url="{RC_Uri::url('touch/index/search')}{if $store_id}&store_id={$store_id}{/if}" {if $keywords neq ''}style="text-align: left;" data-val="{$keywords}"{/if}>
			<i class="iconfont icon-search"></i>{if $keywords neq ''}<span class="keywords">{$keywords}</span>{else}{if $store_id}搜索店内商品{else}搜索附近门店{/if}{/if}
		</span>
	</div>
</div>
{else}
<div class="ecjia-mod ecjia-header ecjia-header-index">
	<div class="ecjia-search-header">
		<span class="bg search-goods" data-url="{RC_Uri::url('touch/index/search')}{if $store_id}&store_id={$store_id}{/if}" {if $keywords neq ''}style="text-align: left;" data-val="{$keywords}"{/if}>
			<i class="iconfont icon-search"></i>{if $keywords neq ''}<span class="keywords">{$keywords}</span>{else}{if $store_id}搜索店内商品{else}搜索附近门店{/if}{/if}
		</span>
	</div>
</div>
{/if}
