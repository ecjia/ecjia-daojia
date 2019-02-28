<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.order_merge.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info">	
	<strong>当两个订单不一致时，合并后的订单信息（如：支付方式、配送方式、包装、贺卡、红包等）以主订单为准。</strong>
</div>

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" id="form-privilege" name="theForm" method="post" action="{$form_action}" data-pjax-url='{url path="orders/admin/merge"}'>
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">主订单：</label>
					<div class="controls">
						<input name="to_order_sn" type="text" id="to_order_sn" class="f_l m_r5"/>
						<select name="to_list" id="to_list" >
							<option value="">请选择...</option>
							<!-- {foreach from=$order_list item=order} -->
							<option value="{$order.order_sn}">{$order.order_sn} {if $order.user_name}[{$order.user_name}]{else}[匿名]{/if}</option>
							<!-- {/foreach} -->
						</select>
						<span class="input-must">*</span>
						<span class="help-block" {if $help_open}style="display:block" {else} style="display:none" {/if} id="noticeOrderSn">当两个订单不一致时，合并后的订单信息（如：支付方式、配送方式、包装、贺卡、红包等）以主订单为准。</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">从订单：</label>
					<div class="controls">
						<input name="from_order_sn" type="text" id="from_order_sn" class="f_l m_r5"/>
						<select name="from_list" id="from_list" >
							<option value="">请选择...</option>
							<!-- {foreach from=$order_list item=order} -->
							<option value="{$order.order_sn}">{$order.order_sn} {if $order.user_name}[{$order.user_name}]{else}[匿名]{/if}</option>
							<!-- {/foreach} -->
						</select>
						<span class="input-must">*</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">合并</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->