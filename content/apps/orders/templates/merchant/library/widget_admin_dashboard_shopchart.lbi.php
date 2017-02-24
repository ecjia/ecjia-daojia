<div class="move-mod-group" id="widget_admin_dashboard_briefing">
	<ul class="list-mod list-mod-briefing move-mod-head">
		<li class="span3">
			<div class="bd ecjiaf-pre"><span class="f_s14">￥</span>{$order_money}<span class="f_s14">元</span></div>
			<div class="ft"><i class="fontello-icon-doc-text-inv ecjiaf-fl"></i>本月订单总额</div>
		</li>
		<li class="span3">
			<div class="bd ecjiaf-pre">{$month_order}<span class="f_s14">单</span></div>
			<div class="ft"><i class="fontello-icon-doc-text-inv ecjiaf-fl"></i>本月订单数量</div>
		</li>
		<li class="span3">
			<div class="bd ecjiaf-pre">{$order_unconfirmed}<span class="f_s14">单</span></div>
			<div class="ft"><i class="fontello-icon-doc-text-inv ecjiaf-fl"></i>今日待确认订单</div>
		</li>
		<li class="span3">
			<div class="bd ecjiaf-pre">{$order_await_ship}<span class="f_s14">单</span></div>
			<div class="ft"><i class="fontello-icon-doc-text-inv ecjiaf-fl"></i>今日待发货订单</div>
		</li>
	</ul>
	<!-- <div class="ecjiaf-tar"><a href="{RC_Uri::url('@admin_logs/init')}" title="{t}查看更多{/t}">{t}查看更多{/t}</a></div> -->
</div>
<style type="text/css">
	ul.list-mod-briefing {
		margin: 0;
		overflow: hidden;
		margin-bottom: 20px;
	}
	ul.list-mod-briefing li {
		position: relative;
		background: #fff;
	}
	ul.list-mod-briefing li .bd {
		height: 108px;
		font-size: 28px;
		text-align: center;
		padding: 50px 10px 0;
		border: 1px solid #ccc;
		border-bottom: none;
		border-radius: 5px;
	}
	ul.list-mod-briefing li .ft {
		position: absolute;
		left: 0;
		right: 0;
		bottom: 0;
		height: 38px;
		line-height: 38px;
		padding: 0 15px;
		text-align: right;
		color: #fff;
		background: #54bcd8;
		border-bottom-right-radius: 5px;
		border-bottom-left-radius: 5px;
	}
	ul.list-mod-briefing li:nth-of-type(1n) .ft {
		background: #9dc870;
	}
	ul.list-mod-briefing li:nth-of-type(2n) .ft {
		background: #54bcd8;
	}
	ul.list-mod-briefing li:nth-of-type(3n) .ft {
		background: #e9a954;
	}
	ul.list-mod-briefing li:nth-of-type(4n) .ft {
		background: #976390;
	}
</style>