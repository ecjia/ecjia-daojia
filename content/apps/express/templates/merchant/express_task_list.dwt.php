<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.mh_express_task.init();
	ecjia.merchant.task_list_fresh.init();
</script>

<style>
.breadCrumb{
	margin:0 0 20px;
}
</style>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header task-heading">
	<h2 class="pull-left">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h2>
	<div class="clearfix">
	</div>
</div>

<div class="modal fade" id="myModal1"></div>

<div class="row row-fluid-new">
	<div class="col-lg-12 express-task">
		<div class="panel">
			<input type="hidden" name="home_url" value="{RC_Uri::home_url()}"/>
			<div class="panel-body panel-body-small">
				<ul class="nav nav-pills pull-left">
					<li class="{if $type eq 'wait_grab'}active{/if}"><a  href='{url path="express/merchant/init" args="type=wait_grab"}{if $platform}&platform=1{/if}'>待派单 <span class="badge badge-info">{if $express_order_count.wait_grab}{$express_order_count.wait_grab}{else}0{/if}</span> </a></li>
					<li class="{if $type eq 'wait_pickup'}active{/if}"><a  href='{url path="express/merchant/wait_pickup" args="type=wait_pickup"}{if $platform}&platform=1{/if}'>待取货 <span class="badge badge-info">{if $express_order_count.wait_pickup}{$express_order_count.wait_pickup}{else}0{/if}</span> </a></li>
					<li class="{if $type eq 'sending'}active{/if}"><a  href='{url path="express/merchant/wait_pickup" args="type=sending"}{if $platform}&platform=1{/if}'>配送中 <span class="badge badge-info">{if $express_order_count.sending}{$express_order_count.sending}{else}0{/if}</span> </a></li>
				</ul>
				
				<div class="pull-right">
					<span class="auto-refresh">
						<span class="numcolor">120</span>秒后自动刷新
					</span><a class="btn btn-primary data-pjax m_l5"  href='{url path="express/merchant/init" args="type=wait_grab"}{if $platform}&platform=1{/if}'>手动刷新</a>
				</div>
			</div>
			
			{if $platform neq 1}
			<div class="panel-body panel-body-smal row-fluid ditpage-rightbar-new editpage-rightbar">
				<div class="left-bar1">
					<div class="left-bar move-mod">
						<div class="foldable-list move-mod-group">
							<div class="accordion-group">
								<div class="accordion-heading">
									<a class="accordion-toggle acc-in move-mod-head"><strong>待派单列表</strong></a>
								</div>
								
								<div class="accordion-body in collapse" style="height:544px;overflow:auto;">
									<!-- {foreach from=$wait_grab_list.list key=key item=wait_grab} -->
										<div class="accordion-inner order-div div{$wait_grab.express_id} {if $key eq 0}order-border-first{else}order-border-other{/if}"  express_id="{$wait_grab.express_id}" express_sn="{$wait_grab.express_sn}" express_start="{$wait_grab.sf_latitude},{$wait_grab.sf_longitude}" express_end="{$wait_grab.latitude},{$wait_grab.longitude}" sf_lng="{$wait_grab.sf_longitude}" sf_lat="{$wait_grab.sf_latitude}" data-url='{url path="express/merchant/get_nearest_exuser"}'>
											<div class="control-group control-group-small border-bottom-line">
												<div class="margin-label">配送单号：{$wait_grab.express_sn}</div>
											</div>
											<div class="control-group control-group-small border-bottom-line">
												<div class="margin-label"><span class="sending"></span><span class="margin-icon">{$wait_grab.to_address}</span></div>
											</div>
											<div class="control-group control-group-small">
												<div class="margin-label">距离：{if $wait_grab.distance}{$wait_grab.distance}&nbsp;m{/if}</div>
											</div>
											<div class="control-group control-group-small">
												<div class="margin-label">下单时间：{$wait_grab.format_add_time}</div>
											</div>
											<div class="control-group control-group-small">
												<div class="margin-label btn-a">
												  	 <a class="btn btn-primary express-order-modal" data-toggle="modal" href="#myModal1" express-id="{$wait_grab.express_id}" express-order-url='{url path="express/merchant/express_order_detail" args="express_id={$wait_grab.express_id}{if $type}&type={$type}{/if}"}'  title="查看详情">查看详情</a>
									    	  	</div>
											</div>
											<input type="hidden" class="nearest_exuser_name" value="{$express_info.name}"/>
											<input type="hidden" class="nearest_exuser_mobile" value="{$express_info.mobile}"/>
											<input type="hidden" class="nearest_exuser_lng" value="{$express_info.longitude}"/>
											<input type="hidden" class="nearest_exuser_lat" value="{$express_info.latitude}"/>
											<input type="hidden" class="hasstaff" value="{$has_staff}"/>
											<input type="hidden" class="order_express_id" value="{$first_express_id}"/>
										</div>
									<!-- {foreachelse} -->
										<div class="norecord">暂无任何记录!</div>
									<!-- {/foreach} -->
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="middle-bar" style="width:50%;margin-left:1%;margin-right:1%;">
					<div class="foldable-list move-mod-group">
						<div class="accordion-group">
							<div class="accordion-heading">
								<!-- {if $express_order_count.wait_grab} -->
								<a class="accordion-toggle acc-in move-mod-head">
									<div class="map-exp-order"><strong>配送单号<span class="mark order">【{$first_express_order.express_sn}】</span>位置</strong><i class="order-map-change cursor_pointer fa fa-expand pull-right "></i></div>
									<div class="map-exp-user"><strong>配送员<span class="mark user">【{$express_info.name}】</span>位置 </strong><i class="user-map-change cursor_pointer fa fa-expand pull-right"></i></div>
								</a>
								<!--{/if} -->
							</div>
							<div class="accordion-body in collapse" >
								{if $express_order_count.wait_grab}
		        					<div id="allmap" style="height:542px;"></div>
		        				{else}
		        					<div style="height:580px;text-align:center;padding-top: 116px;">暂无任何记录!</div>
		        				{/if}
							</div>
						</div>
					</div>
				</div>
				
				<div class="original-user-list">
					<!-- #BeginLibraryItem "/library/waitgrablist_search_user_list.lbi" --><!-- #EndLibraryItem -->
				</div>
				
				<div class="new-user-list">
				</div>
			</div>
			{else}
			<div class="panel-body panel-body-small">
				<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
					<thead>
						<tr>
						  	<th>配送单号</th>
						    <th class="w300">收货人信息</th>
						    <th class="w300">下单时间</th>
						    <th class="w150">配送状态</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$wait_grab_list.list item=val} -->
			 			<tr>
					      	<td class="hide-edit-area">
								{$val.express_sn}
					     	  	<div class="edit-list">
								  	 <a class="express-order-modal" data-toggle="modal" data-backdrop="static" href="#myModal1" express-id="{$val.express_id}" express-order-url='{url path="express/merchant/express_order_detail" args="express_id={$val.express_id}{if $type}&type={$type}{/if}"}'  title="查看详情">查看详情</a>&nbsp;|&nbsp;
								  	 <a class="order-div no-border" data-toggle="modal" 
								  	 data-backdrop="static" href="#view_circuit" 
								  	 express_id="{$val.express_id}" 
								  	 express_sn="{$val.express_sn}" 
								  	 express_start="{$val.sf_latitude},{$val.sf_longitude}" 
								  	 express_end="{$val.latitude},{$val.longitude}" 
								  	 sf_lng="{$val.sf_longitude}" 
								  	 sf_lat="{$val.sf_latitude}" 
								  	 data-url='{url path="express/merchant/get_nearest_exuser"}'
								  	 >
								  	 查看线路</a>&nbsp;|&nbsp;
								  	 <a class="ajaxremove" data-toggle="ajaxremove" data-msg="您确定要提醒平台派单吗？" href='{url path="express/merchant/remind_assign"}&id={$val.express_id}'>提醒派单</a>
					    	  	</div>
					      	</td>
					      	<td>{$val.consignee}<br>地址：{$val.to_address}</td>
					      	<td>{$val.format_add_time}</td>
					      	<td class="ecjiafc-red">{if $type eq 'wait_grab'}待派单{elseif $type eq 'wait_pickup'}待取货{elseif $type eq 'sending'}配送中{/if}</td>
					    </tr>
					    <!-- {foreachelse} -->
	        			<tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$wait_grab_list.page} -->
			</div>
			<div class="hide">
			<!-- #BeginLibraryItem "/library/waitgrablist_search_user_list.lbi" --><!-- #EndLibraryItem -->
			</div>
			{/if}
		</div>
	</div>
</div>

<div class="modal fade" id="view_circuit">
	<div class="modal-dialog">
	    <div class="modal-content">
	        <div class="modal-header">
	            <button data-dismiss="modal" class="close" type="button">×</button>
	            <h4 class="modal-title">查看线路</h4>
	        </div>
	        <div class="modal-body">
				<div class="middle-bar" style="width:98%;margin-left:1%;margin-right:1%;">
					<div class="foldable-list move-mod-group">
						<div class="accordion-group">
							<div class="accordion-body in collapse" >
			        			<div id="allmap" style="height:542px;"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
	    </div>
	</div>
</div>
<!-- {/block} -->