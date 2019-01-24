<div class="ticket_box">
	<div class="ticket_box_header">
		<div class="store_logo"><img src="{$store.shop_logo}" /></div>
		<div class="store_name">{$store.merchants_name}</div>
		{if $contact_mobile}
		<div class="store_mobile">{$contact_mobile}</div>
		{/if}
		<div>（{$data.ticket_type}）</div>
	</div>
	<div class="ticket_content">
		<div class="ticket-item">订单编号：{$data.order_sn}</div>
		<div class="ticket-item">退单号：{$data.refund_sn}</div>
		<div class="ticket-item">交易类型：{$data.trade_type}</div>
		<div class="ticket-item">日期和时间：{$data.refund_time}</div>
		<div class="ticket-item">收银员：{$data.cashier}</div>
	</div>
	<div class="ticket_content">
		<div class="ticket-item">红包抵扣：-{$data.bonus}</div>
		<div class="ticket-item">积分抵扣：-{$data.integral_money}</div>
		<div class="ticket-item">优惠金额：-{$data.discount_amount}</div>
		<div class="ticket-item">应收金额：{$data.receivables}</div>
		<div class="ticket-item">实收金额：{$data.order_amount}</div>
		<div class="ticket-item">退款金额：{$data.refund_amount}</div>
	</div>
	<div class="ticket_content">
		<div class="ticket-item">支付渠道：{$data.payment}</div>
		<div class="ticket-item">支付流水号：{$data.trade_no}</div>
	</div>
	<div class="ticket_content no_dashed">
		<center>地址：{$store.address}</center>
		<center>电话：{$contact_mobile}</center>
		<div class="ticket-item qrcode"><img src="{$statics_url}images/qrcode.png" /></div>
	</div>
	{if $info.tail_content}
	<div class="ticket_content dashed">
		{$info.tail_content}
	</div>	
	{/if}
</div>