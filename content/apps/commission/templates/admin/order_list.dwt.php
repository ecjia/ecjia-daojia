<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
 ecjia.admin.order.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $smarty.get.store_id && $smarty.get.refer neq 'store'} --><a class="btn plus_or_reply" href='{RC_Uri::url("commission/admin/init", "{$url_args}")}'><i class="fontello-icon-reply"></i>{t}返回全部{/t}</a><!-- {/if} -->
	</h3>
</div>

<div class="row-fluid batch">
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="choose_list f_r">
		    <input type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{lang key='goods::goods.enter_merchant_keywords'}" size="15" />
			<input type="text" name="order_sn" value="{$smarty.get.order_sn}" placeholder="请输入订单号">
			<button class="btn screen-btn" type="button">搜索</button>
		</div>
	</form>
</div>

<div class="row-fluid list-page">
	<div class="span12">
		<div class="tab-content">
			<!-- system start -->
			<div class="row-fluid">
				<table class="table table-striped smpl_tbl dataTable table-hide-edit">
					<thead>
						<tr>
						    <th>{t}类型{/t}</th>
						    <th>{t}订单号{/t}</th>
						    <th>{t}商家名称{/t}</th>
						    <th>{t}下单时间{/t}</th>
						    <th>{t}订单金额{/t}</th>
						    <th>{t}佣金比例{/t}</th>
						    <th>{t}佣金金额{/t}</th>
						    <th>{t}入账时间{/t}</th>
						 </tr>
					</thead>

   				 	<!-- {foreach from=$record_list.item item=list} -->
					<tr>
						<td>{if $list.order_type eq 1}订单{/if}{if $list.order_type eq 2}<span class="ecjiafc-red">退款</span>{/if}</td>
						<td>
							{assign var=order_url value=RC_Uri::url('orders/admin/info',"order_id={$list.order_id}")}
						     <a href="{$order_url}" target="_blank">{$list.order_sn}</a>
						</td>
					    <td>
					  		{assign var=store_url value=RC_Uri::url('store/admin/preview',"store_id={$list.store_id}")}
					     	<a href='{RC_Uri::url("commission/admin/order","store_id={$list.store_id}")}' title="查看此商家订单分成">{$list.merchants_name}</a>
					     	<a href='{$store_url}' title="查看商家资料" target="_blank"><i class="fontello-icon-info-circled"></i></a>
					    </td>
					    <td>{$list.order_add_time_formate}</td>
					    <td>￥{$list.total_fee}</td>
					    <td>{$list.percent_value}%</td>
						<td>
							{if $list.order_type eq 1}￥{$list.brokerage_amount}{/if}{if $list.order_type eq 2}<span class="ecjiafc-red">￥{$list.brokerage_amount}</span>{/if}
						</td>
						<td>{$list.add_time_formate}</td>
					</tr>
					<!-- {foreachelse} -->
				   	<tr><td class="no-records" colspan="8">{t}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</table>
				<!-- {$record_list.page} -->
			</div>
		</div>
	</div>
</div> 
<!-- {/block} -->