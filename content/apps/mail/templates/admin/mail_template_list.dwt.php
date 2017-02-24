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
				<th>{lang key='mail::mail_template.mail_id'}</th>
				<th>{lang key='mail::mail_template.template_name'}</th>
				<th class="w100">{lang key='system::system.handler'}</th>
			</tr>
		</thead>
		<tbody>
			<!-- {foreach from=$templates item=list} -->
			<tr>
				<td class="first-cell">{$list.template_code}</td>
				<td align="left">{$list.template_name}</td>
				<td align="center">
					<a class="data-pjax no-underline" href='{url path="mail/admin/edit" args="tpl={$list.template_code}"}' title="{lang key='system::system.edit'}"><i class="fontello-icon-edit"></i></a>
				</td>
			</tr>
			<!-- {/foreach} -->
		</tbody>
	</table>
</div>
<!-- {/block} -->