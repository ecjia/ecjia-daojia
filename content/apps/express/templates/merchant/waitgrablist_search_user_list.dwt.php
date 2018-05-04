<?php defined('IN_ECJIA') or exit('No permission resources.');?> 

<script type="text/javascript">
	ecjia.merchant.serachuser_list.init();
</script>

<div class="waitgrablist">
	<input type="hidden" name="home_url" value="{RC_Uri::home_url()}"/>
	<div class="right-bar move-mod" style="height:580px;border:1px solid #dcdcdc;border-radius:4px;">
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
									 <input id="start" type="hidden" value="{$start}"/>
									 <input id="end" type="hidden" value="{$end}"/>
									 <input id="policy" type="hidden" value="LEAST_TIME"/>
									 <input id="routes" type="hidden" />
									 <div class="col-lg-10">
							            <input name="keywords" class="form-control express-search-input" type="text" placeholder="请输入配送员名称" value="{$smarty.get.keywords}" />
							         </div>
							         <button class="btn btn-primary express-search-btn" type="button">搜索</button>
								 </form>
							</div>
						</div>
						
						{if $express_count.online or $express_count.offline}
						   	{if $express_count.online}
							<div class="control-group control-group-small press-list" style="margin-bottom:0px;">
								<div class="margin-label online-list" style="margin-top:5px;margin-bottom: 5px;">在线 （{if $express_count.online}{$express_count.online}{else}0{/if}）<a class="acc-in move-mod-head online-click" data-toggle="collapse" data-target="#waitgrab_online"><b class="triangle on-tri"></b></a></div>
								<div class="online open">
									<div class="express-user-list-on accordion-body in collapse" id="waitgrab_online">
										<!-- {foreach from=$express_user_list.list item=list} -->
											{if $list.online_status eq '1'}
												<div class="express-user-info ex-user-div{$list.user_id}" staff_user_id="{$list.user_id}" online_status ="{$list.online_status}">
													<div class="reassign_exuser_div" longitude="{$list.longitude}" latitude="{$list.latitude}" name="{$list.name}" mobile="{$list.mobile}">
														<div class="imginfo-div">
				        		                			<div class="express-img">{if $list.avatar}<img src="{$list.avatar}">{else}<img src="{$app_url}/touxiang.png">{/if}</div>
				        		                			<div class="expressinfo">{$list.name}</div>
														</div>
														<div class="express-order-div">
															<div class="waitfor-pickup">
																待取货<span class="ecjia-red">{if $list.wait_pickup_count}{$list.wait_pickup_count}{else}0{/if}单</span>
															</div>
															<div class="wait-sending-list">
																待配送<span class="ecjia-red">{if $list.sending_count}{$list.sending_count}{else}0{/if}单</span>
															</div>
														</div>
													</div>
													<div class="assign-div">
														 <a class="{if $express_order_count.wait_grab} re-assign {/if} "  data-msg="是否确定让  【{$list.name}】  去配送？" data-href='{url path="express/merchant/assign_express_order" args="staff_id={$list.user_id}&type={$type}"}'  >
							                       			{if $express_order_count.wait_grab}
							                       				<button class="btn btn-warning" type="button">
							                       					指派给他
							                       				</button>  
							                       			{else}
							                       				<button class="btn btn-default" type="button" disabled="disabled">指派给他</button>  
							                       			{/if}
			               								 </a> 
														<input type="hidden" class="selected-express-id" value="{$first_express_order.express_id}"/>
														<input type="hidden" class="ex-u-id" value=""/>
													</div>
												</div>
											 {/if}
										<!-- {/foreach} -->
									</div>
								</div>
							</div>
							{/if}
							
							{if $express_count.offline}
							<div class="control-group control-group-small press-list" style="margin-bottom:0px;">
								<div class="margin-label online-list" style="margin-top:5px;margin-bottom: 5px;">离线 （{if $express_count.offline}{$express_count.offline}{else}0{/if}）<a class="acc-in  move-mod-head collapsed offline-click" data-toggle="collapse" data-target="#waitgrab_leave"><b class="triangle1 off-tri"></b></a></div>
								<div class="leaveline-express">
									<div class="express-user-list-off accordion-body collapse" id="waitgrab_leave">
										<!-- {foreach from=$express_user_list.list item=list} -->
											{if $list.online_status eq '4'}
												<div class="express-user-info" online_status ="{$list.online_status}" >
													<div longitude="{$list.longitude}" latitude="{$list.latitude}" name="{$list.name}" mobile="{$list.mobile}">
														<div class="imginfo-div">
				        		                			<div class="express-img">{if $list.avatar}<img src="{$list.avatar}">{else}<img src="{$app_url}/touxiang.png">{/if}</div>
				        		                			<div class="expressinfo">{$list.name}</div>
														</div>
														<div class="express-order-div">
															<div class="waitfor-pickup">
																待取货<span class="ecjia-red">{if $list.wait_pickup_count}{$list.wait_pickup_count}{else}0{/if}单</span>
															</div>
															<div class="wait-sending-list">
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
							<div class="norecord">未查找到配送员!</div>
						{/if}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
