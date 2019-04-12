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
	        <p class="intergal_title">{t domain="h5" 1={$data.user_integral} 2={$integral_name}}您总共有%1个%2{/t}</p>
	        <input class="intergal_input before_two" placeholder='{t domain="h5"}最多可使用{/t}{if $data.user_integral lt $activity.order_max_integral }{$data.user_integral}{else}{$activity.order_max_integral}{/if}{t domain="h5"}个{/t}{$integral_name}' name="integral" value="{$temp.integral}">
	    </div>
	    
	     <div class="save_discard">
	        <input class="btn mag-t1" name="save" type="submit" value='{t domain="h5"}保存{/t}'>
	        <input type="hidden" name="integral_update" value="1" />
	        <input class="btn btn-hollow-danger mag-t1" name="integral_clear" type="submit" value='{t domain="h5"}清空{/t}'>
	    </div>
	</div>
</form>
<!-- {/block} -->
{/nocache}