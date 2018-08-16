<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading"> 
		<!-- {if $ur_here}{$ur_here}{/if} --> 
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a">
			<i class="fontello-icon-plus"></i>{$action_link.text}
		</a>{/if}
		<a href="{url path='goodslib/admin/import'}" class="btn data-pjax plus_or_reply" id="">
			<i class="splashy-upload"></i> 批量导入
		</a>
		<a href="{url path='goodslib/admin/export' args="{if $smarty.get.cat_id}&cat_id={$smarty.get.cat_id}{/if}{if $smarty.get.brand_id}&brand_id={$smarty.get.brand_id}{/if}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}"}" 
			class="btn plus_or_reply goodslib_download" id="">
			<i class="splashy-download"></i> 导出结果
		</a>
	</h3>
</div>

<div class="row-fluid batch">
	<div class="btn-group f_l m_r5">
		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fontello-icon-cog"></i>{lang key='goods::goods.batch_handle'}<span class="caret"></span>
		</a>
		<ul class="dropdown-menu batch-move" data-url="{RC_Uri::url('goodslib/admin/batch')}">
			<li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=trash&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_trash_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_trash_goods'}" href="javascript:;"> <i class="fontello-icon-box"></i>删除</a></li>
			<li><a class="batch-sale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=on_sale&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_on_sale_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_sale_goods'}" href="javascript:;"> <i class="fontello-icon-up-circled2"></i>{lang key='goods::goods.on_sale'}</a></li>
			<li><a class="batch-notsale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_on_sale&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_not_on_sale_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_not_sale_goods'}" href="javascript:;"> <i class="fontello-icon-down-circled2"></i>{lang key='goods::goods.not_on_sale'}</a></li>
		</ul>
	</div>

	<form class="form-inline" action="{RC_Uri::url('goodslib/admin/init')}{if $smarty.get.type}&type={$smarty.get.type}{/if}" method="post" name="filterForm">
 		
		<div class="screen f_l">
			<!-- 分类 -->
			<div class="f_l m_r5">
				<select class="w150" name="cat_id">
					<option value="0">{lang key='goods::goods.goods_cat'}</option>
					<!-- {foreach from=$cat_list item=cat} -->
					<option value="{$cat.cat_id}" {if $cat.cat_id == $smarty.get.cat_id}selected{/if} {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<!-- 品牌 -->
			<div class="f_l m_r5">
				<select class="no_search w120" name="brand_id">
					<option value="0">{lang key='goods::goods.goods_brand'}</option>
					<!-- {foreach from=$brand_list item=list key=key} -->
					<option value="{$key}" {if $key == $smarty.get.brand_id}selected{/if}>{$list}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<button class="btn screen-btn" type="button">{lang key='goods::goods.filter'}</button>
		</div>
	</form>
	<form class="f_r form-inline" action='{RC_Uri::url("goodslib/admin/init")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
		<!-- 关键字 -->
		<input class="w180" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='goods::goods.enter_goods_keywords'}" size="15" />
		<button class="btn" type="submit">{lang key='system::system.button_search'}</button>
	</form>
</div>

<div class="row-fluid list-page">
	<div class="span12">
		<table class="table table-striped smpl_tbl table_vam table-hide-edit" id="smpl_tbl" data-uniform="uniform">
			<thead>
				<tr data-sorthref='{RC_Uri::url("goodslib/admin/init", "{if $smarty.get.type}&type={$smarty.get.type}{/if}")}'>
					<th class="table_checkbox">
						<input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
					</th>
					<th class="w80">{lang key='goods::goods.thumb'}</th>
					<th class="w100" data-toggle="sortby" data-sortby="goods_id">{lang key='goods::goods.goods_name'}</th>
					<th class="w80" data-toggle="sortby" data-sortby="goods_sn">{lang key='goods::goods.goods_sn'}</th>
					<th class="w70" data-toggle="sortby" data-sortby="shop_price">{lang key='goods::goods.shop_price'}</th>
					<th class="w35"> {lang key='goods::goods.is_on_sale'} </th>
					<th class="w35" data-toggle="sortby" data-sortby="sort_order">排序</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$goods_list.goods item=goods}-->
				<tr class="big">
					<td class="center-td">
						<input class="checkbox" type="checkbox" name="checkboxes[]" value="{$goods.goods_id}"/>
					</td>						
					<td>
						<a href="{url path='goodslib/admin/edit' args="goods_id={$goods.goods_id}"}" title="{$goods.goods_name|escape:html}" >
							<img class="thumbnail" alt="{$goods.goods_name}" src="{$goods.goods_thumb}">
						</a>
					</td>
					<td class="hide-edit-area ">
						{$goods.goods_name|escape:html}
						<br/>
						<div class="edit-list">
							<a class="data-pjax" href='{url path="goodslib/admin/edit" args="goods_id={$goods.goods_id}"}'>{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goodslib/admin_gallery/init" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.tab_gallery'}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goodslib/admin/edit_goods_attr" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.tab_properties'}</a>&nbsp;|&nbsp;
							{if $specifications[$goods.goods_type] neq ''}<a target="_blank" href='{url path="goodslib/admin/product_list" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.product_list'}</a>&nbsp;|&nbsp;{/if}
							<a target="_blank" href='{url path="goodslib/admin/preview" args="goods_id={$goods.goods_id}"}'>预览</a>&nbsp;|&nbsp;
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='goods::goods.trash_goods_confirm'}" href='{url path="goodslib/admin/remove" args="id={$goods.goods_id}"}'>{lang key='system::system.drop'}</a>
						</div>
					</td>	
					
					<td>
						{$goods.goods_sn} 
					</td>
					<td align="right">
						<span  class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goodslib/admin/edit_goods_price')}{if $smarty.get.page}&page={$smarty.get.page}{/if}" data-name="goods_price" data-pk="{$goods.goods_id}" data-title="请输入商品价格"> 
							{$goods.shop_price}
						</span> 
					</td>
					<td align="center">
						<i class="{if $goods.is_display}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggle_on_sale" data-url="{RC_Uri::url('goodslib/admin/toggle_on_sale')}" refresh-url="{RC_Uri::url('goodslib/admin/init')}
							{if $filter.type}&type={$filter.type}{/if}
							{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
							{if $filter.brand_id}&brand_id={$filter.brand_id}{/if}
							{if $filter.intro_type}&intro_type={$filter.intro_type}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							{if $smarty.get.page}&page={$smarty.get.page}{/if}
							" data-id="{$goods.goods_id}">
						</i>
					</td>
					<td align="center">
						<span class="cursor_pointer" data-placement="left" data-trigger="editable" data-url="{RC_Uri::url('goodslib/admin/edit_sort_order')}" data-name="sort_order" data-pk="{$goods.goods_id}" data-title="请输入排序序号"> 
							{$goods.sort_order}
						</span>
					</td>
				</tr>
				<!-- {foreachelse}-->
				<tr>
					<td class="no-records" colspan="13">{lang key='system::system.no_records'}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$goods_list.page} -->
	</div>
</div>
<!-- {/block} -->