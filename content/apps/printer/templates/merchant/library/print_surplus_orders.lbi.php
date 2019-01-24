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
		<div class="ticket-item">交易号：{$data.order_trade_no}</div>
		<div class="ticket-item">交易类型：{$data.trade_type}</div>
		<div class="ticket-item">日期和时间：{$data.recharge_time}</div>
	</div>
	<div class="ticket_content">
		<div class="ticket-item">优惠金额：{$data.discount_amount}</div>
		<div class="ticket-item">实收金额：{$data.order_amount}</div>
		<div class="ticket-item">账户积分：{$data.user_pay_points}</div>
		<div class="ticket-item">账户余额：{$data.user_money}</div>
	</div>
	<div class="ticket_content">
		<div class="ticket-item">会员账号：{$data.user_name}</div>
		<div class="ticket-item">支付渠道：{$data.payment}</div>
		{if $data.pay_account}
		<div class="ticket-item">支付账号：{$data.pay_account}</div>
		{/if}
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