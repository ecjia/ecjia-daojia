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
		<h3><!-- {if $ur_here}{$ur_here}{/if} --><small>{t domain="express" 1={$name}}（当前配送员：%1）{/t}</small></h3>
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
							<span>{t domain="express"}选择日期：{/t}</span>
	                    	<input class="form-control date w110" name="start_date" type="text" placeholder='{t domain="express"}开始时间{/t}' value="{$start_date}">
	    					<span class="">-</span>
	    					<input class="form-control date w110" name="end_date" type="text" placeholder='{t domain="express"}结束时间{/t}' value="{$end_date}">
	    					<input class="btn btn-primary select-button" type="button" value='{t domain="express"}查询{/t}'>
	    					<input type="hidden" name="user_id" value="{$user_id}">
						</form>
					</div>
				</div>
			</header>
		</section>
		
		<div class="match-account">
			<ul class="list-mod-briefing">
				<li class="span3">
					<div class="bd">{if $order_number}{$order_number}{else}0{/if}<span class="f_s14"> {t domain="express"}单{/t}</span></div>
					<div class="ft"><i class="fa fa-bar-chart-o"></i> {t domain="express"}订单数量{/t}</div>
				</li>
				<li class="span3">
					<div class="bd">{$money.all_money}<span class="f_s14"> {t domain="express"}元{/t}</span></div>
					<div class="ft"><i class="fa fa-truck"></i> {t domain="express"}配送总费用{/t}</div>
				</li>
				<li class="span3">
					<div class="bd">{$money.express_money}<span class="f_s14"> {t domain="express"}元{/t}</span></div>
					<div class="ft"><i class="fa fa-yen"></i> {t domain="express"}配送员应得{/t}</div>
				</li>
				<li class="span3">
					<div class="bd">{$account_money}<span class="f_s14"> {t domain="express"}元{/t}</span></div>
					<div class="ft"><i class="fa fa-user"></i> {t domain="express"}已结算费用{/t}</div>
				</li>
			</ul>
		</div>
		
		<section class="panel">
			<div class="panel-body">
				<section id="unseen">
					<table class="table table-striped table-advance table-hover">
						<thead>
							<tr>
								<th class="w150">{t domain="express"}下单时间{/t}</th>
								<th class="w250">{t domain="express"}配送单号{/t}</th>
								<th class="w100">{t domain="express"}任务类型{/t}</th>
								<th class="w100">{t domain="express"}配送总费用{/t}</th>
								<th class="w100">{t domain="express"}配送员应得{/t}</th>
								<th class="w100">{t domain="express"}结算状态{/t}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$order_list.list item=list} -->
							<tr>
								<td>{$list.receive_time}</td>
								<td>{$list.express_sn}</td>
								<td>{if $list.from eq 'assign'}{t domain="express"}派单{/t}{else}{t domain="express"}抢单{/t}{/if}</td>
								<td>{$list.shipping_fee}</td>
								<td>{$list.commision}</td>
								<td>{if $list.commision_status eq 1}{t domain="express"}已结算{/t}{else}<font class="ecjiafc-red">{t domain="express"}未结算{/t}</font>{/if}</td>
							</tr>
							<!-- {foreachelse} -->
							<tr>
								<td class="dataTables_empty" colspan="7">{t domain="express"}没有找到任何记录{/t}</td>
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