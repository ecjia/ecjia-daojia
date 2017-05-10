<?php
/*
Name: 选择红包
Description: 选择红包模板
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form id="theForm" name="theForm" action='{url path="cart/flow/checkout" args="{if $smarty.session.order_address_temp.store_id}store_id={$smarty.session.order_address_temp.store_id}&{/if}address_id={$address_id}&rec_id={$rec_id}"}' method="post">
    <div class="ecjia-select ecjia-checkout-bonus">
        <ul class="ecjia-list ecjia-margin-t">
            <!-- {foreach from=$data.bonus item=list} -->
            <label class="select-item" for="{$list.bonus_id}">
                <li>
                    <span class="ecjiaf-fr ecjia-margin-l">
                        <label class="ecjia-check"><input type="radio" id="{$list.bonus_id}" name="bonus" value="{$list.bonus_id}"  {if $temp.bonus eq $list.bonus_id}checked="true"{/if}>
                        </label>
                    </span>
                    <span class="">{$list.bonus_name}</span>
                    <span class="ecjiaf-fr">{$list.formatted_bonus_amount}</span>
                </li>
            </label>
           <!-- {foreachelse} -->
           <label class="select-item" for="{$list.bonus_id}">
                <li>
                    <span class="ecjia-color-999">暂无可用红包</span>
                </li>
          	</label>
           	<!-- {/foreach} -->
        </ul>
        <div class="two-btn">
            <input type="hidden" name="address_id" value="{$address_id}">
            <input type="hidden" name="rec_id" value="{$rec_id}" />
            <input class="btn btn-hollow-danger" name="bonus_clear" type="submit" value="清空"/>
            <input class="btn btn-info" name="bonus_update" type="submit" value="确定"/>
        </div>
    </div>
</form>
<!-- {/block} -->
{/nocache}