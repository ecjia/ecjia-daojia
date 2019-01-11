<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.cashier_device.init();
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
				<form class="form-inline pull-right" name="searchForm" method="post" action="{$search_action}">
					<div class="form-group">
						<input type="text" class="form-control" style="width:250px;" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入设备名称或设备号关键字"/> 
						<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> 搜索 </button>
					</div>
				</form>
			</div>
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit">
						<thead>
							<tr>
							    <th>缩略图</th>
								<th>设备名称</th>
								<th class="w250">设备MAC地址</th>
								<th>设备号</th>
								<th>机型</th>
								<th>产品序列号</th>
								<th>状态</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$cashier_device_list.list item=list} -->
							<tr>
								<td>
									<a href='{url path="cashier/mh_cashier_device/edit" args="id={$list.id}"}'>
										<img class="w60 h60" alt="{if $list.cashier_type eq 'cashier-desk'}收银台{else}收银POS机{/if}" src="{if $list.cashier_type eq 'cashier-desk'}{$app_url}/cashdesk.png{else}{$app_url}/pos.png{/if}">
									</a>
								</td>
								<td>
		                           {$list.device_name}
		                           <div class="edit-list">
										<a class="data-pjax" href='{url path="cashier/mh_cashier_device/edit" args="id={$list.id}"}'>{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
										<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="您确定要删除该收银设备吗？" href='{url path="cashier/mh_cashier_device/remove" args="id={$list.id}"}'>{lang key='system::system.drop'}</a>
									</div>
		                        </td>
								<td class="hide-edit-area">
									{$list.device_mac}
								</td>
								<td>{$list.device_sn}</td>
								<td>{$list.device_type}</td>
								<td>{$list.product_sn}</td>
								<td align="center">
									<i class="cursor_pointer fa {if $list.status}fa-check {else}fa-times{/if}" data-trigger="toggle_status" data-url="{RC_Uri::url('cashier/mh_cashier_device/toggle_status')}" refresh-url="{RC_Uri::url('cashier/mh_cashier_device/init')}" data-id="{$list.id}"></i>
								</td>
							</tr>
							<!-- {foreachelse} -->
							   <tr><td class="no-records" colspan="7">{lang key='system::system.no_records'}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</section>
			<!-- {$cashier_device_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->