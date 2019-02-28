<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.ucenter_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid batch" >
	<form method="post" action="{$search_action}" name="searchForm">
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{t domain="ucserver"}批量操作{/t}
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a class="button_remove" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{url path="ucenter/admin/batch_remove"}' data-msg='{t domain="ucserver"}您确定要删除选中的应用吗？{/t}' data-noSelectMsg='{t domain="ucserver"}请选择要删除的应用{/t}' data-name="appid" href="javascript:;"><i class="fontello-icon-trash"></i>{t domain="ucserver"}删除{/t}</a></li>
			</ul>
		</div>
	</form>
</div>

<div class="row-fluid list-page">
	<div class="span12">
		<form method="post" action="{$form_action}" name="listForm">
			<table class="table table-striped smpl_tbl table-hide-edit">
				<thead>
					<tr>
						<th class="table_checkbox"><input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/></th>
						<th class="w50">{t domain="ucserver"}ID{/t}</th>
						<th>{t domain="ucserver"}应用名称{/t}</th>
						<th class="w300">{t domain="ucserver"}应用的主 URL{/t}</th>
						<th class="w150">{t domain="ucserver"}通信情况{/t}</th>
					</tr>
				</thead>
				<tbody>
				<!-- {foreach from=$list.item item=val} -->
				<tr>
					<td>
						<span><input type="checkbox" name="checkboxes[]" class="checkbox" value="{$val.appid}"/></span>
					</td>
					<td>
						{$val.appid}
					</td>
					<td class="hide-edit-area">
						{$val.name}
						<div class="edit-list">
							<a class="data-pjax" href='{RC_Uri::url("ucserver/admin/edit", "id={$val.appid}")}' title='{t domain="ucserver"}编辑{/t}'>{t domain="ucserver"}编辑{/t}</a>&nbsp;|&nbsp;
				      		<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="ucserver"}您确定要删除该应用吗？{/t}' href='{RC_Uri::url("ucserver/admin/remove","id={$val.appid}")}' title='{t domain="ucserver"}删除{/t}'>{t domain="ucserver"}删除{/t}</a>
						</div>
					</td>
					<td>{$val.url}</td>
					<td class="app_linkstatus" data-href="{RC_Uri::url('ucserver/admin/ping')}" data-url="{$val.url}" data-ip="{$val.ip}" data-appid="{$val.appid}" id="app_{$val.appid}"></td>
				</tr>
				<!--  {foreachelse} -->
				<tr><td class="no-records" colspan="6">{t domain="ucserver"}没有找到任何记录{/t}</td></tr>
				<!-- {/foreach} -->
				</tbody>
			</table>
			<!-- {$list.page} -->
		</form>
	</div>
</div>
<!-- {/block} -->
