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
		<li class="{if $type eq 'wait_grab'}active{/if}"><a class="data-pjax" href='{url path="express/admin/init" args="type=wait_grab"}'>{t domain="express"}待抢单{/t} <span class="badge badge-info">{if $express_order_count.wait_grab}{$express_order_count.wait_grab}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'wait_pickup'}active{/if}"><a class="data-pjax" href='{url path="express/admin/wait_pickup" args="type=wait_pickup{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="express"}待取货{/t} <span class="badge badge-info">{if $express_order_count.wait_pickup}{$express_order_count.wait_pickup}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'sending'}active{/if}"><a class="data-pjax" href='{url path="express/admin/wait_pickup" args="type=sending{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="express"}配送中{/t} <span class="badge badge-info">{if $express_order_count.sending}{$express_order_count.sending}{else}0{/if}</span> </a></li>
		<form method="post" action="{$search_action}{if $type}&type={$type}{/if}" name="searchForm">
			<div class="choose_list f_r">
				<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="express"}请输入配送员名称或配送单号{/t}'/>
				<button class="btn search_express_order" type="submit">{t domain="express"}搜索{/t}</button>
			</div>
		</form>
	</ul>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="w250">{t domain="express"}配送单号{/t}</th>
				    <th class="w150">{t domain="express"}配送员{/t}</th>
				    <th class="w150">{t domain="express"}收货人信息{/t}</th>
				    <th class="w500">{t domain="express"}取/送货地址{/t}</th>
				    <th class="w100">{t domain="express"}任务类型{/t}</th>
				    <th class="w200">{t domain="express"}接单时间{/t}</th>
				    <th class="w100">{t domain="express"}配送状态{/t}</th>
			  	</tr>
			</thead>
			<!-- {foreach from=$wait_pickup_list.list item=wait_pickup} -->
		    <tr>
		      	<td class="hide-edit-area">
					{$wait_pickup.express_sn}
		     	  	<div class="edit-list">
					  	 <a  class="express-order-modal" data-toggle="modal" data-backdrop="static" href="#myModal1" express-id="{$wait_pickup.express_id}" express-order-url='{url path="express/admin/express_order_detail" args="express_id={$wait_pickup.express_id}{if $type}&type={$type}{/if}"}'  title='{t domain="express"}查看详情{/t}'>{t domain="express"}查看详情{/t}</a>
					  	 {if $type eq 'wait_pickup'}&nbsp;|&nbsp;<a class="express-reassign-click" data-toggle="modal" data-backdrop="static" href="#myModal2" express-id="{$wait_pickup.express_id}" express-reassign-url='{url path="express/admin/express_reasign_detail" args="express_id={$wait_pickup.express_id}&store_id={$wait_pickup.store_id}{if $type}&type={$type}{/if}"}'  title='{t domain="express"}重新指派{/t}'>{t domain="express"}重新指派{/t}</a>{/if}
					  	 {if $wait_pickup.online_status eq '1'}&nbsp;|&nbsp;<a class="express-location" data-toggle="modal" data-backdrop="static" href="#myModal3" express-id="{$wait_pickup.express_id}" express-location-url='{url path="express/admin/express_location" args="express_id={$wait_pickup.express_id}&store_id={$wait_pickup.store_id}{if $type}&type={$type}{/if}"}'  title='{t domain="express"}当前位置{/t}'>{t domain="express"}当前位置{/t}</a>{/if}
		    	  	</div>
		      	</td>
		      	<td>{$wait_pickup.express_user}</td>
		      	<td>{$wait_pickup.consignee}</td>
		      	<td>{t domain="express"}取：{/t}{$wait_pickup.from_address}<br>
                    {t domain="express"}送：{/t}{$wait_pickup.to_address}
		      	</td>
		      	<td>{if $wait_pickup.from eq 'assign'}{t domain="express"}派单{/t}{else}{t domain="express"}抢单{/t}{/if}</td>
		      	<td>{$wait_pickup.format_receive_time}</td>
		      	<td>{if $type eq 'wait_pickup'}{t domain="express"}待取货{/t}{elseif $type eq 'sending'}{t domain="express"}配送中{/t}{/if}</td>
		    </tr>
		    <!-- {foreachelse} -->
	        <tr><td class="no-records" colspan="7">{t domain="express"}没有找到任何记录{/t}</td></tr>
			<!-- {/foreach} -->
            </tbody>
         </table>
         <!-- {$wait_pickup_list.page} -->
	</div>
</div>
<!-- {/block} -->