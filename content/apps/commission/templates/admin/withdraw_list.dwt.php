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
		<a class="btn plus_or_reply" id="sticky_a" href='{RC_Uri::url("commission/admin/withdraw_export", "{if $smarty.get.type}&type={$smarty.get.type}{/if}{$url_parames}")}'><i class="fontello-icon-download"></i>{t domain="commission"}导出{/t}Excel</a>
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<ul class="nav nav-pills">
		    <li class="{if !$smarty.get.type}active{/if}">
				<a class="data-pjax" href='{RC_Uri::url("commission/admin/withdraw", "{$url_parames}")}'>{t domain="commission"}待审核{/t}
					<span class="badge badge-info">{$type_count.wait_check}</span>
				</a>
			</li>
			<li class="{if $smarty.get.type eq 1}active{/if}">
				<a class="data-pjax" href='{RC_Uri::url("commission/admin/withdraw", "type=1{$url_parames}")}'>{t domain="commission"}已通过{/t}
					<span class="badge badge-info">{$type_count.passed}</span>
				</a>
			</li>
			<li class="{if $smarty.get.type eq 2}active{/if}">
				<a class="data-pjax" href='{RC_Uri::url("commission/admin/withdraw", "type=2{$url_parames}")}'>{t domain="commission"}已拒绝{/t}
					<span class="badge badge-info">{$type_count.refused}</span>
				</a>
			</li>
		</ul>
		<ul class="nav nav-pills choose_list " style="border:none;">
			<form class="f_r form-inline" action='{RC_Uri::url("commission/admin/withdraw")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
    			<input class="date f_l w120" name="start_time" type="text" value="{$smarty.get.start_time}" placeholder="{t domain="commission"}开始时间{/t}">
             	<input class="date f_l w120" name="end_time" type="text" value="{$smarty.get.end_time}" placeholder="{t domain="commission"}结束时间{/t}">
    			<input type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{t domain="commission"}请输入商家关键字{/t}" size="15" />
    			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain="commission"}请输入提现流水号{/t}" size="15" />
    			<button class="btn screen-btn" type="submit">{t domain="commission"}搜索{/t}</button>
    		</form>
		</ul>
		<div class="tab-content">
			<div class="row-fluid">
				<table class="table table-striped smpl_tbl dataTable table-hide-edit">
					<thead>
						<tr>
						    <th>{t domain="commission"}流水号{/t}</th>
						    <th>{t domain="commission"}商家名称{/t}</th>
						    <th>{t domain="commission"}提现金额{/t}</th>
						    <th>{t domain="commission"}提现方式{/t}</th>
						    <th>{t domain="commission"}收款账号{/t}</th>
						    <th>{t domain="commission"}申请时间{/t}</th>
						    <th>{t domain="commission"}处理状态{/t}</th>
						</tr>
					</thead>

				 	<!-- {foreach from=$data.item item=list} -->
					<tr>
						<td class="hide-edit-area">
							{$list.order_sn}
							<div class="edit-list">
								<a href='{url path="commission/admin/withdraw_detail" args="id={$list.id}"}' class="data-pjax" title="{t domain="commission"}查看详情{/t}">{t domain="commission"}查看详情{/t}</a>
							</div>
						</td>
						<td>{$list.merchants_name}</td>
						<td>{$list.amount}</td>
						<td>
							{if $list.account_type eq 'bank'}
                            {t domain="commission"}银行卡{/t}
							{else if $list.account_type eq 'alipay'}
                            {t domain="commission"}支付宝{/t}
							{/if}
						</td>
						<td>
							{$list.account_number}<br>
							{$list.bank_name}
						</td>
						<td>{$list.add_time}</td>
						<td>
							{if $list.status eq 1}
                            {t domain="commission"}待审核{/t}
							{else if $list.status eq 2}
                            {t domain="commission"}已通过{/t}
							{else if $list.status eq 3}
                            {t domain="commission"}已拒绝{/t}
							{/if}
						</td>
					</tr>
					<!-- {foreachelse} -->
				   	<tr><td class="no-records" colspan="7">{t domain="commission"}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</table>
				<!-- {$data.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->