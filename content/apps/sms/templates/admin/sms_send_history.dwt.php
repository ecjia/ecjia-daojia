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
	<li class="{if $listdb.filter.errorval eq '0'}active{/if}"><a class="data-pjax" href='{url path="sms/admin/init" args="errorval=0{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>{t domain="sms"}全部{/t}<span class="badge badge-info">{$listdb.msg_count.count}</span></a></li>
	<li class="{if $listdb.filter.errorval eq '1'}active{/if}"><a class="data-pjax" href='{url path="sms/admin/init" args="errorval=1{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>{t domain="sms"}待发送{/t}<span class="badge badge-info">{$listdb.msg_count.wait}</span></a></li>
	<li class="{if $listdb.filter.errorval eq '2'}active{/if}"><a class="data-pjax" href='{url path="sms/admin/init" args="errorval=2{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>{t domain="sms"}发送成功{/t}<span class="badge badge-info">{$listdb.msg_count.success}</span></a></li>
	<li class="{if $listdb.filter.errorval eq '3'}active{/if}"><a class="data-pjax" href='{url path="sms/admin/init" args="errorval=3{if $listdb.filter.keywords}&keywords={$listdb.filter.keywords}{/if}"}'>{t domain="sms"}发送失败{/t}<span class="badge badge-info">{$listdb.msg_count.faild}</span></a></li>
</ul>

<!-- 批量操作、筛选、搜索 -->
<div class="row-fluid batch" >
	<form method="post" action="{$search_action}&errorval={$listdb.filter.errorval}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{t domain="sms"}批量操作{/t}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='sms/admin/batch_resend'}" data-msg='{t domain="sms"}您确定要再次发送选中的短信记录吗？{/t}' data-noSelectMsg='{t domain="sms"}请先选中要再次发送的短信记录！{/t}' data-name="sms_id" href="javascript:;"><i class="fontello-icon-chat-empty"></i>{t domain="sms"}再次发送短信{/t}</a></li>
			</ul>
		</div>
		
		<div class="choose_list f_l" >
			<input class="date f_l w180" name="start_date" type="text" value="{$listdb.filter.start_date}" placeholder='{t domain="sms"}开始时间{/t}'>
			<span class="f_l">{t domain="sms"}至{/t}</span>
			<input class="date f_l w180" name="end_date" type="text" value="{$listdb.filter.end_date}" placeholder='{t domain="sms"}截止时间{/t}'>
			<button class="btn select-button" type="submit">{t domain="sms"}筛选{/t}</button>
		</div>
		
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$listdb.filter.keywords}" placeholder='{t domain="sms"}请输入短信接收号码或内容关键字{/t}'/>
			<button class="btn search_sms" type="button">{t domain="sms"}搜索{/t}</button>
		</div>
	</form>
</div>

<div class="row-fluid list-page">
	<div class="span12">	
		<table class="table table-striped smpl_tbl table-hide-edit table_vam" id="smpl_tbl" data-uniform="uniform" >
			<thead>
				<tr>
					<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
					<th class="w110">{t domain="sms"}短信渠道{/t}</th>
					<th class="w100">{t domain="sms"}接收短信号码{/t}</th>
					<th>{t domain="sms"}短信内容{/t}</th>
					<th class="w150">{t domain="sms"}发送时间{/t}</th>
					<th class="w100">{t domain="sms"}发送状态{/t}</th>
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
							{t domain="sms"}发送成功{/t}
						<!-- {elseif $val.error eq -1} -->
							{t domain="sms"}待发送{/t}
						<!-- {else} -->
                            <a class="hint--left  hint--error" style="text-decoration:none;"  {if $val.last_error_message}data-hint="{$val.last_error_message|escape}"{/if}><span class="ecjiafc-red">{if $val.last_error_message}<u>{t domain="sms" 1={$val.error}}%1次发送错误{/t}</u>{else}{t domain="sms" 1={$val.error}}%1次发送错误{/t}{/if}</span></a><br>
							<!-- {if $val.error gt 0}  -->
								<a class="ajaxsms" href='{RC_Uri::url("sms/admin/resend", "id={$val.id}")}'>{t domain="sms"}再次发送{/t}</a>
							<!-- {/if} -->
						<!-- {/if} -->
					</td>					
				</tr>
				<!--  {foreachelse} -->
				<tr><td class="no-records" colspan="6">{t domain="sms"}没有找到任何记录{/t}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$listdb.page} -->
	</div>
</div> 
<!-- {/block} -->