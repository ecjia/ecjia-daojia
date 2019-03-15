<?php
/*
Name: 返还方式列表模板
Description: 这是返还方式列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<div class="ecjia-user ecjia-margin-b">
	 <div class="ecjia-return-title">{t domain="h5"}快递方式选择{/t}</div>
     <ul class="ecjia-list ecjia-return-way-list">
     	<!-- {foreach from=$data.return_way_list item=shipping} -->
        <li>
			<a class="data-pjax" href="{url path='user/order/return_way'}&refund_sn={$refund_sn}&type={$shipping.return_way_code}">
				<div class="ecjia-return-item">
        			<div class="return-item-right">
        				<span class="title">{$shipping.return_way_name}</span>
        			</div>
        			<i class="iconfont icon-jiantou-right"></i>
        		</div>
        	</a>
		</li>
		<!-- {/foreach} -->
	</ul>
</div>
<!-- {/block} -->
{/nocache}	