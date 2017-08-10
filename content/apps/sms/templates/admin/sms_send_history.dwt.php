<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.sms_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<ul class="nav nav-pills">
	<li class="{if $listdb.filter.errorval eq '0'}active{/if}"><a class="data-pjax" href='{url path="sms/admin/init" args="errorval=0{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>{lang key='sms::sms.all'}<span class="badge badge-info">{$listdb.msg_count.count}</span></a></li>
	<li class="{if $listdb.filter.errorval eq '1'}active{/if}"><a class="data-pjax" href='{url path="sms/admin/init" args="errorval=1{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>{lang key='sms::sms.wait_send'}<span class="badge badge-info">{$listdb.msg_count.wait}</span></a></li>
	<li class="{if $listdb.filter.errorval eq '2'}active{/if}"><a class="data-pjax" href='{url path="sms/admin/init" args="errorval=2{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>{lang key='sms::sms.send_success'}<span class="badge badge-info">{$listdb.msg_count.success}</span></a></li>
	<li class="{if $listdb.filter.errorval eq '3'}active{/if}"><a class="data-pjax" href='{url path="sms/admin/init" args="errorval=3{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>{lang key='sms::sms.send_faild'}<span class="badge badge-info">{$listdb.msg_count.faild}</span></a></li>
</ul>

<!-- 批量操作、筛选、搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}&errorval={$listdb.filter.errorval}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{lang key='sms::sms.batch_handle'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='sms/admin/batch_resend'}" data-msg="{lang key='sms::sms.batch_send_confirm'}" data-noSelectMsg="{lang key='sms::sms.select_confirm'}" data-name="sms_id" href="javascript:;"><i class="fontello-icon-chat-empty"></i>{lang key='sms::sms.send_sms_again'}</a></li>
			</ul>
		</div>
		
		<div class="choose_list f_l" >
			<input class="date f_l w180" name="start_date" type="text" value="{$listdb.filter.start_date}" placeholder="{lang key='sms::sms.start_time'}">
			<span class="f_l">{lang key='sms::sms.to'}</span>
			<input class="date f_l w180" name="end_date" type="text" value="{$listdb.filter.end_date}" placeholder="{lang key='sms::sms.end_time'}">
			<button class="btn select-button" type="submit">{lang key='sms::sms.filter'}</button>
		</div>
		
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$listdb.filter.keywords}" placeholder="{lang key='sms::sms.sms_keywords'}"/>
			<button class="btn search_sms" type="button">{lang key='sms::sms.search'}</button>
		</div>
	</form>
</div>

<div class="row-fluid list-page">
	<div class="span12">	
		<table class="table table-striped smpl_tbl table-hide-edit table_vam" id="smpl_tbl" data-uniform="uniform" >
			<thead>
				<tr>
					<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
					<th class="w110">短信渠道</th>
					<th class="w100">{lang key='sms::sms.sms_number'}</th>
					<th>{lang key='sms::sms.sms_content'}</th>
					<th class="w150">{lang key='sms::sms.send_time'}</th>
					<th class="w100">{lang key='sms::sms.send_status'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$listdb.item item=val} -->
				<tr>
				<!-- {if $val.error gt 0} -->
				<td>
					<span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.id}"/></span>
				</td>
				<!-- {else} -->
				<td>
					<span><input type="checkbox" disabled="true" name="checkboxes[]" class="checkbox1" value="{$val.id}"/></span>
				</td>
				<!-- {/if} -->
					<td>{$val.channel_name}</td>
					<td>{$val.mobile}</td>
					<td>{$val.sms_content}</td>
					<td>{$val.last_send}</td>
					<td>
						<!-- {if $val.error eq 0 } -->
							{lang key='sms::sms.send_success'}
						<!-- {elseif $val.error eq -1} -->
							{lang key='sms::sms.wait_send'}
						<!-- {else} -->
                            <a class="hint--left  hint--error" style="text-decoration:none;"  {if $val.last_error_message}data-hint="{$val.last_error_message|escape}"{/if}><span class="ecjiafc-red">{if $val.last_error_message}<u>{$val.error} {lang key='sms::sms.error_times'}</u>{else}{$val.error} {lang key='sms::sms.error_times'}{/if}</span></a><br>
							<!-- {if $val.error gt 0}  -->
								<a class="ajaxsms" href='{RC_Uri::url("sms/admin/resend", "id={$val.id}")}'>{lang key='sms::sms.send_again'}</a>
							<!-- {/if} -->
						<!-- {/if} -->
					</td>					
				</tr>
				<!--  {foreachelse} -->
				<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$listdb.page} -->
	</div>
</div> 
<!-- {/block} -->