<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<meta charset="UTF-8">
<title>{t domain="orders"}打印订单{/t}</title>
<style type="text/css">
body,td { font-size:13px; }
</style>

<h1 align="center">{t domain="orders"}订单信息{/t}</h1>
<table width="100%" cellpadding="1">
	<tr>
		<td width="8%">{t domain="orders"}购货人：{/t}</td>
		<td>{if $order.user_name}{$order.user_name}{else}{t domain="orders"}匿名用户{/t}{/if}<!-- 购货人姓名 --></td>
		<td align="right">{t domain="orders"}下单时间：{/t}</td><td>{$order.order_time}<!-- 下订单时间 --></td>
		<td align="right">{t domain="orders"}支付方式：{/t}</td><td>{$order.pay_name}<!-- 支付方式 --></td>
		<td align="right">{t domain="orders"}订单编号：{/t}</td><td>{$order.order_sn}<!-- 订单号 --></td>
	</tr>
	<tr>
		<td>{t domain="orders"}付款时间：{/t}</td><td>{$order.pay_time}</td><!-- 付款时间 -->
		<td align="right">{t domain="orders"}发货时间：{/t}</td><td>{$order.shipping_time}<!-- 发货时间 --></td>
		<td align="right">{t domain="orders"}配送方式：{/t}</td><td>{$order.shipping_name}<!-- 配送方式 --></td>
		<td align="right">{t domain="orders"}运单编号：{/t}</td><td>{$order.invoice_no} <!-- 发货单号 --></td>
	</tr>
	<tr>
		<td>{t domain="orders"}收货地址：{/t}</td>
		<td colspan="7">
			[{$order.region}]&nbsp;{$order.address}&nbsp;<!-- 收货人地址 -->
            {t domain="orders"}收货人：{/t}{$order.consignee}&nbsp;<!-- 收货人姓名 -->
			{if $order.tel}{t domain="orders"}电话：{/t}{$order.tel}&nbsp; {/if}<!-- 联系电话 -->
			{if $order.mobile}{t domain="orders"}手机：{/t}{$order.mobile}{/if}<!-- 手机号码 -->
		</td>
	</tr>
	{if $order.express_user}
	<tr>
		<td>{t domain="orders"}配送员：{/t}</td>
		<td colspan="7">
			{$order.express_user} {$order.express_mobile}
		</td>
	</tr>
	{/if}
</table>
<table width="100%" border="1" style="border-collapse:collapse;border-color:#000;">
	<tr align="center">
		<td bgcolor="#cccccc">{t domain="orders"}商品名称{/t}</td>
		<td bgcolor="#cccccc">{t domain="orders"}货号{/t}</td>
		<td bgcolor="#cccccc">{t domain="orders"}属性{/t}</td>
		<td bgcolor="#cccccc">{t domain="orders"}价格{/t}</td>
		<td bgcolor="#cccccc">{t domain="orders"}数量{/t}</td>
		<td bgcolor="#cccccc">{t domain="orders"}小计{/t}</td>
	</tr>
	<!-- {foreach from=$goods_list item=goods key=key} -->
	<tr>
		<td>&nbsp;{$goods.goods_name}<!-- 商品名称 -->
			{if $goods.is_gift}{if $goods.goods_price gt 0}{t domain="orders"}（特惠品）{/t}{else}{t domain="orders"}（赠品）{/t}{/if}{/if}
			{if $goods.parent_id gt 0}{t domain="orders"}（配件）{/t}{/if}
		</td>
		<td>&nbsp;{$goods.goods_sn} <!-- 商品货号 --></td>
		<td><!-- 商品属性 -->
			<!-- {foreach key=key from=$goods_attr[$key] item=attr} -->
			<!-- {if $attr.name} --> {$attr.name}:{$attr.value} <!-- {/if} -->
			<!-- {/foreach} -->
		</td>
		<td align="right">{$goods.formated_goods_price}&nbsp;<!-- 商品单价 --></td>
		<td align="right">{$goods.goods_number}&nbsp;<!-- 商品数量 --></td>
		<td align="right">{$goods.formated_subtotal}&nbsp;<!-- 商品金额小计 --></td>
	</tr>
	<!-- {/foreach} -->
	<tr>
		<!-- 发票抬头和发票内容 -->
		<td colspan="4">
			{if $order.inv_payee}
            {t domain="orders"}发票抬头：{/t}{$order.inv_payee}&nbsp;&nbsp;&nbsp;
            {t domain="orders"}发票内容：{/t}{$order.inv_content}
			{/if}
		</td>
		<!-- 商品总金额 -->
		<td colspan="2" align="right">{t domain="orders"}商品总金额：{/t}{$order.formated_goods_amount}</td>
	</tr>
</table>
<table width="100%" border="0">
	<tr align="right">
		<td>
			{if $order.discount gt 0}- {t domain="orders"}折扣：{/t}{$order.formated_discount}{/if}{if $order.pack_name and $order.pack_fee neq '0.00'}
			<!-- 包装名称包装费用 -->
				+ {t domain="orders"}包装费用：{/t}{$order.formated_pack_fee}
			{/if}
			{if $order.card_name and $order.card_fee neq '0.00'}<!-- 贺卡名称以及贺卡费用 -->
				+ {t domain="orders"}贺卡费用：{/t}{$order.formated_card_fee}
			{/if}
			{if $order.pay_fee neq '0.00'}<!-- 支付手续费 -->
				+ {t domain="orders"}支付费用：{/t}{$order.formated_pay_fee}
			{/if}
			{if $order.shipping_fee neq '0.00'}<!-- 配送费用 -->
				+ {t domain="orders"}配送费用：{/t}{$order.formated_shipping_fee}
			{/if}
			{if $order.insure_fee neq '0.00'}<!-- 保价费用 -->
				+ {t domain="orders"}保价费用：{/t}{$order.formated_insure_fee}
			{/if}
			<!-- 订单总金额 -->
			= {t domain="orders"}订单总金额：{/t}{$order.formated_total_fee}
		</td>
	</tr>
	<tr align="right">
		<td>
			<!-- 如果已付了部分款项, 减去已付款金额 -->
			{if $order.money_paid neq '0.00'}- {t domain="orders"}已付款金额：{/t}{$order.formated_money_paid}{/if}
			<!-- 如果使用了余额支付, 减去已使用的余额 -->
			{if $order.surplus neq '0.00'}- {t domain="orders"}使用余额：{/t}{$order.formated_surplus}{/if}
			<!-- 如果使用了积分支付, 减去已使用的积分 -->
			{if $order.integral_money neq '0.00'}- {t domain="orders"}使用积分：{/t}{$order.formated_integral_money}{/if}
			<!-- 如果使用了红包支付, 减去已使用的红包 -->
			{if $order.bonus neq '0.00'}- {t domain="orders"}使用红包：{/t}{$order.formated_bonus}{/if}
			<!-- 应付款金额 -->
			= {t domain="orders"}应付款金额：{/t}{$order.formated_order_amount}
		</td>
	</tr>
</table>
<table width="100%" border="0">
	<!-- {if $order.to_buyer} -->
	<tr><!-- 给购货人看的备注信息 -->
		<td>{t domain="orders"}商家给客户的留言：{/t}{$order.to_buyer}</td>
	</tr>
	<!-- {/if}  -->
	<!-- {if $order.invoice_note} -->
	<tr> <!-- 发货备注 -->
		<td>{t domain="orders"}发货备注：{/t}{$order.invoice_note}</td>
	</tr>
	<!-- {/if} -->
	<!-- {if $order.pay_note} -->
	<tr> <!-- 支付备注 -->
		<td>{t domain="orders"}支付备注：{/t}{$order.pay_note}</td>
	</tr>
	<!-- {/if} -->

	<tr><!-- 网店名称, 网店地址, 网店URL以及联系电话 -->
		<td>
			{$shop_name}（{$shop_url}）
			{t domain="orders"}地址：{/t}{$shop_address}&nbsp;&nbsp;{t domain="orders"}电话：{/t}{$service_phone}
		</td>
	</tr>
	<tr align="right"><!-- 订单操作员以及订单打印的日期 -->
		<td>{t domain="orders"}打印时间：{/t}{$print_time}&nbsp;&nbsp;&nbsp;{t domain="orders"}操作者：{/t}{$action_user}</td>
	</tr>
</table>