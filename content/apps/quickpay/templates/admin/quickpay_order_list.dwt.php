<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.order_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class=" fontello-icon-search"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<ul class="nav nav-pills">
		<li class="{if $filter.check_type eq ''}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin_order/init" args="{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="quickpay"}全部{/t}<span class="badge badge-info">{if $order_list.count.count}{$order_list.count.count}{else}0{/if}</span> </a></li>
		 <li class="{if $filter.check_type eq 'unverification'}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin_order/init" args="check_type=unverification{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="quickpay"}待核销{/t}<span class="badge badge-info">{if $order_list.count.unverification}{$order_list.count.unverification}{else}0{/if}</span> </a></li>
        <li class="{if $filter.check_type eq 'verification'}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin_order/init" args="check_type=verification{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="quickpay"}已核销{/t}<span class="badge badge-info">{if $order_list.count.verification}{$order_list.count.verification}{else}0{/if}</span> </a></li>
        <li class="{if $filter.check_type eq 'unpay'}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin_order/init" args="check_type=unpay{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="quickpay"}未付款{/t}<span class="badge badge-info">{if $order_list.count.unpay}{$order_list.count.unpay}{else}0{/if}</span> </a></li>
</ul>

<div class="row-fluid batch" >
	<form action="{$search_action}{if $filter.check_type}&check_type={$filter.check_type}{/if}" name="searchForm" method="post" >
		<div class="f_l m_r5">
			<select class="w100" name="order_status">
				<option value="0">{t domain="quickpay"}订单状态{/t}</option>
				<!-- {foreach from=$status_list item=list key=key} -->
				<option value="{$key}" {if $key eq $smarty.get.order_status}selected="selected"{/if}>{$list}</option>
				<!-- {/foreach} -->
			</select>
		</div>
		
		<div class="f_l m_r5">
			<select class="w200" name="activity_type">
				<option value="0">{t domain="quickpay"}买单优惠类型{/t}</option>
				<!-- {foreach from=$type_list item=list key=key} -->
				<option value="{$key}" {if $key eq $smarty.get.activity_type}selected="selected"{/if}>{$list}</option>
				<!-- {/foreach} -->
			</select>
		</div>
		<a class="btn screen-btn">{t domain="quickpay"}筛选{/t}</a>
		
		<div class="choose_list f_r" >
			<input type="text" name="merchant_keywords" value="{$order_list.filter.merchant_keywords}" placeholder='{t domain="quickpay"}请输入商家名称{/t}'/> 
			<input type="text" name="keywords" value="{$order_list.filter.keywords}" placeholder='{t domain="quickpay"}请输入订单号或者购买者姓名{/t}'/> 
			<button class="btn" type="submit">{t domain="quickpay"}搜索{/t}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<thead>
					<tr>
						<th class="w100">{t domain="quickpay"}订单号{/t}</th>
						<th class="w120">{t domain="quickpay"}商家名称{/t}</th>
						<th>{t domain="quickpay"}购买者信息{/t}</th>
						<th class="w150">{t domain="quickpay"}买单优惠类型{/t}</th>
						<th class="w150">{t domain="quickpay"}下单时间{/t}</th>
						<th class="w80">{t domain="quickpay"}实付金额{/t}</th>
						<th class="w200">{t domain="quickpay"}订单状态{/t}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$order_list.list item=order key=okey} -->
					<tr>
						<td class="hide-edit-area">
							{$order.order_sn}
							<div class="edit-list"><a href='{url path="quickpay/admin_order/order_info" args="order_id={$order.order_id}"}' class="data-pjax" title='{t domain="quickpay"}查看详情{/t}'>{t domain="quickpay"}查看详情{/t}</a></div>
						</td>
						<td class="ecjiafc-red">
							{$order.merchants_name}
						</td>
						<td>{$order.user_name}</td>
						<td>{if $order.activity_type eq 'discount'}
						{t domain="quickpay"}价格折扣{/t}
						{elseif $order.activity_type eq 'everyreduced'}
						{t domain="quickpay"}每满多少减多少，最高减多少{/t}
						{elseif $order.activity_type eq 'reduced'}
						{t domain="quickpay"}满多少减多少{/t}
						{elseif $order.activity_type eq 'normal'}
						{t domain="quickpay"}无优惠{/t}
						{/if}
						</td>
						<td>{$order.add_time}</td>
						<td>{$order.order_amount}</td>
						<td>
							{if $order.order_status eq 1}
							{t domain="quickpay"}已确认{/t}
							{elseif $order.order_status eq 9}
							<font class="ecjiafc-red">{t domain="quickpay"}已取消{/t}</font>
							{elseif $order.order_status eq 99}
							<font class="ecjiafc-red">{t domain="quickpay"}已删除{/t}</font>
							{else}
							{t domain="quickpay"}未确认{/t}
							{/if},
							{if $order.pay_status eq 1}
							{t domain="quickpay"}已付款{/t}
							{else}
							{t domain="quickpay"}未付款{/t}
							{/if},
							{if $order.verification_status eq 1}
							{t domain="quickpay"}已核销{/t}
							{else}
							{t domain="quickpay"}未核销{/t}
							{/if}
						</td>
					</tr>
					<!-- {foreachelse}-->
					<tr><td class="no-records" colspan="8">{t domain="quickpay"}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$order_list.page} -->	
		</div>
	</div>
</div>
<!-- {/block} -->