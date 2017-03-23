<?php
/*
Name: 首页热门推荐
Description: 这是首页热门推荐模块,此模块只在首页配合ajaxinfo才能有效
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-mod ecjia-margin-b goods-index-list ecjia-new-goods" style="border-bottom:none;" >
	<div class="hd">
		<h2>
			<span class="line"></span>
			<span class="goods-index-title"><i class="icon-goods-hot"></i>热门推荐</span>
		</h2>
	</div>
	<div class="bd">
		<ul class="ecjia-list ecjia-list-two list-page-two" id="J_ItemList" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='index/ajax_goods' args='type=hot'}">
		</ul>
	</div>
</div>