<?php 
/*
Name: 店长推荐模版
Description: 店长推荐推荐列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.index.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-mod ecjia-margin-b goods-index-list ecjia-new-goods" style="border-bottom:none;">
	<div class="bd">
		<ul class="ecjia-margin-b ecjia-list ecjia-list-two list-page-two" id="J_ItemList" data-toggle="asynclist"
		 data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='#index/ajax_goods' args='type=best'}">
		</ul>
	</div>
</div>
<!-- {/block} -->
{/nocache}