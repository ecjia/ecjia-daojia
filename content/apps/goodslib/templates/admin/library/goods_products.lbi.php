<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div>
	<h3 class="heading">{t domain="goods"}货品（SKU）{/t}</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<thead>
					<tr>
						<th class="w150">{t domain="goods"}货品SKU{/t}</th>
			        	<th class="w100">{t domain="goods"}商品货号{/t}</th>
			        	<th class="w100">{t domain="goods"}条形码{/t}</th>
			        	<th class="w80">{t domain="goods"}价格{/t}</th>
			        	<th class="w50">{t domain="goods"}操作{/t}</th>
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
							 </div>
						</td>
						<td>
							{$list.product_sn}
						</td>
						<td>
							{$list.product_bar_code}
						</td>
						<td align="left">
							{$list.formatted_product_shop_price}
						</td>
						<td>
							<a target="_blank" href='{url path="goodslib/admin/product_edit" args="id={$list.product_id}&goods_id={$list.goods_id}"}'>{t domain='goodslib'}编辑{/t}</a>&nbsp;|&nbsp;
							<a target="_blank" href='{url path="goodslib/admin/product_preview" args="product_id={$list.product_id}&goods_id={$list.goods_id}"}'>{t domain='goodslib'}预览{/t}</a>	&nbsp;|&nbsp;		
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t domain='goodslib'}您确定要把该货品放入回收站吗？{/t}" href='{url path="goodslib/admin/product_remove" args="id={$list.product_id}&goods_id={$list.goods_id}"}'>{t domain='goodslib'}删除{/t}</a>
						</td>
					</tr>
					<!-- {foreachelse}-->
					<tr>
						<td class="no-records" colspan="5">{t domain="goods"}没有找到任何记录{/t}</td>
					</tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$order_list.page} -->
		</div>
	</div>
</div>