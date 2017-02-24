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
					<i class="fontello-icon-cog"></i>{lang key='orders::order.bulk_operations'}
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a class="batch-del-btn" data-toggle="ecjiabatch" data-name="delivery_id" data-idClass=".checkbox:checked" data-url="{$form_action}" data-msg="{lang key='orders::order.delivery_delete'}" data-noSelectMsg="{lang key='orders::order.pls_select_delivery'}" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='system::system.remove'}</a></li>
				</ul>
			</div>
			<select class="down-menu good_br w100" name="status" id="select-rank">
				<option value="-1">{lang key='system::system.select_please'}</option>
				<!-- {html_options options=$lang_delivery_status selected=$filter.status} -->
			</select>
			<a class="btn m_l5 screen-btn">{lang key='orders::order.filter'}</a>
			<div class="choose_list f_r" >
				<input type="text" name="delivery_sn"  value="{$filter.delivery_sn}"  placeholder="{lang key='orders::order.pls_delivery_sn_number'}"/>
				<input type="text" name="keywords" value="{$filter.keywords}" placeholder="{lang key='orders::order.pls_consignee'}"/>
				<button class="btn" type="submit">{lang key='orders::order.search'}</button>
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
						<th class="w130">{lang key='orders::order.label_delivery_sn'}</th>
						<th class="w110">{lang key='orders::order.order_sn'}</th>
						<th class="w130">{lang key='orders::order.label_add_time'}</th>
						<th>{lang key='orders::order.consignee'}</th>
						<th class="w130">{lang key='orders::order.label_update_time'}</th>
<!-- 							<th class="w80">{lang key='orders::order.suppliers_name'}</th> -->
						<th class="w80">{lang key='orders::order.label_delivery_status'}</th>
						<th class="w80">{lang key='system::system.operator'}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$delivery_list.delivery item=delivery key=dkey} -->
					<tr>
						<td valign="top" nowrap="nowrap"><input type="checkbox" class="checkbox" name="delivery_id[]"  value="{$delivery.delivery_id}" /></td>
						<td class="hide-edit-area">
							{$delivery.delivery_sn}
							<div class="edit-list">
								<a class="data-pjax" href='{url path="orders/admin_order_delivery/delivery_info" args="delivery_id={$delivery.delivery_id}"}' title="{lang key='orders::order.detail'}">{lang key='orders::order.detail'}</a>&nbsp;|&nbsp; 
								<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='orders::order.confirm_delete_one'}" href='{url path="orders/admin_order_delivery/remove" args="delivery_id={$delivery.delivery_id}"}' title="{lang key='orders::order.op_remove'}">{lang key='orders::order.op_remove'}</a>
							</div>
						</td>
						<td><a href='{url path="orders/admin/info" args="order_id={$delivery.order_id}"}' target="_blank" title="{lang key='orders::order.look_order'}">{$delivery.order_sn}</a></td>
						<td>{$delivery.add_time}</td>
						<td><a class="cursor_pointer consignee_info" data-url='{url path="orders/admin_order_delivery/consignee_info" args="delivery_id={$delivery.delivery_id}"}' title="{lang key='orders::order.display_consignee_info'}"><span class="ecjiaf-pre ecjiaf-wsn">{$delivery.consignee|escape}</span></a></td>
						<td>{$delivery.update_time}</td>
<!-- 							<td>{$delivery.suppliers_name}</td> -->
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
<!-- {/block} -->