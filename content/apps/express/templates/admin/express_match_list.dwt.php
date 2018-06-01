<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.match_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<!-- 批量操作和搜索 -->
<div class="row-fluid" >
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="choose_list f_r">
			<input type="text" name="keyword" value="{$smarty.get.keyword}" placeholder="请输入配送员名称或手机号"/> 
			<button class="btn search_match" type="button">搜索</button>
		</div>
	</form>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="w150">配送员名称</th>
				    <th class="w150">手机号</th>
				    <th class="w150">订单数</th>
				    <th class="w100">配送总费用</th>
				    <th class="w100">平台总应得</th>
				    <th class="w100">配送员总应得</th>
			  	</tr>
			</thead>
			<!-- {foreach from=$data.list item=match} -->
		    <tr>
		      	<td class="hide-edit-area">
					{$match.name}
		     	  	<div class="edit-list">
					  	<a target="_blank"   href='{url path="express/admin_match/detail" args="user_id={$match.user_id}"}' title="查看详情">查看详情</a>
		    	  	</div>
		      	</td>
		      	<td>{$match.mobile}</td>
		      	<td>{if $match.order_number}{$match.order_number}{else}0{/if}</td>
		      	<td>{$match.money.all_money}</td>
		      	<td>{$match.money.store_money} </td>
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
<!-- {/block} -->