<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<div class="move-mod-group" id="widget_admin_dashboard_goodsstat">
	<div class="heading clearfix move-mod-head">
		<h3 class="pull-left">{$title}</h3>
	</div>
	<div class="row-fluid">
		<div class="span6 left-border">
			<div class="total-count">
				<div class="total-count-margin">
					<span class="total-num-col">总商品数</span>
					<span class="total-num">{$goods.total}</span>
				</div>
			</div>
			<div class="goods-left-stats">
				<div class="row-fluid suggest-goods">
					<div class="span4 suggest-space">
						<p><span class="suggest-num">{$goods.new_goods}</span></p>
						<p class="suggest-name">新品首发</p>
					</div>
					<div class="span4">
						<p><span class="suggest-num">{$goods.best_goods}</span></p>
						<p class="suggest-name">精品推荐</p>
					</div>
					<div class="span4">
						<p><span class="suggest-num">{$goods.hot_goods}</span></p>
						<p class="suggest-name">热销商品</p>
					</div>
				</div>
				<div class="row-fluid per-margin">
					<div class="span2 percent-title">新品首发</div>
					<div class="span8">
						<div class="sepH_b progress progress-success">
							<div style="width:{$goods.new_percent}%" class="bar"></div>
						</div>
					</div>
					<div class="span2 percent">{$goods.new_percent}%</div>
				</div>
				<div class="row-fluid per-margin">
					<div class="span2 percent-title">精品推荐</div>
					<div class="span8">
						<div class="sepH_b progress progress-warning">
							<div style="width:{$goods.best_percent}%" class="bar"></div>
						</div>
					</div>
					<div class="span2 percent">{$goods.best_percent}%</div>
				</div>
				<div class="row-fluid per-margin">
					<div class="span2 percent-title">热销商品</div>
					<div class="span8">
						<div class="sepH_b progress progress-info">
							<div style="width:{$goods.hot_percent}%" class="bar"></div>
						</div>
					</div>
					<div class="span2 percent">{$goods.hot_percent}%</div>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="row-fluid other-goods">
				<div class="span4">
				 	 <div class="other-info">
                        <img src="{$static_url}selling.png" alt="">
                        <div class="info">
                            <div class="name">在售商品</div>
                            <span class="count-num"><a target="_blank" href='{url path="goods/admin/init"}'>{$goods.selling}</a></span>
                        </div>
                     </div>
				</div>
				<div class="span4">
				 	 <div class="other-info">
                        <img src="{$static_url}finish.png" alt="">
                        <div class="info">
                            <div class="name">售罄商品</div>
                            <span class="count-num"><a target="_blank" href='{url path="goods/admin/finish"}'>{$goods.finish}</a></span>
                        </div>
                     </div>
				</div>
				<div class="span4">
				 	 <div class="other-info">
                        <img src="{$static_url}obtained.png" alt="">
                        <div class="info">
                            <div class="name">下架商品</div>
                            <span class="count-num"><a target="_blank" href='{url path="goods/admin/obtained"}'>{$goods.obtained}</a></span>
                        </div>
                     </div>
				</div>
			</div>
			<hr>
			<div class="row-fluid other-goods">
				<div class="span4">
				 	 <div class="other-info">
                        <img src="{$static_url}await_check.png" alt="">
                        <div class="info">
                            <div class="name">待审核商品</div>
                            <span class="count-num"><a target="_blank" href='{url path="goods/admin/check"}'>{$goods.await_check}</a></span>
                        </div>
                     </div>
				</div>
				<div class="span4">
				 	 <div class="other-info">
                        <img src="{$static_url}bulk.png" alt="">
                        <div class="info">
                            <div class="name">散装商品</div>
                            <span class="count-num"><a target="_blank" href='{url path="goods/admin/bulk"}'>{$goods.bulk}</a></span>
                        </div>
                     </div>
				</div>
				<div class="span4">
				 	 <div class="other-info">
                        <img src="{$static_url}cashier.png" alt="">
                        <div class="info">
                            <div class="name">收银台商品</div>
                            <span class="count-num"><a target="_blank" href='{url path="goods/admin/cashier"}'>{$goods.cashier}</a></span>
                        </div>
                     </div>
				</div>
			</div>
			
		</div>
	</div>
</div>

<style type="text/css">
.titie-font{
	font-weight:800;
}
.left-border{
	border:1px solid #ccc;
	border-radius:4px;
}
.total-count{
	height:50px;
	line-height:50px;
	background-color: #ebf2f6;
	width:100%;
}
.total-count-margin{
	margin-left:15px;
}
.total-num-col{
	color:#999999 !important;
}
.total-num{
	font-size:17px;
	font-weight:1000;
	display:inline-block;
	margin-left:8px;
	
}
.goods-left-stats{
	margin:15px;
}
.suggest-goods{
	margin-bottom: 10px;
	overflow: hidden;
	position: relative;
}
.suggest-goods .suggest-space{
	padding-left:30px;
}
.suggest-goods .suggest-num{
	font-size:15px;
	font-weight:1000;
	margin-bottom:50px;
}
.suggest-goods .suggest-name{
	font-size:13px;
	color:#999999;
}
.percent-title{
	text-align:center;
	font-size:13px;
	color:#999999;	
}
.percent{
	text-align:center;
	font-size:13px;
	font-weight:bold;
}
.per-margin{
	margin-top:8px !important;
}
.other-goods{
	margin-top:20px;
}
.other-goods .other-info{
	height: 60px;
}
.other-goods .other-info img {
    float: left;
	margin-top: 22px;
}

.other-goods .other-info .info {
    margin-left: 40px;
}

.other-goods .other-info .info .name {
    padding-top: 10px;
    font-weight: bold;
    font-size: 13px;
}

.other-goods .other-info .info .count-num {
    margin-top: 7px;
    padding: 4px 10px;
    display: inline-block;
    font-size: 15px;
	font-weight:1000;
}
hr{
	margin:35px 0;
}
/*.per-border{
	display: inline-block;
    height: 50px;
    border: 1px solid #ccc;
    margin-top: -14px;
    position: relative;
    margin-left: 30px;
	float:right;
	position:relative;
}*/

</style>