<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.privilege.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
	<!-- {/if} -->
</h3>

<div class="row-fluid">
	<div class="control-group form-horizontal choose_list span12">
		<form class="f_r" name="searchForm" method="post" action="{url path='@privilege/init'}">
			<select class="w100" name="key_type">
				<option value="1" {if $key_type == 1}selected{/if}>{t}用户名{/t}</option>
				<option value="2" {if $key_type == 2}selected{/if}>{t}用户ID{/t}</option>
				<option value="3" {if $key_type == 3}selected{/if}>{t}用户邮箱{/t}</option>
			</select>
			<input type="text" name="keyword"  placeholder="{t}请输入相应的关键字{/t}"/> 
			<button class="btn" type="submit">{t}搜索{/t}</button>
		</form>
	</div>
</div>

<table class="table table-striped" id="smpl_tbl">
	<thead>
		<tr data-sorthref="{url path='@privilege/init'}">
			<th class="w50" data-toggle="sortby" data-sortby="user_id">{t}编号{/t}</th>
			<th class="w150" data-toggle="sortby" data-sortby="user_name">{t}用户名{/t}</th>
			<th>{t}Email地址{/t}</th>
			<th class="w150" data-toggle="sortby" data-sortby="add_time">{t}加入时间{/t}</th>
			<th class="w150" data-toggle="sortby" data-sortby="last_login">{t}最后登录时间{/t}</th>
			<th class="w150">{t}操作{/t}</th>
		</tr>
	</thead>
	<tbody>
		<!-- {foreach from=$admin_list.list item=list} -->
		<tr>
			<td class="first-cell" >{$list.user_id}</td>
			<td class="first-cell" >{$list.user_name}</td>
			<td align="left">{$list.email}</td>
			<td align="center">{$list.add_time}</td>
			<td align="center">{$list.last_login}</td>
			<td align="center">
				<a {if $list.action_list != 'all'}class="data-pjax no-underline" href='{url path="@privilege/allot" args="id={$list.user_id}"}'{else}class="nodel stop_color no-underline" href="javascript:;"{/if}  title="{t}分派权限{/t}"><i class="fontello-icon-cog"></i></a>&nbsp;&nbsp;
				<a class="no-underline" href='{url path="@admin_logs/init" args="user_id={$list.user_id}"}' title="{t}查看日志{/t}"><i class="fontello-icon-doc-text"></i></a>&nbsp;&nbsp;
				<a {if $list.action_list != 'all'}class="data-pjax no-underline" href='{url path="@privilege/edit" args="id={$list.user_id}"}'{else}class="nodel stop_color no-underline" href="javascript:;"{/if} title="{t}编辑{/t}"><i class="fontello-icon-edit"></i></a>&nbsp;&nbsp;
				<a {if $list.action_list != 'all'}class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{t}您确定要删除用户该用户吗？{/t}" href='{url path="@privilege/remove" args="id={$list.user_id}"}'{else}class="nodel stop_color no-underline" href="javascript:;"{/if} title="{t}移除{/t}"><i class="fontello-icon-trash"></i></a>
			</td>
		</tr>
		<!-- {foreachelse} -->
		<tr>
			<td class="no-records" colspan="10">{t}没有找到任何记录{/t}</td>
		</tr>
		<!-- {/foreach} -->
	</tbody>
</table>
<!-- {$admin_list.page} -->
<!-- {/block} -->