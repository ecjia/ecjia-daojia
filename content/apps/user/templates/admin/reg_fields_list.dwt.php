<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div>
	<table class="table table-striped" data-pjax-url='{url path="user/admin_reg_fields/init"}'>
		<thead>
			<tr>
				<th>{lang key='user::reg_fields.field_name'}</th>
				<th class="w130">{lang key='user::reg_fields.field_order'}</th>
				<th class="w130">{lang key='user::reg_fields.field_display'}</th>
				<th class="w130">{lang key='user::reg_fields.field_need'}</th>
				<th class="w100">{lang key='system::system.handler'}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$reg_fields item=field} -->
			<tr>
				<td class="first-cell" >
					<!-- {if $field.reg_field_name} -->
					<span class="cursor_pointer" data-trigger="editable" data-url='{url path="user/admin_reg_fields/edit_name"}' data-name="field_name" data-pk="{$field.id}" data-title="{lang key='user::reg_fields.edit_field_name'}">{$field.reg_field_name}</span>
					<!-- {/if} -->
				</td>
				<td align="center">
					<span class="cursor_pointer" data-trigger="editable" data-url='{url path="user/admin_reg_fields/edit_order"}' data-name="dis_order" data-pk="{$field.id}" data-title="{lang key='user::reg_fields.edit_sequence'}">{$field.dis_order}</span>
				</td>
				<td align="center">
					<i class="cursor_pointer {if $field.display}fontello-icon-ok{else}fontello-icon-cancel{/if}" data-trigger="toggleState" data-url="{url path='user/admin_reg_fields/toggle_dis'}" data-id="{$field.id}" title="{lang key='user::reg_fields.click_switch_status'}"></i>
				</td>
				<td align="center">
					<i class="cursor_pointer {if $field.is_need}fontello-icon-ok{else}fontello-icon-cancel{/if}" data-trigger="toggleState" data-url="{url path='user/admin_reg_fields/toggle_need'}" data-id="{$field.id}" title="{lang key='user::reg_fields.click_switch_status'}"></i>
				</td>
				<td align="right">
					<a href='{url path="user/admin_reg_fields/edit" args="id={$field.id}"}' title="{lang key='system::system.edit'}" class="data-pjax no-underline"><i class="fontello-icon-edit"></i></a>
					<!-- {if $field.type eq 0}  -->
					<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='user::reg_fields.delete_field_confirm'}" href='{url path="user/admin_reg_fields/remove" args="id={$field.id}"}' title="{lang key='user::reg_fields.delete'}"><i class="fontello-icon-trash"></i></a>
					<!-- {/if} -->
				</td>
			</tr>
            <!-- {foreachelse} -->
		    <tr><td class="no-records" colspan="5">{lang key='system::system.no_records'}</td></tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
</div>
<!-- {/block} -->