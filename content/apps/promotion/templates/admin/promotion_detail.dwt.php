<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">

</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        {/if}
    </h3>
</div>

<div class="row-fluid admin-promotion-detail">
    <div class="row-fluid edit-page editpage-rightbar">
        <div class="left-bar move-mod">
            <div class="form-horizontal">
                <div class="control-group formSep">
                    <label class="control-label">{t domain="promotion"}活动状态：{/t}</label>
                    <div class="controls l_h30">
                        <span class="promote-status {$goods.promote_status}">{$goods.promote_status_label}</span>
                    </div>
                </div>

                <div class="control-group formSep">
                    <label class="control-label">{t domain="promotion"}活动范围：{/t}</label>
                    <div class="controls l_h30">{$goods.range_label}</div>
                </div>

                <div class="control-group formSep">
                    <label class="control-label">{t domain="promotion"}活动时间：{/t}</label>
                    <div class="controls">
                        <input class="w130" type="text" value="{$goods.promote_start_date}" disabled> 至
                        <input class="w130" type="text" value="{$goods.promote_end_date}" disabled>
                        <span class="input-must">*</span>
                        <span class="help-block">活动到期后将自动失效，时间精确到：分钟</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">{t domain="promotion"}参与活动商品：{/t}</label>
                    <div class="controls">
                        <div class="goods-temp-content">
                            <div class="goods-temp-info">
                                <div class="notice m_t0">
                                    <p>{t domain="promotion"}注：1、限购总数量：限制商品参与活动的总数量，此设置不能高于商品（SPU/SKU）总库存；{/t}</p>
                                    <p>{t domain="promotion"}2、每人限购：限制每个会员购买活动商品的数量，此设置不能高于限购总数量，默认0代表不设置；{/t}</p>
                                    <p>{t domain="promotion"}3、活动价：设置商品（SPU/SKU）活动价格，此设置不能高于商品（SPU/SKU）原价；{/t}</p>
                                </div>

                                <!-- {if $products} -->
                                <div class="goods-content overflow">
                                    <div class="goods-info">
                                        <div class="left">
                                            <img src="{$goods.goods_thumb}" alt="">
                                        </div>
                                        <div class="right">
                                            <div class="name">
                                                <span class="spec-label">{t domain="promotion"}多货品{/t}</span> {$goods.goods_name}
                                            </div>
                                            <div class="goods_sn">{t domain="promotion"}货号：{/t}{$goods.goods_sn}</div>
                                            <div class="info">
                                                <span class="price">{$goods.formated_shop_price}</span>
                                                <span class="market_price">{t domain="promotion"}市场价：{/t}{$goods.formated_market_price}</span>
                                                <span class="goods_number">{t domain="promotion"}库存：{/t}{$goods.goods_number}</span>
                                            </div>
                                            <div>
                                                <a target="_blank" href='{url path="goods/admin/preview" args="id={$goods.goods_id}"}'>{t domain="promotion"}预览>>{/t}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-dashed m_b20"></div>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="w250">{t domain="promotion"}货品SKU{/t}</th>
                                            <th>{t domain="promotion"}编号{/t}</th>
                                            <th class="w100">{t domain="promotion"}限购总数量{/t}<span class="m_l5 red-color">*</span>
                                            </th>
                                            <th class="w80">{t domain="promotion"}每人限购{/t}</th>
                                            <th class="w80">{t domain="promotion"}活动价{/t}<span class="m_l5 red-color">*</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <!-- {foreach from=$products item=item key=key} -->
                                    {if $item.is_promote eq 1}
                                    <tr>
                                        <td>
                                            <img class="ecjiaf-fl" src="{$goods.goods_thumb}" width="60" style="height: 60px;">
                                            <div class="product-info">
                                                <div class="name">{$item.attr_value}</div>
                                                <div class="other-info">
                                                    <span class="price">{$goods.formated_shop_price}</span>
                                                    <span class="number">{t domain="promotion"}库存：{/t}{$item.product_number}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="m_b5">{t domain="promotion"}货号：{/t}{$item.product_sn}</div>
                                            <!--                                            <div>{t domain="promotion"}条形码：{/t}</div>-->
                                        </td>
                                        <td>
                                            <input disabled class="w30" type="text" name="promote_limited[]" value="{$item.promote_limited}">
                                        </td>
                                        <td>
                                            <input disabled class="w30" type="text" name="promote_user_limited[]" value="{$item.promote_user_limited}">
                                        </td>
                                        <td>
                                            <input disabled class="w80" type="text" name="promote_price[]" value="{$item.promote_price}">
                                        </td>
                                        <input class="form-control" type="hidden" name="product_id[]" value="{$item.product_id}">
                                    </tr>
                                    {/if}
                                    <!-- {/foreach} -->
                                </table>
                                <!-- {else} -->
                                <p class="m_t10"><a href="">{t domain="promotion"}预览>>{/t}</a></p>
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="w250">{t domain="promotion"}商品SPU{/t}</th>
                                            <th>{t domain="promotion"}编号{/t}</th>
                                            <th class="w100">{t domain="promotion"}限购总数量{/t}<span class="m_l5 red-color">*</span>
                                            </th>
                                            <th class="w80">{t domain="promotion"}每人限购{/t}</th>
                                            <th class="w80">{t domain="promotion"}活动价{/t}<span class="m_l5 red-color">*</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td>
                                            <img class="ecjiaf-fl" src="{$goods.goods_thumb}" width="60" height="60">
                                            <div class="product-info">
                                                <div class="name">{$goods.goods_name}</div>
                                                <div class="other-info">
                                                    <span class="price">{$goods.formated_shop_price}</span>
                                                    <span class="number">{t domain="promotion"}库存：{/t}{$goods.goods_number}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="m_b5">{t domain="promotion"}货号：{/t}{$goods.goods_sn}</div>
                                            <!--                                            <div>{t domain="promotion"}条形码：{/t}</div>-->
                                        </td>
                                        <td>
                                            <input disabled class="w30" type="text" name="promote_limited" value="{$goods.promote_limited}">
                                        </td>
                                        <td>
                                            <input disabled class="w30" type="text" name="promote_user_limited" value="{$goods.promote_user_limited}">
                                        </td>
                                        <td>
                                            <input disabled class="w80" type="text" name="promote_price" value="{$goods.promote_price}">
                                        </td>
                                    </tr>
                                </table>
                                <!-- {/if} -->
                            </div>
                        </div>
                    </div>
                </div>

                {if $action}
                <div class="control-group">
                    <div class="controls">
                        <a class="btn btn-gebo" target="_blank" href="{RC_Uri::url('promotion/admin/autologin')}&store_id={$goods.store_id}&url={$edit_url}">去修改</a>
                    </div>
                </div>
                {/if}
            </div>
        </div>

        <div class="right-bar move-mod">
            <div class="foldable-list move-mod-group" id="merchants_info_sort_cat">
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#area_one">
                            <strong>{t domain="promotion"}店铺信息{/t}</strong>
                        </a>
                    </div>
                    <div class="accordion-body in in_visable collapse" id="area_one">
                        <div class="accordion-inner">
                            <div class="merchants_info">
                                <div class="logo-info">
                                    <img src="{$shop.shop_logo}" alt="">
                                    <div class="info">
                                        <div class="name">{$shop.merchants_name}</div>
                                        {if $shop.manage_mode eq 'self'}
                                        <span class="self-mode">自营</span>
                                        {/if}
                                    </div>
                                </div>

                                <div class="other-info">
                                    <div class="info-item"><label>营业时间：</label>
                                        <div class="content">{$shop.trade_time}</div>
                                    </div>
                                    <div class="info-item"><label>商家电话：</label>
                                        <div class="content">{$shop.shop_kf_mobile}</div>
                                    </div>
                                    <div class="info-item"><label>商家地址：</label>
                                        <div class="content">{$shop.address}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {if $count gt 0}
            <div class="foldable-list move-mod-group" id="other_promotion_sort_cat">
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#area_one">
                            <strong>{t domain="promotion"}该商户其他促销{/t}</strong>
                        </a>
                    </div>
                    <div class="accordion-body in in_visable collapse" id="area_one">
                        <div class="accordion-inner">
                            <div class="goods-content">
                                {foreach from=$result item=val}
                                <div class="goods-info m_b10 border-bottom">
                                    <div class="left">
                                        <a target="_blank" href="{RC_Uri::url('promotion/admin/detail')}&id={$val.goods_id}"><img src="{$val.goods_thumb}" alt=""></a>
                                    </div>
                                    <div class="right">
                                        <div class="name p_t5">
                                            {if $val.products}
                                            <span class="spec-label">{t domain="promotion"}多货品{/t}</span>
                                            {/if}
                                            <a target="_blank" href="{RC_Uri::url('promotion/admin/detail')}&id={$val.goods_id}">{$val.goods_name}</a>
                                        </div>
                                        <div class="goods_sn m_t15">{t domain="promotion"}货号：{/t}{$val.goods_sn}</div>
                                        <div class="info">
                                            <span class="market_price">{t domain="promotion"}促销价：{/t} <span class="red-color">{$val.formated_promote_price}</span> <del class="ecjiaf-fr">{$val.formated_market_price}</del></span>
                                        </div>
                                    </div>
                                </div>
                                {/foreach}
                            </div>
                            {if $count gt 3 && $action}
                            <div class="view-more">
                                <a target="_blank" href="{RC_Uri::url('promotion/admin/init')}&store_id={$goods.store_id}">查看更多>></a>
                            </div>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
            {/if}
        </div>
    </div>


</div>
<!-- {/block} -->