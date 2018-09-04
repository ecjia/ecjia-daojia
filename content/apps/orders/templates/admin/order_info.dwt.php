<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.order.info();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		{if $ur_here}{$ur_here}{/if} {if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax">
			<i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="modal hide fade" id="consigneeinfo">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='orders::order.buyer_info'}</h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid">
			<div class="span12">
				<table class="table table-bordered">
					<tr>
						<td colspan="2">
							<strong>{lang key='orders::order.buyer_info'}</strong>
						</td>
					</tr>
					<tr>
						<td class="w200">{lang key='orders::order.email'}</td>
						<td>{$user.email}</td>
					</tr>
					<tr>
						<td>{lang key='orders::order.user_money'}</td>
						<td>{$user.user_money}</td>
					</tr>
					<tr>
						<td>{lang key='orders::order.pay_points'}</td>
						<td>{$user.pay_points}</td>
					</tr>
					<tr>
						<td>{lang key='orders::order.rank_points'}</td>
						<td>{$user.rank_points}</td>
					</tr>
					<tr>
						<td>{lang key='orders::order.rank_name'}</td>
						<td>{$user.rank_name}</td>
					</tr>
					<tr>
						<td>{lang key='orders::order.bonus_count'}</td>
						<td>{$user.bonus_count}</td>
					</tr>
				</table>
				
				{foreach from=$address_list item=address}
				<table class="table table-bordered">
					<tr>
						<td colspan="2">
							<strong>{lang key='orders::order.consignee'}:{$order.consignee|default:$order.user_name}</strong>
						</td>
					</tr>
					<tr>
						<td class="w200">{lang key='orders::order.email'}</td>
						<td>{$address.email}</td>
					</tr>
					<tr>
						<td>{lang key='orders::order.address'}</td>
						<td>{$address.address}{$address.address_info}</td>
					</tr>
					<tr>
						<td>{lang key='orders::order.zipcode'}</td>
						<td>{$address.zipcode}</td>
					</tr>
					<tr>
						<td>手机号：</td>
						<td>{$address.mobile}</td>
					</tr>
				</table>
				{/foreach}
				
			</div>
		</div>
	</div>
</div>

<div class="order-status-base order-five-base m_b20">
	<ul class="">
		<li class="step-first">
			<div class="{if $flow_status.key eq '1'}step-cur{else}step-done{/if}">
				<div class="step-no">{if $flow_status.key lt '2'}1{/if}</div>
				<div class="m_t5">{lang key='orders::order.submit_order'}</div>
				<div class="m_t5 ecjiafc-blue">{$order.formated_add_time}</div>
			</div>
		</li>
		<li>
			<div class="{if $flow_status.key eq '2'}step-cur{elseif $flow_status.key gt '2'}step-done{/if}">
				<div class="step-no">{if $flow_status.key lt '3'}2{/if}</div>
				<div class="m_t5">{$flow_status.pay}</div>
				<div class="m_t5 ecjiafc-blue">{$order.pay_time}</div>
			</div>
		</li>
		<li>
			<div class="{if $flow_status.key eq '3'}step-cur{elseif $flow_status.key gt '3'}step-done{/if}">
				<div class="step-no">{if $flow_status.key lt '4'}3{/if}</div>
				<div class="m_t5">{$flow_status.confirm}</div>
				<div class="m_t5 ecjiafc-blue">{if $order.confirm_time && $flow_status.key gt '2'}{$order.confirm_time}{/if}</div>
			</div>
		</li>
		<li>
			<div class="{if $flow_status.key eq '4'}step-cur{elseif $flow_status.key gt '4'}step-done{/if}">
				<div class="step-no">{if $flow_status.key lt '5'}4{/if}</div>
				<div class="m_t5">{$flow_status.shipping}</div>
				<div class="m_t5 ecjiafc-blue">{$order.shipping_time}</div>
			</div>
		</li>
		<li class="step-last">
			<div class="{if $flow_status.key eq '5'}step-cur{elseif $flow_status.key gt '5'}step-done{/if}">
				<div class="step-no">{if $flow_status.key lt '6'}5{/if}</div>
				<div class="m_t5">交易完成</div>
			</div>
		</li>
	</ul>
</div>

<div class="row-fluid">
	<form name="queryinfo" action='{url path="orders/admin/query_info"}' method="post">
		<div class="span12 ecjiaf-tac">
			<div class="ecjiaf-fl">
				<h3>{lang key='orders::order.label_order_sn'}{$order.order_sn}</h3>
			</div>
			<span class="choose_list">
				<input type="text" name="keywords" class="ecjiaf-fn" placeholder="{lang key='orders::order.pls_order_id'}" />
				<button class="btn ecjiaf-fn" type="submit">{lang key='orders::order.search'}</button>
			</span>
			<div class="f_r">
				{if $next_id}
				<a class="data-pjax ecjiaf-tdn" href='{url path="orders/admin/info" args="order_id={$next_id}"}'>
					{/if}
					<button class="btn btn-small" type="button" {if !$next_id}disabled="disabled" {/if}>{lang key='orders::order.prev'}</button>
					{if $next_id}
				</a>
				{/if} {if $prev_id}
				<a class="data-pjax ecjiaf-tdn" href='{url path="orders/admin/info" args="order_id={$prev_id}"}'>
					{/if}
					<button class="btn btn-small" type="button" {if !$prev_id}disabled="disabled" {/if}>{lang key='orders::order.next'}</button>
					{if $prev_id}
				</a>
				{/if}
			</div>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<form action="{$form_action}" method="post" name="orderpostForm" id="listForm" data-url='{url path="orders/admin/operate_post" args="order_id={$order.order_id}"}'
		    data-pjax-url='{url path="orders/admin/info" args="order_id={$order.order_id}"}' data-list-url='{url path="orders/admin/init"}'
		    data-remove-url="{$remove_action}">
			<div id="accordion2" class="foldable-list form-inline">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne">
							<strong>{lang key='orders::order.base_info'}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="collapseOne">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_order_sn'}</strong>
										</div>
									</td>
									<td>
										{$order.order_sn}
									</td>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_order_status'}</strong>
										</div>
									</td>
									<td>{$order.status}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>购买人：</strong>
										</div>
									</td>
									<td>
										{$order.user_name|default:{lang key='orders::order.anonymous'}} {if $order.user_id gt 0} [
										<a class="userInfo cursor_pointer"
										    data-toggle="modal" href="#consigneeinfo" title="{lang key='orders::order.display_buyer'}">{lang key='orders::order.display_buyer'}</a> ] {/if}
									</td>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_order_time'}</strong>
										</div>
									</td>
									<td>{$order.formated_add_time}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_payment'}</strong>
										</div>
									</td>
									<td>
										{$order.pay_name}
									</td>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_pay_time'}</strong>
										</div>
									</td>
									<td>{$order.pay_time}</td>
								</tr>

								<tr>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_shipping'}</strong>
										</div>
									</td>
									<td>
										{if $exist_real_goods}
										<span>{if $order.shipping_name}{$order.shipping_name}{/if}</span>
										{if $order.shipping_id gt 0 && $order.insure_fee gt 0}{lang key='orders::order.label_insure_fee'}{$order.formated_insure_fee}{/if}
										{/if}
									</td>
									<td>
										<div align="right">
											<strong>期望送达时间：</strong>
										</div>
									</td>
									<td>{$order.expect_shipping_time}</td>
								</tr>

								<tr>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_shipping_time'}</strong>
										</div>
									</td>
									<td>{$order.shipping_time}</td>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_invoice_no'}</strong>
										</div>
									</td>
									<td>
										{if $order.shipping_id gt 0 and $order.shipping_status gt 0}
										<span>{if $order.invoice_no}{$order.invoice_no}{else}暂无{/if}</span>
										{/if}
									</td>
								</tr>

								{if $order.express_user}
								<tr>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_express_user'}</strong>
										</div>
									</td>
									<td>{$order.express_user}</td>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_express_user_mobile'}</strong>
										</div>
									</td>
									<td>{$order.express_mobile}</td>
								</tr>
								{/if}

								<tr>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.from_order'}</strong>
										</div>
									</td>
									<td colspan="3">{$order.label_referer}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				
				{if $order_finished eq 1 || $order.shipping_status eq 2}
				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseDelivery">
							<strong>发货单信息</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseDelivery">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>发货单流水号：</strong>
										</div>
									</td>
									<td colspan="3"><a href="{RC_Uri::url('orders/admin_order_delivery/delivery_info')}&delivery_id={$delivery_info.delivery_id}" target="__blank">{$delivery_info.delivery_sn}</a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				{/if}
				
				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseTwo-a">
							<strong>{lang key='orders::order.invoice_information'}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseTwo-a">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_inv_type'}</strong>
										</div>
									</td>
									<td>{$order.inv_type}</td>
									<td>
										<div align="right">
											<strong>纳税人识别码：</strong>
										</div>
									</td>
									<td>{$inv_tax_no}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>发票抬头：</strong>
										</div>
									</td>
									<td>{if $inv_payee}{$inv_payee}{else if $order.inv_type neq ''}个人{/if}</td>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_inv_content'}</strong>
										</div>
									</td>
									<td>{$order.inv_content}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				
				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseTwo">
							<strong>{lang key='orders::order.other_info'}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseTwo">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>订单备注：</strong>
										</div>
									</td>
									<td colspan="3">{$order.postscript}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_how_oos'}</strong>
										</div>
									</td>
									<td colspan="3">{$order.how_oos}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_to_buyer'}</strong>
										</div>
									</td>
									<td colspan="3">{$order.to_buyer}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseThree">
							<strong>{lang key='orders::order.consignee_info'}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseThree">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_consignee'}</strong>
										</div>
									</td>
									<td>{$order.consignee}</td>
									<td>
										<div align="right">
											<strong>手机号：</strong>
										</div>
									</td>
									<td>{$order.mobile}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_address'}</strong>
										</div>
									</td>
									<td colspan="3">[{$order.region}] {$order.address}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseFour">
							<strong>{lang key='orders::order.goods_info'}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseFour">
						<table class="table table-striped table_vam m_b0 order-table-list">
							<thead>
								<tr class="table-list">
									<th class="w80">{lang key='orders::order.product_thumbnail'}</th>
									<th>{lang key='orders::order.goods_name_brand'}</th>
									<th class="w80">{lang key='orders::order.goods_sn'}</th>
									<th class="w70">{lang key='orders::order.product_sn'}</th>
									<th class="w100">{lang key='orders::order.goods_price'}</th>
									<th class="w30">{lang key='orders::order.goods_number'}</th>
									<th class="w100">{lang key='orders::order.goods_attr'}</th>
									<th class="w50">{lang key='orders::order.storage'}</th>
									<th class="w100">{lang key='orders::order.subtotal'}</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$goods_list item=goods}
								<tr class="table-list">
									<td>
										<img src="{$goods.goods_img}" width='50' />
									</td>
									<td>
										{if $goods.goods_id gt 0 and $goods.extension_code neq 'package_buy'}
										<a href='{url path="goods/admin/preview" args="id={$goods.goods_id}"}' target="_blank">{$goods.goods_name} {if $goods.brand_name}[ {$goods.brand_name} ]{/if}{if $goods.is_gift}{if $goods.goods_price
											gt 0}{lang key='orders::order.remark_favourable'}{else}{lang key='orders::order.remark_gift'}{/if}{/if}{if $goods.parent_id
											gt 0}{lang key='orders::order.remark_fittings'}{/if}</a>
										{/if}
									</td>
									<td>{$goods.goods_sn}</td>
									<td>{$goods.product_sn}</td>
									<td>
										<div>{$goods.formated_goods_price}</div>
									</td>
									<td>
										<div>{$goods.goods_number}</div>
									</td>
									<td>{$goods.goods_attr|nl2br}</td>
									<td>
										<div>{$goods.storage}</div>
									</td>
									<td>
										<div>{$goods.formated_subtotal}</div>
									</td>
								</tr>
								{foreachelse}
								<tr>
									<td class="no-records" colspan="9">{lang key='orders::order.order_no_goods'}</td>
								</tr>
								{/foreach}
								<tr>
									<td colspan="5">{if $order.total_weight}
										<div align="right">
											<strong>{lang key='orders::order.label_total_weight'}
											</strong>
										</div>{/if}</td>
									<td colspan="2">{if $order.total_weight}
										<div align="right">{$order.total_weight}
										</div>{/if}</td>
									<td>
										<div align="right">
											<strong>{lang key='orders::order.label_total'}</strong>
										</div>
									</td>
									<td>
										<div align="right">{$order.formated_goods_amount}</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseFive">
							<strong>{lang key='orders::order.fee_info'}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseFive">
						<table class="table m_b0">
							<tr>
								<td>
									<div align="right">
										{lang key='orders::order.label_goods_amount'}
										<strong>{$order.formated_goods_amount}</strong>
										- {lang key='orders::order.label_discount'}
										<strong>{$order.formated_discount}</strong>
										+ {lang key='orders::order.label_tax'}
										<strong>{$order.formated_tax}</strong>
										+ {lang key='orders::order.label_shipping_fee'}
										<strong>{$order.formated_shipping_fee}</strong>
										+ {lang key='orders::order.label_insure_fee'}
										<strong>{$order.formated_insure_fee}</strong>
										+ {lang key='orders::order.label_pay_fee'}
										<strong>{$order.formated_pay_fee}</strong>
										+ {lang key='orders::order.label_pack_fee'}
										<strong>{$order.formated_pack_fee}</strong>
										+ {lang key='orders::order.label_card_fee'}
										<strong>{$order.formated_card_fee}</strong>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div align="right"> = {lang key='orders::order.label_order_amount'}
										<strong>{$order.formated_total_fee}</strong>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										- {lang key='orders::order.label_money_paid'}
										<strong>{$order.formated_money_paid}</strong>
										- {lang key='orders::order.label_surplus'}
										<strong>{$order.formated_surplus}</strong>
										- {lang key='orders::order.label_integral'}
										<strong>{$order.formated_integral_money}</strong>
										- {lang key='orders::order.label_bonus'}
										<strong>{$order.formated_bonus}</strong>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										= {if $order.order_amount >= 0} {lang key='orders::order.label_money_dues'}
										<strong>{$order.formated_order_amount}</strong>
										{else} {lang key='orders::order.label_money_refund'}
										<strong>{$order.formated_money_refund}</strong>
										<input class="refund_click btn" type="button" data-href="{$refund_url}" value="{lang key='orders::order.refund'}"> {/if} {if $order.extension_code eq "group_buy"}
										<br/>{lang key='orders::order.notice_gb_order_amount'}{/if}
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseSix">
							<strong>{lang key='orders::order.operation_record'}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="collapseSix">
						<table class="table table-striped m_b0">
							<thead>
								<tr>
									<th class="w150">
										<strong>{lang key='orders::order.action_user_two'}</strong>
									</th>
									<th class="w180">
										<strong>{lang key='orders::order.action_time'}</strong>
									</th>
									<th class="w150">
										<strong>订单状态</strong>
									</th>
									<th class="ecjiafc-pre t_c w150">
										<strong>操作备注</strong>
									</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$action_list item=action}
								<tr>
									<td>{$action.action_user}</td>
									<td>{$action.action_time}</td>
									<td>{$action.action_status}</td>
									<td>{$action.action_note|nl2br}</td>
								</tr>
								{foreachelse}
								<tr>
									<td class="no-records" colspan="4">{lang key='orders::order.no_order_operation_record'}</td>
								</tr>
								{/foreach}
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
		</form>
	</div>
</div>
<!-- {/block} -->