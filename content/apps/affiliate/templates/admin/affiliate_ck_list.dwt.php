<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.affiliate.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<!-- 分成订单-->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <a class="btn plus_or_reply" id="sticky_a" href="{url path="#admin_separate/download"}{if $filter.status}&status={$filter.status}{/if}{if $filter.order_sn}&order_sn={$filter.order_sn}{/if}"><i class="fontello-icon-download"></i>导出结果</a>
    </h3>
</div>

<ul class="nav nav-pills">
    <li class="{if $filter.status eq 0}active{/if}">
        <a class="data-pjax" href="{RC_Uri::url('#admin_separate/init')}&status=0{if $filter.order_sn}&order_sn={$filter.order_sn}{/if}">{t domain="affiliate"}未分成{/t}
            <span class="badge badge-info">{if $type_count.await_pay}{$type_count.await_pay}{else}0{/if}</span>
        </a>
    </li>
    <li class="{if $filter.status eq 1}active{/if}">
        <a class="data-pjax" href="{RC_Uri::url('#admin_separate/init')}&status=1{if $filter.order_sn}&order_sn={$filter.order_sn}{/if}" >{t domain="affiliate"}已分成{/t}
            <span class="badge badge-info">{if $type_count.payed}{$type_count.payed}{else}0{/if}</span>
        </a>
    </li>
    <li class="{if $filter.status eq 2}active{/if}">
        <a class="data-pjax" href="{RC_Uri::url('#admin_separate/init')}&status=2{if $filter.order_sn}&order_sn={$filter.order_sn}{/if}" >{t domain="affiliate"}取消分成{/t}
            <span class="badge badge-info">{if $type_count.canceled}{$type_count.canceled}{else}0{/if}</span>
        </a>
    </li>
</ul>


<div class="row-fluid">
    <form method="post" action="{$search_action}&status={$filter.status}" name="search_from">
        {if $filter.status eq 0}
        <div class="btn-group f_l m_r5">
            <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fontello-icon-cog"></i>{t domain="article"}批量操作{/t}
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="button_hide" data-toggle="ecjiabatch" data-idClass=".checkbox:checked"
                       data-url='{url path="#admin_separate/batch" args="{if $smarty.get.page}&page={$smarty.get.page}{/if}"}' data-msg='{t domain="article"}您确定要这么做吗？{/t}' data-noSelectMsg='{t domain="article"}请选择要操作的记录{/t}' data-name="id" href="javascript:;">
                        <i class="fontello-icon-ok-circled"></i>{t domain="article"}分成{/t}</a></li>
            </ul>
        </div>
        {/if}
        <div class="top_right f_r" >
            <input type="text" name="order_sn" value="{$filter.order_sn}" placeholder='{t domain="affiliate"}请输入订单号{/t}'>
            <input type="button" value='{t domain="affiliate"}搜索{/t}' class="btn search_order">
        </div>
    </form>
</div>

<div class="row-fluid">
    <div class="span12">
        <table class="table table-hide-edit table-striped" id="list-table">
            <thead>
            <tr>
                {if $filter.status eq 0}
                <th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
                {/if}
                <th class="w120">{t domain="affiliate"}订单编号{/t}</th>
                <th class="w100">{t domain="affiliate"}商家名称{/t}</th>
                <th class="w100">{t domain="affiliate"}购买人{/t}</th>
                <th class="w100">{t domain="affiliate"}订单金额{/t}</th>
                <th class="w80">{t domain="affiliate"}佣金{/t}</th>
                <th class="w100">{t domain="affiliate"}付款时间{/t}</th>
                <!--<th class="w110">{t domain="affiliate"}分成类型{/t}</th>-->
                <th class="w100">{t domain="affiliate"}操作状态{/t}</th>
                <th>{t domain="affiliate"}操作信息{/t}</th>
            </tr>
            </thead>
            <tbody>
            <!-- {foreach from=$logdb.item item=log} -->
            <tr align="center">
                {if $filter.status eq 0}
                <td>
                    <span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$log.log_id}"/></span>
                </td>
                {/if}
                <td class="hide-edit-area"><a href='{url path="orders/admin/info" args="order_sn={$log.order_sn}"}' target="_blank">{$log.order_sn}</a>
                    <div class="edit-list">
                        <!-- {if $log.separate_type eq 0 && $on eq 1} -->
                        <a class="toggle_view" href='{url path="affiliate/admin_separate/separate" args="id={$log.log_id}"}'  data-msg='{t domain="affiliate"}您确定要分成吗？{/t}' data-pjax-url='{url path="affiliate/admin_separate/init" args="page={$logdb.current_page}{if $filter.status}&status={$filter.status}{/if}"}' data-val="separate">{t domain="affiliate"}分成{/t}</a>&nbsp;|&nbsp;
                        <a class="toggle_view ecjiafc-red" href='{url path="affiliate/admin_separate/cancel" args="id={$log.log_id}&order_id={$log.order_id}"}'  data-msg='{t domain="affiliate"}您确定要取消分成吗？此操作不能撤销。{/t}' data-pjax-url='{url path="affiliate/admin_separate/init" args="page={$logdb.current_page}{if $filter.status}&status={$filter.status}{/if}"}' data-val="cancel">{t domain="affiliate"}取消{/t}</a>
                        <!-- {elseif $log.separate_type eq 1} -->
                        <a class="toggle_view ecjiafc-red" href='{url path="affiliate/admin_separate/rollback" args="id={$log.log_id}"}'  data-msg='{t domain="affiliate"}您确定要撤销此次分成吗？{/t}' data-pjax-url='{url path="affiliate/admin_separate/init" args="page={$logdb.current_page}{if $filter.status}&status={$filter.status}{/if}"}' data-val="rollback">{t domain="affiliate"}撤销{/t}</a>
                        <!-- {else} -->
                        -
                        <!-- {/if} -->
                    </div>
                </td>
                <td>{$log.merchants_name}{if $log.manage_mode eq 'self'}<span class="ecjiafc-red">（自营）</span>{/if}</td>
                <td>{$log.consignee}</td>
                <td>{$log.total_fee_formatted}</td>
                <td>{$log.money_formatted}</td>
                <td>{$log.pay_time_formatted}</td>
                <td>{$log.separate_type_label}</td>
                <td>{$log.info}</td>
                <!--<td>{$order_stats[$log.order_status]}</td>
                  <td>{$separate_by[$log.separate_type]}</td>-->
            </tr>
            <!-- {foreachelse} -->
            <tr><td class="dataTables_empty" colspan="9">{t domain="affiliate"}没有找到任何记录{/t}</td></tr>
            <!-- {/foreach} -->
            </tbody>
        </table>
        <!-- {$logdb.page} -->
    </div>
</div>
<!-- {/block} -->