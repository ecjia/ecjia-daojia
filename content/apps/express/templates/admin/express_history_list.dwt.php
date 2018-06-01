<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.history_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"  id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="modal hide fade" id="myModal1" style="height:650px;"></div>

<div class="row-fluid">
	<div class="span12">
		<div class="form-group choose_list">
			<form class="f_l" name="searchForm" action="{$search_action}" method="post">
				<span>选择日期：</span>
				<input class="date f_l w150" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder="请选择开始时间">
				<span class="f_l">至</span>
				<input class="date f_l w150" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder="请选择结束时间">
			
				<select class="w100 " name="work_type" id="select-work">
					<option value="0">工作类型</option>
					<option value="assign" {if $smarty.get.work_type eq 'assign'}selected{/if}>派单</option>
					<option value="grab" {if $smarty.get.work_type eq 'grab'}selected{/if}>抢单</option>
				</select>
				
				<input type="text" name="keyword" value="{$smarty.get.keyword}" placeholder="请输入配送员名称或配送单号"/> 
				<button class="btn search_history" type="button">搜索</button>
			</form>
		</div>
	</div>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="w150">配送单号</th>
				    <th class="w150">配送员</th>
				    <th class="w150">收货人信息</th>
				    <th class="w500">取/送货地址</th>
				    <th class="w100">任务类型</th>
				    <th class="w200">完成时间</th>
				    <th class="w100">配送状态</th>
			  	</tr>
			</thead>
			<!-- {foreach from=$data.list item=history} -->
		    <tr>
		      	<td class="hide-edit-area">
					{$history.express_sn}
		     	  	<div class="edit-list">
					  	 <a data-toggle="modal" data-backdrop="static" href="#myModal1" express-id="{$history.express_id}" express-url="{$express_detail}"  title="查看详情">查看详情</a>
		    	  	</div>
		      	</td>
		      	<td>{$history.express_user}</td>
		      	<td>{$history.consignee}</td>
		      	<td>取：{$history.district}{$history.street}{$history.address}<br>
					送：{$history.eodistrict}{$history.eostreet}{$history.eoaddress}
		      	</td>
		      	<td>{if $history.from eq 'assign'}派单{else}抢单{/if}</td>
		      	<td>{$history.signed_time}</td>
		      	<td>已完成</td>
		    </tr>
		    <!-- {foreachelse} -->
	        <tr><td class="no-records" colspan="7">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
            </tbody>
         </table>
         <!-- {$data.page} -->
	</div>
</div>
<!-- {/block} -->