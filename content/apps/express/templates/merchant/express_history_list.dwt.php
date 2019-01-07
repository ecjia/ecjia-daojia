<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.history_list.init();
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

<div class="modal fade" id="myModal1"></div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<ul class="nav nav-pills pull-left">
					<li class="{if !$smarty.get.type}active{/if}"><a class="data-pjax" href='{url path="express/mh_history/init" args="{if $smarty.get.start_date}&start_date={$smarty.get.start_date}{/if}{if $smarty.get.end_date}&end_date={$smarty.get.end_date}{/if}{if $smarty.get.keyword}&keyword={$smarty.get.keyword}{/if}"}'>平台配送 <span class="badge badge-info">{if $type_count.platform}{$type_count.platform}{else}0{/if}</span> </a></li>
					<li class="{if $smarty.get.type eq 'merchant'}active{/if}"><a class="data-pjax" href='{url path="express/mh_history/init" args="type=merchant{if $smarty.get.start_date}&start_date={$smarty.get.start_date}{/if}{if $smarty.get.end_date}&end_date={$smarty.get.end_date}{/if}{if $smarty.get.keyword}&keyword={$smarty.get.keyword}{/if}"}'>商家配送 <span class="badge badge-info">{if $type_count.merchant}{$type_count.merchant}{else}0{/if}</span> </a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			
			<div class="panel-body panel-body-small">
				<form class="form-inline" action="{$search_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}" method="post" name="searchForm">
					<span>选择日期：</span>
                    <input class="form-control date w110" name="start_date" type="text" placeholder="开始时间" value="{$smarty.get.start_date}" />
    				<span class="">至</span>
    				<input class="form-control date w110" name="end_date" type="text" placeholder="结束时间" value="{$smarty.get.end_date}" />
    				<input type="text" name="keyword" class="form-control" style="width: 200px;" value="{$smarty.get.keyword}" placeholder="请输入配送员名或配送单号"/>
    				
					<a class="btn btn-primary m_l5 search_history">搜索</a>
				</form>
			</div>

			<div class="panel-body panel-body-small">
				<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
					<thead>
						<tr>
							<th class="w100">配送单号</th>
						    <th class="w100">配送员</th>
						    <th class="w200">收货人信息</th>
						    <th class="w50">任务类型</th>
						    <th class="w100">完成时间</th>
						    <th class="w50">配送状态</th>
						</tr>
					</thead>
					<tbody>
						<!-- {foreach from=$data.list item=history} -->
					    <tr>
					      	<td class="hide-edit-area">
								{$history.express_sn}
					     	  	<div class="edit-list">
								  	 <a data-toggle="modal" data-backdrop="static" href="#myModal1" express-id="{$history.express_id}" express-url="{$express_detail}"  title="查看详情">查看详情</a>
					    	  	</div>
					      	</td>
					      	<td>{$history.express_user}</td>
					      	<td>{$history.consignee}<br>
					      		地址：{$history.district}{$history.street}{$history.address}
					      	</td>
					      	<td>{if $history.from eq 'assign'}派单{else}抢单{/if}</td>
					      	<td>{$history.signed_time}</td>
					      	<td>已完成</td>
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