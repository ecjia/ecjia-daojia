<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
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
<div class="row-fluid list-page">
	<div class="span12">
		<table class="table table-striped table-hide-edit" data-rowlink="a">
			<thead>
				<tr>
					<th class="w50">{lang key='mobile::mobile.app_id'}</th>
					<th>{lang key='mobile::mobile.app_name'}</th>
					<th>{lang key='mobile::mobile.package_name'}</th>
					<th>{lang key='mobile::mobile.client'}</th>
					<th>{lang key='mobile::mobile.platform'}</th>
					<th>{lang key='mobile::mobile.sort_order'}</th>
					<th class="w100">{lang key='mobile::mobile.create_time'}</th>
				</tr>
			</thead>
			<!-- {foreach from=$mobile_manage.item item=item key=key name=children} -->
			<tr>
				<td>
					{$item.app_id}
				</td>
				<td class="hide-edit-area">
					{$item.app_name}
					<div class="edit-list">
						<a class="data-pjax" href='{RC_Uri::url("mobile/admin_mobile_manage/edit", "id={$item.app_id}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
						<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg="{lang key='mobile::mobile.drop_mobile_confirm'}" href='{RC_Uri::url("mobile/admin_mobile_manage/remove", "id={$item.app_id}")}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
				    </div>
				</td>
				<td>
					{$item.bundle_id}
				</td>
				<td>
					{$item.device_client}
				</td>
				<td>
					<!-- {if $item.platform eq 'umeng-push'} -->
					{lang key='mobile::mobile.umeng_push'}
					<!-- {/if} -->
				</td>
				<td>
					<span class="edit_sort cursor_pointer" data-trigger="editable" data-url='{RC_Uri::url("mobile/admin_mobile_manage/edit_sort", "id={$item.app_id}")}' data-name="sort" data-pk="{$item.app_id}" data-title="{lang key='mobile::mobile.edit_sort'}">{$item.sort}</span>
				</td>
				<td>
					{$item.add_time}
				</td>
			</tr>
			<!-- {foreachelse} -->
			<tr><td class="no-records" colspan="7">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
		</table>
		<!-- {$mobile_manage.page} -->
	</div>
</div>
<!-- {/block} -->