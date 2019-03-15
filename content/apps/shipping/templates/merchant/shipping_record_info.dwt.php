<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.express.info();
</script>
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
	<div class="span12 ">
		<form action="{$form_action}" method="post" name="expressForm" class="form-horizontal">
			<div id="accordion2" class="panel panel-default">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <h4 class="panel-title">
                            <strong>{t domain="shipping"}基本信息{/t}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse " id="collapseOne">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{t domain="shipping"}配送流水号：{/t}</strong></div></td>
								<td>{$express_info.delivery_sn}</td>
								<td><div align="right"><strong>{t domain="shipping"}创建时间：{/t}</strong></div></td>
								<td>{$express_info.formatted_add_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="shipping"}订单编号：{/t}</strong></div></td>
								<td>
									<a href='{url path="orders/merchant/record_info" args="order_sn={$express_info.order_sn}"}'>{$express_info.order_sn}</a>
								</td>
								<td><div align="right"><strong>{t domain="shipping"}发货单流水号：{/t}</strong></div></td>
								<td>{$express_info.delivery_sn}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="shipping"}配送来源：{/t}</strong></div></td>
								<td>{$express_info.label_from}</td>
								<td><div align="right"><strong>{t domain="shipping"}配送状态：{/t}</strong></div></td>
								<td>{$express_info.label_status}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="shipping"}配送员：{/t}</strong></div></td>
								<td>{$express_info.staff_user}</td>
								<td><div align="right"><strong>{t domain="shipping"}接单时间：{/t}</strong></div></td>
								<td>{$express_info.formatted_receive_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="shipping"}取货配送时间：{/t}</strong></div></td>
								<td>{$express_info.formatted_express_time}</td>
								<td><div align="right"><strong>{t domain="shipping"}签收时间：{/t}</strong></div></td>
								<td>{$express_info.formatted_signed_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="shipping"}更新时间：{/t}</strong></div></td>
								<td colspan="3">{$express_info.formatted_update_time}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="accordion-group panel panel-default">
				<div class="panel-heading">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                		<h4 class="panel-title"><strong>{t domain="shipping"}收货人信息{/t}</strong></h4>
                  	</a>
				</div>
				<div class="accordion-body in collapse" id="collapseTwo">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{t domain="shipping"}收货人名称：{/t}</strong></div></td>
								<td>{$express_info.consignee|escape}</td>
								<td><div align="right"><strong>{t domain="shipping"}邮箱地址：{/t}</strong></div></td>
								<td>{$express_info.email}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="shipping"}收货地址：{/t}</strong></div></td>
								<td>[{$express_info.region}] {$express_info.address|escape}</td>
								<td><div align="right"><strong>{t domain="shipping"}联系方式：{/t}</strong></div></td>
								<td>{$express_info.mobile}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="shipping"}送货距离：{/t}</strong></div></td>
								<td>{$express_info.distance}</td>
								<td><div align="right"><strong>{t domain="shipping"}期望送货时间：{/t}</strong></div></td>
								<td>{$express_info.label_best_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="shipping"}客户给商家的留言：{/t}</strong></div></td>
								<td colspan="3">{$express_info.remark}</td>
							</tr>
						</tbody>
					</table>
				</div> 
    		</div>
			<div class="accordion-group panel panel-default">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        <h4 class="panel-title">
                            <strong>{t domain="shipping"}商品信息{/t}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse" id="collapseThree">
					<table class="table table-striped m_b0 order-table-list">
						<tbody>
							<tr class="table-list">
								<th>{t domain="shipping"}商品名称 [品牌 ]{/t}</th>
								<th>{t domain="shipping"}货号{/t}</th>
								<th>{t domain="shipping"}货品号{/t}</th>
								<th>{t domain="shipping"}属性{/t}</th>
								<th>{t domain="shipping"}发货数量{/t}</th>
							</tr>
							<!-- {foreach from=$goods_list item=goods} -->
							<tr class="table-list">
								<td>
									<a href='{url path="goods/merchant/preview" args="id={$goods.goods_id}"}' target="_blank">{$goods.goods_name} {if $goods.brand_name}[ {$goods.brand_name} ]{/if}</a>
								</td>
								<td>{$goods.goods_sn}</td>
								<td>{$goods.product_sn}</td>
								<td>{$goods.goods_attr|nl2br}</td>
								<td>{$goods.send_number}</td>
							</tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</div>
			</div>
			<!-- {if $express_info.status lt 2} -->
			<div class="accordion-group panel panel-default">
				<div class="panel-heading">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                        <h4 class="panel-title">
                            <strong>{t domain="shipping"}配送操作信息{/t}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse" id="collapseFive">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{t domain="shipping"}配送人员：{/t}</strong></div></td>
								<td>
									<select class="w250 form-control" name='staff_id'>
										<option value='0'>{t domain="shipping"}请选择{/t}</option>
										<!-- {foreach from=$staff_user item=list} -->
											<option value="{$list.user_id}" {if $list.user_id eq $express_info.staff_id}selected="selected"{/if}>{$list.name}</option>
										<!-- {/foreach} -->
									</select>
								</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{t domain="shipping"}当前可执行操作：{/t}</strong></div></td>
								<td align="left">
									<button class="btn btn-info" type="submit">{t domain="shipping"}变更配送人员{/t}</button>
									<input name="express_id" type="hidden" value="{$express_info.express_id}">
									<input name="act" type="hidden" value="{$action_act}">
								</td>
							</tr>
							
						</tbody>
					</table>
				</div>
			</div>
			<!-- {/if} -->
		</form>
	</div>
</div>
<!-- {/block} -->