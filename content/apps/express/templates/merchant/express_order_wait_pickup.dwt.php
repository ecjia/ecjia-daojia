<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.mh_express_order_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->


<div class="page-header">
	<h2 class="pull-left">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h2>
	<div class="clearfix">
	</div>
</div>

<input type="hidden" name="home_url" value="{RC_Uri::home_url()}"/>

<div id="myModal1" class="modal order-detail fade" ></div>

<div id="myModal2" class="modal express-reassign-modal fade"></div>
 
<div id="myModal3" class="modal express-location-modal fade"></div>


<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<ul class="nav nav-pills pull-left">
					<li class="{if $type eq 'wait_grab'}active{/if}"><a class="data-pjax" href='{url path="express/merchant/init" args="type=wait_grab"}{if $platform}&platform=1{/if}'>{t domain="express"}待派单{/t} <span class="badge badge-info">{if $express_order_count.wait_grab}{$express_order_count.wait_grab}{else}0{/if}</span> </a></li>
					<li class="{if $type eq 'wait_pickup'}active{/if}"><a class="data-pjax" href='{url path="express/merchant/wait_pickup" args="type=wait_pickup{if $platform}&platform=1{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="express"}待取货{/t} <span class="badge badge-info">{if $express_order_count.wait_pickup}{$express_order_count.wait_pickup}{else}0{/if}</span> </a></li>
					<li class="{if $type eq 'sending'}active{/if}"><a class="data-pjax" href='{url path="express/merchant/wait_pickup" args="type=sending{if $platform}&platform=1{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}"}'>{t domain="express"}配送中{/t} <span class="badge badge-info">{if $express_order_count.sending}{$express_order_count.sending}{else}0{/if}</span> </a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			
			<div class="panel-body panel-body-small">
				<form class="form-inline" method="post" action="{$search_action}{if $filter.type}&type={$filter.type}{/if}{if $platform}&platform=1{/if}" name="searchForm">
					<div class="f_r form-group">
						<input type="text" name="keywords" class="form-control" style="width:200px;" value="{$smarty.get.keywords}" placeholder='{t domain="express"}请输入配送员名或配送单号{/t}'/>
						<button class="btn btn-primary search_express_order" type="submit">{t domain="express"}搜索{/t}</button>
					</div>
				</form>
			</div>
			
			
			<div class="panel-body panel-body-small">
				<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
					<thead>
						<tr>
						  	<th class="w200">{t domain="express"}配送单号{/t}</th>
						    <th class="w200">{t domain="express"}配送员{/t}</th>
						    <th >{t domain="express"}收货人信息{/t}</th>
						    <th class="w100">{t domain="express"}任务类型{/t}</th>
						    <th class="w200">{t domain="express"}接单时间{/t}</th>
						    <th class="w100">{t domain="express"}配送状态{/t}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$wait_pickup_list.list item=wait_pickup} -->
			 			<tr>
					      	<td class="hide-edit-area">
								{$wait_pickup.express_sn}
					     	  	<div class="edit-list">
								  	 <a class="express-order-modal" data-toggle="modal" data-backdrop="static" href="#myModal1" express-id="{$wait_pickup.express_id}" express-order-url='{url path="express/merchant/express_order_detail" args="express_id={$wait_pickup.express_id}{if $platform eq 1}&platform=1{/if}{if $type}&type={$type}{/if}"}'  title='{t domain="express"}查看详情{/t}'>{t domain="express"}查看详情{/t}</a>
								  	 {if $platform eq 1 && $wait_pickup.online_status eq '1'}
								  	 	&nbsp;|&nbsp;<a class="express-location" data-toggle="modal" data-backdrop="static" href="#myModal3" express-id="{$wait_pickup.express_id}" express-location-url='{url path="express/merchant/express_location" args="express_id={$wait_pickup.express_id}&store_id={$wait_pickup.store_id}{if $type}&type={$type}{/if}"}'  title='{t domain="express"}查看路线{/t}'>{t domain="express"}查看路线{/t}</a>
								  	 {else}
								  		{if $type eq 'wait_pickup'}&nbsp;|&nbsp;<a class="express-reassign-click" data-toggle="modal" data-backdrop="static" href="#myModal2" express-id="{$wait_pickup.express_id}" express-reassign-url='{url path="express/merchant/express_reasign_detail" args="express_id={$wait_pickup.express_id}&store_id={$wait_pickup.store_id}{if $type}&type={$type}{/if}"}'  title='{t domain="express"}重新指派{/t}'>{t domain="express"}重新指派{/t}</a>{/if}
								  	 	{if $wait_pickup.online_status eq '1'}&nbsp;|&nbsp;<a class="express-location" data-toggle="modal" data-backdrop="static" href="#myModal3" express-id="{$wait_pickup.express_id}" express-location-url='{url path="express/merchant/express_location" args="express_id={$wait_pickup.express_id}&store_id={$wait_pickup.store_id}{if $type}&type={$type}{/if}"}'  title='{t domain="express"}当前位置{/t}'>{t domain="express"}当前位置{/t}</a>{/if}
								  	 {/if}
								</div>
					      	</td>
					      	<td>{$wait_pickup.express_user}</td>
					      	<td>{$wait_pickup.consignee}<br>{t domain="express"}地址：{/t}{$wait_pickup.to_address}</td>
					      	<td>{if $wait_pickup.from eq 'assign'}{t domain="express"}派单{/t}{else}{t domain="express"}抢单{/t}{/if}</td>
					      	<td>{$wait_pickup.format_receive_time}</td>
					      	<td class="ecjiafc-red">{if $type eq 'wait_pickup'}{t domain="express"}待取货{/t}{elseif $type eq 'sending'}{t domain="express"}配送中{/t}{/if}</td>
					    </tr>
					    <!-- {foreachelse} -->
	        			<tr><td class="no-records" colspan="6">{t domain="express"}没有找到任何记录{/t}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$wait_pickup_list.page} -->
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->