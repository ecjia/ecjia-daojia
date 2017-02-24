<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="move-mod-group chart-mod2" id="widget_admin_dashboard_orderCountChart">
	<h3 class="move-mod-head">{$title}</h3>
	<canvas id="orderCount-chart"></canvas>
	<div class="bd">
		<p class="title">{$count}</p>
		<p>{t}订单列表（单）{/t}</p>
	</div>
	<div class="info">
		<ul class="chart-list">
			<li><i></i>{t}待确认：{/t}{$order.unconfirmed}{t}单{/t}</li>
			<li><i></i>{t}待付款：{/t}{$order.await_pay}{t}单{/t}</li>
			<li><i></i>{t}待发货：{/t}{$order.await_ship}{t}单{/t}</li>
			<li><i></i>{t}待收货：{/t}{$order.shipped_part}{t}单{/t}</li>
			<li><i></i>{t}已完成：{/t}{$order.finished}{t}单{/t}</li>
		</ul>
	</div>
	<style type="text/css">
		.chart-mod2 {
			padding: 20px;
			border: 1px solid #ccc;
			border-radius: 10px;
			position: relative;
			margin-bottom: 20px;
		}
			.chart-mod2 h3 {
				line-height: 30px;
				font-size: 16px;
				line-height: 30px;
				color: #333;
				border-bottom: 1px solid #ccc;
				font-weight: normal;
			}
			.chart-mod2 canvas {
				position: absolute;
				width: 240px;
				height: 240px;
				left: 20px;
				bottom: 50%;
				margin-bottom: -120px;
				z-index: 2;
			}
			.chart-mod2 .bd {
				position: absolute;
				width: 240px;
				height: 240px;
				left: 20px;
				bottom: 50%;
				margin-bottom: -120px;
				z-index: 1;
			}
				.chart-mod2 .bd p {
					position: absolute;
					top: 70%;
					left: 0;
					right: 0;
					text-align: center;
				}
				.chart-mod2 .bd .title {
					font-size: 70px;
					color: #64cce8;
					top: 50%;
					margin-top: -20px;
				}
			.chart-mod2 .info {
				height: 300px;
				padding: 20px 0;
				padding-left: 260px;
			}
				.chart-mod2 .info .chart-list li {
					list-style: none;
					line-height: 40px;
					padding-left: 40px;
					position: relative;
				}
				.chart-mod2 .info .chart-list li i {
					display: block;
					position: absolute;
					top: 50%;
					left: 10px;
					width: 15px;
					height: 15px;
					border-radius: 10px;
					margin-top: -7px;
				}
				.chart-mod2 .info .chart-list li:nth-of-type(1n) i {
					background: #54bcd8;
				}
				.chart-mod2 .info .chart-list li:nth-of-type(2n) i {
					background: #976390;
				}
				.chart-mod2 .info .chart-list li:nth-of-type(3n) i {
					background: #ff907e;
				}
				.chart-mod2 .info .chart-list li:nth-of-type(4n) i {
					background: #9dc870;
				}
				.chart-mod2 .info .chart-list li:nth-of-type(5n) i {
					background: #888;
				}
		#widget_admin_dashboard_orderCountChart .bd .title {
			color: #666;
		}
	</style>
	<script type="text/javascript">
	$(function(){
		{if $order.unconfirmed eq 0 && $order.await_pay eq 0 && $order.await_ship eq 0 && $order.shipped_part eq 0 && $order.finished eq 0}
		var doughnutData = [
			{
				value: 1,
				color:"#666",
				highlight: "#999",
				label: "暂无订单"
			}
		]
		{else}
		var doughnutData = [
			{
				value: {$order.unconfirmed},
				color:"#54bcd8",
				highlight: "#64cce8",
				label: "待确认"
			},
			{
				value: {$order.await_pay},
				color: "#976390",
				highlight: "#a773a0",
				label: "待付款"
			},
			{
				value: {$order.await_ship},
				color: "#ff907e",
				highlight: "#efa08e",
				label: "待发货"
			},
			{
				value: {$order.shipped_part},
				color: "#9dc870",
				highlight: "#add880",
				label: "待收货"
			},
			{
				value: {$order.finished},
				color: "#888888",
				highlight: "#999999",
				label: "已完成"
			}
		];
		{/if}
		{literal}
		var ctx = $("#orderCount-chart").get(0).getContext("2d");
		var doughnutOptions = {
			segmentShowStroke : true,
			segmentStrokeColor : "#fff",
			segmentStrokeWidth : 0,
			percentageInnerCutout : 90,
			animation : true,
			animationSteps : 100,
			animationEasing : "easeOutQuart",
			animateRotate : true,
			animateScale : true
		}
		new Chart(ctx).Doughnut(doughnutData,doughnutOptions);
		{/literal}
	})
	</script>
</div>