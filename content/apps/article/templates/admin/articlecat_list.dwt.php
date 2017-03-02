<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

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
	<div class="span12">
		<table class="table table-striped unlimited-category-list" id="list-table">
			<thead>
				<tr>
					<th>{lang key='article::article.cat_name'}</th>
					<th class="w100">{lang key='system::system.sort_order'}</th>
					<th class="w100">{lang key='system::system.handler'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$articlecat item=cat} -->
				<tr align="center" class="{$cat.level}" id="{$cat.level}_{$cat.cat_id}">
					<td align="left" class="first-cell nowrap cursor_pointer" valign="top" >
						<i class="fontello-icon-minus-squared-alt cursor_pointer ecjiafc-blue" id="icon_{$cat.level}_{$cat.cat_id}" style="margin-left:{$cat.level}em" onclick='ecjia.admin.article_cat_list.rowClicked(this);'></i>
						<span><a href="index.php?m=article&c=admin&a=init&amp;cat_id={$cat.cat_id}">{$cat.cat_name|escape}</a></span>
					</td>
			
					<td>
						<span class="cursor_pointer" data-trigger="editable" data-url="{url path='article/admin_articlecat/edit_sort_order'}" data-name="sort_order" data-pk="{$cat.cat_id}" data-title="{lang key='article::article.sort_order'}"> 
							{$cat.sort_order}
						</span>
					</td>

					<td>
						<a class="data-pjax no-underline" href='{RC_Uri::url("article/admin_articlecat/edit", "id={$cat.cat_id}")}' title="{lang key='system::system.edit'}"><i class="fontello-icon-edit"></i></a>
						<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='article::article.drop_cat_confirm'}" href='{RC_Uri::url("article/admin_articlecat/remove","id={$cat.cat_id}")}' title="{lang key='system::system.remove'}"><i class="fontello-icon-trash"></i></a>
					</td>
				</tr>
				<!-- {foreachelse} -->
				   <tr><td class="no-records" colspan="3">{lang key='system::system.no_records'}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
	</div>
</div>
<!-- {/block} -->