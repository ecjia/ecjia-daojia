<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.mail_template_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="row-fluid">
	<div class="span12">
		<h3 class="heading">
			<!-- {if $ur_here}{$ur_here}{/if} -->
            {$action_links}
		</h3>
	
		<table class="table table-striped smpl_tbl dataTable table-hide-edit" id="plugin-table">
			<thead>
				<tr>
					<th class="w300">{t domain="mail"}模板代号{/t}</th>
					<th>{t domain="mail"}模板主题{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$template item=list} -->
				<tr>
					 <td class="hide-edit-area hide_edit_area_bottom">{$list.template_code}
						<div class="edit-list">
						 <a class="data-pjax no-underline" href='{url path="mail/admin_template/edit" args="id={$list.id}&event_code={$list.template_code}"}' title='{t domain="mail"}编辑{/t}'>{t domain="mail"}编辑{/t}</a>&nbsp;|&nbsp;
		                 <a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="mail"}您确定要删除该邮件模板吗？{/t}' href='{RC_Uri::url("mail/admin_template/remove", "id={$list.id}")}' title='{t domain="mail"}删除{/t}'>{t domain="mail"}删除{/t}</a>
						</div>
					 </td>
					<td>{$list.template_subject}</td>
				</tr>
                <!-- {foreachelse} -->
                <tr><td class="no-records" colspan="2">{t domain="mail"}没有找到任何记录{/t}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
	</div>
</div>
<!-- {/block} -->