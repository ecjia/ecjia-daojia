<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.order.addedit();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
{if $shipping_list_error}
<div class="alert alert-error">
	<strong>{t domain="orders"}您可能没有添加配送插件或填写收货人地址信息！暂无对应的配送方式！{/t}</strong>
</div>
{/if}

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --><!-- {if $user_name}<small>{t domain="orders" 1={$user_name}}（当前用户：%1）{/t}</small>{/if} --></h2>
  	</div>
  	<div class="clearfix"></div>
</div>

<form name="shippingForm" action='{url path="orders/merchant/edit_shipping_post" args="order_id={$order_id}"}' method="post">
	<!-- {if $exist_real_goods} -->
	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<table class="table table-striped table-hover table-hide-edit">
					<thead>
						<tr>
							<th class="w35">&nbsp;</th>
							<th class="w100">{t domain="orders"}名称{/t}</th>
							<th>{t domain="orders"}描述{/t}</th>
							<th class="w100">{t domain="orders"}配送费{/t}</th>
							<th class="w100">{t domain="orders"}免费额度{/t}</th>
							<th class="w100">{t domain="orders"}保价费{/t}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$shipping_list item=shipping} -->
						<tr>
							<td>
								<input id="{$shipping.shipping_id}" name="shipping" type="radio" data-cod="{$shipping.support_cod}" value="{$shipping.shipping_id}" {if $order.shipping_id eq $shipping.shipping_id}checked{/if} />
								<label for="{$shipping.shipping_id}"></label>
							</td>
							<td>{$shipping.shipping_name}</td>
							<td>{$shipping.shipping_desc}</td>
							<td><div>{$shipping.format_shipping_fee}</div></td>
							<td><div>{$shipping.free_money}</div></td>
							<td><div>{$shipping.insure}</div></td>
						</tr>
						<!-- {foreachelse}-->
    					<tr><td class="no-records" colspan="6">{t domain="orders"}没有找到任何记录{/t}</td></tr>
    					<!-- {/foreach} -->
					</tbody>
				</table>
			</section>
		</div>
	</div>
	<p align="right">
		<input id="insure" class="form-control" name="insure" type="checkbox" value="1" {if $order.insure_fee > 0}checked{/if} />
		<label for="insure">{t domain="orders"}我要保价{/t}</label>
	</p>
	<!--{/if}-->

	<div class="page-header">
		<div class="pull-left">
			<h2><!-- {if $ur_heres}{$ur_heres}{/if} --></h2>
	  	</div>
	  	<div class="clearfix"></div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<section class="panel">
				<table class="table table-striped table-hover table-hide-edit">
					<thead>
						<tr>
							<th class="w35">&nbsp;</th>
							<th class="w100">{t domain="orders"}名称{/t}</th>
							<th>{t domain="orders"}描述{/t}</th>
							<th class="w100">{t domain="orders"}手续费{/t}</th>
						</tr>
					</thead>
					<!-- {foreach from=$payment_list item=payment} -->
					<tr>
						<td>
						<input id="{$payment.pay_id}" type="radio" name="payment" data-cod="{$payment.is_cod}" value="{$payment.pay_id}" {if $order.pay_id eq $payment.pay_id}checked{/if} />
						<label for="{$payment.pay_id}"></label>
						</td>
						<td>{$payment.pay_name}</td>
						<td>{$payment.pay_desc}</td>
						<td>{$payment.pay_fee}</td>
					</tr>
					<!-- {foreachelse}-->
    				<tr><td class="no-records" colspan="4">{t domain="orders"}没有找到任何记录{/t}</td></tr>
    				<!-- {/foreach} -->
				</table>
			</section>
		</div>
	</div>
	<p align="center">
		<button class="btn btn-info" type="submit">{t domain="orders"}确定{/t}</button>
		<input type="hidden" name="action_note" value="{$action_note}" />
		<a class="data-pjax" href='{url path="orders/merchant/go_shipping" args="order_id={$order_id}{if $action_note}&action_note={$action_note}{/if}"}'>
            <button class="btn btn-default" type="button">{t domain="orders"}取消{/t}</button>
        </a>
	</p>
</form>
<!-- {/block} -->