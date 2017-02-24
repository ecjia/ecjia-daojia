<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
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
                    <a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne"><strong>{lang key='payment::payment.fund_flow_record'}</strong></a>
                </div>
                <div class="accordion-body in in_visable collapse" id="collapseOne">
                    <table class="table table-oddtd m_b0">
                        <tbody class="first-td-no-leftbd">
                        <tr>
                            <td><div align="right"><strong>{lang key='payment::payment.order_sn'}</strong></div></td>
                            <td><a target="__blank" href='{url path="/orders/admin/info" args="order_id={$order.order_id}"}'>{$modules.order_sn}</a></td>
                            <td><div align="right"><strong>{lang key='payment::payment.pay_status'}</strong></div></td>
                            <td>{$modules.pay_status}</td>
                        </tr>
                        <tr>
                            <td><div align="right"><strong>{lang key='payment::payment.trade_type'}</strong></div></td>
                            <td>{$modules.trade_type}</td>
                            <td><div align="right"><strong>{lang key='payment::payment.trade_no'}</strong></div></td>
                            <td>{$modules.trade_no}</td>
                        </tr>
                        <tr>
                            <td><div align="right"><strong>{lang key='payment::payment.pay_code'}</strong></div></td>
                            <td>{$modules.pay_code}</td>
                            <td><div align="right"><strong>{lang key='payment::payment.pay_name'}</strong></div></td>
                            <td>{$modules.pay_name} </td>
                        </tr>
                        <tr>
                            <td><div align="right"><strong>{lang key='payment::payment.total_fee'}</strong></div></td>
                            <td>{$modules.total_fee}</td>
                            <td><div align="right"><strong>{lang key='payment::payment.create_time'}</strong></div></td>
                            <td>{$modules.create_time}</td>
                        <tr>
                            <td><div align="right"><strong>{lang key='payment::payment.update_time'}</strong></div></td>
                            <td>{$modules.update_time}</td>
                            <td><div align="right"><strong>{lang key='payment::payment.pay_time'}</strong></div></td>
                            <td>{$modules.pay_time}</td>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- {if $check_modules} -->
			<div class="accordion-group">
				<div class="accordion-heading">
				    <a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseTwo"><strong>{lang key='payment::payment.heading_order_info'}</strong></a>
				</div>
				<div class="accordion-body in in_visable collapse" id="collapseTwo">
				    <table class="table table-oddtd m_b0">
				        <tbody class="first-td-no-leftbd">
				        <tr>
				            <td><div align="right"><strong>{lang key='orders::order.label_goods_amount'}</strong></div></td>
				            <td>{$order.formated_goods_amount}</td>
				            <td><div align="right"><strong>{lang key='orders::order.label_discount'}</strong></div></td>
				            <td>{$order.discount}</td>
				        </tr>
				        <tr>
				            <td><div align="right"><strong>{lang key='orders::order.label_tax'}</strong></div></td>
				            <td>{$order.tax}</td>
				            <td><div align="right"><strong>{lang key='orders::order.label_order_amount'}</strong></div></td>
				            <td>{$order.formated_total_fee}</td>
				        </tr>
				        <tr>
				            <td><div align="right"><strong>{lang key='orders::order.label_shipping_fee'}</strong></div></td>
				            <td>{$order.shipping_fee}</td>
				            <td><div align="right"><strong>{lang key='orders::order.label_money_paid'}</strong></div></td>
				            <td>{$order.formated_money_paid} </td>
				        </tr>
				        <tr>
				            <td><div align="right"><strong>{lang key='orders::order.label_insure_fee'}</strong></div></td>
				            <td>{if $exist_real_goods}{else}0{/if}</td>
				            <td><div align="right"><strong>{lang key='orders::order.label_surplus'}</strong></div></td>
				            <td>{$order.surplus}</td>
				        <tr>
				            <td><div align="right"><strong>{lang key='orders::order.label_pay_fee'}</strong></div></td>
				            <td>{$order.pay_fee}</td>
				            <td><div align="right"><strong>{lang key='orders::order.label_card_fee'}</strong></div></td>
				            <td>{$order.card_fee}</td>
				        </tr>
				        <tr>
				            <td><div align="right"><strong>{lang key='orders::order.label_pack_fee'}</strong></div></td>
				            <td>{$order.pack_fee}</td>
				            <td><div align="right"><strong>{if $order.order_amount >= 0} {lang key='orders::order.label_money_dues'} {else} {lang key='orders::order.label_money_refund'} {/if}</strong></div></td>
				            <td>{$order.formated_order_amount}</td>
				        </tr>
				        </tbody>
				    </table>
				</div>
			</div>
    		<!-- {/if} -->
        </div>
    </div>
</div>
<!-- {/block} -->