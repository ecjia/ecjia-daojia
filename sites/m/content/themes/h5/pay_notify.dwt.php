<?php
/*
Name: 支付提示模板
Description: 
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-flow-done">
    <div class="flow-success">
        <p style="width: 3em;height: 3.5em;padding-left: 0;"></p>
        <div class="ecjia-margin-t ecjiaf-tac ecjia-fz-big ecjia-color-green">{if $msg}{$msg}{else}{t domain="h5"}支付成功！{/t}{/if}</div>
    </div>
    
    <div class="ecjia-margin-t ecjia-margin-b two-btn">
        <a class="btn" href='{$url.index}'>{t domain="h5"}返回首页{/t}</a>
        {if !$order_type}
        <a class="btn btn-hollow" href='{$url.order}'>{t domain="h5"}查看订单{/t}</a>
        {/if}
    </div>
</div>
<!-- {/block} -->
{/nocache}
