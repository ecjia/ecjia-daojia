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
	<li class="{if $listdb.filter.errorval eq '0'}active{/if}"><a class="data-pjax" href='{url path="push/admin/init" args="errorval=0{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>{t domain="push"}全部{/t}<span class="badge badge-info">{$listdb.msg_count.count}</span></a></li>
	<li class="{if $listdb.filter.errorval eq '1'}active{/if}"><a class="data-pjax" href='{url path="push/admin/init" args="errorval=1{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>{t domain="push"}待发送{/t}<span class="badge badge-info">{$listdb.msg_count.wait}</span></a></li>
	<li class="{if $listdb.filter.errorval eq '2'}active{/if}"><a class="data-pjax" href='{url path="push/admin/init" args="errorval=2{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>{t domain="push"}发送成功{/t}<span class="badge badge-info">{$listdb.msg_count.success}</span></a></li>
	<li class="{if $listdb.filter.errorval eq '3'}active{/if}"><a class="data-pjax" href='{url path="push/admin/init" args="errorval=3{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>{t domain="push"}发送失败{/t}<span class="badge badge-info">{$listdb.msg_count.faild}</span></a></li>
</ul>

<!-- 批量操作、筛选、搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{t domain="push"}批量操作{/t}<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="push/admin/batch_resend" args="appid={$appid}"}' data-msg='{t domain="push"}您确定要再次推送该条消息吗？{/t}' data-noSelectMsg='{t domain="push"}请先选中要再次推送的消息{/t}' data-name="message_id" href="javascript:;"><i class="fontello-icon-chat-empty"></i>{t domain="push"}批量发送{/t}</a></li>
			</ul>
		</div>
	
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$listdb.filter.keywords}" placeholder='{t domain="push"}请输入消息主题关键字{/t}' />
			<button class="btn search_push" type="button">{t domain="push"}搜索{/t}</button>
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
							<th class="w150">{t domain="push"}设备类型{/t}</th>
							<th>{t domain="push"}消息主题/消息内容{/t}</th>
							<th class="w150">{t domain="push"}推送时间{/t}</th>
							<th class="w200">{t domain="push"}推送状态{/t}</th>
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
										<a class="ajaxpush" data-msg='{t domain="push"}您确定要推送该条这条消息吗？{/t}' href='{url path="push/admin/resend" args="message_id={$val.message_id}"}'>{t domain="push"}推送{/t}</a>&nbsp;|&nbsp;
									<!-- {else} -->
										<a class="ajaxpush" data-msg='{t domain="push"}您确定要再次推送该条消息吗？{/t}' href='{url path="push/admin/resend" args="message_id={$val.message_id}"}'>{t domain="push"}再次推送{/t}</a>&nbsp;|&nbsp;
									<!-- {/if} -->
							      	<a class="data-pjax" href='{RC_Uri::url("push/admin/push_copy", "message_id={$val.message_id}")}'>{t domain="push"}消息复用{/t}</a>
								</div>
							</td>
							<td>
								{$val.title}<br>{$val.content}
							</td>
							<td>{$val.push_time}</td>
							<td>
								{if $val.in_status == 1}
									{t domain="push"}推送完成{/t}<br>
									{t domain="push"}该消息已经被推送了{/t}<font class="ecjiafc-red">{$val.push_count}</font>{t domain="push"}次{/t}<br>
									{t domain="push"}推送于：{/t}{$val.push_time}
								{else}
									{if $val.last_error_message}
										<a class="hint--left  hint--error"  data-hint="{$val.last_error_message|escape}">
											<span class="ecjiafc-red">
											<u>{t domain="push"}发送失败{/t}</u></span>
										</a>
									{else}
									{t domain="push"}发送失败{/t}
									{/if}<br><br>
								{/if}
								<br>
							</td>
						</tr>
						<!-- {foreachelse} -->
						<tr><td class="no-records" colspan="6">{t domain="push"}没有找到任何记录{/t}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$listdb.page} -->
			</div>
		</form>
	</div>
</div> 
<!-- {/block} -->