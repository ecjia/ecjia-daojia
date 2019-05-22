<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_type.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	{t domain="quickpay"}商品规格：指商品的销售属性，供买家在下单时点选，如“规格”、“颜色分类”、“尺码”等设置，它将影响买家的购买和店铺商品的库存管理。{/t}
</div>

<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
	<!-- {/if} -->
	</h3>
</div>
<ul class="nav nav-pills">
	<li class="ecjiaf-fn">
		<form name="searchForm" method="post" action="{$form_search}{if $filter.type}&type={$filter.type}{/if}">
			<div class="f_r form-inline">
				<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain='goods'}请输入规格模板名称{/t}"/>
				<button class="btn" type="submit">{t domain='goods'}搜索{/t}</button>
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
					<th class="w150">{t domain='goods'}模板名称{/t}</th>
					<th class="w130">{t domain='goods'}属性统计{/t}</th>
					<th class="w130">{t domain='goods'}商品数量{/t}</th>
					<th class="w80">{t domain='goods'}状态{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$spec_template_list.item item=list} -->
				<tr>
					<td class="hide-edit-area">
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin_spec/edit_type_name')}" data-name="edit_type_name" data-pk="{$list.cat_id}" data-title="{t domain='goods'}请输入规格名称{/t}"><!-- {$list.cat_name} --></span>
						<div class="edit-list">
							<a class="data-pjax" href='{url path="goods/admin_spec_attribute/init" args="cat_id={$list.cat_id}"}' title="{t domain='goods'}查看规格属性{/t}">{t domain='goods'}查看规格属性{/t}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goods/admin_spec/edit" args="cat_id={$list.cat_id}"}' title="{t domain='goods'}编辑{/t}">{t domain='goods'}编辑{/t}</a>&nbsp;|&nbsp;
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t domain='goods' escape=no}删除商品库规格模板将会清除该模板下的所有属性，您确定要删除选定的商品规格模板吗？{/t}" href='{url path="goods/admin_spec/remove" args="id={$list.cat_id}"}' title="{t domain='goods'}删除{/t}">{t domain='goods'}删除{/t}</a>
						</div>
					</td>
					<td>{$list.attr_count}</td>
					<td>0</td>
					<td>
						<i class="{if $list.enabled}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" title="{t domain='goods'}点击修改状态{/t}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/admin_spec/toggle_enabled')}" data-id="{$list.cat_id}"></i>
					</td>
				</tr>
				<!-- {foreachelse} -->
				<tr>
					<td class="no-records" colspan="4">
						{t domain='goods'}没有找到任何记录{/t}
					</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$spec_template_list.page} -->
	</div>
</div>
<!-- {/block} -->