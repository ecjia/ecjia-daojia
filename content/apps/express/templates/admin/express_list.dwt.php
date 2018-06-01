<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.express_list.init();
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

<div class="modal hide fade" id="myModal1">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>配送员当前位置</h3>
	</div>
	<div class="modal-body">
		<div id="allmap"></div>
	</div>
</div>

<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<ul class="nav nav-pills">
		<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="express/admin_express/init" args="{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>全部 <span class="badge badge-info">{if $type_count.count}{$type_count.count}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'online'}active{/if}"><a class="data-pjax" href='{url path="express/admin_express/init" args="type=online{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>在线 <span class="badge badge-info">{if $type_count.online}{$type_count.online}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'offline'}active{/if}"><a class="data-pjax" href='{url path="express/admin_express/init" args="type=offline{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>离线 <span class="badge badge-info">{if $type_count.offline}{$type_count.offline}{else}0{/if}</span> </a></li>
	</ul>
	
	<form method="post" action="{$search_action}{if $type}&type={$type}{/if}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>批量操作
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='express/admin_express/batch'}" data-msg="您确实要删除选中的配送员吗？" data-noSelectMsg="请先选中要删除的配送员！" data-name="user_id" href="javascript:;"><i class="fontello-icon-trash"></i>删除配送员</a></li>
			</ul>
		</div>
		
		<select class="w150" name="work_type" id="select-work">
			<option value="0">工作类型</option>
			<option value="1" {if $smarty.get.work_type eq 1}selected{/if}>派单</option>
			<option value="2" {if $smarty.get.work_type eq 2}selected{/if}>抢单</option>
		</select>
		<a class="btn m_l5 screen-btn">筛选</a>
		
		<div class="choose_list f_r">
			<input type="text" name="keyword" value="{$smarty.get.keyword}" placeholder="请输入配送员名称或手机号"/> 
			<button class="btn search_express" type="button">搜索</button>
		</div>
	</form>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
				    <th class="w150">配送员名称</th>
				    <th class="w150">手机号</th>
				    <th class="w150">信用等级</th>
				    <th class="w100">账户余额</th>
				    <th class="w100">工作类型</th>
				    <th class="w100">工作状态</th>
				    <th class="w150">添加时间</th>
			  	</tr>
			</thead>
			<!-- {foreach from=$data.list item=express} -->
		    <tr>
				<td>
					<span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$express.user_id}"/></span>
				</td>
			
		      	<td class="hide-edit-area">
					{$express.name}
		     	  	<div class="edit-list">
					  	<a class="data-pjax" href='{url path="express/admin_express/edit" args="user_id={$express.user_id}"}' title="编辑">编辑</a>&nbsp;|&nbsp;
					  	<a class="data-pjax" href='{url path="express/admin_express/detail" args="user_id={$express.user_id}"}' title="查看详情">查看详情</a>&nbsp;|&nbsp;
					  	{if $express.online_status eq '1'}<a data-toggle="modal" data-backdrop="static" href="#myModal1" exmobile="{$express.mobile}" exname="{$express.name}" exlng="{$express.longitude}" exlat="{$express.latitude}" title="当前位置">当前位置</a>&nbsp;|&nbsp;{/if}
					  	<a target="_blank"   href='{url path="express/admin_express/account_list" args="user_id={$express.user_id}"}' title="查看账目明细">查看账目明细</a>&nbsp;|&nbsp;
			          	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="你确定要删除配送员【{$express.name}】吗？" href='{url path="express/admin_express/remove" args="user_id={$express.user_id}"}' title="删除">删除</a>
		    	  	</div>
		      	</td>
		      	<td>{$express.mobile}</td>
		      	<td>
			      	{section name=loop loop=$express.comment_rank}
			      		<i class="fontello-icon-star" style="color:#FF9933;"></i>
					{/section}
					{section name=loop loop=5-$express.comment_rank}   
						<i class="fontello-icon-star" style="color:#bbb;"></i>
					{/section}
				</td>
		      	<td>¥ {$express.user_money}</td>
		      	<td>{if $express.work_type eq 1}派单{else}抢单{/if}</td>
		      	<td>{if $express.online_status eq 1}在线{else}<font class="ecjiafc-red">离线</font>{/if}</td>
		      	<td>{$express.add_time}</td>
		    </tr>
		    <!-- {foreachelse} -->
	        <tr><td class="no-records" colspan="8">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
            </tbody>
         </table>
         <!-- {$data.page} -->
	</div>
</div>
<!-- {/block} -->