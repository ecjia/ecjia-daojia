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
			<i class="splashy-upload"></i> {t domain='goodslib'}批量导入{/t}
		</a>
		<a href="{url path='goodslib/admin/export' args="{if $smarty.get.cat_id}&cat_id={$smarty.get.cat_id}{/if}{if $smarty.get.brand_id}&brand_id={$smarty.get.brand_id}{/if}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}"}" 
			class="btn plus_or_reply goodslib_download" id="">
			<i class="splashy-download"></i> {t domain='goodslib'}导出结果{/t}
		</a>
	</h3>
</div>

<div class="row-fluid batch">
	<div class="btn-group f_l m_r5">
		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fontello-icon-cog"></i>{t domain='goodslib'}批量操作{/t}<span class="caret"></span>
		</a>
		<ul class="dropdown-menu batch-move" data-url="{RC_Uri::url('goodslib/admin/batch')}">
			<li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=trash&page={$smarty.get.page}" data-msg="{t domain='goodslib'}您确定要把选中的商品放入回收站吗？{/t}" data-noSelectMsg="{t domain='goodslib'}请选择要移至回收站的商品{/t}" href="javascript:;"> <i class="fontello-icon-box"></i>{t domain='goodslib'}删除{/t}</a></li>
			<li><a class="batch-sale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=on_sale&page={$smarty.get.page}" data-msg="{t domain='goodslib'}您确定要把选中的商品上架吗？{/t}" data-noSelectMsg="{t domain='goodslib'}请选择要上架的商品{/t}" href="javascript:;"> <i class="fontello-icon-up-circled2"></i>{t domain='goodslib'}上架{/t}</a></li>
			<li><a class="batch-notsale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_on_sale&page={$smarty.get.page}" data-msg="{t domain='goodslib'}您确定要把选中的商品下架吗？{/t}" data-noSelectMsg="{t domain='goodslib'}请选择要下架的商品{/t}" href="javascript:;"> <i class="fontello-icon-down-circled2"></i>{t domain='goodslib'}下架{/t}</a></li>
		</ul>
	</div>

	<form class="form-inline" action="{RC_Uri::url('goodslib/admin/init')}{if $smarty.get.type}&type={$smarty.get.type}{/if}" method="post" name="filterForm">
 		
		<div class="screen f_l">
			<!-- 分类 -->
			<div class="f_l m_r5">
				<select class="w150" name="cat_id">
					<option value="0">{t domain='goodslib'}所有分类{/t}</option>
                    {$cat_list_option}
				</select>
			</div>
			<!-- 品牌 -->
			<div class="f_l m_r5">
				<select class="no_search w120" name="brand_id">
					<option value="0">{t domain='goodslib'}所有品牌{/t}</option>
					<!-- {foreach from=$brand_list item=list key=key} -->
					<option value="{$key}" {if $key == $smarty.get.brand_id}selected{/if}>{$list}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<button class="btn screen-btn" type="button">{t domain='goodslib'}筛选{/t}</button>
		</div>
	</form>
	<form class="f_r form-inline" action='{RC_Uri::url("goodslib/admin/init")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
		<!-- 关键字 -->
		<input class="w180" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain='goodslib'}请输入商品关键字{/t}" size="15" />
		<button class="btn" type="submit">{t domain='goodslib'}搜索{/t}</button>
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
					<th class="w80">{t domain='goodslib'}缩略图{/t}</th>
					<th class="w100" data-toggle="sortby" data-sortby="goods_id">{t domain='goodslib'}商品名称{/t}</th>
					<th class="w80" data-toggle="sortby" data-sortby="goods_sn">{t domain='goodslib'}货号{/t}</th>
					<th class="w70" data-toggle="sortby" data-sortby="shop_price">{t domain='goodslib'}价格{/t}</th>
					<th class="w35"> {t domain='goodslib'}上架{/t} </th>
					<th class="w35" data-toggle="sortby" data-sortby="sort_order">{t domain='goodslib'}排序{/t}</th>
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
                        {if $goods.has_products}<span class="label-orange">{t domain='goodslib'}多货品{/t}{/if}</span>{$goods.goods_name|escape:html}
						<br/>
						<div class="edit-list">
							<a class="data-pjax" href='{url path="goodslib/admin/edit" args="goods_id={$goods.goods_id}"}'>{t domain='goodslib'}编辑{/t}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goodslib/admin_gallery/init" args="goods_id={$goods.goods_id}"}'>{t domain='goodslib'}商品相册{/t}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goodslib/admin/edit_goods_parameter" args="goods_id={$goods.goods_id}"}'>{t domain='goodslib'}商品参数{/t}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goodslib/admin/edit_goods_specification" args="goods_id={$goods.goods_id}"}'>{t domain='goodslib'}商品规格{/t}</a>&nbsp;|&nbsp;
							{if $goods.has_products}<a target="_blank" href='{url path="goodslib/admin/product_list" args="goods_id={$goods.goods_id}"}'>{t domain='goodslib'}货品列表{/t}</a>&nbsp;|&nbsp;{/if}
							<a target="_blank" href='{url path="goodslib/admin/preview" args="goods_id={$goods.goods_id}"}'>{t domain='goodslib'}预览{/t}</a>&nbsp;|&nbsp;
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t domain='goodslib'}您确定要把该商品放入回收站吗？{/t}" href='{url path="goodslib/admin/remove" args="id={$goods.goods_id}"}'>{t domain='goodslib'}删除{/t}</a>
						</div>
					</td>	
					
					<td>
						{$goods.goods_sn} 
					</td>
					
					<td align="right">
						<span  class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goodslib/admin/edit_goods_price')}{if $smarty.get.page}&page={$smarty.get.page}{/if}" data-name="goods_price" data-pk="{$goods.goods_id}" data-title="{t domain='goodslib'}请输入商品价格{/t}">
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
						<span class="cursor_pointer" data-placement="left" data-trigger="editable" data-url="{RC_Uri::url('goodslib/admin/edit_sort_order')}" data-name="sort_order" data-pk="{$goods.goods_id}" data-title="{t domain='goodslib'}请输入排序序号{/t}">
							{$goods.sort_order}
						</span>
					</td>
				</tr>
				<!-- {foreachelse}-->
				<tr>
					<td class="no-records" colspan="13">{t domain='goodslib'}没有找到任何记录{/t}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$goods_list.page} -->
	</div>
</div>
<!-- {/block} -->