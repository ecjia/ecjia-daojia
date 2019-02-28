<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.order_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">
			<!-- {if $ur_here}{$ur_here}{/if} -->
			<div class="pull-right">
				{if $action_link}
		  			<a href="{$action_link.href}" class="btn btn-primary data-pjax"><i class="fa fa-search"></i> {$action_link.text}</a>
				{/if}
			</div>
		</h2>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
	    <div class="panel">
	     	<div class="panel-body panel-body-small">
        		<ul class="nav nav-pills pull-left">
        			<li class="{if $filter.check_type eq 'unverification'}active{/if}"><a class="data-pjax" href='{url path="quickpay/mh_order/init" args="check_type=unverification{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="quickpay"}待核销{/t}<span class="badge badge-info">{if $order_list.count.unverification}{$order_list.count.unverification}{else}0{/if}</span> </a></li>
        			<li class="{if $filter.check_type eq 'verification'}active{/if}"><a class="data-pjax" href='{url path="quickpay/mh_order/init" args="check_type=verification{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="quickpay"}已核销{/t}<span class="badge badge-info">{if $order_list.count.verification}{$order_list.count.verification}{else}0{/if}</span> </a></li>
        			<li class="{if $filter.check_type eq 'unpay'}active{/if}"><a class="data-pjax" href='{url path="quickpay/mh_order/init" args="check_type=unpay{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="quickpay"}未付款{/t}<span class="badge badge-info">{if $order_list.count.unpay}{$order_list.count.unpay}{else}0{/if}</span> </a></li>
        		</ul>
            </div>
            
			<div class='col-lg-12 panel-heading form-inline'>
        		<div class="btn-group form-group">
        			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> {t domain="quickpay"}批量操作{/t}<span class="caret"></span></button>
        			<ul class="dropdown-menu">
        				<li><a  data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='quickpay/mh_order/batch'}&operation=remove" data-msg='{t domain="quickpay"}删除订单将清除该订单的所有信息。您确定要这么做吗？{/t}' data-noSelectMsg='{t domain="quickpay"}请选择您要操作的订单{/t}' href="javascript:;"><i class="fa fa-trash-o"></i> {t domain="quickpay"}删除{/t}</a></li>
        				<li><a  data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='quickpay/mh_order/batch'}&operation=cancel" data-msg='{t domain="quickpay"}你确定要取消这些订单吗？{/t}' data-noSelectMsg='{t domain="quickpay"}请选择您要操作的订单{/t}' href="javascript:;"><i class="fa fa-times"></i> {t domain="quickpay"}取消{/t}</a></li>
                   	</ul>
        		</div>
        		
        		<div class="form-group">
        			<select class="w100" name='order_status'>
						<option value="0">{t domain="quickpay"}订单状态{/t}</option>
						<!-- {foreach from=$status_list item=list key=key} -->
						<option value="{$key}" {if $key eq $smarty.get.order_status}selected="selected"{/if}>{$list}</option>
						<!-- {/foreach} -->
					</select>
        		</div>
        		
        		<div class="form-group">
        			<select class="w200" name='activity_type'>
						<option value="0">{t domain="quickpay"}买单优惠类型{/t}</option>
						<!-- {foreach from=$type_list item=list key=key} -->
						<option value="{$key}" {if $key eq $smarty.get.activity_type}selected="selected"{/if}>{$list}</option>
						<!-- {/foreach} -->
					</select>
        		</div>
        		<button class="btn btn-primary screen-btn" type="button"><i class="fa fa-search"></i> {t domain="quickpay"}筛选{/t}</button>
        		
        		<form class="form-inline pull-right" name="searchForm" method="post" action="{$search_action}{if $filter.check_type}&check_type={$filter.check_type}{/if}"}">
					<div class="form-group">
						<!-- 关键字 -->
						<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="quickpay"}请输入订单号{/t}'/> 
						<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> {t domain="quickpay"}搜索{/t}</button>
					</div>
				</form>
			</div>
			
			<div id="actionmodal" class="modal fade">
                <div class="modal-dialog" style="margin-top: 200px;">
                    <div class="modal-content">
	                    <div class="modal-header">
		                    <button data-dismiss="modal" class="close" type="button">×</button>
		                    <h4 class="modal-title">{t domain="quickpay"}操作备注{/t}</h4>
	                    </div>
	                    
	                    <div class="modal-body">
	                     <div class="success-msg"></div>
	                     <div class="error-msg"></div>
		                    <form class="form-horizontal" method="post" name="actionForm" id="actionForm" action='{url path="quickpay/mh_order/order_action"}'>
		                       <div class="form-group">
		                           <div class="col-lg-12">
		                              <textarea id="action_note" class="form-control" name="action_note"></textarea>
		                           </div>
		                       </div>
		                      
		                       <div class="form-group">
		                          <div class="col-lg-10">
		                               <button type="submit" id="note_btn" class="btn btn-primary">{t domain="quickpay"}确认核销{/t}</button>
		                          </div>
		                       </div>
		                    </form>
	                    </div>
                    </div>
                </div>
           </div>
           
           <div id="actionmodal_cancle" class="modal fade">
                <div class="modal-dialog" style="margin-top: 200px;">
                    <div class="modal-content">
	                    <div class="modal-header">
		                    <button data-dismiss="modal" class="close" type="button">×</button>
		                    <h4 class="modal-title">{t domain="quickpay"}操作备注{/t}</h4>
	                    </div>
	                    
	                    <div class="modal-body">
	                     <div class="success-msg"></div>
	                     <div class="error-msg"></div>
		                    <form class="form-horizontal" method="post" name="actioncancelForm" id="actioncancelForm" action='{url path="quickpay/mh_order/order_action_cancel"}'>
		                       <div class="form-group">
		                           <div class="col-lg-12">
		                              <textarea id="action_cancel_note" class="form-control" name="action_cancel_note"></textarea>
		                           </div>
		                       </div>
		                      
		                       <div class="form-group">
		                          <div class="col-lg-10">
		                               <button type="submit" id="note_btn_cancel" class="btn btn-primary">{t domain="quickpay"}取消{/t}</button>
		                          </div>
		                       </div>
		                    </form>
	                    </div>
                    </div>
                </div>
           </div>

			<div class="panel-body panel-body-small">
				<section class="panel">
					 <table class="table table-striped table-hide-edit">
				        <thead>
        					<tr>
        						<th class="table_checkbox check-list w30">
        							<div class="check-item">
        								<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
        								<label for="checkall"></label>
        							</div>
						        </th>
        						<th class="w150">{t domain="quickpay"}订单号{/t}</th>
        						<th>{t domain="quickpay"}购买者信息{/t}</th>
        						<th class="w200">{t domain="quickpay"}买单优惠类型{/t}</th>
        						<th class="w200">{t domain="quickpay"}下单时间{/t}</th>
        						<th class="w100">{t domain="quickpay"}实付金额{/t}</th>
        						<th class="w180">{t domain="quickpay"}订单状态{/t}</th>
        					</tr>
				        </thead>
				        <tbody>
					    <!-- {foreach from=$order_list.list item=order} -->
    					<tr>
    						<td class="check-list">
    							<div class="check-item">
    								<input id="check_{$order.order_id}" class="checkbox" type="checkbox" name="checkboxes[]" value="{$order.order_id}"/>
    								<label for="check_{$order.order_id}"></label>
    							</div>
				            </td>	
    						<td class="hide-edit-area">
    							{$order.order_sn}
    							<div class="edit-list">
    								<a target="_blank" href='{url path="quickpay/mh_order/order_info" args="order_id={$order.order_id}"}' >{t domain="quickpay"}查看详情{/t}</a>
    								{if $order.order_status eq 0 and $order.pay_status eq 0 and $order.verification_status eq 0}	
    									|&nbsp;<a href="#actionmodal_cancle" data-toggle="modal" id="modal_cancel" order-id="{$order.order_id}">{t domain="quickpay"}取消{/t}</a>
    								{/if}
    								
    								{if $order.order_status eq 9}	
    									|&nbsp;<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="quickpay"}你确定要删除该订单吗？{/t}' href='{url path="quickpay/mh_order/remove" args="order_id={$order.order_id}"}' >{t domain="quickpay"}删除{/t}</a>
    								{/if}
    							
    								{if $order.pay_status eq 1 and $order.verification_status neq 1}	
    									|&nbsp;<a href="#actionmodal" data-toggle="modal" id="modal" order-id="{$order.order_id}">{t domain="quickpay"}核销{/t}</a>
    								{/if}
    							</div>
    						</td>
    						<td align="left">
    							{$order.user_name}
    						</td>
    						<td>
    							{if $order.activity_type eq 'discount'}
    							{t domain="quickpay"}价格折扣{/t}
    							{elseif $order.activity_type eq 'everyreduced'}
    							{t domain="quickpay"}每满多少减多少，最高减多少{/t}
    							{elseif $order.activity_type eq 'reduced'}
    							{t domain="quickpay"}满多少减多少{/t}
    							{elseif $order.activity_type eq 'normal'}
    							{t domain="quickpay"}无优惠{/t}
    							{/if}
    						</td>
    						<td>{$order.add_time}</td>
    						<td>{$order.order_amount}</td>
    						<td>
								{if $order.order_status eq 1}
								{t domain="quickpay"}已确认{/t}
								{elseif $order.order_status eq 9}
								<font class="ecjiafc-red">{t domain="quickpay"}已取消{/t}</font>
								{elseif $order.order_status eq 99}
								<font class="ecjiafc-red">{t domain="quickpay"}已删除{/t}</font>
								{else}
								{t domain="quickpay"}未确认{/t}
								{/if},
								{if $order.pay_status eq 1}{t domain="quickpay"}已付款{/t}{else}{t domain="quickpay"}未付款{/t}{/if},
								{if $order.verification_status eq 1}{t domain="quickpay"}已核销{/t}{else}{t domain="quickpay"}未核销{/t}{/if}
							</td>
    					</tr>
    					<!-- {foreachelse}-->
    					<tr><td class="no-records" colspan="7">{t domain="quickpay"}没有找到任何记录{/t}</td></tr>
    					<!-- {/foreach} -->
				        </tbody>
			         </table>
				</section>
				<!-- {$order_list.page} -->
			</div>
	     </div>
     </div>
</div>
<!-- {/block} -->