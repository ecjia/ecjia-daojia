<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.order_delivery.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel">
             <div class="col-lg-12 panel-heading form-inline">
                  <div class="btn-group form-group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> {lang key='orders::order.bulk_operations'} <span class="caret"></span></button>
                      <ul class="dropdown-menu operate_note"><li><a class="batch-del-btn" data-toggle="ecjiabatch" data-name="order_id" data-idClass=".checkbox:checked" data-url="{$form_action}" data-msg="您确定需要删除这些发货单吗？" data-noSelectMsg="请选择需要操作的发货单！" href="javascript:;"><i class="fa fa-trash-o"></i> {lang key='orders::order.remove'}</a></li></ul>
                  </div>
            	  <form class="form-inline pull-right " action='{RC_Uri::url("orders/mh_reminder/init")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
                        <div class="form-group">
                            <input type="text" class="form-control" name="keywords" value="{$result_list.keywords}" placeholder="{lang key='orders::order.pls_consignee'}">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> {lang key='orders::order.search'} </button>
                        </div>
                  </form>
             </div>
             
             <div class="panel-body">
    	         <div class="row-fluid">
    		         <form method="post" action="{$form_action}" name="listForm">
    			         <table class="table table-striped table-hide-edit">
    				        <thead>
            					<tr>
            						<th class="table_checkbox check-list w30">
            							<div class="check-item">
            								<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
            								<label for="checkall"></label>
            							</div>
						            </th>
            						<th>{lang key='orders::order.list_oder_sn'}</th>
            						<th>{lang key='orders::order.consignee'}</th>
            						<th>{lang key='orders::order.list_consignee_address'}</th>
            						<th>{lang key='orders::order.list_audit_status'}</th>
            						<th>{lang key='orders::order.lsit_reminder'}</th>
            					</tr>
    				        </thead>
    				        <tbody>
    					    <!-- {foreach from=$order_remind item=remind key=key} -->
        					<tr>        						
        						<td class="check-list">
        							<div class="check-item">
        								<input id="check_{$remind.order_id}" class="checkbox" type="checkbox" name="checkboxes[]" value="{$remind.order_id}"/>
        								<label for="check_{$remind.order_id}"></label>
        							</div>
				                </td>	
        						<td class="hide-edit-area">
        							{$remind.order_sn}
        							<div class="edit-list">
        								<a class="data-pjax" href='{url path="orders/merchant/info" args="order_id={$remind.order_id}"}' title="{lang key='orders::order.detail'}">{t}{lang key='orders::order.detailed_information'}{/t}</a>&nbsp;|&nbsp;
        									<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t name="{$remind.order_sn}"}您确定要删除退货单[ %1 ]吗？{/t}' href='{url path="orders/mh_reminder/remove" args="order_id={$remind.order_id}"}' title="{t}移除{/t}">{t}{lang key='orders::order.remove'}{/t}</a>
        								</div>
        						</td>
        						<td>{$remind.user_name}</td>
        						<td>{$remind.address}</td>
        						<td>{$remind.order_status}</td>
        						<td>{$remind.confirm_time}</td>
        					</tr>
        					<!-- {foreachelse}-->
        					<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
        					<!-- {/foreach} -->
    				        </tbody>
    			        </table> 
    			            <!-- {$result_list.page} -->
    		         </form>
    	        </div>
            </div>
         </div>
     </div>
</div>
<!-- {/block} -->