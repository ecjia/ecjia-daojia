<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->

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

<div class="row-fluid">
	<div class="span12">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<!-- {foreach from=$tags item=tag} -->
					<li{if $tag.active} class="active"{/if}><a{if $tag.active} href="javascript:;"{else}{if $tag.pjax} class="data-pjax"{/if} href='{$tag.href}'{/if}><!-- {$tag.name} --></a></li>
				<!-- {/foreach} -->
			</ul>
		</div>
		<form method="post" action="{$form_action}" name="listForm" data-edit-url="{RC_Uri::url('bonus/admin/bonus_list')}">
			<table class="table table-striped smpl_tbl">
				<thead>
					<tr>
						<th>{lang key='mobile::mobile.member_name'}</th>
						<th>{lang key='mobile::mobile.prize_name'}</th>
						<th>{lang key='mobile::mobile.assign_status'}</th>
						<th>{lang key='mobile::mobile.source'}</th>
						<th>{lang key='mobile::mobile.assign_time'}</th>
						<th>{lang key='mobile::mobile.draw_time'}</th>
					</tr>    
				</thead>
				<tbody>
					<!--{foreach from=$activity_record_list.item item=record} -->
					<tr>
						<td>{if $record.username}<a href='{RC_Uri::url("user/admin/info", "id={$record.user_id}")}' target="_blank">{$record.username}</a>{else}{$record.username}{/if}</td>
						<td>{$record.prize_name}</td>
						<td>
							{if $record.issue_status eq '0'}{lang key='mobile::mobile.unreleased'}{else}{lang key='mobile::mobile.issued'}{/if}
						</td>
						<td>{$record.source}</td>
						<td>{$record.issue_time}</td>
						<td>{$record.add_time}</td>
					</tr>
					<!-- {foreachelse} -->
					<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$activity_record_list.page} -->
		</form>
	</div>
</div>
<!-- {/block} -->