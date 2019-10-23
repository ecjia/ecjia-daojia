<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.order.info();
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
<!-- #BeginLibraryItem "/library/order_operate.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/order_refund.lbi" --><!-- #EndLibraryItem -->

	<div id="actionmodal" class="modal fade">
        <div class="modal-dialog" style="margin-top: 200px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">{t domain="orders"}订单操作：退款/退货{/t}</h4>
                </div>
                
                <div class="modal-body">
                	  <div class="success-msg"></div>
		              <div class="error-msg"></div>
                      <form class="form-horizontal" method="post" name="actionForm" id="actionForm" action='{url path="orders/merchant/mer_action_return"}'>
                      
					   <div class="form-group">
							<label class="control-label col-lg-3">{t domain="orders"}退款方式：{/t}</label>
							<div class="controls col-lg-8">
								<select class="form-control" id="refund_type_select" name="refund_type_select" style="width: 250px;">
					                <option value="">{t domain="orders"}请选择...{/t}</option>
					                <option value="refund">{t domain="orders"}仅退款{/t}</option>
					                <option value="return">{t domain="orders"}退货退款{/t}</option>
					            </select>
							</div>
						</div>
						
						<div id="refund_type_select_return">
							<div class="form-group">
					    		<label class="control-label col-lg-3">{t domain="orders"}返还方式：{/t}</label>
								<div class="col-lg-8 chk_radio return_shipping_range">
									<input type="checkbox" name="return_shipping_range" id="home" value="home" > 
									<label for="home"><strong>{t domain="orders"}上门取件{/t}</strong></label><small>{t domain="orders"}（由商家联系配送员上门取件）{/t}</small>
					    			<br/>
					    			 
					    			<input name="return_shipping_range" id="express" value="express" type="checkbox"> 
									<label for="express"><strong>{t domain="orders"}自选快递{/t}</strong></label><small>{t domain="orders"}（由用户自选第三方快递公司配送）{/t}</small>
									<div class="return_shipping_content">
										<p>{t domain="orders"}收件人：{/t}{$return_shipping_content.staff_name} &nbsp;&nbsp;&nbsp;{t domain="orders"}手机：{/t}{$return_shipping_content.staff_mobile}</p>
										<p>{t domain="orders"}地址：{/t}{$return_shipping_content.address}</p>
									</div>
									<br/>
								  
								    <input name="return_shipping_range" id="shop" value="shop" type="checkbox"> 
									<label for="shop"><strong>{t domain="orders"}到店退货{/t}</strong></label><small>{t domain="orders"}（由用户到门店线下退货）{/t}</small>
									<div class="return_shipping_content">
										<p>{t domain="orders"}店铺名称：{/t}{$return_shipping_content.store_name} &nbsp;&nbsp;&nbsp;{t domain="orders"}电话：{/t}{$return_shipping_content.shop_kf_mobile}</p>
										<p>{t domain="orders"}地址：{/t}{$return_shipping_content.address}</p>
									</div>
								</div>
							</div>
						</div>	
						
						<div class="form-group">
							<label class="control-label col-lg-3">{t domain="orders"}退款原因：{/t}</label>
							<div class="controls col-lg-8">
								<select class="form-control" id="refund_reason_select" name="refund_reason_select" style="width: 250px;">
									<option value="">{t domain="orders"}请选择...{/t}</option>
					                <option value="91">{t domain="orders"}暂不想购买了{/t}</option>
									<option value="92">{t domain="orders"}信息填写有误，重新购买{/t}</option>
									<option value="93">{t domain="orders"}外表损伤（包装，商品等）{/t}</option>
									<option value="94">{t domain="orders"}商品质量问题{/t}</option>
									<option value="95">{t domain="orders"}发错货{/t}</option>
									<option value="96">{t domain="orders"}未在时效内送达{/t}</option>
									<option value="97">{t domain="orders"}服务态度问题{/t}</option>
					            </select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">{t domain="orders"}退款说明：{/t}</label>
							<div class="controls col-lg-8">
								<textarea name="refund_content" cols="60" rows="3" class="form-control" id="refund_content"></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">{t domain="orders"}操作备注：{/t}</label>
							<div class="controls col-lg-8">
								<textarea name="merchant_action_note" cols="60" rows="3" class="form-control" id="merchant_action_note"></textarea>
							</div>
						</div>
						
                        <div class="control-group t_c">
							<button class="btn btn-info" id="note_btn" type="submit">{t domain="orders"}确定{/t}</button>
							<input type="hidden" name="order_id" value="{$order_id}" />
						</div>
                    </form>
                </div>
            </div>
        </div>
   	</div>
   	
	<div id="unconfirmmodal" class="modal fade">
        <div class="modal-dialog" style="margin-top: 200px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">{t domain="orders"}拒绝接单{/t}</h4>
                </div>
                
                <div class="modal-body">
                	  <div class="success-msg"></div>
		              <div class="error-msg"></div>
                      <form class="form-horizontal" method="post" name="unconfirm_form" action='{url path="orders/merchant/unconfirm_order"}'>
						<div class="form-group">
							<label class="control-label col-lg-3">{t domain="orders"}拒绝原因：{/t}</label>
							<div class="controls col-lg-6">
								<select class="form-control w250" name="unconfirm_reason">
									<option value="">{t domain="orders"}请选择...{/t}</option>
									<option value="31">{t domain="orders"}该订单商品已售完{/t}</option>
									<option value="32">{t domain="orders"}由于天气原因，本店铺暂不接单{/t}</option>
									<option value="33">{t domain="orders"}商家忙碌，暂时无法接单{/t}</option>
					            </select>
							</div>
						</div>
						
                        <div class="form-group">
                        	<label class="control-label col-lg-3"></label>
                        	<div class="controls col-lg-8">
								<button class="btn btn-info" type="submit">{t domain="orders"}确定{/t}</button>
								<input type="hidden" name="order_id" value="{$order_id}" />
							</div>
						</div>
                    </form>
                </div>
            </div>
        </div>
   	</div>
   	
	<div id="shipmodal" class="modal fade">
        <div class="modal-dialog" style="margin-top: 200px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">{t domain="orders"}一键发货{/t}</h4>
                </div>
                
                <div class="modal-body">
                	  <div class="success-msg"></div>
		              <div class="error-msg"></div>
                      <form class="form-horizontal" method="post" name="ship_form" action='{url path="orders/merchant/ship"}'>
						<div class="form-group">
							<label class="control-label col-lg-3">{t domain="orders"}配送方式：{/t}</label>
							<div class="controls col-lg-6">
								<select class="form-control" name="shipping_id" style="width: 299px;">
									<option value="">{t domain="orders"}请选择...{/t}</option>
									{foreach from=$shipping_list item=val}
									<option value="{$val.shipping_id}" {if $order.shipping_id eq $val.shipping_id}selected{/if} data-code="{$val.shipping_code}">{$val.shipping_name}</option>
									{/foreach}
					            </select>
							</div>
							<span class="input-must">*</span>
						</div>
						
						<div class="form-group invoice-no-group {if $shipping_code eq 'ship_o2o_express' || $shipping_code eq 'ship_ecjia_express'}hide{/if}">
							<label class="control-label col-lg-3">{t domain="orders"}运单编号：{/t}</label>
							<div class="controls col-lg-6">
								<input class="form-control" type="text" name="invoice_no" placeholder='{t domain="orders"}请输入此订单的运单编号{/t}' />
							</div>
							<span class="input-must">*</span>
						</div>
						
                        <div class="form-group">
                        	<label class="control-label col-lg-3"></label>
                        	<div class="controls col-lg-6">
								<button class="btn btn-info" name="to_delivery" type="submit">{t domain="orders"}确定{/t}</button>
								<input type="hidden" name="order_id" value="{$order_id}" />
								<input type="hidden" name="action_note" />
							</div>
						</div>
                    </form>
                </div>
            </div>
        </div>
   	</div>
   	
<div class="modal fade" id="consigneeinfo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3>{t domain="orders"}购货人信息{/t}</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
					<div class="span12">
						<table class="table table-bordered">
							<tr><td colspan="2"><strong>{t domain="orders"}购货人信息{/t}</strong></td></tr>
							<tr><td class="w200">{t domain="orders"}电子邮件{/t}</td><td>{$user.email}</td></tr>
							<tr><td>{t domain="orders"}账户余额{/t}</td><td>{$user.user_money}</td></tr>
							<tr><td>{t domain="orders"}消费积分{/t}</td><td>{$user.pay_points}</td></tr>
							<tr><td>{t domain="orders"}成长值{/t}</td><td>{$user.rank_points}</td></tr>
							<tr><td>{t domain="orders"}会员等级{/t}</td><td>{$user.rank_name}</td></tr>
							<tr><td>{t domain="orders"}红包数量{/t}</td><td>{$user.bonus_count}</td></tr>
						</table>
						<!-- {foreach from=$address_list item=address} -->
						<table class="table table-bordered">
							<tr><td colspan="2"><strong>{t domain="orders"}收货人：{/t}{$order.consignee|default:$order.user_name}</strong></td></tr>
							<tr><td class="w200">{t domain="orders"}电子邮件{/t}</td><td>{$address.email}</td></tr>
							<tr><td>{t domain="orders"}地址{/t}</td><td>{$address.address}{$address.address_info}</td></tr>
							<tr><td>{t domain="orders"}邮编{/t}</td><td>{$address.zipcode}</td></tr>
							<tr><td>{t domain="orders"}电话{/t}</td><td>{$address.tel}</td></tr>
							<tr><td>{t domain="orders"}备用电话{/t}</td><td>{$address.mobile}</td></tr>
						</table>
						<!-- {/foreach} -->
					</div>
				</div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-body">
	<div class="order-status-base order-five-base m_b20">
		<ul>
			<li class="step-first">
				<div class="{if $flow_status.key eq '1'}step-cur{else}step-done{/if}">
					<div class="step-no">{if $flow_status.key lt '2'}1{/if}</div>
					<div class="m_t5">{t domain="orders"}提交订单{/t}</div>
					<div class="m_t5 ecjiafc-blue">{if $order.formated_add_time}{$order.formated_add_time}{/if}</div>
				</div>
			</li>
			<li>
				<div class="{if $flow_status.key eq '2'}step-cur{elseif $flow_status.key gt '2'}step-done{/if}">
					<div class="step-no">{if $flow_status.key lt '3'}2{/if}</div>
					<div class="m_t5">{$flow_status.pay}</div>
					<div class="m_t5 ecjiafc-blue">{if $order.pay_time}{$order.pay_time}{/if}</div>
				</div>
			</li>
			<li>
				<div class="{if $flow_status.key eq '3'}step-cur{elseif $flow_status.key gt '3'}step-done{/if}">
					<div class="step-no">{if $flow_status.key lt '4'}3{/if}</div>
					<div class="m_t5">{$flow_status.confirm}</div>
					<div class="m_t5 ecjiafc-blue">{if $order.confirm_time && $flow_status.key gt '2'}{$order.confirm_time}{/if}</div>
				</div>
			</li>
			<li>
				<div class="{if $flow_status.key eq '4'}step-cur{elseif $flow_status.key gt '4'}step-done{/if}">
					<div class="step-no">{if $flow_status.key lt '5'}4{/if}</div>
					<div class="m_t5">{$flow_status.shipping}</div>
					<div class="m_t5 ecjiafc-blue">{if $order.shipping_time}{$order.shipping_time}{/if}</div>
				</div>
			</li>
			<li class="step-last">
				<div class="{if $flow_status.key eq '5'}step-cur{elseif $flow_status.key gt '5'}step-done{/if}">
					<div class="step-no">{if $flow_status.key lt '6'}5{/if}</div>
					<div class="m_t5">{t domain="orders"}交易完成{/t}</div>
				</div>
			</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 panel-heading form-inline">
		<div class="form-group"><h3>{t domain="orders"}订单号：{/t}{$order.order_sn}</h3></div>

		<div class="form-group order-info-search">
			<input type="text" name="keywords" class="form-control" placeholder='{t domain="orders"}请输入订单号或者订单id{/t}' />
            <input type="hidden" name="extension_code" value="{$extension_code}"/>

            <button class="btn btn-primary queryinfo" type="button" data-url='{url path="orders/merchant/query_info"}'>{t domain="orders"}搜索{/t}</button>

		</div>
		<div class="form-group pull-right">
			{if $next_id}
			<a class="data-pjax ecjiaf-tdn" href='{url path="orders/merchant/info" args="order_id={$next_id}"}'>
			{/if}
				<button class="btn btn-primary" type="button" {if !$next_id}disabled="disabled"{/if}>{t domain="orders"}前一个订单{/t}</button>
			{if $next_id}
			</a>
			{/if}
			{if $prev_id}
			<a class="data-pjax ecjiaf-tdn" href='{url path="orders/merchant/info" args="order_id={$prev_id}"}' >
			{/if}
				<button class="btn btn-primary" type="button" {if !$prev_id}disabled="disabled"{/if}>{t domain="orders"}后一个订单{/t}</button>
			{if $prev_id}
			</a>
			{/if}
			<div class="btn-group form-group">
        		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">{t domain="orders"}打印{/t} <span class="caret"></span></button>
        		<ul class="dropdown-menu pull-right">
        			<li><a class="nopjax" href='{url path="orders/merchant/info" args="order_id={$order.order_id}&print=1"}' target="_blank">{t domain="orders"}订单打印{/t}</a></li>
        			{if $has_payed eq 1}
        			<li><a class="toggle_view" href='{url path="orders/mh_print/init" args="order_id={$order.order_id}"}'>{t domain="orders"}小票打印{/t}</a></li>
            		{/if}
            	</ul>
        	</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<form action="{$form_action}" method="post" name="orderpostForm" id="listForm" data-url='{url path="orders/merchant/operate_post" args="order_id={$order.order_id}"}' data-pjax-url='{url path="orders/merchant/info" args="order_id={$order.order_id}"}' data-list-url='{url path="orders/merchant/init"}' data-remove-url="{$remove_action}">
			<div id="accordion2" class="panel panel-default">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <h4 class="panel-title">
                            <strong>{t domain="orders"}基本信息{/t}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse" id="collapseOne">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{t domain="orders"}订单号：{/t}</strong></div></td>
								<td>
									{$order.order_sn}
								</td>
								<td><div align="right"><strong>{t domain="orders"}订单状态：{/t}</strong></div></td>
								<td>{$order.status}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="orders"}购买人：{/t}</strong></div></td>
								<td>
									{$order.user_name}
								</td>
								<td><div align="right"><strong>{t domain="orders"}下单时间：{/t}</strong></div></td>
								<td>{$order.formated_add_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="orders"}支付方式：{/t}</strong></div></td>
								<td>
									{$order.pay_name}
								</td>
								<td><div align="right"><strong>{t domain="orders"}付款时间：{/t}</strong></div></td>
								<td>{$order.pay_time}</td>
							</tr>
							
							<tr>
								<td><div align="right"><strong>{t domain="orders"}配送方式：{/t}</strong></div></td>
								<td>
									{if $exist_real_goods}
										<span>{if $order.shipping_name}{$order.shipping_name}{/if}</span>
										{if $order.shipping_id gt 0}
											{if $shipping_code == 'ship_cac'}
												({t domain="orders"}提货码：{/t}{if $meta_value neq ''}{$meta_value}{else}{t domain="orders"}暂无{/t}{/if})
											{/if}
										{/if}
										
										{if $order.shipping_status gt 0 && $shipping_code neq 'ship_ecjia_express' && $shipping_code neq 'ship_o2o_express'}
										<input type="button" class="btn btn-primary" onclick="window.open('{url path="orders/merchant/shipping_print" args="order_id={$order.order_id}"}')" value='{t domain="orders"}打印快递单{/t}'>
										{/if}

										{if $order.insure_fee gt 0}
                                            {t domain="orders"}保价费用：{/t}{$order.formated_insure_fee}
										{/if}
									{/if}
								</td>
								<td><div align="right"><strong>{t domain="orders"}期望送达时间：{/t}</strong></div></td>
								<td>{if $order.expect_shipping_time}{$order.expect_shipping_time}{else}{t domain="orders"}暂无{/t}{/if}</td>
							</tr>
							
							<tr>
								<td><div align="right"><strong>{t domain="orders"}发货时间：{/t}</strong></div></td>
								<td>{$order.shipping_time}</td>
								
								<td><div align="right"><strong>{t domain="orders"}运单编号：{/t}</strong></div></td>
								<td>
									{if $order.shipping_id gt 0 and $order.shipping_status gt 0}
										<span>{if $order.invoice_no}{$order.invoice_no}{else}{t domain="orders"}暂无{/t}{/if}</span>
									{/if}
								</td>
							</tr>
							
							<!-- {if $order.express_user} -->
							<tr>
								<td><div align="right"><strong>{t domain="orders"}配送员：{/t}</strong></div></td>
								<td>{$order.express_user}</td>
								<td><div align="right"><strong>{t domain="orders"}配送员电话：{/t}</strong></div></td>
								<td>{$order.express_mobile}</td>
							</tr>
							<!-- {/if} -->
							
							<tr>
								<td><div align="right"><strong>{t domain="orders"}订单来源：{/t}</strong></div></td>
								<td colspan="3">{$order.label_referer}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

            {if $order.extension_code eq 'group_buy'}
            <div class="accordion-group panel panel-default">
                <div class="panel-heading accordion-group-heading-relative">
                    <a data-toggle="collapse" data-parent="#accordion" href="#delivery_info">
                        <h4 class="panel-title">
                            <strong>{t domain="orders"}参与活动{/t}</strong>
                        </h4>
                    </a>
                </div>
                <div class="accordion-body in collapse" id="delivery_inf">
                    <table class="table table-oddtd m_b0">
                        <tbody class="first-td-no-leftbd">
                            <tr>
                                <td><div align="right"><strong>{t domain="orders"}活动类型：{/t}</strong></div></td>
                                <td>{t domain="orders"}团购{/t}</td>
                                <td><div align="right"><strong>{t domain="orders"}活动状态：{/t}</strong></div></td>
                                <td>{$groupbuy_info.status_desc}</td>
                            </tr>
                            <tr>
                                <td><div align="right"><strong>{t domain="orders"}活动商品：{/t}</strong></div></td>
                                <td>{$groupbuy_info.goods_name} <a target="_blank" href="{RC_Uri::url('groupbuy/merchant/edit')}&id={$groupbuy_info.act_id}">{t domain="orders"}[ 活动详情 ]{/t}</a></td>
                                <td><div align="right"><strong>{t domain="orders"}保证金：{/t}</strong></div></td>
                                <td class="ecjiafc-FF0000">{$groupbuy_deposit_status}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {/if}
			
			{if $order_finished eq 1 || $order.shipping_status eq 2}
			<div class="accordion-group panel panel-default">
				<div class="panel-heading accordion-group-heading-relative">
                    <a data-toggle="collapse" data-parent="#accordion" href="#delivery_info">
                        <h4 class="panel-title">
                            <strong>{t domain="orders"}发货单信息{/t}</strong>
                        </h4>
                    </a>
                </div>
                <div class="accordion-body in collapse" id="delivery_inf">
                	<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{t domain="orders"}发货单流水号：{/t}</strong></div></td>
								<td colspan="3"><a href="{RC_Uri::url('orders/mh_delivery/delivery_info')}&delivery_id={$delivery_info.delivery_id}" target="_blank">{$delivery_info.delivery_sn}</a></td>
							</tr>
						</tbody>
					</table>
                </div>
			</div>
			{/if}
			
			<div class="accordion-group panel panel-default">
				<div class="panel-heading accordion-group-heading-relative">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        <h4 class="panel-title">
                            <strong>{t domain="orders"}发票信息{/t}</strong>
                        </h4>
                    </a>
                    {if $order_finished neq 1 && $order.shipping_status neq 1 && !$invalid_order}
						<a class="data-pjax accordion-group-heading-absolute" href='{url path="orders/merchant/edit" args="order_id={$order.order_id}&step=other"}'>{t domain="orders"}编辑{/t}</a>
					{/if}
                </div>
                <div class="accordion-body in collapse " id="collapseTwo">
                	<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{t domain="orders"}发票类型：{/t}</strong></div></td>
								<td>{$order.inv_type}</td>
								<td><div align="right"><strong>{t domain="orders"}纳税人识别码：{/t}</strong></div></td>
								<td>{$inv_tax_no}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="orders"}发票抬头：{/t}</strong></div></td>
								<td>{if $inv_payee}{$inv_payee}{else if $order.inv_type neq ''}{t domain="orders"}个人{/t}{/if}</td>
								<td><div align="right"><strong>{t domain="orders"}发票内容：{/t}</strong></div></td>
								<td>{$order.inv_content}</td>
							</tr>
						</tbody>
					</table>
                </div>
			</div>
			<div class="accordion-group panel panel-default">
				<div class="panel-heading accordion-group-heading-relative">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        <h4 class="panel-title">
                            <strong>{t domain="orders"}其他信息{/t}</strong>
                        </h4>
                    </a>
                    {if $order_finished neq 1 && $order.shipping_status neq 1 && !$invalid_order}
						<a class="data-pjax accordion-group-heading-absolute" href='{url path="orders/merchant/edit" args="order_id={$order.order_id}&step=other"}'>{t domain="orders"}编辑{/t}</a>
					{/if}
                </div>
                <div class="accordion-body in collapse " id="collapseThree">
                	<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{t domain="orders"}订单备注：{/t}</strong></div></td>
								<td colspan="3">{$order.postscript}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="orders"}缺货处理：{/t}</strong></div></td>
								<td colspan="3">{$order.how_oos}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="orders"}商家给客户的留言：{/t}</strong></div></td>
								<td colspan="3">{$order.to_buyer}</td>
							</tr>
						</tbody>
					</table>
                </div>
			</div>
			<div class="accordion-group panel panel-default">
				<div class="panel-heading accordion-group-heading-relative">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                        <h4 class="panel-title">
                            <strong>{t domain="orders"}收货人信息{/t}</strong>
                        </h4>
                    </a>
                    {if $order_finished neq 1 && $order.shipping_status neq 1 && !$invalid_order}
						<a class="data-pjax accordion-group-heading-absolute" href='{url path="orders/merchant/edit" args="order_id={$order.order_id}&step=consignee"}'>{t domain="orders"}编辑{/t}</a>
					{/if}
                </div>
                <div class="accordion-body in collapse " id="collapseFour">
                	<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{t domain="orders"}收货人：{/t}</strong></div></td>
								<td>{$order.consignee}</td>
								<td><div align="right"><strong>{t domain="orders"}手机：{/t}</strong></div></td>
								<td>{$order.mobile}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="orders"}地址：{/t}</strong></div></td>
								<td colspan="3">[{$order.region}] {$order.address}</td>
							</tr>
						</tbody>
					</table>
                </div>
			</div>
			<div class="accordion-group panel panel-default">
				<div class="panel-heading accordion-group-heading-relative">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                        <h4 class="panel-title">
                            <strong>{t domain="orders"}商品信息{/t}</strong>
                        </h4>
                    </a>
                    {if $order_finished neq 1 && $order.shipping_status neq 1}
<!-- 						<a class="data-pjax accordion-group-heading-absolute" href='{url path="orders/merchant/edit" args="order_id={$order.order_id}&step=goods"}'>{t domain="orders"}编辑{/t}</a> -->
					{/if}
                </div>
                <div class="accordion-body in collapse " id="collapseFive">
                	<table class="table table-striped table_vam m_b0 order-table-list">
						<thead>
							<tr class="table-list">
								<th class="w130">{t domain="orders"}商品缩略图{/t}</th>
								<th>{t domain="orders"}商品名称 [ 品牌 ]{/t}</th>
								<th class="w80">{t domain="orders"}货号{/t}</th>
								<th class="w70">{t domain="orders"}货品号{/t}</th>
								<th class="w100">{t domain="orders"}价格{/t}</th>
								<th class="w50">{t domain="orders"}数量{/t}</th>
								<th class="w100">{t domain="orders"}属性{/t}</th>
								<th class="w50">{t domain="orders"}库存{/t}</th>
								<th class="w100">{t domain="orders"}小计{/t}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$goods_list item=goods} -->
							<tr class="table-list">
								<td><img src="{$goods.goods_img}" width='50'/></td>
								<td>
									{if $goods.goods_id gt 0 and $goods.extension_code neq 'package_buy'}
									<a href='{url path="goods/merchant/preview" args="id={$goods.goods_id}"}' target="_blank">{$goods.goods_name} {if $goods.brand_name}[ {$goods.brand_name} ]{/if}{if $goods.is_gift}{if $goods.goods_price gt 0}{t domain="orders"}（特惠品）{/t}{else}{t domain="orders"}（赠品）{/t}{/if}{/if}{if $goods.parent_id gt 0}{t domain="orders"}（配件）{/t}{/if}</a>
									{elseif $goods.goods_id gt 0 and $goods.extension_code eq 'package_buy'}
									<!-- <a href="javascript:void(0)" onclick="setSuitShow({$goods.goods_id})">{$goods.goods_name}<span style="color:#FF0000;">（礼包）</span></a> -->
									<!-- <div style="display:none">  -->
									<!-- {foreach from=$goods.package_goods_list item=package_goods_list} -->
									<!-- <a href='{url path="goods/merchant/preview" args="id={$package_goods_list.goods_id}"}' target="_blank">{$package_goods_list.goods_name}</a><br /> -->
									<!-- {/foreach} -->
									<!-- </div> -->
									{/if}
								</td>
								<td>{$goods.goods_sn}</td>
								<td>{$goods.product_sn}</td>
								<td><div >{$goods.formated_goods_price}</div></td>
								<td><div >{$goods.goods_number}
								</div></td>
								<td>{$goods.goods_attr|nl2br}</td>
								<td><div >{$goods.storage}</div></td>
								<td><div >{$goods.formated_subtotal}</div></td>
							</tr>
							<!-- {foreachelse} -->
							<tr>
								<td class="no-records" colspan="9">{t domain="orders"}该订单暂无商品{/t}</td>
							</tr>
							<!-- {/foreach} -->
							<tr>
								<td colspan="4">
                                    {if $order.total_weight}
                                    <div align="right"><strong>{t domain="orders"}商品总重量：{/t}</strong></div>
                                    {/if}
                                </td>
								<td colspan="1">
                                    {if $order.total_weight}
                                    <div align="right">{$order.total_weight}</div>
                                    {/if}
                                </td>
								<td colspan="3">
                                    <div align="right"><strong>{t domain="orders"}合计：{/t}</strong></div>
                                </td>
								<td>
                                    <div align="right">{$order.formated_goods_amount}</div>
                                </td>
							</tr>
						</tbody>
					</table>
                </div>
			</div>
			<div class="accordion-group panel panel-default">
				<div class="panel-heading accordion-group-heading-relative">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                        <h4 class="panel-title">
                            <strong>{t domain="orders"}费用信息{/t}</strong>
                        </h4>
                    </a>
                    {if $order_finished neq 1 && $order.shipping_status neq 1 && !$invalid_order}
						<a class="data-pjax accordion-group-heading-absolute" href='{url path="orders/merchant/edit" args="order_id={$order.order_id}&step=money"}'>{t domain="orders"}编辑{/t}</a>
					{/if}
                </div>
                <div class="accordion-body in collapse " id="collapseSix">
                	<table class="table m_b0">
						<tr>
							<td>
								<div align="right">
                                    {t domain="orders"}商品总金额：{/t}<strong>{$order.formated_goods_amount}</strong>
									- {t domain="orders"}折扣：{/t}<strong>{$order.formated_discount}</strong>
									+ {t domain="orders"}发票税额：{/t}<strong>{$order.formated_tax}</strong>
									+ {t domain="orders"}配送费用：{/t}<strong>{$order.formated_shipping_fee}</strong>
									+ {t domain="orders"}保价费用：{/t}<strong>{$order.formated_insure_fee}</strong>
									+ {t domain="orders"}支付费用：{/t}<strong>{$order.formated_pay_fee}</strong>
									+ {t domain="orders"}包装费用：{/t}<strong>{$order.formated_pack_fee}</strong>
									+ {t domain="orders"}贺卡费用：{/t}<strong>{$order.formated_card_fee}</strong>
								</div>
							</td>
						</tr>
						<tr>
							<td><div align="right"> = {t domain="orders"}订单总金额：{/t}<strong>{$order.formated_total_fee}</strong></div></td>
						</tr>
						<tr>
							<td>
								<div align="right">
									- {t domain="orders"}已付款金额：{/t}<strong>{$order.formated_money_paid}</strong>
									- {t domain="orders"}使用余额：{/t} <strong>{$order.formated_surplus}</strong>
									- {t domain="orders"}使用积分：{/t}<strong>{$order.formated_integral_money}</strong>
									- {t domain="orders"}使用红包：{/t}<strong>{$order.formated_bonus}</strong>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div align="right">
									= {if $order.order_amount >= 0}
                                    {t domain="orders"}应付款金额：{/t}<strong>{$order.formated_order_amount}</strong>
									{else}
                                    {t domain="orders"}应退款金额：{/t}<strong>{$order.formated_money_refund}</strong>
									{/if}
									
									{if $order.extension_code eq "group_buy"}<br />
                                        {t domain="orders"}（备注：团购如果有保证金，第一次只需支付保证金和相应的支付费用）{/t}
									{/if}
								</div>
							</td>
						</tr>
					</table>
                </div>
			</div>
			<div class="accordion-group panel panel-default">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
                        <h4 class="panel-title">
                            <strong>{t domain="orders"}操作记录{/t}</strong>
                        </h4>
                    </a>
                </div>
                <div class="accordion-body in collapse" id="collapseSeven">
                	<table class="table table-striped m_b0">
						<thead>
							<tr>
								<th class="w150"><strong>{t domain="orders"}操作者{/t}</strong></th>
								<th class="w180"><strong>{t domain="orders"}操作时间{/t}</strong></th>
								<th class="w150"><strong>{t domain="orders"}订单状态{/t}</strong></th>
								<th class="ecjiafc-pre t_c"><strong>{t domain="orders"}备注{/t}</strong></th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$action_list item=action} -->
							<tr>
								<td>{$action.action_user}</td>
								<td>{$action.action_time}</td>
								<td>{$action.action_status}</td>
								<td class="t_c">{$action.action_note|nl2br}</td>
							</tr>
							<!-- {foreachelse} -->
							<tr>
								<td class="no-records w200" colspan="6">{t domain="orders"}该订单暂无操作记录{/t}</td>
							</tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
                </div>
			</div>
			
			{if !$invalid_order && $order.order_status neq 2 && $order_handle}
			<div class="accordion-group panel panel-default">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
                        <h4 class="panel-title">
                            <strong>{t domain="orders"}订单操作{/t}</strong>
                        </h4>
                    </a>
                </div>
                <div class="accordion-body in collapse " id="collapseEight">
                	<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td width="15%"><div align="right"><span class="input-must">*</span> <strong>{t domain="orders"}操作备注：{/t}</strong></div></td>
								<td colspan="3"><textarea name="action_note" class="span12 action_note form-control" cols="60" rows="3"></textarea></td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="orders"}当前可执行操作：{/t}</strong></div></td>
								<td colspan="3">
									<input type='hidden' class="operate_note" data-url='{url path="orders/merchant/operate_note"}'>

									{if $operable_list.confirm}
									<button class="btn operatesubmit btn-info" type="submit" name="confirm">{t domain="orders"}确认接单{/t}</button>
									{/if}

									{if $operable_list.unpay}
									<button class="btn operatesubmit btn-info" type="submit" name="unpay">{t domain="orders"}设为未付款{/t}</button>
									{/if}

									{if $operable_list.to_delivery}
									<a style="cursor: pointer;" class="btn btn-info" href="#shipmodal" data-toggle="modal" id="shipmodal-btn">{t domain="orders"}一键发货{/t}</a>
									{/if}
									
									{if $operable_list.prepare}
									<button class="btn operatesubmit btn-info" type="submit" name="prepare">{t domain="orders"}配货{/t}</button>
									{/if}

									{if $operable_list.split}
									<button class="btn operatesubmit btn-info" type="submit" name="ship">{t domain="orders"}生成发货单{/t}</button>
									{/if}

									{if $operable_list.unconfirm}
									<a style="cursor: pointer;" class="btn btn-info" href="#unconfirmmodal" data-toggle="modal" id="unconfirmmodal">{t domain="orders"}拒单{/t}</a>
									{/if}
									
									{if $operable_list.cancel}
									<button class="btn operatesubmit btn-info" type="submit" name="cancel">{t domain="orders"}取消{/t}</button>
									{/if}
									
									{if $operable_list.return}
									<a style="cursor: pointer;" class="btn btn-info" href="#actionmodal" data-toggle="modal" id="modal">{t domain="orders"}退款/退货{/t}</a>
									{/if}
									
									{if $operable_list.confirm_return}
									<button class="btn operatesubmit btn-info" type="submit" name="confirm_return">{t domain="orders"}确认退货{/t}</button>
									{/if}
									
									{if $operable_list.after_service}
									<button class="btn operatesubmit btn-info" type="submit" name="after_service">{t domain="orders"}添加备注{/t}</button>
									{/if}
									
									{if $operable_list.remove}
									<button class="btn operatesubmit btn-info" type="submit" name="remove">{t domain="orders"}移除{/t}</button>
									{/if}

									{if $order.extension_code eq "group_buy"}
									<div class="m_t10">{t domain="orders"}备注：团购活动未处理为成功前，不能发货{/t}</div>
									{/if}
									<input name="order_id" class="order_id" type="hidden" value="{$order.order_id}">
								</td>
							</tr>
							<tr>
								<td width="15%"><div align="right"> <strong>{t domain="orders"}操作说明：{/t}</strong></div></td>
								<td colspan="3">
									{if $operable_list.cancel}{t domain="orders"}【取消】设置该订单为无效/作废订单；{/t}<br>{/if}
									{if $operable_list.confirm}{t domain="orders"}【确认接单】标记订单为已接单状态；{/t}<br>{/if}
									{if $operable_list.unconfirm}{t domain="orders"}【拒单】标记订单为取消状态，取消后，系统自动将款项退回给用户；{/t}<br>{/if}
									
									{if $operable_list.to_delivery}{t domain="orders"}【一键发货】标记订单为已发货状态；{/t}<br>{/if}
									{if $operable_list.prepare}{t domain="orders"}【配货】标记订单为配货状态，对订单商品进行配货；{/t}<br>{/if}
									{if $operable_list.split}{t domain="orders"}【生成发货单】对已经配货完成的订单进行发货，并且生成发货单详细信息；{/t}<br>{/if}
									{if $operable_list.return}{t domain="orders"}【退款/退货】设置该订单进入售后处理流程；{/t}<br>{/if}
									{if $operable_list.after_service}{t domain="orders"}【添加备注】对该订单的补充说明；{/t}<br>{/if}
									
									{if $operable_list.confirm_return}{t domain="orders"}【确认退货】操作人员对该订单的确认退货操作记录；{/t}<br>{/if}
									{if $operable_list.remove}{t domain="orders"}【移除】对已经标记取消或无效的订单删除{/t}<br>{/if}
								</td>
							</tr>
						</tbody>
					</table>
                </div>
			</div>
			{/if}
			
		</form>
	</div>
</div>
<!-- {/block} -->