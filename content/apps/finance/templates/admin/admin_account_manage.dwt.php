<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    var data = '{$data}';
    var right_data = '{$right_data}';
    ecjia.admin.account_manage.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div class="alert alert-info">
    <a class="close" data-dismiss="alert">×</a>
    <p><strong>{t domain="finance"}温馨提示：{/t}</strong><br /></p>
    <p>{if $type eq 'points'}{t domain="finance"}1、统计时间段内，商城积分概况；{/t}{else}{t domain="finance"}1、统计时间段内，商城余额概况；{/t}{/if}</p>
</div>

<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $action_link} -->
        <a class="btn plus_or_reply" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
        <!-- {/if} -->
    </h3>
</div>

<div class="row-fluid">
    <div class="choose_list f_l">
        <form action="{$form_action}" method="post" name="searchForm">
            <div class="screen f_r">
                <span>{t domain="finance"}按年份查询：{/t}</span>
                <div class="f_l m_r5">
                    <select class="w150" name="year">
                        <option value="0">{t domain="finance"}请选择年份{/t}</option>
                        <!-- {foreach from=$year_list item=val} -->
                        <option value="{$val}" {if $val eq $year}selected{/if}>{$val} </option> <!-- {/foreach} -->
                    </select>
                </div>
                <span>{t domain="finance"}按月份查询：{/t}</span>
                <div class="f_l m_r5">
                    <select class="no_search w120" name="month">
                        <option value="0">{t domain="finance"}全年{/t}</option>
                        <!-- {foreach from=$month_list item=val} -->
                        <option value="{$val}" {if $val eq $month}selected{/if}>{$val} </option> <!-- {/foreach} -->
                    </select>
                </div>
                <button class="btn select-button" type="button">{t domain="finance"}查询{/t}</button>
            </div>
        </form>
    </div>
</div>

<div class="row-fluid">
    <div class="stats-content">
        {if $type eq 'points'}
        <div class="stats-item">
            <div class="item-left">{t domain="finance"}积分统计{/t}</div>
            <div class="item-right">
                <div class="right-item">
                    <div class="item-top">{t domain="finance"}下单发放{/t}</div>
                    <div class="item-bottom">{$account.pay_points}</div>
                </div>
                <div class="right-item">
                    <div class="item-top">{t domain="finance"}积分抵现{/t}<span class="fontello-icon-help-circled" data-toggle="tooltip" title="{t domain="finance"}用户下单使用积分抵消订单金额。{/t}"></span></div>
                    <div class="item-bottom">{$account.integral}</div>
                </div>
                <div class="right-item">
                    <div class="item-top">{t domain="finance"}总发放积分{/t}<span class="fontello-icon-help-circled" data-toggle="tooltip" title="{t domain="finance"}管理员向用户发放的总积分数， 包括用户参与活动所获得的积分。{/t}"></span></div>
                    <div class="item-bottom">{$account.total_points}</div>
                </div>
            </div>
        </div>
        {else}
        <div class="stats-item">
            <div class="item-left">{t domain="finance"}余额统计{/t}</div>
            <div class="item-right">
                <div class="right-item">
                    <div class="item-top">{t domain="finance"}会员消费（元）{/t}</div>
                    <div class="item-bottom">{$account.surplus}</div>
                </div>
                <div class="right-item">
                    <div class="item-top">{t domain="finance"}会员充值（元）{/t}</div>
                    <div class="item-bottom">{$account.voucher_amount}</div>
                </div>
                <div class="right-item">
                    <div class="item-top">{t domain="finance"}退款存入（元）{/t}</div>
                    <div class="item-bottom">{$account.return_money}</div>
                </div>
                <div class="right-item">
                    <div class="item-top">{t domain="finance"}提现（元）{/t}</div>
                    <div class="item-bottom">{$account.to_cash_amount}</div>
                </div>
                <div class="right-item">
                    <div class="item-top">{t domain="finance"}冻结（元）{/t}<span class="fontello-icon-help-circled" data-toggle="tooltip" title="{t domain="finance"}用户申请提现后，暂时还没有被审核。{/t}"></span></div>
                    <div class="item-bottom">{$account.frozen_money}</div>
                </div>
                <div class="right-item">
                    <div class="item-top">{t domain="finance"}剩余总余额（元）{/t}</div>
                    <div class="item-bottom">{$account.user_money}</div>
                </div>
            </div>
        </div>
        {/if}
    </div>
</div>

<div class="m_t20">
    <h3 class="heading">
        {t domain="finance"}分布情况{/t}
    </h3>
</div>

<div class="row-fluid edit-page">
    <div class="span12">
        {if $type eq 'points'}
        <div class="right_stats">
            <div id="right_stats">
            </div>
        </div>
        {else}
        <div class="left_stats">
            <div id="left_stats">
            </div>
        </div>
        {/if}
    </div>
</div>

<!-- {if $type eq 'points'} -->
<!-- {include file='library/finance_admin_account_point_sheet.lbi.php'} -->
<!-- {else} -->
<!-- {include file='library/finance_admin_account_money_sheet.lbi.php'} -->
<!-- {/if} -->

<!-- {/block} -->