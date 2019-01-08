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
                    <h4 class="modal-title">订单操作：退款/退货</h4>
                </div>
                
                <div class="modal-body">
                	  <div class="success-msg"></div>
		              <div class="error-msg"></div>
                      <form class="form-horizontal" method="post" name="actionForm" id="actionForm" action='{url path="orders/merchant/mer_action_return"}'>
                      
					   <div class="form-group">
							<label class="control-label col-lg-3">退款方式：</label>
							<div class="controls col-lg-8">
								<select class="form-control" id="refund_type_select" name="refund_type_select" style="width: 250px;">
					                <option value="">请选择…</option>
					                <option value="refund">仅退款</option>
					                <option value="return">退货退款</option>
					            </select>
							</div>
						</div>
						
						<div id="refund_type_select_return">
							<div class="form-group">
					    		<label class="control-label col-lg-3">返还方式：</label>
								<div class="col-lg-8 chk_radio return_shipping_range">
									<input type="checkbox" name="return_shipping_range" id="home" value="home" > 
									<label for="home"><strong>上门取件</strong></label><small>（由商家联系配送员上门取件）</small>
					    			<br/>
					    			 
					    			<input name="return_shipping_range" id="express" value="express" type="checkbox"> 
									<label for="express"><strong>自选快递</strong></label><small>（由用户自选第三方快递公司配送）</small>
									<div class="return_shipping_content">
										<p>收件人：{$return_shipping_content.staff_name} &nbsp;&nbsp;&nbsp;手机：{$return_shipping_content.staff_mobile}</p>
										<p>地址：{$return_shipping_content.address}</p>
									</div>
									<br/>
								  
								    <input name="return_shipping_range" id="shop" value="shop" type="checkbox"> 
									<label for="shop"><strong>到店退货</strong></label><small>（由用户到门店线下退货）</small>
									<div class="return_shipping_content">
										<p>店铺名称：{$return_shipping_content.store_name} &nbsp;&nbsp;&nbsp;电话：{$return_shipping_content.shop_kf_mobile}</p>
										<p>地址：{$return_shipping_content.address}</p>
									</div>
								</div>
							</div>
						</div>	
						
						<div class="form-group">
							<label class="control-label col-lg-3">退款原因：</label>
							<div class="controls col-lg-8">
								<select class="form-control" id="refund_reason_select" name="refund_reason_select" style="width: 250px;">
									<option value="">请选择…</option>
					                <option value="91">暂不想购买了</option>
									<option value="92">信息填写有误，重新购买</option>
									<option value="93">外表损伤（包装，商品等）</option>
									<option value="94">商品质量问题</option>
									<option value="95">发错货</option>
									<option value="96">未在时效内送达</option>
									<option value="97">服务态度问题</option>					
					            </select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">退款说明：</label>
							<div class="controls col-lg-8">
								<textarea name="refund_content" cols="60" rows="3" class="form-control" id="refund_content"></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">操作备注：</label>
							<div class="controls col-lg-8">
								<textarea name="merchant_action_note" cols="60" rows="3" class="form-control" id="merchant_action_note"></textarea>
							</div>
						</div>
						
                        <div class="control-group t_c">
							<button class="btn btn-info" id="note_btn" type="submit">{t}确定{/t}</button>
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
                    <h4 class="modal-title">拒绝接单</h4>
                </div>
                
                <div class="modal-body">
                	  <div class="success-msg"></div>
		              <div class="error-msg"></div>
                      <form class="form-horizontal" method="post" name="unconfirm_form" action='{url path="orders/merchant/unconfirm_order"}'>
						<div class="form-group">
							<label class="control-label col-lg-3">拒绝原因：</label>
							<div class="controls col-lg-6">
								<select class="form-control w250" name="unconfirm_reason">
									<option value="">请选择…</option>
									<option value="31">该订单商品已售完</option>
									<option value="32">由于天气原因，本店铺暂不接单</option>
									<option value="33">商家忙碌，暂时无法接单</option>
					            </select>
							</div>
						</div>
						
                        <div class="form-group">
                        	<label class="control-label col-lg-3"></label>
                        	<div class="controls col-lg-8">
								<button class="btn btn-info" type="submit">{t}确定{/t}</button>
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
                    <h4 class="modal-title">一键发货</h4>
                </div>
                
                <div class="modal-body">
                	  <div class="success-msg"></div>
		              <div class="error-msg"></div>
                      <form class="form-horizontal" method="post" name="ship_form" action='{url path="orders/merchant/ship"}'>
						<div class="form-group">
							<label class="control-label col-lg-3">配送方式：</label>
							<div class="controls col-lg-6">
								<select class="form-control" name="shipping_id" style="width: 299px;">
									<option value="">请选择…</option>
									{foreach from=$shipping_list item=val}
									<option value="{$val.shipping_id}" {if $order.shipping_id eq $val.shipping_id}selected{/if} data-code="{$val.shipping_code}">{$val.shipping_name}</option>
									{/foreach}
					            </select>
							</div>
							<span class="input-must">*</span>
						</div>
						
						<div class="form-group invoice-no-group {if $shipping_code eq 'ship_o2o_express' || $shipping_code eq 'ship_ecjia_express'}hide{/if}">
							<label class="control-label col-lg-3">运单编号：</label>
							<div class="controls col-lg-6">
								<input class="form-control" type="text" name="invoice_no" placeholder="请输入此订单的运单编号" />
							</div>
							<span class="input-must">*</span>
						</div>
						
                        <div class="form-group">
                        	<label class="control-label col-lg-3"></label>
                        	<div class="controls col-lg-6">
								<button class="btn btn-info" name="to_delivery" type="submit">{t}确定{/t}</button>
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
                <h3>{t}购货人信息{/t}</h3>
            </div>
            <div class="modal-body">
                <div class="row-fluid">
					<div class="span12">
						<table class="table table-bordered">
							<tr><td colspan="2"><strong>购货人信息</strong></td></tr>
							<tr><td class="w200">{lang key='orders::order.email'}</td><td>{$user.email}</td></tr>
							<tr><td>{lang key='orders::order.user_money'}</td><td>{$user.user_money}</td></tr>
							<tr><td>{lang key='orders::order.pay_points'}</td><td>{$user.pay_points}</td></tr>
							<tr><td>{lang key='orders::order.rank_points'}</td><td>{$user.rank_points}</td></tr>
							<tr><td>{lang key='orders::order.rank_name'}</td><td>{$user.rank_name}</td></tr>
							<tr><td>{lang key='orders::order.bonus_count'}</td><td>{$user.bonus_count}</td></tr>
						</table>
						<!-- {foreach from=$address_list item=address} -->
						<table class="table table-bordered">
							<tr><td colspan="2"><strong>{lang key='orders::order.label_consignee'}{$order.consignee|default:$order.user_name}</strong></td></tr>
							<tr><td class="w200">{lang key='orders::order.email'}</td><td>{$address.email}</td></tr>
							<tr><td>{lang key='orders::order.address'}</td><td>{$address.address}{$address.address_info}</td></tr>
							<tr><td>{lang key='orders::order.zipcode'}</td><td>{$address.zipcode}</td></tr>
							<tr><td>{lang key='orders::order.tel'}</td><td>{$address.tel}</td></tr>
							<tr><td>{lang key='orders::order.mobile'}</td><td>{$address.mobile}</td></tr>
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
					<div class="m_t5">{lang key='orders::order.submit_order'}</div>
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
					<div class="m_t5">交易完成</div>
				</div>
			</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 panel-heading form-inline">
		<div class="form-group"><h3>{lang key='orders::order.label_order_sn'}{$order.order_sn}</h3></div>

		<div class="form-group order-info-search">
			<input type="text" name="keywords" class="form-control" placeholder="请输入订单号或者订单id" />
			<button class="btn btn-primary queryinfo" type="button" data-url='{url path="orders/merchant/query_info"}'>{t}搜索{/t}</button>

		</div>
		<div class="form-group pull-right">
			{if $next_id}
			<a class="data-pjax ecjiaf-tdn" href='{url path="orders/merchant/info" args="order_id={$next_id}"}'>
			{/if}
				<button class="btn btn-primary" type="button" {if !$next_id}disabled="disabled"{/if}>{lang key='orders::order.prev'}</button>
			{if $next_id}
			</a>
			{/if}
			{if $prev_id}
			<a class="data-pjax ecjiaf-tdn" href='{url path="orders/merchant/info" args="order_id={$prev_id}"}' >
			{/if}
				<button class="btn btn-primary" type="button" {if !$prev_id}disabled="disabled"{/if}>{lang key='orders::order.next'}</button>
			{if $prev_id}
			</a>
			{/if}
			<div class="btn-group form-group">
        		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">打印 <span class="caret"></span></button>
        		<ul class="dropdown-menu pull-right">
        			<li><a class="nopjax" href='{url path="orders/merchant/info" args="order_id={$order.order_id}&print=1"}' target="__blank">订单打印</a></li>
        			{if $has_payed eq 1}
        			<li><a class="toggle_view" href='{url path="orders/mh_print/init" args="order_id={$order.order_id}"}'>小票打印</a></li>
            		{/if}
            	</ul>
        	</div>
		</div>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<form action="{$form_action}" method="post" name="orderpostForm" id="listForm" data-url='{url path="orders/merchant/operate_post" args="order_id={$order.order_id}"}'  data-pjax-url='{url path="orders/merchant/info" args="order_id={$order.order_id}"}' data-list-url='{url path="orders/merchant/init"}' data-remove-url="{$remove_action}">
			<div id="accordion2" class="panel panel-default">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <h4 class="panel-title">
                            <strong>{lang key='orders::order.base_info'}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse" id="collapseOne">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_order_sn'}</strong></div></td>
								<td>
									{$order.order_sn}
								</td>
								<td><div align="right"><strong>{lang key='orders::order.label_order_status'}</strong></div></td>
								<td>{$order.status}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>购买人：</strong></div></td>
								<td>
									{$order.user_name|default:{lang key='orders::order.anonymous'}}
								</td>
								<td><div align="right"><strong>{lang key='orders::order.label_order_time'}</strong></div></td>
								<td>{$order.formated_add_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_payment'}</strong></div></td>
								<td>
									{$order.pay_name}
								</td>
								<td><div align="right"><strong>{lang key='orders::order.label_pay_time'}</strong></div></td>
								<td>{$order.pay_time}</td>
							</tr>
							
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_shipping'}</strong></div></td>
								<td>
									{if $exist_real_goods}
										<span>{if $order.shipping_name}{$order.shipping_name}{/if}</span>
										{if $order.shipping_id gt 0}
											{if $shipping_code == 'ship_cac'}
												(提货码：{if $meta_value neq ''}{$meta_value}{else}暂无{/if})
											{/if}
										{/if}
										
										{if $order.shipping_status gt 0 && $shipping_code neq 'ship_ecjia_express' && $shipping_code neq 'ship_o2o_express'}
										<input type="button" class="btn btn-primary" onclick="window.open('{url path="orders/merchant/info" args="order_id={$order.order_id}&shipping_print=1"}')" value="{lang key='orders::order.print_shipping'}">
										{/if}

										{if $order.insure_fee gt 0}
											{lang key='orders::order.label_insure_fee'}{$order.formated_insure_fee}
										{/if}
									{/if}
								</td>
								<td><div align="right"><strong>期望送达时间：</strong></div></td>
								<td>{if $order.expect_shipping_time}{$order.expect_shipping_time}{else}暂无{/if}</td>
							</tr>
							
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_shipping_time'}</strong></div></td>
								<td>{$order.shipping_time}</td>
								
								<td><div align="right"><strong>{lang key='orders::order.label_invoice_no'}</strong></div></td>
								<td>
									{if $order.shipping_id gt 0 and $order.shipping_status gt 0}
										<span>{if $order.invoice_no}{$order.invoice_no}{else}暂无{/if}</span>
									{/if}
								</td>
							</tr>
							
							<!-- {if $order.express_user} -->
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_express_user'}</strong></div></td>
								<td>{$order.express_user}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_express_user_mobile'}</strong></div></td>
								<td>{$order.express_mobile}</td>
							</tr>
							<!-- {/if} -->
							
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.from_order'}</strong></div></td>
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
                            <strong>参与活动</strong>
                        </h4>
                    </a>
                </div>
                <div class="accordion-body in collapse" id="delivery_inf">
                    <table class="table table-oddtd m_b0">
                        <tbody class="first-td-no-leftbd">
                            <tr>
                                <td><div align="right"><strong>活动类型：</strong></div></td>
                                <td>团购</td>
                                <td><div align="right"><strong>活动状态：</strong></div></td>
                                <td>{$groupbuy_info.status_desc}</td>
                            </tr>
                            <tr>
                                <td><div align="right"><strong>活动商品：</strong></div></td>
                                <td>{$groupbuy_info.goods_name} <a target="__blank" href="{RC_Uri::url('groupbuy/merchant/edit')}&id={$groupbuy_info.act_id}">[ 活动详情 ]</a></td>
                                <td><div align="right"><strong>保证金：</strong></div></td>
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
                            <strong>{t}发货单信息{/t}</strong>
                        </h4>
                    </a>
                </div>
                <div class="accordion-body in collapse" id="delivery_inf">
                	<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>发货单流水号：</strong></div></td>
								<td colspan="3"><a href="{RC_Uri::url('orders/mh_delivery/delivery_info')}&delivery_id={$delivery_info.delivery_id}" target="__blank">{$delivery_info.delivery_sn}</a></td>
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
                            <strong>{t}发票信息{/t}</strong>
                        </h4>
                    </a>
                    {if $order_finished neq 1 && $order.shipping_status neq 1 && !$invalid_order}
						<a class="data-pjax accordion-group-heading-absolute" href='{url path="orders/merchant/edit" args="order_id={$order.order_id}&step=other"}'>{lang key='system::system.edit'}</a>
					{/if}
                </div>
                <div class="accordion-body in collapse " id="collapseTwo">
                	<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_inv_type'}</strong></div></td>
								<td>{$order.inv_type}</td>
								<td><div align="right"><strong>纳税人识别码：</strong></div></td>
								<td>{$inv_tax_no}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_inv_payee'}</strong></div></td>
								<td>{if $inv_payee}{$inv_payee}{else if $order.inv_type neq ''}个人{/if}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_inv_content'}</strong></div></td>
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
                            <strong>{lang key='orders::order.other_info'}</strong>
                        </h4>
                    </a>
                    {if $order_finished neq 1 && $order.shipping_status neq 1 && !$invalid_order}
						<a class="data-pjax accordion-group-heading-absolute" href='{url path="orders/merchant/edit" args="order_id={$order.order_id}&step=other"}'>{lang key='system::system.edit'}</a>
					{/if}
                </div>
                <div class="accordion-body in collapse " id="collapseThree">
                	<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>订单备注：</strong></div></td>
								<td colspan="3">{$order.postscript}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_how_oos'}</strong></div></td>
								<td colspan="3">{$order.how_oos}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_to_buyer'}</strong></div></td>
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
                            <strong>{lang key='orders::order.consignee_info'}</strong>
                        </h4>
                    </a>
                    {if $order_finished neq 1 && $order.shipping_status neq 1 && !$invalid_order}
						<a class="data-pjax accordion-group-heading-absolute" href='{url path="orders/merchant/edit" args="order_id={$order.order_id}&step=consignee"}'>{lang key='system::system.edit'}</a>
					{/if}
                </div>
                <div class="accordion-body in collapse " id="collapseFour">
                	<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_consignee'}</strong></div></td>
								<td>{$order.consignee}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_mobile'}</strong></div></td>
								<td>{$order.mobile}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_address'}</strong></div></td>
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
                            <strong>{lang key='orders::order.goods_info'}</strong>
                        </h4>
                    </a>
                    {if $order_finished neq 1 && $order.shipping_status neq 1}
<!-- 						<a class="data-pjax accordion-group-heading-absolute" href='{url path="orders/merchant/edit" args="order_id={$order.order_id}&step=goods"}'>{lang key='system::system.edit'}</a> -->
					{/if}
                </div>
                <div class="accordion-body in collapse " id="collapseFive">
                	<table class="table table-striped table_vam m_b0 order-table-list">
						<thead>
							<tr class="table-list">
								<th class="w130">{t}商品缩略图{/t}</th>
								<th>{lang key='orders::order.goods_name_brand'}</th>
								<th class="w80">{lang key='orders::order.goods_sn'}</th>
								<th class="w70">{lang key='orders::order.product_sn'}</th>
								<th class="w100">{lang key='orders::order.goods_price'}</th>
								<th class="w50">{lang key='orders::order.goods_number'}</th>
								<th class="w100">{lang key='orders::order.goods_attr'}</th>
								<th class="w50">{lang key='orders::order.storage'}</th>
								<th class="w100">{lang key='orders::order.subtotal'}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$goods_list item=goods} -->
							<tr class="table-list">
								<td><img src="{$goods.goods_img}" width='50'/></td>
								<td>
									{if $goods.goods_id gt 0 and $goods.extension_code neq 'package_buy'}
									<a href='{url path="goods/merchant/preview" args="id={$goods.goods_id}"}' target="_blank">{$goods.goods_name} {if $goods.brand_name}[ {$goods.brand_name} ]{/if}{if $goods.is_gift}{if $goods.goods_price gt 0}{lang key='orders::order.remark_favourable'}{else}{lang key='orders::order.remark_gift'}{/if}{/if}{if $goods.parent_id gt 0}{lang key='orders::order.remark_fittings'}{/if}</a>
									{elseif $goods.goods_id gt 0 and $goods.extension_code eq 'package_buy'}
									<!-- <a href="javascript:void(0)" onclick="setSuitShow({$goods.goods_id})">{$goods.goods_name}<span style="color:#FF0000;">{lang key='orders::order.remark_package'}</span></a> -->
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
								<td class="no-records" colspan="9">{t}该订单暂无商品{/t}</td>
							</tr>
							<!-- {/foreach} -->
							<tr>
								<td colspan="4">{if $order.total_weight}<div align="right"><strong>{lang key='orders::order.label_total_weight'}
								</strong></div>{/if}</td>
								<td colspan="1">{if $order.total_weight}<div align="right">{$order.total_weight}
								</div>{/if}</td>
								<td colspan="3"><div align="right"><strong>{lang key='orders::order.label_total'}</strong></div></td>
								<td><div align="right">{$order.formated_goods_amount}</div></td>
							</tr>
						</tbody>
					</table>
                </div>
			</div>
			<div class="accordion-group panel panel-default">
				<div class="panel-heading accordion-group-heading-relative">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                        <h4 class="panel-title">
                            <strong>{lang key='orders::order.fee_info'}</strong>
                        </h4>
                    </a>
                    {if $order_finished neq 1 && $order.shipping_status neq 1 && !$invalid_order}
						<a class="data-pjax accordion-group-heading-absolute" href='{url path="orders/merchant/edit" args="order_id={$order.order_id}&step=money"}'>{lang key='system::system.edit'}</a>
					{/if}
                </div>
                <div class="accordion-body in collapse " id="collapseSix">
                	<table class="table m_b0">
						<tr>
							<td>
								<div align="right">
									{lang key='orders::order.label_goods_amount'}<strong>{$order.formated_goods_amount}</strong>
									- {lang key='orders::order.label_discount'}<strong>{$order.formated_discount}</strong>
									+ {lang key='orders::order.label_tax'}<strong>{$order.formated_tax}</strong>
									+ {lang key='orders::order.label_shipping_fee'}<strong>{$order.formated_shipping_fee}</strong>
									+ {lang key='orders::order.label_insure_fee'}<strong>{$order.formated_insure_fee}</strong>
									+ {lang key='orders::order.label_pay_fee'}<strong>{$order.formated_pay_fee}</strong>
									+ {lang key='orders::order.label_pack_fee'}<strong>{$order.formated_pack_fee}</strong>
									+ {lang key='orders::order.label_card_fee'}<strong>{$order.formated_card_fee}</strong>
								</div>
							</td>
						</tr>
						<tr>
							<td><div align="right"> = {lang key='orders::order.label_order_amount'}<strong>{$order.formated_total_fee}</strong></div></td>
						</tr>
						<tr>
							<td>
								<div align="right">
									- {lang key='orders::order.label_money_paid'}<strong>{$order.formated_money_paid}</strong>
									- {lang key='orders::order.label_surplus'} <strong>{$order.formated_surplus}</strong>
									- {lang key='orders::order.label_integral'} <strong>{$order.formated_integral_money}</strong>
									- {lang key='orders::order.label_bonus'} <strong>{$order.formated_bonus}</strong>
								</div>
							</td>
						</tr>
						<tr>
							<td>
								<div align="right">
									= {if $order.order_amount >= 0}
									{lang key='orders::order.label_money_dues'}<strong>{$order.formated_order_amount}</strong>
									{else}
									{lang key='orders::order.label_money_refund'}<strong>{$order.formated_money_refund}</strong>
									{/if}
									
									{if $order.extension_code eq "group_buy"}<br />
										{lang key='orders::order.notice_gb_order_amount'}
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
                            <strong>{t}操作记录{/t}</strong>
                        </h4>
                    </a>
                </div>
                <div class="accordion-body in collapse" id="collapseSeven">
                	<table class="table table-striped m_b0">
						<thead>
							<tr>
								<th class="w150"><strong>操作者</strong></th>
								<th class="w180"><strong>{lang key='orders::order.action_time'}</strong></th>
								<th class="w150"><strong>{lang key='orders::order.order_status'}</strong></th>
								<th class="ecjiafc-pre t_c"><strong>{lang key='orders::order.action_note'}</strong></th>
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
								<td class="no-records w200" colspan="6">{t}该订单暂无操作记录{/t}</td>
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
                            <strong>{t}订单操作{/t}</strong>
                        </h4>
                    </a>
                </div>
                <div class="accordion-body in collapse " id="collapseEight">
                	<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td width="15%"><div align="right"><span class="input-must">*</span> <strong>{lang key='orders::order.label_action_note'}</strong></div></td>
								<td colspan="3"><textarea name="action_note" class="span12 action_note form-control" cols="60" rows="3"></textarea></td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_operable_act'}</strong></div></td>
								<td colspan="3">
									<input type='hidden' class="operate_note" data-url='{url path="orders/merchant/operate_note"}'>

									{if $operable_list.confirm}
									<button class="btn operatesubmit btn-info" type="submit" name="confirm">确认接单</button>
									{/if}

									{if $operable_list.unpay}
									<button class="btn operatesubmit btn-info" type="submit" name="unpay">{lang key='orders::order.op_unpay'}</button>
									{/if}

									{if $operable_list.to_delivery}
									<a style="cursor: pointer;" class="btn btn-info" href="#shipmodal" data-toggle="modal" id="shipmodal-btn">一键发货</a>
									{/if}
									
									{if $operable_list.prepare}
									<button class="btn operatesubmit btn-info" type="submit" name="prepare">{lang key='orders::order.op_prepare'}</button>
									{/if}

									{if $operable_list.split}
									<button class="btn operatesubmit btn-info" type="submit" name="ship">{lang key='orders::order.op_split'}</button>
									{/if}

									{if $operable_list.unconfirm}
									<a style="cursor: pointer;" class="btn btn-info" href="#unconfirmmodal" data-toggle="modal" id="unconfirmmodal">拒单</a>
									{/if}
									
									{if $operable_list.cancel}
									<button class="btn operatesubmit btn-info" type="submit" name="cancel">{lang key='orders::order.op_cancel'}</button>
									{/if}
									
									{if $operable_list.return}
									<a style="cursor: pointer;" class="btn btn-info" href="#actionmodal" data-toggle="modal" id="modal">退款/退货</a>
									{/if}
									
									{if $operable_list.confirm_return}
									<button class="btn operatesubmit btn-info" type="submit" name="confirm_return">确认退货</button>
									{/if}
									
									{if $operable_list.after_service}
									<button class="btn operatesubmit btn-info" type="submit" name="after_service">添加备注</button>
									{/if}
									
									{if $operable_list.remove}
									<button class="btn operatesubmit btn-info" type="submit" name="remove">{lang key='orders::order.remove'}</button>
									{/if}

									{if $order.extension_code eq "group_buy"}
									<div class="m_t10">{lang key='orders::order.notice_gb_ship'}</div>
									{/if}
									<input name="order_id" class="order_id" type="hidden" value="{$order.order_id}">
								</td>
							</tr>
							<tr>
								<td width="15%"><div align="right"> <strong>操作说明：</strong></div></td>
								<td colspan="3">
									{if $operable_list.cancel}【取消】设置该订单为无效/作废订单<br>{/if}
									{if $operable_list.confirm}【确认接单】标记订单为已接单状态；<br>{/if}
									{if $operable_list.unconfirm}【拒单】标记订单为取消状态，取消后，系统自动将款项退回给用户；<br>{/if}
									
									{if $operable_list.to_delivery}【一键发货】标记订单为已发货状态；<br>{/if}
									{if $operable_list.prepare}【配货】标记订单为配货状态，对订单商品进行配货；<br>{/if}
									{if $operable_list.split}【生成发货单】对已经配货完成的订单进行发货，并且生成发货单详细信息；<br>{/if}
									{if $operable_list.return}【退款/退货】设置该订单进入售后处理流程；<br>{/if}
									{if $operable_list.after_service}【添加备注】对该订单的补充说明；<br>{/if}
									
									{if $operable_list.confirm_return}【确认退货】操作人员对该订单的确认退货操作记录；<br>{/if}
									{if $operable_list.remove}【移除】对已经标记取消或无效的订单删除<br>{/if}
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