<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.push_list.init();
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

<ul class="nav nav-pills">
<!-- {foreach from=$applistdb.item item=val key=key} -->
	<li class="{if $listdb.filter.appid eq $val.app_id}active{elseif $key eq 0 and $listdb.filter.appid eq ''}active{/if}"><a class="data-pjax" href='{url path="push/admin/init" args="appid={$val.app_id}"}'>{$val.app_name} <span class="badge badge-info">{$val.count}</span></a></li>
<!-- {/foreach} -->
</ul>

<!-- 批量操作、筛选、搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}&appid={$appid}" name="searchForm">
	
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{lang key='push::push.batch'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="push/admin/batch" args="appid={$appid}"}' data-msg="{lang key='push::push.remove_msg_confirm'}" data-noSelectMsg="{lang key='push::push.empty_select_msg'}" data-name="message_id" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='push::push.remove_msg'}</a></li>
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="push/admin/batch_resend" args="appid={$appid}"}' data-msg="{lang key='push::push.resend_confirm'}" data-noSelectMsg="{lang key='push::push.emtpy_resend_msg'}" data-name="message_id" href="javascript:;"><i class="fontello-icon-chat-empty"></i>{lang key='push::push.resend_msg'}</a></li>
			</ul>
		</div>
		
		<div class="choose_list f_l">
			<div class="screen">
				<!-- 级别 -->
				<select name="status" class="no_search w150"  id="select-status">
					<option value=''  {if $smarty.get.status eq '-1' } selected="true" {/if}>{lang key='push::push.select_push_status'}</option>
					<option value='0' {if $smarty.get.status eq '0'} selected="true" {/if}>{lang key='push::push.push_fail'}</option>
					<option value='1' {if $smarty.get.status eq '1'} selected="true" {/if}>{lang key='push::push.push_success'}</option>
				</select>
				<button class="btn screen-btn" type="button">{lang key='push::push.filter'}</button>
			</div>
		</div>
		
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$listdb.filter.keywords}" placeholder="{lang key='push::push.msg_keywords'}"/>
			<button class="btn search_push" type="button">{lang key='push::push.search'}</button>
		</div>
	</form>
</div>

<div class="row-fluid list-page">
	<div class="span12">	
		<form method="POST" action="{$form_action}" name="listForm">
			<div class="row-fluid">	
				<table class="table table-striped smpl_tbl table-hide-edit table_vam " id="smpl_tbl" data-uniform="uniform" >
					<thead>
						<tr>
							<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
							<th class="w200">{lang key='push::push.device_type'}</th>
							<th class="w200">{lang key='push::push.msg_subject'}</th>
							<th class="w350">{lang key='push::push.msg_content'}</th>
							<th class="w350">{lang key='push::push.push_status'}</th>
							<th class="w200">{lang key='push::push.add_time'}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$listdb.item item=val} -->
						<tr>
							<td>
								<span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.message_id}"/></span>
							</td>
							<td>
								<span>{$val.device_client}</span>
								<div class="edit-list">
									<!-- {if $val.in_status neq 1} -->
									<a class="ajaxpush" data-msg="{lang key='push::push.push_confirm'}" href='{url path="push/admin/push" args="message_id={$val.message_id}"}'>{lang key='push::push.push'}</a>&nbsp;|&nbsp;
									<!-- {else} -->
									<a class="ajaxpush" data-msg="{lang key='push::push.resend_confirm'}" href='{url path="push/admin/push" args="message_id={$val.message_id}"}'>{lang key='push::push.resend'}</a>&nbsp;|&nbsp;
									<!-- {/if} -->
							      	<a class="data-pjax" href='{RC_Uri::url("push/admin/push_copy", "message_id={$val.message_id}")}'>{lang key='push::push.push_copy'}</a>&nbsp;|&nbsp;
									<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='push::push.remove_msg_confirm'}" href='{url path="push/admin/remove" args="message_id={$val.message_id}"}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
								</div>
							</td>
							<td class="hide-edit-area">
								{$val.title}
							</td>
							<td>{$val.content}</td>
							<td>
							{if $val.in_status == 1}
								{lang key='push::push.push_success'}<br>
								{lang key='push::push.has_pushed'}<font class="ecjiafc-red">{$val.push_count}</font>{lang key='push::push.time'}<br>
								{lang key='push::push.label_push_on'}{$val.push_time}
							{else}
								{lang key='push::push.push_fail'}
							{/if}
							</td>
							<td>{$val.add_time}</td>
						</tr>
						<!-- {foreachelse} -->
						<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$listdb.page} -->
			</div>
		</form>
	</div>
</div> 
<!-- {/block} -->