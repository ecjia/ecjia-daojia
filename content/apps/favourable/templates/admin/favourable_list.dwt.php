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
		<li class="{if $smarty.get.type eq ''}active{/if}"><a class="data-pjax" href='{$favourable_list.quickuri.init}'>{lang key='favourable::favourable.all'} <span class="badge badge-info">{if $favourable_list.count.count}{$favourable_list.count.count}{else}0{/if}</span> </a></li>
		<li class="{if $smarty.get.type eq 'on_going'}active{/if}"><a class="data-pjax" href='{$favourable_list.quickuri.on_going}'>{lang key='favourable::favourable.on_going'}<span class="badge badge-info">{if $favourable_list.count.on_going}{$favourable_list.count.on_going}{else}0{/if}</span> </a></li>
		<!-- {if $shop_type neq 'b2c'} -->
		<li class="{if $smarty.get.type eq 'self'}active{/if}"><a class="data-pjax" href='{$favourable_list.quickuri.self}'>{lang key='favourable::favourable.self'}<span class="badge badge-info">{if $favourable_list.count.self}{$favourable_list.count.self}{else}0{/if}</span> </a></li>
		<!-- {/if} -->
	</ul>
	
	<form method="post" action="{$search_action}{if $smarty.get.type}&type={$smarty.get.type}{/if}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{lang key='favourable::favourable.batch_operation'}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{url path='favourable/admin/batch'}" data-msg="{lang key='favourable::favourable.batch_drop_confirm'}" data-noSelectMsg="{lang key='favourable::favourable.no_favourable_select'}" data-name="act_id" href="javascript:;"><i class="fontello-icon-trash"></i>{lang key='favourable::favourable.remove_favourable'}</a></li>
			</ul>
		</div>
		<div class="choose_list f_r">
			<!-- {if $shop_type neq 'b2c'} -->
			<input type="text" name="merchant_name" value="{$smarty.get.merchant_name}" placeholder="{lang key='favourable::favourable.pls_enter_merchant_name'}"/>
			<!-- {/if} -->
			<input type="text" name="keyword" value="{$smarty.get.keyword}" placeholder="{lang key='favourable::favourable.pls_enter_name'}"/> 
			<button class="btn search_articles" type="button">{lang key='favourable::favourable.search'}</button>
		</div>
	</form>
</div>
	
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl table-hide-edit">
			<thead>
				<tr>
				    <th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
				    <th>{lang key='favourable::favourable.act_name'}</th>
				    <!-- {if $shop_type neq 'b2c'} -->
				    <th>{lang key='favourable::favourable.merchant_name'}</th>
				    <!-- {/if} -->
				    <th class="w100">{lang key='favourable::favourable.start_time'}</th>
				    <th class="w100">{lang key='favourable::favourable.end_time'}</th>
				    <th class="w100">{lang key='favourable::favourable.min_amount'}</th>
				    <th class="w100">{lang key='favourable::favourable.max_amount'}</th>
				    <th class="w50">{lang key='favourable::favourable.sort'}</th>
			  	</tr>
			</thead>
			<!-- {foreach from=$favourable_list.item item=favourable} -->
		    <tr>
		    	<td><span><input type="checkbox" class="checkbox" value="{$favourable.act_id}" name="checkboxes[]" ></span></td>
		      	<td class="hide-edit-area">
			      	<span class="cursor_pointer" data-trigger="editable" data-url='{url path="favourable/admin/edit_act_name" args="store_id={$favourable.store_id}"}' data-name="act_name" data-pk="{$favourable.act_id}" data-title="{lang key='favourable::favourable.edit_act_name'}">{$favourable.act_name}</span>
		     	  	<div class="edit-list">
					  	<a class="data-pjax" href='{url path="favourable/admin/edit" args="act_id={$favourable.act_id}"}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
			          	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='favourable::favourable.remove_confirm'}" href='{url path="favourable/admin/remove" args="act_id={$favourable.act_id}"}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
		    	  	</div>
		      	</td>
		      	<!-- {if $shop_type neq 'b2c'} -->
		      	<td style="color:red;">{if $favourable.merchants_name eq '' }全场通用{else}{$favourable.merchants_name}{/if}</td>
		      	<!-- {/if} -->
		      	<td>{$favourable.start_time}</td>
		      	<td>{$favourable.end_time}</td>
		      	<td>{$favourable.min_amount}</td>
		      	<td>{$favourable.max_amount}</td>
		      	<td><span class="edit_sort_order cursor_pointer" data-placement="left" data-trigger="editable" data-url="{RC_Uri::url('favourable/admin/edit_sort_order')}" data-name="sort_order" data-pk="{$favourable.act_id}"  data-title="{lang key='favourable::favourable.edit_act_sort'}">{$favourable.sort_order}</span></td>
		    </tr>
		    <!-- {foreachelse} -->
	        <tr><td class="no-records" colspan="8">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
            </tbody>
         </table>
         <!-- {$favourable_list.page} -->
	</div>
</div>
<!-- {/block} -->