<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.device_list.init();
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

<!-- <div class="row-fluid"> -->
	<!-- <div class="choose_list span12">  -->
	<ul class="nav nav-pills">
		<li class="{if $device_list.filter.deviceval eq '0'}active{/if}"><a class="data-pjax" href='{url path="mobile/admin_device/init" args="deviceval=0"}'>{lang key='mobile::mobile.all'}<span class="badge badge-info">{$device_list.msg_count.count}</span></a></li>
		<li class="{if $device_list.filter.deviceval eq '1'}active{/if}"><a class="data-pjax" href='{url path="mobile/admin_device/init" args="deviceval=1"}'>{lang key='mobile::mobile.android'}<span class="badge badge-info">{$device_list.msg_count.android}</span></a></li>
		<li class="{if $device_list.filter.deviceval eq '2'}active{/if}"><a class="data-pjax" href='{url path="mobile/admin_device/init" args="deviceval=2"}'>{lang key='mobile::mobile.iphone'}<span class="badge badge-info">{$device_list.msg_count.iphone}</span></a></li>
		<li class="{if $device_list.filter.deviceval eq '3'}active{/if}"><a class="data-pjax" href='{url path="mobile/admin_device/init" args="deviceval=3"}'>{lang key='mobile::mobile.ipad'}<span class="badge badge-info">{$device_list.msg_count.ipad}</span></a></li>
		<li class="{if $device_list.filter.deviceval eq '4'}active{/if}"><a class="data-pjax" href='{url path="mobile/admin_device/init" args="deviceval=4"}'>{lang key='mobile::mobile.cashdesk'}<span class="badge badge-info">{$device_list.msg_count.cashier}</span></a></li>
		<li class="{if $device_list.filter.deviceval eq '5'}active{/if}"><a class="data-pjax" href='{url path="mobile/admin_device/init" args="deviceval=5"}'>{lang key='mobile::mobile.recycle_bin'}<span class="badge badge-info">{$device_list.msg_count.trashed}</span></a></li>
	</ul>
	<!-- </div> -->
<!-- </div> -->

<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}&deviceval={$device_list.filter.deviceval}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{lang key='mobile::mobile.batch_handle'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<!-- {if $device_list.filter.deviceval eq '5'} -->
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="mobile/admin_device/batch" args="&sel_action=returndevice&deviceval={$device_list.filter.deviceval}"}' data-msg="{lang key='mobile::mobile.batch_restore_confirm'}" data-noSelectMsg="{lang key='mobile::mobile.select_restore_device'}" data-name="id" href="javascript:;"><i class="fontello-icon-reply-all"></i>{lang key='mobile::mobile.restore_device'}</a></li>
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="mobile/admin_device/batch" args="&sel_action=del&deviceval={$device_list.filter.deviceval}"}'  data-msg="{lang key='mobile::mobile.batch_remove_confirm'}" data-noSelectMsg="{lang key='mobile::mobile.select_remove_device'}" data-name="id" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='mobile::mobile.delete_forever'}</a></li>
				<!-- {else} -->
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="mobile/admin_device/batch" args="&sel_action=trash&deviceval={$device_list.filter.deviceval}"}'  data-msg="{lang key='mobile::mobile.batch_trash_confirm'}" data-noSelectMsg="{lang key='mobile::mobile.select_trash_device'}" data-name="id" href="javascript:;"><i class="fontello-icon-box"></i>{lang key='mobile::mobile.move_to_recyclebin'}</a></li>
				<!-- {/if} -->
			</ul>
		</div>
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$device_list.filter.keywords}" placeholder="{lang key='mobile::mobile.device_name_keywords_empty'}"/>
			<button class="btn search_device" type="button">{lang key='mobile::mobile.search'}</button>
		</div>
	</form>
</div>

<div class="row-fluid list-page">
	<div class="span12">	
		<form method="POST" action="{$form_action}" name="listForm">
			<table class="table table-striped smpl_tbl table-hide-edit">
				<thead>
					<tr>
						<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
						<th class="w130">{lang key='mobile::mobile.device_type'}</th>
						<th>{lang key='mobile::mobile.device_name'}</th>
						<th class="w200">{lang key='mobile::mobile.device_os'}</th>
						<th class="w150">{lang key='mobile::mobile.location'}</th>
						<th class="w150">{lang key='mobile::mobile.add_time'}</th>
					</tr>
				</thead>
				<tbody>
				<!-- {foreach from=$device_list.device_list item=val} -->
				<tr>
					<td>
						<span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.id}"/></span>
					</td>
					<td class="hide-edit-area">
						{$val.device_client}
						<div class="edit-list">
						{if $device_list.filter.deviceval eq '5'}
     					<a class="toggle_view" data-msg="{lang key='mobile::mobile.restore_decice_confirm'}" href='{url path="mobile/admin_device/returndevice" args="id={$val.id}"}' data-pjax-url='{url path="mobile/admin_device/init" args="deviceval={$device_list.filter.deviceval}"}' data-val="back">{lang key='mobile::mobile.restore_device'}</a>&nbsp;|&nbsp;
						<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='mobile::mobile.remove_decice_confirm'}" href='{RC_Uri::url("mobile/admin_device/remove","id={$val.id}&deviceval={$device_list.filter.deviceval}")}'>{lang key='mobile::mobile.delete_forever'}</a>
						{else}
						<a class="data-pjax" href='{RC_Uri::url("mobile/admin_device/preview", "id={$val.id}")}' title="{lang key='system::system.view'}">{lang key='system::system.view'}</a>&nbsp;|&nbsp;
						<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='mobile::mobile.trash_decice_confirm'}" href='{RC_Uri::url("mobile/admin_device/trash", "id={$val.id}&deviceval={$device_list.filter.deviceval}")}' title="{lang key='mobile::mobile.move_to_recyclebin'}">{lang key='mobile::mobile.move_to_recyclebin'}</a>
						{/if}
						</div>
					</td>
					<td>
						<!-- {if $val.device_name && $val.device_udid} -->
						{$val.device_name}<br>{$val.device_udid}
						<!-- {elseif $val.device_name} -->
						{$val.device_name}
						<!-- {elseif $val.device_udid} -->
						{$val.device_udid}
						<!-- {/if} -->
					</td>
					<td><!-- {if $val.device_type} -->{$val.device_type}（{$val.device_os}）<!-- {/if} --></td>
					<td>{$val.location_province}/{$val.location_city}</td>
					<td>{$val.add_time}</td>
				</tr>
				<!--  {foreachelse} -->
				<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$device_list.page} -->
		</form>
	</div>
</div> 
<!-- {/block} -->