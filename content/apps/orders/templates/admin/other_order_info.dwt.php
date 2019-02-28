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
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax">
			<i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="order-status-base order-third-base m_b20">
	<ul class="">
		<li class="step-first">
			<div class="{if $flow_status.key eq '1'}step-cur{else}step-done{/if}">
				<div class="step-no">{if $flow_status.key eq 1}1{/if}</div>
				<div class="m_t5">{t domain="orders"}提交订单{/t}</div>
				<div class="m_t5 ecjiafc-blue">{$order.formated_add_time}</div>
			</div>
		</li>
		<li>
			<div class="{if $flow_status.key eq '3'}step-cur{elseif $flow_status.key gt '3'}step-done{/if}">
				<div class="step-no">{if $flow_status.key lt '4'}2{/if}</div>
				<div class="m_t5">{$flow_status.pay}</div>
				<div class="m_t5 ecjiafc-blue">{$order.pay_time}</div>
			</div>
		</li>
		<li class="step-last">
			<div class="{if $flow_status.key eq '5'}step-cur{elseif $flow_status.key gt '3'}step-done{/if}">
				<div class="step-no">3</div>
				<div class="m_t5">{t domain="orders"}交易完成{/t}</div>
			</div>
		</li>
	</ul>
</div>

<div class="row-fluid">
	<div class="span12 ecjiaf-tac">
		<div class="ecjiaf-fl">
			<h3>{t domain="orders"}订单号：{/t}{$order.order_sn}</h3>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div id="accordion2" class="foldable-list form-inline">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne">
						<strong>{t domain="orders"}基本信息{/t}</strong>
					</a>
				</div>
				<div class="accordion-body in collapse" id="collapseOne">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td>
									<div align="right">
										<strong>{t domain="orders"}订单编号：{/t}</strong>
									</div>
								</td>
								<td>
									{$order.order_sn} {if $order.extension_code eq "group_buy"}
									<a href='{url path="groupbuy/admin/edit" args="id={$order.extension_id}"}' target="_blank"><span class="groupbuy-icon">{t domain="orders"}团{/t}</span></a>
									{/if}
								</td>
								<td>
									<div align="right">
										<strong>{t domain="orders"}订单状态：{/t}</strong>
									</div>
								</td>
								<td>{$order.status}</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										<strong>{t domain="orders"}购买人：{/t}</strong>
									</div>
								</td>
								<td>
									{$order.user_name}
								</td>
								<td>
									<div align="right">
										<strong>{t domain="orders"}购买人手机号：{/t}</strong>
									</div>
								</td>
								<td>{$order.mobile_phone}</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										<strong>{t domain="orders"}支付方式：{/t}</strong>
									</div>
								</td>
								<td>
									{$order.pay_name}
								</td>
								<td>
									<div align="right">
										<strong>{t domain="orders"}下单时间：{/t}</strong>
									</div>
								</td>
								<td>{$order.formated_add_time}</td>
							</tr>

							<tr>
								<td>
									<div align="right">
										<strong>{t domain="orders"}付款时间：{/t}</strong>
									</div>
								</td>
								<td>{$order.pay_time}</td>
								<td>
									<div align="right">
										<strong>{t domain="orders"}订单来源：{/t}</strong>
									</div>
								</td>
								<td colspan="3">{$order.label_referer}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<!-- 店铺信息 start -->
			<!-- {if $order.store_id gt 0} -->
			<div class="accordion-group">
				<div class="accordion-heading accordion-heading-url">
					<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseStore">
						<strong>{t domain="orders"}店铺信息{/t}</strong>
					</div>
				</div>
				<div class="accordion-body in collapse" id="collapseStore">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td>
									<div align="right">
										<strong>{t domain="orders"}店铺名称：{/t}</strong>
									</div>
								</td>
								<td>
									<a href='{url path="store/admin/preview" args="store_id={$order.store_id}"}' target="__blank">{$order.merchants_name}</a>
								</td>
								<td>
									<div align="right">
										<strong>{t domain="orders"}负责人：{/t}</strong>
									</div>
								</td>
								<td>{$order.responsible_person}</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										<strong>{t domain="orders"}联系方式：{/t}</strong>
									</div>
								</td>
								<td>{$order.contact_mobile}</td>
								<td>
									<div align="right">
										<strong>{t domain="orders"}电子邮件：{/t}</strong>
									</div>
								</td>
								<td>{$order.merchants_email}</td>
							</tr>
							{if $order.validate_type eq 2}
							<tr>
								<td>
									<div align="right">
										<strong>{t domain="orders"}公司名称：{/t}</strong>
									</div>
								</td>
								<td colspan="3">{$order.company_name}</td>
							</tr>
							{/if}
						</tbody>
					</table>
				</div>
			</div>
			<!-- {/if} -->
			<!-- 店铺信息 end -->

			{if $order.extension_code eq 'storepickup'}
			<div class="accordion-group">
				<div class="accordion-heading accordion-heading-url">
					<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapsePickup">
						<strong>{t domain="orders"}自提信息{/t}</strong>
					</div>
				</div>
				<div class="accordion-body in collapse" id="collapsePickup">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td>
									<div align="right">
										<strong>{t domain="orders"}提货码：{/t}</strong>
									</div>
								</td>
								<td data-val="{$meta_value.normal}" data-enc="{$meta_value.encryption}">
									{if $meta_value}
										<span class="w150">{$meta_value.encryption}</span>
										<i class="show_meta_value fontello-icon-eye cursor_pointer"></i>
									{else}
                                    {t domain="orders"}暂无{/t}
									{/if}
								</td>
								<td>
									<div align="right">
										<strong>{t domain="orders"}提货状态：{/t}</strong>
									</div>
								</td>
								<td>{$pickup_status}</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										<strong>{t domain="orders"}预约提货时间：{/t}</strong>
									</div>
								</td>
								<td colspan="3">
									{if $order.expect_shipping_time}
                                        {$order.expect_shipping_time}
                                    {else}
                                        {t domain="orders"}暂无{/t}
                                    {/if}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="accordion-group">
				<div class="accordion-heading accordion-heading-url">
					<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseTwo-a">
						<strong>{t domain="orders"}发票信息{/t}</strong>
					</div>
				</div>
				<div class="accordion-body in collapse" id="collapseTwo-a">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td>
									<div align="right">
										<strong>{t domain="orders"}发票类型：{/t}</strong>
									</div>
								</td>
								<td>{$order.inv_type}</td>
								<td>
									<div align="right">
										<strong>{t domain="orders"}纳税人识别码：{/t}</strong>
									</div>
								</td>
								<td>{$inv_tax_no}</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										<strong>{t domain="orders"}发票抬头：{/t}</strong>
									</div>
								</td>
								<td>{if $inv_payee}{$inv_payee}{else}个人{/if}</td>
								<td>
									<div align="right">
										<strong>{t domain="orders"}发票内容：{/t}</strong>
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
						<strong>{t domain="orders"}其他信息{/t}</strong>
					</div>
				</div>
				<div class="accordion-body in collapse" id="collapseTwo">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td>
									<div align="right">
										<strong>{t domain="orders"}订单备注：{/t}</strong>
									</div>
								</td>
								<td colspan="3">{$order.postscript}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			{/if}

			<div class="accordion-group">
				<div class="accordion-heading accordion-heading-url">
					<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseFour">
						<strong>{t domain="orders"}商品信息{/t}</strong>
					</div>
				</div>
				<div class="accordion-body in collapse" id="collapseFour">
					<table class="table table-striped table_vam m_b0 order-table-list">
						<thead>
							<tr class="table-list">
								<th class="w80">{t domain="orders"}商品缩略图{/t}</th>
								<th>{t domain="orders"}商品名称 [ 品牌 ]{/t}</th>
								<th class="w80">{t domain="orders"}货号{/t}</th>
								<th class="w70">{t domain="orders"}货品号{/t}</th>
								<th class="w100">{t domain="orders"}价格{/t}</th>
								<th class="w30">{t domain="orders"}数量{/t}</th>
								<th class="w100">{t domain="orders"}属性{/t}</th>
								<th class="w50">{t domain="orders"}库存{/t}</th>
								<th class="w100">{t domain="orders"}小计{/t}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$goods_list item=goods} -->
							<tr class="table-list">
								<td>
									<img src="{$goods.goods_img}" width='50' />
								</td>
								<td>
									{if $goods.goods_id gt 0 and $goods.extension_code neq 'package_buy'}
									<a href='{url path="goods/admin/preview" args="id={$goods.goods_id}"}' target="_blank">
                                        {$goods.goods_name}
                                        {if $goods.brand_name}
                                            [ {$goods.brand_name} ]
                                        {/if}
                                        {if $goods.is_gift}
                                            {if $goods.goods_price gt 0}
                                                {t domain="orders"}（特惠品）{/t}
                                            {else}
                                                {t domain="orders"}（赠品）{/t}
                                            {/if}
                                        {/if}
                                        {if $goods.parent_id gt 0}{t domain="orders"}（配件）{/t}{/if}
                                    </a>
									{/if}
								</td>
								<td>{$goods.goods_sn}</td>
								<td>{$goods.product_sn}</td>
								<td>
									<div>{$goods.formated_goods_price}</div>
								</td>
								<td>
									<div>{$goods.goods_number}
									</div>
								</td>
								<td>{$goods.goods_attr|nl2br}</td>
								<td>
									<div>{$goods.storage}</div>
								</td>
								<td>
									<div>{$goods.formated_subtotal}</div>
								</td>
							</tr>
							<!-- {foreachelse} -->
							<tr>
								<td class="no-records" colspan="9">{t domain="orders"}该订单暂无商品{/t}</td>
							</tr>
							<!-- {/foreach} -->
							<tr>
								<td colspan="8">
									<div align="right">
										<strong>{t domain="orders"}合计：{/t}</strong>
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
						<strong>{t domain="orders"}费用信息{/t}</strong>
					</div>
				</div>
				<div class="accordion-body in collapse" id="collapseFive">
					<table class="table m_b0">
						<tr>
							<td>
								<div align="right">
                                    {t domain="orders"}商品总金额：{/t}
									<strong>{$order.formated_goods_amount}</strong>
									- {t domain="orders"}折扣：{/t}
									<strong>{$order.formated_discount}</strong>
									- {t domain="orders"}使用积分：{/t}
									<strong>{$order.formated_integral_money}</strong>
									- {t domain="orders"}使用红包：{/t}
									<strong>{$order.formated_bonus}</strong>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div align="right">
									= {if $order.order_amount >= 0} {t domain="orders"}买单实付金额：{/t}
									<strong>{$order.formated_order_amount}</strong>
									{/if}
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseSix">
						<strong>{t domain="orders"}操作记录{/t}</strong>
					</a>
				</div>
				<div class="accordion-body in collapse" id="collapseSix">
					<table class="table table-striped m_b0">
						<thead>
							<tr>
								<th class="w130">
									<strong>{t domain="orders"}操作者{/t}</strong>
								</th>
								<th class="w180">
									<strong>{t domain="orders"}操作时间{/t}</strong>
								</th>
								<th class="w130">
									<strong>{t domain="orders"}订单状态{/t}</strong>
								</th>
								<th class="ecjiafc-pre t_c w150">
									<strong>{t domain="orders"}操作备注{/t}</strong>
								</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$action_list item=action} -->
							<tr>
								<td>{$action.action_user}</td>
								<td>{$action.action_time}</td>
								<td>{$action.action_status}</td>
								<td>{$action.action_note|nl2br}</td>
							</tr>
							<!-- {foreachelse} -->
							<tr>
								<td class="no-records" colspan="4">{t domain="orders"}该订单暂无操作记录{/t}</td>
							</tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->