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
    <div class="col-lg-12">
        <div class="panel">
            <div class="col-lg-12 panel-heading form-inline">
                <div class="btn-group form-group">
                	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> {lang key='orders::order.bulk_operations'} <span class="caret"></span></button>
                    <ul class="dropdown-menu"><li><a class="batch-del-btn" name='movetype' data-toggle="ecjiabatch" data-name="back_id" data-idClass=".checkbox:checked" data-url="{$del_action}" data-msg="您确定需要删除这些发货单吗？" data-noSelectMsg="请选择需要操作的发货单！" href="javascript:;"><i class="fa fa-trash-o"></i> {lang key='orders::order.remove'}</a></li></ul>
                </div>	
                <form class="form-inline pull-right" action='{RC_Uri::url("orders/mh_back/init")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
                    <div class="form-group">
                        <input type="text" class="form-control" name="delivery_sn" value="{$filter.delivery_sn}" placeholder="{lang key='orders::order.pls_delivery_sn_number'}">
                        <input type="text" class="form-control" name="keywords" value="{$filter.keywords}" placeholder="{lang key='orders::order.pls_consignee'}">
                    </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> {lang key='orders::order.search'} </button>
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
					            <th>{lang key='orders::order.label_return_time'}</th>
					            <th>{lang key='orders::order.action_user_two'}</th>
					        </tr>
					    </thead>
					
					    <tbody>
					        <!-- {foreach from=$back_list.back item=back key=dkey}-->
					        <tr>
					            <td class="check-list">
					                <div class="check-item">
					                    <input id="check_{$back.back_id}" class="checkbox" type="checkbox" name="checkboxes[]" value="{$back.back_id}"/>
					                    <label for="check_{$back.back_id}"></label>
					                </div>
					            </td>   
					            <td class="hide-edit-area" >
					                {$back.delivery_sn}
					                <div class="edit-list">
					                    <a class="data-pjax" href='{url path="orders/mh_back/back_info" args="back_id={$back.back_id}"}' title="{lang key='orders::order.detail'}">{t}{lang key='orders::order.check_info'}{/t}</a>&nbsp;|&nbsp;
					                    <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t name="{$back.delivery_sn}"}您确定要删除退货单[ %1 ]吗？{/t}' href='{url path="orders/mh_back/remove" args="back_id={$back.back_id}"}' title="{t}移除{/t}">{t}{lang key='orders::order.remove'}{/t}</a>
					                </div>
					            </td>
					            <td><a href='{url path="orders/merchant/info" args="order_sn={$back.order_sn}"}' target="_blank" title="{t}{lang key='orders::order.look_order'}{/t}">{$back.order_sn}</a></td>
					            <td>{$back.add_time}</td>
					            <td><a class="cursor_pointer consignee_info" data-url='{url path="orders/mh_back/consignee_info" args="back_id={$back.back_id}"}' title="{t}{lang key='orders::order.display_consignee_info'}{/t}">{$back.consignee|escape}</a></td>
					            <td>{$back.update_time}</td>
					            <td>{$back.return_time}</td>
					            <td>{$back.action_user}</td>
					        </tr>
					        <!-- {foreachelse} -->
					        <tr><td class="no-records" colspan="8">{lang key='system::system.no_records'}</td></tr>
					        <!-- {/foreach} -->
					    </tbody>
					</table>
					<!-- {$back_list.page} -->        				
            	</div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->