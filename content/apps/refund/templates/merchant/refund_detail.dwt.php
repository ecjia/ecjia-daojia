<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.refund_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<!-- #BeginLibraryItem "/library/refund_step.lbi" --><!-- #EndLibraryItem -->
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">
        <!-- {if $ur_here}{$ur_here}{/if} -->
      	 {if $action_link}
	        <a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fa fa-reply"></i> {$action_link.text}</a>
	        {/if}
        </h2>
    </div>
</div>

<div class="row" id="home-content">
    <div class="col-lg-8">
        <section class="panel panel-body">
            <h4>{t domain="refund"}买家退款申请{/t}</h4>
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
        </section>
        
        {if $refund_info.status eq '1' or $refund_info.status eq '11'}
	        <section class="panel panel-body">
				<h4>{t domain="refund"}商家退款意见{/t}</h4>
				<div class="mer_check">
					<p>{t domain="refund"}处理状态：{/t}{if $refund_info.status eq '1'}{t domain="refund"}同意{/t}{elseif $refund_info.status eq '11'}{t domain="refund"}不同意{/t}{/if}</p>
					<p>{t domain="refund"}商家备注：{/t}{$action_mer_msg.action_note}</p>
					<p>{t domain="refund"}操作人：{/t}{$action_mer_msg.action_user_name}</p>
					<p>{t domain="refund"}处理时间：{/t}{$action_mer_msg.log_time}</p>
				</div>
	        </section>
        {else}
	        <section class="panel panel-body">
				<h4>{t domain="refund"}商家退款操作{/t}</h4>
				<div class="mer-content">
                     <h5 class="mer-title">{t domain="refund"}操作备注：{/t}</h5>
                     <div class="mer-content-textarea">
                        <textarea class="form-control" id="action_note" name="action_note" style="margin-bottom: 10px;"></textarea>
                        <select name="mer_reply_content" id="mer_reply_content" class="form-control" >
	                        <option value="">{t domain="refund"}请选择……{/t}</option>
							<option value="1">{t domain="refund"}审核通过{/t}</option>
							<option value="2">{t domain="refund"}审核通过，用户需写明退货信息，退回被损坏货品{/t}</option>
							<option value="3">{t domain="refund"}审核未通过，用户申请不符合退货退款要求{/t}</option>
							<option value="4">{t domain="refund"}退回货品已签收，等待平台退款{/t}</option>
							<option value="5">{t domain="refund"}退回货品未收到，暂不处理退款请求{/t}</option>
							<option value="6">{t domain="refund"}货品破损严重，拒绝签收{/t}</option>
						</select>
						<span class="help-block" style="margin-top: 50px;">{t domain="refund"}可使用快捷用语{/t}</span>
                     </div>
                 </div>
                 
				 <div class="mer-btn">
				 	<input type="hidden" id="refund_id" value="{$refund_id}"  />
				 	<a style="cursor: pointer;"  class="btn btn-primary change_status" data-type='agree' data-href='{url path="refund/merchant/merchant_check_refund"}' >
						{t domain="refund"}同意{/t}
					</a>
					<a style="cursor: pointer;"  class="btn btn-primary change_status" data-type='disagree' data-href='{url path="refund/merchant/merchant_check_refund"}' >
						{t domain="refund"}不同意{/t}
					</a>
			     </div>
	        </section>
        {/if}
        
        {if $refund_info.refund_status eq '2'}
	        <section class="panel panel-body">
				<h4>{t domain="refund"}商城平台退款审核{/t}</h4>
				<div class="mer_check">
					<p>{t domain="refund"}平台确认：已退款{/t}</p>
					<p>{t domain="refund"}平台备注：{/t}{$action_admin_msg.action_note}</p>
					<p>{t domain="refund"}操作人：{/t}{$action_admin_msg.action_user_name}</p>
					<p>{t domain="refund"}处理时间：{/t}{$action_admin_msg.log_time}</p>
				</div>
	        </section>
		        
	        <section class="panel panel-body">
				<h4>{t domain="refund"}商城平台退款详情{/t}</h4>
				<div class="adm_check">
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
	       </section>
        {/if}
    </div>
    
    <div class="col-lg-4">
        <div class="panel panel-body">
            <h4>{t domain="refund"}已收货商品{/t}</h4>
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
	                <p>{t domain="refund"}订单编号：{/t}<a target="_blank" href='{url path="orders/merchant/info" args="order_id={$order_info.order_id}"}'>{$order_info.order_sn}</a><span><a id="order-info" href="javascript:;">{t domain="refund"}查看更多{/t}</a></span></p>
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
	                <p>订单实付金额：{$refund_total_amount} <span><a id="order-money-info" href="javascript:;">{t domain="refund"}查看更多{/t}</a></span></p>
	                <div class="order-money-info" style="display: none;">
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
	                </div>
	                <hr>
	                <p>{t domain="refund"}订单编号：{/t}<a target="_blank" href='{url path="orders/merchant/info" args="order_id={$refund_info.order_id}"}'>{$refund_info.order_sn}</a><span><a id="order-info" href="javascript:;">{t domain="refund"}查看更多{/t}</a></span></p>
	                <div class="order-info" style="display: none;">
		                <p>{t domain="refund"}支付方式：{/t}{$refund_info.pay_name}</p>
	                </div>
                {/if}
	        </div>
        </div>
	</div>
</div>
<!-- {/block} -->