<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.match_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="page-header">
	<h2 class="pull-left">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<!-- {/if} -->
	</h2>
	<div class="clearfix">
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<form class="form-inline" method="post" action="{$search_action}" name="searchForm">
					<div class="f_r form-group">
						<input type="text" name="keyword" class="form-control" value="{$smarty.get.keyword}" placeholder="请输入名称或手机号"/>
						<a class="btn btn-primary m_l5 search_match"><i class="fa fa-search"></i> 搜索</a>
					</div>
				</form>
			</div>

			<div class="panel-body panel-body-small">
				<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
					<thead>
						<tr>
							<th class="w150">配送员名称</th>
						    <th class="w150">手机号</th>
						    <th class="w150">订单数</th>
						    <th class="w100">配送总费用</th>
						    <th class="w100">配送员总应得</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$data.list item=match} -->
					    <tr>
					      	<td class="hide-edit-area">
								{$match.name}
					     	  	<div class="edit-list">
								  	<a class="data-pjax" href='{url path="express/mh_match/detail" args="user_id={$match.user_id}"}' title="查看详情">查看详情</a>
					    	  	</div>
					      	</td>
					      	<td>{$match.mobile}</td>
					      	<td>{if $match.order_number}{$match.order_number}{else}0{/if}</td>
					      	<td>{$match.money.all_money}</td>
					      	<td>{$match.money.express_money} </td>
					    </tr>
					    <!-- {foreachelse} -->
				        <tr><td class="no-records" colspan="6">{lang key='system::system.no_records'}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
				<!-- {$data.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->