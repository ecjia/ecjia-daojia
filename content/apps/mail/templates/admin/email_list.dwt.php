<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.email_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" ><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
<!-- 批量操作-->
<div class="row-fluid batch" >
	<div class="btn-group f_l m_r5">
		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fontello-icon-cog"></i>{lang key='mail::email_list.batch'}
			<span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			<li><a class="remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='mail/admin_email_list/batch' args='sel_action=remove'}" data-msg="{lang key='mail::email_list.batch_remove_confirm'}" data-noSelectMsg="{lang key='mail::email_list.select_remove_email'}" data-name="checkboxes" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='mail::email_list.remove_email'}</a></li>
			<li><a class="ok" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='mail/admin_email_list/batch' args='sel_action=ok'}" data-msg="{lang key='mail::email_list.batch_ok_confirm'}" data-noSelectMsg="{lang key='mail::email_list.select_ok_email'}" data-name="checkboxes" href="javascript:;"><i class="fontello-icon-smile"></i>{lang key='mail::email_list.ok_email'}</a></li>
			<li><a class="exit" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='mail/admin_email_list/batch' args='sel_action=exit'}" data-msg="{lang key='mail::email_list.batch_exit_confirm'}" data-noSelectMsg="{lang key='mail::email_list.select_exit_email'}" data-name="checkboxes" href="javascript:;"><i class="fontello-icon-frown"></i>{lang key='mail::email_list.exit_email'}</a></li>
		</ul>
	</div>
	<!-- 导出列表 -->
	<button class="btn export_btn" {if !$emaildb.item}disabled{/if} data-url="{RC_Uri::url('mail/admin_email_list/export')}">{lang key='mail::email_list.export'}</button>
</div>
<div class="row-fluid list-page">
	<div class="span12">
		<form method="post" action="{$form_action}" name="listForm">
			<table class="table table-striped smpl_tbl table_vam" id="smpl_tbl" data-uniform="uniform">
				<thead>
					<tr>
						<th class="table_checkbox">
							<input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
						</th>
						<th class="w100">{lang key='mail::email_list.id'}</th>
						<th>{lang key='mail::email_list.email_val'}</th>
						<th class="w150">{lang key='mail::email_list.stat.name'}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$emaildb.item item=val} -->
					<tr id="aa">
						<td>
							<input type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.id}"/>
						</td>
						<td>{$val.id}</td>
						<td>{$val.email}</td>
						<td>{$stat[$val.stat]}</td>
					</tr>
					<!-- {foreachelse} -->
					<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$emaildb.page} -->
		</form>
	</div>
</div>	
<!-- {/block} -->