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

                <input name="has_set_paypass" type="hidden" value="{if $user.has_paypassword eq 1}1{else}0{/if}" />
                <input type="hidden" class="set_paypass_url" data-url="{url path='user/profile/set_pay_password'}" />

		    	<input class="btn btn-recharge quick_pay_btn" name="submit" type="submit" value="确认支付" />
		    	<div class="wei-xin-pay hide"></div>
		    </div>
	    </div>
	</div>
</form>

<div class="mod_address_slide" id="enterPassArea">
    <div class="mod_address_slide_main">
        <div class="mod_address_slide_head">
            请输入支付密码<i class="iconfont icon-close"></i>
        </div>
        <div class="mod_address_slide_body h350">
            <div class="ecjia-form">
                <p class="ecjiaf-tac ecjia-margin-b ecjia-margin-t ecjia-color-85878c">为了保证您的账户安全，请输入您的支付密码</p>
                </p>
                <div id="payPassword_container">
                    <div class="pass_container enter_paypass_container">
                        <div class="input" type="tel" maxlength="1"></div>
                        <div class="input" type="tel" maxlength="1"></div>
                        <div class="input" type="tel" maxlength="1"></div>
                        <div class="input" type="tel" maxlength="1"></div>
                        <div class="input" type="tel" maxlength="1"></div>
                        <div class="input" type="tel" maxlength="1"></div>
                    </div>
                </div>
                <input name="url" type="hidden" value="{url path='user/quickpay/dopay'}" />
                <a class="ecjiaf-fr blue forget_paypass" href="{RC_Uri::url('user/profile/set_pay_password')}" style="padding-right:2em;color:#337ab7;">忘记支付密码</a>
            </div>
            <ul class="keyboard pct100 abs-lb" id="keyboard">
                <li data-key="1">
                    <p>1</p>
                </li>
                <li data-key="2">
                    <p>2</p>
                    <p class="letter">ABC</p>
                </li>
                <li data-key="3">
                    <p>3</p>
                    <p class="letter">DEF</p>
                </li>
                <li data-key="4">
                    <p>4</p>
                    <p class="letter">GHI</p>
                </li>
                <li data-key="5">
                    <p>5</p>
                    <p class="letter">JKL</p>
                </li>
                <li data-key="6">
                    <p>6</p>
                    <p class="letter">MNO</p>
                </li>
                <li data-key="7">
                    <p>7</p>
                    <p class="letter">PQRS</p>
                </li>
                <li data-key="8">
                    <p>8</p>
                    <p class="letter">TUV</p>
                </li>
                <li data-key="9">
                    <p>9</p>
                    <p class="letter">WXYZ</p>
                </li>
                <li class="bg-gray"></li>
                <li data-key="0">
                    <p>0</p>
                </li>
                <li class="bg-gray" data-key="del">
                    <i class="icon-del auto">
                        <img src="{$theme_url}images/user/keyboard_del.png" alt="">
                    </i>
                </li>
            </ul>
        </div>

    </div>
</div>
<!-- {/block} -->