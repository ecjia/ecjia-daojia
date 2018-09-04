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
		<a href="{RC_Uri::url('orders/merchant/init')}&extension_code=storepickup" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>
<!-- #BeginLibraryItem "/library/order_operate.lbi" --><!-- #EndLibraryItem -->

<div class="panel panel-body">
	<div class="order-status-base order-third-base m_b20">
		<ul>
			<li class="step-first">
				<div class="{if $flow_status.key eq 1}step-cur{else}step-done{/if}">
					<div class="step-no">{if $flow_status.key eq 1}1{/if}</div>
					<div class="m_t5">{lang key='orders::order.submit_order'}</div>
					<div class="m_t5 ecjiafc-blue">{if $order.formated_add_time}{$order.formated_add_time}{/if}</div>
				</div>
			</li>
			<li>
				<div class="{if $flow_status.key eq 3}step-cur{else if $flow_status.key gt 3}step-done{/if}">
					<div class="step-no">{if $flow_status.key lt 4}2{/if}</div>
					<div class="m_t5">{$flow_status.pay}</div>
					<div class="m_t5 ecjiafc-blue">{if $order.pay_time}{$order.pay_time}{/if}</div>
				</div>
			</li>
			<li class="step-last">
				<div class="{if $flow_status.key eq 5}step-cur{else if $flow_status.key gt 3}step-done{/if}">
					<div class="step-no">3</div>
					<div class="m_t5">交易完成</div>
				</div>
			</li>
		</ul>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 panel-heading form-inline">
		<div class="form-group"><h3>{lang key='orders::order.label_order_sn'}{$order.order_sn}</h3></div>
		<div class="form-group pull-right">
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
								<td><div align="right"><strong>订单编号：</strong></div></td>
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
								<td><div align="right"><strong>购买人手机号：</strong></div></td>
								<td>{$order.mobile}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_payment'}</strong></div></td>
								<td>
									{$order.pay_name}
								</td>
								<td><div align="right"><strong>{lang key='orders::order.label_order_time'}</strong></div></td>
								<td>{$order.formated_add_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_shipping'}</strong></div></td>
								<td>
									{if $order.shipping_name}{$order.shipping_name}{/if}
								</td>
								<td><div align="right"><strong>{lang key='orders::order.label_pay_time'}</strong></div></td>
								<td>{$order.pay_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.from_order'}</strong></div></td>
								<td colspan="3">{$order.label_referer}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			
			<div class="accordion-group panel panel-default">
				<div class="panel-heading accordion-group-heading-relative">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapsePickup">
                        <h4 class="panel-title">
                            <strong>自提信息</strong>
                        </h4>
                    </a>
                </div>
                <div class="accordion-body in collapse " id="collapsePickup">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>提货码：</strong></div></td>
								<td data-val="{$meta_value.normal}" data-enc="{$meta_value.encryption}">
									{if $meta_value}
										<span class="w150">{$meta_value.encryption}</span>
										<i class="show_meta_value fa fa-eye cursor_pointer"></i>
									{else}
										暂无
									{/if}
								</td>
								<td><div align="right"><strong>提货状态：</strong></div></td>
								<td>{if $pickup_status}{$pickup_status}{else}暂无{/if}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>预约提货时间：</strong></div></td>
								<td colspan="3">
									{if $order.expect_shipping_time} {$order.expect_shipping_time} {else} 暂无 {/if}
								</td>
							</tr>
						</tbody>
					</table>
                </div>
			</div>
			
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
                <div class="accordion-body in collapse" id="collapseTwo">
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
								<td>{if $inv_payee}{$inv_payee}{else}个人{/if}</td>
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
									<a href='{url path="goods/merchant/preview" args="id={$goods.goods_id}"}' target="_blank">{$goods.goods_name}</a>
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
								<td colspan="8"><div align="right"><strong>{lang key='orders::order.label_total'}</strong></div></td>
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
                        {if $order_finished neq 1 && $order.pay_status eq 0 && !$invalid_order}
						<a class="data-pjax accordion-group-heading-absolute" href='{url path="orders/merchant/edit" args="order_id={$order.order_id}&step=money"}'>{lang key='system::system.edit'}</a>
						{/if}
                    </a>
                </div>
                <div class="accordion-body in collapse" id="collapseSix">
                	<table class="table m_b0">
						<tr>
							<td>
								<div align="right">
									{lang key='orders::order.label_goods_amount'}<strong>{$order.formated_goods_amount}</strong>
									- {lang key='orders::order.label_discount'}<strong>{$order.formated_discount}</strong>
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
								<th class="w130"><strong>{lang key='orders::order.order_status'}</strong></th>
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
								<td class="no-records w200" colspan="4">{t}该订单暂无操作记录{/t}</td>
							</tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
                </div>
			</div>
			
			{if $has_payed && $order.shipping_status neq 2}
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
									<a class="btn btn-info confirm_validate" data-url='{url path="orders/mh_validate_order/validate_to_ship"}' data-refresh='{url path="orders/merchant/info"}&order_id={$order.order_id}'>确认验证</a>
									<input name="order_id" class="order_id" type="hidden" value="{$order.order_id}">
								</td>
							</tr>
							<tr>
								<td width="15%"><div align="right"> <strong>操作说明：</strong></div></td>
								<td colspan="3">
									【确认验证】设置该笔订单的商品已被买家取走；<br>
								</td>
							</tr>
						</tbody>
					</table>
                </div>
			</div>
			{/if}
			
			{if $operable_list.cancel}
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
									<button class="btn operatesubmit btn-info" type="submit" name="cancel">{lang key='orders::order.op_cancel'}</button>
									<input name="order_id" class="order_id" type="hidden" value="{$order.order_id}">
								</td>
							</tr>
							<tr>
								<td width="15%"><div align="right"> <strong>操作说明：</strong></div></td>
								<td colspan="3">
									【取消】设置该订单为无效/作废订单；<br>
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