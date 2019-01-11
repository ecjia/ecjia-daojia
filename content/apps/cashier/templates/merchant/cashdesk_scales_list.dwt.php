<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.cashdesk_scales.init();
</script>
<!-- {/block} -->


<!-- {block name="home-content"} -->


<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" ></i></button>
	<strong>温馨提示：</strong>收银台，自主购物区，支持称重后产生的条形码识别，识别的内容包含商品信息，称重金额，数量（称重金额/单价）等。
</div>

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-plus"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit">
						<thead>
							<tr>
								<th class="w100">条码秤编码</th>
								<th class="w200">条码模式</th>
								<th class="w150">日期格式</th>
								<th class="w100">净重单位</th>
								<th class="w100">单价单位</th>
								<th class="w100">是否抹零</th>
								<th class="w100">保留分位</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$scales_list.list item=list} -->
							<tr>
								<td>
		                           {$list.scale_sn}
		                        </td>
								<td class="hide-edit-area">
									{if $list.barcode_mode eq '1'}金额模式{elseif $list.barcode_mode eq '2'}重量模式{else $list.barcode_mode eq '3'}重量模式+金额模式{/if}
									<div class="edit-list">
										<a class="data-pjax" href='{url path="cashier/mh_cashier_scales/edit" args="id={$list.id}"}'>{lang key='system::system.edit'}</a>
									</div>
								</td>
								<td>{if $list.date_format eq '1'}yyyy-mm-dd{else}yyyy.mm.dd{/if}</td>
								<td>{if $list.weight_unit eq '1'}克{else}千克{/if}</td>
								<td>{if $list.weight_unit eq '1'}克/元{else}千克/元{/if}</td>
								<td align="center">
									<i class="cursor_pointer fa {if $list.wipezero}fa-check {else}fa-times{/if}" data-trigger="toggle_wipezero" data-url="{RC_Uri::url('cashier/mh_cashier_scales/toggle_wipezero')}" refresh-url="{RC_Uri::url('cashier/mh_cashier_scales/init')}" data-id="{$list.id}"></i>
								</td>
								<td align="center">
									<i class="cursor_pointer fa {if $list.reserve_quantile}fa-check {else}fa-times{/if}" data-trigger="toggle_reserve_quantile" data-url="{RC_Uri::url('cashier/mh_cashier_scales/toggle_reserve_quantile')}" refresh-url="{RC_Uri::url('cashier/mh_cashier_scales/init')}" data-id="{$list.id}"></i>
								</td>
							</tr>
							<!-- {foreachelse} -->
							   <tr><td class="no-records" colspan="7">{lang key='system::system.no_records'}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</section>
			<!-- {$scales_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->