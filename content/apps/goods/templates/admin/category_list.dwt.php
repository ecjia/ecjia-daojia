<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn plus_or_reply data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
	<!-- {/if} -->
	<!-- {if $action_link1} -->
	<a class="btn plus_or_reply data-pjax" id="sticky_a" href="{$action_link1.href}"><i class="fontello-icon-exchange"></i>{$action_link1.text}</a>
	<!-- {/if} -->
	</h3>
</div>
<!-- start ad position list -->
<div class="row-fluid">
	<table class="table table-striped" id="list-table">
		<thead>
			<tr>
				<th>
					{lang key='goods::category.cat_name'}
				</th>
				<th class="w100">
					{lang key='goods::category.goods_number'}
				</th>
				<th class="w100">
					{lang key='goods::category.measure_unit'}
				</th>
				<th class="w100">
					{lang key='goods::category.short_grade'}
				</th>
				<th class="w50">
					{lang key='goods::category.sort_order'}
				</th>
				<th class="w100">
					{lang key='goods::category.is_show'}
				</th>
				<th class="w80">
					{lang key='system::system.handler'}
				</th>
			</tr>
		</thead>
		<!-- {foreach from=$cat_info item=cat} -->
		<tr class="{$cat.level}" id="{$cat.level}_{$cat.cat_id}">
			<td class="first-cell" align="left">
				<!-- {if $cat.is_leaf neq 1} -->
				<i class="fontello-icon-minus-squared-alt cursor_pointer ecjiafc-blue" id="icon_{$cat.level}_{$cat.cat_id}" style="margin-left:{$cat.level}em" onclick="rowClicked(this)"/></i>
				<!-- {else} -->
				<i class="fontello-icon-angle-circled-right cursor_pointer ecjiafc-blue" style="margin-left:{$cat.level}em"/></i>
				<!-- {/if} -->
				<span><a href='{url path="goods/admin/init" args="cat_id={$cat.cat_id}"}'>{$cat.cat_name}</a></span>
				<!-- {if $cat.cat_image} -->
				<img src="../{$cat.cat_image}" border="0" style="vertical-align:middle;" width="60px" height="21px">
				<!-- {/if} -->
			</td>
			<td>
				{$cat.goods_num}
			</td>
			<td>
				<span {if $cat.measure_unit}class="cursor_pointer" data-trigger="editable" data-url="{url path='goods/admin_category/edit_measure_unit'}" data-name="edit_grade" data-pk="{$cat.cat_id}" data-title="{lang key='goods::category.enter_number'}"{/if}>
				<!-- {if $cat.measure_unit}{$cat.measure_unit}{else}&nbsp;&nbsp;&nbsp;&nbsp;{/if} -->
				</span>
			</td>
			<td>
				<span class="cursor_pointer" data-trigger="editable" data-url="{url path='goods/admin_category/edit_grade'}" data-name="edit_grade" data-pk="{$cat.cat_id}" data-title="{lang key='goods::category.enter_grade'}">
				<!-- {$cat.grade} -->
				</span>
			</td>
			<td>
				<span class="cursor_pointer" data-trigger="editable" data-url="{url path='goods/admin_category/edit_sort_order'}" data-name="sort_order" data-pk="{$cat.cat_id}" data-title="{lang key='goods::category.enter_order'}">
				<!-- {$cat.sort_order} -->
				</span>
			</td>
			<td>
				<i class="{if $cat.is_show eq '1'}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{url path='goods/admin_category/toggle_is_show'}" data-id="{$cat.cat_id}"></i>
			</td>
			<td>
				<a class="data-pjax no-underline" href='{url path="goods/admin_category/edit" args="cat_id={$cat.cat_id}"}' title="{lang key='system::system.edit'}"><i class="fontello-icon-edit"></i></a>
				<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='goods::category.drop_cat_confirm'}" href='{url path="goods/admin_category/remove" args="id={$cat.cat_id}"}' {lang key='system::system.remove'}><i class="fontello-icon-trash"></i></a>
			</td>
		</tr>
		<!-- {foreachelse}-->
		<tr>
			<td class="no-records" colspan="7">{lang key='system::system.no_records'}</td>
		</tr>
		<!-- {/foreach} -->
	</table>
</div>
<!-- {/block} -->