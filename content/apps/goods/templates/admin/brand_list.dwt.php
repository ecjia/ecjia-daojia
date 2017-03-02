<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_brand.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-plus"></i>{$action_link.text}</a>
	<!-- {/if} -->
	</h3>
</div>
<!-- 品牌搜索 -->
<div class="row-fluid">
	<div class="choose_list f_r">
		<form class="f_r" action="{url path='goods/admin_brand/init'}" method="post" name="searchForm">
			<input type="text" name="keywords" value="{$smarty.get.keywords}" size="15" placeholder="{lang key='goods::brand.brand_keywords'}"/>
			<button class="btn" type="submit">{lang key='system::system.button_search'}</button>
		</form>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped dataTable" cellpadding="3" cellspacing="1" id="smpl_tbl">
			<thead>
				<tr>
					<th class="w120">
						{lang key='goods::brand.brand_logo'}
					</th>
					<th>
						{lang key='goods::brand.brand_name'}
					</th>
					<th>
						{lang key='goods::brand.site_url'}
					</th>
					<th>
						{lang key='goods::brand.brand_desc'}
					</th>
					<th class="w50">
						{lang key='goods::brand.sort_order'}
					</th>
					<th class="w100">
						{lang key='goods::brand.is_show'}
					</th>
					<th class="w70">
						{lang key='system::system.handler'}
					</th>
				</tr>
			</thead>
			<tbody>
			<!-- {foreach from=$brand_list.brand item=brand} -->
			<tr>
				<td>{$brand.brand_logo_html}</td>
				<td class="first-cell">
					<span class="cursor_pointer" data-trigger="editable" data-url="{url path='goods/admin_brand/edit_brand_name'}" data-name="edit_brand_name" data-pk="{$brand.brand_id}" data-title="{lang key='goods::brand.no_brand_name'}">
						{$brand.brand_name|escape:html}
					</span>
				</td>
				<td>
					{$brand.site_url}
				</td>
				<td align="left">
					{$brand.brand_desc|truncate:36}
				</td>
				<td align="right">
					<span class="cursor_pointer" data-trigger="editable" data-url="{url path='goods/admin_brand/edit_sort_order'}" data-name="edit_sort_order" data-pk="{$brand.brand_id}" data-title="{lang key='goods::brand.no_sort_order'}">
						{$brand.sort_order}
					</span>
				</td>
				<td align="center">
					<i class="{if $brand.is_show}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{url path='goods/admin_brand/toggle_show'}" data-id="{$brand.brand_id}"></i>
				</td>
				<td align="center">
					<a class="data-pjax no-underline" href='{url path="goods/admin_brand/edit" args="id={$brand.brand_id}"}' title="{lang key='system::system.edit'}"><i class="fontello-icon-edit"></i></a>
					<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='goods::brand.drop_confirm'}" href='{url path="goods/admin_brand/remove" args="id={$brand.brand_id}"}' title="{lang key='system::system.drop'}"><i class="fontello-icon-trash"></i></a>
				</td>
			</tr>
			<!-- {foreachelse} -->
			<tr>
				<td class="no-records" colspan="7">{lang key='system::system.no_records'}</td>
			</tr>
			<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$brand_list.page} -->
	</div>
</div>
<!-- {/block} -->