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
		<form action="{$form_action}" method="post" name="theForm" id="theForm" data-url='{url path="orders/admin/operate_post" args="order_id={$order.order_id}"}'  data-pjax-url='{url path="orders/admin/info" args="order_id={$order.order_id}"}' data-list-url="{url path='orders/admin/init'}" data-remove-url="{$remove_action}">
			<div id="accordion2" class="foldable-list">
				<div class="accordion-group">
					<div class="accordion-heading">
						<div class="accordion-toggle acc-in" data-toggle="collapse" data-target="#telescopic1">
							<strong>发票信息</strong>
						</div>
					</div>
					<div class="accordion-body in collapse" id="telescopic1">
						<table class="table table-oddtd m_b0">
							<tbody class="first-td-no-leftbd">
								<tr>
									<td><div align="right"><strong>会员名称：</strong></div></td>
									<td>{$invoice_info.user_name}</td>
									<td><div align="right"><strong>电话号码：</strong></div></td>
									<td>{$invoice_info.user_mobile}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>抬头类型：</strong></div></td>
									<td>{if $invoice_info.title_type eq 'PERSONAL'}个人{else}企业{/if}</td>
									<td><div align="right"><strong>抬头名称：</strong></div></td>
									<td>{$invoice_info.title_name}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>纳税人识别号：</strong></div></td>
									<td>{$invoice_info.tax_register_no}</td>
									<td><div align="right"><strong>状态：</strong></div></td>
									<td>{if $invoice_info.status eq 1}审核通过{else}待审核{/if}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>开户银行：</strong></div></td>
									<td>{$invoice_info.open_bank_name}</td>
									<td><div align="right"><strong>银行账号：</strong></div></td>
									<td>{$invoice_info.open_bank_account}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>添加时间：</strong></div></td>
									<td>{$invoice_info.add_time}</td>
									<td><div align="right"><strong>更新时间：</strong></div></td>
									<td>{$invoice_info.update_time}</td>
								</tr>
								<tr>
									<td><div align="right"><strong>详细地址：</strong></div></td>
									<td colspan="3">{$invoice_info.user_address}</td>
								</tr>
							</tbody>
						</table>
					</div>	
				</div>
			</div>
		</form>
	</div>
</div>
<!-- {/block} -->