<!-- {nocache} -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>积分查看</title>
    <link rel="stylesheet" type="text/css" href="{$css1_url}">
    <link rel="stylesheet" type="text/css" href="{$css2_url}">
    <link rel="stylesheet" type="text/css" href="{$css3_url}">

</head>
<body>

<div class="details-wrapper">
    <div class="details-info">
        <div class="info-cnt">
            <div class="info-cnt-inner">
                <div class="info-number">
                    <span class="info-txt">当前</span><span class="info-num">{$pay_points}</span><span class="info-txt">积分</span>
                </div>
                <div class="info-btn">
                    <i class="btn-icon"></i>
                    <span class="btn-text">
                        {if $today eq $lastCheckinDay}
                            今日已签到
                        {else}
                            今日未签到
                        {/if}
                    </span>
                </div>
                <div class="info-tips">
                    {if $count eq 0}
                        您还未签到过哦，请在微信回复签到即可签到！
                    {else}
                    已累计签到{$count}次，继续加油哦！
                    {/if}
                </div>
            </div>
        </div>
        <!--        <a href="javascript:void(0)" class="info-help">帮助说明</a>-->
    </div>
    <div class="details-notice">
    </div>
    <div class="details-list">
        <div class="list-head" id="listHead"><div class="list-head-inner">积分收支明细</div></div>
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

<script type="text/javascript" src="{$jq_url}"></script>


</body>
</html>
<!-- {/nocache} -->