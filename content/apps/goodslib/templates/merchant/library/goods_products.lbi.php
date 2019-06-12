<div class="goods-products">
	{t domain="goods"}货品（SKU）{/t}
	<hr style="margin-top:0px;">
</div>
<table class="table table-striped table-hide-edit">
	<thead>
        <tr>
        	<th class="w200">{t domain="goods"}货品SKU{/t}</th>
        	<th class="w100">{t domain="goods"}商品货号{/t}</th>
        	<th class="w100">{t domain="goods"}条形码{/t}</th>
        	<th class="w80">{t domain="goods"}价格{/t}</th>
        	<th class="w50">{t domain="goods"}库存{/t}</th>
        </tr>
	</thead>
	<tbody>
	<!-- {foreach from=$product_list item=list} -->
    	<tr>
    		<td class="hide-edit-area">
    			{if $list.product_thumb}
    				<img class="ecjiaf-fl" src="{$list.product_thumb}" width="60" height="60">
				{/if}
				 <div class="product-info" style="margin-left:65px;">
				    <div class="product-goods-name-style">{$list.product_name}</div>
				    {if $list.product_attr_value}【{$list.product_attr_value}】{/if}
				    {if $list.is_promote_now eq 1}<span class="goods-promote">{t domain='goodslib'}促{/t}</span>{/if}
				 </div>
    		</td>
    		<td>
    			{$list.product_sn}
    		</td>
    		<td>
    			{$list.product_bar_code}				
    		</td>
    		<td>{$list.formatted_product_shop_price}</td>
    		<td>{$list.product_number}</td>
    	</tr>
    <!-- {/foreach} -->
 </tbody>
</table>