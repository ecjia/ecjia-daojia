<div class="goods-temp-info">
    <div class="notice">
        <p>{t domain="promotion"}注：1、限购总数量：限制商品参与活动的总数量，此设置不能高于商品（SPU/SKU）总库存；{/t}</p>
        <p>{t domain="promotion"}2、每人限购：限制每个会员购买活动商品的数量，此设置不能高于限购总数量，默认0代表不设置；{/t}</p>
        <p>{t domain="promotion"}3、活动价：设置商品（SPU/SKU）活动价格，此设置不能高于商品（SPU/SKU）原价；{/t}</p>
    </div>

    <!-- {if $products} -->
    <div class="goods-content">
        <div class="goods-info">
            <div class="left">
                <img src="{$goods.goods_thumb}" alt="">
            </div>
            <div class="right">
                <div class="name"> <span class="spec-label">{t domain="promotion"}多货品{/t}</span> {$goods.goods_name}</div>
                <div class="goods_sn">{t domain="promotion"}货号：{/t}{$goods.goods_sn}</div>
                <div class="info">
                    <span class="price">{$goods.formated_shop_price}</span>
                    <span class="market_price">{t domain="promotion"}市场价：{/t}{$goods.formated_market_price}</span>
                    <span class="goods_number">{t domain="promotion"}库存：{/t}{$goods.goods_number}</span>
                </div>
                <div>
                    <a target="_blank" href='{url path="goods/merchant/preview" args="id={$goods.goods_id}"}'>{t domain="promotion"}预览>>{/t}</a>
                </div>
            </div>
        </div>
    </div>
    <div class="border-dashed"></div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th></th>
                <th class="w250">{t domain="promotion"}货品SKU{/t}</th>
                <th>{t domain="promotion"}编号{/t}</th>
                <th class="w110">{t domain="promotion"}限购总数量{/t}<span class="m_l5 red-color">*</span>
                </th>
                <th class="w110">{t domain="promotion"}每人限购{/t}</th>
                <th class="w130">{t domain="promotion"}活动价{/t}<span class="m_l5 red-color">*</span>
                </th>
            </tr>
        </thead>
        <!-- {foreach from=$products item=item key=key} -->
        <tr>
            <td class="check-list">
                <div class="check-item">
                    <input id="checkbox_{$key}" type="checkbox" class="checkbox" value="1" name="checkboxes[{$key}]" {if $item.is_promote}checked{/if}>
                    <label for="checkbox_{$key}"></label>
                </div>
            </td>
            <td>
                <img class="ecjiaf-fl" src="{$item.product_thumb}" width="60" height="60">
                <div class="product-info">
                    <div class="name">{$item.product_name} {$item.attr_value}</div>
                    <div class="other-info">
                        <span class="price">{$item.formated_attr_price}</span>
                        <span class="number">{t domain="promotion"}库存：{/t}{$item.product_number}</span>
                    </div>
                </div>
            </td>
            <td>
                <div class="m_b5">{t domain="promotion"}货号：{/t}{$item.product_sn}</div>
                <div>{t domain="promotion"}条形码：{/t}{if $item.product_bar_code}{$item.product_bar_code}{else}暂无{/if}</div>
            </td>
            <td><input class="form-control" type="text" name="promote_limited[]" value="{$item.promote_limited}"></td>
            <td><input class="form-control" type="text" name="promote_user_limited[]" value="{$item.promote_user_limited}"></td>
            <td><input class="form-control" type="text" name="promote_price[]" value="{$item.promote_price}"></td>
            <input class="form-control" type="hidden" name="product_id[]" value="{$item.product_id}">
        </tr>
        <!-- {/foreach} -->
    </table>
    <!-- {else} -->
    <p class="m_t10"><a target="_blank" href='{url path="goods/merchant/preview" args="id={$goods.goods_id}"}'>{t domain="promotion"}预览>>{/t}</a></p>
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="w250">{t domain="promotion"}商品SPU{/t}</th>
                <th>{t domain="promotion"}编号{/t}</th>
                <th class="w110">{t domain="promotion"}限购总数量{/t}<span class="m_l5 red-color">*</span>
                </th>
                <th class="w110">{t domain="promotion"}每人限购{/t}</th>
                <th class="w130">{t domain="promotion"}活动价{/t}<span class="m_l5 red-color">*</span>
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
<!--                <div>{t domain="promotion"}条形码：{/t}</div>-->
            </td>
            <td><input class="form-control" type="text" name="promote_limited" value="{$goods.promote_limited}"></td>
            <td><input class="form-control" type="text" name="promote_user_limited" value="{$goods.promote_user_limited}"></td>
            <td><input class="form-control" type="text" name="promote_price" value="{$goods.promote_price}"></td>
        </tr>
    </table>
    <!-- {/if} -->
</div>