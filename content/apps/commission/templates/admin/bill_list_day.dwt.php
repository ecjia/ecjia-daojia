<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.bill_list.searchFormDay();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        <!-- {if $smarty.get.store_id && $smarty.get.refer neq 'store'} --><a class="btn plus_or_reply" href='{RC_Uri::url("commission/admin/day", "{$url_args}")}'><i class="fontello-icon-reply"></i>{t domain="commission"}返回全部{/t}</a><!-- {/if} -->
        <!-- {if $action_link} -->
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}" ><i class="fontello-icon-plus"></i>{$action_link.text}</a>
        <!-- {/if} -->
    </h3>
</div>


<div class="row-fluid">
    {if $smarty.get.refer eq 'store'}
    <div class="span3">
        <!-- {ecjia:hook id=display_admin_store_menus} -->
    </div>
    {/if}
    <div class="{if $smarty.get.refer eq 'store'}span9{/if}">
        {if $smarty.get.refer neq 'store'}
            <ul class="nav nav-pills choose_list ">
                <form class="f_r form-inline" action='{RC_Uri::url("commission/admin/day")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
                    <!-- 关键字 -->
                    <input class="date f_l" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder="{t domain="commission"}开始时间{/t}">
                    <input class="date f_l" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder="{t domain="commission"}结束时间{/t}">
                    <input type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{t domain="commission"}请输入商家关键字{/t}" size="15" />
                    <button class="btn screen-btn" type="submit">{t domain="commission"}搜索{/t}</button>
                </form>
            </ul>
            {/if}

            {if $smarty.get.refer eq 'store'}
            <ul class="nav nav-pills">
                <li class="{if !$smarty.get.type}active{/if}">
                    <a class="data-pjax" href='{RC_Uri::url("commission/admin/day", "{if $smarty.get.store_id}&store_id={$smarty.get.store_id}{/if}{if $smarty.get.refer}&refer={$smarty.get.refer}{/if}")}'>{t domain="commission"}全部{/t}
                        <span class="badge badge-info">{$bill_list.filter.count_all}</span>
                    </a>
                </li>
                <li class="{if $smarty.get.type eq 1}active{/if}">
                    <a class="data-pjax" href='{RC_Uri::url("commission/admin/day", "type=1{if $smarty.get.store_id}&store_id={$smarty.get.store_id}{/if}{if $smarty.get.refer}&refer={$smarty.get.refer}{/if}")}'>{t domain="commission"}未结算{/t}
                        <span class="badge badge-info">{$bill_list.filter.count_unpay}</span>
                    </a>
                </li>
                <li class="{if $smarty.get.type eq 2}active{/if}">
                    <a class="data-pjax" href='{RC_Uri::url("commission/admin/day", "type=2{if $smarty.get.store_id}&store_id={$smarty.get.store_id}{/if}{if $smarty.get.refer}&refer={$smarty.get.refer}{/if}")}'>{t domain="commission"}部分结算{/t}
                        <span class="badge badge-info">{$bill_list.filter.count_paying}</span>
                    </a>
                </li>
                <li class="{if $smarty.get.type eq 3}active{/if}">
                    <a class="data-pjax" href='{RC_Uri::url("commission/admin/day", "type=3{if $smarty.get.store_id}&store_id={$smarty.get.store_id}{/if}{if $smarty.get.refer}&refer={$smarty.get.refer}{/if}")}'>{t domain="commission"}已结算{/t}
                        <span class="badge badge-info use-plugins-num">{$bill_list.filter.count_payed}</span>
                    </a>
                </li>
            </ul>
            {/if}
        <div class="tab-content">
            <div class="row-fluid">
                <table class="table table-striped smpl_tbl dataTable table-hide-edit">
                    <thead>
                        <tr >
                            <th>{t domain="commission"}账单日期{/t}</th>
                            {if $smarty.get.refer neq 'store'}<th>{t domain="commission"}商家名称{/t}</th>{/if}
                            <th>{t domain="commission"}订单{/t}</th>
                            <th>{t domain="commission"}退款{/t}</th>
                            <th>{t domain="commission"}入账金额{/t}</th>
                            <th>{t domain="commission"}退款金额{/t}</th>
                            <th>{t domain="commission"}佣金比例{/t}</th>
                            <th>{t domain="commission"}商家有效佣金{/t}</th>
                         </tr>
                    </thead>

                    <!-- {foreach from=$bill_list.item item=commission} -->
                    <tr>
                        <td>
                        {$commission.day}
                            <!-- <div class="edit-list">
                                <a class="data-pjax" href='{RC_Uri::url("store/admin_commission/order_list","store_id={$commission.store_id}")}' title="订单列表">{t domain="commission"}订单列表{/t}</a>&nbsp;|&nbsp;
                                <a class="data-pjax" href='{RC_Uri::url("store/admin_commission/edit","id={$commission.id}&store_id={$commission.store_id}")}' title="编辑">{t domain="commission"}编辑{/t}</a>&nbsp;|&nbsp;
                                <a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg="{t domain="commission"}您确定要删除吗？{/t}" href='{RC_Uri::url("store/admin_commission/remove","id={$commission.id}")}' title="删除">{t domain="commission"}删除{/t}</a>
                            </div> -->
                        </td>
                        {if $smarty.get.refer neq 'store'}
                        <td> 
                        	{if $commission.merchants_name}
	                        	{assign var=store_url value=RC_Uri::url('store/admin/preview',"store_id={$commission.store_id}")}
	                             <a href='{RC_Uri::url("commission/admin/day", "store_id={$commission.store_id}")}' title="{t domain="commission"}查看此商家账单{/t}">{$commission.merchants_name}</a>
	                             <a href='{$store_url}' title="{t domain="commission"}查看商家资料{/t}" target="_blank"><i class="fontello-icon-info-circled"></i></a>
                       		{/if}
                        </td>
                        {/if}
                        <td>{$commission.order_count}</td>
    					<td>{$commission.refund_count}</td>
                        <td class="ecjiaf-tar">{$commission.order_amount_formatted}</td>
                        <td class="">{$commission.refund_amount_formatted}</td>
                        <!-- {if $commission.percent_value} -->
                        <td>{$commission.percent_value}%</td>
                        <!-- {else} -->
                        <td>100%</td>
                        <!-- {/if} -->
                        <td>{$commission.brokerage_amount_formatted}</td>
                    </tr>
                    <!-- {foreachelse} -->
                   <tr><td class="no-records" colspan="8">{t domain="commission"}没有找到任何记录{/t}</td></tr>
                    <!-- {/foreach} -->
                </table>
                <!-- {$bill_list.page} -->
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->