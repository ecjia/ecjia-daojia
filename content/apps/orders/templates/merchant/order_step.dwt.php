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
	<strong>说明：因为订单已发货，修改配送方式将不会改变配送费和保价费。</strong>
</div>
{/if}
{if $step eq "user"}
<div class="alert alert-info">
	<strong>注意：搜索结果只显示前50条记录，如果没有找到相应会员，请更精确地查找。另外，如果该会员是从论坛注册的且没有在商城登录过，也无法找到，需要先在商城登录。</strong>
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
							<th class="w200">商品名称</th>
							<th class="w100">货号</th>
							<th>价格</th>
							<th class="w120">数量</th>
							<th>属性</th>
							<th class="w100">小计</th>
							<th class="w150">操作</th>
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
							<td colspan="4" class="left-td"><span class="input-must">备注：商品价格中已包含属性加价</span></td>
							<td colspan="1" class="right-td"><strong>合计：</strong>{$goods_amount}</td>
			<!-- 				<td>{$goods_amount}</td> -->
							<td colspan="2" class="panel-heading form-inline">
<!-- 								{if $smarty.foreach.goods.total gt 0} -->
<!-- 								<button class="btn btn-info" type="submit" name="edit_goods">更新商品</button> -->
<!-- 								{/if} -->
                        			<p class="ecjiaf-tac m_t15">
                        				<button class="btn btn-info" type="submit" name="finish">更新商品</button>&nbsp;&nbsp;&nbsp;
                        				<input name="finish" type="hidden" value="{t domain='orders'}确定{/t}" />
                        				<a class="cancel_order" data-href='{url path="orders/merchant/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'><button class="btn btn-info" type="button">取消</button></a>
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
		<span>按商品编号或商品名称或商品货号搜索：</span>
		<input class="form-control" type="text" name="keyword" placeholder="请输入关键字" />
		<button class="btn searchGoods btn-info" type="button">{t domain="orders"}搜索{/t}</button>
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
					<div class="add-goods"><a class="goods_info ecjiaf-dn" href="javascript:;">加入订单</a></div>
					<div class="ms-list nav-list-content ">
						<div class="ecjiaf-dn goods_info h110">
							<div class="ecjiaf-fl ecjiaf-tac col-lg-5 m_t20">
								<span id="goods_img"></span>
							</div>
							<div class="ecjiaf-fl m_t15 col-lg-7">
								<dl>
									<dd><span id="goods_name"></span></dd>
									<dd>{t}货号：{/t}<span id="goods_sn"></span></dd>
<!-- 									<dd>{t domain="orders"}品牌{/t}：<span id="goods_brand"></span></dd> -->
									<dd>{t domain="orders"}分类：{/t}<span id="goods_cat"></span></dd>
									<dd>{t}商品库存：{/t}<span id="goods_number"></span></dd>
								</dl>
							</div>
						</div>
						<div class="ecjiaf-dn goods_info row-fluid">
							<div class="form-group">
								<label class="control-label col-lg-2">商品价格：</label>
								<div class="col-lg-8" id="add_price">
								</div>
							</div>
						</div>
						<div id="sel_goodsattr">
						</div>
						<div class="ecjiaf-dn goods_info row-fluid">
							<div class="form-group">
								<label class="control-label col-lg-2">商品数量：</label>
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
							<td>
								{if $val.province}{ecjia_region::getRegionName($val.province)} {/if}
								{if $val.city}{ecjia_region::getRegionName($val.city)} {/if}
								{if $val.district}{ecjia_region::getRegionName($val.district)} {/if}
								{if $val.street}{ecjia_region::getRegionName($val.street)} {/if}
							</td>
							
							<td>{$val.address|escape}{$val.address_info|escape}</td>
							<td>{$val.zipcode|escape}</td>
							<td>
								电话：{$val.tel}<br/>
								手机：{$val.mobile}
							</td>
							<!-- <td>最佳送货时间：{$val.best_time|escape}<br/>标志性建筑：{$val.sign_building|escape}<br/>email：{$val.email}</td> -->
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
							<label class="control-label col-lg-2">收货人：</label>
							<div class="col-lg-6 form-inline" >
								<input type="text" name="consignee" class="form-control" value="{$order.consignee}"/>
								<span class="input-must">*</span>
							</div>
						</div>
						<!--{if $exist_real_goods} -->
						<div class="order-step-formgroup form-group">
							<label class="control-label col-lg-2">{t}详细地址 ：{/t}</label>
							<div class="col-lg-6 form-inline" >
								<input type="text" name="address" class="form-control" value="{$order.address}"/>
								<span class="input-must">*</span>
							</div>
						</div>
						<div class="form-group order-step">
                            <label class="control-label col-lg-2">{t}省份：{/t}</label>
                            <div class="w110 f_l m_l15">
                                <select class="form-control required" name="province" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities" data-url="{url path='merchant/region/init'}">
                                    <option value='0'>{t}请选择...{/t}</option>
                                    <!-- {foreach from=$province item=region} -->
                                        <option value="{$region.region_id}" {if $region.region_id eq $order.province}selected{/if}>{$region.region_name}</option>
                                    <!-- {/foreach} -->
                                </select>
                            </div>

                            <div class="w110 f_l m_l10">
                                <select class="form-control required region-summary-cities" data-target="region-summary-distric" name="city" data-type="3" data-toggle="regionSummary">
                                    <option value='0'>{t}请选择...{/t}</option>
                                    <!-- {foreach from=$city item=region} -->
                                    <option value="{$region.region_id}" {if $region.region_id eq $order.city}selected{/if}>{$region.region_name}</option>
                                    <!-- {/foreach} -->
                                </select>
                            </div>

                            <div class="w110 f_l m_l10">
                                <select class="form-control required region-summary-distric" data-target="region-summary-street" name="district" data-type="4" data-toggle="regionSummary">
                                    <option value='0'>{t}请选择...{/t}</option>
                                    <!-- {foreach from=$district item=region} -->
                                    <option value="{$region.region_id}" {if $region.region_id eq $order.district}selected{/if}>{$region.region_name}</option>
                                    <!-- {/foreach} -->
                                </select>
                            </div>
                            
                            <div class="w110 f_l m_l10 m_r10">
                          		<select class="form-control required region-summary-street" name="street" >
                                    <option value='0'>{t}请选择...{/t}</option>
                                    <!-- {foreach from=$street item=region} -->
                                    <option value="{$region.region_id}" {if $region.region_id eq $order.street}selected{/if}>{$region.region_name}</option>
                                    <!-- {/foreach} -->
                                </select>
                            </div>
                            <span class="input-must">*</span>
                        </div>
                        
						<div class="order-step-formgroup form-group">
							<label class="control-label col-lg-2">邮编：</label>
							<div class="col-lg-6 form-inline" >
								<input type="text" name="zipcode" class="form-control" value="{$order.zipcode}" />
							</div>
						</div>
						<!-- {/if} -->
						<div class="order-step-formgroup form-group">
							<label class="control-label col-lg-2">手机：</label>
							<div class="col-lg-6 form-inline" >
								<input type="text" name="mobile" class="form-control" value="{$order.mobile}" />
							</div>
						</div>
						<div class="order-step-formgroup form-group">
							<label class="control-label col-lg-2">电子邮件：</label>
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
		<button class="btn btn-info" type="submit" name="finish">{t domain="orders"}确定{/t}</button>
		<a class="cancel_order btn-info" data-href='{url path="orders/merchant/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'>
		<button class="btn btn-info" type="button">取消</button></a>
		<input name="finish" type="hidden" value="{t domain='orders'}确定{/t}" />
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
							<th class="w100">名称</th>
							<th>描述</th>
							<th class="w100">配送费</th>
							<th class="w100">免费额度</th>
							<th class="w100">保价费</th>
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
		<label for="insure">我要保价</label>
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
							<th class="w100">名称</th>
							<th>描述</th>
							<th class="w100">手续费</th>
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
		<button class="btn btn-info" type="submit" name="finish">{t domain="orders"}确定{/t}</button>
		<a class="cancel_order" data-href='{url path="orders/merchant/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'><button class="btn btn-info" type="button">取消</button></a>
		<input name="finish" type="hidden" value="{t domain='orders'}确定{/t}" />
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
						<label class="control-label col-lg-2">发票类型：</label>
						<div class="col-lg-8">
							<input name="inv_type" class="form-control" type="text" id="inv_type" value="{$order.inv_type}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">发票抬头：</label>
						<div class="col-lg-8">
							<input name="inv_payee" class="form-control" value="{$order.inv_payee}" type="text" />
							<span class="help-block">发票抬头及发票识别码，请用英文逗号（“,”）隔开，例：抬头,识别码。如没有英文逗号，则默认为发票抬头。</span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">发票内容：</label>
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
						<label class="control-label col-lg-2">客户给商家的留言：</label>
						<div class="col-lg-8">
							<textarea name="postscript" class="form-control action_note" cols="60" rows="3">{$order.postscript}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">缺货处理：</label>
						<div class="col-lg-8">
							<textarea name="how_oos" class="form-control action_note" cols="60" rows="3">{$order.how_oos}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">商家给客户的留言：</label>
						<div class="col-lg-8">
							<textarea name="to_buyer" class="form-control action_note" cols="60" rows="3">{$order.to_buyer}</textarea>
						</div>
					</div>
				</div>
			</div>
			<p align="center">
				<button class="btn btn-info" type="submit" name="finish">{t domain="orders"}确定{/t}</button>
				<a class="cancel_order" data-href='{url path="orders/merchant/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'><button class="btn btn-info" type="button">取消</button></a>
				<input name="finish" type="hidden" value="{t domain='orders'}确定{/t}" />
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
                            <strong>订单信息</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse " id="collapseOne">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>商品总金额：</strong></div></td>
								<td>{$order.formated_goods_amount}</td>
								<td><div align="right"><strong>折扣：</strong></div></td>
								<td><input class="form-control" name="discount" type="text" id="discount" value="{$order.discount}" /></td>
							</tr>
							<tr>
								<td><div align="right"><strong>发票税额：</strong></div></td>
								<td><input class="form-control" name="tax" type="text" id="tax" value="{$order.tax}" /></td>
								<td><div align="right"><strong>{t domain="orders"}订单总金额：{/t}</strong></div></td>
								<td>{$order.formated_total_fee}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>配送费用：</strong></div></td>
								<td>{if $exist_real_goods}<input class="form-control" name="shipping_fee" type="text" value="{$order.shipping_fee}" >{else}0{/if}</td>
								<td><div align="right"><strong>{t domain="orders"}已付款金额：{/t}</strong></div></td>
								<td>{$order.formated_money_paid} </td>
							</tr>
							<tr>
								<td><div align="right"><strong>保价费用：</strong></div></td>
								<td>{if $exist_real_goods}<input class="form-control" name="insure_fee" type="text" value="{$order.insure_fee}" >{else}0{/if}</td>
								<td><div align="right"><strong>{t domain="orders"}使用余额：{/t}</strong></div></td>
								<td>
									{if $order.user_id gt 0}
									<input class="form-control" name="surplus" type="text" value="{$order.surplus}">
									{/if}
									{t domain="orders"}可用余额：{/t}{$available_user_money|default:0}
								</td>
							</tr>
							<tr>
								<td><div align="right"><strong>支付费用：</strong></div></td>
								<td><input class="form-control" name="pay_fee" type="text" value="{$order.pay_fee}"></td>
								<td><div align="right"><strong>使用积分：</strong></div></td>
								<td>
									{if $order.user_id gt 0}
									<input class="form-control" name="integral" type="text" value="{$order.integral}" >
									{/if} {t domain="orders"}可用积分：{/t}{$available_pay_points|default:0}
								</td>
							</tr>
							<tr>
								<td><div align="right"><strong>包装费用：</strong></div></td>
								<td>
									{if $exist_real_goods}
									<input class="form-control" name="pack_fee" type="text" value="{$order.pack_fee}" >
									{else}0{/if}
								</td>
								<td><div align="right"><strong>使用红包：</strong></div></td>
								<td>
									<select class="form-control" name="bonus_id">
										<option value="0" {if $order.bonus_id eq 0}selected{/if}>请选择...</option>
										<!-- {foreach from=$available_bonus item=bonus} -->
										<option value="{$bonus.bonus_id}" {if $order.bonus_id eq $bonus.bonus_id}selected{/if} money="{$bonus.type_money}">{$bonus.type_name} - {$bonus.type_money}</option>
										<!--{/foreach}  -->
									</select>
								</td>
							</tr>
							<tr>
								<td><div align="right"><strong>贺卡费用：</strong></div></td>
								<td>
									{if $exist_real_goods}
									<input class="form-control" name="card_fee" type="text" value="{$order.card_fee}">
									{else}0{/if}
								</td>
								<td><div align="right"><strong>{if $order.order_amount >= 0} 应付款金额： {else} 应退款金额： {/if}</strong></div></td>
								<td>{$order.formated_order_amount}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<p align="center">
				<button class="btn btn-info" type="submit" name="finish">{t domain="orders"}完成{/t}</button>&nbsp;&nbsp;&nbsp;
				<a class="cancel_order" data-href='{url path="orders/merchant/process" args="func=cancel_order&order_id={$order_id}&step_act={$step_act}"}'><button class="btn btn-info" type="button">取消</button></a>
				<input class="btn-info" name="finish" type="hidden" value="{t domain='orders'}完成{/t}" />
			</p>
		</form>
	</div>
</div>
{elseif $step eq "invoice"}
<div class="row">
<div class="col-lg-12">
<form class="form-horizontal" name="invoiceForm" action='{url path="orders/merchant/step_post" args="step={$step}&order_id={$order_id}&step_act={$step_act}"}' method="post">
	<div class="form-group">
		<label class="control-label col-lg-2"><strong>运单编号：</strong></label>
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
					<th width="25%">名称</th>
					<th>描述</th>
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
					<td class="no-records" colspan="3">没有找到任何记录</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
	</div>
	<p align="center">
		<button class="btn btn-info" type="submit" name="finish">{t domain="orders"}确定{/t}</button>
		<input name="finish" type="hidden" value="{t domain='orders'}完成{/t}" />
		<a class="data-pjax" href='{url path="orders/merchant/info" args="order_id={$order_id}"}'><button class="btn btn-info" type="button">取消</button></a>
	</p>
</form>
</div>
</div>
{/if}
<!-- {/block} -->