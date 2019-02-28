<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.order_delivery.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>
<!-- #BeginLibraryItem "/library/order_consignee.lbi" --><!-- #EndLibraryItem -->
<div class="row-fluid">
	<div class="choose_list span12">
		<form action="{$search_action}" name="searchForm" method="post">
			<div class="btn-group f_l m_r5">
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fontello-icon-cog"></i>批量操作
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a class="batch-del-btn" data-toggle="ecjiabatch" data-name="delivery_id" data-idClass=".checkbox:checked" data-url="{$form_action}" data-msg="您确定需要删除这些发货单吗？" data-noSelectMsg="请选择需要操作的发货单！" href="javascript:;"><i class="fontello-icon-trash"></i>删除</a></li>
				</ul>
			</div>
			<select class="down-menu good_br w100" name="status" id="select-rank">
				<option value="-1">请选择...</option>
				<!-- {html_options options=$lang_delivery_status selected=$filter.status} -->
			</select>
			<a class="btn m_l5 screen-btn">筛选</a>
			<div class="choose_list f_r" >
				<input type="text" name="delivery_sn" value="{$filter.delivery_sn}" placeholder="请输入发货单流水号"/>
				<input type="text" name="keywords" value="{$filter.keywords}" placeholder="请输入订单号或者收货人"/>
				<button class="btn" type="submit">搜索</button>
			</div>
		</form>
	</div>
</div>	
<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<table class="table table-striped table-hide-edit" style="table-layout:fixed;">
				<thead>
					<tr>
						<th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox"/></th>
						<th class="w130">发货单流水号</th>
						<th class="w110">订单号</th>
						<th class="w130">下单时间</th>
						<th>收货人</th>
						<th class="w130">发货时间</th>
<!-- 							<th class="w80">供货商</th> -->
						<th class="w80">发货单状态</th>
						<th class="w80">操作人</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$delivery_list.delivery item=delivery key=dkey} -->
					<tr>
						<td valign="top" nowrap="nowrap"><input type="checkbox" class="checkbox" name="delivery_id[]"  value="{$delivery.delivery_id}" /></td>
						<td class="hide-edit-area">
							{$delivery.delivery_sn}
							<div class="edit-list">
								<a class="data-pjax" href='{url path="orders/admin_order_delivery/delivery_info" args="delivery_id={$delivery.delivery_id}"}' title="查看">查看</a>&nbsp;|&nbsp; 
								<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="您确定需要删除该退货单吗？" href='{url path="orders/admin_order_delivery/remove" args="delivery_id={$delivery.delivery_id}"}' title="删除">删除</a>
							</div>
						</td>
						<td><a href='{url path="orders/admin/info" args="order_id={$delivery.order_id}"}' target="_blank" title="查看订单">{$delivery.order_sn}</a></td>
						<td>{$delivery.add_time}</td>
						<td><a class="cursor_pointer consignee_info" data-url='{url path="orders/admin_order_delivery/consignee_info" args="delivery_id={$delivery.delivery_id}"}' title="显示收货人信息"><span class="ecjiaf-pre ecjiaf-wsn">{$delivery.consignee|escape}</span></a></td>
						<td>{$delivery.update_time}</td>
<!-- 							<td>{$delivery.suppliers_name}</td> -->
						<td>{$delivery.status_name}</td>
						<td>{$delivery.action_user}</td>
					</tr>
					<!-- {foreachelse}-->
					<tr><td class="no-records" colspan="8">没有找到任何记录</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table> 
			<!-- {$delivery_list.page} -->
		</div>
	</div>
</div>
<!-- {/block} -->