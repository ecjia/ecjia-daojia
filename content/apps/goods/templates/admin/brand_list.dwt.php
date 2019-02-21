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
			<input type="text" name="keywords" value="{$smarty.get.keywords}" size="15" placeholder="{t domain="goods"}请输入品牌关键字{/t}"/>
			<button class="btn" type="submit">{t domain="goods"}搜索{/t}</button>
		</form>
	</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<table class="table table-striped dataTable" cellpadding="3" cellspacing="1" id="smpl_tbl">
			<thead>
				<tr>
					<th class="w120">
						{t domain="goods"}品牌LOGO{/t}
					</th>
					<th>
                        {t domain="goods"}品牌名称{/t}
					</th>
					<th>
                        {t domain="goods"}品牌网址{/t}
					</th>
					<th>
                        {t domain="goods"}品牌描述{/t}
					</th>
					<th class="w50">
                        {t domain="goods"}排序{/t}
					</th>
					<th class="w100">
                        {t domain="goods"}是否显示{/t}
					</th>
					<th class="w70">
						{t domain="goods"}操作{/t}
					</th>
				</tr>
			</thead>
			<tbody>
			<!-- {foreach from=$brand_list.brand item=brand} -->
			<tr>
				<td>{$brand.brand_logo_html}</td>
				<td class="first-cell">
					<span class="cursor_pointer" data-trigger="editable" data-url="{url path='goods/admin_brand/edit_brand_name'}" data-name="edit_brand_name" data-pk="{$brand.brand_id}" data-title="{t domain="goods"}请输入品牌名称{/t}">
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
					<span class="cursor_pointer" data-trigger="editable" data-url="{url path='goods/admin_brand/edit_sort_order'}" data-name="edit_sort_order" data-pk="{$brand.brand_id}" data-title="{t domain="goods"}请输入排序序号{/t}">
						{$brand.sort_order}
					</span>
				</td>
				<td align="center">
					<i class="{if $brand.is_show}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{url path='goods/admin_brand/toggle_show'}" data-id="{$brand.brand_id}"></i>
				</td>
				<td align="center">
					<a class="data-pjax no-underline" href='{url path="goods/admin_brand/edit" args="id={$brand.brand_id}"}' title="{t domain="goods"}编辑{/t}"><i class="fontello-icon-edit"></i></a>
					<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{t domain="goods"}你确认要删除选定的商品品牌吗？{/t}" href='{url path="goods/admin_brand/remove" args="id={$brand.brand_id}"}' title="{t domain="goods"}删除{/t}"><i class="fontello-icon-trash"></i></a>
				</td>
			</tr>
			<!-- {foreachelse} -->
			<tr>
				<td class="no-records" colspan="7">{t domain="goods"}没有找到任何记录{/t}</td>
			</tr>
			<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$brand_list.page} -->
	</div>
</div>
<!-- {/block} -->