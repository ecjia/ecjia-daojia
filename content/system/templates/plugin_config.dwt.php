<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">

</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="row-fluid">
	<div class="span3">
		<!-- {ecjia:hook id=display_admin_plugin_menus} -->
	</div>
	<div class="span9">
        <!-- {block name="admin_plugin_list"} -->
		<h3 class="heading">{if $ur_here}{$ur_here}{/if}</h3>
		
		<table class="table table-striped table-hide-edit" data-rowlink="a">
			<thead>
				<tr>
					<th class="w150">{t}名称{/t}</th>
					<th>{t}描述{/t}</th>
					<th class="w80">{t}排序{/t}</th>
					<th class="w80">{t}是否开启{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$list.item item=val} -->
				<tr>
					<td>
						<!-- {if $val.enabled == 1} -->
							<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('notification/admin_notification_channel/edit_name')}&type={$val.channel_type}" data-name="channel_name" data-pk="{$val.channel_id}"  data-title="{t}编辑名称{/t}">{$val.channel_name}</span>
						<!-- {else} -->
							{$val.channel_name}
						<!-- {/if} -->
					</td>
					<td class="hide-edit-area">
						<!-- {if $val.enabled == 1} -->
							{$val.channel_desc|nl2br}
							<div class="edit-list">
								<a class="data-pjax" href='{RC_Uri::url("notification/admin_notification_channel/edit", "code={$val.channel_code}")}&type={$val.channel_type}' title="{t}编辑{/t}">{t}编辑{/t}</a>&nbsp;|&nbsp;
								<a class="switch ecjiafc-red" href="javascript:;" data-url='{RC_Uri::url("notification/admin_notification_channel/switch_state", "code={$val.channel_code}")}&enabled=0' title="{t}禁用{/t}">{t}禁用{/t}</a>
							</div>
						<!-- {else} -->
							{$val.channel_desc|nl2br}
							<div class="edit-list">
								<a class="switch" href="javascript:;" data-url='{RC_Uri::url("notification/admin_notification_channel/switch_state", "code={$val.channel_code}")}&enabled=1' title="{t}启用{/t}">{t}启用{/t}</a>
							</div>
						<!-- {/if} -->
					</td>
					<td>
						<!-- {if $val.enabled == 1} -->
							<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('notification/admin_notification_channel/edit_order')}&type={$val.channel_type}" data-name="sort_order" data-pk="{$val.channel_id}" data-title="{t}编辑排序{/t}">{$val.sort_order}</span>
						<!-- {else} -->
							{$val.sort_order}
						<!-- {/if} -->
					</td>
					<td>
						<i class="{if $val.enabled eq 1}fontello-icon-ok{else}fontello-icon-cancel{/if}"></i>
					</td>
				</tr>
				<!-- {foreachelse} -->
				<tr><td class="no-records" colspan="4">{t}没有找到任何记录{/t}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$list.page} -->
		<!-- {/block} -->
	</div>
</div>    
<!-- {/block} -->