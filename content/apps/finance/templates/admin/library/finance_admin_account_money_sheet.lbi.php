<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="m_t20">
    <h3 class="heading">
        {t domain="finance"}余额变动明细{/t}
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
                    <th class="w110">{t domain="finance"}余额变动{/t}</th>
                    <th class="w110">{t domain="finance"}冻结余额{/t}</th>
                    <th class="w110">{t domain="finance"}关联订单{/t}</th>
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
                        <!-- {if $val.frozen_money gt 0} -->
                        <span class="ecjiafc-0000FF">+{$val.frozen_money}</span>
                        <!-- {elseif $val.frozen_money lt 0} -->
                        <span class="ecjiafc-red">{$val.frozen_money}</span>
                        <!-- {else} -->
                        {$val.frozen_money}
                        <!-- {/if} -->
                    </td>
                    <td><a href="{RC_Uri::url('orders/admin/info')}&order_sn={$val.from_value}" target="_blank">{$val.from_value}</td>
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