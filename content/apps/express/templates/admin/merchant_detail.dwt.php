<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.merchant_list.init();
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

<div class="modal hide fade" id="myModal1" style="height:650px;"></div>

<div class="row-fluid">
     <div class="span12">
         <div class="store_detail">
         	<div class="span2">
				<img src="{if $store_info.img}{RC_Upload::upload_url()}/{$store_info.img}{else}{RC_Uri::admin_url('statics/images/nopic.png')}{/if}">
			</div>
         	
         	<div class="span10">
         	   	<ul>
	             	<li><strong>{$store_info.merchants_name}</strong></li>
	                <li>营业时间：<span>{$store_info.shop_trade_time.start}-{$store_info.shop_trade_time.end}</span></li>
	                <li>商家电话：<span>{$store_info.shop_kf_mobile}</span></li>
	                <li>商家地址：<span>{$store_info.merchants_all_address}</span></li>
            	</ul>
         	</div>
         	
          </div>
     </div>		
</div>

<div class="row-fluid batch" >
	<ul class="nav nav-pills">
		<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="express/admin_merchant/detail" args="store_id={$store_id}"}'>全部 <span class="badge badge-info">{if $order_list.count.count}{$order_list.count.count}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'wait_grab'}active{/if}"><a class="data-pjax" href='{url path="express/admin_merchant/detail" args="store_id={$store_id}&type=wait_grab"}'>待抢单 <span class="badge badge-info">{if $order_list.count.no}{$order_list.count.no}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'wait_pickup'}active{/if}"><a class="data-pjax" href='{url path="express/admin_merchant/detail" args="store_id={$store_id}&type=wait_pickup"}'>待取货 <span class="badge badge-info">{if $order_list.count.ok}{$order_list.count.ok}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'delivery'}active{/if}"><a class="data-pjax" href='{url path="express/admin_merchant/detail" args="store_id={$store_id}&type=delivery"}'>配送中 <span class="badge badge-info">{if $order_list.count.ing}{$order_list.count.ing}{else}0{/if}</span> </a></li>
	</ul>
</div>

	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="w150">配送单号</th>
				   	<!--  {if $type eq 'wait_pickup' or $type eq 'delivery'} -->
				   	<th class="w50">配送员</th>
				    <!-- {/if} -->
				    <th class="w150">收货人信息</th>
				    <th class="w250">收货地址</th>
				    <th class="w150">下单时间</th>
				    <th class="w100">配送费用</th>
				    <th class="w100">订单状态</th>
			  	</tr>
			</thead>
			<!-- {foreach from=$order_list.list item=express} -->
		    <tr>
		      	<td class="hide-edit-area">
					{$express.express_sn}
		     	  	<div class="edit-list">
					  	 <a data-toggle="modal" data-backdrop="static" href="#myModal1" express-id="{$express.express_id}" express-url="{$express_detail}"  title="查看详情">查看详情</a>
		    	  	</div>
		      	</td>
		      	<!--  {if $type eq 'wait_pickup' or $type eq 'delivery'} -->
		      	<td>{$express.express_user}<br>[TEL:{$express.express_mobile}]</td>
		      	<!-- {/if} -->
		      	<td>{$express.consignee}<br>[TEL:{$express.mobile}]</td>
		      	<td>{$express.consignee_address}</td>
		      	<td>{$express.add_time}</td>
		      	<td>¥ {$express.commision}</td>
		      	<td>{if $express.status eq 0}<font class="ecjiafc-red">待抢单</font>{elseif $express.status eq 1}<font class="ecjiafc-red">待取货</font>{elseif $express.status eq 2}<font class="ecjiafc-red">配送中</font>{elseif $express.status eq 3}退货中{elseif $express.status eq 4}已拒收{elseif $express.status eq 5}已完成{else}已退回{/if}</td>
		    </tr>
		    <!-- {foreachelse} -->
	        <tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
            </tbody>
         </table>
         <!-- {$order_list.page} -->
	</div>
</div>
<!-- {/block} -->