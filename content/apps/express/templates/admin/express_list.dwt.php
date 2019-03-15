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
		<h3>{t domain="express"}配送员当前位置{/t}</h3>
	</div>
	<div class="modal-body">
		<div id="allmap"></div>
	</div>
</div>

<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<ul class="nav nav-pills">
		<li class="{if $type eq ''}active{/if}"><a class="data-pjax" href='{url path="express/admin_express/init" args="{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>{t domain="express"}全部{/t} <span class="badge badge-info">{if $type_count.count}{$type_count.count}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'online'}active{/if}"><a class="data-pjax" href='{url path="express/admin_express/init" args="type=online{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>{t domain="express"}在线{/t} <span class="badge badge-info">{if $type_count.online}{$type_count.online}{else}0{/if}</span> </a></li>
		<li class="{if $type eq 'offline'}active{/if}"><a class="data-pjax" href='{url path="express/admin_express/init" args="type=offline{if $filter.keyword}&keyword={$filter.keyword}{/if}"}'>{t domain="express"}离线{/t} <span class="badge badge-info">{if $type_count.offline}{$type_count.offline}{else}0{/if}</span> </a></li>
	</ul>
	
	<form method="post" action="{$search_action}{if $type}&type={$type}{/if}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{t domain="express"}批量操作{/t}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='express/admin_express/batch'}" data-msg='{t domain="express"}您确实要删除选中的配送员吗？{/t}' data-noSelectMsg='{t domain="express"}请先选中要删除的配送员！{/t}' data-name="user_id" href="javascript:;"><i class="fontello-icon-trash"></i>{t domain="express"}删除配送员{/t}</a></li>
			</ul>
		</div>
		
		<select class="w150" name="work_type" id="select-work">
			<option value="0">{t domain="express"}工作类型{/t}</option>
			<option value="1" {if $smarty.get.work_type eq 1}selected{/if}>{t domain="express"}派单{/t}</option>
			<option value="2" {if $smarty.get.work_type eq 2}selected{/if}>{t domain="express"}抢单{/t}</option>
		</select>
		<a class="btn m_l5 screen-btn">{t domain="express"}筛选{/t}</a>
		
		<div class="choose_list f_r">
			<input type="text" name="keyword" value="{$smarty.get.keyword}" placeholder='{t domain="express"}请输入配送员名称或手机号{/t}'/>
			<button class="btn search_express" type="button">{t domain="express"}搜索{/t}</button>
		</div>
	</form>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
				    <th class="w150">{t domain="express"}配送员名称{/t}</th>
				    <th class="w150">{t domain="express"}手机号{/t}</th>
				    <th class="w150">{t domain="express"}信用等级{/t}</th>
				    <th class="w100">{t domain="express"}账户余额{/t}</th>
				    <th class="w100">{t domain="express"}工作类型{/t}</th>
				    <th class="w100">{t domain="express"}工作状态{/t}</th>
				    <th class="w150">{t domain="express"}添加时间{/t}</th>
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
					  	<a class="data-pjax" href='{url path="express/admin_express/edit" args="user_id={$express.user_id}"}' title='{t domain="express"}编辑{/t}'>{t domain="express"}编辑{/t}</a>&nbsp;|&nbsp;
					  	<a class="data-pjax" href='{url path="express/admin_express/detail" args="user_id={$express.user_id}"}' title='{t domain="express"}查看详情{/t}'>{t domain="express"}查看详情{/t}</a>&nbsp;|&nbsp;
					  	{if $express.online_status eq '1'}<a data-toggle="modal" data-backdrop="static" href="#myModal1" exmobile="{$express.mobile}" exname="{$express.name}" exlng="{$express.longitude}" exlat="{$express.latitude}" title='{t domain="express"}当前位置{/t}'>{t domain="express"}当前位置{/t}</a>&nbsp;|&nbsp;{/if}
					  	<a target="_blank"   href='{url path="express/admin_express/account_list" args="user_id={$express.user_id}"}' title='{t domain="express"}查看账目明细{/t}'>{t domain="express"}查看账目明细{/t}</a>&nbsp;|&nbsp;
			          	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="express" 1={$express.name}}你确定要删除配送员【%1】吗？{/t}' href='{url path="express/admin_express/remove" args="user_id={$express.user_id}"}' title='{t domain="express"}删除{/t}'>{t domain="express"}删除{/t}</a>
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
		      	<td>{if $express.work_type eq 1}{t domain="express"}派单{/t}{else}{t domain="express"}抢单{/t}{/if}</td>
		      	<td>{if $express.online_status eq 1}{t domain="express"}在线{/t}{else}<font class="ecjiafc-red">{t domain="express"}离线{/t}</font>{/if}</td>
		      	<td>{$express.add_time}</td>
		    </tr>
		    <!-- {foreachelse} -->
	        <tr><td class="no-records" colspan="8">{t domain="express"}没有找到任何记录{/t}</td></tr>
			<!-- {/foreach} -->
            </tbody>
         </table>
         <!-- {$data.page} -->
	</div>
</div>
<!-- {/block} -->