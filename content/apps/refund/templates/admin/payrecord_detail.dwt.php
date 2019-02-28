<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.payrecord_info.init();
</script>

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
				<h3>{t domain="refund"}买家退款申请{/t}</h3>
				<div class="control-group">
					<label class="control-label">{t domain="refund"}退款编号：{/t}</label>
					<div class="controls l_h30">{$refund_info.refund_sn}</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">{t domain="refund"}退款类型：{/t}</label>
					<div class="controls l_h30">{if $refund_info.refund_type eq 'refund'}{t domain="refund"}仅退款{/t}{elseif $refund_info.refund_type eq 'return'}{t domain="refund"}退货退款{/t}{else}{t domain="refund"}撤单退款{/t}{/if}</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">{t domain="refund"}申请人：{/t}</label>
					<div class="controls l_h30">{$refund_info.user_name}{if $refund_info.referer eq 'merchant'}{t domain="refund"}（商家申请）{/t}{/if}</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">{t domain="refund"}退款原因：{/t}</label>
					<div class="controls l_h30">
					<!-- {foreach from=$reason_list key=key item=val} -->
	 				{if $key eq $refund_info.refund_reason}{$val}{/if}
					<!-- {/foreach} -->
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">{t domain="refund"}退款金额：{/t}</label>
					<div class="controls l_h30 ecjiafc-red ecjiafc-font">{$payrecord_info.order_money_paid_type}</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">{t domain="refund"}退款说明：{/t}</label>
					<div class="controls l_h30">{if $refund_info.refund_content}{$refund_info.refund_content}{else}{t domain="refund"}暂无{/t}{/if}</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">{t domain="refund"}上传凭证：{/t}</label>
					<div class="controls l_h30 refund_content">
						{if $refund_img_list}
						<!-- {foreach from=$refund_img_list item=list} -->
				            <a class="up-img no-underline" href="{RC_Upload::upload_url()}/{$list.file_path}" title="{$list.file_name}">
								<img src="{RC_Upload::upload_url()}/{$list.file_path}"/>
							</a>
			            <!-- {/foreach} -->
			            {else}
			        	{t domain="refund"}暂无{/t}
						{/if}
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="refund"}申请时间：{/t}</label>
					<div class="controls l_h30">{$refund_info.add_time}</div>
				</div>
				
				{if !$payrecord_info.action_back_content}
					<h3>{t domain="refund"}退款操作{/t}</h3>
					{if $payrecord_info.back_pay_fee gt '0'}
						<div class="control-group refund-original {if $payrecord_info.back_pay_type eq 'surplus'}refund-pay-fee{/if}">
							<label class="control-label">{t domain="refund"}退还支付手续费：{/t}</label>
							<div class="controls l_h30">{$payrecord_info.back_pay_fee_type}</div>
						</div>
				
						<div class="control-group refund-balance {if $payrecord_info.back_pay_type eq 'original'}refund-pay-fee{/if}">
							<label class="control-label">{t domain="refund"}扣除支付手续费：{/t}</label>
							<div class="controls l_h30">-{$payrecord_info.back_pay_fee_type}</div>
						</div>
					{/if}
					
					{if $payrecord_info.back_shipping_fee gt '0.00'}
					<div class="control-group">
						<label class="control-label">{t domain="refund"}扣除配送费：{/t}</label>
						<div class="controls l_h30">-{$payrecord_info.back_shipping_fee_type}</div>
					</div>
					{/if}
					
					{if $payrecord_info.back_insure_fee gt '0.00'}
					<div class="control-group">
						<label class="control-label">{t domain="refund"}扣除保价费：{/t}</label>
						<div class="controls l_h30">-{$payrecord_info.back_insure_fee_type}</div>
					</div>
					{/if}
					
					{if $payrecord_info.back_inv_tax gt '0.00'}
					<div class="control-group">
						<label class="control-label">{t domain="refund"}退回发票费：{/t}</label>
						<div class="controls l_h30">{$payrecord_info.back_inv_tax_type}</div>
					</div>
					{/if}
					
					<div class="control-group">
						<label class="control-label">{t domain="refund"}实际退款金额：{/t}</label>
						<div class="controls l_h30 ecjiafc-red ecjiafc-font real-refund-amount">{$payrecord_info.back_money_total_type}</div>
					</div>
					
					{if $payrecord_info.back_integral gt '0'}
					<div class="control-group">
						<label class="control-label">{t domain="refund"}退回积分：{/t}</label>
						<div class="controls l_h30 ecjiafc-red ecjiafc-font"><strong>{$payrecord_info.back_integral}</strong></div>
					</div>
					{/if}
					
					<div class="control-group">
						<label class="control-label">{t domain="refund"}退款方式：{/t}</label>
						<div class="controls back-logo-wrap">
						     <ul>

                                 <!--{if $payrecord_info.back_pay_type eq 'original'}-->
                                 <li class="back-logo active" data-type="original" back_money_total="{$payrecord_info.back_money_total}" back_pay_fee="{$payrecord_info.back_pay_fee}">
                                     <img src="{$original_img}">
                                     <img class="back-logo-select" src="{$selected_img}">
                                 </li>
                                <!--{/if}-->

						         <li class="back-logo {if $payrecord_info.back_pay_type neq 'original'}active{/if}" data-type="surplus" back_money_total="{$payrecord_info.back_money_total}" back_pay_fee="{$payrecord_info.back_pay_fee}">
						             <img src="{$surplus_img}">
						             <img class="back-logo-select" src="{$selected_img}">
						         </li>
						     </ul>
						     <input name="back_type" value="{if $payrecord_info.back_pay_type eq 'original'}original{else}surplus{/if}" type="hidden">
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">{t domain="refund"}操作备注：{/t}</label>
						<div class="controls">
							<textarea name="back_content" style="margin-bottom: 10px;" class="span10" placeholder='{t domain="refund"}请输入退款备注{/t}'></textarea>
							<select class="form-control adm_reply_content w400">
		                        <option value="">{t domain="refund"}请选择……{/t}</option>
								<option value="1">{t domain="refund"}退款完成{/t}</option>
								<option value="2">{t domain="refund"}退款金额已原路退回{/t}</option>
								<option value="3">{t domain="refund"}已全额退款{/t}</option>
								<option value="4">{t domain="refund"}金额已退回账户余额{/t}</option>
								<option value="5">{t domain="refund"}退回商品金额及红包、积分{/t}</option>
							</select>
							<span class="input-must">*</span>
							<span class="help-block">{t domain="refund"}可使用快捷用语{/t}</span>
						</div>
					</div>
	
					<div class="control-group">
						<div class="controls">
						    <button class="btn btn-gebo" type="submit">{t domain="refund"}退款{/t}</button>
							<input type="hidden" name="id" value="{$payrecord_info.id}" />
							<input type="hidden" name="refund_id" value="{$payrecord_info.refund_id}" />
							<input type="hidden" name="refund_type" value="{$payrecord_info.refund_type}" />
							<input type="hidden" name="back_money_total" value="{$payrecord_info.real_back_money_total}" />
							<input type="hidden" name="back_integral" value="{$payrecord_info.back_integral}" />
						</div>
					</div>
				{else}
					<h3>{t domain="refund"}平台退款详情{/t}</h3>
					<div class="control-group">
						<label class="control-label">{t domain="refund"}平台确认：{/t}</label>
						<div class="controls l_h30">{t domain="refund"}已退款{/t}</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">{t domain="refund"}退款方式：{/t}</label>
						<div class="controls l_h30">{if $payrecord_info.action_back_type eq 'original'}{t domain="refund"}原路退回{/t}{else}{t domain="refund"}退回余额{/t}{/if}</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">{t domain="refund"}应退款金额：{/t}</label>
						<div class="controls l_h30 ecjiafc-red ecjiafc-font">{$payrecord_info.order_money_paid_type}</div>
					</div>
					
					{if $payrecord_info.back_pay_fee gt '0'}
						{if $payrecord_info.action_back_type eq 'original'}
							<div class="control-group">
								<label class="control-label">{t domain="refund"}退还支付手续费：{/t}</label>
								<div class="controls l_h30">{$payrecord_info.back_pay_fee_type}</div>
							</div>
						{else}
							<div class="control-group">
								<label class="control-label">{t domain="refund"}扣除支付手续费：{/t}</label>
								<div class="controls l_h30">-{$payrecord_info.back_pay_fee_type}</div>
							</div>
						{/if}
					{/if}
					
					{if $payrecord_info.back_shipping_fee gt '0.00'}
					<div class="control-group">
						<label class="control-label">{t domain="refund"}扣除配送费：{/t}</label>
						<div class="controls l_h30">-{$payrecord_info.back_shipping_fee_type}</div>
					</div>
					{/if}
					
					{if $payrecord_info.back_insure_fee gt '0.00'}
					<div class="control-group">
						<label class="control-label">{t domain="refund"}扣除保价费：{/t}</label>
						<div class="controls l_h30">-{$payrecord_info.back_insure_fee_type}</div>
					</div>
					{/if}
					
					{if $payrecord_info.back_inv_tax gt '0.00'}
					<div class="control-group">
						<label class="control-label">{t domain="refund"}退回发票费：{/t}</label>
						<div class="controls l_h30">{$payrecord_info.back_inv_tax_type}</div>
					</div>
					{/if}
					
					<div class="control-group">
						<label class="control-label">{t domain="refund"}实际退款金额：{/t}</label>
						<div class="controls l_h30 ecjiafc-red ecjiafc-font"><strong>{$payrecord_info.back_money_total_type}</strong></div>
					</div>
					
					{if $payrecord_info.back_integral gt '0'}
						<div class="control-group">
							<label class="control-label">{t domain="refund"}积分：{/t}</label>
							<div class="controls l_h30 ecjiafc-red ecjiafc-font"><strong>{$payrecord_info.back_integral}</strong></div>
						</div>
					{/if}
					
					<div class="control-group">
						<label class="control-label">{t domain="refund"}退款备注：{/t}</label>
						<div class="controls l_h30">{$payrecord_info.action_back_content}</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">{t domain="refund"}退款时间：{/t}</label>
						<div class="controls l_h30">{$payrecord_info.action_back_time}</div>
					</div>
					
					<div class="control-group">
						<label class="control-label">{t domain="refund"}操作人：{/t}</label>
						<div class="controls l_h30">{$payrecord_info.action_user_name}</div>
					</div>
				{/if}
			</div>

			<div class="right-bar move-mod">
				<div class="foldable-list move-mod-group" >
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#refund_goods_content">
								<strong>{t domain="refund"}售后基本信息{/t}</strong>
							</a>
						</div>
						<div class="accordion-body in collapse reply_admin_list" id="refund_goods_content">
							<div class="accordion-inner">
							 	<div class="goods-content">
					           		<p>{t domain="refund"}订单编号：{/t}{$refund_info.order_sn}</p>
					                <p>{t domain="refund"}订单实付金额：{/t}{$refund_total_amount}</p>
					                <p><div class="order-money-info">
					                	{if $refund_info.goods_amount gt '0.00'}
						                <p>{t domain="refund"}商品总金额：{/t}<span>{$refund_info.goods_amount_price}</span></p>
						                {/if}
						                
						                {if $refund_info.inv_tax gt '0.00'}
						                <p>{t domain="refund"}发票税额：{/t}<span>{$refund_info.inv_tax_price}</span></p>
						                {/if}
						                
						                {if $refund_info.shipping_fee gt '0.00'}
						                <p>{t domain="refund"}配送费用：{/t}<span>{$refund_info.shipping_fee_price}</span></p>
						                {/if}
						                
						                {if $refund_info.insure_fee gt '0.00'}
						                <p>{t domain="refund"}保价费用：{/t}<span>{$refund_info.insure_fee_price}</span></p>
						                {/if}
						                
						                {if $refund_info.pay_fee gt '0.00'}
						                <p>{t domain="refund"}支付费用：{/t}<span>{$refund_info.pay_fee_price}</span></p>
						                {/if}
						                
						                {if $refund_info.pack_fee gt '0.00'}
						                <p>{t domain="refund"}包装费用：{/t}<span>{$refund_info.pack_fee_price}</span></p>
						                {/if}
						                
						                {if $refund_info.card_fee gt '0.00'}
						                <p>{t domain="refund"}贺卡费用：{/t}<span>{$refund_info.card_fee_price}</span></p>
						                {/if}
						                
						                {if $refund_info.integral_money gt '0.00'}
						                <p>{t domain="refund"}积分金额：{/t}<span>{$refund_info.integral_money_price}</span></p>
						                {/if}
						                
						                {if $refund_info.bonus gt '0.00'}
						                <p>{t domain="refund"}红包金额：{/t}<span>{$refund_info.bonus_price}</span></p>
						                {/if}
						                
						                {if $refund_info.discount gt '0.00'}
						                <p>{t domain="refund"}折扣金额：{/t}<span>{$refund_info.discount_price}</span></p>
						                {/if}
					                </div></p>
					                <p>{t domain="refund"}是否配送：{/t}{if $refund_info.shipping_whether eq '1'}{t domain="refund"}已配送{/t}{else}{t domain="refund"}未配送{/t}{/if}</p>
					                <p>{t domain="refund"}支付方式：{/t}{$refund_info.pay_name}</p>
					                <p>{t domain="refund"}申请时间：{/t}{$refund_info.add_time}</p>
					                <p>{t domain="refund"}审核时间：{/t}{if $payrecord_info.add_time}{$payrecord_info.add_time}{/if}</p>
					                <a target="_blank" id="order-info" href='{url path="refund/admin/refund_detail" args="refund_id={$refund_info.refund_id}"}'>{t domain="refund"}点此处查看退款单详细信息 >>{/t}</a>
						        </div>
							</div>
						</div>
					</div>
					{if $payment_refund}
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#payment_refund">
								<strong>{t domain="refund"}退款流水{/t}</strong>
							</a>
						</div>
						<div class="accordion-body in collapse " id="payment_refund">
							<div class="accordion-inner">
							 	<div class="goods-content">
					           		<p>
                                       	 {t domain="refund"}退款流水状态：{/t}{$payment_refund.label_refund_status}
                                    </p>
					           		{if $payment_refund.refund_status eq '11'}
					           			<p>{t domain="refund"}退款失败原因：{/t}{$payment_refund.last_error_message}</p>
					           		{/if}
					                <p>{t domain="refund"}退款订单流水号：{/t}{$payment_refund.refund_out_no}</p>
					                <p>{t domain="refund"}支付公司退款流水号：{/t}{$payment_refund.refund_trade_no}</p>
					                <p>{t domain="refund"}退款创建时间：{/t}{if $payment_refund.refund_create_time}{$payment_refund.refund_create_time}{/if}</p>
					                <p>{t domain="refund"}退款确认时间：{/t}{if $payment_refund.refund_confirm_time}{$payment_refund.refund_confirm_time}{/if}</p>
					                <a target="_blank" id="order-info" href='{url path="payment/admin_payment_refund/payment_refund_info" args="id={$payment_refund.id}"}'>{t domain="refund"}点此处查看退款流水详细信息 >>{/t}</a>
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