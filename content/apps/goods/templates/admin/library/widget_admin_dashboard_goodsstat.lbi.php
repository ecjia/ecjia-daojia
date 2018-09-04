<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="move-mod-group" id="widget_admin_dashboard_goodsstat">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{$title}</h3>
		<span class="pull-right label label-info">{$goods.total}</span>
	</div>
	<table class="table table-bordered mediaTable dash-table-oddtd">
		<thead>
			<tr>
				<th colspan="4" class="optional">
					{lang key='goods::goods.goods_count_info'}
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<a href='{url path="goods/admin/init"}' title="{lang key='goods::goods.goods_total'}">{lang
						key='goods::goods.goods_total'}</a>
				</td>
				<td>
					<strong>{$goods.total}</strong>
				</td>
				<td>
					<a href="{$goods.new_goods_url}" title="{lang key='goods::goods.new_goods_number'}">{lang
						key='goods::goods.new_goods_number'}</a>
				</td>
				<td>
					<strong>{$goods.new_goods}</strong>
				</td>
			</tr>
			<tr>
				<td>
					<a href="{$goods.best_goods_url}" title="{lang key='goods::goods.best_goods_number'}">{lang
						key='goods::goods.best_goods_number'}</a>
				</td>
				<td>
					<strong>{$goods.best_goods}</strong>
				</td>
				<td>
					<a href="{$goods.hot_goods_url}" title="{lang key='goods::goods.hot_goods_number'}">{lang
						key='goods::goods.hot_goods_number'}</a>
				</td>
				<td>
					<strong>{$goods.hot_goods}</strong>
				</td>
			</tr>
			<tr>
				<td>
					<a href="{$goods.wait_check_url}" title="{lang key='goods::goods.wait_check_goods'}">{lang
						key='goods::goods.wait_check_goods'}</a>
				</td>
				<td colspan="3" {if $goods.wait_check gt 0}class="dash-table-color" {/if}> <strong>{$goods.wait_check}</strong>
				</td>
			</tr>
		</tbody>
	</table>
</div>