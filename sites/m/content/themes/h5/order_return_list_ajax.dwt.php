<?php
/*
Name: 申请售后列表模板
Description: 这是申请售后列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
<!-- {foreach from=$order_list item=list} -->
<li class="ai">
	<a class="data-pjax" href="{url path='user/order/return_detail'}&order_id={$list.order_id}&refund_sn={$list.refund_sn}">
		<h4 class="aq">{t domain="h5"}服务单号：{/t}<em>{$list.refund_sn}</em></h4>
		<div class="ar">
			<!-- {foreach from=$list.goods_list item=goods key=key} -->
			{if $key lt 4}
			<span class="as"><img class="at" src="{$goods.img.small}"></span>
			{/if}
			<!-- {/foreach} -->
			<em class="av">{t domain="h5" 1={$list.total_goods_number}}共%1件{/t}</em><em class="aw">{t domain="h5"}退款：{/t}{$list.total_refund_amount}</em>
		</div>
		<div class="ay h">
			<img class="ab" src="{if $list.refund_type eq 'refund'}{$theme_url}images/icon/icon-refund.png{elseif $list.refund_type eq 'return'}{$theme_url}images/icon/icon-return.png{/if}">
			<span class="audit_result">{$list.label_refund_type}，{$list.label_service_status}</span><em class="sales_view_details">{t domain="h5"}查看详情{/t}</em>
		</div>
	</a>
</li>
<!-- {/foreach} -->
<!-- {/block} -->
{/nocache}