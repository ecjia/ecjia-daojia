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
				<th>{t domain="user"}会员注册项名称{/t}</th>
				<th class="w130">{t domain="user"}排序权值{/t}</th>
				<th class="w130">{t domain="user"}是否显示{/t}</th>
				<th class="w130">{t domain="user"}是否必填{/t}</th>
				<th class="w100">{t domain="user"}操作{/t}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$reg_fields item=field} -->
			<tr>
				<td class="first-cell" >
					<!-- {if $field.reg_field_name} -->
					<span class="cursor_pointer" data-trigger="editable" data-url='{url path="user/admin_reg_fields/edit_name"}' data-name="field_name" data-pk="{$field.id}" data-title='{t domain="user"}编辑会员注册名称{/t}'>{$field.reg_field_name}</span>
					<!-- {/if} -->
				</td>
				<td align="center">
					<span class="cursor_pointer" data-trigger="editable" data-url='{url path="user/admin_reg_fields/edit_order"}' data-name="dis_order" data-pk="{$field.id}" data-title='{t domain="user"}编辑排序{/t}'>{$field.dis_order}</span>
				</td>
				<td align="center">
					<i class="cursor_pointer {if $field.display}fontello-icon-ok{else}fontello-icon-cancel{/if}" data-trigger="toggleState" data-url="{url path='user/admin_reg_fields/toggle_dis'}" data-id="{$field.id}" title='{t domain="user"}点击切换状态{/t}'></i>
				</td>
				<td align="center">
					<i class="cursor_pointer {if $field.is_need}fontello-icon-ok{else}fontello-icon-cancel{/if}" data-trigger="toggleState" data-url="{url path='user/admin_reg_fields/toggle_need'}" data-id="{$field.id}" title='{t domain="user"}点击切换状态{/t}'></i>
				</td>
				<td align="right">
					<a href='{url path="user/admin_reg_fields/edit" args="id={$field.id}"}' title='{t domain="user"}编辑{/t}' class="data-pjax no-underline"><i class="fontello-icon-edit"></i></a>
					<!-- {if $field.type eq 0}  -->
					<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg='{t domain="user"}您确定要删除会员注册项吗？{/t}' href='{url path="user/admin_reg_fields/remove" args="id={$field.id}"}' title='{t domain="user"}移除{/t}'><i class="fontello-icon-trash"></i></a>
					<!-- {/if} -->
				</td>
			</tr>
            <!-- {foreachelse} -->
		    <tr><td class="no-records" colspan="5">{t domain="user"}没有找到任何记录{/t}</td></tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
</div>
<!-- {/block} -->