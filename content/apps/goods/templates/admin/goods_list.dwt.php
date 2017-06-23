<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="modal hide fade" id="movetype">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='goods::goods.move_to_cat'}</h3>
	</div>
	<div class="modal-body h300">
		<div class="row-fluid ecjiaf-tac">
			<div>
				<select class="noselect w200" size="15" name="target_cat">
					<option value="0">{lang key='goods::goods.goods_cat'}</option>
					<!-- {foreach from=$cat_list item=cat} -->
					<option value="{$cat.cat_id}" {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<div>
				<a class="btn btn-gebo m_l5" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=move_to&" data-msg="{lang key='goods::goods.move_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_move_goods'}" href="javascript:;" name="move_cat_ture">{lang key='goods::goods.start_move'}</a>
			</div>
		</div>
	</div>
</div>
<div>
	<h3 class="heading"> 
		<!-- {if $ur_here}{$ur_here}{/if} --> 
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a">
			<i class="fontello-icon-plus"></i>{$action_link.text}
		</a>{/if}
	</h3>
</div>

<!-- <div class="row-fluid"> -->
<!-- <div class="choose_list span12">  -->
<ul class="nav nav-pills">
	<li class="{if !$smarty.get.type}active{/if}">
		<a class="data-pjax" href="{RC_Uri::url('goods/admin/init')}
			{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
			{if $filter.brand_id}&brand_id={$filter.brand_id}{/if}
			{if $filter.intro_type}&intro_type={$filter.intro_type}{/if}
			{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
			{if $filter.keywords}&keywords={$filter.keywords}{/if}
			{if $filter.review_status}&review_status={$filter.review_status}{/if}
			{if $filter.store_id}&store_id={$filter.store_id}{/if}
			">
			{lang key='goods::goods.intro_type'} 
			<span class="badge badge-info">{$goods_list.filter.count_goods_num}</span>
		</a>
	</li>
	
	<li class="{if $smarty.get.type eq 1}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("goods/admin/init", "type=1
			{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
			{if $filter.brand_id}&brand_id={$filter.brand_id}{/if}
			{if $filter.intro_type}&intro_type={$filter.intro_type}{/if}
			{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
			{if $filter.keywords}&keywords={$filter.keywords}{/if}
			{if $filter.review_status}&review_status={$filter.review_status}{/if}
			{if $filter.store_id}&store_id={$filter.store_id}{/if}
			")}'>{lang key='goods::goods.is_on_saled'}
			<span class="badge badge-info use-plugins-num">{$goods_list.filter.count_on_sale}</span>
		</a>
	</li>
	
	<li class="{if $smarty.get.type eq 2}active{/if}">	
		<a class="data-pjax" href='{RC_Uri::url("goods/admin/init", "type=2
			{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
			{if $filter.brand_id}&brand_id={$filter.brand_id}{/if}
			{if $filter.intro_type}&intro_type={$filter.intro_type}{/if}
			{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
			{if $filter.keywords}&keywords={$filter.keywords}{/if}
			{if $filter.review_status}&review_status={$filter.review_status}{/if}
			{if $filter.store_id}&store_id={$filter.store_id}{/if}
			")}'>{lang key='goods::goods.not_on_saled'}
			<span class="badge badge-info unuse-plugins-num">{$goods_list.filter.count_not_sale}</span>
		</a>
	</li>
	
	<li class="{if $smarty.get.type eq 'self'}active{/if}">
		<a class="data-pjax" href='{RC_Uri::url("goods/admin/init", "type=self
			{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
			{if $filter.brand_id}&brand_id={$filter.brand_id}{/if}
			{if $filter.intro_type}&intro_type={$filter.intro_type}{/if}
			{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
			{if $filter.keywords}&keywords={$filter.keywords}{/if}
			{if $filter.review_status}&review_status={$filter.review_status}{/if}
			{if $filter.store_id}&store_id={$filter.store_id}{/if}
			")}'>{lang key='goods::goods.self'}
			<span class="badge badge-info unuse-plugins-num">{$goods_list.filter.self}</span>
		</a>
	</li>

	<form class="f_r form-inline" action='{RC_Uri::url("goods/admin/init")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
		<!-- 关键字 -->
		<input class="w180" type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{lang key='goods::goods.enter_merchant_keywords'}" size="15" />
		<input class="w180" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='goods::goods.enter_goods_keywords'}" size="15" />
		<button class="btn" type="submit">{lang key='system::system.button_search'}</button>
	</form>
</ul>
<!-- </div> -->
<!-- </div> -->

<div class="row-fluid batch">
	<div class="btn-group f_l m_r5">
		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fontello-icon-cog"></i>{lang key='goods::goods.batch_handle'}<span class="caret"></span>
		</a>
		<ul class="dropdown-menu batch-move" data-url="{RC_Uri::url('goods/admin/batch')}">
			<li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=trash&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_trash_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_trash_goods'}" href="javascript:;"> <i class="fontello-icon-box"></i>{lang key='goods::goods.move_to_trash'}</a></li>
			<li><a class="batch-sale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=on_sale&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_on_sale_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_sale_goods'}" href="javascript:;"> <i class="fontello-icon-up-circled2"></i>{lang key='goods::goods.on_sale'}</a></li>
			<li><a class="batch-notsale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_on_sale&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_not_on_sale_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_not_sale_goods'}" href="javascript:;"> <i class="fontello-icon-down-circled2"></i>{lang key='goods::goods.not_on_sale'}</a></li>
			<li><a class="batch-best-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=best&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_best_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_best_goods'}" href="javascript:;"> <i class="fontello-icon-star"></i>{lang key='goods::goods.best'}</a></li>
			<li><a class="batch-notbest-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_best&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_not_best_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_not_best_goods'}" href="javascript:;"><i class="fontello-icon-star-empty"></i>{lang key='goods::goods.not_best'}</a></li>
			<li><a class="batch-new-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=new&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_new_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_new_goods'}" href="javascript:;"> <i class="fontello-icon-flag"></i>{lang key='goods::goods.new'}</a></li>
			<li><a class="batch-notnew-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_new&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_not_new_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_not_news_goods'}" href="javascript:;"> <i class="fontello-icon-flag-empty"></i>{lang key='goods::goods.not_new'}</a></li>
			<li><a class="batch-hot-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=hot&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_hot_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_hot_goods'}" href="javascript:;"> <i class="fontello-icon-thumbs-up-alt"></i>{lang key='goods::goods.hot'}</a></li>
			<li><a class="batch-nothot-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_hot&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_not_hot_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_not_hot_goods'}" href="javascript:;"> <i class="fontello-icon-thumbs-up"></i>{lang key='goods::goods.not_hot'}</a></li>
			<li><a class="batch-move-btn"data-name="move_cat" data-move="data-operatetype" href="javascript:;"> <i class="fontello-icon-forward"></i>{lang key='goods::goods.move_to'}</a></li>
			
			<li><a class="batch-pass-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=pass&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="您确定要审核通过选中的商品吗？" data-noSelectMsg="请选择需要修改审核状态的商品" href="javascript:;"> <i class="fontello-icon-ok-circled"></i>审核通过</a></li>
			<li><a class="batch-notpass-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_pass&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="您确定要不审核通过选中的商品吗？" data-noSelectMsg="请选择需要修改审核状态的商品" href="javascript:;"> <i class="fontello-icon-cancel-circled"></i>审核未通过</a></li>
			<li><a class="batch-notaudited-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_audited&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="您确定要将选中的商品设为未审核吗？" data-noSelectMsg="请选择需要修改审核状态的商品" href="javascript:;"> <i class="fontello-icon-help-circled"></i>设为未审核</a></li>
			<li><a class="batch-notcheck-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_check&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="您确定要将选中的商品设为无需审核吗？" data-noSelectMsg="请选择需要修改审核状态的商品" href="javascript:;"> <i class=" fontello-icon-gittip"></i>无需审核</a></li>
		</ul>
	</div>

	<form class="form-inline" action="{RC_Uri::url('goods/admin/init')}{if $smarty.get.type}&type={$smarty.get.type}{/if}" method="post" name="filterForm">
		<div class="screen f_l">
			<div class="f_l m_r5">
				<select class="w150" name="review_status">
					<option value="0">请选择审核状态</option>
					<option value="1" {if $filter.review_status eq 1}selected{/if}>未审核</option>
					<option value="2" {if $filter.review_status eq 2}selected{/if}>审核未通过</option>
					<option value="3" {if $filter.review_status eq 3}selected{/if}>已审核</option>
					<option value="5" {if $filter.review_status eq 5}selected{/if}>无需审核</option>
				</select>
			</div>
			
			<div class="f_l m_r5">
				<select class="w150" name="store_id">
					<option value="0">请选择商家</option>
					<!-- {foreach from=$store_list item=val} -->
					<option value="{$val.store_id}" {if $filter.store_id eq $val.store_id}selected{/if}>{$val.merchants_name}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<button class="btn filter-btn" type="button">{lang key='goods::goods.filter'}</button>
		</div>
		
		<div class="screen f_r">
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
			<!-- 推荐 -->
			<div class="f_l m_r5">
				<select class="w100" name="intro_type">
					<option value="0">{lang key='goods::goods.intro_type'}</option>
					<!-- {foreach from=$intro_list item=list key=key} -->
					<option value="{$key}" {if $key == $smarty.get.intro_type}selected{/if}>{$list}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<button class="btn screen-btn" type="button">{lang key='goods::goods.filter'}</button>
		</div>
	</form>
</div>

<div class="row-fluid list-page">
	<div class="span12">
		<table class="table table-striped smpl_tbl table_vam table-hide-edit" id="smpl_tbl" data-uniform="uniform">
			<thead>
				<tr data-sorthref='{RC_Uri::url("goods/admin/init", "{if $smarty.get.type}&type={$smarty.get.type}{/if}")}'>
					<th class="table_checkbox">
						<input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
					</th>
					<th class="w80">{lang key='goods::goods.thumb'}</th>
					<th class="w100" data-toggle="sortby" data-sortby="goods_id">{lang key='goods::goods.goods_name'}</th>
					<th class="w130">{lang key='goods::goods.business_name'}</th>
					<th class="w80">{lang key='goods::goods.check_goods'}</th>
					<th class="w80" data-toggle="sortby" data-sortby="goods_sn">{lang key='goods::goods.goods_sn'}</th>
					<th class="w70" data-toggle="sortby" data-sortby="shop_price">{lang key='goods::goods.shop_price'}</th>
					<th class="w35"> {lang key='goods::goods.is_on_sale'} </th>
					<th class="w35"> {lang key='goods::goods.is_best'} </th>
					<th class="w35"> {lang key='goods::goods.is_new'} </th>
					<th class="w35"> {lang key='goods::goods.is_hot'} </th>
					<!-- {if $use_storage} -->
					<th class="w50" data-toggle="sortby" data-sortby="goods_number"> {lang key='goods::goods.goods_number'} </th>
					<!-- {/if} --> 
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
						<a href="{url path='goods/admin/edit' args="goods_id={$goods.goods_id}"}" title="Image 10" >
							<img class="thumbnail" alt="{$goods.goods_name}" src="{$goods.goods_thumb}">
						</a>
					</td>
					<td class="hide-edit-area {if $goods.is_promote}ecjiafc-red{/if}">
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin/edit_goods_name')}" data-name="goods_edit_name" data-pk="{$goods.goods_id}" data-title="请输入商品名称"> 
							{$goods.goods_name|escape:html}
						</span>
						{if $goods.is_promote eq 1}<span class="goods-promote">促</span>{/if}
						<br/>
						<div class="edit-list">
							<a class="data-pjax" href='{url path="goods/admin/edit" args="goods_id={$goods.goods_id}"}'>{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goods/admin/edit_goods_attr" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.tab_properties'}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goods/admin_gallery/init" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.tab_gallery'}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goods/admin/edit_link_goods" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.tab_linkgoods'}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goods/admin/edit_link_article" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.tab_article'}</a>&nbsp;|&nbsp;
<!-- 							<a class="data-pjax" href='{url path="goods/admin/edit_link_parts" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.tab_groupgoods'}</a>&nbsp;|&nbsp; -->
							<a target="_blank" href='{url path="goods/admin/preview" args="id={$goods.goods_id}"}'>{lang key='goods::goods.preview'}</a>&nbsp;|&nbsp;
							{if $specifications[$goods.goods_type] neq ''}<a target="_blank" href='{url path="goods/admin/product_list" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.product_list'}</a>&nbsp;|&nbsp;{/if}
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='goods::goods.trash_goods_confirm'}" href='{url path="goods/admin/remove" args="id={$goods.goods_id}"}'>{lang key='system::system.drop'}</a>
						</div>
					</td>	
					
					<td class="ecjiafc-red">
					    {$goods.merchants_name}
					</td>	
					
					<td>
						<span class="cursor_pointer review_static" data-trigger="editable" data-value="{$goods.review_status}" data-type="select"  data-url="{RC_Uri::url('goods/admin/review')}" data-name="sort_order" data-pk="{$goods.goods_id}" data-title="请选择审核状态">
							<!--{if $goods.review_status eq 1}-->未审核<!-- {/if} -->
							<span class="ecjiafc-red"><!--{if $goods.review_status eq 2}-->审核未通过<!-- {/if} --></span>
							<span class="ecjiafc-blue"><!--{if $goods.review_status eq 3 || $goods.review_status eq 4}-->审核已通过<!-- {/if} --></span>
							<!--{if $goods.review_status eq 5}-->无需审核<!-- {/if} -->
						</span>
					</td>
					<td>
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin/edit_goods_sn')}" data-name="goods_edit_goods_sn" data-pk="{$goods.goods_id}" data-title="请输入商品货号">
							{$goods.goods_sn} 
						</span>
					</td>
					<td align="right">
						<span  class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin/edit_goods_price')}" data-name="goods_price" data-pk="{$goods.goods_id}" data-title="请输入商品价格"> 
							{$goods.shop_price}
						</span> 
					</td>
					<td align="center">
						<i class="{if $goods.is_on_sale}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggle_on_sale" data-url="{RC_Uri::url('goods/admin/toggle_on_sale')}" refresh-url="{RC_Uri::url('goods/admin/init')}
							{if $filter.type}&type={$filter.type}{/if}
							{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
							{if $filter.brand_id}&brand_id={$filter.brand_id}{/if}
							{if $filter.intro_type}&intro_type={$filter.intro_type}{/if}
							{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							{if $filter.review_status}&review_status={$filter.review_status}{/if}
							{if $filter.store_id}&store_id={$filter.store_id}{/if}
							" data-id="{$goods.goods_id}">
						</i>
					</td>
					<td align="center">
						<i class="{if $goods.is_best}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/admin/toggle_best')}" data-id="{$goods.goods_id}"></i>
					</td>
					<td align="center">
						<i class="{if $goods.is_new}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/admin/toggle_new')}" data-id="{$goods.goods_id}"></i>
					</td>
					<td align="center">
						<i class="{if $goods.is_hot}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/admin/toggle_hot')}" data-id="{$goods.goods_id}"></i>
					</td>
					<!-- {if $use_storage} -->
					<td align="right">
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin/edit_goods_number')}" data-name="goods_number" data-pk="{$goods.goods_id}" data-title="请输入库存数量">
							{$goods.goods_number}
						</span>
					</td>
					<!-- {/if} -->
					<td align="center">
						<span class="cursor_pointer" data-placement="left" data-trigger="editable" data-url="{RC_Uri::url('goods/admin/edit_sort_order')}" data-name="sort_order" data-pk="{$goods.goods_id}" data-title="请输入排序序号"> 
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