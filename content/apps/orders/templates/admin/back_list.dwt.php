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
					<i class="fontello-icon-cog"></i>{t domain="orders"}批量操作{/t}
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a class="batch-del-btn" data-toggle="ecjiabatch" data-name="back_id" data-idClass=".checkbox:checked" data-url="{$del_action}" data-msg='{t domain="orders"}您确定需要删除这些退货单吗？{/t}' data-noSelectMsg='{t domain="orders"}请选择需要操作的退货单！{/t}' href="javascript:;"><i class="fontello-icon-trash"></i>{t domain="orders"}删除{/t}</a></li>
				</ul>
			</div>
			<div class="choose_list f_r" >
				<input type="text" name="delivery_sn" value="{$filter.delivery_sn}" placeholder='{t domain="orders"}请输入发货单流水号{/t}'/>
				<input type="text" name="keywords" value="{$filter.keywords}" placeholder='{t domain="orders"}请输入订单号或者收货人{/t}'/>
				<button class="btn" type="submit">{t domain="orders"}搜索{/t}</button>
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
					<th>{t domain="orders"}发货单流水号{/t}</th>
					<th>{t domain="orders"}订单号{/t}</th>
					<th>{t domain="orders"}下单时间{/t}</th>
					<th>{t domain="orders"}收货人{/t}</th>
					<th>{t domain="orders"}发货时间{/t}</th>
					<th>{t domain="orders"}退货时间{/t}</th>
					<th>{t domain="orders"}操作人{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$back_list.back item=back key=dkey}-->
				<tr>
					<td valign="top" nowrap="nowrap"><input type="checkbox" class="checkbox" name="back_id[]"  value="{$back.back_id}" /></td>
					<td class="hide-edit-area">
						{$back.delivery_sn}
						<div class="edit-list">
							<a class="data-pjax" href='{url path="orders/admin_order_back/back_info" args="back_id={$back.back_id}"}' title='{t domain="orders"}查看{/t}'>{t domain="orders"}查看{/t}</a>&nbsp;|&nbsp;
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="orders"}您确定需要删除该退货单吗？{/t}' href='{url path="orders/admin_order_back/remove" args="back_id={$back.back_id}"}' title='{t domain="orders"}删除{/t}'>{t domain="orders"}删除{/t}</a>
						</div>
					</td>
					<td><a href='{url path="orders/admin/info" args="order_id={$back.order_id}"}' target="_blank" title='{t domain="orders"}查看订单{/t}'>{$back.order_sn}</a></td>
					<td>{$back.add_time}</td>
					<td><a class="cursor_pointer consignee_info" data-url='{url path="orders/admin_order_back/consignee_info" args="back_id={$back.back_id}"}' title='{t domain="orders"}显示收货人信息{/t}'>{$back.consignee|escape}</a></td>
					<td>{$back.update_time}</td>
					<td>{$back.return_time}</td>
					<td>{$back.action_user}</td>
				</tr>
				<!-- {foreachelse} -->
				<tr><td class="no-records" colspan="8">{t domain="orders"}没有找到任何记录{/t}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$back_list.page} -->
	</div>
</div>
<!-- {/block} -->