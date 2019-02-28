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
            <h3>购货人信息</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="span12 user-info">
                    <div class="basic-info clearfix">
                        <img src="{if $user.avatar_img}{RC_Upload::upload_url($user.avatar_img)}{/if}" />
                        <div class="detail">
                            <p>
                                <span class="name">{if $user.user_name}{$user.user_name}{else}匿名用户{/if}</span>
                                {if $user.rank_name}<span class="rank_name">{$user.rank_name}</span>{/if}
                            </p>
                            <p>注册时间：{RC_Time::local_date('Y-m-d H:i:s', $user.reg_time)}</p>
                        </div>
                        <a target="__blank" class="view-detail" href='{url path="user/admin/info" args="id={$user.user_id}"}'>查看详细信息 >></a>
                    </div>
                    <div class="user-money">
                        <div class="item">
                            <p>账户余额</p>
                            <span class="ecjiafc-FF0000">{if $user.formated_user_money}{$user.formated_user_money}{else}￥0.00{/if}</span>
                        </div>
                        <div class="item">
                            <p>消费积分</p>
                            <span class="ecjiafc-FF0000">{if $user.pay_points}{$user.pay_points}{else}0{/if}</span>
                        </div>
                        <div class="item">
                            <p>成长值</p>
                            <span class="ecjiafc-FF0000">{if $user.rank_points}{$user.rank_points}{else}0{/if}</span>
                        </div><div class="item">
                            <p>红包数量</p>
                            <span class="ecjiafc-FF0000">{if $user.bonus_count}{$user.bonus_count}{else}0{/if}</span>
                        </div>
                    </div>
                    <div class="user-address">
                        <div class="address-title">收货地址</div>
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
                            <div class="no-records">暂无收货地址</div>
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
				<div class="m_t5">提交订单</div>
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
				<div class="m_t5">交易完成</div>
			</div>
		</li>
	</ul>
</div>

<div class="row-fluid">
	<form name="queryinfo" action='{url path="orders/admin/query_info"}' method="post">
		<div class="span12 ecjiaf-tac">
			<div class="ecjiaf-fl">
				<h3>订单号：{$order.order_sn}</h3>
			</div>
			<span class="choose_list">
				<input type="text" name="keywords" class="ecjiaf-fn" placeholder="请输入订单号或者订单id" />
				<button class="btn ecjiaf-fn" type="submit">搜索</button>
			</span>
			<div class="f_r">
				{if $next_id}
				<a class="data-pjax ecjiaf-tdn" href='{url path="orders/admin/info" args="order_id={$next_id}"}'>
					{/if}
					<button class="btn btn-small" type="button" {if !$next_id}disabled="disabled" {/if}>前一个订单</button>
					{if $next_id}
				</a>
				{/if} {if $prev_id}
				<a class="data-pjax ecjiaf-tdn" href='{url path="orders/admin/info" args="order_id={$prev_id}"}'>
					{/if}
					<button class="btn btn-small" type="button" {if !$prev_id}disabled="disabled" {/if}>后一个订单</button>
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
							<strong>基本信息</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="collapseOne">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>订单号：</strong>
										</div>
									</td>
									<td>
										{$order.order_sn}
									</td>
									<td>
										<div align="right">
											<strong>订单状态：</strong>
										</div>
									</td>
									<td>{$order.status}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>购买人：</strong>
										</div>
									</td>
									<td>
										{$order.user_name}
                                        {if $order.user_id gt 0}
                                        [ <a class="userInfo cursor_pointer" data-toggle="modal" href="#consigneeinfo" title="显示购货人信息">显示购货人信息</a> ]
                                        {/if}
									</td>
									<td>
										<div align="right">
											<strong>下单时间：</strong>
										</div>
									</td>
									<td>{$order.formated_add_time}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>支付方式：</strong>
										</div>
									</td>
									<td>
										{$order.pay_name}
									</td>
									<td>
										<div align="right">
											<strong>付款时间：</strong>
										</div>
									</td>
									<td>{$order.pay_time}</td>
								</tr>

								<tr>
									<td>
										<div align="right">
											<strong>配送方式：</strong>
										</div>
									</td>
									<td>
										{if $exist_real_goods}
										<span>{if $order.shipping_name}{$order.shipping_name}{/if}</span>
										{if $order.shipping_id gt 0 && $order.insure_fee gt 0}保价费用：{$order.formated_insure_fee}{/if}
										{/if}
									</td>
									<td>
										<div align="right">
											<strong>期望送达时间：</strong>
										</div>
									</td>
									<td>{$order.expect_shipping_time}</td>
								</tr>

								<tr>
									<td>
										<div align="right">
											<strong>发货时间：</strong>
										</div>
									</td>
									<td>{$order.shipping_time}</td>
									<td>
										<div align="right">
											<strong>运单编号：</strong>
										</div>
									</td>
									<td>
										{if $order.shipping_id gt 0 and $order.shipping_status gt 0}
										<span>{if $order.invoice_no}{$order.invoice_no}{else}暂无{/if}</span>
										{/if}
									</td>
								</tr>

								{if $order.express_user}
								<tr>
									<td>
										<div align="right">
											<strong>配送员：</strong>
										</div>
									</td>
									<td>{$order.express_user}</td>
									<td>
										<div align="right">
											<strong>配送员电话：</strong>
										</div>
									</td>
									<td>{$order.express_mobile}</td>
								</tr>
								{/if}

								<tr>
									<td>
										<div align="right">
											<strong>订单来源：</strong>
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
                            <strong>参与活动</strong>
                        </a>
                    </div>
                    <div class="accordion-body in collapse" id="collapseGroupBuy">
                        <table class="table table-oddtd m_b0">
                            <tbody class="first-td-no-leftbd">
                                <tr>
                                    <td>
                                        <div align="right">
                                            <strong>活动类型：</strong>
                                        </div>
                                    </td>
                                    <td>团购</td>
                                    <td>
                                        <div align="right">
                                            <strong>活动状态：</strong>
                                        </div>
                                    </td>
                                    <td>{$groupbuy_info.status_desc}</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div align="right">
                                            <strong>店铺名称：</strong>
                                        </div>
                                    </td>
                                    <td>{$order.merchants_name}</td>
                                    <td>
                                        <div align="right">
                                            <strong>活动商品：</strong>
                                        </div>
                                    </td>
                                    <td>{$groupbuy_info.goods_name} <a target="__blank" href="{RC_Uri::url('groupbuy/admin/view')}&id={$groupbuy_info.act_id}">[ 活动详情 ]</a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div align="right">
                                            <strong>保证金：</strong>
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
							<strong>发货单信息</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseDelivery">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>发货单流水号：</strong>
										</div>
									</td>
									<td colspan="3"><a href="{RC_Uri::url('orders/admin_order_delivery/delivery_info')}&delivery_id={$delivery_info.delivery_id}" target="__blank">{$delivery_info.delivery_sn}</a></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				{/if}

				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseTwo-a">
							<strong>发票信息</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseTwo-a">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>发票类型：</strong>
										</div>
									</td>
									<td>{$order.inv_type}</td>
									<td>
										<div align="right">
											<strong>纳税人识别码：</strong>
										</div>
									</td>
									<td>{$inv_tax_no}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>发票抬头：</strong>
										</div>
									</td>
									<td>{if $inv_payee}{$inv_payee}{else if $order.inv_type neq ''}个人{/if}</td>
									<td>
										<div align="right">
											<strong>发票内容：</strong>
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
							<strong>其他信息</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseTwo">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>订单备注：</strong>
										</div>
									</td>
									<td colspan="3">{$order.postscript}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>缺货处理：</strong>
										</div>
									</td>
									<td colspan="3">{$order.how_oos}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>商家给客户的留言：</strong>
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
							<strong>收货人信息</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseThree">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right">
											<strong>收货人：</strong>
										</div>
									</td>
									<td>{$order.consignee}</td>
									<td>
										<div align="right">
											<strong>手机号：</strong>
										</div>
									</td>
									<td>{$order.mobile}</td>
								</tr>
								<tr>
									<td>
										<div align="right">
											<strong>地址：</strong>
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
							<strong>商品信息</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseFour">
						<table class="table table-striped table_vam m_b0 order-table-list">
							<thead>
								<tr class="table-list">
									<th class="w80">商品缩略图</th>
									<th>商品名称 [ 品牌 ]</th>
									<th class="w80">货号</th>
									<th class="w70">货品号</th>
									<th class="w100">价格</th>
									<th class="w30">数量</th>
									<th class="w100">属性</th>
									<th class="w50">库存</th>
									<th class="w100">小计</th>
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
										<a href='{url path="goods/admin/preview" args="id={$goods.goods_id}"}' target="_blank">{$goods.goods_name} {if $goods.brand_name}[ {$goods.brand_name} ]{/if}{if $goods.is_gift}{if $goods.goods_price
											gt 0}（特惠品）{else}（赠品）{/if}{/if}{if $goods.parent_id
											gt 0}（配件）{/if}</a>
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
									<td class="no-records" colspan="9">该订单暂无商品</td>
								</tr>
								{/foreach}
								<tr>
									<td colspan="5">
                                        {if $order.total_weight}
										<div align="right">
											<strong>商品总重量：</strong>
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
											<strong>合计：</strong>
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
							<strong>费用信息</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseFive">
						<table class="table m_b0">
							<tr>
								<td>
									<div align="right">
										商品总金额：
										<strong>{$order.formated_goods_amount}</strong>
										- 折扣：
										<strong>{$order.formated_discount}</strong>
										+ 发票税额：
										<strong>{$order.formated_tax}</strong>
										+ 配送费用：
										<strong>{$order.formated_shipping_fee}</strong>
										+ 保价费用：
										<strong>{$order.formated_insure_fee}</strong>
										+ 支付费用：
										<strong>{$order.formated_pay_fee}</strong>
										+ 包装费用：
										<strong>{$order.formated_pack_fee}</strong>
										+ 贺卡费用：
										<strong>{$order.formated_card_fee}</strong>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div align="right"> = 订单总金额：
										<strong>{$order.formated_total_fee}</strong>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										- 已付款金额：
										<strong>{$order.formated_money_paid}</strong>
										- 使用余额：
										<strong>{$order.formated_surplus}</strong>
										- 使用积分：
										<strong>{$order.formated_integral_money}</strong>
										- 使用红包：
										<strong>{$order.formated_bonus}</strong>
									</div>
								</td>
							</tr>
							<tr>
								<td>
									<div align="right">
										= {if $order.order_amount >= 0} 应付款金额：
										<strong>{$order.formated_order_amount}</strong>
										{else} 应退款金额：
										<strong>{$order.formated_money_refund}</strong>
										<input class="refund_click btn" type="button" data-href="{$refund_url}" value="退款"> {/if}
                                        {if $order.extension_code eq "group_buy"}<br/>（备注：团购如果有保证金，第一次只需支付保证金和相应的支付费用）{/if}
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseSix">
							<strong>操作记录</strong>
						</a>
					</div>
					<div class="accordion-body in collapse" id="collapseSix">
						<table class="table table-striped m_b0">
							<thead>
								<tr>
									<th class="w150">
										<strong>操作者</strong>
									</th>
									<th class="w180">
										<strong>操作时间</strong>
									</th>
									<th class="w150">
										<strong>订单状态</strong>
									</th>
									<th class="ecjiafc-pre t_c w150">
										<strong>操作备注</strong>
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
									<td class="no-records" colspan="4">该订单暂无操作记录</td>
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