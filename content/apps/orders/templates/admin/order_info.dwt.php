<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.order.info();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		{if $ur_here}{$ur_here}{/if} {if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax">
			<i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="order_userinfo_modal">
    <div class="modal hide fade" id="consigneeinfo">
        <div class="modal-header">
            <button class="close" data-dismiss="modal">×</button>
            <h3>{t domain="orders"}购货人信息{/t}</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="span12 user-info">
                    <div class="basic-info clearfix">
                        <img src="{if $user.avatar_img}{RC_Upload::upload_url($user.avatar_img)}{/if}" />
                        <div class="detail">
                            <p>
                                <span class="name">{if $user.user_name}{$user.user_name}{else}{t domain="orders"}匿名用户{/t}{/if}</span>
                                {if $user.rank_name}<span class="rank_name">{$user.rank_name}</span>{/if}
                            </p>
                            <p>{t domain="orders"}注册时间：{/t}{RC_Time::local_date('Y-m-d H:i:s', $user.reg_time)}</p>
                        </div>
                        <a target="_blank" class="view-detail" href='{url path="user/admin/info" args="id={$user.user_id}"}'>{t domain="orders"}查看详细信息 >>{/t}</a>
                    </div>
                    <div class="user-money">
                        <div class="item">
                            <p>{t domain="orders"}账户余额{/t}</p>
                            <span class="ecjiafc-FF0000">{if $user.formated_user_money}{$user.formated_user_money}{else}￥0.00{/if}</span>
                        </div>
                        <div class="item">
                            <p>{t domain="orders"}消费积分{/t}</p>
                            <span class="ecjiafc-FF0000">{if $user.pay_points}{$user.pay_points}{else}0{/if}</span>
                        </div>
                        <div class="item">
                            <p>{t domain="orders"}成长值{/t}</p>
                            <span class="ecjiafc-FF0000">{if $user.rank_points}{$user.rank_points}{else}0{/if}</span>
                        </div><div class="item">
                            <p>{t domain="orders"}红包数量{/t}</p>
                            <span class="ecjiafc-FF0000">{if $user.bonus_count}{$user.bonus_count}{else}0{/if}</span>
                        </div>
                    </div>
                    <div class="user-address">
                        <div class="address-title">{t domain="orders"}收货地址{/t}</div>
                        <div class="address-content">
                            {foreach from=$address_list item=list}
                            <div class="address-item">
                                <div class="box-placeholder">
                                    <p class="address_name">{$list.consignee} </p>
                                    <p class="address_tel">{$list.mobile}</p>
                                    <p class="address_info">
                                        {if $list.province}{ecjia_region::getRegionName($list.province)}{/if}
                                        {if $list.city}{ecjia_region::getRegionName($list.city)}{/if}
                                        {if $list.district}{ecjia_region::getRegionName($list.district)}{/if}
                                        {if $list.street}{ecjia_region::getRegionName($list.street)}{/if}
                                        {$list.address}
                                    </p>
                                </div>
                            </div>
                            {foreachelse}
                            <div class="no-records">{t domain="orders"}暂无收货地址{/t}</div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="order-status-base order-five-base m_b20">
	<ul class="">
		<li class="step-first">
			<div class="{if $flow_status.key eq '1'}step-cur{else}step-done{/if}">
				<div class="step-no">{if $flow_status.key lt '2'}1{/if}</div>
				<div class="m_t5">{t domain="orders"}提交订单{/t}</div>
				<div class="m_t5 ecjiafc-blue">{$order.formated_add_time}</div>
			</div>
		</li>
		<li>
			<div class="{if $flow_status.key eq '2'}step-cur{elseif $flow_status.key gt '2'}step-done{/if}">
				<div class="step-no">{if $flow_status.key lt '3'}2{/if}</div>
				<div class="m_t5">{$flow_status.pay}</div>
				<div class="m_t5 ecjiafc-blue">{$order.pay_time}</div>
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
				<div class="m_t5 ecjiafc-blue">{$order.shipping_time}</div>
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

<div class="row-fluid">
	<form name="queryinfo" action='{url path="orders/admin/query_info"}' method="post">
		<div class="span12 ecjiaf-tac">
			<div class="ecjiaf-fl">
				<h3>{t domain="orders"}订单号：{/t}{$order.order_sn}</h3>
			</div>
			<span class="choose_list">
				<input type="text" name="keywords" class="ecjiaf-fn" placeholder='{t domain="orders"}请输入订单号或者订单id{/t}' />
				<button class="btn ecjiaf-fn" type="submit">{t domain="orders"}搜索{/t}</button>
			</span>
			<div class="f_r">
				{if $next_id}
				<a class="data-pjax ecjiaf-tdn" href='{url path="orders/admin/info" args="order_id={$next_id}"}'>
				{/if}
					<button class="btn btn-small" type="button" {if !$next_id}disabled="disabled" {/if}>{t domain="orders"}前一个订单{/t}</button>
				{if $next_id}
				</a>
				{/if}

                {if $prev_id}
				<a class="data-pjax ecjiaf-tdn" href='{url path="orders/admin/info" args="order_id={$prev_id}"}'>
				{/if}
					<button class="btn btn-small" type="button" {if !$prev_id}disabled="disabled" {/if}>{t domain="orders"}后一个订单{/t}</button>
				{if $prev_id}
				</a>
				{/if}
			</div>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<form action="{$form_action}" method="post" name="orderpostForm" id="listForm" data-url='{url path="orders/admin/operate_post" args="order_id={$order.order_id}"}'
		    data-pjax-url='{url path="orders/admin/info" args="order_id={$order.order_id}"}' data-list-url='{url path="orders/admin/init"}'
		    data-remove-url="{$remove_action}">
			<div id="accordion2" class="foldable-list form-inline">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne">
							<strong>{t domain="orders"}基本信息{/t}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="collapseOne">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}订单号：{/t}</strong>
										</div>
									</td>
									<td>
										{$order.order_sn}
									</td>
									<td>
										<div align="right">
											<strong>{t domain="orders"}订单状态：{/t}</strong>
										</div>
									</td>
									<td>{$order.status}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}购买人：{/t}</strong>
										</div>
									</td>
									<td>
										{$order.user_name}
                                        {if $order.user_id gt 0}
                                        [ <a class="userInfo cursor_pointer" data-toggle="modal" href="#consigneeinfo" title='{t domain="orders"}显示购货人信息{/t}'>{t domain="orders"}显示购货人信息{/t}</a> ]
                                        {/if}
									</td>
									<td>
										<div align="right">
											<strong>{t domain="orders"}下单时间：{/t}</strong>
										</div>
									</td>
									<td>{$order.formated_add_time}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}支付方式：{/t}</strong>
										</div>
									</td>
									<td>
										{$order.pay_name}
									</td>
									<td>
										<div align="right">
											<strong>{t domain="orders"}付款时间：{/t}</strong>
										</div>
									</td>
									<td>{$order.pay_time}</td>
								</tr>

								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}配送方式：{/t}</strong>
										</div>
									</td>
									<td>
										{if $exist_real_goods}
										<span>{if $order.shipping_name}{$order.shipping_name}{/if}</span>
										{if $order.shipping_id gt 0 && $order.insure_fee gt 0}{t domain="orders"}保价费用：{/t}{$order.formated_insure_fee}{/if}
										{/if}
									</td>
									<td>
										<div align="right">
											<strong>{t domain="orders"}期望送达时间：{/t}</strong>
										</div>
									</td>
									<td>{$order.expect_shipping_time}</td>
								</tr>

								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}发货时间：{/t}</strong>
										</div>
									</td>
									<td>{$order.shipping_time}</td>
									<td>
										<div align="right">
											<strong>{t domain="orders"}运单编号：{/t}</strong>
										</div>
									</td>
									<td>
										{if $order.shipping_id gt 0 and $order.shipping_status gt 0}
										<span>{if $order.invoice_no}{$order.invoice_no}{else}{t domain="orders"}暂无{/t}{/if}</span>
										{/if}
									</td>
								</tr>

								{if $order.express_user}
								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}配送员：{/t}</strong>
										</div>
									</td>
									<td>{$order.express_user}</td>
									<td>
										<div align="right">
											<strong>{t domain="orders"}配送员电话：{/t}</strong>
										</div>
									</td>
									<td>{$order.express_mobile}</td>
								</tr>
								{/if}

								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}订单来源：{/t}</strong>
										</div>
									</td>
									<td colspan="3">{$order.label_referer}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

                {if $order.extension_code eq 'group_buy'}
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseGroupBuy">
                            <strong>{t domain="orders"}参与活动{/t}</strong>
                        </a>
                    </div>
                    <div class="accordion-body in collapse" id="collapseGroupBuy">
                        <table class="table table-oddtd m_b0">
                            <tbody class="first-td-no-leftbd">
                                <tr>
                                    <td>
                                        <div align="right">
                                            <strong>{t domain="orders"}活动类型：{/t}</strong>
                                        </div>
                                    </td>
                                    <td>{t domain="orders"}团购{/t}</td>
                                    <td>
                                        <div align="right">
                                            <strong>{t domain="orders"}活动状态：{/t}</strong>
                                        </div>
                                    </td>
                                    <td>{$groupbuy_info.status_desc}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div align="right">
                                            <strong>{t domain="orders"}店铺名称：{/t}</strong>
                                        </div>
                                    </td>
                                    <td>{$order.merchants_name}</td>
                                    <td>
                                        <div align="right">
                                            <strong>{t domain="orders"}活动商品：{/t}</strong>
                                        </div>
                                    </td>
                                    <td>{$groupbuy_info.goods_name} <a target="_blank" href="{RC_Uri::url('groupbuy/admin/view')}&id={$groupbuy_info.act_id}">{t domain="orders"}[ 活动详情 ]{/t}</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div align="right">
                                            <strong>{t domain="orders"}保证金：{/t}</strong>
                                        </div>
                                    </td>
                                    <td class="ecjiafc-FF0000" colspan="3">{$groupbuy_deposit_status}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                {/if}

				{if $order_finished eq 1 || $order.shipping_status eq 2}
				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseDelivery">
							<strong>{t domain="orders"}发货单信息{/t}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseDelivery">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}发货单流水号：{/t}</strong>
										</div>
									</td>
									<td colspan="3"><a href="{RC_Uri::url('orders/admin_order_delivery/delivery_info')}&delivery_id={$delivery_info.delivery_id}" target="_blank">{$delivery_info.delivery_sn}</a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				{/if}

				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseTwo-a">
							<strong>{t domain="orders"}发票信息{/t}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseTwo-a">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}发票类型：{/t}</strong>
										</div>
									</td>
									<td>{$order.inv_type}</td>
									<td>
										<div align="right">
											<strong>{t domain="orders"}纳税人识别码：{/t}</strong>
										</div>
									</td>
									<td>{$inv_tax_no}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}发票抬头：{/t}</strong>
										</div>
									</td>
									<td>{if $inv_payee}{$inv_payee}{else if $order.inv_type neq ''}{t domain="orders"}个人{/t}{/if}</td>
									<td>
										<div align="right">
											<strong>{t domain="orders"}发票内容：{/t}</strong>
										</div>
									</td>
									<td>{$order.inv_content}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseTwo">
							<strong>{t domain="orders"}其他信息{/t}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseTwo">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}订单备注：{/t}</strong>
										</div>
									</td>
									<td colspan="3">{$order.postscript}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}缺货处理：{/t}</strong>
										</div>
									</td>
									<td colspan="3">{$order.how_oos}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}商家给客户的留言：{/t}</strong>
										</div>
									</td>
									<td colspan="3">{$order.to_buyer}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseThree">
							<strong>{t domain="orders"}收货人信息{/t}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseThree">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}收货人：{/t}</strong>
										</div>
									</td>
									<td>{$order.consignee}</td>
									<td>
										<div align="right">
											<strong>{t domain="orders"}手机号：{/t}</strong>
										</div>
									</td>
									<td>{$order.mobile}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>{t domain="orders"}地址：{/t}</strong>
										</div>
									</td>
									<td colspan="3">[{$order.region}] {$order.address}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseFour">
							<strong>{t domain="orders"}商品信息{/t}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseFour">
						<table class="table table-striped table_vam m_b0 order-table-list">
							<thead>
								<tr class="table-list">
									<th class="w80">{t domain="orders"}商品缩略图{/t}</th>
									<th>{t domain="orders"}商品名称 [ 品牌 ]{/t}</th>
									<th class="w80">{t domain="orders"}货号{/t}</th>
									<th class="w70">{t domain="orders"}货品号{/t}</th>
									<th class="w100">{t domain="orders"}价格{/t}</th>
									<th class="w30">{t domain="orders"}数量{/t}</th>
									<th class="w100">{t domain="orders"}属性{/t}</th>
									<th class="w50">{t domain="orders"}库存{/t}</th>
									<th class="w100">{t domain="orders"}小计{/t}</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$goods_list item=goods}
								<tr class="table-list">
									<td>
										<img src="{$goods.goods_img}" width='50' />
									</td>
									<td>
										{if $goods.goods_id gt 0 and $goods.extension_code neq 'package_buy'}
										<a href='{url path="goods/admin/preview" args="id={$goods.goods_id}"}' target="_blank">
                                            {$goods.goods_name}

                                            {if $goods.brand_name}
                                                [ {$goods.brand_name} ]
                                            {/if}

                                            {if $goods.is_gift}
                                                {if $goods.goods_price gt 0}
                                                    {t domain="orders"}（特惠品）{/t}
                                                {else}
                                                    {t domain="orders"}（赠品）{/t}
                                                {/if}
                                            {/if}

                                            {if $goods.parent_id gt 0}{t domain="orders"}（配件）{/t}{/if}
                                        </a>
										{/if}
									</td>
									<td>{$goods.goods_sn}</td>
									<td>{$goods.product_sn}</td>
									<td>
										<div>{$goods.formated_goods_price}</div>
									</td>
									<td>
										<div>{$goods.goods_number}</div>
									</td>
									<td>{$goods.goods_attr|nl2br}</td>
									<td>
										<div>{$goods.storage}</div>
									</td>
									<td>
										<div>{$goods.formated_subtotal}</div>
									</td>
								</tr>
								{foreachelse}
								<tr>
									<td class="no-records" colspan="9">{t domain="orders"}该订单暂无商品{/t}</td>
								</tr>
								{/foreach}
								<tr>
									<td colspan="5">
                                        {if $order.total_weight}
										<div align="right">
											<strong>{t domain="orders"}商品总重量：{/t}</strong>
										</div>
                                        {/if}
                                    </td>
									<td colspan="2">
                                        {if $order.total_weight}
										<div align="right">
                                            {$order.total_weight}
										</div>
                                        {/if}
                                    </td>
									<td>
										<div align="right">
											<strong>{t domain="orders"}合计：{/t}</strong>
										</div>
									</td>
									<td>
										<div align="right">{$order.formated_goods_amount}</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseFive">
							<strong>{t domain="orders"}费用信息{/t}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseFive">
						<table class="table m_b0">
							<tr>
								<td>
									<div align="right">
                                        {t domain="orders"}商品总金额：{/t}
										<strong>{$order.formated_goods_amount}</strong>
										- {t domain="orders"}折扣：{/t}
										<strong>{$order.formated_discount}</strong>
										+ {t domain="orders"}发票税额：{/t}
										<strong>{$order.formated_tax}</strong>
										+ {t domain="orders"}配送费用：{/t}
										<strong>{$order.formated_shipping_fee}</strong>
										+ {t domain="orders"}保价费用：{/t}
										<strong>{$order.formated_insure_fee}</strong>
										+ {t domain="orders"}支付费用：{/t}
										<strong>{$order.formated_pay_fee}</strong>
										+ {t domain="orders"}包装费用：{/t}
										<strong>{$order.formated_pack_fee}</strong>
										+ {t domain="orders"}贺卡费用：{/t}
										<strong>{$order.formated_card_fee}</strong>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div align="right"> = {t domain="orders"}订单总金额：{/t}
										<strong>{$order.formated_total_fee}</strong>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										- {t domain="orders"}已付款金额：{/t}
										<strong>{$order.formated_money_paid}</strong>
										- {t domain="orders"}使用余额：{/t}
										<strong>{$order.formated_surplus}</strong>
										- {t domain="orders"}使用积分：{/t}
										<strong>{$order.formated_integral_money}</strong>
										- {t domain="orders"}使用红包：{/t}
										<strong>{$order.formated_bonus}</strong>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										= {if $order.order_amount >= 0} {t domain="orders"}应付款金额：{/t}
										<strong>{$order.formated_order_amount}</strong>
										{else} {t domain="orders"}应退款金额：{/t}
										<strong>{$order.formated_money_refund}</strong>
										<input class="refund_click btn" type="button" data-href="{$refund_url}" value='{t domain="orders"}退款{/t}'> {/if}
                                        {if $order.extension_code eq "group_buy"}<br/>{t domain="orders"}（备注：团购如果有保证金，第一次只需支付保证金和相应的支付费用）{/t}{/if}
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseSix">
							<strong>{t domain="orders"}操作记录{/t}</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="collapseSix">
						<table class="table table-striped m_b0">
							<thead>
								<tr>
									<th class="w150">
										<strong>{t domain="orders"}操作者{/t}</strong>
									</th>
									<th class="w180">
										<strong>{t domain="orders"}操作时间{/t}</strong>
									</th>
									<th class="w150">
										<strong>{t domain="orders"}订单状态{/t}</strong>
									</th>
									<th class="ecjiafc-pre t_c w150">
										<strong>{t domain="orders"}操作备注{/t}</strong>
									</th>
								</tr>
							</thead>
							<tbody>
								{foreach from=$action_list item=action}
								<tr>
									<td>{$action.action_user}</td>
									<td>{$action.action_time}</td>
									<td>{$action.action_status}</td>
									<td>{$action.action_note|nl2br}</td>
								</tr>
								{foreachelse}
								<tr>
									<td class="no-records" colspan="4">{t domain="orders"}该订单暂无操作记录{/t}</td>
								</tr>
								{/foreach}
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</form>
	</div>
</div>
<!-- {/block} -->