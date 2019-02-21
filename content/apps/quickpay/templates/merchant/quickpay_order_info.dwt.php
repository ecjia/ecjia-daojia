<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.order_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->



<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $order_info.order_status eq 9}
  		 <a class="ajaxremove" data-toggle="ajaxremove" data-msg='{t domain="quickpay"}删除订单将清楚该订单的所有信息。您确定要这么做吗？{/t}' href='{url path="quickpay/mh_order/remove" args="order_id={$order_info.order_id}"}' title='{t domain="quickpay"}删除订单{/t}'><button type="button" class="btn btn-primary">{t domain="quickpay"}删除订单{/t}</button></a>
  		{/if}
  		
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<!-- #BeginLibraryItem "/library/quickpay_order_step.lbi" --><!-- #EndLibraryItem -->
{if $has_payed eq 1}
<div class="row">
	<div class="col-lg-12 panel-heading form-inline">
		<div class="form-group"><h3>{t domain="quickpay"}订单号：{/t}{$order_info.order_sn}</h3></div>
		<div class="form-group pull-right">
     		<button type="button" class="btn btn-primary toggle_view" data-href='{url path="quickpay/mh_print/init" args="order_id={$order_info.order_id}"}'>{t domain="quickpay"}小票打印{/t}</button>
		</div>
	</div>
</div>
{/if}

<div class="row-fluid">
	<div class="span12">
		<div id="accordion2" class="panel panel-default">
			<div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <h4 class="panel-title"><strong>{t domain="quickpay"}基本信息{/t}</strong></h4>
                </a>
            </div>
			<div class="accordion-body in collapse" id="collapseOne">
				<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr>
							<td><div align="right"><strong>{t domain="quickpay"}订单编号：{/t}</strong></div></td>
							<td>
								{$order_info.order_sn}
							</td>
							<td><div align="right"><strong>{t domain="quickpay"}订单状态：{/t}</strong></div></td>
							<td>{$order_info.status}</td>
						</tr>
						<tr>
							<td><div align="right"><strong>{t domain="quickpay"}购买人姓名：{/t}</strong></div></td>
							<td>
								{$order_info.user_name}
							</td>
							<td><div align="right"><strong>{t domain="quickpay"}购买人手机号：{/t}</strong></div></td>
							<td>{$order_info.user_mobile}</td>
						</tr>
						<tr>
							<td><div align="right"><strong>{t domain="quickpay"}支付方式：{/t}</strong></div></td>
							<td>
								{$order_info.pay_name}
							</td>
							<td><div align="right"><strong>{t domain="quickpay"}支付时间：{/t}</strong></div></td>
							<td>{$order_info.pay_time}</td>
						</tr>
						
						<tr>
							<td><div align="right"><strong>{t domain="quickpay"}买单优惠类型：{/t}</strong></div></td>
							<td>
								{$order_info.activity_name}
							</td>
							<td><div align="right"><strong>{t domain="quickpay"}买单来源：{/t}</strong></div></td>
							<td>{$order_info.referer}</td>
						</tr>
						
						<tr>
							<td><div align="right"><strong>{t domain="quickpay"}下单时间：{/t}</strong></div></td>
							<td colspan="3">{$order_info.add_time}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="accordion-group panel panel-default">
			<div class="panel-heading accordion-group-heading-relative">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                    <h4 class="panel-title">
                        <strong>{t domain="quickpay"}费用信息{/t}</strong>
                    </h4>
                </a>
            </div>
            <div class="accordion-body in collapse " id="collapseSix">
            	<table class="table m_b0">
					<tr>
						<td>
							<div align="right">
								<strong>{t domain="quickpay"}买单消费总金额：{/t}</strong>¥{if $order_info.goods_amount}{$order_info.goods_amount}{else}0{/if}
								- <strong>{t domain="quickpay"}买单：{/t}</strong>¥{if $order_info.discount}{$order_info.discount}{else}0{/if}
								- <strong>{t domain="quickpay"}使用积分抵扣：{/t}</strong>¥{if $order_info.integral_money}{$order_info.integral_money}{else}0{/if}
								- <strong>{t domain="quickpay"}使用红包抵扣：{/t}</strong>¥{if $order_info.bonus}{$order_info.bonus}{else}0{/if}
							</div>
						</td>
					</tr>
					<tr>
						<td><div align="right"> = <strong>{t domain="quickpay"}买单实付金额：{/t}</strong>{$order_info.order_amount}</div></td>
					</tr>
				</table>
            </div>
		</div>
		<div class="accordion-group panel panel-default">
			<div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
                    <h4 class="panel-title">
                        <strong>{t domain="quickpay"}操作记录{/t}</strong>
                    </h4>
                </a>
            </div>
            <div class="accordion-body in collapse" id="collapseSeven">
            	<table class="table table-striped m_b0">
					<thead>
						<tr>
							<th class="w150"><strong>{t domain="quickpay"}操作者{/t}</strong></th>
							<th class="w180"><strong>{t domain="quickpay"}操作时间{/t}</strong></th>
							<th class="w180"><strong>{t domain="quickpay"}订单状态{/t}</strong></th>
							<th class="ecjiafc-pre t_c"><strong>{t domain="quickpay"}操作备注{/t}</strong></th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$action_list item=action} -->
						<tr>
							<td>{$action.action_user_name}</td>
							<td>{$action.add_time}</td>
							<td>{$action.order_status_name}</td>
							<td class="t_c">{$action.action_note|nl2br}</td>
						</tr>
						<!-- {foreachelse} -->
						<tr>
							<td class="no-records w200" colspan="4">{t domain="quickpay"}该订单暂无操作记录{/t}</td>
						</tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
            </div>
		</div>
		
		<!-- 需要核销 -->
        {if $order_info.pay_status eq 1 and $order_info.verification_status neq 1}
        <div class="accordion-group panel panel-default">
			<div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
                    <h4 class="panel-title">
                        <strong>{t domain="quickpay"}订单操作{/t}</strong>
                    </h4>
                </a>
            </div>
            <div class="accordion-body in collapse " id="collapseEight">
            	<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr>
							<td width="15%"><div align="right"><span class="input-must">*</span> <strong>{t domain="quickpay"}操作备注：{/t}</strong></div></td>
							<td colspan="3"><textarea name="action_note" class="span12 action_note form-control" cols="60" rows="3"></textarea></td>
						</tr>
						<tr>
							<td><div align="right"><strong>{t domain="quickpay"}当前可执行操作：{/t}</strong></div></td>
							<td colspan="3">
								<a class="change_status" data-href='{url path="quickpay/mh_order/order_action"}'>
									<button class="btn operatesubmit btn-info" type="button">{t domain="quickpay"}确认核销{/t}</button>
								</a>
								<input type="hidden" value="{$order_info.order_id}" name="order_id">
								<input type="hidden" value="type_info" name="type_info">
							</td>
						</tr>
					</tbody>
				</table>
            </div>
        </div>
        {/if}
		
        <!-- 需要取消 -->
        {if $order_info.order_status eq 0 and $order_info.pay_status eq 0 and $order_info.verification_status eq 0}
        <div class="accordion-group panel panel-default">
			<div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseEight">
                    <h4 class="panel-title">
                        <strong>{t domain="quickpay"}订单操作{/t}</strong>
                    </h4>
                </a>
            </div>
            <div class="accordion-body in collapse " id="collapseEight">
            	<table class="table table-oddtd m_b0">
					<tbody class="first-td-no-leftbd">
						<tr>
							<td width="15%"><div align="right"><span class="input-must">*</span> <strong>{t domain="quickpay"}操作备注：{/t}</strong></div></td>
							<td colspan="3"><textarea name="action_note" class="span12 action_note form-control" cols="60" rows="3"></textarea></td>
						</tr>
						<tr>
							<td><div align="right"><strong>{t domain="quickpay"}当前可执行操作：{/t}</strong></div></td>
							<td colspan="3">
								<a class="change_status" data-href='{url path="quickpay/mh_order/order_action_cancel"}'>
									<button class="btn operatesubmit btn-info" type="button">{t domain="quickpay"}取消{/t}</button>
								</a>
								<input type="hidden" value="{$order_info.order_id}" name="order_id">
								<input type="hidden" value="type_info" name="type_info">
							</td>
						</tr>
					</tbody>
				</table>
            </div>
		</div>
        {/if}
        
	</div>
</div>
<!-- {/block} -->