<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<style>
.table { margin:0}
.table-info>tbody>tr>td{ border:none;    padding: 4px}
.table-info tr>td:nth-child(odd) {
    background-color: #fff;
    border:none;
    padding-right: 0;
}
.table-info .user_name_tr td div { height:36px; line-height:36px;}
.table-info .user_name_tr td{ height:36px; line-height:36px;}
.user_name { display:inline-block;}
</style>
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
   	
<div class="row-fluid">
	<div class="span12">
		<form action="{$form_action}" method="post" name="orderpostForm" >
			<div id="accordion2" class="panel panel-default">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <h4 class="panel-title">
                            <strong>{t domain="customer"}基本信息{/t}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse" id="collapseOne">
					<div class="panel-body">
    					<div class="pull-left">
    						<img alt="" src="{if $user_info.avatar_img}{$user_info.avatar_img}{else}{$ecjia_main_static_url}img/ecjia_avatar.jpg{/if}" width="100"><br>
                        </div>
                        <div class="col-sm-10">
                        	<table class="table table-oddtd table-info">
                        		<tr class="user_name_tr">
                        			<td><div align="right">{t domain="customer"}会员名称：{/t}</div></td>
                        			<td colspan="3"><h3 class="user_name ecjiafc-red">{$user_info.user_name}</h3> ({$user_info.rank_name})</td>
                        		</tr>
                        		<!-- {if $manage_mode eq 'self'} -->
                        		<tr>
                        			<td><div align="right">{t domain="customer"}手机号码：{/t}</div></td>
                        			<td>{$user_info.mobile_phone}</td>
                        			<td><div align="right">{t domain="customer"}邮箱账号：{/t}</div></td>
                        			<td>{$user_info.email}</td>
                        		</tr>
                        		<!-- {else} -->
                        		<tr>
                        			<td><div align="right">{t domain="customer"}手机号码：{/t}</div></td>
                        			<td colspan="3">{$user_info.mobile_phone_format}</td>
                        		</tr>
                        		<!-- {/if} -->
                        		<tr>
                        			<td><div align="right">{t domain="customer"}注册时间：{/t}</div></td>
                        			<td>{$user_info.reg_time_format}</td>
                        			<td><div align="right">{t domain="customer"}最近购买时间：{/t}</div></td>
                        			<td>{$user_info.last_buy_time_format}</td>
                        		</tr>
                        		<tr>
                        			<td><div align="right">{t domain="customer"}最近收货地区：{/t}</div></td>
                        			<td colspan="3">{if $user_info.city_name}{$user_info.province_name} {$user_info.city_name}{else}{t domain="customer"}暂无{/t}{/if}</td>
                        		</tr>
                        	</table>
                        </div>
					</div>
				</div>
			</div>
			
			<div class="accordion-group panel panel-default">
				<div class="panel-heading accordion-group-heading-relative">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        <h4 class="panel-title">
                            <strong>{t domain="customer"}会员资金{/t}</strong>
                        </h4>
                    </a>
                </div>
                <div class="accordion-body in collapse " id="collapseThree">
                	<div class="panel-body">
                		{if $manage_mode eq 'self'}
                		<div class="col-sm-6 ecjiaf-tac">{t domain="customer"}消费金额：{/t}{$user_info.buy_amount}</div>
                		<div class="col-sm-6 ecjiaf-tac">{t domain="customer"}可用金额：{/t}{$user_info.user_money}</div>
                		{else}
                		<div class="col-sm-12 ecjiaf-tac">{t domain="customer"}消费金额：{/t}{$user_info.buy_amount}</div>
                		{/if}
                	</div>
                </div>
			</div>
			{if $manage_mode eq 'self'}
			<div class="accordion-group panel panel-default">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
                        <h4 class="panel-title">
                            <strong>{t domain="customer"}收货地址{/t}</strong>
                        </h4>
                    </a>
                </div>
                <div class="accordion-body in collapse" id="collapseSeven">
                	<table class="table table-striped m_b0">
						<thead>
							<tr>
								<th class="w150"><strong>{t domain="customer"}收货人{/t}</strong></th>
								<th class="w180"><strong>{t domain="customer"}手机号{/t}</strong></th>
								<th class="w180"><strong>{t domain="customer"}地区{/t}</strong></th>
								<th class="w280"><strong>{t domain="customer"}详细地址{/t}</strong></th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$address_list item=list} -->
							<tr {if $list.default_address eq 1}class="info"{/if}>
								<td>{$list.consignee}{if $list.default_address eq 1}({t domain="customer"}默认地址{/t}){/if}</td>
								<td>{$list.mobile}</td>
								<td>{$list.province_name} {$list.city_name} {$list.district_name}</td>
								<td>{$list.street_name}{$list.address}{$list.address_info}</td>
							</tr>
							<!-- {foreachelse} -->
							<tr>
								<td class="no-records w200" colspan="6">{t domain="customer"}暂无记录{/t}</td>
							</tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
                </div>
			</div>
			{/if}
			<div class="accordion-group panel panel-default">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#order">
                        <h4 class="panel-title">
                            <strong>{t domain="customer"}会员订单{/t}({$order_list.count})</strong>
                        </h4>
                    </a>
                </div>
                <div class="accordion-body in collapse" id="order">
                	<table class="table table-striped m_b0">
						<thead>
							<tr>
								<th class="w180"><strong>{t domain="customer"}订单号{/t}</strong></th>
								<th class="w180"><strong>{t domain="customer"}下单时间{/t}</strong></th>
								<th class="w150"><strong>{t domain="customer"}收货人{/t}</strong></th>
								<th class="w150"><strong>{t domain="customer"}订单金额{/t}</strong></th>
								<th class="w150"><strong>{t domain="customer"}订单状态{/t}</strong></th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$order_list.list item=list} -->
							<tr>
								<td><a href="{url path='orders/merchant/info' args='order_sn='}{$list.order_sn}" target="_blank">{$list.order_sn}</a></td>
								<td>{$list.add_time}</td>
								<td>{$list.consignee}</td>
								<td>{price_format($list.goods_amount + $list.tax + $list.shipping_fee + $list.insure_fee + $list.pay_fee + $list.pack_fee + $list.card_fee - $list.discount)}</td>
								<td>{$list.status}</td>
							</tr>
							<!-- {foreachelse} -->
							<tr>
								<td class="no-records w200" colspan="6">{t domain="customer"}暂无记录{/t}</td>
							</tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
					<div class="panel-body"><!-- {$order_list.page} --></div>
                </div>
			</div>
			
		</form>
	</div>
</div>
<!-- {/block} -->