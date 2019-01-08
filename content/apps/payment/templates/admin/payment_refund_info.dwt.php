<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.payment_refund_list.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->

<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        	<a  href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
        {/if}
    </h3>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="form-inline foldable-list">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne"><strong>退款资金流水记录</strong></a>
                </div>
                <div class="accordion-body in in_visable collapse" id="collapseOne">
                    <table class="table table-oddtd m_b0">
                        <tbody class="first-td-no-leftbd">
                        <tr>
                            <td><div align="right"><strong>订单编号</strong></div></td>
                            <td>
	                            <a target="_blank" href='{url path="orders/admin/info" args="order_id={$refund_order.order_id}"}'>{$payment_refund_info.order_sn}</a>
                            </td>
                            <td><div align="right"><strong>退款状态</strong></div></td>
                            <td>
                                {$payment_refund_info.label_refund_status}
                                <a class="btn m_l5 payrecord_query" href="javascript:;" data-url="{RC_Uri::url('payment/admin_payment_refund/query')}&id={$payment_refund_info.id}">对账查询</a>
                            </td>
                        </tr>
                        <tr>
                            <td><div align="right"><strong>订单退款流水号</strong></div></td>
                            <td>{$payment_refund_info.refund_out_no}</td>
                            <td><div align="right"><strong>支付公司退款流水号</strong></div></td>
                            <td>{$payment_refund_info.refund_trade_no}</td>
                        </tr>
                        <tr>
                            <td><div align="right"><strong>支付方式</strong></div></td>
                            <td>{$payment_refund_info.pay_code}</td>
                            <td><div align="right"><strong>支付名称</strong></div></td>
                            <td>{$payment_refund_info.pay_name} </td>
                        </tr>
                        <tr>
                            <td><div align="right"><strong>退款金额</strong></div></td>
                            <td>{$payment_refund_info.refund_fee}</td>
                            <td><div align="right"><strong>订单类型</strong></div></td>
                            <td>{$payment_refund_info.label_order_type}</td>
                        </tr>
                        <tr>
                            <td><div align="right"><strong>创建时间</strong></div></td>
                            <td>{$payment_refund_info.refund_create_time}</td>
                            <td><div align="right"><strong>退款时间</strong></div></td>
                            <td>{$payment_refund_info.refund_confirm_time}</td>
                        </tr>
                        <tr>
				        	<td><div align="right"><strong>退款编号：</strong></div></td>
				        	<td colspan='3'>
				        		 <a target="_blank" href='{url path="refund/admin_payrecord/detail" args="refund_id={$refund_order.refund_id}"}'>{$refund_order.refund_sn}</a>
				        	</td>
				        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

			<div class="accordion-group">
				<div class="accordion-heading">
				    <a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseTwo"><strong>退款单信息</strong></a>
				</div>
				<div class="accordion-body in in_visable collapse" id="collapseTwo">
				    <table class="table table-oddtd m_b0">
				        <tbody class="first-td-no-leftbd">
				        	 <tr>
					        	<td><div align="right"><strong>退款状态：</strong></div></td>
					        	<td colspan='3'>
					        		{if $refund_order.refund_status eq '0'}
					        			无打款请求
					        		{elseif  $refund_order.refund_status eq '1'}
					        			待处理
					        		{else}
					        			已退款
					        		{/if}
					        	</td>
					        </tr>
					        <tr>
					            <td><div align="right"><strong>商品总金额</strong></div></td>
					            <td>{$refund_order.goods_amount}</td>
					            <td><div align="right"><strong>折扣</strong></div></td>
					            <td>{$refund_order.discount}</td>
					        </tr>
					        <tr>
					            <td><div align="right"><strong>发票税额</strong></div></td>
					            <td>{$refund_order.inv_tax}</td>
					            <td><div align="right"><strong>应退款总金额</strong></div></td>
					            <td>{$refund_order.should_refund_amount}</td>
					        </tr>
					        <tr>
					            <td><div align="right"><strong>配送费用</strong></div></td>
					            <td>{$refund_order.shipping_fee}</td>
					            <td><div align="right"><strong>已付款金额</strong></div></td>
					            <td>{$refund_order.money_paid} </td>
					        </tr>
					        <tr>
					            <td><div align="right"><strong>保价费用</strong></div></td>
					            <td>{$refund_order.insure_fee}</td>
					            <td><div align="right"><strong>使用余额</strong></div></td>
					            <td>{$refund_order.surplus}</td>
					        <tr>
					            <td><div align="right"><strong>支付费用</strong></div></td>
					            <td>{$refund_order.pay_fee}</td>
					            <td><div align="right"><strong>贺卡费用</strong></div></td>
					            <td>{$refund_order.card_fee}</td>
					        </tr>
					        <tr>
					            <td><div align="right"><strong>包装费用</strong></div></td>
					            <td>{$refund_order.pack_fee}</td>
					            <td><div align="right"><strong>实际退款金额</strong></div></td>
					            <td>{$refund_payrecord.back_money_total}</td>
					        </tr>
				        </tbody>
				    </table>
				</div>
			</div>
        </div>
    </div>
</div>
<!-- {/block} -->