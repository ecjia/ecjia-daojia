<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.order.delivery_info();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" action="{$form_action}" method="post" name="deliveryForm">
			<div id="accordion2" class="foldable-list">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne"><strong>{lang key='orders::order.base_info'}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseOne">
						<table class="table table-oddtd m_b0">
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_order_sn'}</strong></div></td>
								<td>
									{$order.order_sn}
									<!-- {if $order.extension_code eq "group_buy"} -->
<!-- 									<a href="group_buy.php?act=edit&id={$order.extension_id}">{lang key='orders::order.group_buy'}</a> -->
									<!-- {elseif $order.extension_code eq "exchange_goods"}  -->
<!-- 									<a href="exchange_goods.php?act=edit&id={$order.extension_id}">{lang key='orders::order.exchange_goods'}</a> -->
									<!-- {/if}  -->
								</td>
								<td><div align="right"><strong>{lang key='orders::order.label_order_time'}</strong></div></td>
								<td>{$order.formated_add_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_user_name'}</strong></div></td>
								<td>{$order.user_name|default:{lang key='orders::order.anonymous'}}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_how_oos'}</strong></div></td>
								<td>{$order.how_oos}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_shipping'}</strong></div></td>
								<td>
									<!-- {if $exist_real_goods} -->
										<!-- {if $order.shipping_id > 0} -->
											{$order.shipping_name}
										<!-- {else} -->
											{lang key='system::system.require_field'}
										<!-- {/if} -->
										<!-- {if $order.insure_fee > 0} -->
											（{lang key='orders::order.label_insure_fee'}{$order.formated_insure_fee}）
										<!-- {/if} -->
									<!-- {/if} -->
								</td>
								<td><div align="right"><strong>{lang key='orders::order.label_shipping_fee'}</strong></div></td>
								<td>{$order.shipping_fee}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_insure_yn'}</strong></div></td>
								<td>{if $insure_yn}{lang key='system::system.yes'}{else}{lang key='system::system.no'}{/if}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_insure_fee'}</strong></div></td>
								<td>{$order.insure_fee|default:0.00}</td>
							</tr>
							<!-- {if $exist_real_goods}-->
<!-- 						  	<tr> -->
<!-- 								<td><div align="right"><strong>{lang key='orders::order.label_invoice_no'}</strong></div></td> -->
<!-- 								<td colspan="3"><input name="delivery[invoice_no]" type="text" id="invoice_no" value="" size="20"/><input name="delivery_hidden" type="hidden" value="{$exist_real_goods}" /></td> -->
<!-- 						  	</tr> -->
						  	<!-- {/if} -->
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseTwo"><strong>{lang key='orders::order.consignee_info'}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseTwo">
						<table class="table table-oddtd m_b0">
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_consignee'}</strong></div></td>
								<td>{$order.consignee|escape}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_email'}</strong></div></td>
								<td>{$order.email}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_address'}</strong></div></td>
								<td>[{$order.region}] {$order.address|escape}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_zipcode'}</strong></div></td>
								<td>{$order.zipcode|escape}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_tel'}</strong></div></td>
								<td>{$order.tel}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_mobile'}</strong></div></td>
								<td>{$order.mobile|escape}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_sign_building'}</strong></div></td>
								<td>{$order.sign_building|escape}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_best_time'}</strong></div></td>
								<td>{$order.best_time|escape}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_postscript'}</strong></div></td>
								<td colspan="3">{$order.postscript}</td>
							</tr>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseThree"><strong>{lang key='orders::order.goods_info'}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseThree">
						<table class="table table-striped m_b0">
							<thead>
								<tr>
									<td><div><strong>{lang key='orders::order.goods_name_brand'}</strong></div></td>
									<td><div><strong>{lang key='orders::order.goods_sn'}</strong></div></td>
									<td><div><strong>{lang key='orders::order.product_sn'}</strong></div></td>
									<td><div><strong>{lang key='orders::order.goods_attr'}</strong></div></td>
									<!-- {if $suppliers_list neq 0} -->
									<td><div><strong>{lang key='orders::order.suppliers_name'}</strong></div></td>
									<!-- {/if} -->
									<td><div><strong>{lang key='orders::order.storage'}</strong></div></td>
									<td><div><strong>{lang key='orders::order.goods_number'}</strong></div></td>
									<td><div><strong>{lang key='orders::order.goods_delivery'}</strong></div></td>
									<td><div><strong>{lang key='orders::order.goods_delivery_curr'}</strong></div></td>
								</tr>
							</thead>
							<tbody>
								<!-- {foreach from=$goods_list item=goods} -->
								<!--礼包-->
								<!-- {if $goods.goods_id gt 0 && $goods.extension_code eq 'package_buy'} -->
								<tr>
									<td>{$goods.goods_name}<span class="ecjiafc-FF0000">{lang key='orders::order.remark_package'}</span></td>
									<td>{$goods.goods_sn}</td>
									<td>&nbsp;<!--货品货号--></td>
									<td>&nbsp;<!--属性--></td>
									<!-- {if $suppliers_list neq 0} -->
									<td><div></div></td>
									<!-- {/if} -->
									<td><div></div></td>
									<td><div>{$goods.goods_number}</div></td>
									<td><div></div></td>
									<td><div></div></td>
								</tr>
								<!-- {foreach from=$goods.package_goods_list item=package} -->
								<tr>
									<td>
										--&nbsp;<a href='{url path="goods/admin/preview" args="id={$package.goods_id}"}' target="_blank">{$package.goods_name}</a>
									</td>
									<td>{$package.goods_sn}</td>
									<td>{$package.product_sn}</td>
									<td>{$package.goods_attr_str}</td>
									<!-- {if $suppliers_list neq 0} -->
									<td><div>{$suppliers_name[$package.suppliers_id]|default:{lang key='orders::order.restaurant'}}</div></td>
									<!-- {/if} -->
									<td><div>{$package.storage}</div></td>
									<td><div>{$package.order_send_number}</div></td>
									<td><div>{$package.sended}</div></td>
									<td><div><input name="send_number[{$goods.rec_id}][{$package.g_p}]" type="text" id="send_number_{$goods.rec_id}_{$package.g_p}" value="{$package.send}" class="w50" {$package.readonly}/></div></td>
								</tr>
								<!-- {/foreach} -->
								<!-- {else} -->
								<tr>
									<td>
										<!-- {if $goods.goods_id gt 0 && $goods.extension_code neq 'package_buy'} -->
										<a href='{url path="goods/admin/preview" args="id={$goods.goods_id}"}' target="_blank">{$goods.goods_name} {if $goods.brand_name}[ {$goods.brand_name} ]{/if}{if $goods.is_gift}{if $goods.goods_price > 0}{lang key='orders::order.remark_favourable'}{else}{lang key='orders::order.remark_gift'}{/if}{/if}{if $goods.parent_id > 0}{lang key='orders::order.remark_fittings'}{/if}</a>
										<!-- {/if} -->
									</td>
									<td>{$goods.goods_sn}</td>
									<td>{$goods.product_sn}</td>
									<td>{$goods.goods_attr|nl2br}</td>
									<!-- {if $suppliers_list neq 0} -->
									<td><div>{$suppliers_name[$goods.suppliers_id]|default:{lang key='orders::order.restaurant'}}</div></td>
									<!-- {/if} -->
									<td><div>{$goods.storage}</div></td>
									<td><div>{$goods.goods_number}</div></td>
									<td><div>{$goods.sended}</div></td>
									<td><div><input name="send_number[{$goods.rec_id}]" type="text" id="send_number_{$goods.rec_id}" value="{$goods.send}" class="w70" {$goods.readonly}/></div></td>
								</tr>
								<!-- {/if} -->
								<!-- {/foreach} -->
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseFour"><strong>{lang key='orders::order.action_info'}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseFour">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<!-- {if $suppliers_list neq 0} -->
								<tr> 
									<td width="15%"><div align="right"><strong>{lang key='orders::order.label_suppliers'}</strong></div></td> 
									<td colspan="3">
										<select name="suppliers_id" id="suppliers_id">
											<option value="0" selected="selected">{lang key='orders::order.suppliers_no'}</option>
											<!-- {foreach from=$suppliers_list item=suppliers} -->
											<option value="{$suppliers.suppliers_id}">{$suppliers.suppliers_name}</option>
											<!-- {/foreach} -->
										</select>
									</td>
								</tr>
								<!-- {/if} -->
								<tr>
									<td><div align="right"><strong>{lang key='orders::order.label_action_note'}</strong></div></td> 
									<td colspan="3">
										<textarea name="action_note" class="span10" cols="80" rows="3">{$action_note}</textarea>
									</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{lang key='orders::order.label_operable_act'}</strong></div></td> 
									<td colspan="3">
										<button class="btn btn-gebo" type="submit" name="delivery_confirmed">{lang key='orders::order.op_confirm'}{lang key='orders::order.op_split'}</button>
										<a href='{url path="orders/admin/info" args="order_id={$order_id}"}'><button class="btn" type="button">{lang key='system::system.cancel'}</button></a>

										<input name="order_id" type="hidden" value="{$order.order_id}">
										<input name="delivery[order_sn]" type="hidden" value="{$order.order_sn}">
										<input name="delivery[add_time]" type="hidden" value="{$order.order_time}">
										<input name="delivery[user_id]" type="hidden" value="{$order.user_id}">
										<input name="delivery[how_oos]" type="hidden" value="{$order.how_oos}">
										<input name="delivery[shipping_id]" type="hidden" value="{$order.shipping_id}">
										<input name="delivery[shipping_fee]" type="hidden" value="{$order.shipping_fee}">

										<input name="delivery[consignee]" type="hidden" value="{$order.consignee}">
										<input name="delivery[address]" type="hidden" value="{$order.address}">
										<input name="delivery[country]" type="hidden" value="{$order.country}">
										<input name="delivery[province]" type="hidden" value="{$order.province}">
										<input name="delivery[city]" type="hidden" value="{$order.city}">
										<input name="delivery[district]" type="hidden" value="{$order.district}">
										<input name="delivery[sign_building]" type="hidden" value="{$order.sign_building}">
										<input name="delivery[email]" type="hidden" value="{$order.email}">
										<input name="delivery[zipcode]" type="hidden" value="{$order.zipcode}">
										<input name="delivery[tel]" type="hidden" value="{$order.tel}">
										<input name="delivery[mobile]" type="hidden" value="{$order.mobile}">
										<input name="delivery[best_time]" type="hidden" value="{$order.best_time}">
										<input name="delivery[postscript]" type="hidden" value="{$order.postscript}">

										<input name="delivery[how_oos]" type="hidden" value="{$order.how_oos}">
										<input name="delivery[insure_fee]" type="hidden" value="{$order.insure_fee}">
										<input name="delivery[shipping_fee]" type="hidden" value="{$order.shipping_fee}">
										<input name="delivery[agency_id]" type="hidden" value="{$order.agency_id}">
										<input name="delivery[shipping_name]" type="hidden" value="{$order.shipping_name}">
										<input name="operation" type="hidden" value="{$operation}">
									</td>
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