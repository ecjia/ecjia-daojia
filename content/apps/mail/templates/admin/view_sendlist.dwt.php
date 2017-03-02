<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.view_sendlist.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div id="part_loading">
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<!-- 批量操作-->
<div class="row-fluid batch" >
	<div class="choose_list">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{lang key='mail::view_sendlist.batch'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="batchdel" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='mail/admin_view_sendlist/batch' args='sel_action=batchdel'}" data-msg="{lang key='mail::view_sendlist.batch_remove_confirm'}" data-noSelectMsg="{lang key='mail::view_sendlist.select_remove_email'}" data-name="checkboxes" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='mail::view_sendlist.remove_mail_send'}</a></li>
				<li><a class="batchsend" data-url="{RC_Uri::url('mail/admin_view_sendlist/batch?sel_action=batchsend')}" data-noSelectMsg="{lang key='mail::view_sendlist.select_send_email'}" data-name="checkboxes" href="javascript:;"><i class="fontello-icon-mail"></i>{lang key='mail::view_sendlist.select_mail_send'}</a></li>
			</ul>
		</div>
		<!-- 全部发送 -->
		<!-- {if $isSendAll} -->
		<button class="btn" id="send-all" >{lang key='mail::view_sendlist.all_send'}</button>
		<!-- {else} -->
		<button class="btn" disabled="disabled"  id="send-all" >{lang key='mail::view_sendlist.all_send'}</button>
		<!-- {/if} -->

		<!-- 筛选 -->
		<form class="f_r form-inline" action="{$search_action}"  method="post" name="searchForm">
			<div class="screen f_r">
				<!-- 邮件类型 -->
				<select class="no_search w180" name="typemail" id="select-typemail">
					<option value="0" {if $smarty.get.typemail_id eq '0'} selected="selected" {/if}>{lang key='mail::view_sendlist.all_typemail'}</option>
					<option value='1' {if $smarty.get.typemail_id eq '1'} selected="selected" {/if}>{lang key='mail::view_sendlist.type.magazine'}</option>
					<option value='2' {if $smarty.get.typemail_id eq '2'} selected="selected" {/if}>{lang key='mail::view_sendlist.type.template'}</option>
				</select>
				<!-- 级别 -->
				<select name="pri" class="no_search w100"  id="select-pri">
					<option value=''  {if $smarty.get.pri_id eq ''} selected="selected" {/if}>{lang key='mail::view_sendlist.all_levels'}</option>
					<option value='0' {if $smarty.get.pri_id eq '0'} selected="selected" {/if}>{lang key='mail::view_sendlist.pri.0'}</option>
					<option value='1' {if $smarty.get.pri_id eq '1'} selected="selected" {/if}>{lang key='mail::view_sendlist.pri.1'}</option>
				</select>
				<button class="btn screen-btn" type="button">{lang key='mail::view_sendlist.filter'}</button>
			</div>
		</form>
	</div>
</div>

<div class="row-fluid list-page">
	<div class="span12">	
		<form method="post" action="{$form_action}" name="listForm">
			<table class="table table-striped smpl_tbl table-hide-edit table_vam " id="smpl_tbl" data-uniform="uniform" >
				<thead>
					<tr>
						<th class="table_checkbox">
							<input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
						</th>
						<th class="w200">{lang key='mail::view_sendlist.email_val'}</th>
						<th>{lang key='mail::view_sendlist.email_subject'}</th>
						<th class="w100" >{lang key='mail::view_sendlist.type.name'}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$listdb.item item=val} -->
					<tr id="aa">
						<td>
							<input type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.id}" />
						</td>
						<td>{$val.email}<br>
							{if $val.error neq 0}
							<span class="ecjiafc-red">{$val.error}{lang key='mail::view_sendlist.send_errors'}</span>
							{/if}</td>
						<td class="hide-edit-area">
							{lang key='mail::view_sendlist.pri.name'}：{$pri[$val.pri]}&nbsp;|&nbsp;{lang key='mail::view_sendlist.last_send'}{$val.last_send}<br>
							{$val.template_subject}
							<div class="edit-list">
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='mail::view_sendlist.drop_mail_confirm'}" href='{RC_Uri::url("mail/admin_view_sendlist/remove", "id={$val.id}")}' title="{lang key='system::system.remove'}">{lang key='system::system.drop'}</a>
							</div>
						</td>
						<td>{$type[$val.type]}</td>					
					</tr>
					<!--  {foreachelse} -->
					<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$listdb.page} -->
		</form>
	</div>
</div> 
<!-- {/block} -->