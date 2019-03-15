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
				<span>{t domain="express"}选择日期：{/t}</span>
				<input class="date f_l w150" name="start_date" type="text" value="{$smarty.get.start_date}" placeholder='{t domain="express"}请选择开始时间{/t}'>
				<span class="f_l">{t domain="express"}至{/t}</span>
				<input class="date f_l w150" name="end_date" type="text" value="{$smarty.get.end_date}" placeholder='{t domain="express"}请选择结束时间{/t}'>
			
				<select class="w100 " name="work_type" id="select-work">
					<option value="0">{t domain="express"}工作类型{/t}</option>
					<option value="assign" {if $smarty.get.work_type eq 'assign'}selected{/if}>{t domain="express"}派单{/t}</option>
					<option value="grab" {if $smarty.get.work_type eq 'grab'}selected{/if}>{t domain="express"}抢单{/t}</option>
				</select>
				
				<input type="text" name="keyword" value="{$smarty.get.keyword}" placeholder='{t domain="express"}请输入配送员名称或配送单号{/t}'/>
				<button class="btn search_history" type="button">{t domain="express"}搜索{/t}</button>
			</form>
		</div>
	</div>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="w150">{t domain="express"}配送单号{/t}</th>
				    <th class="w150">{t domain="express"}配送员{/t}</th>
				    <th class="w150">{t domain="express"}收货人信息{/t}</th>
				    <th class="w500">{t domain="express"}取/送货地址{/t}</th>
				    <th class="w100">{t domain="express"}任务类型{/t}</th>
				    <th class="w200">{t domain="express"}完成时间{/t}</th>
				    <th class="w100">{t domain="express"}配送状态{/t}</th>
			  	</tr>
			</thead>
			<!-- {foreach from=$data.list item=history} -->
		    <tr>
		      	<td class="hide-edit-area">
					{$history.express_sn}
		     	  	<div class="edit-list">
					  	 <a data-toggle="modal" data-backdrop="static" href="#myModal1" express-id="{$history.express_id}" express-url="{$express_detail}"  title='{t domain="express"}查看详情{/t}'>{t domain="express"}查看详情{/t}</a>
		    	  	</div>
		      	</td>
		      	<td>{$history.express_user}</td>
		      	<td>{$history.consignee}</td>
		      	<td>{t domain="express"}取：{/t}{$history.district}{$history.street}{$history.address}<br>
                    {t domain="express"}送：{/t}{$history.eodistrict}{$history.eostreet}{$history.eoaddress}
		      	</td>
		      	<td>{if $history.from eq 'assign'}{t domain="express"}派单{/t}{else}{t domain="express"}抢单{/t}{/if}</td>
		      	<td>{$history.signed_time}</td>
		      	<td>{t domain="express"}已完成{/t}</td>
		    </tr>
		    <!-- {foreachelse} -->
	        <tr><td class="no-records" colspan="7">{t domain="express"}没有找到任何记录{/t}</td></tr>
			<!-- {/foreach} -->
            </tbody>
         </table>
         <!-- {$data.page} -->
	</div>
</div>
<!-- {/block} -->