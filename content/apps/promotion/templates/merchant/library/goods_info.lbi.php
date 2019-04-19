<div class="goods-content">
    <div class="goods-info">
        <div class="left">
            <img src="{$goods.goods_thumb}" alt="">
        </div>
        <div class="right">
            <div class="name">{$goods.goods_name}</div>
            <div class="goods_sn">{t domain="promotion"}货号：{/t}{$goods.goods_sn}</div>
            <div class="info">
                <span class="price">{$goods.formated_shop_price}</span>
                <span class="market_price">{t domain="promotion"}市场价：{/t}{$goods.formated_market_price}</span>
                <span class="goods_number">{t domain="promotion"}库存：{/t}{$goods.goods_number}</span>
            </div>
            <div><a target="_blank" href='{url path="goods/merchant/preview" args="id={$goods.goods_id}"}'>{t domain="promotion"}预览>>{/t}</a>
            </div>
        </div>
    </div>

    {if $products}
    <div class="product-info">
        <div class="title">{t domain="promotion"}货品SKU{/t}</div>
        {foreach from=$products item=val}
        <div class="goods-info m_b10">
            <div class="left">
                <img src="{$val.product_thumb}" alt="">
            </div>
            <div class="right">
                <div class="name">{$val.product_name} {$val.attr_value}</div>
                <div class="goods_sn">
                	{t domain="promotion"}货号：{/t}{$val.product_sn}
                    {if $val.product_bar_code}<br><span class="goods_number">{t domain="promotion"}条形码：{/t}{$val.product_bar_code}</span>{/if}
                </div>
                <div class="info">
                    <span class="price">{$val.formated_attr_price}</span>
                    <span class="goods_number">{t domain="promotion"}库存：{/t}{$val.product_number}</span>
                </div>
            </div>
        </div>
        {/foreach}
    </div>
    {/if}
</div>