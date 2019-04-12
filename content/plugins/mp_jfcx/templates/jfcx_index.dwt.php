<!-- {nocache} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{$title}</title>
    <link rel="stylesheet" type="text/css" href="{$animate_css}">
    <link rel="stylesheet" type="text/css" href="{$jquery_toast_min_css}">
    <link rel="stylesheet" type="text/css" href="{$details_min_css}">

</head>
<body>

<div class="details-wrapper">
    <div class="details-info">
        <div class="info-cnt">
            <div class="info-cnt-inner">
                <div class="info-number">
                    <span class="info-txt">{t domain="mp_jfcx"}当前{/t}</span><span class="info-num">{$pay_points}</span><span class="info-txt">{t domain="mp_jfcx"}积分{/t}</span>
                </div>
                <div class="info-btn">
                    <i class="btn-icon"></i>
                    <span class="btn-text">
                        {if $today eq $lastCheckinDay}
                            {t domain="mp_jfcx"}今日已签到{/t}
                        {else}
                            {t domain="mp_jfcx"}今日未签到{/t}
                        {/if}
                    </span>
                </div>
                <div class="info-tips">
                    {if $count eq 0}
                    {t domain="mp_jfcx"}您还未签到过哦，请在微信回复签到即可签到！{/t}
                    {else}
                    {t domain="mp_jfcx" 1={$count}}已累计签到%1次，继续加油哦！{/t}
                    {/if}
                </div>
            </div>
        </div>
        <!--        <a href="javascript:void(0)" class="info-help">帮助说明</a>-->
    </div>
    <div class="details-notice">
    </div>
    <div class="details-list">
        <div class="list-head" id="listHead"><div class="list-head-inner">{t domain="mp_jfcx"}积分收支明细{/t}</div></div>
        <div class="place-holder"></div>
        <div class="list-box" id="listBox">

            {foreach $new_points_info as $key => $value}

            {if $value.pay_points eq 0}
                {continue}
            {else}
            <div class="list-item">
                <div class="cell list-item-left">
                    <div class="list-item-text">{$value.change_desc}</div>
                    <div class="list-item-time">{$value.change_time}</div>
                </div>
                {if $value.pay_points gt 0}
                <div class="list-item-right add">
                    +{$value.pay_points}
                </div>
                {/if}
                {if $value.pay_points lt 0}
                <div class="list-item-right">
                    {$value.pay_points}
                </div>
                {/if}
            </div>

            {/if}

            {/foreach}

        </div>
    </div>
</div>

<script type="text/javascript" src="{$jquery_js}"></script>


</body>
</html>
<!-- {/nocache} -->