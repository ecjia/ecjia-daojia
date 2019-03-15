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
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseOne"><strong>{t domain="express"}基本信息{/t}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseOne">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>{t domain="express"}配送员名称：{/t}</strong></div></td>
									<td>
										{$express_info.name}
									</td>
									<td><div align="right"><strong>{t domain="express"}手机号码：{/t}</strong></div></td>
									<td>{$express_info.mobile}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="express"}邮箱账号：{/t}</strong></div></td>
									<td>
										{$express_info.email}
									</td>
									<td><div align="right"><strong>{t domain="express"}信用等级：{/t}</strong></div></td>
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
									<td><div align="right"><strong>{t domain="express"}工作类型：{/t}</strong></div></td>
									<td>
										{if $express_info.work_type eq 1}{t domain="express"}派单{/t}{else}{t domain="express"}抢单{/t}{/if}
									</td>
									<td><div align="right"><strong>{t domain="express"}账户余额：{/t}</strong></div></td>
									<td>¥ {$express_info.user_money}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="express"}申请时间：{/t}</strong></div></td>
									<td>{$express_info.add_time}</td>
									<td><div align="right"><strong>{t domain="express"}申请来源：{/t}</strong></div></td>
									<td>{if $express_info.apply_source eq 'admin'}平台{else}APP{/if}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>{t domain="express"}所在地区：{/t}</strong></div></td>
									<td colspan="3">{$express_info.province}&nbsp;{$express_info.city}&nbsp;{$express_info.district}&nbsp;{$express_info.street}&nbsp;{$express_info.address}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading accordion-heading-url">
						<div class="accordion-toggle acc-in" data-toggle="collapse"  data-target="#collapseFive">
							<strong>{t domain="express"}配送情况{/t}</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="collapseFive">
						<table class="table h70">
							<tr>
								<td>
									<div class="order_number m_t30">
										<span>{t domain="express"}已完成：{/t}<font class="ecjiafc-red"> {$order_number.finish} </font>{t domain="express"}单{/t}</span>
										<span>{t domain="express"}抢单数：{/t}<font class="ecjiafc-red"> {$order_number.grab}   </font>{t domain="express"}单{/t}</span>
										<span>派单数：<font class="ecjiafc-red"> {$order_number.assign} </font>{t domain="express"}单{/t}</span>
									</div>
								</td>
							</tr>
						</table>
					</div>
				</div>
				
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle acc-in" data-toggle="collapse" data-target="#collapseSix"><strong>{t domain="express"}配送记录{/t}</strong></a>
					</div>
					<div class="accordion-body in collapse" id="collapseSix">
						<table class="table table-striped m_b0">
							<thead>
								<tr>
									<td class="w150">{t domain="express"}配送单号{/t}</td>
									<td class="w150">{t domain="express"}店铺名称{/t}</td>
									<td class="w500">{t domain="express"}取货/送货地址{/t}</td>
									<td class="w200">{t domain="express"}接单时间{/t}</td>
									<td class="w100">{t domain="express"}任务类型{/t}</td>
									<td class="w100">{t domain="express"}配送费{/t}</td>
									<td class="w100">{t domain="express"}配送状态{/t}</td>
								</tr>
							</thead>
							<tbody>
								<!-- {foreach from=$order_list.list item=list} -->
								<tr>
									<td>{$list.express_sn}</td>
									<td>{$list.merchants_name}</td>
									<td>
                                        {t domain="express"}取：{/t}{$list.district}{$list.street}{$list.address}<br>
                                        {t domain="express"}送：{/t}{$list.eodistrict}{$list.eostreet}{$list.eoaddress}
									</td>
									<td>
										{$list.receive_time}
									</td>
									<td>{if $list.from eq 'assign'}{t domain="express"}派单{/t}{else}{t domain="express"}抢单{/t}{/if}</td>
									<td>¥{$list.commision}</td>
									<td>
									{if $list.status eq 0}<font class="ecjiafc-red">{t domain="express"}待抢单{/t}</font>{elseif $list.status eq 1}<font class="ecjiafc-red">{t domain="express"}待取货{/t}</font>{elseif $list.status eq 2}<font class="ecjiafc-red">{t domain="express"}配送中{/t}</font>{elseif $list.status eq 3}{t domain="express"}退货中{/t}{elseif $list.status eq 4}{t domain="express"}已拒收{/t}{elseif $list.status eq 5}{t domain="express"}已完成{/t}{else}{t domain="express"}已退回{/t}{/if}</td>
								</tr>
								<!-- {foreachelse} -->
								<tr>
									<td class="no-records" colspan="7">{t domain="express"}该订单暂无操作记录{/t}</td>
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