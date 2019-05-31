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
<div>
	<h3 class="heading"> 
		<!-- {if $ur_here}{$ur_here}{/if} --> 
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a">
			<i class="fontello-icon-plus"></i>{$action_link.text}
		</a>{/if}
	</h3>
</div>

<div class="modal hide fade" id="actionmodal">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3 class="modal-title">{t domain="goods"}内部链接{/t}</h3>
    </div>
    <div class="modal-body" style="height:auto;">
		<div class="success-msg"></div>
		<div class="error-msg"></div>
	    <textarea id="link_value"  name="link_value" disabled="disabled"  cols="30" rows="5" class="span5"></textarea>
	    <div class="form-group">
	        <button id="copy_btn" class="btn btn-gebo m_t10">{t domain="goods"}复制{/t}</button>
        </div>
    </div>
</div>

<!-- <div class="row-fluid"> -->
<!-- <div class="choose_list span12">  -->
<ul class="nav nav-pills">
    {foreach $goods_count as $count}
	<li class="{if $list_type === $count.type}active{/if}">
		<a class="data-pjax" href="{$count.link}">
			{t domain='goods'}{$count.label}{/t}
			<span class="badge badge-info">{$count.count}</span>
		</a>
	</li>
    {/foreach}
    
    {if $action neq 'bulk' and  $action neq 'cashier'}
	<form class="f_r form-inline" action='{$list_url}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
		<!-- 关键字 -->
		<input class="w180" type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{t domain='goods'}请输入商家关键字{/t}" size="15" />
		<input class="w180" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain='goods'}请输入商品关键字{/t}" size="15" />
		<button class="btn" type="submit">{t domain='goods'}搜索{/t}</button>
	</form>
	{/if}
</ul>
<!-- </div> -->
<!-- </div> -->

<div class="row-fluid batch">
	{if $action neq 'check'}
		<div class="btn-group f_l m_r5">
			<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fontello-icon-cog"></i>{t domain='goods'}批量操作{/t}<span class="caret"></span>
			</a>
			<ul class="dropdown-menu batch-move" data-url="{RC_Uri::url('goods/admin/batch')}&list_url={$list_url}">
				{if $action neq 'bulk' and  $action neq 'cashier'}
					<li><a class="batch-best-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=best&action_url={$action}&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain='goods'}您确定要把选中的商品设为精品吗？{/t}" data-noSelectMsg="{t domain='goods'}请选择设为精品的商品{/t}" href="javascript:;"> <i class="fontello-icon-star"></i>{t domain='goods'}设为精品{/t}</a></li>
					<li><a class="batch-notbest-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_best&action_url={$action}&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain='goods'}您确定要把选中的商品取消精品吗？{/t}" data-noSelectMsg="{t domain='goods'}请选择取消精品的商品{/t}" href="javascript:;"><i class="fontello-icon-star-empty"></i>{t domain='goods'}取消精品{/t}</a></li>
					<li><a class="batch-new-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=new&action_url={$action}&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain='goods'}您确定要把选中的商品设为新品吗？{/t}" data-noSelectMsg="{t domain='goods'}请选择要设为新品的商品{/t}" href="javascript:;"> <i class="fontello-icon-flag"></i>{t domain='goods'}设为新品{/t}</a></li>
					<li><a class="batch-notnew-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&action_url={$action}&type=not_new&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain='goods'}您确定要把选中的商品取消新品吗？{/t}" data-noSelectMsg="{t domain='goods'}请选择要取消新品的商品{/t}" href="javascript:;"> <i class="fontello-icon-flag-empty"></i>{t domain='goods'}取消新品{/t}</a></li>
					<li><a class="batch-hot-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&action_url={$action}&type=hot&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain='goods'}您确定要把选中的商品设为热销吗？{/t}" data-noSelectMsg="{t domain='goods'}请选择要设为热销的商品{/t}" href="javascript:;"> <i class="fontello-icon-thumbs-up-alt"></i>{t domain='goods'}设为热销{/t}</a></li>
					<li><a class="batch-nothot-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&action_url={$action}&type=not_hot&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain='goods'}您确定要把选中的商品取消热销吗？{/t}" data-noSelectMsg="{t domain='goods'}请选择要取消热销的商品{/t}" href="javascript:;"> <i class="fontello-icon-thumbs-up"></i>{t domain='goods'}取消热销{/t}</a></li>
				{/if}
				<li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&action_url={$action}&type=trash&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain='goods'}您确定要把选中的商品放入回收站吗？{/t}" data-noSelectMsg="{t domain='goods'}请选择要移至回收站的商品{/t}" href="javascript:;"> <i class="fontello-icon-box"></i>{t domain='goods'}移至回收站{/t}</a></li>
			</ul>
		</div>
	{/if}
	
	<form class="form-inline" action="{$list_url}{if $smarty.get.type}&type={$smarty.get.type}{/if}" method="post" name="filterForm">
		<div class="screen f_l">
			
			<div class="f_l m_r5">
				<select class="w150" name="store_id">
					<option value="0">{t domain='goods'}请选择商家{/t}</option>
					<!-- {foreach from=$store_list item=store_name key=store_id} -->
					<option value="{$store_id}" {if $filter.store_id eq $store_id}selected{/if}>{$store_name}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<button class="btn filter-btn" type="button">{t domain='goods'}筛选{/t}</button>
		</div>
		{if $action neq 'bulk' and  $action neq 'cashier'}
		<div class="screen f_r">
			<!-- 分类 -->
			<div class="f_l m_r5">
				<select class="w150" name="cat_id">
					<option value="0">{t domain='goods'}所有分类{/t}</option>
                    {$cat_list_option}
				</select>
			</div>
			<!-- 品牌 -->
			<div class="f_l m_r5">
				<select class="no_search w120" name="brand_id">
					<option value="0">{t domain='goods'}所有品牌{/t}</option>
					<!-- {foreach from=$brand_list item=list key=key} -->
					<option value="{$key}" {if $key == $smarty.get.brand_id}selected{/if}>{$list}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<!-- 推荐 -->
			<div class="f_l m_r5">
				<select class="w100" name="intro_type">
					<option value="0">{t domain='goods'}全部{/t}</option>
					<!-- {foreach from=$intro_list item=list key=key} -->
					<option value="{$key}" {if $key == $smarty.get.intro_type}selected{/if}>{$list}</option>
					<!-- {/foreach} -->
				</select>
			</div>
			<button class="btn screen-btn" type="button">{t domain='goods'}筛选{/t}</button>
		</div>
		{/if}
	</form>
	{if $action eq 'bulk' or $action eq 'cashier'}
	<form class="f_r form-inline" action='{$list_url}{if $smarty.get.type}&type={$smarty.get.type}{/if}' method="post" name="searchForm">
		<!-- 关键字 -->
		<input class="w180" type="text" name="merchant_keywords" value="{$smarty.get.merchant_keywords}" placeholder="{t domain='goods'}请输入商家关键字{/t}" size="15" />
		<input class="w180" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain='goods'}请输入商品关键字{/t}" size="15" />
		<button class="btn" type="submit">{t domain='goods'}搜索{/t}</button>
	</form>
	{/if}
</div>

<div class="row-fluid list-page">
	<div class="span12">
		<table class="table table-striped smpl_tbl table_vam table-hide-edit" id="smpl_tbl" data-uniform="uniform">
			<thead>
				<tr data-sorthref='{$list_url}{if $smarty.get.type}&type={$smarty.get.type}{/if}'>
					<th class="table_checkbox">
						<input type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
					</th>
					
					{if $action neq 'bulk' and  $action neq 'cashier'}
					<th class="w80">{t domain='goods'}缩略图{/t}</th>
					{/if}
					
					<th class="w200">{t domain='goods'}店铺+商品信息{/t}</th>
					{if $action neq 'check'}
					<th class="w100" data-toggle="sortby" data-sortby="goods_sn">{t domain='goods'}货号{/t}</th>
					{/if}
					<th class="w100" data-toggle="sortby" data-sortby="shop_price">{t domain='goods'}价格{/t}</th>
					
					{if $action eq 'bulk'}
					<th class="w100">{t domain='goods'}单位{/t}</th>
					{/if}
					
					{if $action eq 'cashier'}
					<th class="w100">{t domain='goods'}销量{/t}</th>
					{/if}
					
					<!-- {if $use_storage} -->
					<th class="w100" data-toggle="sortby" data-sortby="goods_number"> {t domain='goods'}库存{/t} </th>
					<!-- {/if} --> 
					
					{if $action neq 'check'}
					<th class="w35" data-toggle="sortby" data-sortby="sort_order">{t domain='goods'}排序{/t}</th>
					{/if}
					
					{if $action neq 'bulk' and  $action neq 'cashier'}
					<th class="w80"> {t domain='goods'}加入推荐{/t} </th>
					{/if}
					
					{if $action eq 'check'}
					<th class="w50"> {t domain='goods'}审核状态{/t} </th>
					<th class="w80"> {if $list_type}{t domain='goods'}审核时间{/t}{else}{t domain='goods'}添加时间{/t}{/if} </th>
					{/if}
				</tr>
			</thead>
			<tbody>
				<!-- {foreach from=$goods_list.goods item=goods}-->
				<tr class="big">
			
					<td class="center-td">
						<input class="checkbox" type="checkbox" name="checkboxes[]" value="{$goods.goods_id}"/>
					</td>	
					
					{if $action neq 'bulk' and  $action neq 'cashier'}				
					<td>
						<img class="thumbnail" alt="{$goods.goods_name}" src="{$goods.goods_thumb}">
					</td>
					{/if}
					
					<td class="hide-edit-area">
						<strong>{$goods.merchants_name}</strong>
						</span>{if $goods.manage_mode eq 'self'}<span class="ecjiafc-red">{t domain='goods'}（自营）{/t}</span>{/if}
						<br>
                        {if $goods.has_product}<span class="label-orange">{t domain='goods'}多货品{/t}{/if}</span>
						{$goods.goods_name|escape:html}
						{if $goods.is_promote && $action eq 'finish'}<span class="goods-promote">{t domain='goods'}促{/t}</span>{/if}
						<br/>
						<div class="edit-list">
							{if $preview_type}
							<a target="_blank" href='{url path="goods/admin/preview" args="id={$goods.goods_id}&preview_type={$preview_type}"}'>{t domain='goods'}预览{/t}</a>&nbsp;|&nbsp;
							{/if}
							
							{if $action eq 'sale' or $action eq 'finish'}
							<a href="#actionmodal" data-toggle="modal" id="modal" copy-url="ecjiaopen://app?open_type=goods_detail&goods_id={$goods.goods_id}" >{t domain='goods'}内部链接{/t}</a>&nbsp;|&nbsp;
							{/if}
							
							{if $action eq 'sale' or $action eq 'finish' or $action eq 'obtained'}
							<a class="insert-goods-btn" href="javascript:;" data-href='{url path="goods/admin/insert_goodslib" args="goods_id={$goods.goods_id}"}' 
								data-id="{$goods.goods_id}" data-name="{$goods.goods_name}" data-sn="{$goods.goods_sn}" data-shopprice="{$goods.shop_price}" data-marketprice="{$goods.market_price}" data-costprice="{$goods.cost_price}">{t domain='goods'}导入商品库{/t}</a>&nbsp;|&nbsp;
							{/if}
							
							{if $action neq 'check'}
								<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t domain='goods'}您确定要把该商品放入回收站吗？{/t}" href='{url path="goods/admin/remove" args="id={$goods.goods_id}"}'>{t domain='goods'}删除{/t}</a>
							{/if}
							
							{if $action eq 'check'}
								{if $goods.review_status eq 1}
									<a data-toggle="modal" data-backdrop="static" href="#myModal2" goods-id="{$goods.goods_id}">{t domain='goods'}审核{/t}</a>
								{/if}
								
								{if $goods.review_status eq 2}
									<a  href="#review_log" data-toggle="modal" data-type="log" data-backdrop="static"  goods-id="{$goods.goods_id}" attr-url="{RC_Uri::url('goods/admin/review_log')}">{t domain='goods'}查看审核{/t}</a>
								{/if}
							{/if}
						</div>
					</td>	
					
					{if $action neq 'check'}<td>{$goods.goods_sn}</td>{/if}
					
					<td>{$goods.shop_price}</td>
					
					{if $action eq 'bulk'}
						<td>{if $goods.weight_unit eq '1'}{t domain="cashier"}克{/t}{else}{t domain="cashier"}千克{/t}{/if}</td>
					{/if}
					
					{if $action eq 'cashier'}
						<td>{if $goods.sales_volume}{$goods.sales_volume}{else}0{/if}</td>
					{/if}
					
					<!-- {if $use_storage} -->
					<td>{$goods.goods_number}</td>
					<!-- {/if} -->
					{if $action neq 'check'}
					<td>
						<span class="cursor_pointer" data-placement="left" data-trigger="editable" data-url="{RC_Uri::url('goods/admin/edit_sort_order')}" data-name="sort_order" data-pk="{$goods.goods_id}" data-title="{t domain='goods'}请输入排序序号{/t}">
							{$goods.sort_order}
						</span>
					</td>
					{/if}
					
					{if $action neq 'bulk' and  $action neq 'cashier'}
					<td>
                        <span class="label label-info cursor_pointer {if $goods.is_best}toggleOn{else}toggleOff {/if}" data-trigger="toggleStateNew" data-url="{RC_Uri::url('goods/admin/toggle_best')}
							{if $filter.type}&type={$filter.type}{/if}
							{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
							{if $filter.brand_id}&brand_id={$filter.brand_id}{/if}
							{if $filter.intro_type}&intro_type={$filter.intro_type}{/if}
							{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							{if $filter.store_id}&store_id={$filter.store_id}{/if}
							{if $smarty.get.page}&page={$smarty.get.page}{/if}
							" data-id="{$goods.goods_id}"">{t domain='goods'}精{/t}</span>
                        <span class="label label-success cursor_pointer {if $goods.is_new}toggleOn{else}toggleOff{/if}" data-trigger="toggleStateNew" data-url="{RC_Uri::url('goods/admin/toggle_new')}
							{if $filter.type}&type={$filter.type}{/if}
							{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
							{if $filter.brand_id}&brand_id={$filter.brand_id}{/if}
							{if $filter.intro_type}&intro_type={$filter.intro_type}{/if}
							{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							{if $filter.store_id}&store_id={$filter.store_id}{/if}
							{if $smarty.get.page}&page={$smarty.get.page}{/if}
							" data-id="{$goods.goods_id}"">{t domain='goods'}新{/t}</span>
                        <span class="label label-important cursor_pointer {if $goods.is_hot}toggleOn{else}toggleOff{/if}" data-trigger="toggleStateNew" data-url="{RC_Uri::url('goods/admin/toggle_hot')}
							{if $filter.type}&type={$filter.type}{/if}
							{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}
							{if $filter.brand_id}&brand_id={$filter.brand_id}{/if}
							{if $filter.intro_type}&intro_type={$filter.intro_type}{/if}
							{if $filter.merchant_keywords}&merchant_keywords={$filter.merchant_keywords}{/if}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}
							{if $filter.store_id}&store_id={$filter.store_id}{/if}
							{if $smarty.get.page}&page={$smarty.get.page}{/if}
                            " data-id="{$goods.goods_id}">{t domain='goods'}热{/t}</span>
					</td>
					{/if}
					
					{if $action eq 'check'}
						<td>{if $goods.review_status eq 1}{t domain='goods'}待审核{/t}{elseif $goods.review_status eq 2}{t domain='goods'}审核未通过{/t}{/if}</td>
						<td>{$goods.add_time}</td>
					{/if}
				</tr>
				<!-- {foreachelse}-->
				<tr>
					<td class="no-records" colspan="13">{t domain='goods'}没有找到任何记录{/t}</td>
				</tr>
				<!-- {/foreach} -->
			</tbody>
		</table>
		<!-- {$goods_list.page} -->
	</div>
</div>

<div class="modal hide fade" id="movetype">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3>{t domain='goods'}转移商品至分类{/t}</h3>
    </div>
    <div class="modal-body h300">
        <div class="row-fluid ecjiaf-tac">
            <div>
                <select class="noselect w200" size="15" name="target_cat">
                    <option value="0">{t domain='goods'}所有分类{/t}</option>
                    <!-- {foreach from=$cat_list item=cat} -->
                    <option value="{$cat.cat_id}" {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
                    <!-- {/foreach} -->
                </select>
            </div>
            <div>
                <a class="btn btn-gebo m_l5" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=move_to&" data-msg="{t domain='goods'}是否将选中商品转移至分类？{/t}" data-noSelectMsg="{t domain='goods'}请选择要转移的商品{/t}" href="javascript:;" name="move_cat_ture">{t domain='goods'}开始转移{/t}</a>
            </div>
        </div>
    </div>
</div>



<div class="modal hide fade" id="myModal2" >
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3 class="modal-title">{t domain='goods'}审核{/t}</h3>
    </div>
    <div class="modal-body" >
        <form class="form-horizontal" action="{RC_Uri::url('goods/admin/check_review')}&curr_page={$page}" method="post" name="checkForm">
            <div class="control-group control-group-small">
                <label class="control-label">{t domain='goods'}审核备注：{/t}</label>
                <div class="controls">
                   <textarea class="w350" id="review_content" name="review_content" rows="6" cols="48" placeholder="请输入审核备注信息"></textarea>
                	<span class="input-must">*</span>
                </div>
            </div>
            
            <div class="control-group control-group-small">
                <div class="controls">
					<select class="w350" id="check_review_log" name="check_review_log">
						<option value="0">{t domain='goods'}请选择……{/t}</option>
						<option value="1">{t domain='goods'}审核通过{/t}</option>
						<option value="2">{t domain='goods'}审核通过，商品符合商城规定，允许上架售卖{/t}</option>
						<option value="3">{t domain='goods'}审核未通过，您的商品存在违规行为{/t}</option>
						<option value="4">{t domain='goods'}商品信息不全或图片不清晰，请补充后再提交{/t}</option>
						<option value="5">{t domain='goods'}所上传商品名称及文字内容触犯广告法,不能使用国家级、最高级、最佳等敏感性用语{/t}</option>
					</select>
				</div>
            </div>
            
            <div class="control-group control-group-small">
	            <div class="controls">
	                 <a class="change_status btn btn-gebo" review_status="3" href="javascript:;">{t domain='goods'}通过{/t}</a>
	                 <a class="change_status btn " review_status="2" href="javascript:;">{t domain='goods'}拒绝{/t}</a>
	            </div>
            </div>
        </form>
    </div>
</div>

<div id="review_log" class="modal hide fade" ></div>

<div class="modal hide fade" id="insertGoods">
    <div class="modal-header">
        <button class="close" data-dismiss="modal">×</button>
        <h3 class="modal-title">{t domain='goods'}导入商品{/t}</h3>
    </div>
    <div class="modal-body" style="height:auto;">
        <form class="form-horizontal" action="{$form_action_insert}" method="post" name="insertForm">
            <div class="control-group control-group-small formSep">
                <label class="control-label">{t domain='goods'}商品名称{/t}</label>
                <div class="controls">
                    <input class="form-control" name="goods_name" type="text" value="" />
                    <span class="input-must m_l15">*</span>
                </div>
            </div>
            <div class="control-group control-group-small formSep">
                <label class="control-label">{t domain='goods'}本店售价{/t}</label>
                <div class="controls">
                    <input class="form-control" name="shop_price" type="text" value="" />
                    <a class="btn" data-toggle="marketPriceSetted">{t domain='goods'}按市场价计算{/t}</a>
                    <span class="input-must">*</span>
                </div>
            </div>
            <div class="control-group control-group-small formSep">
                <label class="control-label">{t domain='goods'}市场售价{/t}</label>
                <div class="controls">
                    <input class="form-control" name="market_price" type="text" value="" />
                    <a class="btn" data-toggle="integral_market_price">{t domain='goods'}取整数{/t}</a>
                </div>
            </div>
            <div class="control-group control-group-small formSep">
                <label class="control-label">{t domain='goods'}成本价{/t}</label>
                <div class="controls">
                    <input class="form-control" name="cost_price" type="text" value="" />
                </div>
            </div>
            <div class="control-group control-group-small formSep">
                <label class="control-label">{t domain='goods'}上架{/t}</label>
                <div class="controls chk_radio">
                    <input type="checkbox" name="is_display" value="1" style="opacity: 0;" checked="checked">
                    <span>{t domain='goods'}打勾表示商家可见此商品，并允许商家将此商品导入店铺{/t}</span>
                </div>
            </div>

            <input type="hidden" name="goods_id" value="" />

            <div class="form-group t_c">
                <a class="btn btn-gebo insertSubmit" href="javascript:;">{t domain='goods'}开始导入{/t}</a>
            </div>
        </form>
    </div>
</div>

<!-- {/block} -->