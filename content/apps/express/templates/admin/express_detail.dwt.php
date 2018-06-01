<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="main_content"} -->


<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<form action="{$form_action}" method="post" name="orderpostForm" id="listForm" data-url='{url path="orders/admin/operate_post" args="order_id={$order.order_id}"}'  data-pjax-url='{url path="orders/admin/info" args="order_id={$order.order_id}"}' data-list-url='{url path="orders/admin/init"}' data-remove-url="{$remove_action}">
			<div id="accordion2" class="foldable-list form-inline">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne"><strong>{lang key='orders::order.base_info'}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseOne">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>配送员名称：</strong></div></td>
									<td>
										{$express_info.name}
									</td>
									<td><div align="right"><strong>手机号码：</strong></div></td>
									<td>{$express_info.mobile}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>邮箱账号：</strong></div></td>
									<td>
										{$express_info.email}
									</td>
									<td><div align="right"><strong>信用等级：</strong></div></td>
									<td>
										{section name=loop loop=$express_info.comment_rank}
								      		<i class="fontello-icon-star" style="color:#FF9933;"></i>
										{/section}
										{section name=loop loop=5-$express_info.comment_rank}   
											<i class="fontello-icon-star" style="color:#bbb;"></i>
										{/section}
									</td>
								</tr>
								<tr>
									<td><div align="right"><strong>工作类型：</strong></div></td>
									<td>
										{if $express_info.work_type eq 1}派单{else}抢单{/if}
									</td>
									<td><div align="right"><strong>账户余额：</strong></div></td>
									<td>¥ {$express_info.user_money}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>申请时间：</strong></div></td>
									<td>{$express_info.add_time}</td>
									<td><div align="right"><strong>申请来源：</strong></div></td>
									<td>{if $express_info.apply_source eq 'admin'}平台{else}APP{/if}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>所在地区：</strong></div></td>
									<td colspan="3">{$express_info.province}&nbsp;{$express_info.city}&nbsp;{$express_info.district}&nbsp;{$express_info.street}&nbsp;{$express_info.address}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse"  data-target="#collapseFive">
							<strong>配送情况</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseFive">
						<table class="table h70">
							<tr>
								<td>
									<div class="order_number m_t30">
										<span>已完成：<font class="ecjiafc-red"> {$order_number.finish} </font>单</span>
										<span>抢单数：<font class="ecjiafc-red"> {$order_number.grab}   </font>单</span>
										<span>派单数：<font class="ecjiafc-red"> {$order_number.assign} </font>单</span>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseSix"><strong>配送记录</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseSix">
						<table class="table table-striped m_b0">
							<thead>
								<tr>
									<td class="w150">配送单号</td>
									<td class="w150">店铺名称</td>
									<td class="w500">取货/送货地址</td>
									<td class="w200">接单时间</td>
									<td class="w100">任务类型</td>
									<td class="w100">配送费</td>
									<td class="w100">配送状态</td>
								</tr>
							</thead>
							<tbody>
								<!-- {foreach from=$order_list.list item=list} -->
								<tr>
									<td>{$list.express_sn}</td>
									<td>{$list.merchants_name}</td>
									<td>
										取：{$list.district}{$list.street}{$list.address}<br>
										送：{$list.eodistrict}{$list.eostreet}{$list.eoaddress}
									</td>
									<td>
										{$list.receive_time}
									</td>
									<td>{if $list.from eq 'assign'}派单{else}抢单{/if}</td>
									<td>¥{$list.commision}</td>
									<td>
									{if $list.status eq 0}<font class="ecjiafc-red">待抢单</font>{elseif $list.status eq 1}<font class="ecjiafc-red">待取货</font>{elseif $list.status eq 2}<font class="ecjiafc-red">配送中</font>{elseif $list.status eq 3}退货中{elseif $list.status eq 4}已拒收{elseif $list.status eq 5}已完成{else}已退回{/if}</td>
								</tr>
								<!-- {foreachelse} -->
								<tr>
									<td class="no-records" colspan="7">{lang key='orders::order.no_order_operation_record'}</td>
								</tr>
								<!-- {/foreach} -->
							</tbody>
						</table>
						 <!-- {$order_list.page} -->
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<!-- {/block} -->