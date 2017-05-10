<?php
/*
Name: 使用积分
Description: 使用积分模板
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
    <div class="ecjia-select ecjia-flow-invoice">
        <p class="select-title ecjia-margin-l">发票抬头</p>
        <div class="input input100">
            <input type="text" name="inv_payee" value="{$temp.inv_payee}" placeholder="请输入发票抬头，如:个人">
        </div>
        <p class="select-title ecjia-margin-l ">发票内容</p>
        <ul class="ecjia-list ecjia-border-t">
            <!-- {foreach from=$inv_content_list item=list key=index} -->
            <label class="select-item" for="content-{$list.id}">
                <li>
                    <span class="slect-title">{$list.value}</span>
                    <span class="ecjiaf-fr">
                        <label class="ecjia-check"><input type="radio" name="inv_content" id="content-{$list.id}" value="{$list.value}" {if $temp.inv_content eq '' && $index eq 0}checked="true"{/if}{if $temp.inv_content eq $list.value}checked="true"{/if}>
                        </label>
                    </span>
                </li>
            </label>
            <!-- {foreachelse} -->
            <li>暂无</li>
            <!-- {/foreach} -->
        </ul>
        
        <!-- {if $inv_type_list} -->
        <p class="select-title ecjia-margin-l">发票类型</p>
        <ul class="ecjia-list ecjia-border-t">
            <!-- {foreach from=$inv_type_list item=list key=index} -->
            <label class="select-item" for="type-{$list.id}">
                <li>
                    <span class="slect-title">{$list.value}</span>
                    <span class="ecjiaf-fr">
                        <label class="ecjia-check"><input type="radio" name="inv_type" id="type-{$list.id}" value="{$list.label_value}" {if $temp.inv_type eq '' && $index eq 0}checked="true"{/if}{if $temp.inv_type eq $list.label_value}checked="true"{/if}>
                        </label>
                    </span>
                </li>
            </label>
            <!-- {foreachelse} -->
            <li>暂无</li>
            <!-- {/foreach} -->
        </ul>
        <!-- {/if} -->
        
        <div class="ecjia-margin-t2 ecjia-margin-b">
            <input type="hidden" name="address_id" value="{$address_id}">
            <input type="hidden" name="rec_id" value="{$rec_id}" />
            <input class="btn btn-info" name="inv_update" type="submit" value="确定"/>
        </div>
        <div class="ecjia-margin-t ecjia-padding-b">
            <input class="btn btn-hollow-danger" name="inv_clear" type="submit" value="不开发票"/>
        </div>
    </div>
</form>
<!-- {/block} -->
{/nocache}