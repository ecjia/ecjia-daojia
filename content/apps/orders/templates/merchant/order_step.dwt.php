<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.order.addedit();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
{if $shipping_list_error}
<div class="alert alert-error">
	<strong>{t}您可能没有添加配送插件或填写收货人地址信息！暂无对应的配送方式！{/t}</strong>
</div>
{/if}
{if $step eq "invoice"}
<div class="alert alert-info">
	<strong>{lang key='orders::order.shipping_note'}</strong>
</div>
{/if}
{if $step eq "user"}
<div class="alert alert-info">
	<strong>{lang key='orders::order.notice_user'}</strong>
</div>
{/if}

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --><!-- {if $user_name}<small>（当前用户：{$user_name}）</small>{/if} --></h2>
  	</div>
  	<div class="clearfix"></div>
</div>
{if $step eq "goods"}
<!-- 编辑订单商品信息 -->
<!-- {if $goods_list} -->
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<form name="theForm" action='{url path="orders/merchant/step_post" args="step=edit_goods&order_id={$order_id}&step_act={$step_act}"}' method="post">
				<table class="table order-goods-select table-striped">
					<thead>
						<tr>
							<th class="w200">{lang key='orders::order.goods_name'}</th>
							<th class="w100">{lang key='orders::order.goods_sn'}</th>
							<th>{lang key='orders::order.goods_price'}</th>
							<th class="w120">{lang key='orders::order.goods_number'}</th>
							<th>{lang key='orders::order.goods_attr'}</th>
							<th class="w100">{lang key='orders::order.subtotal'}</th>
							<th class="w150">{lang key='orders::order.handler'}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$goods_list item=goods name="goods"} -->
						<tr class='edit_order_list'>
							<td>
								{if $goods.goods_id gt 0 && $goods.extension_code neq 'package_buy'}
								<a href='{url path="goods/merchant/preview" args="id={$goods.goods_id}"}' id="get_goods_info" target="_blank">{$goods.goods_name}</a>
								{elseif $goods.goods_id gt 0 && $goods.extension_code eq 'package_buy'}
								{$goods.goods_name}
								{/if}
							</td>
							<td>
								{$goods.goods_sn}<input name="rec_id[]" type="hidden" value="{$goods.rec_id}" />
							</td>
							<td>
								<input name="goods_price[]" type="text" class="form-control" value="{$goods.goods_price}" />
								<input name="goods_id[]" type="hidden"  value="{$goods.goods_id}"  />
								<input name="product_id[]" type="hidden"  value="{$goods.product_id}"  />
							</td>
							<td class="edit_numtd">
								<input class="ecjiaf-tac w50 goods_number" name="goods_number[]" type="text" value="{$goods.goods_number}"  />
							</td>
							<td>
								<textarea name="goods_attr[]" cols="30" rows="{$goods.rows}" class="form-control" style="height:68px;overflow:hidden;">{$goods.goods_attr}</textarea>
							</td>
							<td>{$goods.subtotal}</td>
							<td>
								<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg='{t name="{$goods.goods_name}"}您确定要删除订单商品[ %1 ]吗？{/t}' href='{url path="orders/merchant/process" args="func=drop_order_goods&rec_id={$goods.rec_id}&step_act={$step_act}&order_id={$order_id}"}' title="{t}移除{/t}"><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></a>
							</td>
						</tr>
						<!-- {/foreach} -->
						<tr>
							<td colspan="4" class="left-td"><span class="input-must">{lang key='orders::order.price_note'}</span></td>
							<td colspan="1" class="right-td"><strong>{lang key='orders::order.label_total'}</strong>{$goods_amount}</td>
			<!-- 				<td>{$goods_amount}</td> -->
							<td colspan="2" class="panel-heading form-inline">
<!-- 								{if $smarty.foreach.goods.total gt 0} -->
<!-- 								<button class="btn btn-info" type="submit" name="edit_goods">{lang key='orders::order.update_goods'}</button> -->
<!-- 								{/if} -->
                        			<p class="ecjiaf-tac m_t15">
                        				<button class="btn btn-info" type="submit" name="finish">{lang key='orders::order.update_goods'}</button>&nbsp;&nbsp;&nbsp;
                        				<input name="finish" type="hidden" value="{lang key='orders::order.button_submit'}" />
                        				<a class="cancel_order" data-href='{url path="orders/merchant/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'><button class="btn btn-info" type="button">{lang key='orders::order.button_cancel'}</button></a>
                        			</p>
								<input name="goods_count" type="hidden" value="{$smarty.foreach.goods.total}" />
							</td>
						</tr>
					</tbody>
				</table>
			</form>
		</section>
	</div>
</div>
<!-- {/if} -->

<div class="row">
	<div class="col-lg-12 panel-heading form-inline">
		<span>{lang key='orders::order.search_goods'}</span>
		<input class="form-control" type="text" name="keyword" placeholder="请输入关键字" />
		<button class="btn searchGoods btn-info" type="button">{lang key='orders::order.button_search'}</button>
	</div>
</div>

<div class="row-fluid draggable">
	<div class="ms-container ms-container-nobg" id="ms-custom-navigation">
		<div class="ms-selectable ms-not-selectable" id="goodslist"  data-change-url='{url path="orders/merchant/goods_json"}'>
			<div class="search-header">
				<input class="form-control" id="ms-search" type="text" placeholder="{t}筛选搜索到的商品信息{/t}" autocomplete="off">
			</div>
			<ul class="ms-list nav-list-ready order-select-goods">
				<li class="ms-elem-selectable disabled"><span>暂无内容</span></li>
			</ul>
		</div>
		<form class="form-horizontal" name="goodsForm" action='{url path="orders/merchant/step_post" args="step=add_goods&order_id={$order_id}&step_act={$step_act}"}' method="post"  data-search-url='{url path="orders/merchant/search_goods"}' data-goods-url='{url path="orders/merchant/add" args="step=goods&order_id={$order_id}"}'>
			<fieldset class="edit-page">
				<div class="ms-selection order-goods-select">
					<div class="custom-header custom-header-align"><span>商品信息</span>
					</div>
					<div class="add-goods"><a class="goods_info ecjiaf-dn" href="javascript:;">{lang key='orders::order.add_to_order'}</a></div>
					<div class="ms-list nav-list-content ">
						<div class="ecjiaf-dn goods_info h110">
							<div class="ecjiaf-fl ecjiaf-tac col-lg-5 m_t20">
								<span id="goods_img"></span>
							</div>
							<div class="ecjiaf-fl m_t15 col-lg-7">
								<dl>
									<dd><span id="goods_name"></span></dd>
									<dd>{t}货号：{/t}<span id="goods_sn"></span></dd>
<!-- 									<dd>{lang key='orders::order.brand'}：<span id="goods_brand"></span></dd> -->
									<dd>{lang key='orders::order.label_category'}<span id="goods_cat"></span></dd>
									<dd>{t}商品库存：{/t}<span id="goods_number"></span></dd>
								</dl>
							</div>
						</div>
						<div class="ecjiaf-dn goods_info row-fluid">
							<div class="form-group">
								<label class="control-label col-lg-2">{lang key='orders::order.label_goods_price'}</label>
								<div class="col-lg-8" id="add_price">
								</div>
							</div>
						</div>
						<div id="sel_goodsattr">
						</div>
						<div class="ecjiaf-dn goods_info row-fluid">
							<div class="form-group">
								<label class="control-label col-lg-2">{lang key='orders::order.label_goods_number'}</label>
								<div class="col-lg-6" id="add_price">
									<input class="w50 ecjiaf-tac goods_number" name="add_number" type="text" value="1">
								</div>
							</div>
						</div>

						<ul class="ecjiaf-dn goods_info">

							<li class="goods_attr">
								<div>{t}商品属性{/t}</div></li>
							<li>
							<div id="goods_attr"></div><input type="hidden" name="spec_count" value="0" /></li>
						</ul>
					</div>
				</div>
			</fieldset>
			<input name="goodslist" type="hidden" />
		</form>
	</div>
</div>
{elseif $step eq "consignee"}
<!-- 编辑订单收货人信息 -->
<form class="form-horizontal" name="consigneeForm" action='{url path="orders/merchant/step_post" args="step={$step}&order_id={$order_id}&step_act={$step_act}"}' method="post" >
	<!--{if $address_list}-->
	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<table class="table table-striped table-hover table-hide-edit">
					<thead>
						<tr>
							<th class="w30">&nbsp;</th>
							<th class="w100">{t}收货人{/t}</th>
							<th class="w200">{t}所在地区{/t}</th>
							<th>{t}详细地址{/t}</th>
							<th class="w80">{t}邮编{/t}</th>
							<th class="w200">{t}电话/手机{/t}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$address_list key=Key item=val} -->
						<tr class="{if $val.default_address}info{/if}">
							<td>
								<input id="radio_{$val.address_id}" type="radio" name='user_address' value="{$val.address_id}"/>
								<label for="radio_{$val.address_id}"></label>
							</td>
							<td>{$val.consignee|escape}<br>{if $val.default_address}(默认收货地址){/if}</td>
							<td>{$val.country_name} {$val.province_name} {$val.city_name} {$val.district_name}</td>
							<td>{$val.address|escape}{$val.address_info|escape}</td>
							<td>{$val.zipcode|escape}</td>
							<td>
								{lang key='orders::order.label_tel'}{$val.tel}<br/>
								{lang key='orders::order.label_mobile'}{$val.mobile}
							</td>
							<!-- <td>{lang key='orders::order.label_best_time'}{$val.best_time|escape}<br/>{lang key='orders::order.label_sign_building'}{$val.sign_building|escape}<br/>email：{$val.email}</td> -->
						</tr>
						<!-- {/foreach} -->
						<tr>
							<td>
								<input id="user_address" type="radio" name='user_address' {if $order.consignee neq ""}checked{/if} value="-1"/>
								<label for="user_address"></label>
							</td>
							<td colspan='5'>{t}填写收货地址{/t}</td>
						</tr>
					</tbody>
				</table>
			</section>
		</div>
	</div>
	<!--{/if}-->
	<div class="row" id='add_address'>
  		<div class="col-lg-12">
      		<section class="panel">
          		<div class="panel-body">
					<div class="row-fluid m_t20 {if $address_list && $order.consignee eq ''}ecjiaf-dn{/if}">
						<div class="order-step-formgroup form-group">
							<label class="control-label col-lg-2">{lang key='orders::order.label_consignee'}</label>
							<div class="col-lg-6 form-inline" >
								<input type="text" name="consignee" class="form-control" value="{$order.consignee}"/>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
						</div>
						<!--{if $exist_real_goods} -->
						<div class="order-step-formgroup form-group">
							<label class="control-label col-lg-2">{t}详细地址 ：{/t}</label>
							<div class="col-lg-6 form-inline" >
								<input type="text" name="address" class="form-control" value="{$order.address}"/>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
						</div>
						<div class="form-group order-step">
							<label class="control-label col-lg-2">{t}所在地区：{/t}</label>
							<div class="col-lg-6 form-inline" >
								<div class="form-group">
									<select class="form-control" name="country" data-toggle="regionSummary" data-url='{url path="shipping/region/init"}' data-type="1" data-target="region-summary-provinces">
										<option value="" selected="selected">{lang key='system::system.select_please'}</option>
										<!--{foreach from=$country_list item=country} -->
										<option value="{$country.region_id}" {if $order.country eq $country.region_id}selected{/if}>{$country.region_name}</option>
										<!--{/foreach} -->
									</select>
								</div>
								<div class="form-group">
									<select class="region-summary-provinces form-control" name="province" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities">
										<option value="">{lang key='system::system.select_please'}</option>
										<!--{foreach from=$province_list item=province} -->
										<option value="{$province.region_id}" {if $order.province eq $province.region_id}selected{/if}>{$province.region_name}</option>
										<!-- {/foreach} -->
									</select>
								</div>
								<div class="form-group">
									<select class="region-summary-cities form-control" name="city" data-toggle="regionSummary" data-type="3" data-target="region-summary-districts">
										<option value="">{lang key='system::system.select_please'}</option>
										<!-- {foreach from=$city_list item=city} -->
										<option value="{$city.region_id}" {if $order.city eq $city.region_id}selected{/if}>{$city.region_name}</option>
										<!-- {/foreach} -->
									</select>
								</div>
								<div class="form-group">
									<select class="region-summary-districts form-control" name="district" >
										<option value="">{lang key='system::system.select_please'}</option>
										<!-- {foreach from=$district_list item=district} -->
										<option value="{$district.region_id}" {if $order.district eq $district.region_id}selected{/if}>{$district.region_name}</option>
										<!-- {/foreach} -->
									</select>
								</div>
								<span class="input-must">{lang key='system::system.require_field'}</span>
							</div>
						</div>
						<div class="order-step-formgroup form-group">
							<label class="control-label col-lg-2">{lang key='orders::order.label_zipcode'}</label>
							<div class="col-lg-6 form-inline" >
								<input type="text" name="zipcode" class="form-control" value="{$order.zipcode}" />
							</div>
						</div>
						<!-- {/if} -->
						<div class="order-step-formgroup form-group">
							<label class="control-label col-lg-2">{lang key='orders::order.label_mobile'}</label>
							<div class="col-lg-6 form-inline" >
								<input type="text" name="mobile" class="form-control" value="{$order.mobile}" />
							</div>
						</div>
						<div class="order-step-formgroup form-group">
							<label class="control-label col-lg-2">{lang key='orders::order.label_email'}</label>
							<div class="col-lg-6 form-inline" >
								<input type="text" name="email" class="form-control" value="{$order.email}" autocomplete="off"/>
							    <span class="input-must">*</span>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
	<p class="ecjiaf-tac m_t15">
		<button class="btn btn-info" type="submit" name="finish">{lang key='orders::order.button_submit'}</button>
		<a class="cancel_order btn-info" data-href='{url path="orders/merchant/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'>
		<button class="btn btn-info" type="button">{lang key='orders::order.button_cancel'}</button></a>
		<input name="finish" type="hidden" value="{lang key='orders::order.button_submit'}" />
	</p>
</form>
{elseif $step eq "shipping"}
<!-- 编辑订单配送方式 -->
<form name="shippingForm" action='{url path="orders/merchant/step_post" args="step={$step}&order_id={$order_id}&step_act={$step_act}"}' method="post">
	<!-- {if $exist_real_goods} -->
	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<table class="table table-striped table-hover table-hide-edit">
					<thead>
						<tr>
							<th class="w35">&nbsp;</th>
							<th class="w100">{lang key='orders::order.name'}</th>
							<th>{lang key='orders::order.desc'}</th>
							<th class="w100">{lang key='orders::order.shipping_fee'}</th>
							<th class="w100">{lang key='orders::order.free_money'}</th>
							<th class="w100">{lang key='orders::order.insure'}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$shipping_list item=shipping} -->
						<tr>
							<td>
								<input id="{$shipping.shipping_id}" name="shipping" type="radio" data-cod="{$shipping.support_cod}" value="{$shipping.shipping_id}" {if $order.shipping_id eq $shipping.shipping_id}checked{/if} />
								<label for="{$shipping.shipping_id}"></label>
							</td>
							<td>{$shipping.shipping_name}</td>
							<td>{$shipping.shipping_desc}</td>
							<td><div>{$shipping.format_shipping_fee}</div></td>
							<td><div>{$shipping.free_money}</div></td>
							<td><div>{$shipping.insure}</div></td>
						</tr>
						<!-- {foreachelse}-->
    					<tr><td class="no-records" colspan="6">没有找到任何记录</td></tr>
    					<!-- {/foreach} -->
					</tbody>
				</table>
			</section>
		</div>
	</div>
	<p align="right">
		<input id="insure" class="form-control" name="insure" type="checkbox" value="1" {if $order.insure_fee > 0}checked{/if} />
		<label for="insure">{lang key='orders::order.want_insure'}</label>
	</p>
	<!--{/if}-->

	<div class="page-header">
		<div class="pull-left">
			<h2><!-- {if $ur_heres}{$ur_heres}{/if} --></h2>
	  	</div>
	  	<div class="clearfix"></div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<table class="table table-striped table-hover table-hide-edit">
					<thead>
						<tr>
							<th class="w35">&nbsp;</th>
							<th class="w100">{lang key='orders::order.name'}</th>
							<th>{lang key='orders::order.desc'}</th>
							<th class="w100">{lang key='orders::order.pay_fee'}</th>
						</tr>
					</thead>
					<!-- {foreach from=$payment_list item=payment} -->
					<tr>
						<td>
						<input id="{$payment.pay_id}" type="radio" name="payment" data-cod="{$payment.is_cod}" value="{$payment.pay_id}" {if $order.pay_id eq $payment.pay_id}checked{/if} />
						<label for="{$payment.pay_id}"></label>
						</td>
						<td>{$payment.pay_name}</td>
						<td>{$payment.pay_desc}</td>
						<td>{$payment.pay_fee}</td>
					</tr>
					<!-- {foreachelse}-->
    				<tr><td class="no-records" colspan="4">没有找到任何记录</td></tr>
    				<!-- {/foreach} -->
				</table>
			</section>
		</div>
	</div>
	<p align="center">
		<button class="btn btn-info" type="submit" name="finish">{lang key='orders::order.button_submit'}</button>
		<a class="cancel_order" data-href='{url path="orders/merchant/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'><button class="btn btn-info" type="button">{lang key='orders::order.button_cancel'}</button></a>
		<input name="finish" type="hidden" value="{lang key='orders::order.button_submit'}" />
	</p>
</form>
{elseif $step eq "other"}
<!-- 编辑订单其他信息 -->
<div class="row">
	<div class="col-lg-12">
		<form class="form-horizontal" name="otherForm" action='{url path="orders/merchant/step_post" args="step={$step}&order_id={$order_id}&step_act={$step_act}"}' method="post">
			<!-- {if $exist_real_goods}-->
			<div id="accordion2" class="panel panel-default order-step-accordion">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <h4 class="panel-title">
                            <strong>{t}发票相关{/t}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse " id="collapseOne">
					<div class="form-group first-form-group">
						<label class="control-label col-lg-2">{lang key='orders::order.label_inv_type'}</label>
						<div class="col-lg-8">
							<input name="inv_type" class="form-control" type="text" id="inv_type" value="{$order.inv_type}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">{lang key='orders::order.label_inv_payee'}</label>
						<div class="col-lg-8">
							<input name="inv_payee" class="form-control" value="{$order.inv_payee}" type="text" />
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">{lang key='orders::order.label_inv_content'}</label>
						<div class="col-lg-8">
							<input name="inv_content" class="form-control" value="{$order.inv_content}" type="text" />
						</div>
					</div>
				</div>
			</div>
			<!-- {/if} -->

			<div id="accordion2" class="panel panel-default order-step-accordion">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        <h4 class="panel-title">
                            <strong>{t}留言/备注{/t}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse " id="collapseTwo">
					<div class="form-group first-form-group">
						<label class="control-label col-lg-2">{lang key='orders::order.label_postscript'}</label>
						<div class="col-lg-8">
							<textarea name="postscript" class="form-control action_note" cols="60" rows="3">{$order.postscript}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">{lang key='orders::order.label_how_oos'}</label>
						<div class="col-lg-8">
							<textarea name="how_oos" class="form-control action_note" cols="60" rows="3">{$order.how_oos}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">{lang key='orders::order.label_to_buyer'}</label>
						<div class="col-lg-8">
							<textarea name="to_buyer" class="form-control action_note" cols="60" rows="3">{$order.to_buyer}</textarea>
						</div>
					</div>
				</div>
			</div>
			<p align="center">
				<button class="btn btn-info" type="submit" name="finish">{lang key='orders::order.button_submit'}</button>
				<a class="cancel_order" data-href='{url path="orders/merchant/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'><button class="btn btn-info" type="button">{lang key='orders::order.button_cancel'}</button></a>
				<input name="finish" type="hidden" value="{lang key='orders::order.button_submit'}" />
			</p>
		</form>
	</div>
</div>
{elseif $step eq "money"}
<!-- 编辑订单费用信息 -->
<div class="row">
	<div class="col-lg-12">
		<form name="moneyForm" action='{url path="orders/merchant/step_post" args="step={$step}&order_id={$order_id}&step_act={$step_act}"}' method="post">
			<div id="accordion2" class="panel panel-default order-step-accordion">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <h4 class="panel-title">
                            <strong>{lang key='orders::order.order_info'}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse " id="collapseOne">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_goods_amount'}</strong></div></td>
								<td>{$order.formated_goods_amount}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_discount'}</strong></div></td>
								<td><input class="form-control" name="discount" type="text" id="discount" value="{$order.discount}" /></td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_tax'}</strong></div></td>
								<td><input class="form-control" name="tax" type="text" id="tax" value="{$order.tax}" /></td>
								<td><div align="right"><strong>{lang key='orders::order.label_order_amount'}</strong></div></td>
								<td>{$order.formated_total_fee}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_shipping_fee'}</strong></div></td>
								<td>{if $exist_real_goods}<input class="form-control" name="shipping_fee" type="text" value="{$order.shipping_fee}" >{else}0{/if}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_money_paid'}</strong></div></td>
								<td>{$order.formated_money_paid} </td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_insure_fee'}</strong></div></td>
								<td>{if $exist_real_goods}<input class="form-control" name="insure_fee" type="text" value="{$order.insure_fee}" >{else}0{/if}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_surplus'}</strong></div></td>
								<td>
									{if $order.user_id gt 0}
									<input class="form-control" name="surplus" type="text" value="{$order.surplus}">
									{/if}
									{lang key='orders::order.available_surplus'}{$available_user_money|default:0}
								</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_pay_fee'}</strong></div></td>
								<td><input class="form-control" name="pay_fee" type="text" value="{$order.pay_fee}"></td>
								<td><div align="right"><strong>{lang key='orders::order.label_integral'}</strong></div></td>
								<td>
									{if $order.user_id gt 0}
									<input class="form-control" name="integral" type="text" value="{$order.integral}" >
									{/if} {lang key='orders::order.available_integral'}{$available_pay_points|default:0}
								</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_pack_fee'}</strong></div></td>
								<td>
									{if $exist_real_goods}
									<input class="form-control" name="pack_fee" type="text" value="{$order.pack_fee}" >
									{else}0{/if}
								</td>
								<td><div align="right"><strong>{lang key='orders::order.label_bonus'}</strong></div></td>
								<td>
									<select class="form-control" name="bonus_id">
										<option value="0" {if $order.bonus_id eq 0}selected{/if}>{lang key='system::system.select_please'}</option>
										<!-- {foreach from=$available_bonus item=bonus} -->
										<option value="{$bonus.bonus_id}" {if $order.bonus_id eq $bonus.bonus_id}selected{/if} money="{$bonus.type_money}">{$bonus.type_name} - {$bonus.type_money}</option>
										<!--{/foreach}  -->
									</select>
								</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_card_fee'}</strong></div></td>
								<td>
									{if $exist_real_goods}
									<input class="form-control" name="card_fee" type="text" value="{$order.card_fee}">
									{else}0{/if}
								</td>
								<td><div align="right"><strong>{if $order.order_amount >= 0} {lang key='orders::order.label_money_dues'} {else} {lang key='orders::order.label_money_refund'} {/if}</strong></div></td>
								<td>{$order.formated_order_amount}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<p align="center">
				<button class="btn btn-info" type="submit" name="finish">{lang key='orders::order.button_finish'}</button>&nbsp;&nbsp;&nbsp;
				<a class="cancel_order" data-href='{url path="orders/merchant/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'><button class="btn btn-info" type="button">{lang key='orders::order.button_cancel'}</button></a>
				<input class="btn-info" name="finish" type="hidden" value="{lang key='orders::order.button_finish'}" />
			</p>
		</form>
	</div>
</div>
{elseif $step eq "invoice"}
<div class="row">
<div class="col-lg-12">
<form class="form-horizontal" name="invoiceForm" action='{url path="orders/merchant/step_post" args="step={$step}&order_id={$order_id}&step_act={$step_act}"}' method="post">
	<div class="form-group">
		<label class="control-label col-lg-2"><strong>{lang key='orders::order.label_invoice_no'}</strong></label>
		<div class="col-lg-6">
			<input class="w250 form-control" name="invoice_no" type="text" value="{$order.invoice_no}" size="30"/>
			<span class="help-block">多个发货单号，请用英文逗号（“,”）隔开。</span>
		</div>
	</div>

	<div class="row-fluid">
		<table class="table table-striped">
			<thead>
				<tr>
					<th width="5%">&nbsp;</th>
					<th width="25%">{lang key='orders::order.name'}</th>
					<th>{lang key='orders::order.desc'}</th>
				</tr>
			</thead>
			<tbody>
				<!--{foreach from=$shipping_list item=shipping}-->
				<tr>
					<td>
						<input id="shipping_{$shipping.shipping_id}"name="shipping" type="radio" value="{$shipping.shipping_id}" {if $order.shipping_id eq $shipping.shipping_id}checked{/if}/>
						<label for="shipping_{$shipping.shipping_id}"></label>
					</td>
					<td>{$shipping.shipping_name}</td>
					<td>{$shipping.shipping_desc}</td>
				</tr>
				<!--{foreachelse}-->
				<tr>
					<td class="no-records" colspan="3">{lang key='system::system.no_records'}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
	</div>
	<p align="center">
		<button class="btn btn-info" type="submit" name="finish">{lang key='orders::order.button_submit'}</button>
		<input name="finish" type="hidden" value="{lang key='orders::order.button_finish'}" />
		<a class="data-pjax" href='{url path="orders/merchant/info" args="order_id={$order_id}"}'><button class="btn btn-info" type="button">{lang key='orders::order.button_cancel'}</button></a>
	</p>
</form>
</div>
</div>
{/if}
<!-- {/block} -->