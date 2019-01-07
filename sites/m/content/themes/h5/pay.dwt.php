<?php
/*
Name: 支付结算模板
Description: 
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

{if $detail.pay_code eq 'pay_balance' && $data.pay_status neq 'success'}
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.touch.flow.init();
</script>
<!-- {/block} -->
{/if}

<!-- {block name="main-content"} -->
<div class="ecjia-flow-done ecjia-pay">
    {if $tips_show}
    <div class="flow-success">
        <p>恭喜您，订单已经生成~</p>
    </div>
    {/if}
    <ul class="ecjia-list">
        <li>订单金额：<span class="ecjiaf-fr">{$detail.formated_total_fee}</span></li>

        {if $detail.extension_code eq 'group_buy' && $detail.formated_pay_money neq ''}
        <li>支付余额：<span class="ecjiaf-fr">{$detail.formated_pay_money}</span></li>
        {/if}

        <li>支付方式：<span class="ecjiaf-fr flow-msg">{if $data.pay_name}{$data.pay_name}{else}{$detail.pay_name}{/if}</span></li>
    </ul>
    <div class="ecjia-margin-t ecjia-margin-b flow-msg">{if $data.pay_status eq 'success'}支付成功！{else}{$pay_error}{/if}</div>

    {if $payment_list}
        <ul class="ecjia-list">
            <li>
                其它支付方式 <span class="ecjiaf-fr"></span>
            </li>
        </ul>
        <ul class="ecjia-list list-short payment-list">
            <!-- {foreach from=$payment_list item=list} -->
            <li>
                <span class="icon-name {$list.pay_code}" data-code="{$list.pay_code}">
                    <a class="fnUrlReplace" href='{url path="payment/pay/init" args="order_id={$data.order_id}&tips_show=1&pay_id={$list.pay_id}&pay_code={$list.pay_code}"}'>{$list.pay_name}</a>
                </span>
            </li>
            <!-- {/foreach} -->
        </ul>
    {/if}

    {if $pay_online}
    <div class="ecjia-margin-t ecjia-margin-t1 ecjia-margin-b">
        <a class="btn nopjax external" href="{$pay_online}">确认支付</a>
    </div>
    {/if}

    {if $detail.pay_code eq 'pay_balance' && $data.pay_status neq 'success'}
    <form class="ecjia-form ecjia-margin-t1" name="payForm" action="{url path='payment/pay/pay_order'}" method="post">
        <div class="ecjia-margin-t ecjia-margin-b">
            <input name="order_id" type="hidden" value="{$detail.order_id}" />
            <input name="pay_id" type="hidden" value="{$detail.pay_id}" />
            <input name="has_set_paypass" type="hidden" value="{if $user.has_paypassword eq 1}1{else}0{/if}" />
            <input class="btn confirm-payment payment-balance" type="button" value="{t}确认支付{/t}" />
            <input name="extension_code" type="hidden" value="{$detail.extension_code}" />
            <input type="hidden" class="set_paypass_url" data-url="{url path='user/profile/set_pay_password'}" />
        </div>
    </form>
    {/if}

    {if $pay_button}
    {$pay_button}
    {/if}

    {if $detail.pay_code eq 'pay_cod'}
    <ul class="ecjia-list">
        <li>下单成功，请货到后付款</li>
    </ul>
    {/if}

    {if $data.pay_status eq 'success' || $detail.pay_code eq 'pay_cod'}
    <div class="ecjia-margin-t ecjia-margin-b two-btn">
        <a class="btn nopjax external" href='{url path="touch/index/init"}'>去购物</a>
        <a class="btn" href='{if $detail.extension_code eq "group_buy"}{url path="user/order/groupbuy_detail" args="order_id={$data.order_id}"}{else}{url path="user/order/order_detail" args="order_id={$data.order_id}&type=detail"}{/if}'>查看订单</a>
    </div>
    {/if}

</div>

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
                <input name="order_id" type="hidden" value="{$detail.order_id}" />
                <input name="pay_id" type="hidden" value="{$detail.pay_id}" />
                <input name="url" type="hidden" value="{url path='payment/pay/pay_order'}" />
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
{/nocache}