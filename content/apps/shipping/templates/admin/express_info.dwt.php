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
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne"><strong>{lang key='shipping::shipping.admin_base_info'}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseOne">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_express_sn'}</strong></div></td>
									<td>{$express_info.delivery_sn}</td>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_add_time'}</strong></div></td>
									<td>{$express_info.formatted_add_time}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_order_sn'}</strong></div></td>
									<td>
										<a href='{url path="orders/admin/info" args="order_sn={$express_info.order_sn}"}'>{$express_info.order_sn}</a>
									</td>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_delivery_sn'}</strong></div></td>
									<td>{$express_info.delivery_sn}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_from'}</strong></div></td>
									<td>{$express_info.label_from}</td>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_express_status'}</strong></div></td>
									<td>{$express_info.label_status}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_express_staff_name'}</strong></div></td>
									<td>{$express_info.staff_user}</td>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_receive_time'}</strong></div></td>
									<td>{$express_info.formatted_receive_time}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_express_time'}</strong></div></td>
									<td>{$express_info.formatted_express_time}</td>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_signed_time'}</strong></div></td>
									<td>{$express_info.formatted_signed_time}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_update_time'}</strong></div></td>
									<td colspan="3">{$express_info.formatted_update_time}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseTwo">
							<strong>{lang key='shipping::shipping.admin_consignee_info'}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseTwo">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_consignee'}</strong></div></td>
									<td>{$express_info.consignee|escape}</td>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_email'}</strong></div></td>
									<td>{$express_info.email}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_address'}</strong></div></td>
									<td>[{$express_info.region}] {$express_info.address|escape}</td>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_mobile'}</strong></div></td>
									<td>{$express_info.mobile}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_distance'}</strong></div></td>
									<td>{$express_info.distance}</td>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_best_time'}</strong></div></td>
									<td>{$express_info.label_best_time}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{lang key='shipping::shipping.admin_label_remark'}</strong></div></td>
									<td colspan="3">{$express_info.remark}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseThree">
							<strong>{lang key='shipping::shipping.admin_goods_info'}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseThree">
						<table class="table table-striped table_vam m_b0 order-table-list">
							<thead>
								<tr class="table-list">
									<th class="w400">{lang key='shipping::shipping.admin_goods_name_brand'}</th>
									<th>{lang key='shipping::shipping.admin_goods_sn'}</th>
									<th class="w80">{lang key='shipping::shipping.admin_product_sn'}</th>
									<th class="w70">{lang key='shipping::shipping.admin_goods_attr'}</th>
									<th class="w100">{lang key='shipping::shipping.admin_label_send_number'}</th>
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