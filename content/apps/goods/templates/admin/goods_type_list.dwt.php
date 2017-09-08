<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_type.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
	<!-- {/if} -->
	</h3>
</div>
<ul class="nav nav-pills">
	<li class="{if $filter.type eq ''}active{/if}"><a class="data-pjax" href='{url path="goods/admin_goods_spec/init" args="{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{lang key='goods::goods_spec.all'} <span class="badge badge-info">{$filter.count}</span></a></li>
	<li class="{if $filter.type eq 'self'}active{/if}"><a class="data-pjax" href='{url path="goods/admin_goods_spec/init" args="type=self{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{lang key='goods::goods_spec.self'}<span class="badge badge-info">{$filter.self}</span></a></li>
	<li class="ecjiaf-fn">
	<form name="searchForm" method="post" action="{$form_search}{if $filter.type}&type={$filter.type}{/if}">
		<div class="f_r form-inline">
			<input type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{lang key='goods::goods_spec.merchant_keywords'}"/>
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='goods::goods_spec.goods_type_keywords'}"/>
			<button class="btn" type="submit">{lang key='goods::goods_spec.search'}</button>
		</div>
	</form>
	</li>
</ul>
<!-- 商品编辑属性 -->
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped dataTable table-hide-edit">
			<thead>
				<tr>
					<th class="w150">
						{lang key='goods::goods_spec.goods_type_name'}
					</th>
					<th class="w130">
						{lang key='goods::goods_spec.merchants_name'}
					</th>
					<th>
						{lang key='goods::goods_spec.attr_groups'}
					</th>
					<th class="w130">
						{lang key='goods::goods_spec.attribute_number'}
					</th>
					<th class="w80">
						{lang key='goods::goods_spec.goods_type_status'}
					</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$goods_type_list.item item=goods_type} -->
				<tr>
					<td class="hide-edit-area">
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin_goods_spec/edit_type_name')}" data-name="edit_type_name" data-pk="{$goods_type.cat_id}" data-title="{lang key='goods::goods_spec.enter_type_name'}"><!-- {$goods_type.cat_name} --></span>
						<div class="edit-list">
							<a class="data-pjax" href='{url path="goods/admin_attribute/init" args="cat_id={$goods_type.cat_id}"}' title="{lang key='goods::goods_spec.view_type_attr'}">{lang key='goods::goods_spec.view_type_attr'}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goods/admin_goods_spec/edit" args="cat_id={$goods_type.cat_id}"}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='goods::goods_spec.remove_confirm'}" href='{url path="goods/admin_goods_spec/remove" args="id={$goods_type.cat_id}"}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
						</div>
					</td>
					<td class="ecjiafc-red">
						{$goods_type.merchants_name}
					</td>
					<td>
						{$goods_type.attr_group}
					</td>
					<td>
						{$goods_type.attr_count}
					</td>
					<td>
						<i class="{if $goods_type.enabled}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" title="{lang key='goods::goods_spec.click_edit_stats'}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/admin_goods_spec/toggle_enabled')}" data-id="{$goods_type.cat_id}"></i>
					</td>
				</tr>
				<!-- {foreachelse} -->
				<tr>
					<td class="no-records" colspan="5">
						{lang key='system::system.no_records'}
					</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$goods_type_list.page} -->
	</div>
</div>
<!-- {/block} -->