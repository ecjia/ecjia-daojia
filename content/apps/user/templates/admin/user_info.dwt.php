<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.user_info.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>


<div class="row-fluid">
	<div class="choose_list">
		<form method="post" action="{url path='user/admin/info'}" name="searchForm" data-id="{$user.user_id}">
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="user"}请输入ID或会员名称或邮箱{/t}' />
			<button class="btn" type="submit">{t domain="user"}查看{/t}</button>
		</form>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<form action="{$form_action}" method="post" name="theForm" id="theForm" data-url='{url path="orders/admin/operate_post" args="order_id={$order.order_id}"}'
		 data-pjax-url='{url path="orders/admin/info" args="order_id={$order.order_id}"}' data-list-url="{url path='orders/admin/init'}"
		 data-remove-url="{$remove_action}">
			<div id="accordion2" class="foldable-list">
				<div class="accordion-group">
					<div class="accordion-heading">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic1">
							<strong>{t domain="user"}基本信息{/t}</strong>
							<a target="_blank" href='{url path="user/admin/edit" args="id={$user.user_id}"}'>编辑</a>
						</div>
					</div>
					<div class="accordion-body in collapse" id="telescopic1">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td>
										<div align="right"><strong>{t domain="user"}会员名称：{/t}</strong></div>
									</td>
									<td>{$user.user_name}</td>
									<td>
										<div align="right"><strong>{t domain="user"}邮箱账号：{/t}</strong></div>
									</td>
									<td>{$user.email}</td>
								</tr>

								<tr>
									<td>
										<div align="right"><strong>{t domain="user"}性别：{/t}</strong></div>
									</td>
									<td>{if $user.sex eq 1 }{t domain="user"}男{/t}{elseif $user.sex eq 2}{t domain="user"}女{/t}{else}{t domain="user"}保密{/t}{/if}</td>
									<td>
										<div align="right"><strong>{t domain="user"}出生日期：{/t}</strong></div>
									</td>
									<td>{if $user.birthday neq '0000-00-00'}{$user.birthday}{else}{/if}</td>
								</tr>

								<tr>
									<td>
										<div align="right"><strong>{t domain="user"}手机号码：{/t}</strong></div>
									</td>
									<td>{$user.mobile_phone}</td>
									<td>
										<div align="right"><strong>{t domain="user"}微信：{/t}</strong></div>
									</td>
									
									<td>{if $wechat_info}{$wechat_info.nickname}{else}{t domain="user"}未绑定{/t}{/if}</td>
								</tr>

								<tr>
									<td>
										<div align="right"><strong>QQ：</strong></div>
									</td>
									<td>{if $qq_info}{t domain="user"}已绑定{/t}{else}{t domain="user"}未绑定{/t}{/if}</td>
									<td>
										<div align="right"><strong>{t domain="user"}会员等级：{/t}</strong></div>
									</td>
									<td>{$user.user_rank_name}</td>
								</tr>

								<tr>
									<td>
										<div align="right"><strong>{t domain="user"}信用额度：{/t}</strong></div>
									</td>
									<td>{$user.credit_line}</td>
									<td>
										<div align="right"><strong>{t domain="user"}推荐人：{/t}</strong></div>
									</td>
									<td>{$user.parent_username}</td>
								</tr>

								<tr>
									<td>
										<div align="right"><strong>{t domain="user"}注册时间：{/t}</strong></div>
									</td>
									<td>{$user.reg_time}</td>
									<td>
										<div align="right"><strong>{t domain="user"}最后登录时间：{/t}</strong></div>
									</td>
									<td>{$user.last_time}</td>
								</tr>

								<tr>
									<td>
										<div align="right"><strong>{t domain="user"}最后登录IP：{/t}</strong></div>
									</td>
									<td colspan="3">{$user.last_ip}</td>
								</tr>

								<tr>
									<td>
										<div align="right"><strong>{t domain="user"}删除会员：{/t}</strong></div>
									</td>
									<td colspan="3"><a class="btn data-pjax" href="{RC_Uri::url('user/admin/remove_user')}&id={$user.user_id}">{t domain="user"}去删除账号数据{/t}</a></td>
								</tr>

							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic2">
							<strong>{t domain="user"}会员资金{/t}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="telescopic2">
						<div class="item-content">
							<div class="item">
                                {t domain="user"}可用资金：{/t}<span class="ecjiafc-FF0000">{$user.formated_user_money}</span>
                                <a class="m_l5" target="__blank" href="{RC_Uri::url('finance/admin_account_log/init')}&account_type=user_money&user_id={$user.user_id}">{t domain="user"}查看{/t}</a>
                            </div>
							<div class="item">
                                {t domain="user"}冻结资金：{/t}<span class="ecjiafc-FF0000">{$user.formated_frozen_money}</span>
                            </div>
							<div class="item">
                                {t domain="user"}积分：{/t}<span class="ecjiafc-FF0000">{$user.pay_points}</span>
                                <a class="m_l5" target="__blank" href="{RC_Uri::url('finance/admin_account_log/init')}&account_type=pay_points&user_id={$user.user_id}">{t domain="user"}查看{/t}</a>
                            </div>
							<div class="item">
                                {t domain="user"}成长值：{/t}<span class="ecjiafc-FF0000">{$user.rank_points}</span>
                                <a class="m_l5" target="__blank" href="{RC_Uri::url('finance/admin_account_log/init')}&account_type=rank_points&user_id={$user.user_id}">{t domain="user"}查看{/t}</a>
                            </div>
						</div>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic3">
							<strong>{t domain="user"}收货地址{/t}</strong>
							<a target="_blank" href='{url path="user/admin/address_list" args="id={$user.user_id}"}'>{lang
								key='user::users.more'}</a>
						</div>
					</div>
					<div class="accordion-body in collapse" id="telescopic3">
						<table class="table table-oddtd  table-striped  m_b0">
							<tbody class="first-td-no-leftbd ">
								<!-- {foreach from=$address_list item=item} -->
								<tr class="{if $item.default_address}info{/if}">
									<td>
										<div align="right"><strong>{$item.consignee} {if $item.default_address}{t domain="user"}（默认地址）{/t}{/if}</strong></div>
									</td>
									<td colspan="3">
										{if $item.tel}{t domain="user"}电话{/t}{$item.tel}<br />{/if}
										{if $item.mobile}{t domain="user"}手机{/t}{$item.mobile}<br />{/if}
										{if $item.zipcode}{t domain="user"}邮编{/t}{$item.zipcode}{/if}
									</td>
									<td>
										{$item.province_name}&nbsp;{$item.city_name}&nbsp;{$item.district_name}&nbsp;&nbsp;{$item.street_name}&nbsp;&nbsp;{$item.address}&nbsp;&nbsp;{$item.address_info|escape}
									</td>
								</tr>
								<!-- {foreachelse} -->
								<tr>
									<td class="no-records" colspan="3">{t domain="user"}该用户暂无收货地址{/t}</td>
								</tr>
								<!-- {/foreach} -->
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic4">
							<strong>{t domain="user"}会员订单{/t}</strong>
							<a target="_blank" href='{url path="orders/admin/init" args="user_id={$user.user_id}"}'>{lang
								key='user::users.more'}</a>
						</div>
					</div>
					<div class="accordion-body in collapse" id="telescopic4">
						<table class="table table-striped table_vam  m_b0">
							<thead class="ecjiaf-bt">
								<tr>
									<th>{t domain="user"}订单号{/t}</th>
									<th>{t domain="user"}下单时间{/t}</th>
									<th>{t domain="user"}收货人{/t}</th>
									<th>{t domain="user"}总金额{/t}</th>
									<th>{t domain="user"}订单状态{/t}</th>
								</tr>
							</thead>
							<tbody>
								<!-- {foreach from=$order_list item=order} -->
								<tr>
									<td><a target="_blank" href='{url path="orders/admin/info" args="order_id={$order.order_id}"}' title='{t domain="user"}查看订单{/t}'>{$order.order_sn}</a></td>
									<td>{$order.add_time}</td>
									<td valign="top" align="left">
										{if $order.consignee}
										<i class="fontello-icon-user ecjiafc-999"></i>：{$order.consignee}<br>
										{/if}
										{if $order.tel}
										<i class="fontello-icon-phone ecjiafc-999"></i>：{$order.tel} <br>
										{/if}
									</td>
									<td valign="top" nowrap="nowrap" align="right">{price_format($order.goods_amount + $order.tax +
										$order.shipping_fee + $order.insure_fee + $order.pay_fee + $order.pack_fee + $order.card_fee -
										$order.discount)}</td>
									<td valign="top" nowrap="nowrap" align="center">{$order.status}</td>
								</tr>
								<!-- {foreachelse} -->
								<tr>
									<td class="no-records" colspan="5">{t domain="user"}该会员暂无订单信息{/t}</td>
								</tr>
								<!-- {/foreach} -->
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- {/block} -->