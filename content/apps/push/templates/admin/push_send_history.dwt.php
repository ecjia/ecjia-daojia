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
		<a class="btn plus_or_reply data-pjax" href="{$action_link_device.href}" id="sticky_a"><i class="fontello-icon-upload"></i>{$action_link_device.text}</a>
	</h3>
</div>

<ul class="nav nav-pills">
	<li class="{if $listdb.filter.errorval eq '0'}active{/if}"><a class="data-pjax" href='{url path="push/admin/init" args="errorval=0{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>全部<span class="badge badge-info">{$listdb.msg_count.count}</span></a></li>
	<li class="{if $listdb.filter.errorval eq '1'}active{/if}"><a class="data-pjax" href='{url path="push/admin/init" args="errorval=1{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>待发送<span class="badge badge-info">{$listdb.msg_count.wait}</span></a></li>
	<li class="{if $listdb.filter.errorval eq '2'}active{/if}"><a class="data-pjax" href='{url path="push/admin/init" args="errorval=2{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>发送成功<span class="badge badge-info">{$listdb.msg_count.success}</span></a></li>
	<li class="{if $listdb.filter.errorval eq '3'}active{/if}"><a class="data-pjax" href='{url path="push/admin/init" args="errorval=3{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>发送失败<span class="badge badge-info">{$listdb.msg_count.faild}</span></a></li>
</ul>

<!-- 批量操作、筛选、搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>批量操作<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="push/admin/batch_resend" args="appid={$appid}"}' data-msg="{lang key='push::push.resend_confirm'}" data-noSelectMsg="{lang key='push::push.emtpy_resend_msg'}" data-name="message_id" href="javascript:;"><i class="fontello-icon-chat-empty"></i>批量发送</a></li>
			</ul>
		</div>
	
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$listdb.filter.keywords}" placeholder="{lang key='push::push.msg_keywords'}"/>
			<button class="btn search_push" type="button">搜索</button>
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
							<th class="w150">设备类型</th>
							<th>消息主题/消息内容</th>
							<th class="w150">推送时间</th>
							<th class="w200">推送状态</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$listdb.item item=val} -->
						<tr>
							<td>
								<span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.message_id}"/></span>
							</td>
							<td>
								<span>{if $val.device_client eq 'iphone'}iPhone{elseif $val.device_client eq 'android'}Android{/if}<br>{$val.app_name}</span>
								<div class="edit-list">
									<!-- {if $val.in_status neq 1} -->
										<a class="ajaxpush" data-msg="{lang key='push::push.push_confirm'}" href='{url path="push/admin/resend" args="message_id={$val.message_id}"}'>{lang key='push::push.push'}</a>&nbsp;|&nbsp;
									<!-- {else} -->
										<a class="ajaxpush" data-msg="{lang key='push::push.resend_confirm'}" href='{url path="push/admin/resend" args="message_id={$val.message_id}"}'>{lang key='push::push.resend'}</a>&nbsp;|&nbsp;
									<!-- {/if} -->
							      	<a class="data-pjax" href='{RC_Uri::url("push/admin/push_copy", "message_id={$val.message_id}")}'>{lang key='push::push.push_copy'}</a>
								</div>
							</td>
							<td>
								{$val.title}<br>{$val.content}
							</td>
							<td>{$val.push_time}</td>
							<td>
								{if $val.in_status == 1}
									{lang key='push::push.push_success'}<br>
									{lang key='push::push.has_pushed'}<font class="ecjiafc-red">{$val.push_count}</font>{lang key='push::push.time'}<br>
									{lang key='push::push.label_push_on'}{$val.push_time}
								{else}
									{if $val.last_error_message}
										<a class="hint--left  hint--error"  data-hint="{$val.last_error_message|escape}">
											<span class="ecjiafc-red">
											<u>发送失败</u></span>
										</a>
									{else}发送失败{/if}<br><br>
								{/if}
								<br>
							</td>
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