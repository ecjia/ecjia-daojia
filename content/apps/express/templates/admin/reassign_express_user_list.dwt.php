<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<script type="text/javascript">
		ecjia.admin.serach_user_list.init();
</script>
<div class="right-bar move-mod">
	<div class="foldable-list move-mod-group">
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle move-mod-head"><strong>配送员列表</strong></a>
			</div>
			<div class="accordion-body">
				<div class="accordion-inner right-scroll">
					<div class="control-group control-group-small">
						{if $express_count.online or $express_count.offline}
							<div class="margin-label">
							     <form id="form-privilege" class="form-horizontal" name="express_searchForm" action="{$search_action}" method="post" >
									 <input name="keywords" class="span2" type="text" placeholder="请输入配送员名称" value="{$smarty.get.keywords}" />
									 <button class="btn btn-gebo express-search-btn" style="background:#058DC7;padding:4px 7px;" type="button">搜索</button>
								 </form>
							</div>
						{/if}
					</div>
					{if $express_count.online or $express_count.offline}
						{if $express_count.online}
							<div class="control-group control-group-small press-list" style="margin-bottom:0px;">
								<div class="margin-label online-list" style="margin-top:5px;margin-bottom: 5px;">在线 （{$express_count.online}）<a class="accordion-toggle acc-in move-mod-head online-click" data-toggle="collapse" data-target="#reassign-online"><b class="triangle on-tri"></b></a></div>
								<div class="online open">
									<div class="express-user-list-on accordion-body in collapse" id="reassign-online">
										<!-- {foreach from=$express_user_list.list item=list} -->
											{if $list.online_status eq '1'}
												<div class="express-user-info ex-user-div{$list.user_id}" staff_user_id="{$list.user_id}" online_status="{$list.online_status}">
													<div class="reassign_exuser_div" longitude="{$list.longitude}" latitude="{$list.latitude}" name="{$list.name}" mobile="{$list.mobile}">
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
														<a class="re-assign btn btn-warning" type="button"  notice="是否确定让  【{$list.name}】  去配送？" assign-url='{url path="express/admin/assign_express_order" args="staff_id={$list.user_id}&type={$type}"}'><span style="color:#fff;">指派给他</span></a>  
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
								<div class="margin-label online-list" style="margin-top:5px;margin-bottom: 5px;">离线 （{$express_count.offline}）<a class="accordion-toggle acc-in  move-mod-head collapsed offline-click" data-toggle="collapse" data-target="#reassign-leave"><b class="triangle1 off-tri"></b></a></div>
								<div class="leaveline-express">
									<div class="express-user-list-off accordion-body collapse" id="reassign-leave">
										<!-- {foreach from=$express_user_list.list item=list} -->
											<!-- {if $list.online_status eq '4'} -->
												<div class="express-user-info" online_status="{$list.online_status}" longitude="{$list.longitude}" latitude="{$list.latitude}" name="{$list.name}" mobile="{$list.mobile}">
													<div>
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
			               								 <a class="btn" type="button" disabled="disabled" notice="是否确定让  【{$list.name}】  去配送？" assign-url='{url path="express/admin/assign_express_order" args="staff_id={$list.user_id}&type={$type}"}'>指派给他</a>  
													</div>
												</div>
											<!-- {/if} -->
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


<!-- 指派开始 -->
<div class="after-search-re-assign-model re-assign-model">
	<div class="modal " style="width:530px;">
		 <div class="modal-body">
			<div class="control-group formSep control-group-small">
				<div class="controls">
					<div class="notice-message"></div>
				</div>
			</div>
			<div class="control-group t_c">
				<button class="btn cancel-btn">取消</button>&nbsp;&nbsp;
				<button class="btn ok-btn">确定</button>
			</div>
		  </div>
	</div>
</div>
	
<!--指派结束 -->
