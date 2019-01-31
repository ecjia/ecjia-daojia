<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.mail_template.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>
<div class="row-fluid">
	<table class="table table-striped" id="plugin-table">
		<thead>
			<tr>
				<th>{t domain="mail"}编号{/t}</th>
				<th>{t domain="mail"}邮件模板{/t}</th>
				<th class="w100">{t domain="mail"}操作{/t}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$templates item=list} -->
			<tr>
				<td class="first-cell">{$list.template_code}</td>
				<td align="left">{$list.template_name}</td>
				<td align="center">
					<a class="data-pjax no-underline" href='{url path="mail/admin/edit" args="tpl={$list.template_code}"}' title='{t domain="mail"}编辑{/t}'><i class="fontello-icon-edit"></i></a>
				</td>
			</tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
</div>
<!-- {/block} -->