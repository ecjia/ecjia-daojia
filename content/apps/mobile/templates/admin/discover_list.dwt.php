<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.cycleimage.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link_special} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link_special.href}"  id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link_special.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid list-page">
	<div class="span12">
		<table class="table table-striped table-hide-edit" data-rowlink="a">
			<thead>
				<tr>
					<th class="w180">{lang key='mobile::mobile.discover_icon'}</th>
					<th class="w300">{lang key='mobile::mobile.discover_url'}</th>
					<th class="w100">{lang key='mobile::mobile.is_show'}</th>
					<th class="w80">{lang key='mobile::mobile.sort_order'}</th>
				</tr>
			</thead>
			<!-- {foreach from=$playerdb item=item key=key} -->
			<tr>
				<td>
					<a href="{$item.src}" title="Image 10" target="_blank">
						<img class="w80 h70" alt="{$item.src}" src="{$item.src}">
					</a>
				</td>
				<td class="hide-edit-area">
					<span><a href="{$item.url}" target="_blank">{$item.url}</a></span><br>
					{$item.text}
					<div class="edit-list">
						<a class="data-pjax" href='{RC_Uri::url("mobile/admin_discover/edit", "id={$key}")}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
						<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg="{lang key='mobile::mobile.drop_discover_confirm'}" href='{RC_Uri::url("mobile/admin_discover/remove", "id={$key}")}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
				    </div>
				</td>
				<td>
			    	<i class="{if $item.display eq '1'}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('mobile/admin_discover/toggle_show')}" data-id="{$key}" ></i>
				</td>
				<td><span class="edit_sort cursor_pointer" data-trigger="editable" data-url='{RC_Uri::url("mobile/admin_discover/edit_sort", "id={$key}")}' data-name="sort" data-pk="{$key}"  data-title="{lang key='mobile::mobile.edit_sort'}">{$item.sort}</span></td>
			</tr>
			<!-- {foreachelse} -->
			<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
		</table>
	</div>
</div> 
<!-- {/block} -->