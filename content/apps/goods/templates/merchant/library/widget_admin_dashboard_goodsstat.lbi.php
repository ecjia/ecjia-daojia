<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="move-mod-group" id="widget_admin_dashboard_goodsstat">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{$title}</h3>
		<span class="pull-right label label-info">{$goods.total}</span>
	</div>
	<table class="table table-bordered mediaTable dash-table-oddtd">
		<thead>
			<tr>
				<th colspan="4" class="optional">{t domain="goods"}商品统计信息{/t}</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><a href='{url path="goods/merchant/init"}' title="{t domain="goods"}商品总数{/t}">{t domain="goods"}商品总数{/t}</a></td>
				<td><strong>{$goods.total}</strong></td>
				<td><a href="{$goods.warn_goods_url}" title="{t domain="goods"}库存警告商品数{/t}">{t domain="goods"}库存警告商品数{/t}</a></td>
				<td class="dash-table-color"><strong>{$goods.warn_goods}</strong></td>
			</tr>
			<tr>
				<td><a href="{$goods.new_goods_url}" title="{t domain="goods"}新品推荐数{/t}">{t domain="goods"}新品推荐数{/t}</a></td>
				<td><strong>{$goods.new_goods}</strong></td>
				<td><a href="{$goods.best_goods_url}" title="{t domain="goods"}精品推荐数{/t}">{t domain="goods"}精品推荐数{/t}</a></td>
			</tr>
			<tr>
				<td><a href="{$goods.hot_goods_url}" title="{t domain="goods"}热销商品数{/t}">{t domain="goods"}热销商品数{/t}</a></td>
				<td><strong>{$goods.hot_goods}</strong></td>
				<td><a href="{$goods.promote_goods_url}" title="{t domain="goods"}促销商品数{/t}">{t domain="goods"}促销商品数{/t}</a></td>
				<td><strong>{$goods.promote_goods}</strong></td>
			</tr>
		</tbody>
	</table>
</div>
