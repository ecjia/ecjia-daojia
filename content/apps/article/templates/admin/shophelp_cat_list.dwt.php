<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.shophelp_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>

<div class="row-fluid editpage-leftbar">
	<div class="left-bar">
		<form class="form-horizontal" action="{$form_action}" name="addcatForm" method="post">
            <h4>{lang key='article::shophelp.add_help_category'}：</h4> <br>
            <input type="text" name="cat_name" id="keyword" /><br><br>
            <button class="btn btn-gebo" type="submit">{lang key='article::shophelp.cat_add_confirm'}</button>
        </form>
	</div>
	<div class="right-bar">
		<table class="table dataTable table-hide-edit">
			<thead>
				<tr>
					<th>{lang key='article::shophelp.cat_name'}</th>
					<th class="w70">{lang key='article::shophelp.sort'}</th>
					<th class="w120">{lang key='system::system.handler'}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$list item=item} -->
				<tr>
					<td>
						<span class="article_edit_catname cursor_pointer"  data-trigger="editable" data-url="{RC_Uri::url('article/admin_shophelp/edit_catname')}" data-name="title" data-pk="{$item.cat_id}"  data-title="{lang key='article::shophelp.edit_help_cat_name'}">{$item.cat_name|escape:html}</span>
					</td>
					<td align="left"><span class="article_edit_catorder cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('article/admin_shophelp/edit_cat_order')}" data-name="title" data-pk="{$item.cat_id}"  data-title="{lang key='article::shophelp.edit_help_cat_order'}">{$item.sort_order}</span></td>
					<td align="center">
						<span>
							<a class="data-pjax no-underline" href='{RC_Uri::url("article/admin_shophelp/add", "cat_id={$item.cat_id}")}' title="{lang key='article::shophelp.lang_article_add'}"><i class="fontello-icon-pencil-squared"></i></a>&nbsp;
							<a class="data-pjax no-underline" href='{RC_Uri::url("article/admin_shophelp/list_article", "cat_id={$item.cat_id}")}' title="{lang key='article::shophelp.article_list'}"><i class=" fontello-icon-doc-text-inv"></i></a>&nbsp;
							<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='article::shophelp.remove_cat_confirm'}" href='{RC_Uri::url("article/admin_shophelp/remove", "cat_id={$item.cat_id}")}' title="{lang key='system::system.remove'}"><i class="fontello-icon-trash"></i></a>
						</span>
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