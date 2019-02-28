<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.order_delivery.info();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
			<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form action="{$form_action}" method="post" name="deliveryForm">
			<div id="accordion2" class="foldable-list form-inline">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" href="#collapseOne"><strong>{t domain="orders"}基本信息{/t}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseOne">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>{t domain="orders"}发货单流水号：{/t}</strong></div></td>
									<td>{$delivery_order.delivery_sn}</td>
									<td><div align="right"><strong>{t domain="orders"}发货时间：{/t}</strong></div></td>
									<td>{$delivery_order.formated_update_time}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}订单号：{/t}</strong></div></td>
									<td>
										<a href='{url path="orders/admin/info" args="order_id={$delivery_order.order_id}"}'>{$delivery_order.order_sn}</a>
										{if $delivery_order.extension_code eq "group_buy"}
<!-- 										<a href="group_buy.php?act=edit&id={$delivery_order.extension_id}"><span class="groupbuy-icon">团</span></a> -->
										{elseif $delivery_order.extension_code eq "exchange_goods"}
<!-- 										<a href="exchange_goods.php?act=edit&id={$delivery_order.extension_id}">（积分兑换）</a> -->
										{/if}
									</td>
									<td><div align="right"><strong>{t domain="orders"}下单时间：{/t}</strong></div></td>
									<td>{$delivery_order.formated_add_time}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}购货人：{/t}</strong></div></td>
									<td>{$delivery_order.user_name}</td>
									<td><div align="right"><strong>{t domain="orders"}缺货处理：{/t}</strong></div></td>
									<td>{$delivery_order.how_oos}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}配送方式：{/t}</strong></div></td>
									<td>{if $exist_real_goods}{if $delivery_order.shipping_id gt 0}{$delivery_order.shipping_name}{else}*{/if} {if $delivery_order.insure_fee gt 0}{t domain="orders"}保价费用：{/t}{$delivery_order.formated_insure_fee}{/if}{/if}</td>
									<td><div align="right"><strong>{t domain="orders"}配送费用：{/t}</strong></div></td>
									<td>{$delivery_order.shipping_fee}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}是否保价：{/t}</strong></div></td>
									<td>{if $insure_yn}{t domain="orders"}是{/t}{else}{t domain="orders"}否{/t}{/if}</td>
									<td><div align="right"><strong>{t domain="orders"}保价费用：{/t}</strong></div></td>
									<td>{$delivery_order.insure_fee|default:0.00}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}运单编号：{/t}</strong></div></td>
									<td colspan="3">
										{if $delivery_order.status neq 1}
										<input name="invoice_no" type="text" class="span4" value="{$delivery_order.invoice_no}" {if $delivery_order.status eq 0} readonly="readonly" {/if} />
										{else}
										{$delivery_order.invoice_no}
										{/if}
										<input name="shipping_id" type="hidden" value="{$delivery_order.shipping_id}">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" href="#collapseTwo"><strong>{t domain="orders"}收货人信息{/t}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseTwo">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>{t domain="orders"}收货人：{/t}</strong></div></td>
									<td>{$delivery_order.consignee|escape}</td>
									<td><div align="right"><strong>{t domain="orders"}电子邮件：{/t}</strong></div></td>
									<td>{$delivery_order.email}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}地址：{/t}</strong></div></td>
									<td>[{$delivery_order.region}] {$delivery_order.address|escape}</td>
									<td><div align="right"><strong>{t domain="orders"}邮编：{/t}</strong></div></td>
									<td>{$delivery_order.zipcode|escape}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}电话：{/t}</strong></div></td>
									<td>{$delivery_order.tel}</td>
									<td><div align="right"><strong>{t domain="orders"}手机：{/t}</strong></div></td>
									<td>{$delivery_order.mobile|escape}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}标志性建筑：{/t}</strong></div></td>
									<td>{$delivery_order.sign_building|escape}</td>
									<td><div align="right"><strong>{t domain="orders"}最佳送货时间：{/t}</strong></div></td>
									<td>
										{if $expect_shipping_time}
											{$expect_shipping_time|escape}
										{else}
											{$delivery_order.best_time|escape}
										{/if}
									</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}客户给商家的留言：{/t}</strong></div></td>
									<td colspan="3">{$delivery_order.postscript}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" href="#collapseThree"><strong>{t domain="orders"}商品信息{/t}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseThree">
						<table class="table table-striped m_b0 order-table-list">
							<tbody>
								<tr class="table-list">
									<th>{t domain="orders"}商品名称 [ 品牌 ]{/t}</th>
									<th>{t domain="orders"}货号{/t}</th>
									<th>{t domain="orders"}货品号{/t}</th>
									<th>{t domain="orders"}属性{/t}</th>
									<th>{t domain="orders"}发货数量{/t}</th>
								</tr>
								<!-- {foreach from=$goods_list item=goods} -->
								<tr class="table-list">
									<td>
										<a href='{url path="goods/admin/preview" args="id={$goods.goods_id}"}' target="_blank">{$goods.goods_name} {if $goods.brand_name}[ {$goods.brand_name} ]{/if}</a>
									</td>
									<td>{$goods.goods_sn}</td>
									<td>{$goods.product_sn}</td>
									<td>{$goods.goods_attr|nl2br}</td>
									<td>{$goods.send_number}</td>
								</tr>
								<!-- {/foreach} -->
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" href="#collapseFour"><strong>{t domain="orders"}发货操作信息{/t}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseFour">
						<table class="table table-striped m_b0">
							<thead>
								<tr>
									<th>{t domain="orders"}操作者{/t}</th>
									<th>{t domain="orders"}操作时间{/t}</th>
									<th>{t domain="orders"}订单状态{/t}</th>
									<th>{t domain="orders"}付款状态{/t}</th>
									<th>{t domain="orders"}发货状态{/t}</th>
									<th>{t domain="orders"}备注{/t}</th>
								</tr>
							</thead>
							<tbody>
								<!-- {foreach from=$action_list item=action} -->
								<tr>
									<td><div>{$action.action_user}</div></td>
									<td><div>{$action.action_time}</div></td>
									<td><div>{$action.order_status}</div></td>
									<td><div>{$action.pay_status}</div></td>
									<td><div>{$action.shipping_status}</div></td>
									<td>{$action.action_note|nl2br}</td>
								</tr>
								<!-- {foreachelse} -->
								<tr>
									<td class="no-records" colspan="6">{t domain="orders"}该订单暂无操作记录{/t}</td>
								</tr>
								<!-- {/foreach} -->
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" href="#collapseFive"><strong>{t domain="orders"}发货操作信息{/t}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseFive">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>{t domain="orders"}操作者：{/t}</strong></div></td>
									<td>{$delivery_order.action_user}</td>
								</tr>
								<!-- {if $delivery_order.status neq 1} -->
								<tr>
									<td><div align="right"><span class='input-must'>* </span><strong>{t domain="orders"}操作备注：{/t}</strong></div></td>
									<td><textarea name="action_note" cols="80" rows="5" class="span10"></textarea></td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="orders"}当前可执行操作：{/t}</strong></div></td>
									<td align="left">
										{if $delivery_order.status eq 2}
										<button class="btn" type="submit">{t domain="orders"}发货{/t}</button>
										{else}
										<button class="btn" type="submit">{t domain="orders"}取消发货{/t}</button>
										{/if}
										<input name="order_id" type="hidden" value="{$delivery_order.order_id}">
										<input name="delivery_id" type="hidden" value="{$delivery_order.delivery_id}">
										<input name="act" type="hidden" value="{$action_act}">
									</td>
								</tr>
								<!-- {/if} -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- {/block} -->