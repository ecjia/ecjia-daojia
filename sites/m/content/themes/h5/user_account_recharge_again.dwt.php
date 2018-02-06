<?php
/*
Name: 账户继续充值模板
Description: 账户继续充值充值页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript" >
ecjia.touch.user_account.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-account ecjia-form user-profile-form" name="useraccountForm" action="{url path='user/account/recharge_again_account'}" method="post">
    <div class="ecjia-form ecjia-account ecjia-flow-done ecjia-pay">
    	{if !$pay_msg}
    		<div class="help-text"><p>{t}当前订单不支持原有支付方式，请切换新的支付方式继续支付。{/t}</p></div>
    	{/if}
    	
    	<div class="account-user-money">{$format_amount}</div>
    	<div class="account-user-info">{t}为账户【{$user.name}】充值{/t}</div>
    	
    	 {if $payment_list}
		    <ul class="ecjia-list ecjia-margin-t">
		        <li>
		                        支付方式 <span class="ecjiaf-fr"></span>
		        </li>
		    </ul>
		    <ul class="ecjia-list list-short payment-list">
		    <!-- {foreach from=$payment_list item=list} -->
		        <li class="ecjia-account-padding-input user_pay_way">
		            <span class="icon-name {$list.pay_code}" data-code="{$list.pay_code}">
                		<label for="{$list.pay_id}" class="ecjiaf-fr ecjia-check">
                			<input type="radio" id="{$list.pay_id}" name="pay_id" value="{$list.pay_id}"{if $list.checked}checked="true"{/if} >
                		</label>
		            	{$list.pay_name}
		            </span>
		        </li>
		    <!-- {/foreach} -->
		    </ul>
	    {/if}
    	<input name="account_id" type="hidden" value="{$account_id}" />
    	<div class="text-center account-top">
    		<input class="btn btn-recharge pay-btn" name="submit" type="submit" value="{t}继续充值{/t}" />
    	</div>
    	<div class="wei-xin-pay hide"></div>
    </div>	
</form>
<!-- {/block} -->