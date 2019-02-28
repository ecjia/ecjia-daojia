<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="mobile_config_parent.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.device_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_right_content"} -->

<!-- {if $platform_clients} -->
<ul class="nav nav-pills">
    <!-- {foreach $platform_clients as $client} -->
    {assign var="count_key" value="{$client.device_client}_count"}
    <li class="{if $client.device_client eq $current_client}active{/if}"><a class="data-pjax" href='{url path="mobile/admin_device/init" args="code={$client.platform}&app_id={$client.app_id}"}'>{$client.app_name}<span class="badge badge-info">{$device_list.msg_count.{$count_key}}</span></a></li>
    <!-- {/foreach} -->
</ul>
<!-- {/if} -->

<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{t domain="mobile"}批量操作{/t}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<!-- {if $device_list.filter.app_id eq '-1'} -->
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="mobile/admin_device/batch" args="code={$code}&app_id={$app_id}&sel_action=returndevice"}' data-msg='{t domain="mobile"}您确定要批量还原选中的设备吗？{/t}' data-noSelectMsg='{t domain="mobile"}请先选中要还原的设备！{/t}' data-name="id" href="javascript:;"><i class="fontello-icon-reply-all"></i>{t domain="mobile"}还原设备{/t}</a></li>
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="mobile/admin_device/batch" args="code={$code}&app_id={$app_id}&sel_action=del"}'  data-msg='{t domain="mobile"}您确定要批量删除选中的设备吗？{/t}' data-noSelectMsg='{t domain="mobile"}请先选中要删除的设备！{/t}' data-name="id" href="javascript:;"><i class="fontello-icon-trash"></i>{t domain="mobile"}永久删除{/t}</a></li>
				<!-- {else} -->
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="mobile/admin_device/batch" args="code={$code}&app_id={$app_id}&sel_action=trash"}'  data-msg='{t domain="mobile"}您确定要批量将选中的设备移至回收站吗？{/t}' data-noSelectMsg='{t domain="mobile"}请先选中要移至回收站的的设备！{/t}' data-name="id" href="javascript:;"><i class="fontello-icon-box"></i>{t domain="mobile"}移至回收站{/t}</a></li>
				<!-- {/if} -->
			</ul>
		</div>
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$device_list.filter.keywords}" placeholder='{t domain="mobile"}请输入设备名称关键字{/t}'/>
			<button class="btn search_device" type="button">{t domain="mobile"}搜索{/t}</button>
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
						<th class="w130">{t domain="mobile"}设备类型{/t}</th>
						<th>{t domain="mobile"}设备名称{/t}</th>
						<th class="w200">{t domain="mobile"}操作系统{/t}</th>
						<th class="w150">{t domain="mobile"}位置{/t}</th>
						<th class="w150">{t domain="mobile"}添加时间{/t}</th>
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
						{if $device_list.filter.app_id eq '-1'}
	     					<a class="toggle_view" data-msg='{t domain="mobile"}您确定要还原此设备吗？{/t}' href='{url path="mobile/admin_device/returndevice" args="id={$val.id}"}' data-pjax-url='{url path="mobile/admin_device/init" args="code={$code}&app_id={$app_id}"}' data-val="back">{t domain="mobile"}还原设备{/t}</a>&nbsp;|&nbsp;
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="mobile"}您确定要删除此设备吗？{/t}' href='{RC_Uri::url("mobile/admin_device/remove","code={$code}&app_id={$app_id}&id={$val.id}")}'>{t domain="mobile"}永久删除{/t}</a>
						{else}
							<a class="data-pjax" href='{RC_Uri::url("mobile/admin_device/preview", "code={$code}&app_id={$app_id}&id={$val.id}")}' >{t domain="mobile"}查看{/t}</a>&nbsp;|&nbsp;
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="mobile"}您确定要将此设备移至回收站吗？{/t}' href='{RC_Uri::url("mobile/admin_device/trash", "code={$code}&app_id={$app_id}&id={$val.id}")}' >{t domain="mobile"}移至回收站{/t}</a>
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
				<tr><td class="no-records" colspan="6">{t domain="mobile"}没有找到任何记录{/t}</td></tr>
				<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$device_list.page} -->
		</form>
	</div>
</div> 
<!-- {/block} -->