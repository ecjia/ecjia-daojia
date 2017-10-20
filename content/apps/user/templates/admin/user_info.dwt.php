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
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>


<div class="row-fluid">
	<div class="choose_list" >
		<form method="post" action="{url path='user/admin/info'}" name="searchForm" data-id="{$user.user_id}">
			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='user::users.id_confirm'}"/> 
			<button class="btn" type="submit">{lang key='user::users.view'}</button>
		</form>
	</div>
</div>

<div class="row-fluid">
	<div class="span12">
		<form action="{$form_action}" method="post" name="theForm" id="theForm" data-url='{url path="orders/admin/operate_post" args="order_id={$order.order_id}"}'  data-pjax-url='{url path="orders/admin/info" args="order_id={$order.order_id}"}' data-list-url="{url path='orders/admin/init'}" data-remove-url="{$remove_action}">
			<div id="accordion2" class="foldable-list">
				<div class="accordion-group">
					<div class="accordion-heading">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic1">
							<strong>{lang key='user::users.member_information'}</strong>
							<a target="_blank" href='{url path="user/admin/edit" args="id={$user.user_id}"}'>{lang key='user::users.edit'}</a>
						</div>
					</div>
					<div class="accordion-body in collapse" id="telescopic1">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>{lang key='user::users.user_names'}</strong></div></td>
									<td>{$user.user_name}</td>
									<td><div align="right"><strong>{lang key='user::users.label_email'}</strong></div></td>
									<td>{$user.email}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{lang key='user::users.label_gender'}</strong></div></td>
									<td>{if $user.sex eq 1 }{lang key='user::users.sex.1'}{elseif $user.sex eq 2}{lang key='user::users.sex.2'}{else}{lang key='user::users.sex.0'}{/if}</td>
									<td><div align="right"><strong>{lang key='user::users.label_birthday'}</strong></div></td>
									<td>{if $user.birthday neq '0000-00-00'}{$user.birthday}{else}{/if}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{lang key='user::users.label_user_rank'}</strong></div></td>
									<td>{if !$user.user_rank }非特殊等级{else}{$user.user_rank}{/if}</td>
									<td><div align="right"><strong>{lang key='user::users.label_credit_line'}</strong></div></td>
									<td>{$user.credit_line}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{lang key='user::users.lable_registration_time'}</strong></div></td>
									<td>{$user.reg_time}</td>
									<td><div align="right"><strong>{lang key='user::users.parent_user_lable'}</strong></div></td>
									<td>{$user.parent_username}</td>
								</tr>
								
								<!-- {if $extend_info_list} -->
									<!-- {foreach from=$extend_info_list item=field key=key} -->
									{if $key eq 0 || $key eq 2 || $key eq 4}
									<tr>
									<td><div align="right"><strong>{$field.reg_field_name}</strong></div></td>
									<td>{$field.content}</td>
									{/if}
								
									{if $key eq 1 || $key eq 3}
									<td><div align="right"><strong>{$field.reg_field_name}</strong></div></td>
									<td>{$field.content}</td>
									</tr>
									{/if}
									<!-- {/foreach} -->
									<td><div align="right"><strong>{lang key='user::users.email_verification_lable'}</strong></div></td>
									<td class="ecjiafc-f00">{$user.is_validated}</td>
								<!-- {else} -->
								<tr>
									<td><div align="right"><strong>{lang key='user::users.email_verification_lable'}</strong></div></td>
									<td colspan="3" class="ecjiafc-f00">{$user.is_validated}</td>
								</tr>
								<!-- {/if} -->
								<tr>
									<td><div align="right"><strong>{lang key='user::users.last_login_time_lable'}</strong></div></td>
									<td>{$user.last_time}</td>
									<td><div align="right"><strong>{lang key='user::users.last_login_ip_lable'}</strong></div></td>
									<td>{$user.last_ip}</td>
								</tr>
							</tbody>
						</table>
					</div>	
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic2">
							<strong>{lang key='user::users.users_money'}</strong>
							<a target="_blank" href='{url path="finance/admin_account_log/init" args="user_id={$user.user_id}"}'>{lang key='user::users.edit'}</a>
						</div>
					</div>
					<div class="accordion-body in collapse" id="telescopic2">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>{lang key='user::users.user_money_lable'}</strong></div></td>
									<td>{$user.formated_user_money}</td>
									<td><div align="right"><strong>{lang key='user::users.frozen_money_lable'}</strong></div></td>
									<td>{$user.formated_frozen_money}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{lang key='user::users.rank_points_lable'}</strong></div></td>
									<td>{$user.rank_points}</td>
									<td><div align="right"><strong>{lang key='user::users.pay_points_lable'}</strong></div></td>
									<td>{$user.pay_points}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic3">
							<strong>{lang key='user::users.address_list'}</strong>
							<a target="_blank" href='{url path="user/admin/address_list" args="id={$user.user_id}"}'>{lang key='user::users.more'}</a>
						</div>
					</div>
					<div class="accordion-body in collapse" id="telescopic3">
						<table class="table table-oddtd  table-striped  m_b0">
							<tbody class="first-td-no-leftbd ">
								<!-- {foreach from=$address_list item=item} -->
								<tr class="{if $item.default_address}info{/if}">
									<td><div align="right"><strong>{$item.consignee} {if $item.default_address}{lang key='user::users.default_address'}{/if}</strong></div></td>
									<td colspan="3">
										{if $item.tel}{lang key='user::users.tel'}{$item.tel}<br/>{/if}
										{if $item.mobile}{lang key='user::users.mobile'}{$item.mobile}<br/>{/if}
										{if $item.zipcode}{lang key='user::users.zip_code'}{$item.zipcode}{/if}
									</td>
									<td>
										{$item.province_name}&nbsp;{$item.city_name}&nbsp;{$item.district_name}&nbsp;&nbsp;{$item.address}
									</td>
								</tr>
								<!-- {foreachelse} -->
								<tr>
									<td class="no-records" colspan="4">{lang key='user::users.no_address'}</td>
								</tr>
								<!-- {/foreach} -->
							</tbody>
						</table>
					</div>
				</div>
				<div class="accordion-group">
					<div class="accordion-heading">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic4">
							<strong>{lang key='user::users.member_order'}</strong>
							<a target="_blank" href='{url path="orders/admin/init" args="user_id={$user.user_id}"}'>{lang key='user::users.more'}</a>
						</div>
					</div>
					<div class="accordion-body in collapse" id="telescopic4">
						<table class="table table-striped table_vam  m_b0">
							<thead class="ecjiaf-bt">
								<tr >
									<th>{lang key='user::users.order_number'}</th>
									<th>{lang key='user::users.order_time'}</th>
									<th>{lang key='user::users.receiver_name'}</th>
									<th>{lang key='user::users.total_amount'}</th>
									<th>{lang key='user::users.order_status'}</th>
								</tr>
							</thead>
							<tbody>
							<!-- {foreach from=$order_list item=order} -->
								<tr>
									<td><a target="_blank" href='{url path="orders/admin/info" args="order_id={$order.order_id}"}' title="{lang key='user::users.view_order'}">{$order.order_sn}</a></td>
									<td>{$order.add_time}</td>
									<td valign="top" align="left">
										{if $order.consignee}
										<i class="fontello-icon-user ecjiafc-999"></i>：{$order.consignee}<br>
										{/if}
										{if $order.tel}
										<i class="fontello-icon-phone ecjiafc-999"></i>：{$order.tel} <br>
										{/if}
									</td>
									<td valign="top" nowrap="nowrap" align="right">{$order.goods_amount+$order.tax+$order.shipping_fee+$order.insure_fee+$order.pay_fee+$order.pack_fee+$order.card_fee-$order.discount}</td>
									<td valign="top" nowrap="nowrap" align="center">{$order.status}</td>
								</tr>
							<!-- {foreachelse} -->
							<tr><td class="no-records" colspan="10">{lang key='user::users.no_order_information'}</td></tr>
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