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
					<li class="{if $type eq 'wait_grab'}active{/if}"><a  href='{url path="express/merchant/init" args="type=wait_grab"}{if $platform}&platform=1{/if}'>{t domain="express"}待派单{/t} <span class="badge badge-info">{if $express_order_count.wait_grab}{$express_order_count.wait_grab}{else}0{/if}</span> </a></li>
					<li class="{if $type eq 'wait_pickup'}active{/if}"><a  href='{url path="express/merchant/wait_pickup" args="type=wait_pickup"}{if $platform}&platform=1{/if}'>{t domain="express"}待取货{/t} <span class="badge badge-info">{if $express_order_count.wait_pickup}{$express_order_count.wait_pickup}{else}0{/if}</span> </a></li>
					<li class="{if $type eq 'sending'}active{/if}"><a  href='{url path="express/merchant/wait_pickup" args="type=sending"}{if $platform}&platform=1{/if}'>{t domain="express"}配送中{/t} <span class="badge badge-info">{if $express_order_count.sending}{$express_order_count.sending}{else}0{/if}</span> </a></li>
				</ul>
				
				<div class="pull-right">
					<span class="auto-refresh">
						<span class="numcolor">120</span>{t domain="express"}秒后自动刷新{/t}
					</span><a class="btn btn-primary data-pjax m_l5"  href='{url path="express/merchant/init" args="type=wait_grab"}{if $platform}&platform=1{/if}'>{t domain="express"}手动刷新{/t}</a>
				</div>
			</div>
			
			{if $platform neq 1}
			<div class="panel-body panel-body-smal row-fluid ditpage-rightbar-new editpage-rightbar">
				<div class="left-bar1">
					<div class="left-bar move-mod">
						<div class="foldable-list move-mod-group">
							<div class="accordion-group">
								<div class="accordion-heading">
									<a class="accordion-toggle acc-in move-mod-head"><strong>{t domain="express"}待派单列表{/t}</strong></a>
								</div>
								
								<div class="accordion-body in collapse" style="height:544px;overflow:auto;">
									<!-- {foreach from=$wait_grab_list.list key=key item=wait_grab} -->
										<div class="accordion-inner order-div div{$wait_grab.express_id} {if $key eq 0}order-border-first{else}order-border-other{/if}"  express_id="{$wait_grab.express_id}" express_sn="{$wait_grab.express_sn}" express_start="{$wait_grab.sf_latitude},{$wait_grab.sf_longitude}" express_end="{$wait_grab.latitude},{$wait_grab.longitude}" sf_lng="{$wait_grab.sf_longitude}" sf_lat="{$wait_grab.sf_latitude}" data-url='{url path="express/merchant/get_nearest_exuser"}'>
											<div class="control-group control-group-small border-bottom-line">
												<div class="margin-label">{t domain="express"}配送单号：{/t}{$wait_grab.express_sn}</div>
											</div>
											<div class="control-group control-group-small border-bottom-line">
												<div class="margin-label"><span class="sending"></span><span class="margin-icon">{$wait_grab.to_address}</span></div>
											</div>
											<div class="control-group control-group-small">
												<div class="margin-label">{t domain="express"}距离：{/t}{if $wait_grab.distance}{$wait_grab.distance}&nbsp;m{/if}</div>
											</div>
											<div class="control-group control-group-small">
												<div class="margin-label">{t domain="express"}下单时间：{/t}{$wait_grab.format_add_time}</div>
											</div>
											<div class="control-group control-group-small">
												<div class="margin-label btn-a">
												  	 <a class="btn btn-primary express-order-modal" data-toggle="modal" href="#myModal1" express-id="{$wait_grab.express_id}" express-order-url='{url path="express/merchant/express_order_detail" args="express_id={$wait_grab.express_id}{if $type}&type={$type}{/if}"}'  title='{t domain="express"}查看详情{/t}'>{t domain="express"}查看详情{/t}</a>
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
										<div class="norecord">{t domain="express"}暂无任何记录!{/t}</div>
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
									<div class="map-exp-order"><strong>{t domain="express"}配送单号{/t}<span class="mark order">【{$first_express_order.express_sn}】</span>{t domain="express"}位置{/t}</strong><i class="order-map-change cursor_pointer fa fa-expand pull-right "></i></div>
									<div class="map-exp-user"><strong>{t domain="express"}配送员{/t}<span class="mark user">【{$express_info.name}】</span>{t domain="express"}位置{/t} </strong><i class="user-map-change cursor_pointer fa fa-expand pull-right"></i></div>
								</a>
								<!--{/if} -->
							</div>
							<div class="accordion-body in collapse" >
								{if $express_order_count.wait_grab}
		        					<div id="allmap" style="height:542px;"></div>
		        				{else}
		        					<div style="height:580px;text-align:center;padding-top: 116px;">{t domain="express"}暂无任何记录!{/t}</div>
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
						  	<th>{t domain="express"}配送单号{/t}</th>
						    <th class="w300">{t domain="express"}收货人信息{/t}</th>
						    <th class="w300">{t domain="express"}下单时间{/t}</th>
						    <th class="w150">{t domain="express"}配送状态{/t}</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$wait_grab_list.list item=val} -->
			 			<tr>
					      	<td class="hide-edit-area">
								{$val.express_sn}
					     	  	<div class="edit-list">
								  	 <a class="express-order-modal" data-toggle="modal" data-backdrop="static" href="#myModal1" express-id="{$val.express_id}" express-order-url='{url path="express/merchant/express_order_detail" args="express_id={$val.express_id}{if $type}&type={$type}{/if}"}'  title='{t domain="express"}查看详情{/t}'>{t domain="express"}查看详情{/t}</a>&nbsp;|&nbsp;
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
                                         {t domain="express"}查看线路{/t}</a>&nbsp;|&nbsp;
								  	 <a class="ajaxremove" data-toggle="ajaxremove" data-msg='{t domain="express"}您确定要提醒平台派单吗？{/t}' href='{url path="express/merchant/remind_assign"}&id={$val.express_id}'>{t domain="express"}提醒派单{/t}</a>
					    	  	</div>
					      	</td>
					      	<td>{$val.consignee}<br>{t domain="express"}地址：{/t}{$val.to_address}</td>
					      	<td>{$val.format_add_time}</td>
					      	<td class="ecjiafc-red">{if $type eq 'wait_grab'}{t domain="express"}待派单{/t}{elseif $type eq 'wait_pickup'}{t domain="express"}待取货{/t}{elseif $type eq 'sending'}{t domain="express"}配送中{/t}{/if}</td>
					    </tr>
					    <!-- {foreachelse} -->
	        			<tr><td class="no-records" colspan="6">{t domain="express"}没有找到任何记录{/t}</td></tr>
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
	            <h4 class="modal-title">{t domain="express"}查看线路{/t}</h4>
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