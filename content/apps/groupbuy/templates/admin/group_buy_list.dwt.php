<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.groupbuy_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<!-- <div class="row-fluid"> -->
<!-- <div class="choose_list span12">  -->
	<ul class="nav nav-pills">
		<li class="{if !$groupbuy_list.filter.type}active{/if}"><a class="data-pjax" href='{url path="groupbuy/admin/init"}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>全部 <span class="badge badge-info">{$groupbuy_list.msg_count.count}</span> </a></li>
        <li class="{if $groupbuy_list.filter.type eq 'on_going'}active{/if}"><a class="data-pjax" href='{url path="groupbuy/admin/init" args="type=on_going"}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>进行中 <span class="badge badge-info">{$groupbuy_list.msg_count.on_going}</span> </a></li>
     	<li class="{if $groupbuy_list.filter.type eq 'uncheck'}active{/if}"><a class="data-pjax" href='{url path="groupbuy/admin/init" args="type=uncheck"}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>结束未处理 <span class="badge badge-info">{$groupbuy_list.msg_count.uncheck}</span> </a></li>
      	<li class="{if $groupbuy_list.filter.type eq 'successed'}active{/if}"><a class="data-pjax" href='{url path="groupbuy/admin/init" args="type=successed"}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>成功结束 <span class="badge badge-info">{$groupbuy_list.msg_count.successed}</span> </a></li>
      	<li class="{if $groupbuy_list.filter.type eq 'failed'}active{/if}"><a class="data-pjax" href='{url path="groupbuy/admin/init" args="type=failed"}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}'>失败结束 <span class="badge badge-info">{$groupbuy_list.msg_count.failed}</span> </a></li>
	</ul>
	<!-- </div> -->
<!-- </div> -->
	
<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	
	<form method="post" action="{$search_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}" name="searchForm">
		<div class="choose_list f_r" >
			<input type="text" name="keywords" value="{$groupbuy_list.filter.keywords}" placeholder="请输入团购商品名称"/>
			<button class="btn search-btn" type="button">{t}搜索{/t}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<form method="POST" action="{$form_action}" name="listForm">
			<table class="table table-striped smpl_tbl dataTable table-hide-edit">
				<thead>
					<tr data-sorthref='{RC_Uri::url("groupbuy/admin/init", "{if $smarty.get.type}&type={$smarty.get.type}{/if}")}'>
						<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
						<th class="w200">{t}商品名称{/t}</th>
						<th class="w100">{t}商家名称{/t}</th>
						<th class="w70">{t}限购数量{/t}</th>
						<th class="w70">{t}订单数量{/t}</th>
				    	<th class="w70">{t}保证金{/t}</th>
				    	<th class="w70">{t}当前价格{/t}</th>
				    	<th class="w100" data-toggle="sortby" data-sortby="end_time">{t}结束时间{/t}</th>
				    	<th class="w80">{t}状态{/t}</th>
	                </tr>
				</thead>
				<tbody>
					<!-- {foreach from=$groupbuy_list.groupbuy item=list} -->
					<tr>
						<td>
							<span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$list.act_id}"/></span>
						</td>
						<td class="hide-edit-area">
							{$list.goods_name}<br>
							<div class="edit-list">
							{assign var=edit_url value=RC_Uri::url('groupbuy/admin/view',"id={$list.act_id}")}
							<a class="data-pjax" href="{$edit_url}{if $smarty.get.page}&page={$smarty.get.page}{/if}" title="{t}查看{/t}">{t}活动详情{/t}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{RC_Uri::url("groupbuy/admin/view_order","group_buy_id={$list.act_id}")}' title="{t}查看订单{/t}">{t}查看订单{/t}</a> 
							</div>
						</td>
						<td class="ecjiafc-red">{$list.merchants_name}</td>
						<td>{if $list.restrict_amount}{$list.restrict_amount}{else}0{/if}</td>
						<td>{if $list.valid_order}{$list.valid_order}{else}0{/if}</td>
						<td>{if $list.deposit}{$list.deposit}{else}0{/if}</td>
						<td>{$list.cur_price}</td>
						<td>{$list.end_time}</td>
						<td>{$list.cur_status}</td>
					</tr>
					<!-- {foreachelse} -->
					<tr><td class="no-records" colspan="10">{t}没有找到任何记录{/t}</td></tr>
				<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$groupbuy_list.page} -->
		</form>
	</div>
</div>
<!-- {/block} -->