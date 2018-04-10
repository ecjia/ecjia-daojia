<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.withdraw.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<a class="btn plus_or_reply" id="sticky_a" href='{RC_Uri::url("commission/admin/withdraw_export", "{if $smarty.get.type}&type={$smarty.get.type}{/if}{$url_parames}")}'><i class="fontello-icon-download"></i>导出Excel</a>
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<ul class="nav nav-pills">
		    <li class="{if !$smarty.get.type}active{/if}">
				<a class="data-pjax" href='{RC_Uri::url("commission/admin/withdraw", "{$url_parames}")}'>待审核
					<span class="badge badge-info">{$type_count.wait_check}</span>
				</a>
			</li>
			<li class="{if $smarty.get.type eq 1}active{/if}">
				<a class="data-pjax" href='{RC_Uri::url("commission/admin/withdraw", "type=1{$url_parames}")}'>已通过
					<span class="badge badge-info">{$type_count.passed}</span>
				</a>
			</li>
			<li class="{if $smarty.get.type eq 2}active{/if}">
				<a class="data-pjax" href='{RC_Uri::url("commission/admin/withdraw", "type=2{$url_parames}")}'>已拒绝
					<span class="badge badge-info">{$type_count.refused}</span>
				</a>
			</li>
		</ul>
		<ul class="nav nav-pills choose_list " style="border:none;">
			<form class="f_r form-inline" action='{RC_Uri::url("commission/admin/withdraw")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
    			<input class="date f_l w120" name="start_time" type="text" value="{$smarty.get.start_time}" placeholder="开始时间">
             	<input class="date f_l w120" name="end_time" type="text" value="{$smarty.get.end_time}" placeholder="结束时间">
    			<input type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="请输入商家关键字" size="15" />
    			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="请输入提现流水号" size="15" />
    			<button class="btn screen-btn" type="submit">{lang key='system::system.button_search'}</button>
    		</form>
		</ul>
		<div class="tab-content">
			<div class="row-fluid">
				<table class="table table-striped smpl_tbl dataTable table-hide-edit">
					<thead>
						<tr>
						    <th>流水号</th>
						    <th>商家名称</th>
						    <th>提现金额</th>
						    <th>提现方式</th>
						    <th>收款账号</th>
						    <th>申请时间</th>
						    <th>处理状态</th>
						</tr>
					</thead>

				 	<!-- {foreach from=$data.item item=list} -->
					<tr>
						<td class="hide-edit-area">
							{$list.order_sn}
							<div class="edit-list">
								<a href='{url path="commission/admin/withdraw_detail" args="id={$list.id}"}' class="data-pjax" title="查看详情">{t}查看详情{/t}</a>
							</div>
						</td>
						<td>{$list.merchants_name}</td>
						<td>{$list.amount}</td>
						<td>
							{if $list.account_type eq 'bank'}
								银行卡
							{else if $list.account_type eq 'alipay'}
								支付宝
							{/if}
						</td>
						<td>
							{$list.account_number}<br>
							{$list.bank_name}
						</td>
						<td>{$list.add_time}</td>
						<td>
							{if $list.status eq 1}
								待审核
							{else if $list.status eq 2}
								已通过
							{else if $list.status eq 3}
								已拒绝
							{/if}
						</td>
					</tr>
					<!-- {foreachelse} -->
				   	<tr><td class="no-records" colspan="7">{t}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</table>
				<!-- {$data.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->