<div class="row">
	<div class="col-lg-12 ">
		<div class="panel">
			<div class="panel-body">
				<header class="panel-title">
					店铺资金
					<span class="pull-right">
						<a target="__blank" href="{RC_Uri::url('commission/merchant/init')}">查看更多 >></a>
					</span>
				</header>
				<div class="task-progress-content">
					<div class="item-column">
						<div class="title">账户余额（元）</div>
						<div class="num">{$data.formated_money}</div>
					</div>
					<div class="item-column">
						<div class="title">冻结资金（元）</div>
						<div class="num">{$data.formated_frozen_money}</div>
					</div>
					<div class="item-column">
						<div class="title">保证金（元）</div>
						<div class="num">{$data.formated_deposit}</div>
					</div>
					<div class="item-column">
						<div class="title">可用余额（元）</div>
						<div class="num">{$data.formated_amount_available}</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel">
			<div class="panel-body">
				<header class="panel-title">
					订单统计类型
					<span class="pull-right">
						<a target="__blank" href="{RC_Uri::url('orders/mh_order_stats/init')}">查看更多 >></a>
					</span>
				</header>
				<div class="task-progress-content">
					<div class="item-column">
						<div class="title">配送订单（单）</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('orders/merchant/init')}">{$data.order_count}</a>
						</div>
					</div>
					<div class="item-column">
						<div class="title">自提订单（单）</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('orders/merchant/init')}&extension_code=storepickup">{$data.storepickup_count}</a>
						</div>
					</div>
					<div class="item-column">
						<div class="title">到店订单（单）</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('orders/merchant/init')}&extension_code=storebuy">{$data.storebuy_count}</a>
						</div>
					</div>
					<div class="item-column">
						<div class="title">团购订单（单）</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('orders/merchant/init')}&extension_code=group_buy">{$data.groupbuy_count}</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel">
			<div class="panel-body">
				<header class="panel-title">平台配送</h1>
				</header>
				<div class="task-progress-content">
					<div class="item-row">
						<img src="{$ecjia_main_static_url}img/merchant_dashboard/express.png" />
						<div class="title">提醒派单</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('express/merchant/init')}&type=wait_grab&platform=1">{$data.express_platform_count.wait_grab}</a>
						</div>
					</div>
					<div class="item-row">
						<img src="{$ecjia_main_static_url}img/merchant_dashboard/wait_get.png" />
						<div class="title">待取货</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('express/merchant/wait_pickup')}&type=wait_pickup&platform=1">{$data.express_platform_count.wait_pickup}</a>
						</div>
					</div>
					<div class="item-row">
						<img src="{$ecjia_main_static_url}img/merchant_dashboard/shipping.png" />
						<div class="title">配送中</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('express/merchant/wait_pickup')}&type=sending&platform=1">{$data.express_platform_count.sending}</a>
						</div>
					</div>
					<div class="item-row">
						<img src="{$ecjia_main_static_url}img/merchant_dashboard/finished.png" />
						<div class="title">已完成</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('express/mh_history/init')}">{$data.express_platform_count.finished}</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel">
			<div class="panel-body">
				<header class="panel-title">商家配送</h1>
				</header>
				<div class="task-progress-content">
					<div class="item-row">
						<img src="{$ecjia_main_static_url}img/merchant_dashboard/express.png" />
						<div class="title">待派单</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('express/merchant/init')}&type=wait_grab">{$data.express_merchant_count.wait_grab}</a>
						</div>
					</div>
					<div class="item-row">
						<img src="{$ecjia_main_static_url}img/merchant_dashboard/wait_get.png" />
						<div class="title">待取货</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('express/merchant/wait_pickup')}&type=wait_pickup">{$data.express_merchant_count.wait_pickup}</a>
						</div>
					</div>
					<div class="item-row">
						<img src="{$ecjia_main_static_url}img/merchant_dashboard/shipping.png" />
						<div class="title">配送中</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('express/merchant/wait_pickup')}&type=sending">{$data.express_merchant_count.sending}</a>
						</div>
					</div>
					<div class="item-row">
						<img src="{$ecjia_main_static_url}img/merchant_dashboard/finished.png" />
						<div class="title">已完成</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('express/mh_history/init')}&type=merchant">{$data.express_merchant_count.finished}</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="panel">
			<div class="panel-body">
				<header class="panel-title">促销活动</h1>
				</header>
				<div class="task-progress-content">
					<div class="item-row">
						<img src="{$ecjia_main_static_url}img/merchant_dashboard/promotion.png" />
						<div class="title">促销</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('promotion/merchant/init')}">{$data.promotion_count}</a>
						</div>
					</div>
					<div class="item-row">
						<img src="{$ecjia_main_static_url}img/merchant_dashboard/favourable.png" />
						<div class="title">优惠</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('favourable/merchant/init')}">{$data.favourable_count}</a>
						</div>
					</div>
					<div class="item-row">
						<img src="{$ecjia_main_static_url}img/merchant_dashboard/groupbuy.png" />
						<div class="title">团购</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('groupbuy/merchant/init')}">{$data.groupbuy_count}</a>
						</div>
					</div>
					<div class="item-row">
						<img src="{$ecjia_main_static_url}img/merchant_dashboard/quickpay.png" />
						<div class="title">买单</div>
						<div class="num">
							<a target="__blank" href="{RC_Uri::url('quickpay/merchant/init')}">{$data.quickpay_count}</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		{if $data.sale_item}
		<div class="panel">
			<div class="panel-body">
				<header class="panel-title m_b10">商品热卖榜</h1>
					<span class="pull-right">
						<a target="__blank" href="{RC_Uri::url('orders/mh_sale_order/init')}">查看更多 >></a>
					</span>
				</header>
				<table class="table table-striped table-hover table-hide-edit m_b0">
					<thead>
						<tr>
							<th class="w50">排行</th>
							<th>商品名称</th>
							<th class="w100">货号</th>
							<th class="w100">销售量</th>
							<th class="w120">销售额</th>
							<th class="w100">单价</th>
						</tr>
					</thead>
					<!-- {foreach from=$data.sale_item item=list key=key} -->
					<tr>
						<td>
							{$key+1}
						</td>
						<td>
							{$list.goods_name}
						</td>
						<td>
							{$list.goods_sn}
						</td>
						<td>
							{$list.goods_num}
						</td>
						<td>
							{$list.turnover}
						</td>
						<td>
							{$list.wvera_price}
						</td>
					</tr>
					<!-- {/foreach} -->
				</table>
			</div>
		</div>
		{/if}
		
	</div>
</div>