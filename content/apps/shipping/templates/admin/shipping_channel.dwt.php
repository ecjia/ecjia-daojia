<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="plugin_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.shopping_list.list();
</script>
<!-- {/block} -->

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
			<th class="w150">{t domain="shipping"}名称{/t}</th>
			<th>{t domain="shipping"}描述{/t}</th>
			<th class="w80">{t domain="shipping"}排序{/t}</th>
			<th class="w80">{t domain="shipping"}保价费用{/t}</th>
			<th class="w70">{t domain="shipping"}货到付款{/t}</th>
		</tr>
	</thead>
	<tbody>
		<!-- {foreach from=$modules item=module} -->
		<tr>
			<td>
				<!-- {if $module.enabled == 1} -->
					<span class="shipping_name cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('shipping/admin_plugin/edit_name')}" data-name="title" data-pk="{$module.id}"  data-title='{t domain="shipping"}编辑配送方式名称{/t}'>{$module.name}</span>
				<!-- {else} -->
					{$module.name}
				<!-- {/if} -->
			</td>
			<td class="hide-edit-area">
			<!-- {if $module.enabled == 1} -->
					{$module.desc|nl2br}
					<div class="edit-list">
						<a class="data-pjax" href='{RC_Uri::url("shipping/admin_plugin/edit", "code={$module.code}")}' title='{t domain="shipping"}编辑{/t}'>{t domain="shipping"}编辑{/t}</a>&nbsp;|&nbsp;
						{if $module.print_support}
							<a class="data-pjax" href='{RC_Uri::url("shipping/admin/edit_print_template", "shipping_id={$module.id}&code={$module.code}")}' title='{t domain="shipping"}编辑打印模板{/t}'>{t domain="shipping"}快递单模板{/t}</a>&nbsp;|&nbsp;
						{/if}
						<a class="switch ecjiafc-red" href="javascript:;" data-url='{RC_Uri::url("shipping/admin_plugin/disable", "code={$module.code}")}' title='{t domain="shipping"}禁用{/t}'>{t domain="shipping"}禁用{/t}</a>
					</div>
				<!-- {else} -->
					{$module.desc|nl2br}
					<div class="edit-list">
						<a class="switch" href="javascript:;" data-url='{RC_Uri::url("shipping/admin_plugin/enable", "code={$module.code}")}' title='{t domain="shipping"}启用{/t}'>{t domain="shipping"}启用{/t}</a>
					</div>
				<!-- {/if} -->
				
			</td>
			<td>
				<!-- {if $module.enabled == 1} -->
					<span class="shipping_order cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('shipping/admin_plugin/edit_order')}" data-name="title" data-pk="{$module.id}"  data-title='{t domain="shipping"}编辑配送方式排序{/t}'>{$module.shipping_order}</span>
				<!-- {else} -->
					{$module.shipping_order}
				<!-- {/if} -->
			</td>
			<td>
				<!-- {if $module.is_insure } -->
					{$module.insure_fee}
				<!-- {else} -->
					{t domain="shipping"}不支持{/t}
				<!-- {/if} -->
			</td>
			<td>
				{if $module.cod==1}
					{t domain="shipping"}是{/t}
				{else}
					{t domain="shipping"}否{/t}
				{/if}
			</td>
		</tr>
		<!-- {foreachelse} -->
		<tr><td class="no-records" colspan="5">{t domain="shipping"}没有找到任何记录{/t}</td></tr>
		<!-- {/foreach} -->
	</tbody>
</table>
<!-- {/block} -->