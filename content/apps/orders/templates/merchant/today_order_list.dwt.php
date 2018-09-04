<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
var date = 'today';
var new_order = '{$new_order}';
ecjia.merchant.order.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $back_order_list}
  			<a href="{$back_order_list.href}" class="btn btn-primary nopjax">
				<i class="fa fa-reply"></i> {$back_order_list.text}
			</a>
  		{else}
	  		<a href='{RC_Uri::url("orders/merchant/today_order")}' class="btn btn-primary nopjax" target="__blank">当天订单</a>
	  		{if $action_link}
			<a href="{$action_link.href}" class="btn btn-primary data-pjax">
				<i class="fa fa-search"></i> {$action_link.text}
			</a>
			{/if}
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<!-- #BeginLibraryItem "/library/order_operate.lbi" --><!-- #EndLibraryItem -->

<div class="row">
	<div class="col-lg-12">
	    <div class="panel">
		 	<div class="col-lg-12 content">
				<div class="inner-content">
					<button class="m_l30 btn btn-success auto-refresh" type="button">20秒自动刷新 </button>
					<button class="m_l30 btn btn-warning hand-refresh" type="button"><i class="fa fa-refresh"></i> 手动刷新 </button>
					<span class="m_l30">下单铃声</span>
					<div class="switch m_l30">
			            <div class="onoffswitch" data-url="{RC_Uri::url('orders/merchant/switch_on_off')}">
			                <input type="checkbox" {if $on_off eq 'on'}checked{/if} name="onOff" class="onoffswitch-checkbox" id="onOff">
			                <label class="onoffswitch-label" for="onOff">
			                    <span class="onoffswitch-inner"></span>
			                    <span class="onoffswitch-switch"></span>
			                </label>
			            </div>
			        </div>
				</div>
			</div>

			<div class='panel-body panel-body-small'>
				<ul class="nav nav-pills">
					<li class="{if $filter.composite_status eq ''}active{/if}">
						<a class="data-pjax" href="{$search_url}
							{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							">{lang key='orders::order.all'}
							<span class="badge badge-info">{if $count.all}{$count.all}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 100}active{/if}">
						<a class="data-pjax" href="{$search_url}&composite_status=100
							{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							">待付款
							<span class="badge badge-info">{if $count.await_pay}{$count.await_pay}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 105}active{/if}">
						<a class="data-pjax" href="{$search_url}&composite_status=105
							{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							">待接单
							<span class="badge badge-info">{if $count.unconfirmed}{$count.unconfirmed}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 101}active{/if}">
						<a class="data-pjax" href="{$search_url}&composite_status=101
							{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							">待发货
							<span class="badge badge-info">{if $count.await_ship}{$count.await_ship}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 104}active{/if}">
						<a class="data-pjax" href="{$search_url}&composite_status=104
							{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							">待收货
							<span class="badge badge-info">{if $count.shipped}{$count.shipped}{else}0{/if}</span>
						</a>
					</li>
					<li class="{if $filter.composite_status eq 102}active{/if}">
						<a class="data-pjax" href="{$search_url}&composite_status=102
							{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							">已完成
							<span class="badge badge-info">{if $count.finished}{$count.finished}{else}0{/if}</span>
						</a>
					</li>
	        		<form class="form-inline pull-right" action='{$search_url}{if $filter.composite_status}&composite_status={$filter.composite_status}{/if}' method="post" name="searchForm">
	        			<div class="form-group">
	        				<input type="text" class="form-control w230" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入订单编号或购买者信息">
	        			</div>
	        			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> {lang key='orders::order.search_order'}</button>
	        		</form>
        		</ul>
    		</div>
    		
    		<div class="panel-body">
	           <div class="row-fluid">
		          <section class="panel">
			         <table class="table table-striped table-hide-edit">
				        <thead>
        					<tr>
        						<th class="w130">{lang key='orders::order.order_sn'}</th>
        						<th class="w180">{lang key='orders::order.order_time'}</th>
        						<th>{lang key='orders::order.user_purchase_information'}</th>
        						<th class="w120">{lang key='orders::order.total_fee'}</th>
        						<th class="w110">{lang key='orders::order.order_amount'}</th>
        						<th class="w150">{lang key='orders::order.all_status'}</th>
        					</tr>
				        </thead>
				        <tbody>
					    <!-- {foreach from=$order_list.order_list item=order key=okey} -->
    					<tr>
    						<td class="hide-edit-area">
    							{$order.order_sn}
    							<div class="edit-list">
    								<a href='{url path="orders/merchant/info" args="order_id={$order.order_id}"}' class="data-pjax" title="{lang key='orders::order.detail'}">{t}查看详情{/t}</a>
    								{if $order.can_remove}
    								&nbsp;|&nbsp;
    								<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t name="{$order.order_sn}"}您确定要删除订单[ %1 ]吗？{/t}' href='{url path="orders/merchant/remove_order" args="order_id={$order.order_id}"}' title="{t}移除{/t}">{t}移除{/t}</a>
    								{/if}
    							</div>
    						</td>
    						<td>
    							{$order.order_time}
    						</td>
    						<td align="left">
    							{$order.consignee}
    						</td>
    						<td>{$order.formated_total_fee}</td>
    						<td>{$order.formated_order_amount}</td>
    						<td {if $order.pay_status eq $payed}class="ecjiafc-red"{/if}>{$order.label_order_status}</td>
    					</tr>
    					<!-- {foreachelse}-->
    					<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
    					<!-- {/foreach} -->
				        </tbody>
			         </table>
		          </section>
		          <div> <!-- {$order_list.page} -->	</div>
	           </div>
            </div>
	     </div>
     </div>
</div>
<audio id="audio" src="{$music_url}new_order.mp3" style="opacity:0" preload="auto" controls hidden="true" loop="loop"/>  
<form action="{$form_action}" name="orderpostForm" id="listForm" data-pjax-url="{$search_action}" method="post"></form>
<!-- {/block} -->