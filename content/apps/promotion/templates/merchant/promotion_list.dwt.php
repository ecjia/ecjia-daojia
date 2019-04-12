<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.promotion_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="page-header">
    <div class="pull-left">
        <h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
    </div>
    <div class="pull-right">
        <!-- {if $action_link} -->
        <a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fa fa-plus"></i> {$action_link.text}</a>
        <!-- {/if} -->
    </div>
    <div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
            <div class="panel-body panel-body-small">
                <ul class="nav nav-pills pull-left">
                    <li class="{if $type eq 'on_sale'}active{/if}">
                        <a class="data-pjax" href='{url path="promotion/merchant/init" args="{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="promotion"}正在进行中{/t}<span class="badge badge-info">{if $type_count.on_sale}{$type_count.on_sale}{else}0{/if}</span>
                        </a>
                    </li>
                    <li class="{if $type eq 'coming'}active{/if}">
                        <a class="data-pjax" href='{url path="promotion/merchant/init" args="type=coming{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="promotion"}即将开始{/t}<span class="badge badge-info">{if $type_count.coming}{$type_count.coming}{else}0{/if}</span>
                        </a>
                    </li>
                    <li class="{if $type eq 'finished'}active{/if}">
                        <a class="data-pjax" href='{url path="promotion/merchant/init" args="type=finished{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="promotion"}已结束{/t}<span class="badge badge-info">{if $type_count.finished}{$type_count.finished}{else}0{/if}</span>
                        </a>
                    </li>
                </ul>
                <form class="form-inline pull-right" name="searchForm" method="post" action="{$form_search}{if $smarty.get.type}&type={$smarty.get.type}{/if}">
                    <div class="form-group">
                        <!-- 关键字 -->
                        <input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain=" promotion"}请输入商品名称关键字{/t}"/>
                        <button class="btn btn-primary" type="submit">
                            <i class='fa fa-search'></i> {t domain="promotion"}搜索{/t}
                        </button>
                    </div>
                </form>
            </div>
            <div class="panel-body panel-body-small">
                <section class="panel">
                    <table class="table table-striped table-hover table-hide-edit">
                        <thead>
                            <tr>
                                <th>{t domain="promotion"}活动商品（SPU/SKU）{/t}</th>
                                <th class="w130">{t domain="promotion"}活动范围{/t}</th>
                                <th class="w100">{t domain="promotion"}限购总数{/t}</th>
                                <th class="w100">{t domain="promotion"}每人限购{/t}</th>
                                <th class="w100">{t domain="promotion"}活动价{/t}</th>
                                {if $type eq 'coming'}
                                <th class="w150">{t domain="promotion"}开始时间{/t}</th>
                                {else}
                                <th class="w150">{t domain="promotion"}结束时间{/t}</th>
                                {/if}
                                <th class="w100">{t domain="promotion"}活动状态{/t}</th>
                                <th class="w50"></th>
                            </tr>
                        </thead>
                        <!-- {foreach from=$promotion_list.item item=item key=key} -->
                        <tr>
                            <td class="hide-edit-area">
                                <img class="ecjiaf-fl" src="{$item.goods_thumb}" width="60" height="60">
                                <div class="area-item">
                                    <div>{if $item.products}<span class="spec-label">{t domain="promotion"}多货品{/t}</span>{/if}{$item.goods_name}
                                    </div>
                                    <div class="goods_sn">{t domain="promotion"}货号：{/t}{$item.goods_sn}</div>
                                    <div class="edit-list">
                                        <a class="data-pjax" href='{RC_Uri::url("promotion/merchant/edit", "id={$item.goods_id}")}' title='{t domain="promotion"}编辑{/t}'>{t domain="promotion"}编辑{/t}</a>&nbsp;|&nbsp;
                                        <a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg='{t domain="promotion"}您确定要删除该促销活动吗？{/t}' href='{RC_Uri::url("promotion/merchant/remove", "id={$item.goods_id}")}' title='{t domain="promotion"}删除{/t}'>{t domain="promotion"}删除{/t}</a>
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
                                <i class="fa fa-caret-down cursor_pointer" data-toggle="show_products" data-id="{$item.goods_id}"></i>
                                {/if}
                            </td>
                        </tr>
                        <!-- {if $item.products} -->
                        <tbody class="border-none td-product-{$item.goods_id} hide">
                            <!-- {foreach from=$item.products item=val} -->
                            <tr>
                                <td>
                                    <div class="area-item">
                                        <img class="ecjiaf-fl" src="{$item.goods_thumb}" width="60" height="60">
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
                </section>
                <!-- {$promotion_list.page} -->
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->