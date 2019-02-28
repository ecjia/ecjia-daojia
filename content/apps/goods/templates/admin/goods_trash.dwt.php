<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_trash.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	{if $action_link}
	<a href="{$action_link.href}" class="btn plus_or_reply data-pjax"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	{/if}
	</h3>
</div>
<ul class="nav nav-pills">
	<li class="{if $filter.type eq ''}active{/if}">
	<a class="data-pjax" href='{url path="goods/admin/trash" args="{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="goods"}全部{/t}
	<span class="badge badge-info">{$filter.count_goods_num}</span>
	</a>
	</li>
	<li class="{if $filter.type eq 'self'}active{/if}">
	<a class="data-pjax" href='{url path="goods/admin/trash" args="type=self{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="goods"}自营{/t}
	<span class="badge badge-info">{$filter.self}</span>
	</a>
	</li>
</ul>
<div class="row-fluid batch">
	<form method="post" action="{$search_action}" name="actionForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fontello-icon-cog"></i>{t domain="goods"}批量操作{/t}
			<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{$form_action}&type=restore&page={$smarty.get.page}" data-msg="{t domain="goods"}您确定要把选中的商品还原吗？{/t}" data-noselectmsg="{t domain="goods"}请选择需要操作的商品{/t}" data-name="checkboxes" href="javascript:;"><i class="fontello-icon-export"></i>{t domain="goods"}还原{/t}</a></li>
				<li><a data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url="{$form_action}&type=drop&page={$smarty.get.page}" data-msg="{t domain="goods" escape=no}彻底删除商品将删除与该商品有关的所有信息，<br/>您确定要删除选中的商品吗？{/t}" data-noselectmsg="{t domain="goods"}请选择需要操作的商品{/t}" data-name="checkboxes" href="javascript:;"><i class="fontello-icon-trash"></i>{t domain="goods"}删除{/t}</a></li>
			</ul>
		</div>
	</form>
	<form class="form-inline" action="{RC_Uri::url('goods/admin/trash')}{if $filter.type}&type={$filter.type}{/if}" method="post" class="f_r" name="searchForm">
		<div class="f_r">
			<div class="f_l m_r5">
				<select class="w180" name="cat_id">
					<option value="0">{t domain="goods"}所有分类{/t}</option>
					<!-- {foreach from=$cat_list item=cat} -->
					<option value="{$cat.cat_id}" {if $cat.cat_id eq $smarty.get.cat_id}selected{/if} {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<input type="text" class="w150" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{t domain="goods"}请输入商家关键字{/t}"/>
			<input type="text" class="w150" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain="goods"}请输入商品关键字{/t}"/>
			<button class="btn" type="submit">{t domain="goods"}搜索{/t}</button>
		</div>
	</form>
</div>
<div class="row-fluid list-page">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped smpl_tbl">
			<thead>
			<tr>
				<th class="table_checkbox">
					<input type="checkbox" data-toggle="selectall" data-children=".checkbox"/>
				</th>
				<th class="w50">
					{t domain="goods"}编号{/t}
				</th>
				<th class="w110">
					{t domain="goods"}商家名称{/t}
				</th>
				<th>
					{t domain="goods"}商品名称{/t}
				</th>
				<th class="w100">
					{t domain="goods"}货号{/t}
				</th>
				<th class="w100">
					{t domain="goods"}价格{/t}
				</th>
				<th class="w70">
					{t domain="goods"}操作{/t}
				</th>
			</tr>
			</thead>
			<tbody>
			<!-- {foreach from=$goods_list.goods item=goods} -->
			<tr>
				<td>
					<input class="checkbox" value="{$goods.goods_id}" name="checkboxes[]" type="checkbox"/>
				</td>
				<td>
					{$goods.goods_id}
				</td>
				<td class="ecjiafc-red">
					{$goods.merchants_name}
				</td>
				<td>
					{$goods.goods_name|escape:html}
				</td>
				<td>
					{$goods.goods_sn}
				</td>
				<td align="right">
					{$goods.shop_price}
				</td>
				<td align="center">
					<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg='{t domain="goods"}您确定要把该商品还原吗？{/t}' href='{RC_Uri::url("goods/admin/restore_goods", "id={$goods.goods_id}")}' title="{t domain="goods"}还原{/t}"><i class="fontello-icon-export"></i></a>
					<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg='{t domain="goods"}您确定要删除该商品吗？{/t}' href='{RC_Uri::url("goods/admin/drop_goods", "id={$goods.goods_id}")}' title="{t domain="goods"}删除{/t}"><i class="fontello-icon-trash"></i></a>
				</td>
			</tr>
			<!-- {foreachelse} -->
			<tr>
				<td class="no-records" colspan="7">
					{t domain="goods"}没有找到任何记录{/t}
				</td>
			</tr>
			<!-- {/foreach} -->
			</tbody>
			</table>
			<!-- {$goods_list.page} -->
		</div>
	</div>
</div>
<!-- {/block} -->