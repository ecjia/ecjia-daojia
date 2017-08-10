<?php
/*
Name: 填写发票信息
Description: 填写发票信息模板
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.init();</script>
<script type="text/javascript">ecjia.touch.flow.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form id="theForm" name="theForm" action='{url path="cart/flow/checkout" args="{if $smarty.session.order_address_temp.store_id}store_id={$smarty.session.order_address_temp.store_id}&{/if}address_id={$address_id}&rec_id={$rec_id}"}' method="post">
    <div class="ecjia-select ecjia-flow-invoice">
        <p class="select-title ecjia-margin-l">发票抬头</p>
        <div class="select-type">
            <div class="inv_type personal {if $temp.inv_type_name != 'enterprise'}action{/if}">
                <p>个人</p>
                <image {if $temp.inv_type_name == 'enterprise'}style="display:none"{/if} class="ecjia-bill-img" src="{$theme_url}images/select.png"></image>
            </div>
            <div class="inv_type enterprise {if $temp.inv_type_name == 'enterprise'}action{/if}">
                <p>单位</p>
                <image {if $temp.inv_type_name != 'enterprise'}style="display:none"{/if} class="ecjia-bill-img" src="{$theme_url}images/select.png"></image>
            </div>
            <input name="inv_type_name" type="hidden" value="{if $temp.inv_type_name != ''}$temp.inv_type_name{else if}personal{/if}" />
            <div class="input input100 inv_input {if $temp.inv_type_name != 'enterprise'}inv_none{/if}">
                <input class="inv_type_input" type="text" name="inv_payee" value="{$temp.inv_payee}" placeholder="请填写单位发票抬头">
                <div class="img_flat">
                    <input class="inv_type_input" type="text" name="inv_bill_code" value="{$temp.inv_bill_code}" placeholder="请输入纳税人识别码">
                    <img class="inv_img" src="{$theme_url}images/info.png" />
                </div>
            </div>
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