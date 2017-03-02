<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.platform.init();
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
				<i class="fontello-icon-cog"></i>{lang key='platform::platform.bulk_operation'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="platform/admin/batch_remove"}'  data-msg="{lang key='platform::platform.sure_want_do'}" data-noSelectMsg="{lang key='platform::platform.delete_selected_plat'}" data-name="id" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='platform::platform.platform_del'}</a></li>
			</ul>
		</div>
		
		<select class="w150" name="platform" id="select_type">
			<option value=''  		{if $smarty.get.platform eq ''}			selected="true"{/if}>{lang key='platform::platform.all_platform'}</option>
			<option value='wechat' 	{if $smarty.get.platform eq 'wechat'}	selected="true"{/if}>{lang key='platform::platform.weixin'}</option>
		</select>
		<a class="btn m_l5 screen-btn">{lang key='platform::platform.filtrate'}</a>
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='platform::platform.input_plat_name_key'}"/>
			<button class="btn search_wechat" type="submit">{lang key='platform::platform.search'}</button>
		</div>
	</form>
</div>

<div class="row-fluid list-page">
	<div class="row-fluid">	
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
					<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
					<th class="w150">{lang key='platform::platform.logo'}</th>
					<th class="w250">{lang key='platform::platform.platform_name'}</th>
					<th class="w150">{lang key='platform::platform.terrace'}</th>
					<th class="w150">{lang key='platform::platform.platform_num_type'}</th>
					<th class="w100">{lang key='platform::platform.status'}</th>
					<th class="w100">{lang key='platform::platform.sort'}</th>
					<th class="w200">{lang key='platform::platform.add_time'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$wechat_list.item item=val} -->
				<tr class="big">
					<td>
						<span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.id}"/></span>
					</td>
					<td><img class="thumbnail" src="{$val.logo}"></td>
					<td class="hide-edit-area">
						{$val.name}<br>
						{$val.uuid}
						<div class="edit-list">
							<a class="data-pjax" href='{RC_Uri::url("platform/admin/wechat_extend","id={$val.id}")}' title="{lang key='platform::platform.function_extend'}">{lang key='platform::platform.function_extend'}</a>&nbsp;|&nbsp;
					      	<a class="data-pjax" href='{RC_Uri::url("platform/admin/edit", "id={$val.id}")}' title="{lang key='system::system.edit'}">{lang key='platform::platform.edit'}</a>	&nbsp;|&nbsp;
					     	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t}您确定要删除公众号[{$val.name}]吗？{/t}" href='{RC_Uri::url("platform/admin/remove","id={$val.id}")}' title="{lang key='platform::platform.delete'}">{lang key='platform::platform.delete'}</a>
				     	</div>
					</td>
					<td>
						{if $val.platform eq 'wechat'}
							{lang key='platform::platform.weixin'}
						{/if}
					</td>
					<td>
						{if $val.type eq 0}
							{lang key='platform::platform.un_platform_num'}
						{elseif $val.type eq 1}
							{lang key='platform::platform.subscription_num'}
						{elseif $val.type eq 2}
							{lang key='platform::platform.server_num'}
						{elseif $val.type eq 3}
							{lang key='platform::platform.test_account'}
						{/if}
					</td>
					<td>
				        <i class="{if $val.status eq 1}fontello-icon-ok{else}fontello-icon-cancel{/if} cursor_pointer" data-trigger="toggleState" data-url="{RC_Uri::url('platform/admin/toggle_show')}" data-id="{$val.id}" ></i>
					</td>
					<td><span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('platform/admin/edit_sort')}" data-name="sort" data-pk="{$val.id}"  data-title="{lang key='platform::platform.edit_plat_sort'}">{$val.sort}</span></td>
					<td>{$val.add_time}</td>
				</tr>
				<!--  {foreachelse} -->
				<tr><td class="no-records" colspan="8">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$wechat_list.page} -->
	</div>
</div> 
<!-- {/block} -->