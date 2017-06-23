<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.goods_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="modal fade" id="movetype">
	<div class="modal-dialog">
    	<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title">{lang key='goods::goods.move_to_cat'}</h4>
			</div>
			<div class="modal-body h400">
				<form class="form-horizontal" method="post" name="batchForm">
					<div class="form-group ecjiaf-tac">
						<div>
							<select class="noselect w200 ecjiaf-ib form-control" size="15" name="target_cat">
							<!-- {if $cat_list} -->
								<!-- {foreach from=$cat_list item=cat} -->
								<option value="{$cat.cat_id}" {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
								<!-- {/foreach} -->
							<!-- {else} -->
								<option value="0">暂无任何分类</option>
							<!-- {/if} -->
							</select>
						</div>
					</div>
					<div class="form-group t_c">
						<a class="btn btn-primary m_l5 disabled" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=move_to&" data-msg="{lang key='goods::goods.move_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_move_goods'}" href="javascript:;" name="move_cat_ture">{lang key='goods::goods.start_move'}</a>
					</div>
				</form>
           </div>
		</div>
	</div>
</div>

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-plus"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<ul class="nav nav-pills pull-left">
					<li class="{if !$smarty.get.type}active{/if}">
						<a class="data-pjax" href='{RC_Uri::url("goods/merchant/init", "{$get_url}&type=''")}'>{lang key='goods::goods.intro_type'} 
							<span class="badge badge-info">{$goods_list.filter.count_goods_num}</span>
						</a>
					</li>
					
					<li class="{if $smarty.get.type eq 1}active{/if}">
						<a class="data-pjax" href='{RC_Uri::url("goods/merchant/init", "{$get_url}&type=1")}'>{lang key='goods::goods.is_on_saled'}
							<span class="badge badge-info use-plugins-num">{$goods_list.filter.count_on_sale}</span>
						</a>
					</li>
					
					<li class="{if $smarty.get.type eq 2}active{/if}">	
						<a class="data-pjax" href='{RC_Uri::url("goods/merchant/init", "{$get_url}&type=2")}'>{lang key='goods::goods.not_on_saled'}
							<span class="badge badge-info unuse-plugins-num">{$goods_list.filter.count_not_sale}</span>
						</a>
					</li>
				</ul>	
				<div class="clearfix"></div>
			</div>
			
			<div class="panel-body panel-body-small">
				<div class="btn-group f_l">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> {lang key='goods::goods.batch_handle'} <span class="caret"></span></button>
					<ul class="dropdown-menu">
		                <li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=trash&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_trash_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_trash_goods'}" href="javascript:;"><i class="fa fa-archive"></i> {lang key='goods::goods.move_to_trash'}</a></li>
						<li><a class="batch-sale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=on_sale&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_on_sale_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_sale_goods'}" href="javascript:;"><i class="fa fa-arrow-circle-o-up"></i> {lang key='goods::goods.on_sale'}</a></li>
						<li><a class="batch-notsale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_on_sale&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_not_on_sale_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_not_sale_goods'}" href="javascript:;"><i class="fa fa-arrow-circle-o-down"></i> {lang key='goods::goods.not_on_sale'}</a></li>
						<li><a class="batch-best-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=best&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_best_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_best_goods'}" href="javascript:;"><i class="fa fa-star"></i> {lang key='goods::goods.best'} </a></li>
						<li><a class="batch-notbest-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_best&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_not_best_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_not_best_goods'}" href="javascript:;"><i class="fa fa-star-o"></i> {lang key='goods::goods.not_best'}</a></li>
						<li><a class="batch-new-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=new&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_new_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_new_goods'}" href="javascript:;"><i class="fa fa-flag"></i> {lang key='goods::goods.new'}</a></li>
						<li><a class="batch-notnew-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_new&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_not_new_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_not_news_goods'}" href="javascript:;"><i class="fa fa-flag-o"></i> {lang key='goods::goods.not_new'}</a></li>
						<li><a class="batch-hot-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=hot&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_hot_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_hot_goods'}" href="javascript:;"><i class="fa fa-thumbs-up"></i> {lang key='goods::goods.hot'}</a></li>
						<li><a class="batch-nothot-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_hot&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_not_hot_confirm'}" data-noSelectMsg="{lang key='goods::goods.select_not_hot_goods'}" href="javascript:;"><i class="fa fa-thumbs-o-up"></i> {lang key='goods::goods.not_hot'}</a></li>
						<li><a class="batch-move-btn" data-name="move_cat" data-move="data-operatetype" href="javascript:;"><i class="fa fa-mail-forward"></i> {lang key='goods::goods.move_to'}</a></li>
		           	</ul>
				</div>
				
				<form class="form-inline f_l m_l5" action="{RC_Uri::url('goods/merchant/init')}{$get_url}" method="post" name="filter_form">
					<div class="screen f_l">
						<div class="form-group">
							<select class="w130" name="review_status">
								<option value="-1">请选择...</option>
								<option value="1" {if $filter.review_status eq 1}selected{/if}>未审核</option>
								<option value="2" {if $filter.review_status eq 2}selected{/if}>审核未通过</option>
								<option value="3" {if $filter.review_status eq 3}selected{/if}>已审核</option>
								<option value="5" {if $filter.review_status eq 5}selected{/if}>无需审核</option>
							</select>
						</div>
						<button class="btn btn-primary filter-btn" type="button"><i class="fa fa-search"></i> {lang key='goods::goods.filter'} </button>
					</div>
				</form>
				
				<form class="form-inline f_r" action="{RC_Uri::url('goods/merchant/init')}{$get_url}" method="post" name="search_form">
					<div class="screen f_r">
						<div class="form-group">
							<select class="w130" name="cat_id">
								<option value="0">{lang key='goods::goods.goods_cat'}</option>
								<!-- {foreach from=$cat_list item=cat} -->
								<option value="{$cat.cat_id}" {if $cat.cat_id == $smarty.get.cat_id}selected{/if} {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
								<!-- {/foreach} -->
							</select>
						</div>
						<div class="form-group">
							<select class="w130" name="intro_type">
								<option value="0">{lang key='goods::goods.intro_type'}</option>
								<!-- {foreach from=$intro_list item=list key=key} -->
								<option value="{$key}" {if $key == $smarty.get.intro_type}selected{/if}>{$list}</option>
								<!-- {/foreach} -->
							</select>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='goods::goods.enter_goods_keywords'}">
						</div>
						<button class="btn btn-primary screen-btn" type="button"><i class="fa fa-search"></i> 搜索 </button>
					</div>
				</form>
			</div>
			
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
						<thead>
							<tr data-sorthref="{RC_Uri::url('goods/merchant/init')}{$get_url}">
								<th class="table_checkbox check-list w30">
									<div class="check-item">
										<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
										<label for="checkall"></label>
									</div>
								</th>
								<th class="w100 text-center">{lang key='goods::goods.thumb'}</th>
								<th data-toggle="sortby" data-sortby="goods_id">{lang key='goods::goods.goods_name'}</th>
								<th class="w110 sorting " data-toggle="sortby" data-sortby="goods_sn">{lang key='goods::goods.goods_sn'}</th>
								<th class="w100 sorting text-center" data-toggle="sortby" data-sortby="shop_price">{lang key='goods::goods.shop_price'}</th>
								<th class="w70 text-center"> {lang key='goods::goods.is_on_sale'} </th>
								<th class="w70 text-center"> {lang key='goods::goods.is_best'} </th>
								<th class="w70 text-center"> {lang key='goods::goods.is_new'} </th>
								<th class="w70 text-center"> {lang key='goods::goods.is_hot'} </th>
								<!-- {if $use_storage} -->
								<th class="w70 text-center" data-toggle="sortby" data-sortby="goods_number"> {lang key='goods::goods.goods_number'} </th>
								<!-- {/if} --> 
								<th class="w70 sorting text-center" data-toggle="sortby" data-sortby="store_sort_order">排序</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$goods_list.goods item=goods}-->
							<tr>
								<td class="check-list">
									<div class="check-item">
										<input id="check_{$goods.goods_id}" class="checkbox" type="checkbox" name="checkboxes[]" value="{$goods.goods_id}"/>
										<label for="check_{$goods.goods_id}"></label>
									</div>
								</td>						
								<td>
									<a href='{url path="goods/merchant/edit" args="goods_id={$goods.goods_id}"}'>
										<img class="w80 h80" alt="{$goods.goods_name}" src="{$goods.goods_thumb}">
									</a>
								</td>
								<td class="hide-edit-area {if $goods.is_promote}ecjiafc-red{/if}">
									<span class="cursor_pointer ecjiaf-pre ecjiaf-wsn" data-text="textarea" data-trigger="editable" data-url="{RC_Uri::url('goods/merchant/edit_goods_name')}" data-name="goods_edit_name" data-pk="{$goods.goods_id}" data-title="请输入商品名称">{$goods.goods_name|escape:html}</span>
									<br/>
									<div class="edit-list">
										<a class="data-pjax" href='{url path="goods/merchant/edit" args="goods_id={$goods.goods_id}"}'>{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
										<a class="data-pjax" href='{url path="goods/merchant/edit_goods_desc" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.tab_detail'}</a>&nbsp;|&nbsp;
										<a class="data-pjax" href='{url path="goods/merchant/edit_goods_attr" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.tab_properties'}</a>&nbsp;|&nbsp;
										<a class="data-pjax" href='{url path="goods/mh_gallery/init" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.tab_gallery'}</a>&nbsp;|&nbsp;
										<a class="data-pjax" href='{url path="goods/merchant/edit_link_goods" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.tab_linkgoods'}</a>&nbsp;|&nbsp;
<!-- 										<a class="data-pjax" href='{url path="goods/merchant/edit_link_parts" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.tab_groupgoods'}</a>&nbsp;|&nbsp; -->
										<a class="data-pjax" href='{url path="goods/merchant/edit_link_article" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.tab_article'}</a>&nbsp;|&nbsp;
										<a target="_blank" href='{url path="goods/merchant/preview" args="id={$goods.goods_id}"}'>{lang key='goods::goods.preview'}</a>&nbsp;|&nbsp;
										{if $specifications[$goods.goods_type] neq ''}<a target="_blank" href='{url path="goods/merchant/product_list" args="goods_id={$goods.goods_id}"}'>{lang key='goods::goods.product_list'}</a>&nbsp;|&nbsp;{/if}
										<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='goods::goods.trash_goods_confirm'}" href='{url path="goods/merchant/remove" args="id={$goods.goods_id}"}'>{lang key='system::system.drop'}</a>
									</div>
								</td>	
								
								<td>
									<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/merchant/edit_goods_sn')}" data-name="goods_edit_goods_sn" data-pk="{$goods.goods_id}" data-title="请输入商品货号">
										{$goods.goods_sn} 
									</span>
								</td>
								<td align="center">
									<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/merchant/edit_goods_price')}" data-name="goods_price" data-pk="{$goods.goods_id}" data-title="请输入商品价格"> 
										{$goods.shop_price}
									</span> 
								</td>
								<td align="center">
									<i class="cursor_pointer fa {if $goods.is_on_sale}fa-check {else}fa-times{/if}" data-trigger="toggle_on_sale" data-url="{RC_Uri::url('goods/merchant/toggle_on_sale')}" refresh-url="{RC_Uri::url('goods/merchant/init')}{$get_url}" data-id="{$goods.goods_id}"></i>
								</td>
								<td align="center">
									<i class="cursor_pointer fa {if $goods.store_best}fa-check {else}fa-times{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/merchant/toggle_best')}" data-id="{$goods.goods_id}"></i>
								</td>
								<td align="center">
									<i class="cursor_pointer fa {if $goods.store_new}fa-check {else}fa-times{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/merchant/toggle_new')}" data-id="{$goods.goods_id}"></i>
								</td>
								<td align="center">
									<i class="cursor_pointer fa {if $goods.store_hot}fa-check {else}fa-times{/if}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/merchant/toggle_hot')}" data-id="{$goods.goods_id}"></i>
								</td>
								<!-- {if $use_storage} -->
								<td align="center">
									<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/merchant/edit_goods_number')}" data-name="goods_number" data-pk="{$goods.goods_id}" data-title="请输入库存数量">
										{$goods.goods_number}
									</span>
								</td>
								<!-- {/if} -->
								<td align="center">
									<span class="cursor_pointer" data-trigger="editable" data-placement="left" data-url="{RC_Uri::url('goods/merchant/edit_sort_order')}" data-name="sort_order" data-pk="{$goods.goods_id}" data-title="请输入排序序号"> 
										{$goods.store_sort_order}
									</span>
								</td>
							</tr>
							<!-- {foreachelse}-->
							<tr>
								<td class="no-records" colspan="11">{lang key='system::system.no_records'}</td>
							</tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</section>
				<!-- {$goods_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->