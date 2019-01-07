<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="plugin_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_plugin.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_plugin_list"} -->
<h3 class="heading">{if $ur_here}{$ur_here}{/if}</h3>

<table class="table table-striped table-hide-edit" data-rowlink="a">
	<thead>
		<tr>
			<th class="w100">提现方式</th>
			<th>{lang key='withdraw::withdraw.withdraw_desc'}</th>
			<th class="w50">{lang key='system::system.sort_order'}</th>
			<th class="w80">{lang key='withdraw::withdraw.short_withdraw_fee'}</th>
		</tr>
	</thead>
	<tbody>
		<!-- {foreach from=$modules item=module} -->
		<!-- {if $module.code neq "tenpayc2c"} -->
		<tr>
			<td >
				<!-- {if $module.enabled == 1} -->
					<span class="withdraw_name cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('withdraw/admin_plugin/edit_name')}" data-name="title" data-pk="{$module.id}"  data-title="{lang key='withdraw::withdraw.edit_withdraw_name'}">{$module.name}</span>
				<!-- {else} -->
					{$module.name}
				<!-- {/if} -->
			</td>
			<td class="hide-edit-area">
				<!-- {if $module.enabled == 1} -->
					{$module.desc|nl2br}
					<div class="edit-list">
						<a class="data-pjax" href='{RC_Uri::url("withdraw/admin_plugin/edit", "code={$module.code}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
						<a class="switch ecjiafc-red" href="javascript:;" data-url='{RC_Uri::url("withdraw/admin_plugin/disable", "code={$module.code}")}' title="{lang key='withdraw::withdraw.disable'}">{lang key='withdraw::withdraw.disable'}</a>
					</div>
				<!-- {else} -->
					{$module.desc|nl2br}
					<div class="edit-list">
						<a class="switch" href="javascript:;" data-url='{RC_Uri::url("withdraw/admin_plugin/enable", "code={$module.code}")}' title="{lang key='withdraw::withdraw.enable'}">{lang key='withdraw::withdraw.enable'}</a>
					</div>
				<!-- {/if} -->
			</td>
			<td>
				<!-- {if $module.enabled == 1} -->
				<span class="withdraw_order cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('withdraw/admin_plugin/edit_order')}" data-name="title" data-pk="{$module.id}" data-title="{lang key='withdraw::withdraw.edit_withdraw_order'}">{$module.withdraw_order}</span>
				<!-- {else} -->
				{$module.withdraw_order}
				<!-- {/if} -->
			</td>
			<td>
			    {$module.withdraw_fee}
			</td>
		</tr>
		<!-- {/if} -->
		<!-- {foreachelse} -->
		<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
		<!-- {/foreach} -->
	</tbody>
</table>	
<!-- {/block} -->