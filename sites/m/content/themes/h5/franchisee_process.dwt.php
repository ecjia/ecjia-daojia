<?php
/*
Name: 查询进度页
Description: 
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {nocache} -->
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
            {t domain="h5"}亲~您的申请已提交成功！{/t}
        {elseif $check_status eq '1'}
            {t domain="h5"}您的申请正在审核！{/t}
        {elseif $check_status eq '2'}
            {t domain="h5"}您的申请审核已通过！{/t}
        {elseif $check_status eq '3'}
            {t domain="h5"}您的申请审核未通过！{/t}
        {/if}
        </p>
    </div>
    <div class="franchisee-progress">
        <p class="pro-b">{t domain="h5"}申请进度{/t}</p>
        <hr /><br />
        <div class="progress-img">
        {if $check_status eq '0'}
            <img src="{$theme_url}images/user_center/f_progress0.png"> 
            <p><span class="ecjiaf-fl left10">{t domain="h5"}审核已提交{/t}</span><span class="gfont">{t domain="h5"}审核中{/t}</span><span class="ecjiaf-fr right10 gfont">{t domain="h5"}审核完成{/t}</span></p>
        {elseif $check_status eq '1'}
            <img src="{$theme_url}images/user_center/f_progress1.png">
            <p><span class="ecjiaf-fl left10">{t domain="h5"}审核已提交{/t}</span><span>{t domain="h5"}审核中{/t}</span><span class="ecjiaf-fr right10 gfont">{t domain="h5"}审核完成{/t}</span></p>
        {elseif $check_status eq '2'}
            <img src="{$theme_url}images/user_center/f_progress2.png">
            <p><span class="ecjiaf-fl left10">{t domain="h5"}审核已提交{/t}</span><span>{t domain="h5"}审核中{/t}</span><span class="ecjiaf-fr right10">{t domain="h5"}审核完成{/t}</span></p>
        {elseif $check_status eq '3'}
            <img src="{$theme_url}images/user_center/f_progress2.png">
            <p><span class="ecjiaf-fl left10">{t domain="h5"}审核已提交{/t}</span><span>{t domain="h5"}审核中{/t}</span><span class="ecjiaf-fr right10">{t domain="h5"}审核完成{/t}</span></p>
        {/if}
            
        </div>
    </div>
    <div class="franchisee-prompt">
        {if $check_status eq '3'}
            <span class="fran-info-color">{t domain="h5"}审核状态：{/t}</span>
            <span class="check-stat">{t domain="h5"}很抱歉，审核未通过，您可以申请修改信息。{/t}</span>
            <br/>
            <span class="fran-info-color">{t domain="h5"}拒绝原因：{/t}</span>
            <span class="fran-info-color">{if $info.remark neq ''}{$info.remark}{else}{t domain="h5"}暂无{/t}{/if}</span>
            <div class="hand-objection">
               <a class="remove_apply btn nopjax external" href="{RC_Uri::url('franchisee/index/four')}&mobile={$mobile}&code={$code}" title='{t domain="h5"}申请修改信息{/t}'>{t domain="h5"}申请修改信息{/t}</a>
               <input class="btn" name="cancel" type="button" data-url="{$url}" value='{t domain="h5"}撤销申请{/t}' />
            </div>
        {else}
            <span class="warm-prompt">{t domain="h5"}温馨提示：{/t}</span>
            <span class="prompt-info">
                {if $check_status eq '0'}
				{t domain="h5"}您的申请已提交成功，我们将尽快为您处理，感谢您对我们的支持！{/t}
                {elseif $check_status eq '1'}
         	 	{t domain="h5"}您的申请已提交成功，我们将尽快为您处理，感谢您对我们的支持！{/t}
                {elseif $check_status eq '2'}
         		{t domain="h5"}您的申请已审核通过，现在您可以登录自己的商家平台管理店铺，赶快去登录吧！{/t}
                {/if}
            </span>
        {/if}
    </div>
    <div class="franchisee-info">
        <ul>
            <p>
                <span class="ecjiaf-fl fran-info-color">{t domain="h5"}真实姓名{/t}</span>
                <span class="ecjiaf-fr">{$info.responsible_person}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">{t domain="h5"}电子邮箱{/t}</span>
                <span class="ecjiaf-fr">{$info.email}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">{t domain="h5"}手机号码{/t}</span>
                <span class="ecjiaf-fr">{$info.mobile}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">{t domain="h5"}店铺名称{/t}</span>
                <span class="ecjiaf-fr">{$info.seller_name}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">{t domain="h5"}店铺分类{/t}</span>
                <span class="ecjiaf-fr">{$info.seller_category}</span>
            </p>
            <p>
                <span class="ecjiaf-fl fran-info-color">{t domain="h5"}详细地址{/t}</span>
                <span class="ecjiaf-fr address-span">{$info.address}</span>
            </p>
        </ul>
    </div>
</div>
<!-- {/block} -->
<!-- {/nocache} -->