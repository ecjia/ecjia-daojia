<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.sidebar.click();
    ecjia.admin.promotion_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<style>

  .table  .fontello-icon-sort-down{
    position: relative;
    display: inline-block;
    top: -3px;}
  .table  .fontello-icon-sort-up{
      position: relative;
      display: inline-block;
      top: 4px;}
</style>
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link} -->
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
        <!-- {/if} -->
    </h3>
</div>
<ul class="nav nav-pills">
    <li class="{if !$type || $type eq 'on_sale'}active{/if}">
        <a class="data-pjax" href='{url path="promotion/admin/init" args="{if $store_id}&store_id={$store_id}{/if}{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>
            {t domain="promotion"}进行中{/t}<span class="badge badge-info">{if $type_count.on_sale}{$type_count.on_sale}{else}0{/if}</span>
        </a>
    </li>
    <li class="{if $type eq 'coming'}active{/if}">
        <a class="data-pjax" href='{url path="promotion/admin/init" args="type=coming{if $store_id}&store_id={$store_id}{/if}{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>
            {t domain="promotion"}即将开始{/t}<span class="badge badge-info">{if $type_count.coming}{$type_count.coming}{else}0{/if}</span>
        </a>
    </li>
    <li class="{if $type eq 'finished'}active{/if}">
        <a class="data-pjax" href='{url path="promotion/admin/init" args="type=finished{if $store_id}&store_id={$store_id}{/if}{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>
            {t domain="promotion"}已结束{/t}<span class="badge badge-info">{if $type_count.finished}{$type_count.finished}{else}0{/if}</span>
        </a>
    </li>

    <li class="ecjiaf-fn">
        <form name="searchForm" method="post" action="{$form_search}{if $smarty.get.type}&type={$smarty.get.type}{/if}">
            <div class="f_r form-inline">
                <input type="text" class="w180" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder='{t domain="promotion"}请输入商家名称关键字{/t}'/>
                <input type="text" class="w180" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="promotion"}请输入商品名称关键字{/t}'/>
                <button class="btn" type="submit">{t domain="promotion"}搜索{/t}</button>
            </div>
        </form>
    </li>
</ul>
<div class="row-fluid list-page">
    <div class="span12">
        <table class="table table-hover table-hide-edit">
            <thead>
                <tr>
                    <th class="w250">{t domain="promotion"}活动商品（SPU/SKU）{/t}</th>
                    <th class="w80">{t domain="promotion"}活动范围{/t}</th>
                    <th class="w80">{t domain="promotion"}限购总数{/t}</th>
                    <th class="w80">{t domain="promotion"}每人限购{/t}</th>
                    <th class="w80">{t domain="promotion"}活动价{/t}</th>
                    {if $type eq 'coming'}
                    <th class="w130">{t domain="promotion"}开始时间{/t}</th>
                    {else}
                    <th class="w130">{t domain="promotion"}结束时间{/t}</th>
                    {/if}
                    <th class="w80">{t domain="promotion"}活动状态{/t}</th>
                    <th class="w50"></th>
                </tr>
            </thead>
            <!-- {foreach from=$promotion_list.item item=item key=key} -->
            <tr>
                <td class="hide-edit-area">
                    <img class="ecjiaf-fl" src="{$item.goods_thumb}" width="60" style="height: 60px;padding-top: 20px;">
                    <div class="area-item">
                        <div class="ecjiaf-fwb m_b5">{$item.merchants_name} {if $item.manage_mode eq 'self'}<span class="red-color ecjiaf-fwn">{t domain="promotion"}（自营）{/t}</span>{/if}
                        </div>
                        <div>{if $item.products}<span class="spec-label">{t domain="promotion"}多货品{/t}</span>{/if}{$item.goods_name}
                        </div>
                        <div class="goods_sn">{t domain="promotion"}货号：{/t}{$item.goods_sn}</div>
                        <div class="edit-list">
                            <a href='{RC_Uri::url("promotion/admin/detail", "id={$item.goods_id}")}' title='{t domain="promotion"}查看详情{/t}'>{t domain="promotion"}查看详情{/t}</a>
                        </div>
                    </div>
                </td>

                <td>{$item.range_label}</td>

                {if $item.products}
                <td></td>
                <td></td>
                <td></td>
                {else}

                <td>{$item.promote_limited}</td>
                <td>{$item.promote_user_limited}</td>
                <td>{$item.formated_promote_price}</td>
                {/if}

                {if $type eq 'coming'}
                <td>{$item.start_time}</td>
                {else}
                <td>{$item.end_time}</td>
                {/if}
                <td>
                    {if $type eq 'on_sale'}
                    <span class="sale_status">{t domain="promotion"}进行中{/t}</span>
                    {else if $type eq 'coming'}
                    <span class="coming_status">{t domain="promotion"}即将开始{/t}</span>
                    {else if $type eq 'finished'}
                    <span class="finished_status">{t domain="promotion"}已结束{/t}</span>
                    {/if}
                </td>

                <td>
                    {if $item.products}
                    <a data-toggle="show_products" data-id="{$item.goods_id}"><i class="fontello-icon-sort-down"></i><span>{t domain="promotion"}展开{/t}</span></a>
                    {/if}
                </td>
            </tr>
            <!-- {if $item.products} -->
            <tbody class="border-none td-product-{$item.goods_id} hide">
                <!-- {foreach from=$item.products item=val} -->
                <tr>
                    <td>
                        <div class="area-item">
                            <img class="ecjiaf-fl" src="{$item.goods_thumb}" width="60" style="height: 60px;">
                            <div class="area-item-content">
                                <div class="attr">{$val.attr_value}</div>
                                <div class="sn">{t domain="promotion"}货号：{/t}{$val.product_sn}</div>
                            </div>
                        </div>
                    </td>
                    <td></td>
                    <td>{$val.promote_limited}</td>
                    <td>{$val.promote_user_limited}</td>
                    <td>{$val.formated_promote_price}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <!-- {/foreach} -->
            </tbody>
            <!-- {/if} -->

            <!-- {foreachelse} -->
            <tr>
                <td class="no-records" colspan="8">{t domain="promotion"}没有找到任何记录{/t}</td>
            </tr>
            <!-- {/foreach} -->
        </table>
        <!-- {$promotion_list.page} -->
    </div>
</div>
<!-- {/block} -->