<div class="move-mod-group" id="widget_admin_dashboard_ordertype_stats">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">订单类型统计</h3>
	</div>
	<div class="move-mod-content">
		<div class="mod-content-item">
			<div class="title">配送订单（单）</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("orders/admin/init")}'>{$data.order_count}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">到店订单（单）</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("orders/admin/init")}&extension_code=storebuy'>{$data.storebuy_count}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">自提订单（单）</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("orders/admin/init")}&extension_code=storepickup'>{$data.storepickup_count}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">团购订单（单）</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("orders/admin/init")}&extension_code=group_buy'>{$data.groupbuy_count}</a></div>
		</div>
	</div>
</div>
<div class="move-mod-group" id="widget_admin_dashboard_user_stats">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">会员统计</h3>
	</div>
	<div class="move-mod-content">
		<div class="mod-content-item">
			<div class="title">今日新增（个）</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("user/admin/init")}'>{$data.today_num}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">7日新增（个）</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("user/admin/init")}'>{$data.sevendays_num}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">30天新增（个）</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("user/admin/init")}'>{$data.thritydays_num}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">总会员数（个）</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("user/admin/init")}'>{$data.total_num}</a></div>
		</div>
	</div>
</div>
<div class="move-mod-group" id="widget_admin_dashboard_account_stats">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">待处理财务统计</h3>
	</div>
	<div class="move-mod-content">
		<div class="mod-content-item">
			<div class="title">会员充值（单）</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("finance/admin_account/init")}&type=recharge'>{$data.recharge_num}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">会员提现（单）</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("finance/admin_account/init")}&type=withdraw'>{$data.withdraw_num}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">会员退款（单）</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("refund/admin_payrecord/init")}'>{$data.refund_num}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">商家提现（单）</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("commission/admin/withdraw")}'>{$data.merchant_withdraw_num}</a></div>
		</div>
	</div>
</div>