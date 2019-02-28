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
                	<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> 批量操作 <span class="caret"></span></button>
                    <ul class="dropdown-menu"><li><a class="batch-del-btn" name='movetype' data-toggle="ecjiabatch" data-name="back_id" data-idClass=".checkbox:checked" data-url="{$del_action}" data-msg="您确定需要删除这些发货单吗？" data-noSelectMsg="请选择需要操作的发货单！" href="javascript:;"><i class="fa fa-trash-o"></i> {t domain="orders"}移除{/t}</a></li></ul>
                </div>	
                <form class="form-inline pull-right" action='{RC_Uri::url("orders/mh_back/init")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
                    <div class="form-group">
                        <input type="text" class="form-control" name="delivery_sn" value="{$filter.delivery_sn}" placeholder="请输入发货单流水号">
                        <input type="text" class="form-control" name="keywords" value="{$filter.keywords}" placeholder="请输入订单号或者收货人">
                    </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> 搜索 </button>
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
					            <th>发货单流水号</th>
					            <th>订单号</th>
					            <th>下单时间</th>
					            <th>收货人</th>
					            <th>发货时间</th>
					            <th>退货时间</th>
					            <th>操作者</th>
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
					                    <a class="data-pjax" href='{url path="orders/mh_back/back_info" args="back_id={$back.back_id}"}' title="查看">{t}{t domain="orders"}查看详情{/t}{/t}</a>&nbsp;|&nbsp;
					                    <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t name="{$back.delivery_sn}"}您确定要删除退货单[ %1 ]吗？{/t}' href='{url path="orders/mh_back/remove" args="back_id={$back.back_id}"}' title="{t}移除{/t}">{t}{t domain="orders"}移除{/t}{/t}</a>
					                </div>
					            </td>
					            <td><a href='{url path="orders/merchant/info" args="order_sn={$back.order_sn}"}' target="_blank" title="{t}查看订单{/t}">{$back.order_sn}</a></td>
					            <td>{$back.add_time}</td>
					            <td><a class="cursor_pointer consignee_info" data-url='{url path="orders/mh_back/consignee_info" args="back_id={$back.back_id}"}' title="{t}显示收货人信息{/t}">{$back.consignee|escape}</a></td>
					            <td>{$back.update_time}</td>
					            <td>{$back.return_time}</td>
					            <td>{$back.action_user}</td>
					        </tr>
					        <!-- {foreachelse} -->
					        <tr><td class="no-records" colspan="8">没有找到任何记录</td></tr>
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