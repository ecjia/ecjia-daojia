<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.payrecord_info.init();
</script>
<style>
.wxpay-pay-fee:{
	display:none;
}
.surplus-pay-fee{
	display:none;
}
</style>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link} <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>{/if}
	</h3>
</div>

<!-- #BeginLibraryItem "/library/payrecord_step.lbi" --><!-- #EndLibraryItem -->
<form id="form-privilege" class="form-horizontal" name="theForm" action="{$form_action}" method="post" >
	<fieldset>
		<div class="row-fluid editpage-rightbar edit-page">
			<div class="left-bar">
				<h3>买家退款申请</h3>
				<div class="control-group">
					<label class="control-label">退款编号：</label>
					<div class="controls l_h30">{$refund_info.refund_sn}</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">退款类型：</label>
					<div class="controls l_h30">{if $refund_info.refund_type eq 'refund'}仅退款{elseif $refund_info.refund_type eq 'return'}退货退款{else}撤单退款{/if}</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">申请人：</label>
					<div class="controls l_h30">{$refund_info.user_name}{if $refund_info.referer eq 'merchant'}（商家申请）{/if}</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">退款原因：</label>
					<div class="controls l_h30">
					<!-- {foreach from=$reason_list key=key item=val} -->
	 				{if $key eq $refund_info.refund_reason}{$val}{/if}
					<!-- {/foreach} -->
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">退款金额：</label>
					<div class="controls l_h30 ecjiafc-red ecjiafc-font">{$payrecord_info.order_money_paid_type}</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">退款说明：</label>
					<div class="controls l_h30">{if $refund_info.refund_content}{$refund_info.refund_content}{else}暂无{/if}</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">上传凭证：</label>
					<div class="controls l_h30 refund_content">
						{if $refund_img_list}
						<!-- {foreach from=$refund_img_list item=list} -->
				            <a class="up-img no-underline" href="{RC_Upload::upload_url()}/{$list.file_path}" title="{$list.file_name}">
								<img src="{RC_Upload::upload_url()}/{$list.file_path}"/>
							</a>
			            <!-- {/foreach} -->
			            {else}
			        	暂无
						{/if}
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">申请时间：</label>
					<div class="controls l_h30">{$refund_info.add_time}</div>
				</div>
				
				{if !$payrecord_info.action_back_content}
					<h3>退款操作</h3>
					{if $payrecord_info.back_pay_fee gt '0'}
						<div class="control-group {if $payrecord_info.back_pay_code eq 'pay_wxpay'}wxpay-pay-fee{/if}">
							<label class="control-label">退还支付手续费：</label>
							<div class="controls l_h30">{$payrecord_info.back_pay_fee_type}</div>
						</div>
				
						<div class="control-group  {if $payrecord_info.back_pay_code eq 'pay_wxpay'}surplus-pay-fee{/if}">
							<label class="control-label">扣除支付手续费：</label>
							<div class="controls l_h30">-{$payrecord_info.back_pay_fee_type}</div>
						</div>
					{/if}
					
					{if $payrecord_info.back_shipping_fee gt '0.00'}
					<div class="control-group">
						<label class="control-label">扣除配送费：</label>
						<div class="controls l_h30">-{$payrecord_info.back_shipping_fee_type}</div>
					</div>
					{/if}
					
					{if $payrecord_info.back_insure_fee gt '0.00'}
					<div class="control-group">
						<label class="control-label">扣除保价费：</label>
						<div class="controls l_h30">-{$payrecord_info.back_insure_fee_type}</div>
					</div>
					{/if}
					
					{if $payrecord_info.back_inv_tax gt '0.00'}
					<div class="control-group">
						<label class="control-label">退回发票费：</label>
						<div class="controls l_h30">{$payrecord_info.back_inv_tax_type}</div>
					</div>
					{/if}
					
					<div class="control-group">
						<label class="control-label">实际退款金额：</label>
						<div class="controls l_h30 ecjiafc-red ecjiafc-font real-refund-amount">{$payrecord_info.back_money_total_type}</div>
					</div>
					
					{if $payrecord_info.back_integral gt '0'}
					<div class="control-group">
						<label class="control-label">退回积分：</label>
						<div class="controls l_h30 ecjiafc-red ecjiafc-font"><strong>{$payrecord_info.back_integral}</strong></div>
					</div>
					{/if}
					
					<div class="control-group">
						<label class="control-label">退款方式：</label>
						<div class="controls back-logo-wrap">
						     <ul>
                                 {if $payrecord_info.back_pay_code eq 'pay_wxpay'}
                                 <li class="back-logo active" data-type="pay_wxpay" back_money_total="{$payrecord_info.back_money_total}" back_pay_fee="{$payrecord_info.back_pay_fee}">
                                     <img src="{$pay_wxpay_img}">
                                     <img class="back-logo-select" src="{$selected_img}">
                                 </li>
                                 {/if}
						         <li class="back-logo {if $payrecord_info.back_pay_code neq 'pay_wxpay'}active{/if}" data-type="surplus" back_money_total="{$payrecord_info.back_money_total}" back_pay_fee="{$payrecord_info.back_pay_fee}">
						             <img src="{$surplus_img}">
						             <img class="back-logo-select" src="{$selected_img}">
						         </li>
						     </ul>
						     <input name="back_type" value="{if $payrecord_info.back_pay_code eq 'pay_wxpay'}pay_wxpay{else}surplus{/if}" type="hidden">
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">操作备注：</label>
						<div class="controls">
							<textarea name="back_content" style="margin-bottom: 10px;" class="span10" placeholder="请输入退款备注"></textarea>
							<select class="form-control adm_reply_content w400">
		                        <option value="">请选择……</option>
								<option value="1">退款完成</option>
								<option value="2">退款金额已原路退回</option>
								<option value="3">已全额退款</option>
								<option value="4">金额已退回账户余额</option>
								<option value="5">退回商品金额及红包、积分</option>
							</select>
							<span class="input-must">*</span>
							<span class="help-block">可使用快捷用语</span>
						</div>
					</div>
	
					<div class="control-group">
						<div class="controls">
						    <button class="btn btn-gebo" type="submit">退款</button>
							<input type="hidden" name="id" value="{$payrecord_info.id}" />
							<input type="hidden" name="refund_id" value="{$payrecord_info.refund_id}" />
							<input type="hidden" name="refund_type" value="{$payrecord_info.refund_type}" />
							<input type="hidden" name="back_money_total" value="{$payrecord_info.real_back_money_total}" />
							<input type="hidden" name="back_integral" value="{$payrecord_info.back_integral}" />
						</div>
					</div>
				{else}
					<h3>平台退款详情</h3>
					<div class="control-group">
						<label class="control-label">平台确认：</label>
						<div class="controls l_h30">已退款</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">退款方式：</label>
						<div class="controls l_h30">{if $payrecord_info.action_back_type eq 'original'}原路退回{else}退回余额{/if}</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">应退款金额：</label>
						<div class="controls l_h30 ecjiafc-red ecjiafc-font">{$payrecord_info.order_money_paid_type}</div>
					</div>
					
					{if $payrecord_info.back_pay_fee gt '0'}
						{if $payrecord_info.action_back_type eq 'original'}
							<div class="control-group">
								<label class="control-label">退还支付手续费：</label>
								<div class="controls l_h30">{$payrecord_info.back_pay_fee_type}</div>
							</div>
						{else}
							<div class="control-group">
								<label class="control-label">扣除支付手续费：</label>
								<div class="controls l_h30">-{$payrecord_info.back_pay_fee_type}</div>
							</div>
						{/if}
					{/if}
					
					{if $payrecord_info.back_shipping_fee gt '0.00'}
					<div class="control-group">
						<label class="control-label">扣除配送费：</label>
						<div class="controls l_h30">-{$payrecord_info.back_shipping_fee_type}</div>
					</div>
					{/if}
					
					{if $payrecord_info.back_insure_fee gt '0.00'}
					<div class="control-group">
						<label class="control-label">扣除保价费：</label>
						<div class="controls l_h30">-{$payrecord_info.back_insure_fee_type}</div>
					</div>
					{/if}
					
					{if $payrecord_info.back_inv_tax gt '0.00'}
					<div class="control-group">
						<label class="control-label">退回发票费：</label>
						<div class="controls l_h30">{$payrecord_info.back_inv_tax_type}</div>
					</div>
					{/if}
					
					<div class="control-group">
						<label class="control-label">实际退款金额：</label>
						<div class="controls l_h30 ecjiafc-red ecjiafc-font"><strong>{$payrecord_info.back_money_total_type}</strong></div>
					</div>
					
					{if $payrecord_info.back_integral gt '0'}
						<div class="control-group">
							<label class="control-label">积分：</label>
							<div class="controls l_h30 ecjiafc-red ecjiafc-font"><strong>{$payrecord_info.back_integral}</strong></div>
						</div>
					{/if}
					
					<div class="control-group">
						<label class="control-label">退款备注：</label>
						<div class="controls l_h30">{$payrecord_info.action_back_content}</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">退款时间：</label>
						<div class="controls l_h30">{$payrecord_info.action_back_time}</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">操作人：</label>
						<div class="controls l_h30">{$payrecord_info.action_user_name}</div>
					</div>
				{/if}
			</div>

			<div class="right-bar move-mod">
				<div class="foldable-list move-mod-group" >
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#refund_goods_content">
								<strong>售后基本信息</strong>
							</a>
						</div>
						<div class="accordion-body in collapse reply_admin_list" id="refund_goods_content">
							<div class="accordion-inner">
							 	<div class="goods-content">
					           		<p>订单编号：{$refund_info.order_sn}</p>
					                <p>订单实付金额：{$refund_total_amount}</p>
					                <p><div class="order-money-info">
					                	{if $refund_info.goods_amount gt '0.00'}
						                <p>商品总金额：<span>{$refund_info.goods_amount_price}</span></p>
						                {/if}
						                
						                {if $refund_info.inv_tax gt '0.00'}
						                <p>发票税额：<span>{$refund_info.inv_tax_price}</span></p>
						                {/if}
						                
						                {if $refund_info.shipping_fee gt '0.00'}
						                <p>配送费用：<span>{$refund_info.shipping_fee_price}</span></p>
						                {/if}
						                
						                {if $refund_info.insure_fee gt '0.00'}
						                <p>保价费用：<span>{$refund_info.insure_fee_price}</span></p>
						                {/if}
						                
						                {if $refund_info.pay_fee gt '0.00'}
						                <p>支付费用：<span>{$refund_info.pay_fee_price}</span></p>
						                {/if}
						                
						                {if $refund_info.pack_fee gt '0.00'}
						                <p>包装费用：<span>{$refund_info.pack_fee_price}</span></p>
						                {/if}
						                
						                {if $refund_info.card_fee gt '0.00'}
						                <p>贺卡费用：<span>{$refund_info.card_fee_price}</span></p>
						                {/if}
						                
						                {if $refund_info.integral_money gt '0.00'}
						                <p>积分金额：<span>{$refund_info.integral_money_price}</span></p>
						                {/if}
						                
						                {if $refund_info.bonus gt '0.00'}
						                <p>红包金额：<span>{$refund_info.bonus_price}</span></p>
						                {/if}
						                
						                {if $refund_info.discount gt '0.00'}
						                <p>折扣金额：<span>{$refund_info.discount_price}</span></p>
						                {/if}
					                </div></p>
					                <p>是否配送：{if $refund_info.shipping_whether eq '1'}已配送{else}未配送{/if}</p>
					                <p>支付方式：{$refund_info.pay_name}</p>
					                <p>申请时间：{$refund_info.add_time}</p>
					                <p>审核时间：{if $payrecord_info.add_time}{$payrecord_info.add_time}{/if}</p>
					                <a target="_blank" id="order-info" href='{url path="refund/admin/refund_detail" args="refund_id={$refund_info.refund_id}"}'>点此处查看退款单详细信息 >></a>
						        </div>
							</div>
						</div>
					</div>
					{if $payment_refund}
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#payment_refund">
								<strong>退款流水</strong>
							</a>
						</div>
						<div class="accordion-body in collapse " id="payment_refund">
							<div class="accordion-inner">
							 	<div class="goods-content">
					           		<p>
                                       	 退款流水状态：{$payment_refund.label_refund_status}
                                    </p>
					           		{if $payment_refund.refund_status eq '11'}
					           			<p>退款失败原因：{$payment_refund.last_error_message}</p>
					           		{/if}
					                <p>退款订单流水号：{$payment_refund.refund_out_no}</p>
					                <p>支付公司退款流水号：{$payment_refund.refund_trade_no}</p>
					                <p>退款创建时间：{if $payment_refund.refund_create_time}{$payment_refund.refund_create_time}{/if}</p>
					                <p>退款确认时间：{if $payment_refund.refund_confirm_time}{$payment_refund.refund_confirm_time}{/if}</p>
					                <a target="_blank" id="order-info" href='{url path="payment/admin_payment_refund/payment_refund_info" args="id={$payment_refund.id}"}'>点此处查看退款流水详细信息 >></a>
						        </div>
							</div>
						</div>
					</div>
				    {/if}
				</div>
			</div>
		</div>
	</fieldset>
</form>

<!-- {/block} -->