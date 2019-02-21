<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="plugin_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.platform.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_plugin_list"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>	

<table class="table table-striped table-hide-edit" data-rowlink="a">
	<thead>
		<tr>
			<th class="w150">{t domain="platform"}扩展名称{/t}</th>
			<th class="w200">{t domain="platform"}插件代号{/t}</th>
			<th>{t domain="platform"}描述{/t}</th>
		</tr>
	</thead>
	<tbody>
		<!-- {foreach from=$modules.module item=module} -->
		<tr>
			<td>{$module.ext_name}</td>
			<td class="hide-edit-area">
			<!-- {if $module.enabled eq 1} -->
				{$module.ext_code}
				<div class="edit-list">
					<a class="data-pjax" href='{RC_Uri::url("platform/admin_command/extend_command", "code={$module.ext_code}")}' title='{t domain="platform"}查看命令{/t}'>{t domain="platform"}查看命令{/t}</a>&nbsp;|&nbsp;
					<a class="data-pjax" href='{RC_Uri::url("platform/admin_plugin/edit", "code={$module.ext_code}")}' title='{t domain="platform"}编辑{/t}'>{t domain="platform"}编辑{/t}</a>&nbsp;|&nbsp;
					
					{assign var=platform_disable value=RC_Uri::url('platform/admin_plugin/disable', "code={$module.ext_code}")}
					<a class="ecjiafc-red ajaxall" href="{$platform_disable}" data-url="{$platform_disable}" title='{t domain="platform"}禁用{/t}'>{t domain="platform"}禁用{/t}</a>
				</div>
			<!-- {else} -->
				{$module.ext_code}
				<div class="edit-list">
					{assign var=platform_enable value=RC_Uri::url('platform/admin_plugin/enable', "code={$module.ext_code}")}
					<a class="ajaxall" href="{$platform_enable}" data-url="{$platform_enable}" title='{t domain="platform"}启用{/t}'>{t domain="platform"}启用{/t}</a>
				</div>
			<!-- {/if} -->
			</td>
			<td>{$module.ext_desc}</td>
		</tr>
		<!-- {foreachelse} -->
		<tr><td class="no-records" colspan="3">{t domain="platform"}没有找到任何记录{/t}</td></tr>
		<!-- {/foreach} -->
	</tbody>
</table>	
<!-- {$modules.page} -->
<!-- {/block} -->