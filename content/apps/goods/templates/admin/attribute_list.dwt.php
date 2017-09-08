<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_arrt.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn plus_or_reply data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
	<!-- {/if} -->
	<!-- {if $action_link2} -->
	<a href="{$action_link2.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link2.text}</a>
	<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid batch">
	<form class="f_l" action="" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fontello-icon-cog"></i>{lang key='goods::attribute.batch_operation'}<span class="caret"></span>
			</a>
			<ul class="dropdown-menu batch-move">
				<li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url='{RC_Uri::url("goods/admin_attribute/batch", "cat_id={$cat_id}")}' data-msg="{lang key='goods::attribute.drop_select_confirm'}" data-noselectmsg="{lang key='goods::attribute.no_select_arrt'}" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='goods::attribute.batchdrop'}</a></li>
			</ul>
		</div>
	</form>
	<div class="choose_list f_r">
		<span>{lang key='goods::attribute.by_goods_type'}</span>
		<select name="goods_type" data-url="{url path='goods/admin_attribute/init' args='cat_id='}">
			<option value="0">{lang key='goods::attribute.all_goods_type'}</option>
			<!-- {$goods_type_list} -->
		</select>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl">
			<thead>
				<tr>
					<th class="table_checkbox">
						<input type="checkbox" data-toggle="selectall" data-children=".checkbox" autocomplete="off"/>
					</th>
					<th class="w130">
						{lang key='goods::attribute.attr_name'}
					</th>
					<th class="w100">
						{lang key='goods::attribute.cat_id'}
					</th>
					<th class="w150">
						{lang key='goods::attribute.attr_input_type'}
					</th>
					<th>
						{lang key='goods::attribute.attr_values'}
					</th>
					<th class="w50">
						{lang key='system::system.sort_order'}
					</th>
					<th class="w70">
						{lang key='system::system.handler'}
					</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$attr_list.item item=attr} -->
				<tr>
					<td nowrap="true" valign="top">
						<input class="checkbox" value="{$attr.attr_id}" name="checkboxes[]" type="checkbox" autocomplete="off"/>
					</td>
					<td class="first-cell" nowrap="true" valign="top">
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin_attribute/edit_attr_name')}" data-name="edit_attr_name" data-pk="{$attr.attr_id}" data-title="{lang key='goods::attribute.name_not_null'}"> 
							{$attr.attr_name}
						</span>
					</td>
					<td nowrap="true" valign="top">
						<span>{$attr.cat_name}</span>
					</td>
					<td nowrap="true" valign="top">
						<span>{$attr.attr_input_type_desc}</span>
					</td>
					<td valign="top">
						<span>{$attr.attr_values}</span>
					</td>
					<td align="right" nowrap="true" valign="top">
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin_attribute/edit_sort_order')}" data-name="edit_sort_order" data-pjax-url='{url path="goods/admin_attribute/init" args="cat_id={$smarty.get.cat_id}"}' data-pk="{$attr.attr_id}" data-title="{lang key='goods::attribute.order_not_null'}">{$attr.sort_order}</span>
					</td>
					<td align="center" nowrap="true" valign="top">
						<a class="data-pjax" href='{RC_Uri::url("goods/admin_attribute/edit", "cat_id={$cat_id}&attr_id={$attr.attr_id}")}' title="{lang key='system::system.edit'}"><i class="fontello-icon-edit"></i></a>
						<a class="ajaxremove" data-toggle="ajaxremove" data-msg="{lang key='goods::attribute.drop_confirm'}" href='{RC_Uri::url("goods/admin_attribute/remove", "id={$attr.attr_id}")}' title="{lang key='system::system.remove'}"><i class="fontello-icon-trash"></i></a>
					</td>
				</tr>
				<!-- {foreachelse} -->
				<tr>
					<td class="no-records" colspan="7">{lang key='system::system.no_records'}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$attr_list.page} -->
	</div>
</div>
<!-- {/block} -->