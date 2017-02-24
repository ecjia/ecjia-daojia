<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.affiliate.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $add_percent} -->				
			<!-- 添加佣金百分比 -->
			<a href="{$add_percent.href}" class="btn plus_or_reply data-pjax" id="sticky_b">
				<i class="fontello-icon-plus"></i>{$add_percent.text}
			</a>
		<!-- {/if} -->
	</h3>
</div>

<!-- {if $config.on eq 0} -->
<div class="alert alert-info">	
	<strong>{lang key='affiliate::affiliate.notice'}</strong>
</div>
<!-- {/if} -->

<div class="row-fluid edit-page">
	<div class="span12">
		<table class="table table-striped" id="smpl_tbl">
			<thead>
				<tr>
					<th>{lang key='affiliate::affiliate.levels'}</th>
					<th>{lang key='affiliate::affiliate.level_point'}</th>
					<th>{lang key='affiliate::affiliate.level_money'}</th>
					<th>{lang key='system::system.handler'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$config.item key=key item=val} -->
				<tr>
					<td>{$key+1}</td>
					<td align="left">
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('affiliate/admin/edit_point')}" data-name="level_point" data-pk="{$key+1}" data-title="{lang key='affiliate::affiliate.edit_level_point'}">{$val.level_point}</span>
					</td>
					<td align="left">
						<span class="cursor_pointer editable-click" data-trigger="editable" data-url="{RC_Uri::url('affiliate/admin/edit_money')}" data-name="level_money" data-pk="{$key+1}" data-title="{lang key='affiliate::affiliate.edit_level_money'}">{$val.level_money}</span>
					</td>
					<td align="left">
						<a class="data-pjax" href='{url path="affiliate/admin/edit" args="id={$key+1}"}' title="编辑"><i class="fontello-icon-edit"></i></a>
						<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='system::system.confirm_delete'}" href='{url path="affiliate/admin/remove" args="id={$key+1}"}' title="{lang key='system::system.drop'}"><i class="fontello-icon-trash"></i></a>
					</td>
				</tr>
			   	<!-- {foreachelse} -->
				<tr>
					<td class="dataTables_empty" colspan="4">{lang key='system::system.no_records'}</td>
				</tr>
	        	<!-- {/foreach} -->
			</tbody>
		</table>
	</div>
</div>

<!-- {/block} -->