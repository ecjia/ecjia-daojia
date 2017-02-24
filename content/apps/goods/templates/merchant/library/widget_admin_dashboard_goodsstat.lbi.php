<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="move-mod-group" id="widget_admin_dashboard_goodsstat">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{$title}</h3>
		<span class="pull-right label label-info">{$goods.total}</span>
	</div>
	<table class="table table-bordered mediaTable dash-table-oddtd">
		<thead>
			<tr>
				<th colspan="4" class="optional">{lang key='goods::goods.goods_count_info'}</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><a href='{url path="goods/merchant/init"}' title="{lang key='goods::goods.goods_total'}">{lang key='goods::goods.goods_total'}</a></td>
				<td><strong>{$goods.total}</strong></td>
				<td><a href="{$goods.warn_goods_url}" title="{lang key='goods::goods.warn_goods_number'}">{lang key='goods::goods.warn_goods_number'}</a></td>
				<td class="dash-table-color"><strong>{$goods.warn_goods}</strong></td>
			</tr>
			<tr>
				<td><a href="{$goods.new_goods_url}" title="{lang key='goods::goods.new_goods_number'}">{lang key='goods::goods.new_goods_number'}</a></td>
				<td><strong>{$goods.new_goods}</strong></td>
				<td><a href="{$goods.best_goods_url}" title="{lang key='goods::goods.best_goods_number'}">{lang key='goods::goods.best_goods_number'}</a></td>
				<td><strong>{$goods.best_goods}</strong></td>
			</tr>
			<tr>
				<td><a href="{$goods.hot_goods_url}" title="{lang key='goods::goods.hot_goods_number'}">{lang key='goods::goods.hot_goods_number'}</a></td>
				<td><strong>{$goods.hot_goods}</strong></td>
				<td><a href="{$goods.promote_goods_url}" title="{lang key='goods::goods.promote_goods_numeber'}">{lang key='goods::goods.promote_goods_numeber'}</a></td>
				<td><strong>{$goods.promote_goods}</strong></td>
			</tr>
		</tbody>
	</table>
</div>
