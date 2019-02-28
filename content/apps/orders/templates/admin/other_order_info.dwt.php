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
				<div class="m_t5">提交订单</div>
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
				<div class="m_t5">交易完成</div>
			</div>
		</li>
	</ul>
</div>

<div class="row-fluid">
	<div class="span12 ecjiaf-tac">
		<div class="ecjiaf-fl">
			<h3>订单号：{$order.order_sn}</h3>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div id="accordion2" class="foldable-list form-inline">
			<div class="accordion-group">
				<div class="accordion-heading">
					<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne">
						<strong>基本信息</strong>
					</a>
				</div>
				<div class="accordion-body in collapse" id="collapseOne">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td>
									<div align="right">
										<strong>订单编号：</strong>
									</div>
								</td>
								<td>
									{$order.order_sn} {if $order.extension_code eq "group_buy"}
									<a href='{url path="groupbuy/admin/edit" args="id={$order.extension_id}"}' target="_blank"><span class="groupbuy-icon">团</span></a>
									{/if}
								</td>
								<td>
									<div align="right">
										<strong>订单状态：</strong>
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
									{$order.user_name}
								</td>
								<td>
									<div align="right">
										<strong>购买人手机号：</strong>
									</div>
								</td>
								<td>{$order.mobile_phone}</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										<strong>支付方式：</strong>
									</div>
								</td>
								<td>
									{$order.pay_name}
								</td>
								<td>
									<div align="right">
										<strong>下单时间：</strong>
									</div>
								</td>
								<td>{$order.formated_add_time}</td>
							</tr>

							<tr>
								<td>
									<div align="right">
										<strong>付款时间：</strong>
									</div>
								</td>
								<td>{$order.pay_time}</td>
								<td>
									<div align="right">
										<strong>订单来源：</strong>
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
						<strong>店铺信息</strong>
					</div>
				</div>
				<div class="accordion-body in collapse" id="collapseStore">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td>
									<div align="right">
										<strong>店铺名称：</strong>
									</div>
								</td>
								<td>
									<a href='{url path="store/admin/preview" args="store_id={$order.store_id}"}' target="__blank">{$order.merchants_name}</a>
								</td>
								<td>
									<div align="right">
										<strong>负责人：</strong>
									</div>
								</td>
								<td>{$order.responsible_person}</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										<strong>联系方式：</strong>
									</div>
								</td>
								<td>{$order.contact_mobile}</td>
								<td>
									<div align="right">
										<strong>电子邮件：</strong>
									</div>
								</td>
								<td>{$order.merchants_email}</td>
							</tr>
							{if $order.validate_type eq 2}
							<tr>
								<td>
									<div align="right">
										<strong>公司名称：</strong>
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
						<strong>自提信息</strong>
					</div>
				</div>
				<div class="accordion-body in collapse" id="collapsePickup">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td>
									<div align="right">
										<strong>提货码：</strong>
									</div>
								</td>
								<td data-val="{$meta_value.normal}" data-enc="{$meta_value.encryption}">
									{if $meta_value}
										<span class="w150">{$meta_value.encryption}</span>
										<i class="show_meta_value fontello-icon-eye cursor_pointer"></i>
									{else}
										暂无
									{/if}
								</td>
								<td>
									<div align="right">
										<strong>提货状态：</strong>
									</div>
								</td>
								<td>{$pickup_status}</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										<strong>预约提货时间：</strong>
									</div>
								</td>
								<td colspan="3">
									{if $order.expect_shipping_time} {$order.expect_shipping_time} {else}
									暂无 {/if}
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="accordion-group">
				<div class="accordion-heading accordion-heading-url">
					<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseTwo-a">
						<strong>发票信息</strong>
					</div>
				</div>
				<div class="accordion-body in collapse" id="collapseTwo-a">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td>
									<div align="right">
										<strong>发票类型：</strong>
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
								<td>{if $inv_payee}{$inv_payee}{else}个人{/if}</td>
								<td>
									<div align="right">
										<strong>发票内容：</strong>
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
						<strong>其他信息</strong>
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
						</tbody>
					</table>
				</div>
			</div>
			{/if}

			<div class="accordion-group">
				<div class="accordion-heading accordion-heading-url">
					<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseFour">
						<strong>商品信息</strong>
					</div>
				</div>
				<div class="accordion-body in collapse" id="collapseFour">
					<table class="table table-striped table_vam m_b0 order-table-list">
						<thead>
							<tr class="table-list">
								<th class="w80">商品缩略图</th>
								<th>商品名称 [ 品牌 ]</th>
								<th class="w80">货号</th>
								<th class="w70">货品号</th>
								<th class="w100">价格</th>
								<th class="w30">数量</th>
								<th class="w100">属性</th>
								<th class="w50">库存</th>
								<th class="w100">小计</th>
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
									<a href='{url path="goods/admin/preview" args="id={$goods.goods_id}"}' target="_blank">{$goods.goods_name} {if $goods.brand_name}[ {$goods.brand_name} ]{/if}{if $goods.is_gift}{if $goods.goods_price
										gt 0}（特惠品）{else}（赠品）{/if}{/if}{if $goods.parent_id
										gt 0}（配件）{/if}</a>
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
								<td class="no-records" colspan="9">该订单暂无商品</td>
							</tr>
							<!-- {/foreach} -->
							<tr>
								<td colspan="8">
									<div align="right">
										<strong>合计：</strong>
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
						<strong>费用信息</strong>
					</div>
				</div>
				<div class="accordion-body in collapse" id="collapseFive">
					<table class="table m_b0">
						<tr>
							<td>
								<div align="right">
									商品总金额：
									<strong>{$order.formated_goods_amount}</strong>
									- 折扣：
									<strong>{$order.formated_discount}</strong>
									- 使用积分：
									<strong>{$order.formated_integral_money}</strong>
									- 使用红包：
									<strong>{$order.formated_bonus}</strong>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div align="right">
									= {if $order.order_amount >= 0} 买单实付金额：
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
						<strong>操作记录</strong>
					</a>
				</div>
				<div class="accordion-body in collapse" id="collapseSix">
					<table class="table table-striped m_b0">
						<thead>
							<tr>
								<th class="w130">
									<strong>操作者</strong>
								</th>
								<th class="w180">
									<strong>操作时间</strong>
								</th>
								<th class="w130">
									<strong>订单状态</strong>
								</th>
								<th class="ecjiafc-pre t_c w150">
									<strong>操作备注</strong>
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
								<td class="no-records" colspan="4">该订单暂无操作记录</td>
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