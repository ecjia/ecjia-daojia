{if $shipping_data.shipping_code != 'ship_cac'}
<!-- {foreach from=$fields item=field} -->
	{if $in && $field.name == 'fee_compute_mode'}
		<div class="form-group" id="{$field.name}">
			<label class="control-label col-lg-4">{$field.label}</label>
			<div class="controls col-lg-6">
				<input type="radio" id="fee_compute_mode_by_weight" name="fee_compute_mode" {if $field.value eq 'by_weight'}checked{/if} value="by_weight" data-code="{$shipping_data.shipping_code}"/>
				<label for="fee_compute_mode_by_weight">按重量</label>
				<input type="radio" id="fee_compute_mode_by_number" name="fee_compute_mode" {if $field.value eq 'by_number'}checked{/if} value="by_number" data-code="{$shipping_data.shipping_code}"/>
				<label for="fee_compute_mode_by_number">按件数</label>
			</div>
		</div>
	{/if}
	
	{if $config.fee_compute_mode == 'by_number'}
		{if $field.name == 'item_fee' || $field.name == 'free_money' || $field.name == 'pay_fee'}
			<div class="form-group" id="{$field.name}">
				<label class="control-label col-lg-4">{$field.label}</label>
				<div class="controls col-lg-6">
					<input class="form-control" name="{$field.name}" type="text" value="{if $config.value}{$config.value}{else}{if $field.value}{$field.value}{else}0{/if}{/if}"/>
				</div>
				<span class="input-must">*</span>
			</div>
		{else if $field.name != 'fee_compute_mode'}
			<div class="form-group" id="{$field.name}">
				<label class="control-label col-lg-4">{$field.label}</label>
				<div class="controls col-lg-6">
					<input class="form-control" name="{$field.name}" type="text" value="{if $config.value}{$config.value}{else}{if $field.value}{$field.value}{else}0{/if}{/if}"/>
				</div>
				<span class="input-must">*</span>
			</div>
		{/if}
	{else}
		{if $field.name != 'item_fee' && $field.name != 'fee_compute_mode' && $field.name != 'pay_fee'}
			<div class="form-group" id="{$field.name}">
				<label class="control-label col-lg-4">{$field.label}</label>
				<div class="controls col-lg-6">
					<input class="form-control" name="{$field.name}" type="text" value="{if $config.value}{$config.value}{else}{if $field.value}{$field.value}{else}0{/if}{/if}"/>
				</div>
				<span class="input-must">*</span>
			</div>
		{else if $field.name == 'item_fee'}
			<div class="form-group" id="{$field.name}">
				<label class="control-label col-lg-4">{$field.label}</label>
				<div class="controls col-lg-6">
					<input class="form-control" name="{$field.name}" type="text" value="{if $config.value}{$config.value}{else}{if $field.value}{$field.value}{else}0{/if}{/if}"/>
				</div>
				<span class="input-must">*</span>
			</div>
		{else if $field.name == 'pay_fee' && $shipping_data.support_cod eq 1}
			<div class="form-group" id="{$field.name}">
				<label class="control-label col-lg-4">{$field.label}</label>
				<div class="controls col-lg-6">
					<input class="form-control" name="{$field.name}" type="text" value="{if $config.value}{$config.value}{else}{if $field.value}{$field.value}{else}0{/if}{/if}"/>
				</div>
			</div>	
		{/if}
	{/if}
<!-- {/foreach} -->
{/if}

{if $shipping_data.shipping_code eq 'ship_o2o_express' || $shipping_data.shipping_code eq 'ship_ecjia_express'}
	<div class="form-group" id="ship_days">
		<label class="control-label col-lg-4">下单后几天内配送：</label>
		<div class="controls col-lg-6">
			<input class="form-control col-lg-3" name="ship_days" placeholder="请填写有效天数，最小单位为1" type="text" value="{$ship_days}" />
		</div>
		<div class="clear">
			<label class="control-label col-lg-4"></label>
			<span class="col-lg-6 help-block">默认7天以内配送（用户可选择的时间）</span>
		</div> 
	</div>
	<div class="form-group" id="last_order_time">
		<label class="control-label col-lg-4">提前下单时间：</label>
		<div class="controls col-lg-6">
			<input class="form-control" name="last_order_time" placeholder="最小单位为分钟；如30" type="text" value="{$last_order_time}" />
		 
		</div>
		<div class="clear">
			<label class="control-label col-lg-4"></label>
			<span class="col-lg-6 help-block">需比配送时间提前多久下单才能配送，否则匹配至下个配送时间</span>
		</div>
	</div>
	
	<div class="form-group" id="ship_time">
		<label class="control-label col-lg-4">配送时间：</label>
		<div class="controls col-lg-6">
		<!-- {foreach from=$o2o_shipping_time item=shipping_time name=shipping} -->
			<div class='time-picker'>
				从&nbsp;&nbsp;<input class="w100 form-control tp_1" name="start_ship_time[]" type="text" value="{$shipping_time.start}" autocomplete="off" />&nbsp;&nbsp;
				至&nbsp;&nbsp; <input class="w100 form-control tp_1" name="end_ship_time[]" type="text" value="{$shipping_time.end}" autocomplete="off" />&nbsp;&nbsp;
				<!-- {if $smarty.foreach.shipping.last} -->
					<a class="no-underline" data-toggle="clone-obj" data-before="before" data-parent=".time-picker" href="javascript:;"><i class="fontello-icon-plus fa fa-plus"></i></a>
				<!-- {else} -->
					<a class="no-underline" href="javascript:;" data-parent=".time-picker" data-toggle="remove-obj"><i class="fontello-icon-cancel ecjiafc-red fa fa-times "></i></a>
				<!-- {/if} -->
			</div> 
		<!-- {foreachelse} --> 
			<div class='time-picker'>
				<input class="w100 form-control tp_1" name="start_ship_time[]" type="text" value="{$time_field.start}"/>&nbsp;&nbsp;
				至&nbsp;&nbsp; <input class="w100 form-control tp_1" name="end_ship_time[]" type="text" value="{$time_field.end}" />&nbsp;&nbsp;
				<a class="no-underline" data-toggle="clone-obj" data-before="before" data-parent=".time-picker" href="javascript:;"><i class="fontello-icon-plus fa fa-plus"></i></a>
			</div> 
		<!-- {/foreach} --> 
			<span class="col-lg-6 help-block">可设置多个配送时间段</span>
		</div>
	</div>
	
	<div class="form-group" id="ship_time">
		<label class="control-label col-lg-4">配送费：</label>
		<div class="controls col-lg-8">
		<!-- {foreach from=$o2o_express item=express name=e} -->
			<div class='time-picker'>
				距离&nbsp;&nbsp;<input class="w100 form-control" name="express_distance[]" type="text" value="{$express.express_distance}" autocomplete="off" />&nbsp;&nbsp;公里&nbsp;&nbsp;
				配送费&nbsp;&nbsp;<input class="w100 form-control" name="express_money[]" type="text" value="{$express.express_money}" autocomplete="off" />&nbsp;&nbsp;元&nbsp;&nbsp;
				<!-- {if $smarty.foreach.e.last} -->
				<a class="no-underline" data-toggle="clone-obj" data-before="before" data-parent=".time-picker" href="javascript:;"><i class="fontello-icon-plus fa fa-plus"></i></a>
				<!-- {else} -->
				<a class="no-underline" href="javascript:;" data-parent=".time-picker" data-toggle="remove-obj"><i class="fontello-icon-cancel ecjiafc-red fa fa-times "></i></a>
				<!-- {/if} -->
			</div> 
		<!-- {foreachelse} --> 
			<div class='time-picker'>
				距离&nbsp;&nbsp;<input class="w100 form-control" name="express_distance[]" type="text" />&nbsp;&nbsp;公里&nbsp;&nbsp;
				配送费&nbsp;&nbsp;<input class="w100 form-control" name="express_money[]" type="text" />&nbsp;&nbsp;元&nbsp;&nbsp;
				<a class="no-underline" data-toggle="clone-obj" data-before="before" data-parent=".time-picker" href="javascript:;"><i class="fontello-icon-plus fa fa-plus"></i></a>
			</div> 
		<!-- {/foreach} --> 
			<span class="col-lg-10 help-block">如首个距离设10公里，配送费设5元，表示在10公里内，用户需支付配送费5元，后面新增距离阶梯时必须大于上一个距离，比如上一个距离是10，再次增加时，填写的公里数必须大于10</span>
		</div>
	</div>
{/if}
{if $shipping_data.shipping_code eq 'ship_cac'}
	<div class="form-group" id="pickup_days">
		<label class="control-label col-lg-4">下单后几天内取货：</label>
		<div class="controls col-lg-4">
			<input class="form-control col-lg-3" name="pickup_days" placeholder="请填写有效天数，最小单位为1" type="text" value="{$pickup_days}" />
		</div>
		<div class="clear">
			<label class="control-label col-lg-4"></label>
			<span class="col-lg-6 help-block">默认7天以内取货（用户可选择的时间）</span>
		</div> 
	</div>
	<div class="form-group" id="ship_time">
		<label class="control-label col-lg-4">取货时间：</label>
		<div class="controls col-lg-6">
		<!-- {foreach from=$cac_pickup_time item=pickup_time name=pickup} -->
			<div class='time-picker'>
				从&nbsp;&nbsp;<input class="w100 form-control tp_1" name="start_pickup_time[]" type="text" value="{$pickup_time.start}" autocomplete="off" />&nbsp;&nbsp;
				至&nbsp;&nbsp; <input class="w100 form-control tp_1" name="end_pickup_time[]" type="text" value="{$pickup_time.end}" autocomplete="off" />&nbsp;&nbsp;
				<!-- {if $smarty.foreach.pickup.last} -->
					<a class="no-underline" data-toggle="clone-obj" data-before="before" data-parent=".time-picker" href="javascript:;"><i class="fontello-icon-plus fa fa-plus"></i></a>
				<!-- {else} -->
					<a class="no-underline" href="javascript:;" data-parent=".time-picker" data-toggle="remove-obj"><i class="fontello-icon-cancel ecjiafc-red fa fa-times "></i></a>
				<!-- {/if} -->
			</div> 
		<!-- {foreachelse} --> 
			<div class='time-picker'>
				<input class="w100 form-control tp_1" name="start_pickup_time[]" type="text" value="{$time_field.start}"/>&nbsp;&nbsp;
				至&nbsp;&nbsp; <input class="w100 form-control tp_1" name="end_pickup_time[]" type="text" value="{$time_field.end}" />&nbsp;&nbsp;
				<a class="no-underline" data-toggle="clone-obj" data-before="before" data-parent=".time-picker" href="javascript:;"><i class="fontello-icon-plus fa fa-plus"></i></a>
			</div> 
		<!-- {/foreach} --> 
			<span class="col-lg-6 help-block">可设置多个取货时间段</span>
		</div>
  </div>
{/if}