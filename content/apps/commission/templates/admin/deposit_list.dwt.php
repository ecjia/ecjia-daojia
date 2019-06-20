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
        <!-- {if $action_link} -->
        <a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
        <!-- {/if} -->
		<a class="btn plus_or_reply" id="sticky_a" href='{RC_Uri::url("commission/admin/deposit_export", "{if $smarty.get.type}&type={$smarty.get.type}{/if}{$url_parames}")}'><i class="fontello-icon-download"></i>{t domain="commission"}导出{/t}Excel</a>
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<ul class="nav nav-pills">
			<li class="active">
				<a class="data-pjax" href='{$search_action}&type=1{$url_parames}'>{t domain="commission"}已完成{/t}
					<span class="badge badge-info">{$type_count.passed}</span>
				</a>
			</li>
		</ul>
		<ul class="nav nav-pills choose_list " style="border:none;">
			<form class="f_r form-inline" action='{$search_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
    			<input class="date f_l w120" name="start_time" type="text" value="{$smarty.get.start_time}" autocomplete="off" placeholder="{t domain="commission"}开始时间{/t}">
             	<input class="date f_l w120" name="end_time" type="text" value="{$smarty.get.end_time}" autocomplete="off" placeholder="{t domain="commission"}结束时间{/t}">
    			<input type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{t domain="commission"}请输入商家关键字{/t}" size="15" />
    			<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain="commission"}请输入充值流水号{/t}" size="15" />
    			<button class="btn screen-btn" type="submit">{t domain="commission"}搜索{/t}</button>
    		</form>
		</ul>
		<div class="tab-content">
			<div class="row-fluid">
				<table class="table table-striped smpl_tbl dataTable table-hide-edit">
					<thead>
						<tr data-sorthref='{$search_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}{if $smarty.get.start_time}&start_time={$smarty.get.start_time}{/if}
					{if $smarty.get.end_time}&end_time={$smarty.get.end_time}{/if}{if $smarty.get.merchant_keywords}&merchant_keywords={$smarty.get.merchant_keywords}{/if}
					{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>
						    <th>{t domain="commission"}流水号{/t}</th>
						    <th>{t domain="commission"}商家名称{/t}</th>
						    <th>{t domain="commission"}充值金额{/t}</th>
						    <th>{t domain="commission"}充值方式{/t}</th>
						    <th data-toggle="sortby" data-sortby="add_time">{t domain="commission"}申请时间{/t}</th>
						    <th>{t domain="commission"}处理状态{/t}</th>
						</tr>
					</thead>

				 	<!-- {foreach from=$data.item item=list} -->
					<tr>
						<td class="hide-edit-area">
							{$list.order_sn}
							<div class="edit-list">
								<a href='{url path="commission/admin/deposit_detail" args="id={$list.id}"}' class="data-pjax" title="{t domain="commission"}查看详情{/t}">{t domain="commission"}查看详情{/t}</a>
							</div>
						</td>
						<td>{$list.merchants_name}</td>
						<td>{$list.amount}</td>
						<td>
							{if $list.pay_code eq 'bank'}
                            {t domain="commission"}银行卡{/t}
                            {else if $list.pay_code eq 'alipay'}
                            {t domain="commission"}支付宝{/t}
                            {else if $list.pay_code eq 'pay_cash'}
                            {t domain="commission"}现金{/t}
							{/if}
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
				   	<tr><td class="no-records" colspan="6">{t domain="commission"}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</table>
				<!-- {$data.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->