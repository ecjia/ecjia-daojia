<?php
/*
Name: 更改支付方式页面
Description: 
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript" >
    ecjia.touch.flow.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<form class="ecjia-form" name="payForm" action="{url path='payment/pay/pay_order'}" method="post">
    <div class="ecjia-flow-done ecjia-pay">
        <p class="ecjia-payment-notice">{t domain="h5"}当前订单不支持原有支付方式，请切换新的支付方式继续支付。{/t}</p>

        <ul class="ecjia-list ecjia-margin-t">
            <li>{t domain="h5"}订单金额：{/t}<span class="ecjiaf-fr">{$detail.formated_total_fee}</span></li>
            <li>{t domain="h5"}支付方式：{/t}<span class="ecjiaf-fr flow-msg">{$detail.pay_name}</span></li>
        </ul>
        
        {if $payment_list}
            <ul class="ecjia-list ecjia-margin-t">
                <li>
                    {t domain="h5"}其它支付方式{/t} <span class="ecjiaf-fr"></span>
                </li>
            </ul>

            <ul class="ecjia-list list-short payment-list">
            <!-- {foreach from=$payment_list item=list} -->
                <li>
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

        <div class="ecjia-margin-t ecjia-margin-b">
            <input name="order_id" type="hidden" value="{$detail.order_id}" />
            <input name="has_set_paypass" type="hidden" value="{if $user.has_paypassword eq 1}1{else}0{/if}" />
            <input class="btn btn-recharge confirm-payment" name="submit" type="submit" value='{t domain="h5"}确认支付{/t}' />
        </div>
        <div class="wei-xin-pay hide"></div>
    </div>
</form>

<div class="mod_address_slide" id="enterPassArea">
    <div class="mod_address_slide_main">
        <div class="mod_address_slide_head">
            {t domain="h5"}请输入支付密码{/t}<i class="iconfont icon-close"></i>
        </div>
        <div class="mod_address_slide_body h350">
            <div class="ecjia-form">
                <p class="ecjiaf-tac ecjia-margin-b ecjia-margin-t ecjia-color-85878c">{t domain="h5"}为了保证您的账户安全，请输入您的支付密码{/t}</p>
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
                <input name="pay_balance_id" type="hidden" value="{$pay_balance_id}" />
                <input name="url" type="hidden" value="{url path='payment/pay/pay_order'}" />
                <a class="ecjiaf-fr blue forget_paypass" href="{RC_Uri::url('user/profile/set_pay_password')}" style="padding-right:2em;color:#337ab7;">{t domain="h5"}忘记支付密码{/t}</a>
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