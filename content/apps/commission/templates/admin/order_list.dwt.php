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
		<!-- {if $smarty.get.store_id && $smarty.get.refer neq 'store'} --><a class="btn plus_or_reply" href='{RC_Uri::url("commission/admin/init", "{$url_args}")}'><i class="fontello-icon-reply"></i>{t domain="commission"}返回全部{/t}</a><!-- {/if} -->
	</h3>
</div>

<div class="row-fluid batch">
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="choose_list f_r">
		    <input type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{t domain="commission"}请输入商家关键字{/t}" size="15" />
			<input type="text" name="order_sn" value="{$smarty.get.order_sn}" placeholder="{t domain="commission"}请输入订单号{/t}">
			<button class="btn screen-btn" type="button">{t domain="commission"}搜索{/t}</button>
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
						    <th>{t domain="commission"}类型{/t}</th>
						    <th>{t domain="commission"}订单号{/t}</th>
						    <th>{t domain="commission"}商家名称{/t}</th>
						    <th>{t domain="commission"}订单金额{/t}</th>
						    <th>{t domain="commission"}分佣金额{/t}</th>
						    <th>{t domain="commission"}佣金比例{/t}</th>
						    <th>{t domain="commission"}佣金金额{/t}</th>
						    <th>{t domain="commission"}入账时间{/t}</th>
						    <th>{t domain="commission"}结算状态{/t}</th>
						 </tr>
					</thead>

   				 	<!-- {foreach from=$record_list.item item=list} -->
					<tr>
						<td>{if $list.order_type_name_style}{$list.order_type_name_style}{else}{$list.order_type_name}{/if}</td>
						<td>
						{if $list.order_type eq 'buy'}
							{assign var=order_url value=RC_Uri::url('orders/admin/info',"order_id={$list.order_id}")}
                        {else if $list.order_type eq 'refund'}
                            {assign var=order_url value=RC_Uri::url('refund/admin/refund_detail',"refund_id={$list.order_id}")}
						{else if $list.order_type eq 'quickpay'}
							{assign var=order_url value=RC_Uri::url('quickpay/admin_order/order_info',"order_id={$list.order_id}")}
						{/if}
						     <a href="{$order_url}" target="_blank">{$list.order_sn}</a>
						</td>
					    <td>
					    	{if $list.merchants_name}
						  		{assign var=store_url value=RC_Uri::url('store/admin/preview',"store_id={$list.store_id}")}
						     	<a href='{RC_Uri::url("commission/admin/order","store_id={$list.store_id}")}' title="{t domain="commission"}查看此商家订单结算{/t}">{$list.merchants_name}</a>
						     	<a href='{$store_url}' title="{t domain="commission"}查看商家资料{/t}" target="_blank"><i class="fontello-icon-info-circled"></i></a>
					   		{/if}
					    </td>
					    <td>{$list.total_fee_formatted}</td>
					    <td>{$list.commission_fee_formatted}</td>
					    <td>{$list.percent_value}%</td>
						<td>{$list.brokerage_amount_formatted}</td>
						<td>{$list.add_time}</td>
						<!-- {if $list.bill_status eq '0'} -->
						<td><a class="label btn-warning" href='{RC_Uri::url("commission/admin/order_commission","detail_id={$list.detail_id}")}' title="{t domain="commission"}点击进行结算{/t}" target="_blank">{t domain="commission"}未结算{/t}</a></td>
						<!-- {else} -->
						<td class="ok_color"><a class="label btn-success hint--left" data-hint="{t domain="commission"}结算时间{/t} {$list.bill_time}" title="" data-content="{$list.bill_time}">{t domain="commission"}已结算{/t}</a></td>
					    <!-- {/if} -->
					</tr>
					<!-- {foreachelse} -->
				   	<tr><td class="no-records" colspan="10">{t domain="commission"}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</table>
				<!-- {$record_list.page} -->
			</div>
		</div>
	</div>
</div> 
<!-- {/block} -->