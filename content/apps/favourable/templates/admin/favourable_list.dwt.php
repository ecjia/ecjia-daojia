<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.favourable_list.init();
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

<!-- 批量操作和搜索 -->
<div class="row-fluid batch" >
	<ul class="nav nav-pills">
		<li class="{if $smarty.get.type eq ''}active{/if}"><a class="data-pjax" href='{$favourable_list.quickuri.init}'>{t domain="favourable"}全部{/t} <span class="badge badge-info">{if $favourable_list.count.count}{$favourable_list.count.count}{else}0{/if}</span> </a></li>
		<li class="{if $smarty.get.type eq 'on_going'}active{/if}"><a class="data-pjax" href='{$favourable_list.quickuri.on_going}'>{t domain="favourable"}正在进行中{/t}<span class="badge badge-info">{if $favourable_list.count.on_going}{$favourable_list.count.on_going}{else}0{/if}</span> </a></li>
		<!-- {if $shop_type neq 'b2c'} -->
		<li class="{if $smarty.get.type eq 'self'}active{/if}"><a class="data-pjax" href='{$favourable_list.quickuri.self}'>{t domain="favourable"}自营{/t}<span class="badge badge-info">{if $favourable_list.count.self}{$favourable_list.count.self}{else}0{/if}</span> </a></li>
		<!-- {/if} -->
	</ul>
	
	<form method="post" action="{$search_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{t domain="favourable"}批量操作{/t}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='favourable/admin/batch'}" data-msg='{t domain="favourable"}您确实要删除选中的优惠活动吗？{/t}' data-noSelectMsg="{t domain="favourable"}请先选中要删除的优惠活动！{/t}" data-name="act_id" href="javascript:;"><i class="fontello-icon-trash"></i>{t domain="favourable"}删除优惠活动{/t}</a></li>
			</ul>
		</div>
		<div class="choose_list f_r">
			<!-- {if $shop_type neq 'b2c'} -->
			<input type="text" name="merchant_name" value="{$smarty.get.merchant_name}" placeholder='{t domain="favourable"}请输入商家名称{/t}'/>
			<!-- {/if} -->
			<input type="text" name="keyword" value="{$smarty.get.keyword}" placeholder='{t domain="favourable"}请输入优惠活动名称{/t}'/>
			<button class="btn search_articles" type="button">{t domain="favourable"}搜索{/t}</button>
		</div>
	</form>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
				    <th>{t domain="favourable"}优惠活动名称{/t}</th>
				    <!-- {if $shop_type neq 'b2c'} -->
				    <th>{t domain="favourable"}商家名称{/t}</th>
				    <!-- {/if} -->
				    <th class="w100">{t domain="favourable"}开始时间{/t}</th>
				    <th class="w100">{t domain="favourable"}结束时间{/t}</th>
				    <th class="w100">{t domain="favourable"}金额下限{/t}</th>
				    <th class="w100">{t domain="favourable"}金额上限{/t}</th>
				    <th class="w100">{t domain="favourable"}会员等级{/t}</th>
				    <th class="w50">{t domain="favourable"}排序{/t}</th>
			  	</tr>
			</thead>
			<!-- {foreach from=$favourable_list.item item=favourable} -->
		    <tr>
		    	<td><span><input type="checkbox" class="checkbox" value="{$favourable.act_id}" name="checkboxes[]" ></span></td>
		      	<td class="hide-edit-area">
			      	<span class="cursor_pointer" data-trigger="editable" data-url='{url path="favourable/admin/edit_act_name" args="store_id={$favourable.store_id}"}' data-name="act_name" data-pk="{$favourable.act_id}" data-title='{t domain="favourable"}编辑优惠活动名称{/t}'>{$favourable.act_name}</span>
		     	  	<div class="edit-list">
			          	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="favourable"}您确定要删除该优惠活动吗？{/t}' href='{url path="favourable/admin/remove" args="act_id={$favourable.act_id}"}' title='{t domain="favourable"}删除{/t}'>{t domain="favourable"}删除{/t}</a>
		    	  	</div>
		      	</td>
		      	<!-- {if $shop_type neq 'b2c'} -->
		      	<td class="ecjiafc-red">{if $favourable.merchants_name eq '' }全场通用{else}{$favourable.merchants_name}{/if}</td>
		      	<!-- {/if} -->
		      	<td>{$favourable.start_time}</td>
		      	<td>{$favourable.end_time}</td>
		      	<td>{$favourable.min_amount}</td>
		      	<td>{$favourable.max_amount}</td>
		      	<td>{$favourable.user_rank_name}</td>
		      	<td><span class="edit_sort_order cursor_pointer" data-placement="left" data-trigger="editable" data-url="{RC_Uri::url('favourable/admin/edit_sort_order')}" data-name="sort_order" data-pk="{$favourable.act_id}"  data-title='{t domain="favourable"}编辑优惠活动排序{/t}'>{$favourable.sort_order}</span></td>
		    </tr>
		    <!-- {foreachelse} -->
	        <tr><td class="no-records" colspan="9">{t domain="favourable"}没有找到任何记录{/t}</td></tr>
			<!-- {/foreach} -->
            </tbody>
         </table>
         <!-- {$favourable_list.page} -->
	</div>
</div>
<!-- {/block} -->