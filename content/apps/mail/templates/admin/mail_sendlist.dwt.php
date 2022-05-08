<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.mail_sendlist.init();
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
				<i class="fontello-icon-cog"></i>{t domain="mail"}批量操作{/t}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="batchdel" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='mail/admin_mail_sendlist/batch' args='sel_action=batchdel'}" data-msg='{t domain="mail"}您确定要删除选中的邮件吗？{/t}' data-noSelectMsg='{t domain="mail"}请先选中要删除的邮件！{/t}' data-name="checkboxes" href="javascript:;"><i class="fontello-icon-trash"></i>{t domain="mail"}删除邮件记录{/t}</a></li>
			</ul>
		</div>

		<!-- 筛选 -->
		<form class="f_r form-inline" action="{$search_action}"  method="post" name="searchForm">
			<div class="screen f_r">
				<!-- 级别 -->
				<select name="pri" class="no_search w100"  id="select-pri">
					<option value=''  {if $smarty.get.pri_id eq ''} selected="selected" {/if}>{t domain="mail"}所有级别{/t}</option>
					<option value='0' {if $smarty.get.pri_id eq '0'} selected="selected" {/if}>{t domain="mail"}普通{/t}</option>
					<option value='1' {if $smarty.get.pri_id eq '1'} selected="selected" {/if}>{t domain="mail"}高{/t}</option>
				</select>
				<button class="btn screen-btn" type="button">{t domain="mail"}筛选{/t}</button>
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
						<th class="w200">{t domain="mail"}邮件地址{/t}</th>
						<th>{t domain="mail"}邮件标题{/t}</th>
						<th class="w100" >{t domain="mail"}优先级{/t}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$send_list.item item=val} -->
					<tr id="aa">
						<td>
							<input type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.id}" />
						</td>
						<td class="hide-edit-area">{$val.email}<br>
							{if $val.error neq 0}
							<span class="ecjiafc-red">{$val.error}{t domain="mail"}次发送错误{/t}</span>
							{/if}
                            <div class="edit-list">
                                <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="mail"}您确定要删除该邮件信息吗？{/t}' href='{RC_Uri::url("mail/admin_mail_sendlist/remove", "id={$val.id}")}' title='{t domain="mail"}移除{/t}'>{t domain="mail"}删除{/t}</a>
                            </div>
                        </td>
						<td>
                            {$val.template_subject}<br>
                            {if $val.last_send}<span style="color: #9b9b9b">{t domain="mail" 1={$val.last_send}}上次发送于%1{/t}</span>{/if}
						</td>
						<td>{$pri[$val.pri]}</td>
					</tr>
					<!--  {foreachelse} -->
					<tr><td class="no-records" colspan="4">{t domain="mail"}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$send_list.page} -->
		</form>
	</div>
</div> 
<!-- {/block} -->