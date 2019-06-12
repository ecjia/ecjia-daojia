<div class="goods-products">
	{t domain="goods"}货品（SKU）{/t}
	<hr style="margin-top:0px;">
</div>
<table class="table table-striped table-hide-edit">
	<thead>
        <tr>
        	<th class="w100">{t domain="goods"}货品SKU{/t}</th>
        	<th class="w100">{t domain="goods"}商品货号{/t}</th>
        	<th class="w100">{t domain="goods"}条形码{/t}</th>
        	<th class="w80">{t domain="goods"}价格{/t}</th>
        	<th class="w50">{t domain="goods"}库存{/t}</th>
        	<th class="w120">{t domain="goods"}操作{/t}</th>
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
				    {if $list.product_attr_value} 【{$list.product_attr_value}】 {/if}
				    {if $list.is_promote_now eq 1}<span class="goods-promote">{t domain='goods'}促{/t}</span>{/if}
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
    		<td>
    			<a target="_blank" href='{url path="goods/merchant/product_edit" args="id={$list.product_id}&goods_id={$list.goods_id}"}'>{t domain='goods'}编辑{/t}</a>&nbsp;|&nbsp;
    			<a target="_blank" href='{url path="goods/merchant/product_preview" args="product_id={$list.product_id}&goods_id={$list.goods_id}&preview_type={$preview_type}"}'>{t domain='goods'}预览{/t}</a>	&nbsp;|&nbsp;		
				<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t domain='goods'}您确定要把该货品放入回收站吗？{/t}" href='{url path="goods/merchant/product_remove" args="id={$list.product_id}&goods_id={$list.goods_id}"}'>{t domain='goods'}删除{/t}</a>
			</td>
    	</tr>
    <!-- {/foreach} -->
 </tbody>
</table>