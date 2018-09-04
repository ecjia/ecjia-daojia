<div class="move-mod-group" id="widget_admin_dashboard_stats">
	<ul class="list-mod list-mod-stats move-mod-head">
		<li class="span3">
			<div class="bd ecjiaf-pre"><a target="__blank" href='{url path="goods/admin/init"}'>{$data.goods_num}</a><span class="f_s14">&nbsp;件</span></div>
			<div class="ft">
				<img src="{$static_url}goods.png" />
				<span>30天新增商品</span>
			</div>
		</li>
		<li class="span3">
			<div class="bd ecjiaf-pre"><a target="__blank" href='{url path="user/admin/init"}'>{$data.users_num}</a><span class="f_s14">&nbsp;个</span></div>
			<div class="ft">
				<img src="{$static_url}user.png" />
				<span>30天新增会员</span>
			</div>
		</li>
		<li class="span3">
			<div class="bd ecjiaf-pre"><a target="__blank" href='{url path="orders/admin/init"}'>{$data.orders_num}</a><span class="f_s14">&nbsp;单</span></div>
			<div class="ft">
				<img src="{$static_url}order.png" />
				<span>30天新增订单</span>
			</div>
		</li>
		<li class="span3">
			<div class="bd ecjiaf-pre"><a target="__blank" href='{url path="store/admin/join"}'>{$data.store_num}</a><span class="f_s14">&nbsp;个</span></div>
			<div class="ft">
				<img src="{$static_url}seller.png" />
				<span>30天新增入驻商</span>
			</div>
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
		border: 1px solid #ddd;
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
		display: -webkit-box;
		display: -moz-box;
		display: -webkit-flex;
		display: -moz-flex;
		display: -ms-flexbox;
		display: flex;
		align-items: center;
		-webkit-align-items: center;
		box-align: center;
		-moz-box-align: center;
		-webkit-box-align: center;
		height: 100px;
		justify-content: space-around;
		margin-bottom: 10px;
		border: 1px solid #ddd;
	}

	.mod-content-item {
		font-size: 16px;
		width: 25%;
		padding-left: 20px;
	}

	.mod-content-item .title {
		color: #999999;
		font-size: 13px;
	}

	.mod-content-item .num {
		margin-top: 20px;
	}
	
	.move-mod-group a:hover {
		text-decoration: none;
	}
</style>