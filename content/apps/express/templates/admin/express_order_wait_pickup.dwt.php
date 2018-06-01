<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_express_order_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"  id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="wait-grab-order-detail">
	<div class="modal order-detail hide fade" id="myModal1" style="height:590px;"></div>
</div>

<div class="assign-order-detail">
	<div class="modal express-reassign-modal hide fade" id="myModal2" style="height:590px;"></div>
</div>
 
<div class="currnt-location-detail">
	<div class="modal express-location-modal hide fade" id="myModal3"></div>
</div>

<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<ul class="nav nav-pills" style="margin-bottom:5px;">
		<li class="{if $type eq 'wait_grab'}active{/if}"><a class="data-pjax" href='{url path="express/admin/init" args="type=wait_grab"}'>待抢单 <span class="badge badge-info">{if $express_order_count.wait_grab}{$express_order_count.wait_grab}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'wait_pickup'}active{/if}"><a class="data-pjax" href='{url path="express/admin/wait_pickup" args="type=wait_pickup{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>待取货 <span class="badge badge-info">{if $express_order_count.wait_pickup}{$express_order_count.wait_pickup}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'sending'}active{/if}"><a class="data-pjax" href='{url path="express/admin/wait_pickup" args="type=sending{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>配送中 <span class="badge badge-info">{if $express_order_count.sending}{$express_order_count.sending}{else}0{/if}</span> </a></li>
		<form method="post" action="{$search_action}{if $type}&type={$type}{/if}" name="searchForm">
			<div class="choose_list f_r">
				<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入配送员名称或配送单号"/> 
				<button class="btn search_express_order" type="submit">搜索</button>
			</div>
		</form>
	</ul>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="w250">配送单号</th>
				    <th class="w150">配送员</th>
				    <th class="w150">收货人信息</th>
				    <th class="w500">取/送货地址</th>
				    <th class="w100">任务类型</th>
				    <th class="w200">接单时间</th>
				    <th class="w100">配送状态</th>
			  	</tr>
			</thead>
			<!-- {foreach from=$wait_pickup_list.list item=wait_pickup} -->
		    <tr>
		      	<td class="hide-edit-area">
					{$wait_pickup.express_sn}
		     	  	<div class="edit-list">
					  	 <a  class="express-order-modal" data-toggle="modal" data-backdrop="static" href="#myModal1" express-id="{$wait_pickup.express_id}" express-order-url='{url path="express/admin/express_order_detail" args="express_id={$wait_pickup.express_id}{if $type}&type={$type}{/if}"}'  title="查看详情">查看详情</a>
					  	 {if $type eq 'wait_pickup'}&nbsp;|&nbsp;<a class="express-reassign-click" data-toggle="modal" data-backdrop="static" href="#myModal2" express-id="{$wait_pickup.express_id}" express-reassign-url='{url path="express/admin/express_reasign_detail" args="express_id={$wait_pickup.express_id}&store_id={$wait_pickup.store_id}{if $type}&type={$type}{/if}"}'  title="重新指派">重新指派</a>{/if}
					  	 {if $wait_pickup.online_status eq '1'}&nbsp;|&nbsp;<a class="express-location" data-toggle="modal" data-backdrop="static" href="#myModal3" express-id="{$wait_pickup.express_id}" express-location-url='{url path="express/admin/express_location" args="express_id={$wait_pickup.express_id}&store_id={$wait_pickup.store_id}{if $type}&type={$type}{/if}"}'  title="当前位置">当前位置</a>{/if}
		    	  	</div>
		      	</td>
		      	<td>{$wait_pickup.express_user}</td>
		      	<td>{$wait_pickup.consignee}</td>
		      	<td>取：{$wait_pickup.from_address}<br>
					送：{$wait_pickup.to_address}
		      	</td>
		      	<td>{if $wait_pickup.from eq 'assign'}派单{else}抢单{/if}</td>
		      	<td>{$wait_pickup.format_receive_time}</td>
		      	<td>{if $type eq 'wait_pickup'}待取货{elseif $type eq 'sending'}配送中{/if}</td>
		    </tr>
		    <!-- {foreachelse} -->
	        <tr><td class="no-records" colspan="7">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
            </tbody>
         </table>
         <!-- {$wait_pickup_list.page} -->
	</div>
</div>
<!-- {/block} -->