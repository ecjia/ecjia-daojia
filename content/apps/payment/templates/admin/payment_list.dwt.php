<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.payment_list.list();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-hide-edit" data-rowlink="a">
			<thead>
				<tr>
					<th class="w100">{lang key='payment::payment.payment_name'}</th>
					<th>{lang key='payment::payment.payment_desc'}</th>
					<th class="w50">{lang key='system::system.sort_order'}</th>
					<th class="w80">{lang key='payment::payment.short_pay_fee'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$modules item=module} -->
				<!-- {if $module.code neq "tenpayc2c"} -->
				<tr>
					<td >
						<!-- {if $module.enabled == 1} -->
							<span class="pay_name cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('payment/admin/edit_name')}" data-name="title" data-pk="{$module.id}"  data-title="{lang key='payment::payment.edit_payment_name'}">{$module.name}</span>
						<!-- {else} -->
							{$module.name}
						<!-- {/if} -->
					</td>
					<td class="hide-edit-area">
						<!-- {if $module.enabled == 1} -->
							{$module.desc|nl2br}
							<div class="edit-list">
								<a class="data-pjax" href='{RC_Uri::url("payment/admin/edit", "code={$module.code}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
								<a class="switch ecjiafc-red" href="javascript:;" data-url='{RC_Uri::url("payment/admin/disable", "code={$module.code}")}' title="{lang key='payment::payment.disable'}">{lang key='payment::payment.disable'}</a>
							</div>
						<!-- {else} -->
							{$module.desc|nl2br}
							<div class="edit-list">
								<a class="switch" href="javascript:;" data-url='{RC_Uri::url("payment/admin/enable", "code={$module.code}")}' title="{lang key='payment::payment.enable'}">{lang key='payment::payment.enable'}</a>
							</div>
						<!-- {/if} -->
					</td>
					<td>
						<!-- {if $module.enabled == 1} -->
						<span class="pay_order cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('payment/admin/edit_order')}" data-name="title" data-pk="{$module.id}" data-title="{lang key='payment::payment.edit_payment_order'}">{$module.pay_order}</span>
						<!-- {else} -->
						{$module.pay_order}
						<!-- {/if} -->
					</td>
					<td>
						<!-- {if $module.is_cod} -->
							{lang key='payment::payment.decide_by_ship'}
						<!-- {else} -->
							{$module.pay_fee}
						<!-- {/if} -->
					</td>
				</tr>
				<!-- {/if} -->
				<!-- {foreachelse} -->
				<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>	
	</div>
</div>
<!-- {/block} -->