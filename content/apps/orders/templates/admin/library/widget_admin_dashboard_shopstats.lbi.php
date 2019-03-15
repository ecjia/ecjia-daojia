<div class="move-mod-group" id="widget_admin_dashboard_stats">
	<ul class="list-mod list-mod-stats move-mod-head">
		<li class="span3">
			<div class="bd ecjiaf-pre">1<span class="f_s14">&nbsp;{t domain="orders"}件{/t}</span></div>
			<a target="_blank" href='{url path="orders/admin_order_stats/init" args="start_date={$month_start_time}&end_date={$month_end_time}"}'>
				<div class="ft">
					<img src="{$static_url}goods.png" />
					<span>{t domain="orders"}30天新增商品{/t}</span>
				</div>
			</a>
		</li>
		<li class="span3">
			<div class="bd ecjiaf-pre">2<span class="f_s14">&nbsp;{t domain="orders"}个{/t}</span></div>
			<a target="_blank" href='{url path="orders/admin_order_stats/init" args="start_date={$month_start_time}&end_date={$month_end_time}"}'>
				<div class="ft">
					<img src="{$static_url}user.png" />
					<span>{t domain="orders"}30天新增会员{/t}</span>
				</div>
			</a>
		</li>
		<li class="span3">
			<div class="bd ecjiaf-pre">3<span class="f_s14">&nbsp;{t domain="orders"}单{/t}</span></div>
			<a target="_blank" href='{url path="orders/admin/init" args="start_time={$today_start_time}&end_time={$today_end_time}&composite_status={$unconfirmed}"}'>
				<div class="ft">
					<img src="{$static_url}order.png" />
					<span>{t domain="orders"}30天新增订单{/t}</span>
				</div>
			</a>
		</li>
		<li class="span3">
			<div class="bd ecjiaf-pre">4<span class="f_s14">&nbsp;{t domain="orders"}个{/t}</span></div>
			<a target="_blank" href='{url path="orders/admin/init" args="start_time={$today_start_time}&end_time={$today_end_time}&composite_status={$wait_ship}"}'>
				<div class="ft">
					<img src="{$static_url}seller.png" />
					<span>{t domain="orders"}30天新增入驻商{/t}</span>
				</div>
			</a>
		</li>
	</ul>
</div>
<style type="text/css">
	ul.list-mod-stats {
		margin: 0;
		overflow: hidden;
	}

	ul.list-mod-stats li {
		position: relative;
		background: #fff;
	}

	ul.list-mod-stats li .bd {
		height: 60px;
		font-size: 30px;
		text-align: center;
		padding: 80px 0px 0 0;
		border: 1px solid #ccc;
		border-top: none;
		border-radius: 5px;
	}

	ul.list-mod-stats li .ft {
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		height: 45px;
		line-height: 45px;
		padding: 0 15px;
		text-align: center;
		color: #fff;
		background: #54bcd8;
		border-top-right-radius: 5px;
		border-top-left-radius: 5px;
		font-size: 16px;
	}

	ul.list-mod-stats li .ft img {
		width: 30px;
		height: 30px;
	}

	ul.list-mod-stats li:nth-of-type(1n) .ft {
		background: #2fc1a5;
	}

	ul.list-mod-stats li:nth-of-type(2n) .ft {
		background: #efbc2e;
	}

	ul.list-mod-stats li:nth-of-type(3n) .ft {
		background: #f44775;
	}

	ul.list-mod-stats li:nth-of-type(4n) .ft {
		background: #7a31ec;
	}

	.move-mod-content {
		background-color: #f9f9f9;
		border-radius: 4px;
		display: flex;
		align-items: center;
		height: 100px;
		justify-content: space-around;
		margin-bottom: 10px;
	}

	.mod-content-item {
		font-size: 16px;
		width: 25%;
		padding-left: 20px;
	}

	.mod-content-item .title {
		color: #999999;
	}

	.mod-content-item .num {
		margin-top: 20px;
	}
</style>