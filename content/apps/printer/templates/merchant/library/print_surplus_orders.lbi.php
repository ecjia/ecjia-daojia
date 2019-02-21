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
		<div class="ticket-item">{t domain="printer"}订单编号：{/t}{$data.order_sn}</div>
		<div class="ticket-item">{t domain="printer"}交易号：{/t}{$data.order_trade_no}</div>
		<div class="ticket-item">{t domain="printer"}交易类型：{/t}{$data.trade_type}</div>
		<div class="ticket-item">{t domain="printer"}日期和时间：{/t}{$data.recharge_time}</div>
	</div>
	<div class="ticket_content">
		<div class="ticket-item">{t domain="printer"}优惠金额：{/t}{$data.discount_amount}</div>
		<div class="ticket-item">{t domain="printer"}实收金额：{/t}{$data.order_amount}</div>
		<div class="ticket-item">{t domain="printer"}账户积分：{/t}{$data.user_pay_points}</div>
		<div class="ticket-item">{t domain="printer"}账户余额：{/t}{$data.user_money}</div>
	</div>
	<div class="ticket_content">
		<div class="ticket-item">{t domain="printer"}会员账号：{/t}{$data.user_name}</div>
		<div class="ticket-item">{t domain="printer"}支付渠道：{/t}{$data.payment}</div>
		{if $data.pay_account}
		<div class="ticket-item">{t domain="printer"}支付账号：{/t}{$data.pay_account}</div>
		{/if}
		<div class="ticket-item">{t domain="printer"}支付流水号：{/t}{$data.trade_no}</div>
	</div>
	<div class="ticket_content no_dashed">
		<center>{t domain="printer"}地址：{/t}{$store.address}</center>
		<center>{t domain="printer"}电话：{/t}{$contact_mobile}</center>
		<div class="ticket-item qrcode"><img src="{$statics_url}images/qrcode.png" /></div>
	</div>
	{if $info.tail_content}
	<div class="ticket_content dashed">
		{$info.tail_content}
	</div>	
	{/if}
</div>