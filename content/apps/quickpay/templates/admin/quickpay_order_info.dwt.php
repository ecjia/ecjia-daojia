<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
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

<!-- #BeginLibraryItem "/library/quickpay_order_step.lbi" --><!-- #EndLibraryItem -->

<div class="row-fluid">
	<div class="span12">
		<form action="{$form_action}" method="post" name="orderpostForm" id="listForm" data-url='{url path="orders/admin/operate_post" args="order_id={$order.order_id}"}'  data-pjax-url='{url path="orders/admin/info" args="order_id={$order.order_id}"}' data-list-url='{url path="orders/admin/init"}' data-remove-url="{$remove_action}">
			<div id="accordion2" class="foldable-list form-inline">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne"><strong>{lang key='orders::order.base_info'}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseOne">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>订单编号：</strong></div></td>
									<td>
										{$order_info.order_sn}
									</td>
									<td><div align="right"><strong>订单状态：</strong></div></td>
									<td>{$order_info.status}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>购买人姓名：</strong></div></td>
									<td>
										{$order_info.user_name}
									</td>
									<td><div align="right"><strong>购买人手机号：</strong></div></td>
									<td>{$order_info.user_mobile}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>支付方式：</strong></div></td>
									<td>
										{$order_info.pay_name}
									</td>
									<td><div align="right"><strong>支付时间：</strong></div></td>
									<td>{$order_info.pay_time}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>优惠类型：</strong></div></td>
									<td>
										{$order_info.activity_name}
									</td>
									<td><div align="right"><strong>买单来源：</strong></div></td>
									<td>{$order_info.referer}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse"  data-target="#collapseFive">
							<strong>费用信息</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseFive">
						<table class="table m_b0">
							<tr>
								<td>
									<div align="right">
										<strong>买单消费总金额：</strong>¥{if $order_info.goods_amount}{$order_info.goods_amount}{else}0{/if}
										- <strong>买单：</strong>¥{if $order_info.discount}{$order_info.discount}{else}0{/if}
										- <strong>使用积分抵扣：</strong>¥{if $order_info.integral_money}{$order_info.integral_money}{else}0{/if}
										- <strong>使用红包抵扣：</strong>¥{if $order_info.bonus}{$order_info.bonus}{else}0{/if}
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										= 买单实付金额：<strong>{$order_info.order_amount}</strong>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseSix"><strong>{lang key='orders::order.operation_record'}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseSix">
						<table class="table table-striped m_b0">
							<thead>
								<tr>
									<td class="w150">操作者</td>
									<td class="w150">操作时间</td>
									<td class="w180">订单状态</td>
									<td>操作备注</td>
								</tr>
							</thead>
							<tbody>
								<!-- {foreach from=$action_list item=action} -->
								<tr>
									<td>{$action.action_user_name}</td>
									<td>{$action.add_time}</td>
									<td>{$action.order_status_name}</td>
									<td>{$action.action_note}</td>
								</tr>
								<!-- {foreachelse} -->
								<tr>
									<td class="no-records" colspan="4">{lang key='orders::order.no_order_operation_record'}</td>
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