<?php
/*
Name: 选择支付方式
Description: 选择支付方式模板
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript" >
	ecjia.touch.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form id="theForm" name="theForm" action='{url path="cart/flow/checkout" args="{if $smarty.session.order_address_temp.store_id}store_id={$smarty.session.order_address_temp.store_id}&{/if}address_id={$address_id}&rec_id={$rec_id}"}' method="post">
    <div class="ecjia-select">
        <h3 class="select-title"></h3>
        <ul class="ecjia-list ecjia-margin-t">
            <!-- {foreach from=$shipping_list item=list} -->
            <label class="select-item" for="shipping_{$list.shipping_code}">
                <li>
                    <span class="slect-title">{$list.shipping_name}</span>
                    <span class="ecjiaf-fr ecjia-margin-l">
                        <label class="ecjia-check"><input type="radio" id="shipping_{$list.shipping_code}" name="shipping" value="{$list.shipping_id}"
                        {if $smarty.get.shipping_id eq $list.shipping_id} checked="true"{/if}>
                        </label>
                    </span>
                    <span class="ecjiaf-fr">{$list.format_shipping_fee}</span>
                </li>
            </label>
            <!-- {/foreach} -->
        </ul>
        <div class="ecjia-margin-t ecjia-margin-b">
            <input type="hidden" name="address_id" value="{$address_id}">
            <input type="hidden" name="rec_id" value="{$rec_id}" />
			<input class="btn btn-info" name="shipping_update" type="submit" value="确定"/>
        </div>
    </div>
</form>
<!-- {/block} -->
{/nocache}