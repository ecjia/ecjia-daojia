<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.push_config_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_config_form"} -->
<div class="row-fluid edit-page">
    <h3 class="heading">
		平台消息配置
		{if $action_link}
		<a class="btn data-pjax plus_or_reply" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
	<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
		<div class="row-fluid">
			<div class="control-group formSep">
				<label class="control-label">{lang key='push::push.label_app_name'}</label>
				<div class="controls">
					<input type='text' name='app_name' value="{$config_appname}"/> 
					<span class="input-must">{lang key='system::system.require_field'}</span>
					<span class="help-block">{lang key='push::push.app_name_help'}</span> 
				</div>
			</div>
			
			<div class="control-group formSep edit-page">
				<label class="control-label">{lang key='push::push.label_push_development'}</label>
				<div class="controls chk_radio">
					<input type="radio" name="app_push_development" value="1" {if $config_apppush eq 1} checked="true" {/if}/>{lang key='push::push.dev_environment'}
					<input type="radio" name="app_push_development" value="0" {if $config_apppush eq 0} checked="true" {/if}/>{lang key='push::push.produce_environment'}
					<span class="help-block">{lang key='push::push.push_development_help'}</span> 
				</div>
			</div>
			<div>
				<h3 class="heading">
					商家消息配置
				</h3>
			</div>
			<div class="control-group edit-page">
				<label class="control-label">{lang key='push::push.label_client_order'}</label>
				<div class="controls chk_radio">
					<input type="radio" name="config_order" value="1" {if $config_pushplace eq 1} checked="true" {/if}/>{lang key='push::push.push'}
					<input type="radio" name="config_order" value="0" {if $config_pushplace eq 0} checked="true" {/if}/>{lang key='push::push.not_push'}  
					<span class="help-block">{lang key='push::push.client_order_help'}</span> 
				</div>
			</div>
			<div class="control-group formSep">
				<div class="controls control-group draggable">
					<select name='push_order_placed_apps'>
						<option value=''>{lang key='push::push.pls_select_push_event'}</option>
						<!-- {foreach from=$push_event item=item} -->
						<option value="{$item.event_code}" {if $apps_group_order eq $item.event_code}selected="true"{/if}>{$item.event_name}</option>
						<!-- {/foreach} -->
					</select>
				</div>
			</div>
			<div class="control-group edit-page">
				<label class="control-label">{lang key='push::push.label_client_pay'}</label>
				<div class="controls chk_radio">
					<input type="radio" name="config_money" value="1" {if $config_pushpay eq 1} checked="true" {/if}/>{lang key='push::push.push'}
					<input type="radio" name="config_money" value="0" {if $config_pushpay eq 0} checked="true" {/if}/>{lang key='push::push.not_push'}  
					<span class="help-block">{lang key='push::push.client_pay_help'}</span>
				</div>
			</div>
			<div class="control-group formSep">
				<div class="controls control-group draggable">
					<select name='push_order_payed_apps'>
						<option value=''>{lang key='push::push.pls_select_push_event'}</option>
						<!-- {foreach from=$push_event item=item} -->
						<option value="{$item.event_code}"  {if $apps_group_payed eq $item.event_code}selected="true"{/if}>{$item.event_name}</option>
						<!-- {/foreach} -->
					</select>
				</div>
			</div>
			<div>
				<h3 class="heading">
					客户消息配置
				</h3>
			</div>
			<div class="control-group edit-page">
				<label class="control-label">{lang key='push::push.label_seller_shipping'}</label>
				<div class="controls chk_radio">
					<input type="radio" name="config_shipping" value="1" {if $config_pushship eq 1} checked="true" {/if}/>{lang key='push::push.push'}
					<input type="radio" name="config_shipping" value="0" {if $config_pushship eq 0} checked="true" {/if}/>{lang key='push::push.not_push'}
					<span class="help-block">{lang key='push::push.seller_shipping_help'}</span>
				</div>
			</div>
			<div class="control-group formSep">
				<div class="controls control-group draggable">
					<select name='push_order_shipped_apps'>
						<option value=''>{lang key='push::push.pls_select_push_event'}</option>
						<!-- {foreach from=$push_event item=item} -->
						<option value="{$item.event_code}"  {if $apps_group_shipped eq $item.event_code}selected="true"{/if}>{$item.event_name}</option>
						<!-- {/foreach} -->
					</select>
				</div>
			</div>
			<div>
				<h3 class="heading">
					配送员消息配置
				</h3>
			</div>
			<div class="control-group edit-page">
				<label class="control-label">系统派单通知：</label>
				<div class="controls chk_radio">
					<input type="radio" name="push_express_assign" value="1" {if $push_express_assign eq 1} checked="true" {/if}/>{lang key='push::push.push'}
					<input type="radio" name="push_express_assign" value="0" {if $push_express_assign eq 0} checked="true" {/if}/>{lang key='push::push.not_push'}
					<span class="help-block">系统派单后，向所属配送员进行推送通知。</span>
				</div>
			</div>
			<div class="control-group formSep">
				<div class="controls control-group draggable">
					<select name='push_express_assign_event'>
						<option value=''>{lang key='push::push.pls_select_push_event'}</option>
						<!-- {foreach from=$push_event item=item} -->
						<option value="{$item.event_code}"  {if $push_express_assign_event eq $item.event_code}selected="true"{/if}>{$item.event_name}</option>
						<!-- {/foreach} -->
					</select>
				</div>
			</div>
			<div class="control-group edit-page">
				<label class="control-label">抢单成功通知：</label>
				<div class="controls chk_radio">
					<input type="radio" name="push_express_grab" value="1" {if $push_express_grab eq 1} checked="true" {/if}/>{lang key='push::push.push'}
					<input type="radio" name="push_express_grab" value="0" {if $push_express_grab eq 0} checked="true" {/if}/>{lang key='push::push.not_push'}
					<span class="help-block">配送员抢单成功后，向所属配送员进行推送通知。</span>
				</div>
			</div>
			<div class="control-group formSep">
				<div class="controls control-group draggable">
					<select name='push_express_grab_event'>
						<option value=''>{lang key='push::push.pls_select_push_event'}</option>
						<!-- {foreach from=$push_event item=item} -->
						<option value="{$item.event_code}"  {if $push_express_grab_event eq $item.event_code}selected="true"{/if}>{$item.event_name}</option>
						<!-- {/foreach} -->
					</select>
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls">
					<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
				</div>
			</div>
		</div>
	</form>
</div>

<!-- {/block} -->