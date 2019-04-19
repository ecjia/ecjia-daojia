<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_list.init();
	ecjia.admin.goods_info.integral_market_price();
	ecjia.admin.goods_info.marketPriceSetted();
	ecjia.admin.goods_info.priceSetted();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div class="modal hide fade" id="movetype">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{t domain="goods"}转移商品至分类{/t}</h3>
	</div>
	<div class="modal-body h300">
		<div class="row-fluid ecjiaf-tac">
			<div>
				<select class="noselect w200" size="15" name="target_cat">
					<option value="0">{t domain="goods"}所有分类{/t}</option>
					<!-- {foreach from=$cat_list item=cat} -->
					<option value="{$cat.cat_id}" {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<div>
				<a class="btn btn-gebo m_l5" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=move_to&" data-msg="{t domain="goods"}是否将选中商品转移至分类？{/t}" data-noSelectMsg="{t domain="goods"}请选择要转移的商品{/t}" href="javascript:;" name="move_cat_ture">{t domain="goods"}开始转移{/t}</a>
			</div>
		</div>
	</div>
</div>

<div class="modal hide fade" id="insertGoods">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3 class="modal-title">{t domain="goods"}导入商品{/t}</h3>
	</div>
	<div class="modal-body" style="height:auto;">
		<form class="form-horizontal" action="{$form_action_insert}" method="post" name="insertForm">
  			<div class="control-group control-group-small formSep">
				<label class="control-label">{t domain="goods"}商品名称{/t}</label>
				<div class="controls">
					<input class="form-control" name="goods_name" type="text" value="" />
					<span class="input-must m_l15">*</span>
				</div>
			</div>
			<div class="control-group control-group-small formSep">
				<label class="control-label">{t domain="goods"}商品货号{/t}</label>
				<div class="controls">
					<input class="form-control" name="goods_sn" type="text" value="" />
				</div>
			</div>
			<div class="control-group control-group-small formSep">
				<label class="control-label">{t domain="goods"}本店售价{/t}</label>
				<div class="controls">
					<input class="form-control" name="shop_price" type="text" value="" />
					<a class="btn" data-toggle="marketPriceSetted">{t domain="goods"}按市场价计算{/t}</a>
					<span class="input-must">*</span>
				</div>
			</div>
			<div class="control-group control-group-small formSep">
				<label class="control-label">{t domain="goods"}市场售价{/t}</label>
				<div class="controls">
					<input class="form-control" name="market_price" type="text" value="" />
					<a class="btn" data-toggle="integral_market_price">{t domain="goods"}取整数{/t}</a>
				</div>
			</div>
			<div class="control-group control-group-small formSep">
				<label class="control-label">{t domain="goods"}上架{/t}</label>
				<div class="controls chk_radio">
					<input type="checkbox" name="is_display" value="1" style="opacity: 0;" checked="checked">
					<span>{t domain="goods"}打勾表示商家可见此商品，并允许商家将此商品导入店铺{/t}</span>
				</div>
			</div>
											
          	<input type="hidden" name="goods_id" value="" />
          	
			<div class="form-group t_c">
				<a class="btn btn-gebo insertSubmit" href="javascript:;">{t domain="goods"}开始导入{/t}</a>
			</div>
		</form>
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
			{t domain="goods"}全部{/t}
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
			")}'>{t domain="goods"}已上架{/t}
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
			")}'>{t domain="goods"}未上架{/t}
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
			")}'>{t domain="goods"}自营{/t}
			<span class="badge badge-info unuse-plugins-num">{$goods_list.filter.self}</span>
		</a>
	</li>

	<form class="f_r form-inline" action='{RC_Uri::url("goods/admin/init")}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
		<!-- 关键字 -->
		<input class="w180" type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{t domain="goods"}请输入商家关键字{/t}" size="15" />
		<input class="w180" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain="goods"}请输入商品关键字{/t}" size="15" />
		<button class="btn" type="submit">{t domain="goods"}搜索{/t}</button>
	</form>
</ul>
<!-- </div> -->
<!-- </div> -->

<div class="row-fluid batch">
	<div class="btn-group f_l m_r5">
		<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
			<i class="fontello-icon-cog"></i>{t domain="goods"}批量操作{/t}<span class="caret"></span>
		</a>
		<ul class="dropdown-menu batch-move" data-url="{RC_Uri::url('goods/admin/batch')}">
			<li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=trash&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goods"}您确定要把选中的商品放入回收站吗？{/t}" data-noSelectMsg="{t domain="goods"}请选择要移至回收站的商品{/t}" href="javascript:;"> <i class="fontello-icon-box"></i>{t domain="goods"}移至回收站{/t}</a></li>
			<li><a class="batch-sale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=on_sale&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goods"}您确定要把选中的商品上架吗？{/t}" data-noSelectMsg="{t domain="goods"}请选择要上架的商品{/t}" href="javascript:;"> <i class="fontello-icon-up-circled2"></i>{t domain="goods"}上架{/t}</a></li>
			<li><a class="batch-notsale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_on_sale&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goods"}您确定要把选中的商品下架吗？{/t}" data-noSelectMsg="{t domain="goods"}请选择要下架的商品{/t}" href="javascript:;"> <i class="fontello-icon-down-circled2"></i>{t domain="goods"}下架{/t}</a></li>
			<li><a class="batch-best-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=best&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goods"}您确定要把选中的商品设为精品吗？{/t}" data-noSelectMsg="{t domain="goods"}请选择设为精品的商品{/t}" href="javascript:;"> <i class="fontello-icon-star"></i>{t domain="goods"}精品{/t}</a></li>
			<li><a class="batch-notbest-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_best&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goods"}您确定要把选中的商品取消精品吗？{/t}" data-noSelectMsg="{t domain="goods"}请选择取消精品的商品{/t}" href="javascript:;"><i class="fontello-icon-star-empty"></i>{t domain="goods"}取消精品{/t}</a></li>
			<li><a class="batch-new-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=new&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goods"}您确定要把选中的商品设为新品吗？{/t}" data-noSelectMsg="{t domain="goods"}请选择要设为新品的商品{/t}" href="javascript:;"> <i class="fontello-icon-flag"></i>{t domain="goods"}新品{/t}</a></li>
			<li><a class="batch-notnew-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_new&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goods"}您确定要把选中的商品取消新品吗？{/t}" data-noSelectMsg="{t domain="goods"}请选择要取消新品的商品{/t}" href="javascript:;"> <i class="fontello-icon-flag-empty"></i>{t domain="goods"}取消新品{/t}</a></li>
			<li><a class="batch-hot-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=hot&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goods"}您确定要把选中的商品设为热销吗？{/t}" data-noSelectMsg="{t domain="goods"}请选择要设为热销的商品{/t}" href="javascript:;"> <i class="fontello-icon-thumbs-up-alt"></i>{t domain="goods"}热销{/t}</a></li>
			<li><a class="batch-nothot-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_hot&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goods"}您确定要把选中的商品取消热销吗？{/t}" data-noSelectMsg="{t domain="goods"}请选择要取消热销的商品{/t}" href="javascript:;"> <i class="fontello-icon-thumbs-up"></i>{t domain="goods"}取消热销{/t}</a></li>
			<li><a class="batch-move-btn"data-name="move_cat" data-move="data-operatetype" href="javascript:;"> <i class="fontello-icon-forward"></i>{t domain="goods"}转移到分类{/t}</a></li>
			
			<li><a class="batch-pass-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=pass&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goods"}您确定要审核通过选中的商品吗？{/t}" data-noSelectMsg="{t domain="goods"}请选择需要修改审核状态的商品{/t}" href="javascript:;"> <i class="fontello-icon-ok-circled"></i>{t domain="goods"}审核通过{/t}</a></li>
			<li><a class="batch-notpass-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_pass&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goods"}您确定要不审核通过选中的商品吗？{/t}" data-noSelectMsg="{t domain="goods"}请选择需要修改审核状态的商品{/t}" href="javascript:;"> <i class="fontello-icon-cancel-circled"></i>{t domain="goods"}审核未通过{/t}</a></li>
			<li><a class="batch-notaudited-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_audited&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goods"}您确定要将选中的商品设为未审核吗？{/t}" data-noSelectMsg="{t domain="goods"}请选择需要修改审核状态的商品{/t}" href="javascript:;"> <i class="fontello-icon-help-circled"></i>{t domain="goods"}设为未审核{/t}</a></li>
			<li><a class="batch-notcheck-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_check&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goods"}您确定要将选中的商品设为无需审核吗？{/t}" data-noSelectMsg="{t domain="goods"}请选择需要修改审核状态的商品{/t}" href="javascript:;"> <i class=" fontello-icon-gittip"></i>{t domain="goods"}无需审核{/t}</a></li>
	</div>

	<form class="form-inline" action="{RC_Uri::url('goods/admin/init')}{if $smarty.get.type}&type={$smarty.get.type}{/if}" method="post" name="filterForm">
		<div class="screen f_l">
			<div class="f_l m_r5">
				<select class="w150" name="review_status">
					<option value="0">{t domain="goods"}请选择审核状态{/t}</option>
					<option value="1" {if $filter.review_status eq 1}selected{/if}>{t domain="goods"}未审核{/t}</option>
					<option value="2" {if $filter.review_status eq 2}selected{/if}>{t domain="goods"}审核未通过{/t}</option>
					<option value="3" {if $filter.review_status eq 3}selected{/if}>{t domain="goods"}已审核{/t}</option>
					<option value="5" {if $filter.review_status eq 5}selected{/if}>{t domain="goods"}无需审核{/t}</option>
				</select>
			</div>
			
			<div class="f_l m_r5">
				<select class="w150" name="store_id">
					<option value="0">{t domain="goods"}请选择商家{/t}</option>
					<!-- {foreach from=$store_list item=val} -->
					<option value="{$val.store_id}" {if $filter.store_id eq $val.store_id}selected{/if}>{$val.merchants_name}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<button class="btn filter-btn" type="button">{t domain="goods"}筛选{/t}</button>
		</div>
		
		<div class="screen f_r">
			<!-- 分类 -->
			<div class="f_l m_r5">
				<select class="w150" name="cat_id">
					<option value="0">{t domain="goods"}所有分类{/t}</option>
					<!-- {foreach from=$cat_list item=cat} -->
					<option value="{$cat.cat_id}" {if $cat.cat_id == $smarty.get.cat_id}selected{/if} {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<!-- 品牌 -->
			<div class="f_l m_r5">
				<select class="no_search w120" name="brand_id">
					<option value="0">{t domain="goods"}所有品牌{/t}</option>
					<!-- {foreach from=$brand_list item=list key=key} -->
					<option value="{$key}" {if $key == $smarty.get.brand_id}selected{/if}>{$list}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<!-- 推荐 -->
			<div class="f_l m_r5">
				<select class="w100" name="intro_type">
					<option value="0">{t domain="goods"}全部{/t}</option>
					<!-- {foreach from=$intro_list item=list key=key} -->
					<option value="{$key}" {if $key == $smarty.get.intro_type}selected{/if}>{$list}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<button class="btn screen-btn" type="button">{t domain="goods"}筛选{/t}</button>
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
					<th class="w80">{t domain="goods"}缩略图{/t}</th>
					<th class="w100" data-toggle="sortby" data-sortby="goods_id">{t domain="goods"}商品名称{/t}</th>
					<th class="w130">{t domain="goods"}商家名称{/t}</th>
					<th class="w80">{t domain="goods"}审核{/t}</th>
					<th class="w80" data-toggle="sortby" data-sortby="goods_sn">{t domain="goods"}货号{/t}</th>
					<th class="w70" data-toggle="sortby" data-sortby="shop_price">{t domain="goods"}价格{/t}</th>
					<th class="w35"> {t domain="goods"}上架{/t} </th>
					<th class="w35"> {t domain="goods"}精品{/t} </th>
					<th class="w35"> {t domain="goods"}新品{/t} </th>
					<th class="w35"> {t domain="goods"}热销{/t} </th>
					<!-- {if $use_storage} -->
					<th class="w50" data-toggle="sortby" data-sortby="goods_number"> {t domain="goods"}库存{/t} </th>
					<!-- {/if} --> 
					<th class="w35" data-toggle="sortby" data-sortby="sort_order">{t domain="goods"}排序{/t}</th>
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$goods_list.goods item=goods}-->
				<tr class="big">
					<td class="center-td">
						<input class="checkbox" type="checkbox" name="checkboxes[]" value="{$goods.goods_id}"/>
					</td>						
					<td>
						<a href="{url path='goods/admin/edit' args="goods_id={$goods.goods_id}"}" title="{$goods.goods_name|escape:html}" >
							<img class="thumbnail" alt="{$goods.goods_name}" src="{$goods.goods_thumb}">
						</a>
					</td>
					<td class="hide-edit-area {if $goods.is_promote}ecjiafc-red{/if}">
                        {if $goods.product_list}<span class="label-orange">{t domain="goods"}多货品{/t}{/if}</span>
                        <span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin/edit_goods_name')}" data-name="goods_edit_name" data-pk="{$goods.goods_id}" data-title="请输入商品名称">
							{$goods.goods_name|escape:html}
						</span>
						{if $goods.is_promote eq 1}<span class="goods-promote">{t domain="goods"}促{/t}</span>{/if}
						<br/>
						<div class="edit-list">
							<a class="data-pjax" href='{url path="goods/admin/edit" args="goods_id={$goods.goods_id}"}'>{t domain="goods"}编辑{/t}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goods/admin/edit_goods_attr" args="goods_id={$goods.goods_id}"}'>{t domain="goods"}商品属性{/t}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goods/admin_gallery/init" args="goods_id={$goods.goods_id}"}'>{t domain="goods"}商品相册{/t}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goods/admin/edit_link_goods" args="goods_id={$goods.goods_id}"}'>{t domain="goods"}关联商品{/t}</a>&nbsp;|&nbsp;
							<a class="data-pjax" href='{url path="goods/admin/edit_link_article" args="goods_id={$goods.goods_id}"}'>{t domain="goods"}关联文章{/t}</a>&nbsp;|&nbsp;
<!-- 							<a class="data-pjax" href='{url path="goods/admin/edit_link_parts" args="goods_id={$goods.goods_id}"}'>{t domain="goods"}关联配件{/t}</a>&nbsp;|&nbsp; -->
							<a target="_blank" href='{url path="goods/admin/preview" args="id={$goods.goods_id}"}'>{t domain="goods"}预览{/t}</a>&nbsp;|&nbsp;
							{if $specifications[$goods.goods_type] neq ''}<a target="_blank" href='{url path="goods/admin/product_list" args="goods_id={$goods.goods_id}"}'>{t domain="goods"}货品列表{/t}</a>&nbsp;|&nbsp;{/if}
							<a class="insert-goods-btn" href="javascript:;" data-href='{url path="goods/admin/insert_goodslib" args="goods_id={$goods.goods_id}"}' 
										data-id="{$goods.goods_id}" data-name="{$goods.goods_name}" data-sn="{$goods.goods_sn}" data-shopprice="{$goods.shop_price}" data-marketprice="{$goods.market_price}">{t domain="goods"}导入商品库{/t}</a>&nbsp;|&nbsp;
							<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t domain="goods"}您确定要把该商品放入回收站吗？{/t}" href='{url path="goods/admin/remove" args="id={$goods.goods_id}"}'>{t domain="goods"}删除{/t}</a>
						</div>
					</td>	
					
					<td class="ecjiafc-red">
					    {$goods.merchants_name}
					</td>	
					
					<td>
						<span class="cursor_pointer review_static" data-trigger="editable" data-value="{$goods.review_status}" data-type="select"  data-url="{RC_Uri::url('goods/admin/review')}" data-name="sort_order" data-pk="{$goods.goods_id}" data-title="{t domain="goods"}请选择审核状态{/t}">
							<!--{if $goods.review_status eq 1}-->{t domain="goods"}未审核{/t}<!-- {/if} -->
							<span class="ecjiafc-red"><!--{if $goods.review_status eq 2}-->{t domain="goods"}审核未通过{/t}<!-- {/if} --></span>
							<span class="ecjiafc-blue"><!--{if $goods.review_status eq 3 || $goods.review_status eq 4}-->{t domain="goods"}审核已通过{/t}<!-- {/if} --></span>
							<!--{if $goods.review_status eq 5}-->{t domain="goods"}无需审核{/t}<!-- {/if} -->
						</span>
					</td>
					<td>
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin/edit_goods_sn')}" data-name="goods_edit_goods_sn" data-pk="{$goods.goods_id}" data-title="{t domain="goods"}请输入商品货号{/t}">
							{$goods.goods_sn} 
						</span>
					</td>
					<td align="right">
						<span  class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin/edit_goods_price')}" data-name="goods_price" data-pk="{$goods.goods_id}" data-title="{t domain="goods"}请输入商品价格{/t}">
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
							{if $smarty.get.page}&page={$smarty.get.page}{/if}
							" data-id="{$goods.goods_id}">
						</i>
					</td>
					<td align="center">
						<i class="{if $goods.is_best}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/admin/toggle_best')}
							{if $filter.type}&type={$filter.type}{/if}
							{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
							{if $filter.brand_id}&brand_id={$filter.brand_id}{/if}
							{if $filter.intro_type}&intro_type={$filter.intro_type}{/if}
							{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							{if $filter.review_status}&review_status={$filter.review_status}{/if}
							{if $filter.store_id}&store_id={$filter.store_id}{/if}
							{if $smarty.get.page}&page={$smarty.get.page}{/if}
							" data-id="{$goods.goods_id}"></i>
					</td>
					<td align="center">
						<i class="{if $goods.is_new}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/admin/toggle_new')}
							{if $filter.type}&type={$filter.type}{/if}
							{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
							{if $filter.brand_id}&brand_id={$filter.brand_id}{/if}
							{if $filter.intro_type}&intro_type={$filter.intro_type}{/if}
							{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							{if $filter.review_status}&review_status={$filter.review_status}{/if}
							{if $filter.store_id}&store_id={$filter.store_id}{/if}
							{if $smarty.get.page}&page={$smarty.get.page}{/if}
							" data-id="{$goods.goods_id}"></i>
					</td>
					<td align="center">
						<i class="{if $goods.is_hot}fontello-icon-ok cursor_pointer{else}fontello-icon-cancel cursor_pointer{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/admin/toggle_hot')}
							{if $filter.type}&type={$filter.type}{/if}
							{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
							{if $filter.brand_id}&brand_id={$filter.brand_id}{/if}
							{if $filter.intro_type}&intro_type={$filter.intro_type}{/if}
							{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							{if $filter.review_status}&review_status={$filter.review_status}{/if}
							{if $filter.store_id}&store_id={$filter.store_id}{/if}
							{if $smarty.get.page}&page={$smarty.get.page}{/if}" data-id="{$goods.goods_id}"></i>
					</td>
					<!-- {if $use_storage} -->
					<td align="right">
						<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/admin/edit_goods_number')}" data-name="goods_number" data-pk="{$goods.goods_id}" data-title="{t domain="goods"}请输入库存数量{/t}">
							{$goods.goods_number}
						</span>
					</td>
					<!-- {/if} -->
					<td align="center">
						<span class="cursor_pointer" data-placement="left" data-trigger="editable" data-url="{RC_Uri::url('goods/admin/edit_sort_order')}" data-name="sort_order" data-pk="{$goods.goods_id}" data-title="{t domain="goods"}请输入排序序号{/t}">
							{$goods.sort_order}
						</span>
					</td>
				</tr>
				<!-- {foreachelse}-->
				<tr>
					<td class="no-records" colspan="13">{t domain="goods"}没有找到任何记录{/t}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$goods_list.page} -->
	</div>
</div>
<!-- {/block} -->