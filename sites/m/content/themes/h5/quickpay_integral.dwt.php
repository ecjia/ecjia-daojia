<?php
/*
Name: 闪惠积分
Description: 闪惠积分单页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
// 	ecjia.touch.enter_search();
</script>
<!-- {/block} -->
<!-- {block name="main-content"} -->
<form id="theForm" name="theForm" action='{url path="user/quickpay/init" args="store_id={$store_id}"}' method="post">
	<div class="quickpay">
	    <div class="checkout">
	        <p class="intergal_title">{t}您总共有{$data.user_integral}个{$integral_name}{/t}</p>
	        <input class="intergal_input before_two" placeholder="最多可使用{if $data.user_integral lt $activity.order_max_integral }{$data.user_integral}{else}{$activity.order_max_integral}{/if}个{$integral_name}" name="integral" value="{$temp.integral}">
	    </div>
	    
	     <div class="save_discard">
	        <input class="btn mag-t1" name="save" type="submit" value="保存">
	        <input type="hidden" name="integral_update" value="1" />
	        <input class="btn btn-hollow-danger mag-t1" name="integral_clear" type="submit" value="清空">
	    </div>
	</div>
</form>
<!-- {/block} -->
{/nocache}