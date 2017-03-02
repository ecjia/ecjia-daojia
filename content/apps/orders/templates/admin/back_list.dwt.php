<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.order_delivery.back_init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
			<a class="btn data-pjax plus_or_reply" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<!-- #BeginLibraryItem "/library/order_consignee.lbi" --><!-- #EndLibraryItem -->
<div class="row-fluid">
	<div class="choose_list span12">
		<form action="{$form_action}" name="searchForm" method="post">
			<div class="btn-group f_l m_r5">
				<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
					<i class="fontello-icon-cog"></i>{lang key='orders::order.bulk_operations'}
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a class="batch-del-btn" data-toggle="ecjiabatch" data-name="back_id" data-idClass=".checkbox:checked" data-url="{$del_action}" data-msg="{lang key='orders::order.confirm_delete'}" data-noSelectMsg="{lang key='orders::order.pls_select_retun'}" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='system::system.remove'}</a></li>
				</ul>
			</div>
			<div class="choose_list f_r" >
				<input type="text" name="delivery_sn" value="{$filter.delivery_sn}" placeholder="{lang key='orders::order.pls_delivery_sn_number'}"/>
				<input type="text" name="keywords" value="{$filter.keywords}" placeholder="{lang key='orders::order.pls_consignee'}"/>
				<button class="btn" type="submit">{lang key='orders::order.search'}</button>
			</div>
		</form>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped table-hide-edit">
			<thead>
				<tr>
					<th class="table_checkbox"><input type="checkbox" data-toggle="selectall" data-children=".checkbox"/></th>
					<th>{lang key='orders::order.label_delivery_sn'}</th>
					<th>{lang key='orders::order.order_sn'}</th>
					<th>{lang key='orders::order.label_add_time'}</th>
					<th>{lang key='orders::order.consignee'}</th>
					<th>{lang key='orders::order.label_update_time'}</th>
					<th>{lang key='orders::order.label_return_time'}</th>
					<th>{lang key='system::system.operator'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$back_list.back item=back key=dkey}-->
				<tr>
					<td valign="top" nowrap="nowrap"><input type="checkbox" class="checkbox" name="back_id[]"  value="{$back.back_id}" /></td>
					<td class="hide-edit-area">
						{$back.delivery_sn}
						<div class="edit-list">
							<a class="data-pjax" href='{url path="orders/admin_order_back/back_info" args="back_id={$back.back_id}"}' title="{lang key='orders::order.detail'}">{lang key='orders::order.detail'}</a>&nbsp;|&nbsp;
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='orders::order.confirm_delete_one'}" href='{url path="orders/admin_order_back/remove" args="back_id={$back.back_id}"}' title="{lang key='orders::order.op_remove'}">{lang key='orders::order.op_remove'}</a>
						</div>
					</td>
					<td><a href='{url path="orders/admin/info" args="order_id={$back.order_id}"}' target="_blank" title="{lang key='orders::order.look_order'}">{$back.order_sn}</a></td>
					<td>{$back.add_time}</td>
					<td><a class="cursor_pointer consignee_info" data-url='{url path="orders/admin_order_back/consignee_info" args="back_id={$back.back_id}"}' title="{lang key='orders::order.display_consignee_info'}">{$back.consignee|escape}</a></td>
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
<!-- {/block} -->