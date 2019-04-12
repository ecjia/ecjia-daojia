<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.admin_ship_ecjia_express.init();
</script>
<!-- {/block} -->

<!-- {block name="admin_config_form"} -->
<div class="row-fluid edit-page">
    <h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
	
	<div class="row-fluid">
		<form method="post" class="form-horizontal" action="{$form_action}" name="shippingForm">
			<fieldset>
			<!-- {foreach from=$fields item=field} -->
				{if $in && $field.name == 'fee_compute_mode'}
					<div class="control-group formSep" id="{$field.name}">
						<label class="control-label">{$field.label}</label>
						<div class="controls">
							<input type="radio" id="fee_compute_mode_by_weight" name="fee_compute_mode" {if $field.value eq 'by_weight'}checked{/if} value="by_weight" data-code="{$shipping_area.shipping_code}"/>
							<label for="fee_compute_mode_by_weight">{t domain="express"}按重量{/t}</label>
							<input type="radio" id="fee_compute_mode_by_number" name="fee_compute_mode" {if $field.value eq 'by_number'}checked{/if} value="by_number" data-code="{$shipping_area.shipping_code}"/>
							<label for="fee_compute_mode_by_number">{t domain="express"}按件数{/t}</label>
						</div>
					</div>
				{/if}
				
				{if $config.fee_compute_mode == 'by_number'}
					{if $field.name == 'item_fee' || $field.name == 'free_money' || $field.name == 'pay_fee'}
						<div class="control-group formSep" id="{$field.name}">
							<label class="control-label">{$field.label}</label>
							<div class="controls">
								<input class="w350" name="{$field.name}" type="text" value="{if $config.value}{$config.value}{else}{if $field.value}{$field.value}{else}0{/if}{/if}"/>
								<span class="input-must">*</span>
							</div>
						</div>
					{else if $field.name != 'fee_compute_mode'}
						<div class="control-group formSep" id="{$field.name}">
							<label class="control-label">{$field.label}</label>
							<div class="controls">
								<input class="w350" name="{$field.name}" type="text" value="{if $config.value}{$config.value}{else}{if $field.value}{$field.value}{else}0{/if}{/if}"/>
								<span class="input-must">*</span>
							</div>
						</div>
					{/if}
				{else}
					{if $field.name != 'item_fee' && $field.name != 'fee_compute_mode' && $field.name != 'pay_fee'}
						<div class="control-group formSep" id="{$field.name}">
							<label class="control-label">{$field.label}</label>
							<div class="controls">
								<input class="w350" name="{$field.name}" type="text" value="{if $config.value}{$config.value}{else}{if $field.value}{$field.value}{else}0{/if}{/if}"/>
								<span class="input-must">*</span>
							</div>
						</div>
					{else if $field.name == 'item_fee'}
						<div class="control-group formSep" id="{$field.name}">
							<label class="control-label">{$field.label}</label>
							<div class="controls">
								<input class="w350" name="{$field.name}" type="text" value="{if $config.value}{$config.value}{else}{if $field.value}{$field.value}{else}0{/if}{/if}"/>
								<span class="input-must">*</span>
							</div>
						</div>
					{else if $field.name == 'pay_fee' && $shipping_data.support_cod eq 1}
						<div class="control-group formSep" id="{$field.name}">
							<label class="control-label">{$field.label}</label>
							<div class="controls">
								<input class="w350" name="{$field.name}" type="text" value="{if $config.value}{$config.value}{else}{if $field.value}{$field.value}{else}0{/if}{/if}"/>
							</div>
						</div>	
					{/if}
				{/if}
			<!-- {/foreach} -->
				
				<div class="control-group formSep" id="ship_days">
					<label class="control-label">{t domain="express"}下单后几天内配送：{/t}</label>
					<div class="controls">
						<input class="w350" name="ship_days" placeholder='{t domain="express"}请填写有效天数，最小单位为1{/t}' type="text" value="{$ship_days}" />
						<span class="help-block">{t domain="express"}默认7天以内配送（用户可选择的时间）{/t}</span>
					</div>
				</div>
				<div class="control-group formSep" id="last_order_time">
					<label class="control-label">{t domain="express"}提前下单时间：{/t}</label>
					<div class="controls">
						<input class="w350" name="last_order_time" placeholder='{t domain="express"}最小单位为分钟；如30{/t}' type="text" value="{$last_order_time}" />
						<span class="help-block">{t domain="express"}需比配送时间提前多久下单才能配送，否则匹配至下个配送时间{/t}</span>
					</div>
				</div>
				
				<div class="control-group formSep" id="ship_time">
					<label class="control-label">{t domain="express"}配送时间：{/t}</label>
					<div class="controls">
					<!-- {foreach from=$o2o_shipping_time item=shipping_time name=shipping} -->
						<div class='time-picker m_b10'>
                            {t domain="express"}从{/t}&nbsp;&nbsp;<input class="w100 tp_1" name="start_ship_time[]" type="text" value="{$shipping_time.start}" autocomplete="off" />&nbsp;&nbsp;
                            {t domain="express"}至{/t}&nbsp;&nbsp; <input class="w100 tp_1" name="end_ship_time[]" type="text" value="{$shipping_time.end}" autocomplete="off" />&nbsp;&nbsp;
							<!-- {if $smarty.foreach.shipping.last} -->
								<a class="no-underline" data-toggle="clone-obj" data-before="before" data-parent=".time-picker" href="javascript:;"><i class="fontello-icon-plus fa fa-plus"></i></a>
							<!-- {else} -->
								<a class="no-underline" href="javascript:;" data-parent=".time-picker" data-toggle="remove-obj"><i class="fontello-icon-cancel ecjiafc-red fa fa-times "></i></a>
							<!-- {/if} -->
						</div> 
					<!-- {foreachelse} --> 
						<div class='time-picker m_b10'>
							<input class="w100 tp_1" name="start_ship_time[]" type="text" value="{$time_field.start}"/>&nbsp;&nbsp;
                            {t domain="express"}至{/t}&nbsp;&nbsp; <input class="w100 tp_1" name="end_ship_time[]" type="text" value="{$time_field.end}" />&nbsp;&nbsp;
							<a class="no-underline" data-toggle="clone-obj" data-before="before" data-parent=".time-picker" href="javascript:;"><i class="fontello-icon-plus fa fa-plus"></i></a>
						</div> 
					<!-- {/foreach} --> 
						<span class="help-block">{t domain="express"}可设置多个配送时间段{/t}</span>
					</div>
				</div>
				
				<div class="control-group formSep" id="ship_time">
					<label class="control-label">{t domain="express"}配送费：{/t}</label>
					<div class="controls">
					<!-- {foreach from=$o2o_express item=express name=e} -->
						<div class='time-picker m_b10'>
                            {t domain="express"}距离{/t}&nbsp;&nbsp;<input class="w100" name="express_distance[]" type="text" value="{$express.express_distance}" autocomplete="off" />&nbsp;&nbsp;{t domain="express"}公里{/t}&nbsp;&nbsp;
                            {t domain="express"}配送费{/t}&nbsp;&nbsp;<input class="w100" name="express_money[]" type="text" value="{$express.express_money}" autocomplete="off" />&nbsp;&nbsp;{t domain="express"}元{/t}&nbsp;&nbsp;
							<!-- {if $smarty.foreach.e.last} -->
							<a class="no-underline" data-toggle="clone-obj" data-before="before" data-parent=".time-picker" href="javascript:;"><i class="fontello-icon-plus fa fa-plus"></i></a>
							<!-- {else} -->
							<a class="no-underline" href="javascript:;" data-parent=".time-picker" data-toggle="remove-obj"><i class="fontello-icon-cancel ecjiafc-red fa fa-times "></i></a>
							<!-- {/if} -->
						</div> 
					<!-- {foreachelse} --> 
						<div class='time-picker m_b10'>
                            {t domain="express"}距离{/t}&nbsp;&nbsp;<input class="w100" name="express_distance[]" type="text" />&nbsp;&nbsp;{t domain="express"}公里{/t}&nbsp;&nbsp;
                            {t domain="express"}配送费{/t}&nbsp;&nbsp;<input class="w100" name="express_money[]" type="text" />&nbsp;&nbsp;{t domain="express"}元{/t}&nbsp;&nbsp;
							<a class="no-underline" data-toggle="clone-obj" data-before="before" data-parent=".time-picker" href="javascript:;"><i class="fontello-icon-plus fa fa-plus"></i></a>
						</div> 
					<!-- {/foreach} --> 
						<span class="help-block">{t domain="express"}如首个距离设10公里，配送费设5元，表示在10公里内，用户需支付配送费5元，后面新增距离阶梯时必须大于上一个距离，比如上一个距离是10，再次增加时，填写的公里数必须大于10{/t}</span>
					</div>
				</div>
				
				<div class="control-group">
					<div class="controls">
						<input type="submit" value='{t domain="express"}确定{/t}' class="btn btn-gebo" />
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->