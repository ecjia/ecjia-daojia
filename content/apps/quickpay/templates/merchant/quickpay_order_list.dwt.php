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
        			<li class="{if $smarty.get.check_type eq ''}active{/if}"><a class="data-pjax" href='{url path="quickpay/mh_order/init" args="{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>全部 <span class="badge badge-info">{if $order_list.count.count}{$order_list.count.count}{else}0{/if}</span> </a></li>
        			<li class="{if $smarty.get.check_type eq 'verification'}active{/if}"><a class="data-pjax" href='{url path="quickpay/mh_order/init" args="check_type=verification{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>已核销<span class="badge badge-info">{if $order_list.count.verification}{$order_list.count.verification}{else}0{/if}</span> </a></li>
        			<li class="{if $smarty.get.check_type eq 'unverification'}active{/if}"><a class="data-pjax" href='{url path="quickpay/mh_order/init" args="check_type=unverification{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>待核销<span class="badge badge-info">{if $order_list.count.unverification}{$order_list.count.unverification}{else}0{/if}</span> </a></li>
        		</ul>
            </div>
            
			<div class='col-lg-12 panel-heading form-inline'>
        		<div class="btn-group form-group">
        			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> 批量操作 <span class="caret"></span></button>
        			<ul class="dropdown-menu operate_note">
        				<li><a class="batch-del-btn" data-toggle="ecjiabatch" data-name="order_id" data-idClass=".checkbox:checked" data-url="{url path='quickpay/mh_order/batch'}" data-msg="删除订单将清除该订单的所有信息。您确定要这么做吗？" data-noSelectMsg="请选择您要操作的订单" href="javascript:;"><i class="fa fa-trash-o"></i> 删除</a></li>
                   	</ul>
        		</div>
        		
        		<div class="form-group">
        			<select class="w200" name='activity_type'>
						<option value="0">{t}买单优惠类型{/t}</option>
						<!-- {foreach from=$type_list item=list key=key} -->
						<option value="{$key}" {if $key eq $smarty.get.activity_type}selected="selected"{/if}>{$list}</option>
						<!-- {/foreach} -->
					</select>
        		</div>
        		<button class="btn btn-primary screen-btn" type="button"><i class="fa fa-search"></i> 筛选</button>
        		
        		<form class="form-inline pull-right" name="searchForm" method="post" action="{$search_action}">
					<div class="form-group">
						<!-- 关键字 -->
						<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入订单号"/> 
						<button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> 搜索</button>
					</div>
				</form>
			</div>
			
			<div id="actionmodal" class="modal fade">
                <div class="modal-dialog" style="margin-top: 200px;">
                    <div class="modal-content">
	                    <div class="modal-header">
		                    <button data-dismiss="modal" class="close" type="button">×</button>
		                    <h4 class="modal-title">操作备注</h4>
	                    </div>
	                    
	                    <div class="modal-body">
	                     <div class="success-msg"></div>
	                     <div class="error-msg"></div>
		                    <form class="form-horizontal" method="post" name="actionForm" id="actionForm" action='{url path="quickpay/mh_order/order_action"}'>
		                       <div class="form-group">
		                           <div class="col-lg-12">
		                              <textarea id="action_note" class="form-control" id="action_note" name="action_note"></textarea>
		                           </div>
		                       </div>
		                      
		                       <div class="form-group">
		                          <div class="col-lg-10">
		                               <button type="submit" id="note_btn" class="btn btn-primary">确认核销</button>
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
        						<th class="w150">订单号</th>
        						<th>购买者信息</th>
        						<th class="w200">买单优惠类型</th>
        						<th class="w200">下单时间</th>
        						<th class="w100">消费金额</th>
        						<th class="w100">实付金额</th>
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
    								{if $order.pay_status eq 1 and $order.verification_status neq 1}	
    									<a href="#actionmodal" data-toggle="modal" order-id="{$order.order_id}" >核销</a>&nbsp;|&nbsp;
    								{/if}
    								<a target="_blank" href='{url path="quickpay/mh_order/order_info" args="order_id={$order.order_id}"}' title="查看详情">{t}查看详情{/t}</a>
    							</div>
    						</td>
    						<td align="left">
    							{$order.user_name} [TEL：{$order.user_mobile}]
    						</td>
    						<td>
    							{if $order.activity_type eq 'discount'}价格折扣{elseif $order.activity_type eq 'everyreduced'}每满多少减多少，最高减多少{elseif $order.activity_type eq 'reduced'}满多少减多少{elseif $order.activity_type eq 'normal'}无优惠{/if}
    						</td>
    						<td>{$order.add_time}</td>
    						<td>{$order.goods_amount}</td>
    						<td>{$order.order_amount}</td>
    					</tr>
    					<!-- {foreachelse}-->
    					<tr><td class="no-records" colspan="7">{lang key='system::system.no_records'}</td></tr>
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