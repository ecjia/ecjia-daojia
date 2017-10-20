<?php
/*
Name: 确认支付
Description: 这是确认支付页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.quickpay.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-account ecjia-form user-profile-form" name="quickpay_form" action="{url path='user/quickpay/dopay'}" method="post">
	<div class="quickpay">
	    <div class="checkout">
	    	<div class="item_list ecjia-margin-t">
				<div class="quickpay_div background_fff">
					<div class="before_two">
						<div class="seller_info">
							<div class="seller_logo"><img src="{$order_info.store_logo}" /></div>
							<div class="seller_name">{$order_info.store_name}</div>
						</div>
						<div class="order_info">
							<div class="order_amount">{$order_info.formated_order_amount}</div>
							<div class="order_sn">优惠买单订单号：{$order_info.order_sn}</div>
						</div>
		          	</div>
				</div>
			</div>
	        
	        {if $payment_list}
	        <div class="item_list ecjia-margin-t">
		        <div class="quickpay_div content">
		            <div class="before_two line">
					    <ul class="ecjia-list list-short payment-list" data-url="{url path='user/quickpay/payment'}">
					    	<!-- {foreach from=$payment_list item=list key=key} -->
					    	<li class="ecjia-account-padding-input user_pay_way">
					            <span class="icon-name {$list.pay_code}" data-code="{$list.pay_code}">
					                <label class="ecjiaf-fr ecjia-check">
					                  	<input type="radio" name="pay_code" value="{$list.pay_code}" {if $key eq 0}checked{/if}/>
					                </label>
					                {$list.pay_name}
					            </span>
					        </li>
					    	<!-- {/foreach} -->
					    </ul>
					</div>    
		        </div>
	        </div>
	        {/if}
	        
	      	<div class="ecjia-margin-t">
	      		<input  type="hidden" name="order_id" value="{$order_info.order_id}" />
		    	<input class="btn btn-recharge quick_pay_btn" name="submit" type="submit" value="确认支付" />
		    	<div class="wei-xin-pay hide"></div>
		    </div>
	    </div>
	</div>
</form>
<!-- {/block} -->