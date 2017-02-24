<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.order_delivery.back_init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="clearfix"></div>
</div>
        <!-- #BeginLibraryItem "/library/order_consignee.lbi" --><!-- #EndLibraryItem -->
<div class="row">
	<div class="col-lg-12 ">
	    <div class="panel">
    		<ul class="nav nav-pills pull-left panel-heading">
    			<li class="{if !$smarty.get.type}active{/if}">
    				<a class="data-pjax" href="{RC_Uri::url('orders/mh_delivery/init')}{if $filter.delivery_sn}&delivery_sn={$filter.delivery_sn}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}" >{lang key='orders::order.already_shipped'}
    					<span class="badge badge-info">{$type_count.already_shipped}</span>
    				</a>
    			</li>
    			<li class="{if $smarty.get.type eq 1}active{/if}">
    				<a class="data-pjax" href='{RC_Uri::url("orders/mh_delivery/init", "type=1{if $filter.delivery_sn}&delivery_sn={$filter.delivery_sn}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>{lang key='orders::order.op_return'}
    					<span class="badge badge-info use-plugins-num">{$type_count.op_return}</span>
    				</a>
    			</li>
    			<li class="{if $smarty.get.type eq 2}active{/if}">
    				<a class="data-pjax" href='{RC_Uri::url("orders/mh_delivery/init", "type=2{if $filter.delivery_sn}&delivery_sn={$filter.delivery_sn}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>{lang key='orders::order.normal'}
    					<span class="badge badge-info unuse-plugins-num">{$type_count.normal}</span>
    				</a>
    			</li>
    		</ul>
            <div class="col-lg-12 panel-heading form-inline">
    			 <div class="btn-group form-group">
            	      <button  type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> {lang key='orders::order.bulk_operations'} <span class="caret"></span></button>
                      <ul class="dropdown-menu operate_note">
                           <li><a class="batch-del-btn" data-toggle="ecjiabatch" data-name="delivery_id" data-idClass=".checkbox:checked" data-url="{$form_action}" data-msg="您确定需要删除这些发货单吗？" data-noSelectMsg="请选择需要操作的发货单！" href="javascript:;"><i class="fa fa-trash-o"></i> {lang key='system::system.remove'}</a></li>
                      </ul>
                </div>	
                <form class="form-inline pull-right" action='{RC_Uri::url("orders/mh_delivery/init")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
        			<div class="form-group">
        				<input type="text" class="form-control" name="delivery_sn" value="{$filter.delivery_sn}" placeholder="{lang key='orders::order.pls_delivery_sn_number'}">
        			    <input type="text" class="form-control" name="keywords" value="{$filter.keywords}" placeholder="{lang key='orders::order.pls_consignee'}">
        			</div>
        			<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> {lang key='system::system.button_search'} </button>
        		</form>
    		</div>
		
			<div class="panel-body">
				<div class="row-fluid">
					<table class="table table-striped table-hide-edit">
						<thead>
							<tr>
								<th class="table_checkbox check-list w30">
									<div class="check-item">
										<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
										<label for="checkall"></label>
									</div>
					            </th>
								<th>{lang key='orders::order.label_delivery_sn'}</th>
								<th>{lang key='orders::order.order_sn'}</th>
								<th>{lang key='orders::order.order_time'}</th>
								<th>{lang key='orders::order.consignee'}</th>
								<th>{lang key='orders::order.label_update_time'}</th>
								<th>{lang key='orders::order.label_delivery_status'}</th>
								<th>{lang key='orders::order.action_user_two'}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$delivery_list.delivery item=delivery key=dkey} -->
							<tr>
								<td class="check-list">
									<div class="check-item">
										<input id="check_{$delivery.delivery_id}" class="checkbox" type="checkbox" name="checkboxes[]" value="{$delivery.delivery_id}"/>
										<label for="check_{$delivery.delivery_id}"></label>
									</div>
					            </td>	
								<td class="hide-edit-area">
									{$delivery.delivery_sn}
									<div class="edit-list">
										<a class="data-pjax" href='{url path="orders/mh_delivery/delivery_info" args="delivery_id={$delivery.delivery_id}"}' title="{lang key='orders::order.detail'}">{t}{lang key='orders::order.detailed_information'}{/t}</a>&nbsp;|&nbsp;
										<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t name="{$delivery.delivery_sn}"}您确定要删除发货单[ %1 ]吗？{/t}' href='{url path="orders/mh_delivery/remove" args="delivery_id={$delivery.delivery_id}{if $smarty.get.type}&type={$smarty.get.type}{/if}"}' title="{t}移除{/t}">{t}{lang key='orders::order.remove'}{/t}</a>
									</div>
								</td>
								<td><a href='{url path="orders/merchant/info" args="order_sn={$delivery.order_sn}"}' target="_blank" title="{t}查看订单{/t}">{$delivery.order_sn}</a></td>
								<td>{$delivery.add_time}</td>
								<td><a class="cursor_pointer consignee_info" data-url='{url path="orders/mh_delivery/consignee_info" args="delivery_id={$delivery.delivery_id}"}' title="{t}显示收货人信息{/t}">{$delivery.consignee|escape}</a></td>
								<td>{$delivery.update_time}</td>
								<td>{$delivery.status_name}</td>
								<td>{$delivery.action_user}</td>
							</tr>
							<!-- {foreachelse}-->
							<tr><td class="no-records" colspan="8">{lang key='system::system.no_records'}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table> 
				<!-- {$delivery_list.page} -->
				</div>        			
	        </div>
	    </div>
	</div>
</div>
<!-- {/block} -->