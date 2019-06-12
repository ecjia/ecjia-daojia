<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.admin.bill_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<strong>{t domain="commission"}温馨提示：{/t}</strong>{t domain="commission"}每月1日生成上月账单，当月账单未出请查看每日账单和订单分成{/t}
</div>
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $smarty.get.store_id && $smarty.get.refer neq 'store'} -->
			<a class="btn plus_or_reply" href='{RC_Uri::url("commission/admin/init", "{$url_args}")}'><i class="fontello-icon-reply"></i>{t domain="commission"}返回全部{/t}</a>
		<!-- {/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply {if $smarty.get.refer neq 'store'}data-pjax{/if}" href="{$action_link.href}" {if $smarty.get.refer eq 'store'}target="_blank"{/if}><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
		<a class="btn plus_or_reply" id="sticky_a" href='{RC_Uri::url("commission/admin/export", "{$url_parames}")}'><i class="fontello-icon-download"></i>{t domain="commission"}导出结果{/t}</a>
	</h3>
</div>

<div class="row-fluid">
	{if $smarty.get.refer eq 'store'}
	<div class="span3">
		<!-- {ecjia:hook id=display_admin_store_menus} -->
	</div>
	{/if}
	<div class="{if $smarty.get.refer eq 'store'}span9{/if}">
		{if $smarty.get.refer neq 'store'}
			<ul class="nav nav-pills choose_list " style="border:none;">
    			<form class="f_r form-inline" action='{RC_Uri::url("commission/admin/init")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
    				<!-- 关键字 -->
    				<input class="date f_l w120" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder="{t domain="commission"}开始时间{/t}">
                    <input class="date f_l w120" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder="{t domain="commission"}结束时间{/t}">
    				<input type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{t domain="commission"}请输入商家关键字{/t}" size="15" />
    				<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain="commission"}账单编号{/t}" size="15" />
    				<button class="btn screen-btn" type="submit">{t domain="commission"}搜索{/t}</button>
    			</form>
			</ul>
			{/if}

		<div class="tab-content">
			<div class="row-fluid">
				<table class="table table-striped smpl_tbl dataTable table-hide-edit">
					<thead>
						<tr >
							<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
						    <th>{t domain="commission"}账单编号{/t}</th>
						    {if $smarty.get.refer neq 'store'}<th>{t domain="commission"}商家名称{/t}</th>{/if}
						    <th>{t domain="commission"}订单{/t}</th>
                            <th>{t domain="commission"}退款{/t}</th>
						    <th>{t domain="commission"}入账金额{/t}</th>
						    <th>{t domain="commission"}退款金额{/t}</th>
						    <th>{t domain="commission"}佣金比例{/t}</th>
						    <th>{t domain="commission"}商家有效佣金{/t}</th>
						 </tr>
					</thead>

				 	<!-- {foreach from=$bill_list.item item=commission} -->
					<tr>
						<td><span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$commission.bill_id}"/></span></td>
						<td>
						<a {if $smarty.get.refer eq 'store'} target="_blank"{else}class="data-pjax"{/if} href='{RC_Uri::url("commission/admin/detail","id={$commission.bill_id}{if $smarty.get.store_id}&store_id={$smarty.get.store_id}{/if}")}' title="{t domain="commission"}账单详情{/t}">
							{$commission.bill_sn}
							</a>
							<!-- <div class="edit-list">
  								<a class="data-pjax" href='{RC_Uri::url("store/admin_commission/order_list","store_id={$commission.store_id}")}' title="订单列表">{t domain="commission"}订单列表{/t}</a>&nbsp;|&nbsp;
  								<a class="data-pjax" href='{RC_Uri::url("store/admin_commission/edit","id={$commission.id}&store_id={$commission.store_id}")}' title="编辑">{t domain="commission"}编辑{/t}</a>&nbsp;|&nbsp;
  								<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg="{t domain="commission"}您确定要删除吗？{/t}" href='{RC_Uri::url("store/admin_commission/remove","id={$commission.id}")}' title="删除">{t domain="commission"}删除{/t}</a>
							</div> -->
						</td>
					    {if $smarty.get.refer neq 'store'}
					    <td> {assign var=store_url value=RC_Uri::url('store/admin/preview',"store_id={$commission.store_id}")}
    					     <a href='{RC_Uri::url("commission/admin/init", "store_id={$commission.store_id}")}' title="{t domain="commission"}查看此商家账单{/t}">{$commission.merchants_name}</a>
    					     <a href='{$store_url}' title="{t domain="commission"}查看商家资料{/t}" target="_blank"><i class="fontello-icon-info-circled"></i></a>
					    </td>
					    {/if}
					    <td>{$commission.order_count}</td>
    					<td>{$commission.refund_count}</td>
					    <td class="ecjiaf-tar">{$commission.order_amount_formatted}</td>
					    <td class="">{$commission.refund_amount_formatted}</td>
					    <!-- {if $commission.percent_value} -->
					    <td>{$commission.percent_value}%</td>
					    <!-- {else} -->
					    <td>{t domain="commission"}0{/t}</td>
					    <!-- {/if} -->
					    <td>{$commission.bill_amount_formatted}</td>
					</tr>
					<!-- {foreachelse} -->
				   	<tr><td class="no-records" colspan="9">{t domain="commission"}没有找到任何记录{/t}</td></tr>
					<!-- {/foreach} -->
				</table>
				<!-- {$bill_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->