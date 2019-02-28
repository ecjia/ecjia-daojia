<div class="move-mod-group" id="widget_admin_dashboard_ordertype_stats">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{t domain="orders"}订单类型统计{/t}</h3>
	</div>
	<div class="move-mod-content">
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}配送订单（单）{/t}</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("orders/admin/init")}'>{$data.order_count}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}到店订单（单）{/t}</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("orders/admin/init")}&extension_code=storebuy'>{$data.storebuy_count}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}自提订单（单）{/t}</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("orders/admin/init")}&extension_code=storepickup'>{$data.storepickup_count}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}团购订单（单）{/t}</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("orders/admin/init")}&extension_code=group_buy'>{$data.groupbuy_count}</a></div>
		</div>
	</div>
</div>
<div class="move-mod-group" id="widget_admin_dashboard_user_stats">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{t domain="orders"}会员统计{/t}</h3>
	</div>
	<div class="move-mod-content">
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}今日新增（个）{/t}</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("user/admin/init")}'>{$data.today_num}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}7日新增（个）{/t}</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("user/admin/init")}'>{$data.sevendays_num}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}30天新增（个）{/t}</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("user/admin/init")}'>{$data.thritydays_num}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}总会员数（个）{/t}</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("user/admin/init")}'>{$data.total_num}</a></div>
		</div>
	</div>
</div>
<div class="move-mod-group" id="widget_admin_dashboard_account_stats">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{t domain="orders"}待处理财务统计{/t}</h3>
	</div>
	<div class="move-mod-content">
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}会员充值（单）{/t}</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("finance/admin_account/init")}&type=recharge'>{$data.recharge_num}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}会员提现（单）{/t}</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("finance/admin_account/init")}&type=withdraw'>{$data.withdraw_num}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}会员退款（单）{/t}</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("refund/admin_payrecord/init")}'>{$data.refund_num}</a></div>
		</div>
		<div class="mod-content-item">
			<div class="title">{t domain="orders"}商家提现（单）{/t}</div>
			<div class="num"><a target="__blank" href='{RC_Uri::url("commission/admin/withdraw")}'>{$data.merchant_withdraw_num}</a></div>
		</div>
	</div>
</div>