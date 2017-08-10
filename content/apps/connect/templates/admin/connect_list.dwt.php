<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="plugin_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.connect_list.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_plugin_list"} -->
<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	{if $action_link}
	<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	{/if}
</h3>

<table class="table table-striped table-hide-edit" data-rowlink="a">
	<thead>
		<tr>
			<th class="w120">{lang key='connect::connect.name'}</th>
			<th>{lang key='connect::connect.desc'}</th>
			<th class="w100">{lang key='connect::connect.sort'}</th>
		</tr>
	</thead>
	<tbody>
		<!-- {foreach from=$listdb.connect_list item=module} -->
		<tr>
			<td>
				<!-- {if $module.enabled == 1} -->
					<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('connect/admin_plugin/edit_name')}" data-name="title" data-pk="{$module.connect_id}"  data-title="{lang key='connect::connect.edit_name'}">{$module.connect_name}</span>
				<!-- {else} -->
					{$module.connect_name}
				<!-- {/if} -->
			</td>
			
			<td class="hide-edit-area">
			<!-- {if $module.enabled == 1} -->
				{$module.connect_desc|nl2br}
				<div class="edit-list">
					{assign var=connect_edit value=RC_Uri::url('connect/admin_plugin/edit',"code={$module.connect_code}")}
					<a class="data-pjax" href="{$connect_edit}" title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
					{assign var=connect_disable value=RC_Uri::url('connect/admin_plugin/disable',"id={$module.connect_id}")}
					<a class="ecjiafc-red ajaxall"  href="{$connect_disable}" data-url="{$connect_disable}" title="{lang key='connect::connect.disable'}">{lang key='connect::connect.disable'}</a>
				</div>
				<!-- {else} -->
				{$module.connect_desc|nl2br}
				<div class="edit-list">
					{assign var=connect_enable value=RC_Uri::url('connect/admin_plugin/enable',"id={$module.connect_id}")}
					<a class="ajaxall" href="{$connect_enable}" data-url="{$connect_enable}" title="{lang key='connect::connect.enable'}">{lang key='connect::connect.enable'}</a>
				</div>
				<!-- {/if} -->
			</td>
			<td>
				<!-- {if $module.enabled == 1} -->
				<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('connect/admin_plugin/edit_order')}" data-name="title" data-pk="{$module.connect_id}" data-title="{lang key='connect::connect.edit_sort'}">{$module.connect_order}</span>
				<!-- {else} -->
				{$module.connect_order}
				<!-- {/if} -->
			</td>
		</tr>
		<!-- {foreachelse} -->
		<tr><td class="no-records" colspan="3">{lang key='system::system.no_records'}</td></tr>
		<!-- {/foreach} -->
	</tbody>
</table>	
<!-- {/block} -->