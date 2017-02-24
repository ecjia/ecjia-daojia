<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.bonus_type.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<!-- 批量操作-->
<div class="row-fluid batch" >
	<div class="btn-group f_l m_r5">
		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fontello-icon-cog"></i>{lang key='bonus::bonus.batch_operation'}
			<span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			<li><a class="remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="bonus/admin/batch" args="sel_action=remove&bonus_type_id=$bonus_type_id"}' data-msg="{lang key='bonus::bonus.remove_confirm'}" data-noSelectMsg="{lang key='bonus::bonus.pls_choose_remove'}" data-name="checkboxes" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='bonus::bonus.drop_bonus'}</a></li>				      
			<!-- {if $show_mail} -->  
			<li><a class="send"   data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="bonus/admin/batch" args="sel_action=send&bonus_type_id=$bonus_type_id"}' data-msg="{lang key='bonus::bonus.remove_confirm'}" data-noSelectMsg="{lang key='bonus::bonus.pls_choose_send'}" data-name="checkboxes" href="javascript:;"><i class="fontello-icon-right-hand"></i>{lang key='bonus::bonus.insert_maillist'}</a></li>
			<!-- {/if} -->
		</ul>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl">
			<thead>
				<tr>
					<th class="table_checkbox">
						<input type="checkbox" data-toggle="selectall"  data-children=".checkbox"/>
					</th>
					<!-- {if $show_bonus_sn} -->
					<th>{lang key='bonus::bonus.bonus_sn'}</th>
					<!-- {/if} -->
					<th>{lang key='bonus::bonus.list_bonus_type'}</th>
					<th>商家名称</th>
					<th class="w150">{lang key='bonus::bonus.order_id'}</th>
					<th class="w150">{lang key='bonus::bonus.user_id'}</th>
					<th class="w150">{lang key='bonus::bonus.used_time'}</th>
					<!-- {if $show_mail} -->  
					<th class="w220">{lang key='bonus::bonus.emailed'}</th>
					<!-- {/if} -->
					<th class="w80">{lang key='system::system.handler'}</th>
				</tr>    
			</thead>
			<tbody>
				<!--{foreach from=$bonus_list.item item=bonus} -->
				<tr>
					<td><span><input type="checkbox" name="checkboxes[]"  class="checkbox"  value="{$bonus.bonus_id}"/></span></td>
					<!-- {if $show_bonus_sn} -->
					<td>{$bonus.bonus_sn}</td>
					<!-- {/if} -->
					<td>{$bonus.type_name}</td>
					<td class="ecjiafc-red">{$bonus.merchants_name}</td>
					<td>{$bonus.order_sn}</td>
					<td>{if $bonus.email}<a href="{RC_Uri::url('user/admin/info',"id={$bonus.user_id}")}">{$bonus.user_name}</a>{else}{$bonus.user_name}{/if}</td>
					<td align="right">{$bonus.used_time}</td>
					<!-- {if $show_mail} -->
					<td align="center">{$bonus.emailed}</td>
					<!-- {/if} -->
					<td align="center">
						<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='bonus::bonus.remove_bonus_confirm'}" href="{RC_Uri::url('bonus/admin/remove_bonus',"id={$bonus.bonus_id}")}" title="{lang key='system::system.remove'}"><i class="fontello-icon-trash"></i></a>
						{if $show_mail and $bonus.order_id eq 0 and $bonus.email}<a class="insert_mail_list no-underline" href="javascript:;" data-href="{RC_Uri::url('bonus/admin/send_mail',"bonus_id={$bonus.bonus_id}&bonus_type={$bonus_type_id}")}" title="{lang key='bonus::bonus.insert_maillist'}"><i class="fontello-icon-right-hand"></i></a>{/if}
					</td>
				</tr>
				<!-- {foreachelse} -->
				<tr><td class="no-records" colspan="10">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$bonus_list.page} -->
	</div>
</div>
<!-- {/block} -->