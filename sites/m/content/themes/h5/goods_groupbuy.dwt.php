<?php 
/*
Name: 团购商品模版
Description: 团购商品列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.index.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-groupbuy-model">
	<ul class="ecjia-groupbuy-list" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='#index/ajax_goods' args='type=groupbuy'}">
	</ul>
</div>
<!-- {/block} -->

{/nocache}