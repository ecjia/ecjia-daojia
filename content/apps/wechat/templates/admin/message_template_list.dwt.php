<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.message_template_list.init();
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
<div class="row-fluid">
	<table class="table table-striped smpl_tbl dataTable table-hide-edit" id="plugin-table">
		<thead>
			<tr>
				<th class="w200">{lang key='wechat::wechat.message_template_name'}</th>
				<th class="w200">{lang key='wechat::wechat.message_topic'}</th>
				<th>{lang key='wechat::wechat.message_content'}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$templates item=list} -->
			<tr>
				 <td class="hide-edit-area hide_edit_area_bottom"> 
				 	{$list.template_code}
					<div class="edit-list">
					 <a class="data-pjax no-underline" href='{url path="wechat/admin_template/edit" args="id={$list.template_id}"}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
	                 <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='wechat::wechat.delete_confirm'}" href='{RC_Uri::url("wechat/admin_template/remove", "id={$list.template_id}")}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
					</div>
				 </td>
				<td>{$list.template_subject}</td>
				<td>{$list.template_content}</td>
			</tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
</div>
<!-- {/block} -->