<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_express_task.init();
	ecjia.admin.task_list_fresh.init();
</script>

<style>
.breadCrumb{
	margin:0 0 20px;
}
</style>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<div class="task-heading">
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<a class="btn plus_or_reply sidebar-ckeck " key="0" href="javascript:;"  id="sticky_a">{t domain="express"}全屏查看{/t}</a>
	</h3>
</div>

<div class="wait-grab-order-detail">
	<div class="modal hide fade" id="myModal1" style="height:590px;"></div>
</div>


<!-- 批量操作和搜索 -->
<div class="row-fluid batch">
	<ul class="nav nav-pills " style="margin-bottom:5px;">
		<li class="{if $type eq 'wait_grab'}active{/if}"><a  href='{url path="express/admin/init" args="type=wait_grab"}'>{t domain="express"}待抢单{/t} <span class="badge badge-info">{if $express_order_count.wait_grab}{$express_order_count.wait_grab}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'wait_pickup'}active{/if}"><a  href='{url path="express/admin/wait_pickup" args="type=wait_pickup"}'>{t domain="express"}待取货{/t} <span class="badge badge-info">{if $express_order_count.wait_pickup}{$express_order_count.wait_pickup}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'sending'}active{/if}"><a  href='{url path="express/admin/wait_pickup" args="type=sending"}'>{t domain="express"}配送中{/t} <span class="badge badge-info">{if $express_order_count.sending}{$express_order_count.sending}{else}0{/if}</span> </a></li>
		<form class="f_r form-inline" action='' method="post" name="">
			<span class="auto-refresh">
				<span class="numcolor">120</span>{t domain="express"}秒后自动刷新{/t}
			</span><a class="btn btn btn-gebo data-pjax"  href='{url path="express/admin/init" args="type=wait_grab"}'>{t domain="express"}手动刷新{/t}</a>
		</form>
	</ul>
</div>

<div class="row-fluid row-fluid-new">
	<div class="span12 express-task">
		<div class="row-fluid ditpage-rightbar-new editpage-rightbar">
			<div class="left-bar1">
				<div class="left-bar move-mod">
					<div class="foldable-list move-mod-group">
						<div class="accordion-group">
							<div class="accordion-heading">
								<a class="accordion-toggle acc-in move-mod-head"><strong>{t domain="express"}待抢单列表{/t}</strong></a>
							</div>
							<div class="accordion-body in collapse" style="height:547px;overflow:auto;">
								<!-- {foreach from=$wait_grab_list.list key=key item=wait_grab} -->
									<div class="accordion-inner order-div div{$wait_grab.express_id} {if $key eq 0}order-border-first{else}order-border-other{/if}" express_id="{$wait_grab.express_id}" express_sn="{$wait_grab.express_sn}" express_start="{$wait_grab.sf_latitude},{$wait_grab.sf_longitude}" express_end="{$wait_grab.latitude},{$wait_grab.longitude}" sf_lng="{$wait_grab.sf_longitude}" sf_lat="{$wait_grab.sf_latitude}" data-url='{url path="express/admin/get_nearest_exuser"}'>
										<div class="control-group control-group-small border-bottom-line">
											<div class="margin-label">{t domain="express"}配送单号：{/t}{$wait_grab.express_sn}</div>
										</div>
										<div class="control-group control-group-small">
											<div class="margin-label"><span class="takeing"></span><span class="margin-icon">{$wait_grab.from_address}</span></div>
										</div>
										<div class="control-group control-group-small border-bottom-line">
											<div class="margin-label"><span class="sending"></span><span class="margin-icon">{$wait_grab.to_address}</span></div>
										</div>
										<div class="control-group control-group-small">
											<div class="margin-label">{t domain="express"}距离：{/t}{if $wait_grab.distance}{$wait_grab.distance}&nbsp;m{/if}</div>
										</div>
										<div class="control-group control-group-small">
											<div class="margin-label">{t domain="express"}下单时间：{/t}{$wait_grab.format_order_add_time}</div>
										</div>
										<div class="control-group control-group-s>mall">
											<div class="margin-label btn-a">
											  	 <a class="btn btn-gebo express-order-modal" data-toggle="modal" href="#myModal1" express-id="{$wait_grab.express_id}" express-order-url='{url path="express/admin/express_order_detail" args="express_id={$wait_grab.express_id}{if $type}&type={$type}{/if}"}'  title='{t domain="express"}查看详情{/t}'>{t domain="express"}查看详情{/t}</a>
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
			<div class="middle-bar">
			{if $express_order_count.wait_grab}
        		<div class="foldable-list move-mod-group">
					<div class="accordion-group">
						<div class="accordion-heading">
							<!-- {if $express_order_count.wait_grab} -->
							<a class="accordion-toggle acc-in move-mod-head">
								<div class="map-exp-order"><strong>{t domain="express"}配送单号{/t}<span class="mark order">【{$first_express_order.express_sn}】</span>{t domain="express"}位置{/t}</strong><i class="order-map-change cursor_pointer fa fa-expand map-change-icon"></i></div>
								<div class="map-exp-user"><strong>{t domain="express"}配送员{/t}<span class="mark user">【{$express_info.name}】</span>{t domain="express"}位置{/t} </strong><i class="user-map-change cursor_pointer fa fa-expand map-change-icon"></i></div>
							</a>
							<!--{/if} -->
						</div>
						{if $express_order_count.wait_grab}
						<div class="accordion-body in collapse" >
	        					<div class="span6" id="allmap" style="height:545px;width:100%;"></div>
	        			</div>
	        			{/if}
					</div>
				</div>
			{else}
				<div style="height:545px;line-height:545px;text-align:center;width:100%;">{t domain="express"}暂无任何记录!{/t}</div>
			{/if}
			</div>
			<div class="original-user-list">
				<!-- #BeginLibraryItem "/library/waitgrablist_search_user_list.lbi" --><!-- #EndLibraryItem -->
			</div>
			<div class="new-user-list">
				
			</div>
		</div>	
	</div>
</div>
<!-- {/block} -->