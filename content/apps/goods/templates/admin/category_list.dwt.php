<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn plus_or_reply data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
	<!-- {/if} -->
	<!-- {if $exchange_link} -->
	<a class="btn plus_or_reply data-pjax" id="sticky_a" href="{$exchange_link.href}"><i class="fontello-icon-exchange"></i>{$exchange_link.text}</a>
	<!-- {/if} -->
	<!-- {if $back_link} -->
	<a class="btn plus_or_reply data-pjax" id="sticky_a" href="{$back_link.href}"><i class="fontello-icon-reply"></i>{$back_link.text}</a>
	<!-- {/if} -->
	</h3>
</div>
<!-- start ad position list -->
<div class="row-fluid">
	<table class="table table-striped" id="list-table">
		<thead>
			<tr>
				<th>
					{t domain="goods"}分类名称{/t}
				</th>
				<th class="w100">
					{t domain="goods"}商品数量{/t}
				</th>
				<th class="w100">
					{t domain="goods"}数量单位{/t}
				</th>
				<th class="w100">
					{t domain="goods"}价格分级{/t}
				</th>
				<th class="w50">
					{t domain="goods"}排序{/t}
				</th>
				<th class="w100">
					{t domain="goods"}是否显示{/t}
				</th>
				<th class="w80">
					{t domain="goods"}操作{/t}
				</th>
			</tr>
		</thead>
		<!-- {foreach from=$cat_list item=cat} -->
		<tr class="{$cat.level}" id="{$cat.level}_{$cat.cat_id}">
			{if $cat.parent_id eq $cat_id}
			<td class="first-cell" align="left">
				<!-- {if $cat.is_leaf neq 1} -->
				<i class="fontello-icon-minus-squared-alt cursor_pointer ecjiafc-blue" id="icon_{$cat.level}_{$cat.cat_id}" /></i>
				<!-- {else} -->
				<i class="fontello-icon-angle-circled-right cursor_pointer ecjiafc-blue" /></i>
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
				<span {if $cat.measure_unit}class="cursor_pointer" data-trigger="editable" data-url="{url path='goods/admin_category/edit_measure_unit'}" data-name="edit_grade" data-pk="{$cat.cat_id}" data-title="{t domain="goods"}请输入数量单位{/t}"{/if}>
				<!-- {if $cat.measure_unit}{$cat.measure_unit}{else}&nbsp;&nbsp;&nbsp;&nbsp;{/if} -->
				</span>
			</td>
			<td>
				<span class="cursor_pointer" data-trigger="editable" data-url="{url path='goods/admin_category/edit_grade'}" data-name="edit_grade" data-pk="{$cat.cat_id}" data-title="{t domain="goods"}请输入价格分级{/t}">
				<!-- {$cat.grade} -->
				</span>
			</td>
			<td>
				<span class="cursor_pointer" data-trigger="editable" data-url="{url path='goods/admin_category/edit_sort_order'}" data-name="sort_order" data-pk="{$cat.cat_id}" data-title="{t domain="goods"}请输入排序序号{/t}">
				<!-- {$cat.sort_order} -->
				</span>
			</td>
			<td>
				<i class="{if $cat.is_show eq '1'}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{url path='goods/admin_category/toggle_is_show'}" data-id="{$cat.cat_id}"></i>
			</td>
			<td>
				<a class="data-pjax no-underline" title="{t domain="goods"}进入{/t}" href="{url path='goods/admin_category/init' args="cat_id={$cat.cat_id}"}"><i class="fontello-icon-login"></i></a>
				<a class="data-pjax no-underline" href='{url path="goods/admin_category/edit" args="cat_id={$cat.cat_id}"}' title="{t domain="goods"}编辑{/t}"><i class="fontello-icon-edit"></i></a>
				<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{t domain="goods"}您确定要删除该分类吗？{/t}" href='{url path="goods/admin_category/remove" args="id={$cat.cat_id}"}' {t domain="goods"}删除{/t}><i class="fontello-icon-trash"></i></a>
			</td>
			{/if}
		</tr>
		<!-- {foreachelse}-->
		<tr>
			<td class="no-records" colspan="7">{t domain="goods"}没有找到任何记录{/t}</td>
		</tr>
		<!-- {/foreach} -->
	</table>
</div>
<!-- {/block} -->