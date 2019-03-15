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
	                <li>{t domain="express"}营业时间：{/t}<span>{$store_info.shop_trade_time.start}-{$store_info.shop_trade_time.end}</span></li>
	                <li>{t domain="express"}商家电话：{/t}<span>{$store_info.shop_kf_mobile}</span></li>
	                <li>{t domain="express"}商家地址：{/t}<span>{$store_info.merchants_all_address}</span></li>
            	</ul>
         	</div>
         	
          </div>
     </div>		
</div>

<div class="row-fluid batch" >
	<ul class="nav nav-pills">
		<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="express/admin_merchant/detail" args="store_id={$store_id}"}'>{t domain="express"}全部{/t} <span class="badge badge-info">{if $order_list.count.count}{$order_list.count.count}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'wait_grab'}active{/if}"><a class="data-pjax" href='{url path="express/admin_merchant/detail" args="store_id={$store_id}&type=wait_grab"}'>{t domain="express"}待抢单{/t} <span class="badge badge-info">{if $order_list.count.no}{$order_list.count.no}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'wait_pickup'}active{/if}"><a class="data-pjax" href='{url path="express/admin_merchant/detail" args="store_id={$store_id}&type=wait_pickup"}'>{t domain="express"}待取货{/t} <span class="badge badge-info">{if $order_list.count.ok}{$order_list.count.ok}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'delivery'}active{/if}"><a class="data-pjax" href='{url path="express/admin_merchant/detail" args="store_id={$store_id}&type=delivery"}'>{t domain="express"}配送中{/t} <span class="badge badge-info">{if $order_list.count.ing}{$order_list.count.ing}{else}0{/if}</span> </a></li>
	</ul>
</div>

	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="w150">{t domain="express"}配送单号{/t}</th>
				   	<!--  {if $type eq 'wait_pickup' or $type eq 'delivery'} -->
				   	<th class="w50">{t domain="express"}配送员{/t}</th>
				    <!-- {/if} -->
				    <th class="w150">{t domain="express"}收货人信息{/t}</th>
				    <th class="w250">{t domain="express"}收货地址{/t}</th>
				    <th class="w150">{t domain="express"}下单时间{/t}</th>
				    <th class="w100">{t domain="express"}配送费用{/t}</th>
				    <th class="w100">{t domain="express"}订单状态{/t}</th>
			  	</tr>
			</thead>
			<!-- {foreach from=$order_list.list item=express} -->
		    <tr>
		      	<td class="hide-edit-area">
					{$express.express_sn}
		     	  	<div class="edit-list">
					  	 <a data-toggle="modal" data-backdrop="static" href="#myModal1" express-id="{$express.express_id}" express-url="{$express_detail}"  title='{t domain="express"}查看详情{/t}'>{t domain="express"}查看详情{/t}</a>
		    	  	</div>
		      	</td>
		      	<!--  {if $type eq 'wait_pickup' or $type eq 'delivery'} -->
		      	<td>{$express.express_user}<br>[TEL:{$express.express_mobile}]</td>
		      	<!-- {/if} -->
		      	<td>{$express.consignee}<br>[TEL:{$express.mobile}]</td>
		      	<td>{$express.consignee_address}</td>
		      	<td>{$express.add_time}</td>
		      	<td>¥ {$express.commision}</td>
		      	<td>{if $express.status eq 0}<font class="ecjiafc-red">{t domain="express"}待抢单{/t}</font>{elseif $express.status eq 1}<font class="ecjiafc-red">{t domain="express"}待取货{/t}</font>{elseif $express.status eq 2}<font class="ecjiafc-red">{t domain="express"}配送中{/t}</font>{elseif $express.status eq 3}{t domain="express"}退货中{/t}{elseif $express.status eq 4}{t domain="express"}已拒收{/t}{elseif $express.status eq 5}{t domain="express"}已完成{/t}{else}{t domain="express"}已退回{/t}{/if}</td>
		    </tr>
		    <!-- {foreachelse} -->
	        <tr><td class="no-records" colspan="6">{t domain="express"}没有找到任何记录{/t}</td></tr>
			<!-- {/foreach} -->
            </tbody>
         </table>
         <!-- {$order_list.page} -->
	</div>
</div>
<!-- {/block} -->