<?php
/*
Name: 支付提示模板
Description: 
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="ecjia-flow-done">
    <div class="flow-success">
        <p style="width:4em;height:4em;"></p>
        <div class="ecjia-margin-t ecjiaf-tac ecjia-fz-big ecjia-color-green">{if $msg}{$msg}{else}支付成功！{/if}</div>
    </div>
    
    
    <div class="ecjia-margin-t ecjia-margin-b two-btn">
        <a class="btn" href='{url path="touch/index/init"}'>返回首页</a>
        {if !$order_type}
        <a class="btn btn-hollow" href='{url path="user/order/order_list"}'>查看订单</a>
        {/if}
    </div>
</div>
<!-- {/block} -->
