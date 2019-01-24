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
            <h4>{t domain="article"}添加帮助分类：{/t}</h4> <br>
            <input type="text" name="cat_name" id="keyword" /><br><br>
            <button class="btn btn-gebo" type="submit">{t domain="article"}确定{/t}</button>
        </form>
	</div>
	
	<div class="right-bar">
		<table class="table table-striped table-hide-edit">
			<thead>
				<tr>
					<th>{t domain="article"}分类名称{/t}</th>
					<th class="w50">{t domain="article"}排序{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$list item=item} -->
				<tr>
					<td class="hide-edit-area">
						<span class="article_edit_catname cursor_pointer"  data-trigger="editable" data-url="{RC_Uri::url('article/admin_shophelp/edit_catname')}" data-name="title" data-pk="{$item.cat_id}"  data-title="{t domain="article"}编辑帮助分类名称{/t}">{$item.cat_name|escape:html}</span>
						<div class="edit-list">
				    		<a class="data-pjax" href='{RC_Uri::url("article/admin_shophelp/add", "cat_id={$item.cat_id}")}' title="{t domain="article"}添加{/t}">{t domain="article"}添加{/t}</a>&nbsp;|
				    		<a class="data-pjax" href='{RC_Uri::url("article/admin_shophelp/list_article", "cat_id={$item.cat_id}")}' title="{t domain="article"}查看列表{/t}">{t domain="article"}查看列表{/t}</a>&nbsp;|
				    		<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t domain="article"}您确定要删除该帮助分类吗？{/t}" href='{RC_Uri::url("article/admin_shophelp/remove", "cat_id={$item.cat_id}")}' title="{t domain="article"}删除{/t}">{t domain="article"}删除{/t}</a>
				    	</div>
					</td>
					<td align="left"><span class="article_edit_catorder cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('article/admin_shophelp/edit_cat_order')}" data-name="title" data-pk="{$item.cat_id}"  data-title="{t domain="article"}编辑帮助分类排序{/t}">{$item.sort_order}</span></td>
				</tr>
				<!-- {foreachelse} -->
				<tr><td class="no-records" colspan="3">{t domain="article"}没有找到任何记录{/t}</td></tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
	</div>
</div>
<!-- {/block} -->