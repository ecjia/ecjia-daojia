<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
// 	ecjia.admin.order.info();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<form action="{$form_action}" method="post" name="expressForm" class="form-horizontal">
			<div id="accordion2" class="foldable-list form-inline">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne"><strong>{t domain="shipping"}基本信息：{/t}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseOne">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>{t domain="shipping"}配送流水号：{/t}</strong></div></td>
									<td>{$express_info.delivery_sn}</td>
									<td><div align="right"><strong>{t domain="shipping"}创建时间：{/t}</strong></div></td>
									<td>{$express_info.formatted_add_time}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="shipping"}订单编号：{/t}</strong></div></td>
									<td>
										<a href='{url path="orders/admin/info" args="order_sn={$express_info.order_sn}"}'>{$express_info.order_sn}</a>
									</td>
									<td><div align="right"><strong>{t domain="shipping"}发货单流水号：{/t}</strong></div></td>
									<td>{$express_info.delivery_sn}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="shipping"}配送来源：{/t}</strong></div></td>
									<td>{$express_info.label_from}</td>
									<td><div align="right"><strong>{t domain="shipping"}配送状态：{/t}</strong></div></td>
									<td>{$express_info.label_status}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="shipping"}配送员：{/t}</strong></div></td>
									<td>{$express_info.staff_user}</td>
									<td><div align="right"><strong>{t domain="shipping"}接单时间：{/t}</strong></div></td>
									<td>{$express_info.formatted_receive_time}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="shipping"}取货配送时间：{/t}</strong></div></td>
									<td>{$express_info.formatted_express_time}</td>
									<td><div align="right"><strong>{t domain="shipping"}签收时间：{/t}</strong></div></td>
									<td>{$express_info.formatted_signed_time}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="shipping"}更新时间：{/t}</strong></div></td>
									<td colspan="3">{$express_info.formatted_update_time}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseTwo">
							<strong>{t domain="shipping"}收货人信息{/t}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseTwo">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>{t domain="shipping"}收货人名称：{/t}</strong></div></td>
									<td>{$express_info.consignee|escape}</td>
									<td><div align="right"><strong>{t domain="shipping"}邮箱地址：{/t}</strong></div></td>
									<td>{$express_info.email}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="shipping"}收货地址：{/t}</strong></div></td>
									<td>[{$express_info.region}] {$express_info.address|escape}</td>
									<td><div align="right"><strong>{t domain="shipping"}联系方式：{/t}</strong></div></td>
									<td>{$express_info.mobile}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="shipping"}送货距离：{/t}</strong></div></td>
									<td>{$express_info.distance}</td>
									<td><div align="right"><strong>{t domain="shipping"}期望送货时间：{/t}</strong></div></td>
									<td>{$express_info.label_best_time}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="shipping"}客户给商家的留言：{/t}</strong></div></td>
									<td colspan="3">{$express_info.remark}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseThree">
							<strong>{t domain="shipping"}商品信息{/t}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseThree">
						<table class="table table-striped table_vam m_b0 order-table-list">
							<thead>
								<tr class="table-list">
									<th class="w400">{t domain="shipping"}商品名称 [品牌 ]{/t}</th>
									<th>{t domain="shipping"}货号{/t}</th>
									<th class="w80">{t domain="shipping"}货品号{/t}</th>
									<th class="w70">{t domain="shipping"}属性{/t}</th>
									<th class="w100">{t domain="shipping"}发货数量{/t}</th>
								</tr>
							</thead>
							<tbody>
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
			</div>
		</form>
	</div>
</div>
<!-- {/block} -->