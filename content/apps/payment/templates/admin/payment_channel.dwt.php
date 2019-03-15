<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="plugin_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.payment_list.list();
</script>
<!-- {/block} -->

<!-- {block name="admin_plugin_list"} -->
<h3 class="heading">{if $ur_here}{$ur_here}{/if}</h3>

<table class="table table-striped table-hide-edit" data-rowlink="a">
	<thead>
		<tr>
			<th class="w100">{t domain="payment"}名称{/t}</th>
			<th>{t domain="payment"}描述{/t}</th>
			<th class="w50">{t domain="payment"}排序{/t}</th>
			<th class="w80">{t domain="payment"}费用{/t}</th>
		</tr>
	</thead>
	<tbody>
		<!-- {foreach from=$modules item=module} -->
		<!-- {if $module.code neq "tenpayc2c"} -->
		<tr>
			<td >
				<!-- {if $module.enabled == 1} -->
					<span class="pay_name cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('payment/admin_plugin/edit_name')}" data-name="title" data-pk="{$module.id}"  data-title='{t domain="payment"}编辑支付方式名称{/t}'>{$module.name}</span>
				<!-- {else} -->
					{$module.name}
				<!-- {/if} -->
			</td>
			<td class="hide-edit-area">
				<!-- {if $module.enabled == 1} -->
					{$module.desc|nl2br}
					<div class="edit-list">
						<a class="data-pjax" href='{RC_Uri::url("payment/admin_plugin/edit", "code={$module.code}")}' title='{t domain="payment"}编辑{/t}'>{t domain="payment"}编辑{/t}</a>&nbsp;|&nbsp;
						<a class="switch ecjiafc-red" href="javascript:;" data-url='{RC_Uri::url("payment/admin_plugin/disable", "code={$module.code}")}' title='{t domain="payment"}禁用{/t}'>{t domain="payment"}禁用{/t}</a>
					</div>
				<!-- {else} -->
					{$module.desc|nl2br}
					<div class="edit-list">
						<a class="switch" href="javascript:;" data-url='{RC_Uri::url("payment/admin_plugin/enable", "code={$module.code}")}' title='{t domain="payment"}启用{/t}'>{t domain="payment"}启用{/t}</a>
					</div>
				<!-- {/if} -->
			</td>
			<td>
				<!-- {if $module.enabled == 1} -->
				<span class="pay_order cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('payment/admin_plugin/edit_order')}" data-name="title" data-pk="{$module.id}" data-title='{t domain="payment"}编辑支付方式排序{/t}'>{$module.pay_order}</span>
				<!-- {else} -->
				{$module.pay_order}
				<!-- {/if} -->
			</td>
			<td>
				<!-- {if $module.is_cod} -->
					{t domain="payment"}配送决定{/t}
				<!-- {else} -->
					{$module.pay_fee}
				<!-- {/if} -->
			</td>
		</tr>
		<!-- {/if} -->
		<!-- {foreachelse} -->
		<tr><td class="no-records" colspan="4">{t domain="payment"}没有找到任何记录{/t}</td></tr>
		<!-- {/foreach} -->
	</tbody>
</table>	
<!-- {/block} -->