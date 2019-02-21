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
			<i class="fontello-icon-cog"></i>{t domain="goodslib"}批量操作{/t}<span class="caret"></span>
			</a>
			<ul class="dropdown-menu batch-move">
				<li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url='{RC_Uri::url("goodslib/admin_attribute/batch", "cat_id={$cat_id}")}' data-msg="{t domain="goodslib"}您确定要删除选中的商品属性吗？{/t}" data-noselectmsg="{t domain="goodslib"}您没有选择需要删除的属性{/t}" href="javascript:;"><i class="fontello-icon-trash"></i>{t domain="goodslib"}批量删除{/t}</a></li>
			</ul>
		</div>
	</form>
	<div class="choose_list f_r">
		<span>{t domain="goodslib"}按商品规格显示：{/t}</span>
		<select name="goods_type" data-url="{url path='goodslib/admin_attribute/init' args='cat_id='}">
			<option value="0">{t domain="goodslib"}所有商品规格{/t}</option>
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
						{t domain="goodslib"}属性名称{/t}
					</th>
					<th class="w100">
						{t domain="goodslib"}商品规格{/t}
					</th>
					<th class="w150">
						{t domain="goodslib"}属性值的录入方式{/t}
					</th>
					<th>
						{t domain="goodslib"}可选值列表{/t}
					</th>
					<th class="w50">
						{t domain="goodslib"}排序{/t}
					</th>
					<th class="w70">
						{t domain="goodslib"}操作{/t}
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
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goodslib/admin_attribute/edit_attr_name')}" data-name="edit_attr_name" data-pk="{$attr.attr_id}" data-title="{t domain="goodslib"}属性名称不能为空{/t}">
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
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goodslib/admin_attribute/edit_sort_order')}" data-name="edit_sort_order" data-pjax-url='{url path="goodslib/admin_attribute/init" args="cat_id={$smarty.get.cat_id}"}' data-pk="{$attr.attr_id}" data-title="{t domain="goodslib"}请输入排序号{/t}">{$attr.sort_order}</span>
					</td>
					<td align="center" nowrap="true" valign="top">
						<a class="data-pjax" href='{RC_Uri::url("goodslib/admin_attribute/edit", "attr_id={$attr.attr_id}")}' title="{t domain="goodslib"}编辑{/t}"><i class="fontello-icon-edit"></i></a>
						<a class="ajaxremove" data-toggle="ajaxremove" data-msg="{t domain="goodslib"}您确实要删除该属性吗？{/t}" href='{RC_Uri::url("goodslib/admin_attribute/remove", "id={$attr.attr_id}")}' title="{t domain="goodslib"}删除{/t}"><i class="fontello-icon-trash"></i></a>
					</td>
				</tr>
				<!-- {foreachelse} -->
				<tr>
					<td class="no-records" colspan="7">{t domain="goodslib"}没有找到任何记录{/t}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$attr_list.page} -->
	</div>
</div>
<!-- {/block} -->