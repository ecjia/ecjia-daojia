<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.weapp.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{lang key='weapp::weapp.bulk_operation'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="weapp/admin/batch_remove"}'  data-msg="{lang key='weapp::weapp.sure_want_do'}" data-noSelectMsg="{lang key='weapp::weapp.delete_selected_plat'}" data-name="id" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='weapp::weapp.weapp_delete'}</a></li>
			</ul>
		</div>
		
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='weapp::weapp.input_weapp_name_key'}"/>
			<button class="btn search_wechat" type="submit">{lang key='weapp::weapp.search'}</button>
		</div>
	</form>
</div>

<div class="row-fluid list-page">
	<div class="span12">	
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
					<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
					<th class="w150">Logo</th>
					<th class="w250">小程序名称</th>
					<th class="w100">状态</th>
					<th class="w100">排序</th>
					<th class="w120">添加时间</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$weapp_list.item item=val} -->
				<tr class="big">
					<td>
						<span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.id}"/></span>
					</td>
					<td><img class="thumbnail" src="{$val.logo}"></td>
					<td class="hide-edit-area">
						{$val.name}
						<div class="edit-list">
					      	<a class="data-pjax" href='{RC_Uri::url("weapp/admin/edit", "id={$val.id}")}' title="{lang key='system::system.edit'}">{lang key='weapp::weapp.edit'}</a>	&nbsp;|&nbsp;
					     	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t}您确定要删除小程序[{$val.name}]吗？{/t}" href='{RC_Uri::url("weapp/admin/remove","id={$val.id}")}' title="{lang key='weapp::weapp.delete'}">{lang key='weapp::weapp.delete'}</a>
				     	</div>
					</td>
					<td>
				        <i class="{if $val.status eq 1}fontello-icon-ok{else}fontello-icon-cancel{/if} cursor_pointer" data-trigger="toggleState" data-url="{RC_Uri::url('weapp/admin/toggle_show')}" data-id="{$val.id}" ></i>
					</td>
					<td><span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('weapp/admin/edit_sort')}" data-name="sort" data-pk="{$val.id}"  data-title="{lang key='weapp::weapp.edit_weapp_sort'}">{$val.sort}</span></td>
					<td>{$val.add_time}</td>
				</tr>
				<!--  {foreachelse} -->
				<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$weapp_list.page} -->
	</div>
</div> 
<!-- {/block} -->