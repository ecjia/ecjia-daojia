<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
var date = '{$date}';
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
	  		<a href="{RC_Uri::url('orders/merchant/init')}&date=today" class="btn btn-primary nopjax" target="__blank">当天订单</a>
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
	    	{if $date}
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
			{/if}
	        <div class='{if $date}panel-body panel-body-small{else}col-lg-12 panel-heading form-inline{/if}'>
	        	{if !$date}
        		<div class="btn-group form-group">
        			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> {lang key='goods::goods.batch_handle'} <span class="caret"></span></button>
        			<ul class="dropdown-menu operate_note" data-url='{url path="orders/merchant/operate_note"}'>
        				<li><a class="batch-del-btn" data-toggle="ecjiabatch" data-name="order_id" data-idClass=".checkbox:checked" data-url="{$form_action}&operation=confirm" data-msg="{lang key='orders::order.confirm_approval_order'}" data-noSelectMsg="{lang key='orders::order.pls_select_order'}" href="javascript:;"><i class="fa fa-check"></i> {lang key='orders::order.op_confirm'}</a></li>
        				<li><a class="batch-operate batch-operate-invalid" data-operatetype="invalid" data-url="{$form_action}&operation=invalid" data-invalid-msg="{lang key='orders::order.confirm_order_invalid'}" href="javascript:;"><i class="fa fa-ban"></i> {lang key='orders::order.op_invalid'}</a></li>
        				<li><a class="batch-operate batch-operate-cancel" data-operatetype="cancel" data-url="{$form_action}&operation=cancel" data-cancel-msg="{lang key='orders::order.confirm_order_cancel'}" href="javascript:;"><i class="fa fa-times"></i> {lang key='orders::order.op_cancel'}</a></li>
        				<li><a class="batch-del-btn" data-toggle="ecjiabatch" data-name="order_id" data-idClass=".checkbox:checked" data-url="{$form_action}&operation=remove" data-msg="{lang key='orders::order.remove_confirm'}" href="javascript:;"><i class="fa fa-trash-o"></i> {lang key='system::system.remove'}</a></li>
        				<li><a class="batch-print" data-url="{$form_action}&print=1" href="javascript:;"><i class="fa fa-print"></i> {lang key='orders::order.print_order'}</a></li>
                   	</ul>
        		</div>
        		<div class="form-group ">
        			<select class="w130" name="status" id="select-rank">
        				<option value="-1">{lang key='orders::order.all_status'}</option>
        				<!-- {html_options options=$status_list selected=$order_list.filter.composite_status } -->
        			</select>
        		</div>
        		<button class="btn btn-primary screen-btn" type="button"><i class="fa fa-search"></i> {lang key='orders::order.filter'} </button>
        		{else}
        		<ul class="nav nav-pills pull-left">
					<li class="{if $composite_status eq '' || !$composite_status}active{/if}"><a class="data-pjax" href='{RC_Uri::url("orders/merchant/init")}&date=today{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>全部 <span class="badge badge-info">{$count.all}</span></a></li>
					<li class="{if $composite_status eq 'await_confirm'}active{/if}"><a class="data-pjax" href='{RC_Uri::url("orders/merchant/init")}&date=today&composite_status=0{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>待确认<span class="badge badge-info">{$count.await_confirm}</span></a></li>
					<li class="{if $composite_status eq 'await_pay'}active{/if}"><a class="data-pjax" href='{RC_Uri::url("orders/merchant/init")}&date=today&composite_status=100{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>待付款<span class="badge badge-info">{$count.await_pay}</span></a></li>
					<li class="{if $composite_status eq 'await_ship'}active{/if}"><a class="data-pjax" href='{RC_Uri::url("orders/merchant/init")}&date=today&composite_status=101{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>待发货<span class="badge badge-info">{$count.await_ship}</span></a></li>
					<li class="{if $composite_status eq 'order_finished'}active{/if}"><a class="data-pjax" href='{RC_Uri::url("orders/merchant/init")}&date=today&composite_status=102{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>已完成<span class="badge badge-info">{$count.order_finished}</span></a></li>
				</ul>
        		{/if}
        		
        		<form class="form-inline pull-right" action='{RC_Uri::url("orders/merchant/init")}{if $smarty.get.date}&date={$smarty.get.date}{/if}' method="post" name="searchForm">
        			<div class="form-group">
        				<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='orders::order.pls_consignee'}">
        			</div>
        			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> {lang key='orders::order.search_order'}</button>
        		</form>
    		</div>
    		
    		<div class="panel-body">
	           <div class="row-fluid">
		          <section class="panel">
			         <table class="table table-striped table-hide-edit">
				        <thead>
        					<tr>
        						{if !$date}
        						<th class="table_checkbox check-list w30">
        							<div class="check-item">
        								<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
        								<label for="checkall"></label>
        							</div>
						        </th>
						        {/if}
        						<th class="w100">{lang key='orders::order.order_sn'}</th>
        						<th class="w150">{lang key='orders::order.order_time'}</th>
        						<th>{lang key='orders::order.user_purchase_information'}</th>
        						<th class="w120">{lang key='orders::order.total_fee'}</th>
        						<th class="w110">{lang key='orders::order.order_amount'}</th>
        						<th class="w200">{lang key='orders::order.all_status'}</th>
        					</tr>
				        </thead>
				        <tbody>
					    <!-- {foreach from=$order_list.orders item=order key=okey} -->
    					<tr>
    						{if !$date}
    						<td class="check-list">
    							<div class="check-item">
    								<input id="check_{$order.order_id}" class="checkbox" type="checkbox" name="checkboxes[]" value="{$order.order_id}"/>
    								<label for="check_{$order.order_id}"></label>
    							</div>
				            </td>
				            {/if}	
    						<td class="hide-edit-area">
    							{$order.order_sn}{if $order.extension_code eq "group_buy"}{lang key='orders::order.group_buy'}{elseif $order.extension_code eq "exchange_goods"}{lang key='orders::order.exchange_goods'}{/if}
    							{if $order.stet eq 1}<font style="color:#0e92d0;">(子订单)</font>{elseif $order.stet eq 2}<font style="color:#F00;"><span data-original-title="{foreach from=$order.children_order item=val}{$val};{/foreach}" data-toggle="tooltip">(主订单)</span></font>{/if}
    							<div class="edit-list">
    								<a href='{url path="orders/merchant/info" args="order_id={$order.order_id}"}' class="data-pjax" title="{lang key='orders::order.detail'}">{t}查看详情{/t}</a>
    								{if $order.can_remove}
    								&nbsp;|&nbsp;
    								<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t name="{$order.order_sn}"}您确定要删除订单[ %1 ]吗？{/t}' href='{url path="orders/merchant/remove_order" args="order_id={$order.order_id}"}' title="{t}移除{/t}">{t}移除{/t}</a>
    								{/if}
    							</div>
    						</td>
    						<td>
    							{$order.short_order_time}
    						</td>
    						<td align="left">
    							{$order.consignee} [TEL：{$order.mobile}]<br/>{$order.address}
    						</td>
    						<td>{$order.formated_total_fee}</td>
    						<td>{$order.formated_order_amount}</td>
    						<td {if $order.pay_status eq $payed}class="ecjiafc-red"{/if}>{$os[$order.order_status]},{$ps[$order.pay_status]},{$ss[$order.shipping_status]}</td>
    					</tr>
    					<!-- {foreachelse}-->
    					<tr><td class="no-records" colspan="7">{lang key='system::system.no_records'}</td></tr>
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
{if $date}
<audio id="audio" src="{$music_url}new_order.mp3" style="opacity:0" preload="auto" controls hidden="true"/>  
{/if}
<form action="{$form_action}" name="orderpostForm" id="listForm" data-pjax-url="{$search_action}" method="post"></form>
<!-- {/block} -->