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
            <h4>买家退款申请</h4>
			<div class="refund_content">
				<p>退款编号：{$refund_info.refund_sn}</p>
				<p>申请人：{$refund_info.user_name}{if $refund_info.referer eq 'merchant'}（商家申请）{/if}</p>
				<p>退款原因：
 				<!-- {foreach from=$reason_list key=key item=val} -->
 				{if $key eq $refund_info.refund_reason}{$val}{/if}
				<!-- {/foreach} -->
				</p>
				<p>退款金额：<font class="ecjiafc-red ecjiafc-font">{$refund_total_amount}</font></p>
				<p>退款说明：{if $refund_info.refund_content}{$refund_info.refund_content}{else}暂无{/if}</p>
				<p>上传凭证： 
					{if $refund_img_list}
					<!-- {foreach from=$refund_img_list item=list} -->
						<a class="up-img no-underline" href="{RC_Upload::upload_url()}/{$list.file_path}" title="{$list.file_name}">
							<img src="{RC_Upload::upload_url()}/{$list.file_path}"/>
						</a>
					<!-- {/foreach} -->
	                {else}
	            	暂无
					{/if}
                </p>
                <p>申请时间：{$refund_info.add_time}</p>
			</div>
        </section>
        
        {if $refund_info.status eq '1' or $refund_info.status eq '11'}
	        <section class="panel panel-body">
				<h4>商家退款意见</h4>
				<div class="mer_check">
					<p>处理状态：{if $refund_info.status eq '1'}同意{elseif $refund_info.status eq '11'}不同意{/if}</p>
					<p>商家备注：{$action_mer_msg.action_note}</p>
					<p>操作人：{$action_mer_msg.action_user_name}</p>
					<p>处理时间：{$action_mer_msg.log_time}</p>
				</div>
	        </section>
        {else}
	        <section class="panel panel-body">
				<h4>商家退款操作</h4>
				<div class="mer-content">
                     <h5 class="mer-title">操作备注：</h5>
                     <div class="mer-content-textarea">
                        <textarea class="form-control" id="action_note" name="action_note" style="margin-bottom: 10px;"></textarea>
                        <select name="mer_reply_content" id="mer_reply_content" class="form-control" >
	                        <option value="">请选择……</option>
							<option value="1">审核通过</option>
							<option value="2">审核通过，用户需写明退货信息，退回被损坏货品</option>
							<option value="3">审核未通过，用户申请不符合退货退款要求</option>
							<option value="4">退回货品已签收，等待平台退款</option>
							<option value="5">退回货品未收到，暂不处理退款请求</option>
							<option value="6">货品破损严重，拒绝签收</option>
						</select>
						<span class="help-block" style="margin-top: 50px;">可使用快捷用语</span>
                     </div>
                 </div>
                 
				 <div class="mer-btn">
				 	<input type="hidden" id="refund_id" value="{$refund_id}"  />
				 	<a style="cursor: pointer;"  class="btn btn-primary change_status" data-type='agree' data-href='{url path="refund/merchant/merchant_check_refund"}' >
						同意
					</a>
					<a style="cursor: pointer;"  class="btn btn-primary change_status" data-type='disagree' data-href='{url path="refund/merchant/merchant_check_refund"}' >
						不同意
					</a>
			     </div>
	        </section>
        {/if}
        
        {if $refund_info.refund_status eq '2'}
	        <section class="panel panel-body">
				<h4>商城平台退款审核</h4>
				<div class="mer_check">
					<p>平台确认：已退款</p>
					<p>平台备注：{$action_admin_msg.action_note}</p>
					<p>操作人：{$action_admin_msg.action_user_name}</p>
					<p>处理时间：{$action_admin_msg.log_time}</p>
				</div>
	        </section>
		        
	        <section class="panel panel-body">
				<h4>商城平台退款详情</h4>
				<div class="adm_check">
					<p>退款方式：{if $payrecord_info.action_back_type eq 'original'}原路退回{else}退回余额{/if}</p>
					<p>应退款金额：<font class="ecjiafc-red ecjiafc-font">{$payrecord_info.order_money_paid_type}</font></p>
					{if $payrecord_info.back_pay_fee gt '0.00'}
						<p>扣除支付手续费：-{$payrecord_info.back_pay_fee_type}</p>
					{/if}
					
					{if $payrecord_info.back_shipping_fee gt '0.00'}
						<p>扣除配送费：-{$payrecord_info.back_shipping_fee_type}</p>
					{/if}
					
					{if $payrecord_info.back_insure_fee gt '0.00'}
						<p>扣除保价费：-{$payrecord_info.back_insure_fee_type}</p>
					{/if}
					
					{if $payrecord_info.back_inv_tax gt '0.00'}
						<p>退回发票费：{$payrecord_info.back_inv_tax_type}</p>
					{/if}
					
					<p>实际退款金额：<font class="ecjiafc-red ecjiafc-font">{$payrecord_info.back_money_total_type}</font></p>
					{if $payrecord_info.back_integral gt '0'}
						<p>积分：<font class="ecjiafc-red ecjiafc-font">{$payrecord_info.back_integral}</font></p>
					{/if}
					<p>退款时间：{$payrecord_info.action_back_time}</p>
				</div>
	       </section>
        {/if}
    </div>
    
    <div class="col-lg-4">
        <div class="panel panel-body">
            <h4>已收货商品</h4>
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
	               	<p>订单实付金额：{$order_money_total} <span><a id="order-money-info" href="javascript:;">查看更多</a></span></p>
	                <div class="order-money-info" style="display: none;">
	                	{if $order_info.goods_amount gt '0.00'}
		                <p>商品总金额：<span>{$order_info.goods_amount_price}</span></p>
		                {/if}
		                
		                {if $order_info.tax gt '0.00'}
		                <p>发票税额：<span>{$order_info.tax_price}</span></p>
		                {/if}
		                
		                {if $order_info.shipping_fee gt '0.00'}
		                <p>配送费用：<span>{$order_info.shipping_fee_price}</span></p>
		                {/if}
		                
		                {if $order_info.insure_fee gt '0.00'}
		                <p>保价费用：<span>{$order_info.insure_fee_price}</span></p>
		                {/if}
		                
		                {if $order_info.pay_fee gt '0.00'}
		                <p>支付费用：<span>{$order_info.pay_fee_price}</span></p>
		                {/if}
		                
		                {if $order_info.pack_fee gt '0.00'}
		                <p>包装费用：<span>{$order_info.pack_fee_price}</span></p>
		                {/if}
		                
		                {if $order_info.card_fee gt '0.00'}
		                <p>贺卡费用：<span>{$order_info.card_fee_price}</span></p>
		                {/if}
		                
		                {if $order_info.integral_money gt '0.00'}
		                <p>积分金额：<span>{$order_info.integral_money_price}</span></p>
		                {/if}
		                
		                {if $order_info.bonus gt '0.00'}
		                <p>红包金额：<span>{$order_info.bonus_price}</span></p>
		                {/if}
		                
		                {if $order_info.discount gt '0.00'}
		                <p>折扣金额：<span>{$order_info.discount_price}</span></p>
		                {/if}
	                </div>
	                <hr>
	                <p>订单编号：<a target="_blank" href='{url path="orders/merchant/info" args="order_id={$order_info.order_id}"}'>{$order_info.order_sn}</a><span><a id="order-info" href="javascript:;">查看更多</a></span></p>
	                <div class="order-info" style="display: none;">
		                <p>支付方式：{$order_info.pay_name}</p>
		                <p>下单时间：{$order_info.add_time}</p>
		                <p>付款时间：{$order_info.pay_time}</p>
	                </div>
	                <hr>
	                <p>收货人：{$order_info.consignee}<span><a id="address-info" href="javascript:;">查看更多</a></span></p>
	                <div class="address-info" style="display: none;">
		                <p>收货地址：{$order_info.province}{$order_info.city}{$order_info.district}{$order_info.street}{$order_info.address}</p>
		                <p>联系电话：{$order_info.mobile}</p>
	                </div>
                {else}
	                <p>订单实付金额：{$refund_total_amount} <span><a id="order-money-info" href="javascript:;">查看更多</a></span></p>
	                <div class="order-money-info" style="display: none;">
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
	                </div>
	                <hr>
	                <p>订单编号：<a target="_blank" href='{url path="orders/merchant/info" args="order_id={$refund_info.order_id}"}'>{$refund_info.order_sn}</a><span><a id="order-info" href="javascript:;">查看更多</a></span></p>
	                <div class="order-info" style="display: none;">
		                <p>支付方式：{$refund_info.pay_name}</p>
	                </div>
                {/if}
	        </div>
        </div>
	</div>
</div>
<!-- {/block} -->