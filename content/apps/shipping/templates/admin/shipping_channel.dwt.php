<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="plugin_config.dwt.php"} -->

<!-- {block name="admin_plugin_list"} -->
<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="data-pjax" href="{$action_link.href}" class="btn" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	<!-- {/if} -->
</h3>

<table class="table table-striped table-hide-edit">
	<thead>
		<tr>
			<th class="w110">{lang key='shipping::shipping.shipping_name'}</th>
			<th>{lang key='shipping::shipping.shipping_desc'}</th>
			<th class="w80">{lang key='system::system.sort_order'}</th>
			<th class="w80">{lang key='shipping::shipping.insure'}</th>
			<th class="w70">{lang key='shipping::shipping.support_cod'}</th>
		</tr>
	</thead>
	<tbody>
		<!-- {foreach from=$modules item=module} -->
		<tr>
			<td>
				<!-- {if $module.enabled == 1} -->
					<span class="shipping_name cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('shipping/admin_plugin/edit_name')}" data-name="title" data-pk="{$module.id}"  data-title="{lang key='shipping::shipping.edit_shipping_name'}">{$module.name}</span>
				<!-- {else} -->
					{$module.name}
				<!-- {/if} -->
			</td>
			<td class="hide-edit-area">
			<!-- {if $module.enabled == 1} -->
					{$module.desc|nl2br}
					<div class="edit-list">
						<a class="data-pjax" href='{RC_Uri::url("shipping/admin_plugin/edit", "code={$module.code}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
						<a class="data-pjax" href='{RC_Uri::url("shipping/admin_area_plugin/init", "shipping_id={$module.id}&code={$module.code}")}'  title="{lang key='shipping::shipping.shipping_area'}">{lang key='shipping::shipping.set_shipping'}</a>&nbsp;|&nbsp;
						<a class="data-pjax" href='{RC_Uri::url("shipping/admin_plugin/edit_print_template", "shipping_id={$module.id}&code={$module.code}")}' title="{lang key='shipping::shipping.shipping_print_edit'}">{lang key='shipping::shipping.shipping_print_edit'}</a>&nbsp;|&nbsp;
						<a class="switch ecjiafc-red" href='javascript:ecjia.admin.shopping_list.plugin_state_click("{RC_Uri::url("shipping/admin_plugin/disable", "code={$module.code}")}");' title="{lang key='shipping::shipping.disable'}">{lang key='shipping::shipping.disable'}</a>
					</div>
				<!-- {else} -->
					{$module.desc|nl2br}
					<div class="edit-list">
						<a class="switch" href='javascript:ecjia.admin.shopping_list.plugin_state_click("{RC_Uri::url("shipping/admin_plugin/enable", "code={$module.code}")}");' title="{lang key='shipping::shipping.enable'}">{lang key='shipping::shipping.enable'}</a>
					</div>
				<!-- {/if} -->
				
			</td>
			<td>
				<!-- {if $module.enabled == 1} -->
					<span class="shipping_order cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('shipping/admin_plugin/edit_order')}" data-name="title" data-pk="{$module.id}"  data-title="{lang key='shipping::shipping.edit_shipping_order'}">{$module.shipping_order}</span>
				<!-- {else} -->
					{$module.shipping_order}
				<!-- {/if} -->
			</td>
			<td>
				<!-- {if $module.is_insure } -->
					{$module.insure_fee}
				<!-- {else} -->
					{lang key='shipping::shipping.not_support'}
				<!-- {/if} -->
			</td>
			<td>
				{if $module.cod==1}
					{lang key='system::system.yes'}
				{else}
					{lang key='system::system.no'}
				{/if}
			</td>
		</tr>
		<!-- {foreachelse} -->
		<tr><td class="no-records" colspan="5">{lang key='system::system.no_records'}</td></tr>
		<!-- {/foreach} -->
	</tbody>
</table>
<!-- {/block} -->