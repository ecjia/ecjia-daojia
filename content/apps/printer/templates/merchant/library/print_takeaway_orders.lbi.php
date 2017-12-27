<div class="ticket_box">
	<div class="ticket_box_header">
		<div class="store_logo"><img src="{$store.shop_logo}" /></div>
		<div class="store_name">{$store.merchants_name}</div>
		{if $contact_mobile}
		<div class="store_mobile">{$contact_mobile}</div>
		{/if}
		<div class="pay_status">{$data.payment}（{$data.pay_status}）</div>
	</div>
	<div class="ticket_content no_dashed">
		<div class="ticket-item">订单编号：{$data.order_sn}</div>
		<div class="ticket-item">流水编号：{$data.order_trade_no}</div>
		<div class="ticket-item">下单时间：{$data.purchase_time}</div>
		<div class="ticket-item">期望送达时间：{$data.expect_shipping_time}</div>
	</div>
	<div class="ticket_content no_dashed">
		<div class="title">  
		   <span class="line"></span>  
		   <span class="txt">商品名</span>  
		   <span class="line"></span>  
		</div>  
		<ul>
			<li>商品</li>
			<li>数量</li>
			<li>单价</li>
		</ul>
		<!-- {foreach from=$data.goods_lists item=list} -->
		<p>{$list.goods_name}</p>
		<ul>
			<li>&nbsp;</li>
			<li>{$list.goods_number}</li>
			<li>{$list.goods_amount}</li>
		</ul>
		<!-- {/foreach} -->
		<span class="total">总计：{$data.goods_subtotal}</span>
	</div>	
	<div class="ticket_content">
		<div class="title">  
		   <span class="line"></span>  
		   <span class="txt">其他</span>
		   <span class="line"></span>  
		</div> 
		<div class="ticket-item">
			<div class="left-item">积分抵扣：-{$data.integral_money}</div>
			<div class="right-item">获得积分：{$data.integral_give}</div>
		</div>
		<div class="ticket-item">积分余额：{$data.integral_balance}</div>
		<div class="ticket-item">满减满折：-{$data.favourable_discount}</div>
		<div class="ticket-item">红包折扣：-{$data.bonus_discount}</div>
	</div>	
	<div class="ticket_content">
		<div class="ticket-item">配送费用：{$data.shipping_fee}</div>
		<div class="ticket-item">应收金额：{$data.receivables}</div>
		<div class="ticket-item">实收金额：{$data.order_amount}</div>
		<div class="ticket-item">微信支付：{$data.order_amount}</div>
	</div>
	<div class="ticket_content no_dashed">
		备注内容：{$data.order_remarks}
		<div class="ticket-item">地址：{$data.consignee_address}</div>
		<div class="ticket-item">姓名：{$data.consignee_name}</div>
		<div class="ticket-item">手机号：{$data.consignee_mobile}</div>
		<div class="ticket-item qrcode"><img src="{$statics_url}images/qrcode.png" /></div>
	</div>	
	{if $info.tail_content}
	<div class="ticket_content dashed">
		{$info.tail_content}
	</div>	
	{/if}	
</div>