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
                            <strong>{lang key='express::express.base_info'}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse " id="collapseOne">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{lang key='express::express.label_express_sn'}</strong></div></td>
								<td>{$express_info.delivery_sn}</td>
								<td><div align="right"><strong>{lang key='express::express.label_add_time'}</strong></div></td>
								<td>{$express_info.formatted_add_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='express::express.label_order_sn'}</strong></div></td>
								<td>
									<a href='{url path="orders/merchant/info" args="order_sn={$express_info.order_sn}"}'>{$express_info.order_sn}</a>
								</td>
								<td><div align="right"><strong>{lang key='express::express.label_delivery_sn'}</strong></div></td>
								<td>{$express_info.delivery_sn}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='express::express.label_from'}</strong></div></td>
								<td>{$express_info.label_from}</td>
								<td><div align="right"><strong>{lang key='express::express.label_express_status'}</strong></div></td>
								<td>{$express_info.label_status}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='express::express.label_express_staff_name'}</strong></div></td>
								<td>{$express_info.staff_user}</td>
								<td><div align="right"><strong>{lang key='express::express.label_receive_time'}</strong></div></td>
								<td>{$express_info.formatted_receive_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='express::express.label_express_time'}</strong></div></td>
								<td>{$express_info.formatted_express_time}</td>
								<td><div align="right"><strong>{lang key='express::express.label_signed_time'}</strong></div></td>
								<td>{$express_info.formatted_signed_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='express::express.label_update_time'}</strong></div></td>
								<td colspan="3">{$express_info.formatted_update_time}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="accordion-group panel panel-default">
				<div class="panel-heading">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                		<h4 class="panel-title"><strong>{lang key='express::express.consignee_info'}</strong></h4>
                  	</a>
				</div>
				<div class="accordion-body in collapse" id="collapseTwo">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{lang key='express::express.label_consignee'}</strong></div></td>
								<td>{$express_info.consignee|escape}</td>
								<td><div align="right"><strong>{lang key='express::express.label_email'}</strong></div></td>
								<td>{$express_info.email}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='express::express.label_address'}</strong></div></td>
								<td>[{$express_info.region}] {$express_info.address|escape}</td>
								<td><div align="right"><strong>{lang key='express::express.label_mobile'}</strong></div></td>
								<td>{$express_info.mobile}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='express::express.label_distance'}</strong></div></td>
								<td>{$express_info.distance}</td>
								<td><div align="right"><strong>{lang key='express::express.label_best_time'}</strong></div></td>
								<td>{$express_info.label_best_time}</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='express::express.label_remark'}</strong></div></td>
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
                            <strong>{lang key='express::express.goods_info'}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse" id="collapseThree">
					<table class="table table-striped m_b0 order-table-list">
						<tbody>
							<tr class="table-list">
								<th>{lang key='express::express.goods_name_brand'}</th>
								<th>{lang key='express::express.goods_sn'}</th>
								<th>{lang key='express::express.product_sn'}</th>
								<th>{lang key='express::express.goods_attr'}</th>
								<th>{lang key='express::express.label_send_number'}</th>
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
                            <strong>{lang key='express::express.express_op_info'}</strong>
                        </h4>
                    </a>
                </div>
				<div class="accordion-body in collapse" id="collapseFive">
					<table class="table table-oddtd m_b0">
						<tbody class="first-td-no-leftbd">
							<tr>
								<td><div align="right"><strong>{lang key='express::express.label_express_user'}</strong></div></td>
								<td>
									<select class="w250 form-control" name='staff_id'>
										<option value='0'>请选择</option>
										<!-- {foreach from=$staff_user item=list} -->
											<option value="{$list.user_id}" {if $list.user_id eq $express_info.staff_id}selected="selected"{/if}>{$list.name}</option>
										<!-- {/foreach} -->
									</select>
								</td>
							</tr>
							<tr>
								<td><div align="right"><strong>{lang key='express::express.label_operable_act'}</strong></div></td>
								<td align="left">
									<button class="btn btn-info" type="submit">{lang key='express::express.change_express_user'}</button>
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