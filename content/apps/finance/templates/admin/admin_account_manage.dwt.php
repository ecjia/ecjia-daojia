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

<div class="m_t20">
    <h3 class="heading">
        {if $type eq 'points'}{t domain="finance"}积分变动明细{/t}{else}{t domain="finance"}余额变动明细{/t}{/if}
    </h3>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <table class="table table-striped table-hide-edit">
                <thead>
                    <tr>
                        <th class="w130">{t domain="finance"}变动时间{/t}</th>
                        <th class="w110">{t domain="finance"}会员名称{/t}</th>
                        <th>{t domain="finance"}变动原因{/t}</th>
                        {if $type eq 'points'}
                        <th class="w110">{t domain="finance"}积分变动{/t}</th>
                        {else}
                        <th class="w110">{t domain="finance"}余额变动{/t}</th>
                        {/if}
                        <th class="w110">{t domain="finance"}关联订单{/t}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from=$log_list.item key=key item=val} -->
                    <tr>
                        <td>{$val.change_time}</td>
                        <td>{$val.user_name}</td>
                        <td>{$val.change_desc}</td>
                        {if $type eq 'points'}
                        <td>
                            <!-- {if $val.rank_points gt 0} -->
                            <span class="ecjiafc-0000FF">+{$val.rank_points}</span>
                            <!-- {elseif $val.rank_points lt 0} -->
                            <span class="ecjiafc-red">{$val.rank_points}</span>
                            <!-- {else} -->
                            {$val.rank_points}
                            <!-- {/if} -->
                        </td>
                        {else}
                        <td>
                            <!-- {if $val.user_money gt 0} -->
                            <span class="ecjiafc-0000FF">+{$val.user_money}</span>
                            <!-- {elseif $val.user_money lt 0} -->
                            <span class="ecjiafc-red">{$val.user_money}</span>
                            <!-- {else} -->
                            {$val.user_money}
                            <!-- {/if} -->
                        </td>
                        {/if}
                        <td><a href="{RC_Uri::url('orders/admin/info')}&order_sn={$val.from_value}" target="__blank">{$val.from_value}</td>
                    </tr>
                    <!-- {foreachelse}-->
                    <tr>
                        <td class="no-records" colspan="5">{t domain="finance"}没有找到任何记录{/t}</td>
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
            <!-- {$log_list.page} -->
        </div>
    </div>
</div>

<!-- {/block} -->