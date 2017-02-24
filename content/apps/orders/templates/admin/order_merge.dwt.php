<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.order_merge.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info">	
	<strong>{lang key='orders::order.notice_order_sn'}</strong>
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
					<label class="control-label">{lang key='orders::order.to_order_sn'}</label>
					<div class="controls">
						<input name="to_order_sn" type="text" id="to_order_sn" class="f_l m_r5"/>
						<select name="to_list" id="to_list" >
							<option value="">{lang key='system::system.select_please'}</option>
							<!-- {foreach from=$order_list item=order} -->
							<option value="{$order.order_sn}">{$order.order_sn} {if $order.user_name}[{$order.user_name}]{else}[匿名]{/if}</option>
							<!-- {/foreach} -->
						</select>
						<span class="input-must">{lang key='system::system.require_field'}</span>
						<span class="help-block" {if $help_open}style="display:block" {else} style="display:none" {/if} id="noticeOrderSn">{lang key='orders::order.notice_order_sn'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='orders::order.from_order_sn'}</label>
					<div class="controls">
						<input name="from_order_sn" type="text" id="from_order_sn" class="f_l m_r5"/>
						<select name="from_list" id="from_list" >
							<option value="">{lang key='system::system.select_please'}</option>
							<!-- {foreach from=$order_list item=order} -->
							<option value="{$order.order_sn}">{$order.order_sn} {if $order.user_name}[{$order.user_name}]{else}[匿名]{/if}</option>
							<!-- {/foreach} -->
						</select>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{lang key='orders::order.merge'}</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->