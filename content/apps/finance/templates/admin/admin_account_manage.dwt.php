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
    <p><strong>温馨提示</strong><br /></p>
    <p>1、统计时间段内，商城余额、积分概况；</p>
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
                <span>按年份查询：</span>
                <div class="f_l m_r5">
                    <select class="w150" name="year">
                        <option value="0">请选择年份</option>
                        <!-- {foreach from=$year_list item=val} -->
                        <option value="{$val}" {if $val eq $year}selected{/if}>{$val} </option> <!-- {/foreach} -->
                    </select>
                </div>
                <span>按月份查询：</span>
                <div class="f_l m_r5">
                    <select class="no_search w120" name="month">
                        <option value="0">全年</option>
                        <!-- {foreach from=$month_list item=val} -->
                        <option value="{$val}" {if $val eq $month}selected{/if}>{$val} </option> <!-- {/foreach} -->
                    </select>
                </div>
                <button class="btn select-button" type="button">查询</button>
            </div>
        </form>
    </div>
</div>

<div class="row-fluid">
    <div class="stats-content">
        <div class="stats-item">
            <div class="item-left">余额统计</div>
            <div class="item-right">
                <div class="right-item">
                    <div class="item-top">会员消费（元）</div>
                    <div class="item-bottom">{$account.surplus}</div>
                </div>
                <div class="right-item">
                    <div class="item-top">会员充值（元）</div>
                    <div class="item-bottom">{$account.voucher_amount}</div>
                </div>
                <div class="right-item">
                    <div class="item-top">退款存入（元）</div>
                    <div class="item-bottom">{$account.return_money}</div>
                </div>
                <div class="right-item">
                    <div class="item-top">提现（元）</div>
                    <div class="item-bottom">{$account.to_cash_amount}</div>
                </div>
                <div class="right-item">
                    <div class="item-top">冻结（元）<span class="fontello-icon-help-circled" data-toggle="tooltip" title="用户申请提现后，暂时还没有被审核。"></span></div>
                    <div class="item-bottom">{$account.frozen_money}</div>
                </div>
                <div class="right-item">
                    <div class="item-top">剩余总余额（元）</div>
                    <div class="item-bottom">{$account.user_money}</div>
                </div>
            </div>
        </div>
        <div class="stats-item">
            <div class="item-left">积分统计</div>
            <div class="item-right">
                <div class="right-item">
                    <div class="item-top">下单发放</div>
                    <div class="item-bottom">{$account.pay_points}</div>
                </div>
                <div class="right-item">
                    <div class="item-top">积分抵现<span class="fontello-icon-help-circled" data-toggle="tooltip" title="用户下单使用积分抵消订单金额。"></span></div>
                    <div class="item-bottom">{$account.integral}</div>
                </div>
                <div class="right-item">
                    <div class="item-top">总发放积分<span class="fontello-icon-help-circled" data-toggle="tooltip" title="管理员向用户发放的总积分数，
 包括用户参与活动所获得的积分。"></span></div>
                    <div class="item-bottom">{$account.total_points}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="m_t20">
    <h3 class="heading">
        分布情况
    </h3>
</div>

<div class="row-fluid edit-page">
    <div class="span12">
        <div class="span6">
            <div class="left_stats">
                <div id="left_stats">
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="right_stats">
                <div id="right_stats">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="m_t20">
    <h3 class="heading">
        资金明细
    </h3>
</div>

<div class="row-fluid">
    <div class="span12">
        <div class="row-fluid">
            <table class="table table-striped table-hide-edit">
                <thead>
                    <tr>
                        <th class="w130">变动时间</th>
                        <th class="w110">会员名称</th>
                        <th>变动原因</th>
                        <th class="w110">余额变动</th>
                        <th class="w110">积分变动</th>
                        <th class="w110">关联订单</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- {foreach from=$log_list.item key=key item=val} -->
                    <tr>
                        <td>{$val.change_time}</td>
                        <td>{$val.user_name}</td>
                        <td>{$val.change_desc}</td>
                        <td>
                            <!-- {if $val.user_money gt 0} -->
                            <span class="ecjiafc-0000FF">+{$val.user_money}</span>
                            <!-- {elseif $val.user_money lt 0} -->
                            <span class="ecjiafc-red">{$val.user_money}</span>
                            <!-- {else} -->
                            {$val.user_money}
                            <!-- {/if} -->
                        </td>
                        <td>
                            <!-- {if $val.rank_points gt 0} -->
                            <span class="ecjiafc-0000FF">+{$val.rank_points}</span>
                            <!-- {elseif $val.rank_points lt 0} -->
                            <span class="ecjiafc-red">{$val.rank_points}</span>
                            <!-- {else} -->
                            {$val.rank_points}
                            <!-- {/if} -->
                        </td>
                        <td><a href="{RC_Uri::url('orders/admin/info')}&order_sn={$val.from_value}" target="__blank">{$val.from_value}</td>
                    </tr>
                    <!-- {foreachelse}-->
                    <tr>
                        <td class="no-records" colspan="6">{lang key='system::system.no_records'}</td>
                    </tr>
                    <!-- {/foreach} -->
                </tbody>
            </table>
            <!-- {$log_list.page} -->
        </div>
    </div>
</div>

<!-- {/block} -->