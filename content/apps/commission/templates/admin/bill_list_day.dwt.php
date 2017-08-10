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
		<!-- {if $smarty.get.store_id && $smarty.get.refer neq 'store'} --><a class="btn plus_or_reply" href='{RC_Uri::url("commission/admin/day", "{$url_args}")}'><i class="fontello-icon-reply"></i>{t}返回全部{/t}</a><!-- {/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" ><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
{if $smarty.get.refer neq 'store'}
<ul class="nav nav-pills choose_list ">
	<form class="f_r form-inline" action='{RC_Uri::url("commission/admin/day")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
		<!-- 关键字 -->
		<input class="date f_l" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder="开始时间">
		<input class="date f_l" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder="结束时间">
		<input type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{lang key='goods::goods.enter_merchant_keywords'}" size="15" />
		<button class="btn screen-btn" type="submit">{lang key='system::system.button_search'}</button>
	</form>
</ul>
{/if}

<div class="row-fluid list-page">
	<div class="span12">
	   <div class="tabbable tabs-left">
			{if $menu}
			<ul class="nav nav-tabs tab_merchants_nav">
                <!-- {foreach from=$menu item=val} -->
                <li {if $val.active}class="active"{/if}><a href="{$val.url}" {if $val.active}data-toggle="tab"{/if}>{$val.menu}</a></li>
                <!-- {/foreach} -->
			</ul>
			{/if}
    		<div class="tab-content">
    		{if $smarty.get.refer eq 'store'}
<ul class="nav nav-pills">
    <li class="{if !$smarty.get.type}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("commission/admin/day", "{if $smarty.get.store_id}&store_id={$smarty.get.store_id}{/if}{if $smarty.get.refer}&refer={$smarty.get.refer}{/if}")}'>全部
			<span class="badge badge-info">{$bill_list.filter.count_all}</span>
		</a>
	</li>
	<li class="{if $smarty.get.type eq 1}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("commission/admin/day", "type=1{if $smarty.get.store_id}&store_id={$smarty.get.store_id}{/if}{if $smarty.get.refer}&refer={$smarty.get.refer}{/if}")}'>未结算 
			<span class="badge badge-info">{$bill_list.filter.count_unpay}</span>
		</a>
	</li>
	<li class="{if $smarty.get.type eq 2}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("commission/admin/day", "type=2{if $smarty.get.store_id}&store_id={$smarty.get.store_id}{/if}{if $smarty.get.refer}&refer={$smarty.get.refer}{/if}")}'>部分结算 
			<span class="badge badge-info">{$bill_list.filter.count_paying}</span>
		</a>
	</li>
	<li class="{if $smarty.get.type eq 3}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("commission/admin/day", "type=3{if $smarty.get.store_id}&store_id={$smarty.get.store_id}{/if}{if $smarty.get.refer}&refer={$smarty.get.refer}{/if}")}'>已结算
			<span class="badge badge-info use-plugins-num">{$bill_list.filter.count_payed}</span>
		</a>
	</li>
</ul>
{/if}
    			<!-- system start -->
    			<div class="row-fluid">
    				<table class="table table-striped smpl_tbl dataTable table-hide-edit">
    					<thead>
    						<tr >
    						    <th>{t}账单日期{/t}</th>
    						    {if $smarty.get.refer neq 'store'}<th>{t}商家名称{/t}</th>{/if}
    						    <th>{t}入账金额{/t}</th>
    						    <th>{t}退款金额{/t}</th>
    						    <th>{t}佣金比例{/t}</th>
    						    <th>{t}商家有效佣金{/t}</th>
    						 </tr>
    					</thead>
    
       				 <!-- {foreach from=$bill_list.item item=commission} -->
    						<tr>
    							<td>
    							{$commission.day}
    								<!-- <div class="edit-list">
          								<a class="data-pjax" href='{RC_Uri::url("store/admin_commission/order_list","store_id={$commission.store_id}")}' title="订单列表">{t}订单列表{/t}</a>&nbsp;|&nbsp;
          								<a class="data-pjax" href='{RC_Uri::url("store/admin_commission/edit","id={$commission.id}&store_id={$commission.store_id}")}' title="编辑">{t}编辑{/t}</a>&nbsp;|&nbsp;
          								<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg="{t}您确定要删除吗？{/t}" href='{RC_Uri::url("store/admin_commission/remove","id={$commission.id}")}' title="删除">{t}删除{/t}</a>
    								</div> -->
    							</td>
    						    {if $smarty.get.refer neq 'store'}
    						    <td> {assign var=store_url value=RC_Uri::url('store/admin/preview',"store_id={$commission.store_id}")}
            					     <a href='{RC_Uri::url("commission/admin/day", "store_id={$commission.store_id}")}' title="查看此商家账单">{$commission.merchants_name}</a>
            					     <a href='{$store_url}' title="查看商家资料" target="_blank"><i class="fontello-icon-info-circled"></i></a>
        					    </td>
        					    {/if}
    						    <td class="ecjiaf-tar">￥{$commission.order_amount}</td>
    						    <td class="ecjiafc-red">￥{$commission.refund_amount}</td>
    						    <!-- {if $commission.percent_value} -->
    						    <td>{$commission.percent_value}%</td>
    						    <!-- {else} -->
    						    <td>{t}100%{/t}</td>
    						    <!-- {/if} -->
    						    <td>￥{$commission.brokerage_amount}</td>
    						</tr>
    						<!-- {foreachelse} -->
    					   <tr><td class="no-records" colspan="7">{t}没有找到任何记录{/t}</td></tr>
    					<!-- {/foreach} -->
    				</table>
    				<!-- {$bill_list.page} -->
    			</div>
    		</div>
		</div>
	</div>
</div> 
<!-- {/block} -->