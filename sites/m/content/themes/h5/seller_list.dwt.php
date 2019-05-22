<?php 
/*
Name: 分类店铺
Description: 这是分类店铺页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>

{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<div class="ecjia-store-goods-list">
	<ul class="ecjia-store-list m_t0" id="ecjia-seller-list" {if $is_last neq 1}data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='merchant/category/list'}&type=ajax_get&cid={$cid}"{/if}>
	</ul>
</div>
<!-- {/block} -->
{/nocache}