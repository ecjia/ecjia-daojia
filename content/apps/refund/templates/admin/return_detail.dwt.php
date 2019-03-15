<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.return_info.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link} <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>{/if}
	</h3>
</div>

<!-- #BeginLibraryItem "/library/return_step.lbi" --><!-- #EndLibraryItem -->

<div class="row-fluid editpage-rightbar">
	<div class="left-bar move-mod">
		<div class="foldable-list move-mod-group" >
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#refund_content">
						<strong>{t domain="refund"}买家退货退款申请{/t}</strong>
					</a>
				</div>
				<div class="accordion-body in collapse" id="refund_content">
					<div class="refund_content">
						<p>{t domain="refund"}退款编号：{/t}{$refund_info.refund_sn}</p>
						<p>{t domain="refund"}申请人：{/t}{$refund_info.user_name}{if $refund_info.referer eq 'merchant'}{t domain="refund"}（商家申请）{/t}{/if}</p>
						<p>{t domain="refund"}退款原因：{/t}
						<!-- {foreach from=$reason_list key=key item=val} -->
		 				{if $key eq $refund_info.refund_reason}{$val}{/if}
						<!-- {/foreach} -->
						</p>
						<p>{t domain="refund"}退款金额：{/t}<font class="ecjiafc-red ecjiafc-font">{$refund_total_amount}</font></p>
						<p>{t domain="refund"}退款说明：{/t}{if $refund_info.refund_content}{$refund_info.refund_content}{else}{t domain="refund"}暂无{/t}{/if}</p>
						<p>{t domain="refund"}上传凭证：{/t} 
							{if $refund_img_list}
							<!-- {foreach from=$refund_img_list item=list} -->
				                <a class="up-img no-underline" href="{RC_Upload::upload_url()}/{$list.file_path}" title="{$list.file_name}">
									<img src="{RC_Upload::upload_url()}/{$list.file_path}"/>
								</a>
			                <!-- {/foreach} -->
			                {else}
			            	{t domain="refund"}暂无{/t}
							{/if}
		                </p>
		                <p>{t domain="refund"}申请时间：{/t}{$refund_info.add_time}</p>
					</div>
				</div>
			</div>
			
			{if $refund_info.status eq '1' or $refund_info.status eq '11'}
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#mer_content">
							<strong>{t domain="refund"}商家退货退款意见{/t}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="mer_content">
						<div class="refund_content">
							<p>{t domain="refund"}处理状态：{/t}{if $refund_info.status eq '1'}{t domain="refund"}同意{/t}{elseif $refund_info.status eq '11'}{t domain="refund"}不同意{/t}{/if}</p>
							<p>{t domain="refund"}商家备注：{/t}{$action_mer_msg_return.action_note}</p>
							{if $range}
								<p>{t domain="refund"}可用退货方式：{/t}{$range}</p>
							{/if}
							<p>{t domain="refund"}操作人：{/t}{$action_mer_msg_return.action_user_name}</p>
							<p>{t domain="refund"}处理时间：{/t}{$action_mer_msg_return.log_time}</p>
						</div>
					</div>
				</div>
			{/if}
			
			{if $refund_info.return_status gt '1'}
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#return_shipping">
							<strong>{t domain="refund"}买家退货信息{/t}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="return_shipping">
						<div class="refund_content">
							{if $return_shipping_value.return_way_code eq 'home'}
								<p>{t domain="refund"}退货方式：{/t}{$return_shipping_value.return_way_name}</p>
								<p>{t domain="refund"}取件地址：{/t}{$return_shipping_value.pickup_address}</p>
								<p>{t domain="refund"}期望取件时间：{/t}{$return_shipping_value.expect_pickup_time}</p>
								<p>{t domain="refund"}联系人：{/t}{$return_shipping_value.contact_name}</p>
								<p>{t domain="refund"}联系电话：{/t}{$return_shipping_value.contact_phone}</p>
							{elseif $return_shipping_value.return_way_code eq 'express'}
								<p>{t domain="refund"}退货方式：{/t}{$return_shipping_value.return_way_name}</p>
								<p>{t domain="refund"}收件人：{/t}{$return_shipping_value.recipients}</p>
								<p>{t domain="refund"}联系方式：{/t}{$return_shipping_value.contact_phone}</p>
								<p>{t domain="refund"}收件地址：{/t}{$return_shipping_value.recipient_address}</p>
								<p>{t domain="refund"}快递名称：{/t}{$return_shipping_value.shipping_name}</p>
								<p>{t domain="refund"}快递单号：{/t}{$return_shipping_value.shipping_sn}</p>
							{else}
								<p>{t domain="refund"}退货方式：{/t}{$return_shipping_value.return_way_name}</p>
								<p>{t domain="refund"}店铺名称：{/t}{$return_shipping_value.store_name}</p>
								<p>{t domain="refund"}联系方式：{/t}{$return_shipping_value.contact_phone}</p>
								<p>{t domain="refund"}店铺地址：{/t}{$return_shipping_value.store_address}</p>
							{/if}
						</div>
					</div>
				</div>
			{/if}
			
			<!-- 商家已发货 -->
		    {if $refund_info.return_status eq '3' or $refund_info.return_status eq '11'}
		    	<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#mer_content">
							<strong>{t domain="refund"}商家确认收货意见{/t}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="mer_content">
						<div class="refund_content">
							<p>{t domain="refund"}处理状态：{/t}{if $refund_info.return_status eq '3'}{t domain="refund"}确认收货{/t}{elseif $refund_info.return_status eq '11'}{t domain="refund"}未收到货{/t}<{/if}</p>
							<p>{t domain="refund"}商家备注：{/t}{$action_mer_msg_confirm.action_note}</p>
							<p>{t domain="refund"}操作人：{/t}{$action_mer_msg_confirm.action_user_name}</p>
							<p>{t domain="refund"}处理时间：{/t}{$action_mer_msg_confirm.log_time}</p>
						</div>
					</div>
				</div>  
				{if $refund_info.return_status eq '3' and $refund_info.refund_status eq '1'}
					<div style="margin-top: 20px;">
						{t domain="refund"}退款操作：{/t}<a href='{url path="refund/admin_payrecord/detail" args="refund_id={$refund_info.refund_id}"}' class="data-pjax"><button class="btn btn-gebo" type="button">{t domain="refund"}去退款{/t}</button>  </a>     
					</div>
				{/if}
	        {/if}
			
			<!-- 平台已打款 -->			
			{if $refund_info.refund_status eq '2' }
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#admin_content">
							<strong>{t domain="refund"}商城平台退款审核{/t}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="admin_content">
						<div class="refund_content">
							<p>{t domain="refund"}平台确认：已退款{/t}</p>
							<p>{t domain="refund"}平台备注：{/t}{$action_admin_msg.action_note}</p>
							<p>{t domain="refund"}操作人：{/t}{$action_admin_msg.action_user_name}</p>
							<p>{t domain="refund"}处理时间：{/t}{$action_admin_msg.log_time}</p>
						</div>
					</div>
				</div>
				
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#admin_content">
							<strong>{t domain="refund"}商城平台退款详情{/t}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="admin_content">
						<div class="refund_content">
							<p>{t domain="refund"}退款方式：{/t}{if $payrecord_info.action_back_type eq 'original'}{t domain="refund"}原路退回{/t}{else}{t domain="refund"}退回余额{/t}{/if}</p>
							<p>{t domain="refund"}应退款金额：{/t}<font class="ecjiafc-red ecjiafc-font">{$payrecord_info.order_money_paid_type}</font></p>
							{if $payrecord_info.back_pay_fee gt '0.00'}
								<p>{t domain="refund"}扣除支付手续费：{/t}-{$payrecord_info.back_pay_fee_type}</p>
							{/if}
							
							{if $payrecord_info.back_shipping_fee gt '0.00'}
								<p>{t domain="refund"}扣除配送费：{/t}-{$payrecord_info.back_shipping_fee_type}</p>
							{/if}
							
							{if $payrecord_info.back_insure_fee gt '0.00'}
								<p>{t domain="refund"}扣除保价费：{/t}-{$payrecord_info.back_insure_fee_type}</p>
							{/if}
							
							{if $payrecord_info.back_inv_tax gt '0.00'}
								<p>{t domain="refund"}退回发票费：{/t}{$payrecord_info.back_inv_tax_type}</p>
							{/if}
							
							<p>{t domain="refund"}实际退款金额：{/t}<font class="ecjiafc-red ecjiafc-font">{$payrecord_info.back_money_total_type}</font></p>
							{if $payrecord_info.back_integral gt '0'}
								<p>{t domain="refund"}积分：{/t}<font class="ecjiafc-red ecjiafc-font">{$payrecord_info.back_integral}</font></p>
							{/if}
							<p>{t domain="refund"}退款时间：{/t}{$payrecord_info.action_back_time}</p>
						</div>
					</div>
				</div>
			{/if}
		</div>
	</div>
	
	<div class="right-bar move-mod">
		<div class="foldable-list move-mod-group edit-page" >
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#refund_mer_content">
						<strong>{t domain="refund"}店铺信息{/t}</strong>
					</a>
				</div>
				<div class="accordion-body in in_visable collapse" id="refund_mer_content">
					<div class="accordion-inner">
					   <div class="merchant_content">
							<div class="list-top">
								<img src="{if $mer_info.img}{RC_Upload::upload_url()}/{$mer_info.img}{else}{RC_Uri::admin_url('statics/images/nopic.png')}{/if}"><span>{$mer_info.merchants_name}</span>
							</div>
							<div class="list-mid">
								<p><font class="ecjiafc-red">{$mer_info.count.refund_count}</font><br>{t domain="refund"}仅退款{/t}</p>
								<p><font class="ecjiafc-red">{$mer_info.count.return_count}</font><br>{t domain="refund"}退款退货{/t}</p>
							</div>
							
							<div class="list-bot">
								<div><label>{t domain="refund"}营业时间：{/t}</label>{$mer_info.shop_trade_time.start}-{$mer_info.shop_trade_time.end}</div>
								<div><label>{t domain="refund"}商家电话：{/t}</label>{$mer_info.shop_kf_mobile}</div>
								<div><label>{t domain="refund"}商家地址：{/t}</label>{$mer_info.address}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="foldable-list move-mod-group" >
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#refund_goods_content">
						<strong>{t domain="refund"}已收货商品{/t}</strong>
					</a>
				</div>
				<div class="accordion-body in collapse reply_admin_list" id="refund_goods_content">
					<div class="accordion-inner">
					 	<div class="goods-content">
					 		{if $goods_list}
				           		<!-- {foreach from=$goods_list item=list} -->
				           		<div class="goods-info">
				           			<div class="goods-img">
					           			<img src="{$list.image}">
						           	</div>
					           		<div class="goods-desc">
					           			 <p>{$list.goods_name}</p>
					           			 <p>{$list.goods_price}&nbsp;&nbsp;&nbsp;x{$list.goods_number}</p>
					           		</div>
				           		</div>
				           		<!-- {/foreach} -->
				           		<hr>
			           		{/if}
			                {if $order_data}
				                <p>{t domain="refund"}订单实付金额：{/t}{$order_money_total} <span><a id="order-money-info" href="javascript:;">{t domain="refund"}查看更多{/t}</a></span></p>
				                <div class="order-money-info" style="display: none;">
				                	{if $order_info.goods_amount gt '0.00'}
					                <p>{t domain="refund"}商品总金额：{/t}<span>{$order_info.goods_amount_price}</span></p>
					                {/if}
					                
					                {if $order_info.tax gt '0.00'}
					                <p>{t domain="refund"}发票税额：{/t}<span>{$order_info.tax_price}</span></p>
					                {/if}
					                
					                {if $order_info.shipping_fee gt '0.00'}
					                <p>{t domain="refund"}配送费用：{/t}<span>{$order_info.shipping_fee_price}</span></p>
					                {/if}
					                
					                {if $order_info.insure_fee gt '0.00'}
					                <p>{t domain="refund"}保价费用：{/t}<span>{$order_info.insure_fee_price}</span></p>
					                {/if}
					                
					                {if $order_info.pay_fee gt '0.00'}
					                <p>{t domain="refund"}支付费用：{/t}<span>{$order_info.pay_fee_price}</span></p>
					                {/if}
					                
					                {if $order_info.pack_fee gt '0.00'}
					                <p>{t domain="refund"}包装费用：{/t}<span>{$order_info.pack_fee_price}</span></p>
					                {/if}
					                
					                {if $order_info.card_fee gt '0.00'}
					                <p>{t domain="refund"}贺卡费用：{/t}<span>{$order_info.card_fee_price}</span></p>
					                {/if}
					                
					                {if $order_info.integral_money gt '0.00'}
					                <p>{t domain="refund"}积分金额：{/t}<span>{$order_info.integral_money_price}</span></p>
					                {/if}
					                
					                {if $order_info.bonus gt '0.00'}
					                <p>{t domain="refund"}红包金额：{/t}<span>{$order_info.bonus_price}</span></p>
					                {/if}
					                
					                {if $order_info.discount gt '0.00'}
					                <p>{t domain="refund"}折扣金额：{/t}<span>{$order_info.discount_price}</span></p>
					                {/if}
				                </div>
				                <hr>
				                <p>{t domain="refund"}订单编号：{/t}<a target="_blank" href='{url path="orders/admin/info" args="order_id={$order_info.order_id}"}'>{$order_info.order_sn}</a><span><a id="order-info" href="javascript:;">{t domain="refund"}查看更多{/t}</a></span></p>
				                 <div class="order-info" style="display: none;">
					                <p>{t domain="refund"}支付方式：{/t}{$order_info.pay_name}</p>
					                <p>{t domain="refund"}下单时间：{/t}{$order_info.add_time}</p>
					                <p>{t domain="refund"}付款时间：{/t}{$order_info.pay_time}</p>
				                </div>
				                <hr>
				                <p>{t domain="refund"}收货人：{/t}{$order_info.consignee}<span><a id="address-info" href="javascript:;">{t domain="refund"}查看更多{/t}</a></span></p>
				                <div class="address-info" style="display: none;">
					                <p>{t domain="refund"}收货地址：{/t}{$order_info.province}{$order_info.city}{$order_info.district}{$order_info.street}{$order_info.address}</p>
					                <p>{t domain="refund"}联系电话：{/t}{$order_info.mobile}</p>
				                </div>
			                {else}
				                <p>{t domain="refund"}订单实付金额：{/t}{$refund_total_amount} <span><a id="order-money-info" href="javascript:;">{t domain="refund"}查看更多{/t}</a></span></p>
				                <div class="order-money-info" style="display: none;">
				                	{if $refund_info.goods_amount gt '0.00'}
					                <p>{t domain="refund"}商品总金额：{/t}<span>{$refund_info.goods_amount_price}</span></p>
					                {/if}
					                
					                {if $refund_info.tax gt '0.00'}
					                <p>{t domain="refund"}发票税额：{/t}<span>{$refund_info.tax_price}</span></p>
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
				                </div>
				                <hr>
				                <p>{t domain="refund"}订单编号：{/t}<a target="_blank" href='{url path="orders/admin/info" args="order_id={$refund_info.order_id}"}'>{$refund_info.order_sn}</a><span><a id="order-info" href="javascript:;">{t domain="refund"}查看更多{/t}</a></span></p>
				                 <div class="order-info" style="display: none;">
					                <p>{t domain="refund"}支付方式：{/t}{$refund_info.pay_name}</p>
				                </div>
			                {/if}
				        </div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="foldable-list move-mod-group" >
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#refund_goods_content2">
						<strong>{t domain="refund"}申请退货商品{/t}</strong>
					</a>
				</div>
				<div class="accordion-body in collapse reply_admin_list" id="refund_goods_content2">
					<div class="accordion-inner">
					 	<div class="goods-content">
			           		<!-- {foreach from=$refund_list item=list} -->
			           		<div class="goods-info">
			           			<div class="goods-img">
				           			<img src="{$list.image}">
					           	</div>
				           		<div class="goods-desc">
				           			 <p>{$list.goods_name}</p>
				           			 <p>{$list.goods_price}&nbsp;&nbsp;&nbsp;x{$list.send_number}</p>
				           		</div>
			           		</div>
			           		<!-- {/foreach} -->
				        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->