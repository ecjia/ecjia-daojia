<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.ad_position_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<!-- 搜索 -->
<div class="row-fluid batch">
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="choose_list f_r">
			<input type="text" name="keywords" value="{$position_list.filter.keywords}" placeholder="{lang key='adsense::adsense.ad_position_name'}"/>
			<button class="btn search_ad_position" type="button">{lang key='adsense::adsense.search'}</button>
		</div>
	</form>
</div>

<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped smpl_tbl dataTable table-hide-edit">
			<thead>
				<tr>
				    <th class="w70">{lang key='adsense::adsense.ad_id'}</th>
	                <th>{lang key='adsense::adsense.position_name'}</th>
	                <th class="w300">{lang key='adsense::adsense.position_desc'}</th>
				    <th class="w130">{lang key='adsense::adsense.posit_width'}</th>
				    <th class="w130">{lang key='adsense::adsense.posit_height'}</th>
                </tr>
			</thead>
			<tbody>
            	<!-- {foreach from=$position_list.item item=list} -->
				<tr>
					<td><span>{$list.position_id}</span></td>
				    <td class="hide-edit-area hide_edit_area_bottom">
				    	<span class="cursor_pointer" data-text="text" data-trigger="editable" data-url="{RC_Uri::url('adsense/admin_position/edit_position_name')}" data-name="position_name" data-pk="{$list.position_id}" data-title="{lang key='adsense::adsense.edit_ad_position_name'}">{$list.position_name}</span>
				    	<br>
                    	<div class="edit-list">
					      	<a class="data-pjax" href='{RC_Uri::url("adsense/admin/init", "pid={$list.position_id}{if $smarty.get.page}&from_page={$smarty.get.page}{/if}")}' title="{lang key='adsense::adsense.view_ad_content'}">{lang key='adsense::adsense.view_ad_content'}</a>&nbsp;|&nbsp;
					      	<a class="data-pjax" href='{RC_Uri::url("adsense/admin_position/edit", "id={$list.position_id}")}' title="{lang key='system::navigator.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
					    	<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='adsense::adsense.confirm_remove'}" href='{RC_Uri::url("adsense/admin_position/remove", "id={$list.position_id}")}' title="{lang key='adsense::adsense.remove'}">{lang key='adsense::adsense.remove'}</a>
						</div>
				    </td>
				    <td><span>{$list.position_desc}</span></td>
				    <td>
				    	<span class="cursor_pointer" data-text="text" data-trigger="editable" data-url="{RC_Uri::url('adsense/admin_position/edit_ad_width')}" data-name="ad_width" data-pk="{$list.position_id}" data-title="{lang key='adsense::adsense.edit_position_width'}">{$list.ad_width}</span>
				    </td>
				    <td>
					    <span class="cursor_pointer" data-text="text" data-trigger="editable" data-url="{RC_Uri::url('adsense/admin_position/edit_ad_height')}" data-name="ad_height" data-pk="{$list.position_id}" data-title="{lang key='adsense::adsense.edit_position_height'}">{$list.ad_height}</span>
				    </td>
				</tr>
				<!-- {foreachelse} -->
                <tr><td class="no-records" colspan="5">{lang key='system::system.no_records'}</td></tr>
                <!-- {/foreach} -->
            </tbody>
		</table>
		<!-- {$position_list.page} -->
	</div>
</div>
<!-- {/block} -->