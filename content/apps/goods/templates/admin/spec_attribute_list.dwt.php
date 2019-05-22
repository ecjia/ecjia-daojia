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
	<!-- {if $ur_here}{$ur_here}{/if} --><small>（当前模板：{$cat_name}）</small>
	<!-- {if $action_link} -->
	<a class="btn plus_or_reply data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
	<!-- {/if} -->
	<!-- {if $action_link2} -->
	<a href="{$action_link2.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link2.text}</a>
	<!-- {/if} -->
	</h3>
</div>

<div class="modal hide fade" id="myModal1"></div>

<div class="row-fluid batch">
	<form class="f_l" action="" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fontello-icon-cog"></i>{t domain='goods'}批量操作{/t}<span class="caret"></span>
			</a>
			<ul class="dropdown-menu batch-move">
				<li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idclass=".checkbox:checked" data-url='{RC_Uri::url("goods/admin_spec_attribute/batch", "cat_id={$cat_id}")}' data-msg="{t domain='goods'}您确定要删除选中的商品规格属性吗？{/t}" data-noselectmsg="{t domain='goods'}请选择将要删除的商品规格属性{/t}" href="javascript:;"><i class="fontello-icon-trash"></i>{t domain='goods'}批量删除{/t}</a></li>
			</ul>
		</div>
	</form>
	<div class="choose_list f_r">
		<span>{t domain='goods'}按模板名称快速切换：{/t}</span>
		<select name="goods_type" data-url="{url path='goods/admin_spec_attribute/init' args='cat_id='}">
			{$goods_type_list}
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
					<th class="w150">{t domain='goods'}属性名称{/t}</th>
					<th class="w150">{t domain='goods'}所属规格模板{/t}</th>
					<th>{t domain='goods'}可选值列表{/t}</th>
					<th class="w100">{t domain='goods'}排序{/t}</th>
					<th class="w150">{t domain='goods'}操作{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$attr_list.item item=attr} -->
				<tr>
					<td nowrap="true" valign="top">
						<input class="checkbox" value="{$attr.attr_id}" name="checkboxes[]" type="checkbox" autocomplete="off"/>
					</td>
					<td class="first-cell" nowrap="true" valign="top">
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin_spec_attribute/edit_attr_name')}" data-name="edit_attr_name" data-pk="{$attr.attr_id}" data-title="{t domain='goods'}属性名称不能为空{/t}">
							{$attr.attr_name}
						</span>
					</td>
					<td nowrap="true" valign="top">
						<span>{$attr.cat_name}</span>
					</td>
					<td valign="top">
						<span>{$attr.attr_values}</span>
					</td>
					<td align="right" nowrap="true" valign="top">
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin_spec_attribute/edit_sort_order')}" data-name="edit_sort_order" data-pjax-url='{url path="goods/admin_spec_attribute/init" args="cat_id={$smarty.get.cat_id}"}' data-pk="{$attr.attr_id}" data-title="{t domain='goods'}请输入排序号{/t}">{$attr.sort_order}</span>
					</td>
					<td align="center" nowrap="true" valign="top">
						<a class="data-pjax" href='{RC_Uri::url("goods/admin_spec_attribute/edit", "attr_id={$attr.attr_id}")}' title="{t domain='goods'}编辑{/t}"><i class="fontello-icon-edit"></i></a>
						<a class="ajaxremove" data-toggle="ajaxremove" data-msg="{t domain='goods'}您确实要删除该属性吗？{/t}" href='{RC_Uri::url("goods/admin_spec_attribute/remove", "id={$attr.attr_id}")}' title="{t domain='goods'}删除{/t}"><i class="fontello-icon-trash"></i></a>
						{if $attr.attr_cat_type}
							<a data-toggle="modal" data-backdrop="static" href="#myModal1" attr-id="{$attr.attr_id}" attr-url="{RC_Uri::url('goods/admin_spec_attribute/set_color_values')}"  title='{t domain="goods"}设置色值{/t}'><i class="fontello-icon-font"></i></a>
						{/if}
					</td>
				</tr>
				<!-- {foreachelse} -->
				<tr>
					<td class="no-records" colspan="6">{t domain='goods'}没有找到任何记录{/t}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$attr_list.page} -->
	</div>
</div>
<!-- {/block} -->