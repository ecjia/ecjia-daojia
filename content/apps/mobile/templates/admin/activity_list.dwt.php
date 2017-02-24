<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.activity.init();
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
		<form method="post" action="{$search_action}" name="searchForm">
			<div class="choose_list f_r">
				<input type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='mobile::mobile.fill_activity_name'}"/> 
				<input class="screen-btn btn" type="submit" value="{lang key='mobile::mobile.search'}">
			</div>
		</form>
	</div>	
	<div class="row-fluid">
		<div class="span12">
			<div class="row-fluid">
				<table class="table table-striped smpl_tbl table-hide-edit">
					<thead>
						<tr>
						    <th>{lang key='mobile::mobile.activity_name'}</th>
						    <th class="w100">{lang key='mobile::mobile.activity_group'}</th>
						    <th class="w100">{lang key='mobile::mobile.activity_object'}</th>
						    <th class="w120">{lang key='mobile::mobile.activity_restrict_num'}</th>
						    <th class="w150">{lang key='mobile::mobile.start_date'}</th>
						    <th class="w150">{lang key='mobile::mobile.end_date'}</th>
						    <th class="w70">{lang key='mobile::mobile.is_open'}</th>
					  	</tr>
					</thead>
					<!-- {foreach from=$activity_list.item item=act} -->
				    <tr>
				      <td class="hide-edit-area">
				      <span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('mobile/admin_mobile_activity/edit_activity_name')}" data-name="activity_name" data-pk="{$act.activity_id}" data-title="{lang key='mobile::mobile.edit_activity_name'}">{$act.activity_name}</span>
			     	  <div class="edit-list">
						  <a class="data-pjax" href='{url path="mobile/admin_mobile_activity/edit" args="id={$act.activity_id}"}'  title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
						  <a class="data-pjax" href='{url path="mobile/admin_mobile_activity/activity_prize" args="id={$act.activity_id}"}'  title="{lang key='mobile::mobile.prize_pool'}">{lang key='mobile::mobile.prize_pool'}</a>&nbsp;|&nbsp;
						  <a class="data-pjax" href='{url path="mobile/admin_mobile_activity/activity_record" args="id={$act.activity_id}"}'  title="{lang key='mobile::mobile.activity_record'}">{lang key='mobile::mobile.activity_record'}</a>&nbsp;|&nbsp;
						  <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='mobile::mobile.delete_confirm'}" href='{url path="mobile/admin_mobile_activity/remove" args="id={$act.activity_id}"}' title="{lang key='mobile::mobile.delete'}">{lang key='mobile::mobile.delete'}</a>
			    	  </div>
				      </td>
				      <td>
				      	<!-- {if $act.activity_group eq '1'} -->{lang key='mobile::mobile.shake'}<!-- {/if} -->
				      </td>
				      <td>
				      	{if $act.activity_object eq '1'} APP
				      	{elseif $act.activity_object eq '2'} PC
				      	{elseif $act.activity_object eq '3'} Touch
				      	{/if}
				      </td>
				      <td>{$act.limit_num}</td>
				      <td>{$act.start_time}</td>
				      <td>{$act.end_time}</td>
				      <td>
				    	<i class="{if $act.enabled eq '1'}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('mobile/admin_mobile_activity/toggle_show')}" data-id="{$act.activity_id}"></i>
					  </td>
				    </tr>
				    <!-- {foreachelse} -->
			        <tr><td class="no-records" colspan="7">{lang key='system::system.no_records'}</td></tr>
					<!-- {/foreach} -->
		            </tbody>
		         </table>
		         <!-- {$activity_list.page} -->
	         </div>
         </div>
	</div>
<!-- {/block} -->