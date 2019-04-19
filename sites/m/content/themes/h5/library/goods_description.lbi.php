<?php
/*
Name: 商品祥情相关商品
Description: 这是商品祥情相关商品
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
{if $no_goods_info neq 1}
<div class="goods-desc-info active" id="goods-info-two" style="margin-top:3.5em;">
    <!--商品描述-->
    <!-- Nav tabs -->
    <ul class="ecjia-list ecjia-list-new ecjia-list-two ecjia-list-two-new ecjia-nav ecjia-nav-new goods-desc-nav-new">
        <li class="active goods-desc-li-info one-li" data-id="1">
            <a class="a1" href="javascript:;">{t domain="h5"}图文详情{/t}</a>
            <span class="goods-detail-title-border"></span>
        </li>
        <li class="goods-desc-li-info two-li" style="border-left:none;" data-id="2"><a class="a2" href="javascript:;">{t domain="h5"}规格参数{/t}</a></li>
    </ul>
    <!-- Tab panes -->
    <div class="goods-describe ecjia-margin-b active" id="one-info">
        <!-- {if $goods_desc && $goods_desc neq ''} -->
        {$goods_desc}
        <!-- {else} -->
        <div class="ecjia-nolist">
            <img src="{$theme_url}images/wallet/null280.png">
            <p class="tags_list_font">{t domain="h5"}暂无任何商品详情{/t}</p>
        </div>
        <!-- {/if} -->
    </div>
    <div class="goods-describe goods-describe-new ecjia-margin-b" id="two-info">
        <!-- {if $goods_info.properties} -->
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#dddddd">
            <!-- {foreach from=$goods_info.properties item=property_group} -->
            <tr>
                <td bgcolor="#FFFFFF" align="left" width="40%" class="f1">{$property_group.name|escape:html}</td>
                <td bgcolor="#FFFFFF" align="left" width="60%">{$property_group.value}</td>
            </tr>
            <!-- {/foreach}-->
        </table>
        <!-- {else} -->
        <div class="ecjia-nolist">
            <img src="{$theme_url}images/wallet/null280.png">
            <p class="tags_list_font">{t domain="h5"}暂无任何规格参数{/t}</p>
        </div>
        <!-- {/if} -->
    </div>
</div>
{/if}
{/nocache}