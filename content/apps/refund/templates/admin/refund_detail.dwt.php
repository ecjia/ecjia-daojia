<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.refund_info.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link} <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>{/if}
	</h3>
</div>

<!-- #BeginLibraryItem "/library/refund_step.lbi" --><!-- #EndLibraryItem -->

<div class="row-fluid editpage-rightbar">
	<div class="left-bar move-mod">
		<div class="foldable-list move-mod-group" >
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#refund_content">
						<strong>买家退款申请</strong>
					</a>
				</div>
				<div class="accordion-body in collapse" id="refund_content">
					<div class="refund_content">
						<p>退款编号：{$refund_info.refund_sn}</p>
						<p>申请人：{$refund_info.user_name}{if $refund_info.referer eq 'merchant'}（商家申请）{/if}</p>
						<p>退款原因：
						<!-- {foreach from=$reason_list key=key item=val} -->
		 				{if $key eq $refund_info.refund_reason}{$val}{/if}
						<!-- {/foreach} -->
						</p>
						<p>退款金额：{$refund_total_amount}</p>
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
					</div>
				</div>
			</div>
			
			{if $refund_info.status eq '1' or $refund_info.status eq '11'}
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#mer_content">
							<strong>商家退款意见</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="mer_content">
						<div class="refund_content">
							<p>处理状态：{if $refund_info.status eq '1'}同意{elseif $refund_info.status eq '11'}不同意{/if}</p>
							<p>商家备注：{$action_mer_msg.action_note}</p>
							<p>操作人：{$action_mer_msg.action_user_name}</p>
							<p>处理时间：{$action_mer_msg.log_time}</p>
						</div>
					</div>
				</div>
				
				{if $refund_info.status eq '1' and $refund_info.refund_status neq '2'}
                    <div style="margin-top: 20px;">
                        	退款操作：<a href='{url path="refund/admin_payrecord/detail" args="refund_id={$refund_info.refund_id}"}' class="data-pjax"><button class="btn btn-gebo" type="button">去退款</button>  </a>     
                    </div>
                {/if}
			{/if}
						
			{if $refund_info.refund_status eq '2' }
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#admin_content">
							<strong>商城平台退款审核</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="admin_content">
						<div class="refund_content">
							<p>平台确认：已退款</p>
							<p>平台备注：{$action_admin_msg.action_note}</p>
							<p>操作人：{$action_admin_msg.action_user_name}</p>
							<p>处理时间：{$action_admin_msg.log_time}</p>
						</div>
					</div>
				</div>
				
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#admin_content">
							<strong>商城平台退款详情</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="admin_content">
						<div class="refund_content">
							<p>退款方式：{if $payrecord_info.action_back_type eq 'original'}原路退回{else}退回余额{/if}</p>
							<p>应退款金额：{$payrecord_info.order_money_paid_type}</p>
							{if $payrecord_info.back_pay_fee neq '0.00'}
								<p>扣除支付手续费：-{$payrecord_info.back_pay_fee_type}</p>
							{/if}
							
							{if $payrecord_info.back_shipping_fee neq '0.00'}
								<p>扣除配送费：-{$payrecord_info.back_shipping_fee_type}</p>
							{/if}
							
							{if $payrecord_info.back_insure_fee neq '0.00'}
								<p>扣除保价费：-{$payrecord_info.back_insure_fee_type}</p>
							{/if}
							
							{if $payrecord_info.back_inv_tax neq '0.00'}
								<p>退回发票费：{$payrecord_info.back_inv_tax_type}</p>
							{/if}
							
							<p>实际退款金额：<font class="ecjiafc-red"><strong>{$payrecord_info.back_money_total_type}</strong></font></p>
							{if $payrecord_info.back_integral neq '0'}
								<p>积分：<font class="ecjiafc-red"><strong>{$payrecord_info.back_integral}</strong></font></p>
							{/if}
							<p>退款时间：{$payrecord_info.action_back_time}</p>
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
						<strong>店铺信息</strong>
					</a>
				</div>
				<div class="accordion-body in in_visable collapse" id="refund_mer_content">
					<div class="accordion-inner">
					   <div class="merchant_content">
							<div class="list-top">
								<img src="{if $mer_info.img}{RC_Upload::upload_url()}/{$mer_info.img}{else}{RC_Uri::admin_url('statics/images/nopic.png')}{/if}"><span>{$mer_info.merchants_name}</span>
							</div>
							<div class="list-mid">
								<p><font class="ecjiafc-red">{$mer_info.count.refund_count}</font><br>仅退款</p>
								<p><font class="ecjiafc-red">{$mer_info.count.return_count}</font><br>退款退货</p>
							</div>
							
							<div class="list-bot">
								<div><label>营业时间：</label>{$mer_info.shop_trade_time.start}-{$mer_info.shop_trade_time.end}</div>
								<div><label>商家电话：</label>{$mer_info.shop_kf_mobile}</div>
								<div><label>商家地址：</label>{$mer_info.address}</div>
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
						<strong>已收货商品</strong>
					</a>
				</div>
				<div class="accordion-body in collapse reply_admin_list" id="refund_goods_content">
					<div class="accordion-inner">
					 	<div class="goods-content">
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
			                <p>运费：{$order_info.shipping_fee}</p>
			                <p>订单总额：{$order_amount}（退款：{$refund_total_amount}）</p>
			                <hr>
			                <p>订单编号：{$order_info.order_sn} <span><a id="order-info" href="javascript:;">查看更多</a></span></p>
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
				        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->