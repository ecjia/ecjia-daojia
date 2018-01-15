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

<div class="panel panel-body">
	<div class="order-status-base order-third-base m_b20">
		<ul>
			<li class="step-first">
				<div class="{if $time_key lt '2'}step-cur{else}step-done{/if}">
					<div class="step-no">{if $time_key lt '2'}1{/if}</div>
					<div class="m_t5">{lang key='orders::order.submit_order'}</div>
					<div class="m_t5 ecjiafc-blue">{$order.formated_add_time}</div>
				</div>
			</li>
			<li>
				<div class="{if $time_key eq '2'}step-cur{elseif $time_key gt '2' && $pay_key}step-done{else}step-pay{/if}">
					<div class="step-no">{if $time_key eq '2' || !$pay_key}2{/if}</div>
					<div class="m_t5">{lang key='orders::order.pay_for_order'}</div>
					{if $pay_key}
					<div class="m_t5 ecjiafc-blue">{$order.pay_time}</div>
					{/if}
				</div>
			</li>
			<li class="step-last">
				<div class="{if $time_key eq '3'}step-cur{elseif $time_key gt '3'}step-done{/if}">
					<div class="step-no">{if $time_key lt '4'}3{/if}</div>
					<div class="m_t5">{lang key='orders::order.label_finished'}</div>
					{if $pay_key}
					<div class="m_t5 ecjiafc-blue">{$order.pay_time}</div>
					{/if}
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
								<!-- TODO 团购链接赞不知，以后修改测试 -->
								<td>
									{$order.order_sn}
									{if $order.extension_code eq "group_buy"}
<!-- 										<a href="group_buy.php?act=edit&id={$order.extension_id}">{lang key='orders::order.group_buy'}</a> -->
									{elseif $order.extension_code eq "exchange_goods"}
<!-- 										<a href="exchange_goods.php?act=edit&id={$order.extension_id}">{lang key='orders::order.exchange_goods'}</a> -->
									{/if}
								</td>
								<td><div align="right"><strong>{lang key='orders::order.label_order_status'}</strong></div></td>
								<td>{$order.status}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_user_name'}</strong></div></td>
								<td>
									{$order.user_name|default:{lang key='orders::order.anonymous'}}
								</td>
								<td><div align="right"><strong>购货人手机号：</strong></div></td>
								<td>{$order.mobile}</td>
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
								<td><div align="right"><strong>{lang key='orders::order.label_order_time'}</strong></div></td>
								<td>{$order.formated_add_time}</td>
								<td><div align="right"><strong>{lang key='orders::order.from_order'}</strong></div></td>
								<td>{if $order.referer eq 'ecjia-cashdesk'}收银台{else if $order.referer eq 'ecjia-storebuy'}小程序自助购物{else}{$order.referer}{/if}</td>
							</tr>
							
							<!-- {if $order.express_user} -->
							<tr>
								<td><div align="right"><strong>{lang key='orders::order.label_express_user'}</strong></div></td>
								<td>{$order.express_user}</td>
								<td><div align="right"><strong>{lang key='orders::order.label_express_user_mobile'}</strong></div></td>
								<td>{$order.express_mobile}</td>
							</tr>
							<!-- {/if}  -->
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
                    </a>
                </div>
                <div class="accordion-body in collapse " id="collapseSix">
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
								<th class="w130"><strong>{lang key='orders::order.pay_status'}</strong></th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$action_list item=action} -->
							<tr>
								<td>{$action.action_user}</td>
								<td>{$action.action_time}</td>
								<td>{$action.order_status}</td>
								<td>{$action.pay_status}</td>
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
		</form>
	</div>
</div>
<!-- {/block} -->