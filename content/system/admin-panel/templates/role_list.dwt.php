<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn data-pjax plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<table class="table table-striped" id="smpl_tbl">
	<thead>
		<tr>
			<th>{t}角色ID{/t}</th>
			<th>{t}角色名{/t}</th>
			<th>{t}角色描述{/t}</th>
			<th class="w100">{t}操作{/t}</th>
		</tr>
	</thead>
	<tbody>
		<!-- {foreach from=$admin_list.list item=list} -->
		<tr>
			<td class="first-cell" >{$list.role_id}</td>
			<td class="first-cell" >{$list.role_name}</td>
			<td class="first-cell" >{$list.role_describe}</td>
			<td align="center">
				<a class="data-pjax no-underline" href='{url path="@admin_role/edit" args="id={$list.role_id}"}' title="{t}编辑{/t}"><i class="fontello-icon-edit"></i></a>
				<a class="no-underline" data-toggle="ajaxremove" data-msg="{t}您确定要删除该角色吗？{/t}" href='{url path="@admin_role/remove" args="id={$list.role_id}"}' title="{t}移除{/t}"><i class="fontello-icon-trash"></i></a>
			</td>
		</tr>
		<!-- {foreachelse} -->
		<tr><td class="no-records" colspan="10">{t}没有找到任何记录{/t}</td></tr>
		<!-- {/foreach} -->
	</tbody>
</table>
<!-- {$admin_list.page} -->
<!-- {/block} -->