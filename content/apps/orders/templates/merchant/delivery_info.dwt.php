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
                            <strong>{lang key='orders::order.base_info'}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse " id="collapseOne">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.delivery_sn_number'}</strong></div></td>
								<td>{$delivery_order.delivery_sn}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_shipping_time'}</strong></div></td>
								<td>{$delivery_order.formated_update_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_order_sn'}</strong></div></td>
								<td>
									<a href='{url path="orders/merchant/info" args="order_sn={$delivery_order.order_sn}"}'>{$delivery_order.order_sn}</a>
									{if $delivery_order.extension_code eq "group_buy"}
<!-- 										<a href="group_buy.php?act=edit&id={$delivery_order.extension_id}">{$lang.group_buy}</a> -->
									{elseif $delivery_order.extension_code eq "exchange_goods"}
<!-- 										<a href="exchange_goods.php?act=edit&id={$delivery_order.extension_id}">{$lang.exchange_goods}</a> -->
									{/if}
								</td>
								<td><div align="right"><strong>{lang key='orders::order.label_time'}</strong></div></td>
								<td>{$delivery_order.formated_add_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.print_buy_name'}</strong></div></td>
								<td>{$delivery_order.user_name|default:{lang key='orders::order.anonymous'}}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_how_oos'}</strong></div></td>
								<td>{$delivery_order.how_oos}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_shipping'}</strong></div></td>
								<td>{if $exist_real_goods}{if $delivery_order.shipping_id gt 0}{$delivery_order.shipping_name}{else}{lang key='system::system.require_field'}{/if} {if $delivery_order.insure_fee gt 0}{lang key='orders::order.label_insure_fee'}{$delivery_order.formated_insure_fee}{/if}{/if}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_shipping_fee'}</strong></div></td>
								<td>{$delivery_order.shipping_fee}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_insure_yn'}</strong></div></td>
								<td>{if $insure_yn}{lang key='system::system.yes'}{else}{lang key='system::system.no'}{/if}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_insure_fee'}</strong></div></td>
								<td>{$delivery_order.insure_fee|default:0.00}</td>
							</tr>
							<!-- {if $shipping_code neq 'ship_o2o_express'} -->
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_invoice_no'}</strong></div></td>
								<td colspan="3">
									{if $delivery_order.status neq 1}
									<input name="invoice_no" type="text" class="w250 form-control" value="{$delivery_order.invoice_no}" {if $delivery_order.status eq 0} readonly="readonly" {/if} />
									{else}
									{$delivery_order.invoice_no}
									{/if}
								</td>
							</tr>
							<!-- {else} -->
							<tr>
							    <td><div align="right"><strong>{lang key='orders::order.label_invoice_no'}</strong></div></td>
							    <td colspan="1">
									{if $delivery_order.status neq 1}
									<input name="invoice_no" type="text" class="w250 form-control" value="{$delivery_order.invoice_no}" {if $delivery_order.status eq 0} readonly="readonly" {/if} />
									{else}
									{$delivery_order.invoice_no}
									{/if}
								</td>
								<td><div align="right"><strong>配送人员：</strong></div></td>
								<td colspan="3" class="delivery-info">
									<!-- {if $delivery_order.status neq 1} -->
									<select class="w250 form-control" name='staff_id'>
										<option value='0'>请选择</option>
										<!-- {foreach from=$staff_user item=list} -->
											<option value="{$list.user_id}" {if $list.user_id eq $express_order.staff_id}selected="selected"{/if}>{$list.name}</option>
										<!-- {/foreach} -->
									</select>
									<!-- {else} -->
									{$delivery_order.invoice_no}
									<!-- {/if} -->
								</td>
							</tr>
							<!-- {/if} -->
							<input name="shipping_id" type="hidden" value="{$delivery_order.shipping_id}">
						</tbody>
					</table>
				</div>
			</div>
			<div class="accordion-group panel panel-default">
				<div class="panel-heading">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                		<h4 class="panel-title"><strong>{lang key='orders::order.consignee_info'}</strong></h4>
                  	</a>
				</div>
				<div class="accordion-body in collapse" id="collapseTwo">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_consignee'}</strong></div></td>
								<td>{$delivery_order.consignee|escape}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_email'}</strong></div></td>
								<td>{$delivery_order.email}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_shop_address'}</strong></div></td>
								<td>[{$delivery_order.region}] {$delivery_order.address|escape}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_zipcode'}</strong></div></td>
								<td>{$delivery_order.zipcode|escape}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_tel'}</strong></div></td>
								<td>{$delivery_order.tel}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_mobile'}</strong></div></td>
								<td>{$delivery_order.mobile|escape}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_sign_building'}</strong></div></td>
								<td>{$delivery_order.sign_building|escape}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_best_time'}</strong></div></td>
								<td>{$delivery_order.best_time|escape}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_postscript'}</strong></div></td>
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
                            <strong>{lang key='orders::order.goods_info'}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse" id="collapseThree">
					<table class="table table-striped m_b0 order-table-list">
						<tbody>
							<tr class="table-list">
								<th>{lang key='orders::order.goods_name_brand'}</th>
								<th>{lang key='orders::order.goods_sn'}</th>
								<th>{lang key='orders::order.product_sn'}</th>
								<th>{lang key='orders::order.goods_attr'}</th>
								<th>{lang key='orders::order.label_send_number'}</th>
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
                            <strong>{lang key='orders::order.op_ship'}{lang key='orders::order.action_info'}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse" id="collapseFour">
					<table class="table table-striped m_b0 order-table-list">
						<tbody>
							<tr class="table-list">
								<th>{lang key='orders::order.action_user_two'}</th>
								<th>{lang key='orders::order.action_time'}</th>
								<th>{lang key='orders::order.order_status'}</th>
								<th>{lang key='orders::order.pay_status'}</th>
								<th>{lang key='orders::order.shipping_status'}</th>
								<th>{lang key='orders::order.action_note'}</th>
							</tr>
							<!-- {foreach from=$action_list item=action} -->
							<tr class="table-list">
								<td><div>{$action.action_user}</div></td>
								<td><div>{$action.action_time}</div></td>
								<td><div>{$action.order_status}</div></td>
								<td><div>{$action.pay_status}</div></td>
								<td><div>{$action.shipping_status}</div></td>
								<td>{$action.action_note|nl2br}</td>
							</tr>
							<!-- {foreachelse} -->
							<tr>
								<td class="no-records" colspan="6">{t}{lang key='orders::order.no_order_operation_record'}{/t}</td>
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
                            <strong>{lang key='orders::order.op_ship'}{lang key='orders::order.action_info'}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse" id="collapseFive">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.action_user'}</strong></div></td>
								<td>{$delivery_order.action_user}</td>
							</tr>
							<!-- {if $delivery_order.status neq 1} -->
							<tr>
								<td><div align="right"><span class="input-must">* </span><strong>{lang key='orders::order.label_action_note'}</strong></div></td>
								<td><textarea name="action_note" cols="80" rows="5" class="span10 form-control"></textarea></td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_operable_act'}</strong></div></td>
								<td align="left">
									{if $delivery_order.status eq 2}
									<button class="btn btn-info" type="submit">{lang key='orders::order.op_ship'}</button>
									{else}
									<button class="btn btn-info" type="submit">{lang key='orders::order.op_cancel_ship'}</button>
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
		</form>
	</div>
</div>
<!-- {/block} -->