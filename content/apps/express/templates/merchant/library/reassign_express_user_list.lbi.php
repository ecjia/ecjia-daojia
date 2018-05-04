<?php defined('IN_ECJIA') or exit('No permission resources.');?> 

<div class="right-bar move-mod">
	<input type="hidden" name="home_url" value="{RC_Uri::home_url()}"/>
	<div class="foldable-list move-mod-group">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle move-mod-head"><strong>配送员列表</strong></a>
			</div>
			<div class="accordion-body">
				<div class="accordion-inner right-scroll">
					<div class="control-group control-group-small">
						<div class="margin-label">
						     <form id="form-privilege" class="form-horizontal" name="express_searchForm" action="{$search_action}" method="post" >
						     	 {if $express_count.online or $express_count.offline}
								 <div class="col-lg-10">
						            <input name="keywords" class="form-control express-search-input" type="text" placeholder="请输入配送员名称" value="{$smarty.get.keywords}" />
						         </div>
						         <button class="btn btn-primary express-search-btn" type="button">搜索</button>
						         {/if}
							 </form>
						</div>
					</div>
					
					{if $express_count.online or $express_count.offline}
						{if $express_count.online}
						<div class="control-group control-group-small press-list" style="margin-bottom:0px;">
							<div class="margin-label online-list" style="margin-top:5px;margin-bottom: 5px;">在线 （{$express_count.online}）<a class="acc-in move-mod-head online-triangle" data-toggle="collapse" data-target="#online"><b class="triangle on-tran"></b></a></div>
								<div class="online open">
								<div class="express-user-list assign-operate accordion-body in collapse" id="online">
									<!-- {foreach from=$express_user_list.list item=list} -->
									{if $list.online_status eq '1'}
										<div class="express-user-info ex-user-div{$list.user_id}" staff_user_id="{$list.user_id}" online_status ="{$list.online_status}">
											<div class="exuser_div" longitude="{$list.longitude}" latitude="{$list.latitude}" name="{$list.name}" mobile="{$list.mobile}">
												<div class="imginfo-div">
		        		                			<div class="express-img">{if $list.avatar}<img src="{$list.avatar}">{else}<img src="{$app_url}/touxiang.png">{/if}</div>
		        		                			<div class="expressinfo">{$list.name}</div>
												</div>
												<div class="express-order-div">
													<div class="waitfor-pickup">
														待取货<span class="ecjia-red">{if $list.wait_pickup_count}{$list.wait_pickup_count}{else}0{/if}单</span>
													</div>
													<div class="wait-sending">
														待配送<span class="ecjia-red">{if $list.sending_count}{$list.sending_count}{else}0{/if}单</span>
													</div>
												</div>
											</div>
											<div class="assign-div">
				                       			 <a class="btn btn-warning" type="button" data-toggle="ajax_assign" data-msg="是否确定让  【{$list.name}】  去配送？" href='{url path="express/merchant/assign_express_order" args="staff_id={$list.user_id}&type={$type}"}'>指派给他</a>
											</div>
											
											<input type="hidden" class="ex-u-id" value=""/>
										</div>
									{/if}
									<!-- {/foreach} -->
								</div>
							</div>
						</div>
						{/if}
						
						{if $express_count.offline}
						<div class="control-group control-group-small press-list" style="margin-bottom:0px;">
							<div class="margin-label online-list" style="margin-top:5px;margin-bottom: 5px;">离线 （{$express_count.offline}）<a class="acc-in  move-mod-head collapsed leave-trangle" data-toggle="collapse" data-target="#leave"><b class="triangle1 leaveline"></b></a></div>
							<div class="leaveline-express">
								<div class="express-user-list-leave assign-operate accordion-body collapse" id="leave">
									<!-- {foreach from=$express_user_list.list item=list} -->
									{if $list.online_status eq '4'}
										<div class="express-user-info" online_status ="{$list.online_status}">
											<div longitude="{$list.longitude}" latitude="{$list.latitude}" name="{$list.name}" mobile="{$list.mobile}">
												<div class="imginfo-div">
		        		                			<div class="express-img">{if $list.avatar}<img src="{$list.avatar}">{else}<img src="{$app_url}/touxiang.png">{/if}</div>
		        		                			<div class="expressinfo">{$list.name}</div>
												</div>
												<div class="express-order-div">
													<div class="waitfor-pickup">
														待取货<span class="ecjia-red">{if $list.wait_pickup_count}{$list.wait_pickup_count}{else}0{/if}单</span>
													</div>
													<div class="wait-sending">
														待配送<span class="ecjia-red">{if $list.sending_count}{$list.sending_count}{else}0{/if}单</span>
													</div>
												</div>
											</div>
											<div class="assign-div">
												 <button class="btn btn-default" type="button" disabled="disabled">指派给他</button>  
											</div>
										</div>
									{/if}
									<!-- {/foreach} -->
								</div>
							</div>
						</div>
						{/if}
					{else}
						<div class="norecord">还未添加配送员!</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>
