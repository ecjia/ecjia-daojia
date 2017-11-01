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
		<li class="{if $smarty.get.check_type eq ''}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin_order/init" args="{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>全部 <span class="badge badge-info">{if $order_list.count.count}{$order_list.count.count}{else}0{/if}</span> </a></li>
        <li class="{if $smarty.get.check_type eq 'verification'}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin_order/init" args="check_type=verification{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>已核销<span class="badge badge-info">{if $order_list.count.verification}{$order_list.count.verification}{else}0{/if}</span> </a></li>
        <li class="{if $smarty.get.check_type eq 'unverification'}active{/if}"><a class="data-pjax" href='{url path="quickpay/admin_order/init" args="check_type=unverification{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>待核销<span class="badge badge-info">{if $order_list.count.unverification}{$order_list.count.unverification}{else}0{/if}</span> </a></li>
</ul>

<div class="row-fluid batch" >
	<form action="{$search_action}{if $filter.type}&type={$filter.type}{/if}" name="searchForm" method="post" >
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>批量操作
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='quickpay/admin_order/batch'}" data-msg="您确实要删除选中的订单吗？" data-noSelectMsg="请先选中要删除的订单！" data-name="id" href="javascript:;"><i class="fontello-icon-trash"></i>删除</a></li>
			</ul>
		</div>
		
		<select class="w200" name="activity_type">
			<option value="0">买单优惠类型</option>
			<!-- {foreach from=$type_list item=list key=key} -->
			<option value="{$key}" {if $key eq $smarty.get.activity_type}selected="selected"{/if}>{$list}</option>
			<!-- {/foreach} -->
		</select>
		<a class="btn m_l5 screen-btn">筛选</a>
		
		<div class="choose_list f_r" >
			<input type="text" name="merchant_keywords" value="{$order_list.filter.merchant_keywords}" placeholder="请输入商家名称"/> 
			<input type="text" name="keywords" value="{$order_list.filter.keywords}" placeholder="请输入订单号或者购买者姓名"/> 
			<button class="btn" type="submit">搜索</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit">
				<thead>
					<tr>
						<th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox" /></th>
						<th class="w100">订单号</th>
						<th class="w120">商家名称</th>
						<th>购买者信息</th>
						<th class="w150">买单优惠类型</th>
						<th class="w150">下单时间</th>
						<th class="w100">消费金额</th>
						<th class="w100">实付金额</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$order_list.list item=order key=okey} -->
					<tr>
						<td><input type="checkbox" class="checkbox" name="order_id[]"  value="{$order.order_id}" /></td>
						<td class="hide-edit-area">
							{$order.order_sn}
							<div class="edit-list"><a href='{url path="quickpay/admin_order/order_info" args="order_id={$order.order_id}"}' class="data-pjax" title="查看详情">查看详情</a></div>
						</td>
						<td class="ecjiafc-red">
							{$order.merchants_name}
						</td>
						<td>{$order.user_name} [TEL：{$order.user_mobile}]</td>
						<td>{if $order.activity_type eq 'discount'}价格折扣{elseif $order.activity_type eq 'everyreduced'}每满多少减多少，最高减多少{elseif $order.activity_type eq 'reduced'}满多少减多少{elseif $order.activity_type eq 'normal'}无优惠{/if}</td>
						<td>{$order.add_time}</td>
						<td>{$order.goods_amount}</td>
						<td>{$order.order_amount}</td>
					</tr>
					<!-- {foreachelse}-->
					<tr><td class="no-records" colspan="8">{lang key='system::system.no_records'}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$order_list.page} -->	
		</div>
	</div>
</div>
<!-- {/block} -->