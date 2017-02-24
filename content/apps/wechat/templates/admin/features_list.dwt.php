<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>
	
<div class="row-fluid list-page">
	<div class="span12">	
		<div class="row-fluid">	
			<table class="table table-striped smpl_tbl table-hide-edit">
				<thead>
					<tr>
						<th class="w200">{lang key='wechat::wechat.features_name'}</th>
						<th class="w150">{lang key='wechat::wechat.keywords'}</th>
						<th class="w150">{lang key='wechat::wechat.extend_keywords'}</th>
						<th class="w150">{lang key='wechat::wechat.plugin_author'}</th>
						<th class="w200">{lang key='wechat::wechat.plugin_source'}</th>
					</tr>
				</thead>
				<tbody>
					<!-- {foreach from=$listdb.features_list item=val} -->
					<tr>
						<td>{$val.name}</td>
						<td>{$val.keywords}</td>
						<td>{$val.command}</td>
						<td>{$val.author}</td>
						<td>{$val.website}</td>
					</tr>
					<!-- {foreachelse} -->
					<tr><td class="no-records" colspan="10">{lang key='system::system.no_records'}</td></tr>
					<!-- {/foreach} -->
				</tbody>
			</table>
		</div>
	</div>
</div> 
<!-- {$listdb.page} -->
<!-- {/block} -->