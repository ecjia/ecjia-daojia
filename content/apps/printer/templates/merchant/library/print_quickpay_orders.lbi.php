<div class="ticket_box">
	<div class="ticket_box_header">
		<div class="store_logo"><img src="{$store.shop_logo}" /></div>
		<div class="store_name">{$store.merchants_name}</div>
		{if $contact_mobile}
		<div class="store_mobile">{$contact_mobile}</div>
		{/if}
	</div>
	<div class="ticket_content no_dashed">
		<div class="ticket-item">{t domain="printer"}订单编号：{/t}{$data.order_sn}</div>
		<div class="ticket-item">{t domain="printer"}流水编号：{/t}{$data.order_trade_no}</div>
		{if $data.user_account}
			<div class="ticket-item">{t domain="printer"}会员账号：{/t}{$data.user_account}</div>
		{/if}
		<div class="ticket-item">{t domain="printer"}买单时间：{/t}{$data.purchase_time}</div>
		<div class="ticket-item">{t domain="printer"}商家地址：{/t}{$data.merchant_address}</div>
	</div>
	<div class="ticket_content">
		<div class="title">  
		   <span class="line"></span>  
		   <span class="txt">{t domain="printer"}在线买单{/t}</span>
		   <span class="line"></span>  
		</div> 
		<div class="ticket-item">{t domain="printer"}优惠活动：{/t}{$data.favourable_activity}</div>
	</div>
	<div class="ticket_content no_dashed">
		<div class="ticket-item">{t domain="printer"}优惠金额：{/t}-{$data.discount_amount}</div>
		<div class="ticket-item">{t domain="printer"}应收金额：{/t}{$data.receivables}</div>
		<div class="ticket-item">{t domain="printer"}实收金额：{/t}{$data.order_amount}</div>
		<div class="ticket-item">{t domain="printer"}支付宝：{/t}{$data.order_amount}</div>
		<div class="ticket-item qrcode"><img src="{$statics_url}images/qrcode.png" /></div>
	</div>
	{if $info.tail_content}
	<div class="ticket_content dashed">
		{$info.tail_content}
	</div>	
	{/if}
</div>