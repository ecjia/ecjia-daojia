<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">  		
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row-fluid">
	<div class="span12">
		<div id="accordion2" class="panel panel-default">
			<div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <h4 class="panel-title"><strong>基本信息</strong></h4>
                </a>
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
						      		<i class="fa fa-star" style="color:#FF9933;"></i>
								{/section}
								{section name=loop loop=5-$express_info.comment_rank}   
									<i class="fa fa-star" style="color:#bbb;"></i>
								{/section}
							</td>
						</tr>
						<tr>
							<td><div align="right"><strong>工作类型：</strong></div></td>
							<td>派单</td>
							<td><div align="right"><strong>账户余额：</strong></div></td>
							<td>{$express_info.user_money_type}</td>
						</tr>
						<tr>
							<td><div align="right"><strong>添加时间：</strong></div></td>
							<td colspan="3">{$express_info.add_time}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		
		<div class="accordion-group panel panel-default">
			<div class="panel-heading accordion-group-heading-relative">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSix">
                    <h4 class="panel-title">
                        <strong>配送情况</strong>
                    </h4>
                </a>
            </div>
            <div class="accordion-body in collapse " id="collapseSix">
            	<table class="table m_b0 h100">
					<tr>
						<td>
							<div class="order_number m_t30">
								<span>派单数：<font class="ecjiafc-red"> {$order_number.assign} </font>单</span>
								<span>未完成：<font class="ecjiafc-red"> {$order_number.undone} </font>单</span>
								<span>已完成：<font class="ecjiafc-red"> {$order_number.finish} </font>单</span>
							</div>
						</td>
					</tr>
				</table>
            </div>
		</div>
		
		<div class="accordion-group panel panel-default">
			<div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseSeven">
                    <h4 class="panel-title">
                        <strong>配送记录</strong>
                    </h4>
                </a>
            </div>
            <div class="accordion-body in collapse" id="collapseSeven">
            	<table class="table table-striped m_b0">
					<thead>
						<tr>
							<th class="w150"><strong>配送单号</strong></th>
							<th class="w200"><strong>送货地址</strong></th>
							<th class="w150"><strong>接单时间</strong></th>
							<th class="w150"><strong>任务类型</strong></th>
							<th class="w100"><strong>配送费</strong></th>
							<th class="w100"><strong>配送状态</strong></th>	
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$order_list.list item=list} -->
						<tr>
							<td>{$list.express_sn}</td>
							<td>{$list.district}{$list.street}{$list.address}</td>
							<td>{$list.receive_time}</td>
							<td>派单</td>
							<td>{$list.commision}</td>
							<td>
							{if $list.status eq 0}<font class="ecjiafc-red">待派单</font>{elseif $list.status eq 1}<font class="ecjiafc-red">待取货</font>{elseif $list.status eq 2}<font class="ecjiafc-red">配送中</font>{elseif $list.status eq 3}退货中{elseif $list.status eq 4}已拒收{elseif $list.status eq 5}已完成{else}已退回{/if}</td>
						</tr>
						<!-- {foreachelse} -->
						<tr>
							<td class="no-records" colspan="7">{lang key='orders::order.no_order_operation_record'}</td>
						</tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
            </div>
		</div>
	</div>
</div>
<!-- {/block} -->