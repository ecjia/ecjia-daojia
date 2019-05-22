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
	{t domain="quickpay"}商品参数：对商品中不能体现的功能、特性等信息进行补充说明，其目的就是让买家详细了解某款商品。{/t}
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
				<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain='goods'}请输入参数模板名称{/t}"/>
				<button class="btn" type="submit">{t domain="goods"}搜索{/t}</button>
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
					<th class="w150">{t domain="goods"}模板名称{/t}</th>
					<th>{t domain="goods"}参数分组{/t}</th>
					<th class="w130">{t domain="goods"}参数统计{/t}</th>
					<th class="w130">{t domain="goods"}商品数量{/t}</th>
					<th class="w80">{t domain="goods"}状态{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$parameter_template_list.item item=list} -->
				<tr>
					<td class="hide-edit-area">
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin_parameter/edit_type_name')}" data-name="edit_type_name" data-pk="{$list.cat_id}" data-title="{t domain='goods'}请输入参数模板名称{/t}">{$list.cat_name}</span>
						<div class="edit-list">
							<a class="data-pjax" href='{url path="goods/admin_parameter_attribute/init" args="cat_id={$list.cat_id}"}' title="{t domain='goods'}查看参数值{/t}">{t domain="goods"}查看参数值{/t}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goods/admin_parameter/edit" args="cat_id={$list.cat_id}"}' title="{t domain='goods'}编辑{/t}">{t domain="goods"}编辑{/t}</a>&nbsp;|&nbsp;
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t domain='goods' escape=no}删除商品库参数模板将会清除该模板下的所有参数，您确定要删除选定的商品参数模板吗？{/t}" href='{url path="goods/admin_parameter/remove" args="id={$list.cat_id}"}' title="{t domain='goods'}删除{/t}">{t domain="goods"}删除{/t}</a>
						</div>
					</td>
					<td>{$list.attr_group}</td>
					<td>{$list.attr_count}</td>
					<td>0</td>
					<td>
						<i class="{if $list.enabled}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" title="{t domain='goods'}点击修改状态{/t}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/admin_parameter/toggle_enabled')}" data-id="{$list.cat_id}"></i>
					</td>
				</tr>
				<!-- {foreachelse} -->
				<tr>
					<td class="no-records" colspan="5">
						{t domain="goods"}没有找到任何记录{/t}
					</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$parameter_template_list.page} -->
	</div>
</div>
<!-- {/block} -->