<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  		<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row-fluid"">
	<div class="span12">
		<form action="{$form_action}" method="post" name="theForm">
			<div id="accordion2" class="foldable-list">
				<div class="accordion-group panel panel-default">
					<div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                <h4 class="panel-title">
                                    <strong>基本信息</strong>
                                </h4>
                            </a>
                     </div>
					<div class="accordion-body in collapse" id="collapseOne">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{t domain="orders"}退货时间：{/t}</strong></div></td>
								<td >{$back_order.formated_return_time}</td>
								<td><div align="right"><strong>运单编号：</strong></div></td>
								<td colspan="3">{$back_order.invoice_no}</td>
							</tr>

							<tr>
								<td><div align="right"><strong>发货单流水号：</strong></div></td>
								<td>{$back_order.delivery_sn}</td>
								<td><div align="right"><strong>发货时间：</strong></div></td>
								<td>{$back_order.formated_update_time}</td>
							</tr>

							<tr>
								<td><div align="right"><strong>订单号：</strong></div></td>
								<td>
									<a href='{url path="orders/merchant/info" args="order_sn={$back_order.order_sn}"}'>{$back_order.order_sn}</a>
									{if $back_order.extension_code eq "group_buy"}
									<!-- <a href="group_buy.php?act=edit&id={$back_order.extension_id}">{$lang.group_buy}</a> -->
									{elseif $back_order.extension_code eq "exchange_goods"}
									<!-- <a href="exchange_goods.php?act=edit&id={$back_order.extension_id}">{$lang.exchange_goods}</a> -->
									{/if}
								</td>
								<td><div align="right"><strong>下单时间：</strong></div></td>
								<td>{$back_order.formated_add_time}</td>
							</tr>

							<tr>
								<td><div align="right"><strong>购货人：</strong></div></td>
								<td>{$back_order.user_name}</td>
								<td><div align="right"><strong>缺货处理：</strong></div></td>
								<td>{$back_order.how_oos}</td>
							</tr>

							<tr>
								<td><div align="right"><strong>配送方式：</strong></div></td>
								<td>
									{if $exist_real_goods}
									{if $back_order.shipping_id gt 0}
									{$back_order.shipping_name}
									{else}
									*
									{/if}
									{if $back_order.insure_fee gt 0}
									保价费用：{$back_order.formated_insure_fee}
									{/if}
									{/if}
								</td>
								<td><div align="right"><strong>配送费用：</strong></div></td>
								<td>{$back_order.shipping_fee}</td>
							</tr>

							<tr>
								<td><div align="right"><strong>是否保价：</strong></div></td>
								<td>{if $insure_yn}是{else}否{/if}</td>
								<td><div align="right"><strong>保价费用：</strong></div></td>
								<td>{$back_order.insure_fee|default:0.00}</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
				
				<div class="accordion-group panel panel-default">
					<div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                <h4 class="panel-title">
                                    <strong>{t domain="orders"}购货人信息{/t}</strong>
                                </h4>
                            </a>
                    </div>
					<div class="accordion-body in collapse" id="collapseTwo">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>收货人：</strong></div></td>
								<td>{$back_order.consignee|escape}</td>
								<td><div align="right"><strong>电子邮件：</strong></div></td>
								<td>{$back_order.email}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>地址：</strong></div></td>
								<td>[{$back_order.region}] {$back_order.address|escape}</td>
								<td><div align="right"><strong>邮编：</strong></div></td>
								<td>{$back_order.zipcode|escape}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>电话：</strong></div></td>
								<td>{$back_order.tel}</td>
								<td><div align="right"><strong>手机：</strong></div></td>
								<td>{$back_order.mobile|escape}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>标志性建筑：</strong></div></td>
								<td>{$back_order.sign_building|escape}</td>
								<td><div align="right"><strong>最佳送货时间：</strong></div></td>
								<td>{$back_order.best_time|escape}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>客户给商家的留言：</strong></div></td>
								<td colspan="3">{$back_order.postscript}</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
				
				<div class="accordion-group panel panel-default">
					<div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                <h4 class="panel-title">
                                    <strong>商品信息</strong>
                                </h4>
                            </a>
                    </div>
					<div class="accordion-body in collapse" id="collapseThree">
						<table class="table table-striped m_b0 order-table-list">
							<tbody>
							<tr class="table-list">
								<td>商品名称 [ 品牌 ]</td>
								<td>货号</td>
								<td>货品号</td>
								<td>属性</td>
								<td>发货数量</td>
							</tr>
							<!-- {foreach from=$goods_list item=goods} -->
							<tr class="table-list">
								<td>
									<!-- {if $goods.goods_id gt 0 && $goods.extension_code neq 'package_buy'} -->
									<a href='{url path="goods/merchant/preview" args="id={$goods.goods_id}"}' target="_blank">{$goods.goods_name} {if $goods.brand_name}[ {$goods.brand_name} ]{/if}</a>
									<!-- {/if} -->
								</td>
								<td>{$goods.goods_sn}</td>
								<td>{$goods.product_sn}</td>
								<td>{$goods.goods_attr}</td>
								<td>{$goods.send_number}</td>
							</tr>
							<!-- {/foreach} -->
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion-group panel panel-default">
					<div class="panel-heading">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                                <h4 class="panel-title">
                                    <strong>操作信息</strong>
                                </h4>
                            </a>
                    </div>
					<div class="accordion-body in collapse" id="collapseFour">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>操作者：</strong></div></td>
							    <td>{$back_order.action_user}</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- {/block} -->