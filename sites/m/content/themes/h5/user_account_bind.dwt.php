<?php
/*
Name: 绑定手机号码
Description: 绑定手机号码
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {nocache} -->
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-user ecjia-form ecjia-user-no-border-b" name="accountBind" action="{$form_url}" method="post">
    {if $type eq 'mobile'}
    <div class="d_bind">
        <p class="p_bind">{if $status}{t domain='h5'}请设置新手机号{/t}{else}{t domain='h5'}绑定手机号后，你可以使用手机号登录，也可以通过手机号找回密码{/t}{/if}</p>
        <div class="ecjia-list list-short bind">
            <li>
        		<div class="form-group d_input">
            		<label>
            			<input type='number' placeholder="{t domain='h5'}请输入手机号{/t}" name='mobile'>
            		</label>
            	</div>
           </li>
           <li>
        		<div class="form-group d_input_verification_code">
            		<label>
            			<input type='number' placeholder="{t domain='h5'}请输入验证码{/t}" name="code">
            		</label>
            	</div>
            	<div class="form-group get_code">
            	   <label class="input_verification_code">
            			<input type="button" value="{t domain='h5'}获取验证码{/t}"  id='get_code' data-url="{url path='user/profile/get_code'}" name="mobile">
            		</label>
            	</div>
           </li>
        </div>
        <div class=" ecjia-margin-b">
        	<input class="btn btn-info" name="submit" type="submit" value="{t domain='h5'}立即绑定{/t}" id="account_bind_btn"/>
        	<input type="hidden" name="type" value="mobile" />
        </div>
    </div>
    {elseif $type eq 'email'}
    <div class="d_bind">
        <p class="p_bind">{if $status}{t domain='h5'}请设置新邮箱帐号{/t}{else}{t domain='h5'}请输入你的邮箱帐号{/t}{/if}</p>
        <div class="ecjia-list list-short bind">
            <li>
        		<div class="form-group d_input">
            		<label>
            			<input placeholder="{t domain='h5'}请输入邮箱帐号{/t}" name="email">
            		</label>
            	</div>
           </li>
           <li>
        		<div class="form-group d_input_verification_code">
            		<label>
            			<input type='number' placeholder="{t domain='h5'}请输入验证码{/t}" name="code">
            		</label>
            	</div>
            	<div class="form-group get_code">
            	   <label class="input_verification_code">
            			<input type="button" value="{t domain='h5'}获取验证码{/t}"  id='get_code' data-url="{url path='user/profile/get_code'}" name="email">
            		</label>
            	</div>
           </li>
        </div>
        <div class=" ecjia-margin-b">
        	<input class="btn btn-info" name="submit" type="submit" value="{t domain='h5'}立即绑定{/t}" id="account_bind_btn"/>
        	<input type="hidden" name="type" value="email" />
        </div>
    </div>
    {elseif $type eq 'wechat'}
    <div class="d_bind">
        <div class="ecjia-input">
            <a class="fnUrlReplace" href='{url path="user/profile/choose_wechat"}'>
            <div class="input-li b_b b_t">
                <span class="input-fl">{t domain='h5'}微信钱包{/t}</span>
                <div class="choose-div">
                    <span class="choose-name">
                        {if $user.wechat_is_bind eq 1}{$user.wechat_nickname}{else}{t domain='h5'}未绑定{/t}{/if}
                    </span>
                    <i class="iconfont icon-jiantou-right"></i>
                </div>
            </div>
            </a>

            <div class="input-li">
                <span class="input-fl">{t domain='h5'}真实姓名{/t}</span>
                <input type="text" name="real_name" placeholder="{t domain='h5'}请输入微信认证的真实姓名{/t}" value="{$bind_info.cardholder}"/>
            </div>
        </div>

        <div class="ecjia-input">
            <div class="input-li b_b b_t">
                {if $user.mobile_phone}
                <span class="input-fl">{t domain='h5'}手机号码{/t}</span>
                <span class="mobile_phone">{$user.mobile_phone}</span>
                <input class="get_code" type="button" id="get_code" value="{t domain='h5'}获取验证码{/t}" data-url="{url path='user/profile/get_code'}&type=wechat" />
                <input type="hidden" name="mobile" value="{$user.mobile_phone}" />
                {else}
                <span class="input-fl">{t domain='h5'}手机号码{/t}</span>
                <span class="mobile_phone">{t domain='h5'}请先去绑定手机号{/t}</span>
                <div class="bind_notice"><a class="external nopjax" href="{RC_Uri::url('user/profile/account_bind')}&type=mobile">{t domain='h5'}去绑定{/t}</a></div>
                {/if}
            </div>

            <div class="input-li">
                <span class="input-fl">{t domain='h5'}验证码{/t}</span>
                <input class="text_left" type="text" name="smscode" placeholder="{t domain='h5'}请输入手机验证码{/t}" value=""/>
            </div>

            <div class="ecjia-list list-notice">
                <li class="notice-label">{t domain='h5'}温馨提示：{/t}</li>
                <li><div class="notice"><b class="disc">·</b>{t domain='h5'}绑定后，可使用微信进行余额提现；{/t}</div></li>
                <li><div class="notice"><b class="disc">·</b>{t domain='h5'}在提现时，微信账号必须先关注公众号后，提现才有效，若未关注公众号就操作提现，由此造成的损失需由您自行承担；{/t}</div></li>
                <li><div class="notice"><b class="disc">·</b>{t domain='h5'}微信打款平台需验证微信真实姓名，请务必填写微信实名认证时的真实姓名，确保真实有效，若填写的姓名与微信实名认证时不一致，导致提现不了或其他情况，由此造成的损失需由您自行承担。{/t}</div></li>
                <li><div class="notice"><b class="disc">·</b>{t domain='h5'}若有疑问，请拨打客服热线；{/t}</div></li>
            </div>
        </div>

        <div class="ecjia-button-top-list">
            <input type="hidden" name="connect_code" value="{$connect_code}">
            <input class="btn btn-info" name="submit" type="submit" value="{t domain='h5'}保存{/t}">
        </div>

        {if $bind_info}
        <div class="ecjia-button-top-list t_c">
            <a href="javascript:;" class="nopjax external delete_withdraw" data-msg="{t domain='h5'}确定删除微信钱包提现方式？{/t}" data-url="{RC_Uri::url('user/profile/unbind_check_mobile')}&id={$bind_info.id}&type=wechat">{t domain='h5'}删除此提现方式{/t}</a>
        </div>
        {/if}

    </div>
    {elseif $type eq 'bank'}
    <div class="d_bind">
        <div class="ecjia-input">
            <div class="input-li b_b b_t">
                <span class="input-fl">{t domain='h5'}持卡人{/t}</span>
                <input type="text" name="card_name" placeholder="{t domain='h5'}请输入持卡人姓名{/t}" value="{$bind_info.cardholder}"/>
            </div>
            <div class="input-li b_b">
                <span class="input-fl">{t domain='h5'}所属银行{/t}</span>
                <div class="choose-div">
                    <span class="choose-name choose_bank">
                        {if $bind_info.bank_name}
                        <img src="{$bind_info.bank_icon}" width="25" height="25" style="margin-right:5px;">{$bind_info.bank_name}
                        {else}
                        {t domain='h5'}请选择{/t}
                        {/if}
                    </span>
                    <i class="iconfont icon-jiantou-right"></i>
                </div>
                <input type="hidden" name="bank_en_short" value="{$bind_info.bank_en_short}"/>
            </div>
            <div class="input-li b_b">
                <span class="input-fl">{t domain='h5'}开户行{/t}</span>
                <input type="text" name="bank_name" placeholder="{t domain='h5'}请输入开户行{/t}" value="{$bind_info.bank_branch_name}"/>
            </div>
            <div class="input-li b_b_n">
                <span class="input-fl">{t domain='h5'}银行卡号{/t}</span>
                <input type="text" name="bank_number" placeholder="{t domain='h5'}请输入银行卡号{/t}" value="{$bind_info.bank_card}"/>
            </div>
        </div>

        <div class="ecjia-input">
            <div class="input-li b_b b_t">
                {if $user.mobile_phone}
                <span class="input-fl">{t domain='h5'}手机号码{/t}</span>
                <span class="mobile_phone">{$user.mobile_phone}</span>
                <input class="get_code" type="button" id="get_code" value="{t domain='h5'}获取验证码{/t}" data-url="{url path='user/profile/get_code'}&type=bank" />
                <input type="hidden" name="mobile" value="{$user.mobile_phone}" />
                {else}
                <span class="input-fl">{t domain='h5'}手机号码{/t}</span>
                <span class="mobile_phone">{t domain='h5'}请先去绑定手机号{/t}</span>
                <div class="bind_notice"><a class="external nopjax" href="{RC_Uri::url('user/profile/account_bind')}&type=mobile">{t domain='h5'}去绑定{/t}</a></div>
                {/if}
            </div>

            <div class="input-li">
                <span class="input-fl">{t domain='h5'}验证码{/t}</span>
                <input class="text_left" type="text" name="smscode" placeholder="{t domain='h5'}请输入手机验证码{/t}" value=""/>
            </div>

            <div class="ecjia-list list-notice">
                <li class="notice-label">{t domain='h5'}温馨提示：{/t}</li>
                <li><div class="notice"><b class="disc">·</b>{t domain='h5'}绑定后，只能使用该卡进行余额提现；{/t}</div></li>
                <li><div class="notice"><b class="disc">·</b>{t domain='h5'}请确保您填写的信息真实有效，若填写的信息有误，导致提现至错误账号，由此造成的损失需由您自行承担。{/t}</div></li>
                <li><div class="notice"><b class="disc">·</b>{t domain='h5'}若有疑问，请拨打客服热线；{/t}</div></li>
            </div>
        </div>

        <div class="ecjia-button-top-list">
            <input class="btn btn-info" name="submit" type="submit" value="{t domain='h5'}保存{/t}">
        </div>

        {if $bind_info}
        <div class="ecjia-button-top-list t_c">
            <a href="javascript:;" class="nopjax external delete_withdraw" data-msg="{t domain='h5'}确定删除银行卡提现方式？{/t}" data-url="{RC_Uri::url('user/profile/unbind_check_mobile')}&id={$bind_info.id}&type=bank">{t domain='h5'}删除此提现方式{/t}</a>
        </div>
        {/if}
    </div>
    {/if}
    <input type="hidden" name="type" value="{$type}">
</form>
<input type="hidden" name="bank_list" value='{$bank_list}'>
<!-- {/block} -->
<!-- {/nocache} -->
