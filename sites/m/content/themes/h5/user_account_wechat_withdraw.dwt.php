<?php
/*
Name: 账户提现模板
Description: 账户提现页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {nocache} -->
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user_account.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-account ecjia-form user-profile-form" action="{url path='user/account/withdraw_account'}" method="post" name="widthDrawForm">
	<div class="ecjia-user">
		<div class="ecjia-list list-short">
			<li class="height-3">
				<span class="icon-name margin-no-l">提现方式</span>
				<span class="icon-price text-color choose-div">
                    <span class="choose_bank">
                        {if $bank_info}
                        <img class="icon" src="{$bank_info.bank_icon}" />{$bank_info.bank_name}
                        {/if}
                    </span>
                    <input type="hidden" name="bank_type" value="{$bank_info.bank_type}" />
                    <i class="iconfont icon-jiantou-right"></i>
                </span>
			</li>
			<li class="height-5">
				<span class="icon-name margin-no-l">￥</span>
				<input placeholder="可提现金额 {$user.formated_user_money}" name="amount" />
				<span class="withdraw_all_span" data-price="{$user.user_money}">全部提现</span>
			</li>
			<li class="height-3">
				<p class="text-ty m_l0">最低提现金额：{$config.formatted_min_withdraw_amount}</p>
			</li>
		</div>

		<div class="ecjia-list list-short">
			<li class="height-3">
				<p class="m_l0">提现手续费<label class="ecjiaf-fr withdraw_fee_label"><span>￥</span><span class="withdraw_fee_money">0.00</span></label></p>
			</li>
		</div>
	</div>
	<p class="wechat_withdraw_notice">申请提交后，我们将3-5个工作日审核，请您耐心等待</p>

	<div class="text-center">
		<input type="hidden" name="withdraw_fee_percent" value="{$config.withdraw_fee_percent}" />
		<input class="btn btn-info" name="submit" type="submit" value="{t}立即提现{/t}" />
	</div>
</form>

<input type="hidden" name="bank_list" value='{$bank_list}'>
<!-- {/block} -->
<!-- {/nocache} -->