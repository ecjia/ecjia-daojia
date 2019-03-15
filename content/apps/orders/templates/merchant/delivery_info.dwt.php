<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.order_delivery.info();
</script>
<!-- {/block} -->

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

<div class="row-fluid">
	<div class="span12 ">
		<form action="{$form_action}" method="post" name="deliveryForm" class="form-horizontal">
			<div id="accordion2" class="panel panel-default">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <h4 class="panel-title">
                            <strong>{t domain="orders"}基本信息{/t}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse " id="collapseOne">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{t domain="orders"}发货单流水号：{/t}</strong></div></td>
								<td>{$delivery_order.delivery_sn}</td>
								<td><div align="right"><strong>{t domain="orders"}发货时间：{/t}</strong></div></td>
								<td>{$delivery_order.formated_update_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="orders"}订单编号：{/t}</strong></div></td>
								<td>
									<a href='{url path="orders/merchant/info" args="order_id={$delivery_order.order_id}"}'>{$delivery_order.order_sn}</a>
								</td>
								<td><div align="right"><strong>{t domain="orders"}下单时间：{/t}</strong></div></td>
								<td>{$delivery_order.formated_add_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="orders"}购买人：{/t}</strong></div></td>
								<td>{$delivery_order.user_name}</td>
								<td><div align="right"><strong>{t domain="orders"}缺货处理：{/t}</strong></div></td>
								<td>{if $delivery_order.how_oos}{$delivery_order.how_oos}{else}{t domain="orders"}暂无{/t}{/if}</td>
							</tr>
							
							<tr>
								<td><div align="right"><strong>{t domain="orders"}配送方式：{/t}</strong></div></td>
								<td>
									{if $exist_real_goods}
										{if $delivery_order.shipping_id gt 0}
											{$delivery_order.shipping_name}
										{else}
											*
										{/if} 
										{if $delivery_order.insure_fee gt 0}
                                            {t domain="orders"}保价费用：{/t}{$delivery_order.formated_insure_fee}
										{/if}
									{/if}
								</td>
								
								<td><div align="right"><strong>{t domain="orders"}配送人员：{/t}</strong></div></td>
								<td class="delivery-info">
									<!-- {if $delivery_order.status neq 1} -->
									<select class="w250 form-control" name='staff_id' {if $delivery_order.status eq 0} disabled {/if}>
										<option value='0'>{t domain="orders"}自动选择{/t}</option>
										<!-- {foreach from=$staff_user item=list} -->
											<option value="{$list.user_id}" {if $list.user_id eq $express_order.staff_id}selected="selected"{/if}>{$list.name}</option>
										<!-- {/foreach} -->
									</select>
									<!-- {/if} -->
									<div style="margin-top:10px;color:#777;float:left;">{t domain="orders"}注：非必填，未选择默认自动派单{/t}</div>
								</td>
							</tr>
							
							<tr>
								<td><div align="right"><strong>{t domain="orders"}运单编号：{/t}</strong></div></td>
								<td>
									{if $delivery_order.status neq 1}
									<input name="invoice_no" type="text" class="w250 form-control" value="{$delivery_order.invoice_no}" 
										{if $delivery_order.status eq 0 || ($shipping_info.shipping_code eq 'ship_o2o_express' || $shipping_info.shipping_code eq 'ship_ecjia_express')} readonly="readonly" {/if} />
									{else}
									{$delivery_order.invoice_no}
									{/if}
								</td>
								<td><div align="right"><strong>{t domain="orders"}配送费用：{/t}</strong></div></td>
								<td>{$delivery_order.formated_shipping_fee}</td>
							</tr>
							
							<tr>
								<td><div align="right"><strong>{t domain="orders"}是否保价：{/t}</strong></div></td>
								<td>{if $insure_yn}{t domain="orders"}是{/t}{else}{t domain="orders"}否{/t}{/if}</td>
								<td><div align="right"><strong>{t domain="orders"}保价费用：{/t}</strong></div></td>
								<td>{$delivery_order.formated_insure_fee|default:0.00}</td>
							</tr>
							
							<input name="shipping_id" type="hidden" value="{$delivery_order.shipping_id}">
						</tbody>
					</table>
				</div>
			</div>
			<div class="accordion-group panel panel-default">
				<div class="panel-heading">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                		<h4 class="panel-title"><strong>{t domain="orders"}收货人信息{/t}</strong></h4>
                  	</a>
				</div>
				<div class="accordion-body in collapse" id="collapseTwo">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{t domain="orders"}收货人：{/t}</strong></div></td>
								<td>{$delivery_order.consignee|escape}</td>
								<td><div align="right"><strong>{t domain="orders"}手机号码：{/t}</strong></div></td>
								<td>{$delivery_order.mobile|escape}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="orders"}地址：{/t}</strong></div></td>
								<td>[{$delivery_order.region}] {$delivery_order.address|escape}</td>
								<td><div align="right"><strong>{t domain="orders"}最佳送货时间：{/t}</strong></div></td>
								<td>
									{if $expect_shipping_time || $delivery_order.best_time}
										{if $expect_shipping_time}
											{$expect_shipping_time|escape}
										{else}
											{$delivery_order.best_time|escape}
										{/if}
									{else}
                                        {t domain="orders"}暂无{/t}
									{/if}
								</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="orders"}订单备注：{/t}</strong></div></td>
								<td colspan="3">{$delivery_order.postscript}</td>
							</tr>
						</tbody>
					</table>
				</div>
    		</div>
			<div class="accordion-group panel panel-default">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        <h4 class="panel-title">
                            <strong>{t domain="orders"}商品信息{/t}</strong>
                        </h4>
                    </a>
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
									<a href='{url path="goods/merchant/preview" args="id={$goods.goods_id}"}' target="_blank">{$goods.goods_name} {if $goods.brand_name}[ {$goods.brand_name} ]{/if}</a>
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
			<div class="accordion-group panel panel-default">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                        <h4 class="panel-title">
                            <strong>{t domain="orders"}发货操作信息{/t}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse" id="collapseFour">
					<table class="table table-striped m_b0 order-table-list">
						<tbody>
							<tr class="table-list">
								<th>{t domain="orders"}操作者{/t}</th>
								<th>{t domain="orders"}操作时间{/t}</th>
								<th>{t domain="orders"}订单状态{/t}</th>
								<th>{t domain="orders"}备注{/t}</th>
							</tr>
							<!-- {foreach from=$action_list item=action} -->
							<tr class="table-list">
								<td><div>{$action.action_user}</div></td>
								<td><div>{$action.action_time}</div></td>
								<td><div>{$action.action_status}</div></td>
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
			<div class="accordion-group panel panel-default">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                        <h4 class="panel-title">
                            <strong>{t domain="orders"}发货操作信息{/t}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse" id="collapseFive">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<!-- {if $delivery_order.status neq 1} -->
							<tr>
								<td><div align="right"><span class="input-must">* </span><strong>{t domain="orders"}操作备注：{/t}</strong></div></td>
								<td><textarea name="action_note" cols="80" rows="5" class="span10 form-control"></textarea></td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="orders"}当前可执行操作：{/t}</strong></div></td>
								<td align="left">
									{if $delivery_order.status eq 2}
									<button class="btn btn-info" type="submit">{t domain="orders"}发货{/t}</button>
									{else}
									<button class="btn btn-info" type="submit">{t domain="orders"}取消发货{/t}</button>
									{/if}
									<input name="order_id" type="hidden" value="{$delivery_order.order_id}">
									<input name="delivery_id" type="hidden" value="{$delivery_order.delivery_id}">
									<input name="act" type="hidden" value="{$action_act}">
								</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="orders"}操作说明：{/t}</strong></div></td>
								{if $delivery_order.status eq 2}
								<td align="left">
                                    {t domain="orders"}【发货】标记订单为已发货状态{/t}
								</td>
								{else}
								<td align="left">
                                    {t domain="orders"}【取消发货】标记订单为未发货状态{/t}
								</td>
								{/if}
							</tr>
							<!-- {/if} -->
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- {/block} -->
