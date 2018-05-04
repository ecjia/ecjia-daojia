<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.match_list.init()
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="page-header">
	<div class="pull-left">
		<h3><!-- {if $ur_here}{$ur_here}{/if} --><small>（当前配送员：{$name}）</small></h3>
	</div>
  	<div class="pull-right">  		
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
	<div class="clearfix">
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<section class="panel" >
			<header class="panel-heading">
				<div class="all-match">
					<div class="form-group choose_list">
						<form class="form-inline" action="{$form_action}" method="post" name="searchForm">
							<span>选择日期：</span>
	                    	<input class="form-control date w110" name="start_date" type="text" placeholder="开始时间" value="{$start_date}">
	    					<span class="">-</span>
	    					<input class="form-control date w110" name="end_date" type="text" placeholder="结束时间" value="{$end_date}">
	    					<input class="btn btn-primary select-button" type="button" value="查询">
	    					<input type="hidden" name="user_id" value="{$user_id}">
						</form>
					</div>
				</div>
			</header>
		</section>
		
		<div class="match-account">
			<ul class="list-mod-briefing">
				<li class="span3">
					<div class="bd">{if $order_number}{$order_number}{else}0{/if}<span class="f_s14"> 单</span></div>
					<div class="ft"><i class="fa fa-bar-chart-o"></i> 订单数量</div>
				</li>
				<li class="span3">
					<div class="bd">{$money.all_money}<span class="f_s14"> 元</span></div>
					<div class="ft"><i class="fa fa-truck"></i> 配送总费用</div>
				</li>
				<li class="span3">
					<div class="bd">{$money.express_money}<span class="f_s14"> 元</span></div>
					<div class="ft"><i class="fa fa-yen"></i> 配送员应得</div>
				</li>
				<li class="span3">
					<div class="bd">{$account_money}<span class="f_s14"> 元</span></div>
					<div class="ft"><i class="fa fa-user"></i> 已结算费用</div>
				</li>
			</ul>
		</div>
		
		<section class="panel">
			<div class="panel-body">
				<section id="unseen">
					<table class="table table-striped table-advance table-hover">
						<thead>
							<tr>
								<th class="w150">下单时间</th>
								<th class="w250">配送单号</th>
								<th class="w100">任务类型</th>
								<th class="w100">配送总费用</th>
								<th class="w100">配送员应得</th>
								<th class="w100">结算状态</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$order_list.list item=list} -->
							<tr>
								<td>{$list.receive_time}</td>
								<td>{$list.express_sn}</td>
								<td>派单</td>
								<td>{$list.shipping_fee}</td>
								<td>{$list.commision}</td>
								<td>{if $list.commision_status eq 1}已结算{else}<font class="ecjiafc-red">未结算</font>{/if}</td>
							</tr>
							<!-- {foreachelse} -->
							<tr>
								<td class="dataTables_empty" colspan="7">没有找到任何记录</td>
							</tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
					<!-- {$order_list.page} -->
				</section>
			</div>
		</section>
	</div>
</div>
<!-- {/block} -->