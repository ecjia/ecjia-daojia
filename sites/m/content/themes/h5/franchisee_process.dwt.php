<?php
/*
Name: 查询进度页
Description: 
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.franchisee.cancel_apply();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-address-list">
    <div class="franchisee-process-hint"> 
        {if $check_status eq '3'}
            <img src="{$theme_url}images/user_center/f_failed.png" width="100" height="100">
        {else}
            <img src="{$theme_url}images/user_center/f_process.png" width="100" height="100">
        {/if}
        <p>
        {if $check_status eq '0'}
                                    亲~您的申请已提交成功！
        {elseif $check_status eq '1'}
                                    您的申请正在审核！
        {elseif $check_status eq '2'}
                                    您的申请审核已通过！
        {elseif $check_status eq '3'}
                                     您的申请审核未通过！
        {/if}
        </p>
    </div>
    <div class="franchisee-progress">
        <p class="pro-b">申请进度</p>
        <hr /><br />
        <div class="progress-img">
        {if $check_status eq '0'}
            <img src="{$theme_url}images/user_center/f_progress0.png"> 
            <p><span class="ecjiaf-fl left10">审核已提交</span><span class="gfont">审核中</span><span class="ecjiaf-fr right10 gfont">审核完成</span></p>
        {elseif $check_status eq '1'}
            <img src="{$theme_url}images/user_center/f_progress1.png">
            <p><span class="ecjiaf-fl left10">审核已提交</span><span>审核中</span><span class="ecjiaf-fr right10 gfont">审核完成</span></p>
        {elseif $check_status eq '2'}
            <img src="{$theme_url}images/user_center/f_progress2.png">
            <p><span class="ecjiaf-fl left10">审核已提交</span><span>审核中</span><span class="ecjiaf-fr right10">审核完成</span></p>
        {elseif $check_status eq '3'}
            <img src="{$theme_url}images/user_center/f_progress2.png">
            <p><span class="ecjiaf-fl left10">审核已提交</span><span>审核中</span><span class="ecjiaf-fr right10">审核完成</span></p>
        {/if}
            
        </div>
    </div>
    <div class="franchisee-prompt">
        {if $check_status eq '3'}
            <span class="fran-info-color">审核状态：</span>
            <span class="check-stat">很抱歉，审核未通过，您可以申请修改信息。</span>
            <br/>
            <span class="fran-info-color">拒绝原因：</span>
            <span class="fran-info-color">{$info.remark}</span>
            <div class="hand-objection">
               <a class="remove_apply btn" href="{RC_Uri::url('franchisee/index/second')}&mobile={$mobile}&code={$code}" title="申请修改信息">申请修改信息</a>
               <input class="btn" name="cancel" type="button" data-url="{$url}" value="撤销申请" />
            </div>
        {else}
            <span class="warm-prompt">温馨提示：</span>
            <span class="prompt-info">
                {if $check_status eq '0'}
				您的申请已提交成功，我们将尽快为您处理，感谢您对我们的支持！
                {elseif $check_status eq '1'}
         	 	您的申请已提交成功，我们将尽快为您处理，感谢您对我们的支持！
                {elseif $check_status eq '2'}
         		您的申请已审核通过，现在您可以登录自己的商家平台管理店铺，赶快去登录吧！
                {/if}
            </span>
        {/if}
    </div>
    <div class="franchisee-info">
        <ul>
            <p>
                <span class="ecjiaf-fl fran-info-color">真实姓名</span>
                <span class="ecjiaf-fr">{$info.responsible_person}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">电子邮箱</span>
                <span class="ecjiaf-fr">{$info.email}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">手机号码</span>
                <span class="ecjiaf-fr">{$info.mobile}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">店铺名称</span>
                <span class="ecjiaf-fr">{$info.seller_name}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">店铺分类</span>
                <span class="ecjiaf-fr">{$info.seller_category}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">详细地址</span>
                <span class="ecjiaf-fr address-span">{$info.address}</span>
            </p>
        </ul>
    </div>
</div>
<!-- {/block} -->
{/nocache}