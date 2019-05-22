<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.goods_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<!-- #BeginLibraryItem "/library/goods_insert.lbi" --><!-- #EndLibraryItem -->

{if $step}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}

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
				<!-- <div class="btn-group f_l">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> {t domain="goodslib"}批量操作{/t} <span class="caret"></span></button>
					<ul class="dropdown-menu">
		                <li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=trash&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goodslib"}您确定要把选中的商品放入回收站吗？{/t}" data-noSelectMsg="{t domain="goodslib"}请选择要移至回收站的商品{/t}" href="javascript:;"><i class="fa fa-archive"></i> {lang key='goods::goods.move_to_trash'}</a></li>
						<li><a class="batch-sale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=on_sale&is_on_sale={$goods_list.filter.is_on_sale}&page={$smarty.get.page}" data-msg="{t domain="goodslib"}您确定要把选中的商品上架吗？{/t}" data-noSelectMsg="{t domain="goodslib"}请选择要上架的商品{/t}" href="javascript:;"><i class="fa fa-arrow-circle-o-up"></i> {t domain="goodslib"}上架{/t}</a></li>
		           	</ul>
				</div> -->
				
				<form class="form-inline f_l" action='{RC_Uri::url("goodslib/merchant/add", "cat_id={$smarty.get.cat_id}")}' method="post" name="search_form">
					<div class="screen f_l">
						<div class="form-group">
							<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain="goodslib"}请输入商品关键字{/t}">
						</div>
						<button class="btn btn-primary screen-btn" type="button"><i class="fa fa-search"></i> {t domain="goodslib"}搜索{/t}</button>
					</div>
				</form>
			</div>
			
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
						<thead>
							<tr data-sorthref='{RC_Uri::url("goodslib/merchant/add", "{if $smarty.get.cat_id}&cat_id={$smarty.get.cat_id}{/if}{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}")}'>
								<th class="table_checkbox check-list w30">
									<div class="check-item">
										<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
										<label for="checkall"></label>
									</div>
								</th>
								<th class="w100 text-center">{t domain="goodslib"}缩略图{/t}</th>
								<th class="w200" data-toggle="sortby" data-sortby="goods_id">{t domain="goodslib"}商品名称{/t}</th>
								<th class="w200 sorting" data-toggle="sortby" data-sortby="goods_sn">{t domain="goodslib"}货号{/t}</th>
								<th class="w130 sorting text-center" data-toggle="sortby" data-sortby="shop_price">{t domain="goodslib"}价格{/t}</th>
								<th class="w130 sorting text-center">{t domain="goodslib"}市场价{/t}</th>
								<!-- <th class="w70 sorting text-center" data-toggle="sortby" data-sortby="store_sort_order">排序</th> -->
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
									<a target="_blank" href='{url path="goodslib/merchant/preview" args="id={$goods.goods_id}&cat_id={$smarty.get.cat_id}"}'><img class="w80 h80" alt="{$goods.goods_name}" src="{$goods.goods_thumb}"></a>
								</td>
								<td class="hide-edit-area ">
									<span class="ecjiaf-pre ecjiaf-wsn" data-text="textarea">{$goods.goods_name|escape:html}</span>
									<br/>
									<div class="edit-list">
										<a class="insert-goods-btn" href="javascript:;" data-href='{url path="goodslib/merchant/insert" args="goods_id={$goods.goods_id}"}' 
										data-id="{$goods.goods_id}" data-name="{$goods.goods_name}" data-sn="{$goods.goods_sn}" data-shopprice="{$goods.shop_price}" data-marketprice="{$goods.market_price}" data-costprice="{$goods.cost_price}">导入商品</a>&nbsp;|&nbsp;
										<a target="_blank" href='{url path="goodslib/merchant/preview" args="id={$goods.goods_id}&cat_id={$smarty.get.cat_id}"}'>预览商品</a>
									</div>
								</td>	
								
								<td>{$goods.goods_sn}</td>
								<td align="center">{$goods.shop_price}</td>
								<td align="center">{$goods.market_price}</td>
								<!-- <td align="center">{$goods.store_sort_order}</td> -->
							</tr>
							<!-- {foreachelse}-->
							<tr>
								<td class="no-records" colspan="11">{t domain="goodslib"}没有找到任何记录{/t}</td>
							</tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</section>
				<!-- {$goods_list.page} -->
			</div>
			<div class="panel">
    			<div class="form-group">
    				<fieldset class="t_c">
    					<input type="hidden" name="goods_id" value="{$goods_id}" />
    					<input type="hidden" name="cat_id" />
    					<a class="btn btn-info" href='{url path="goodslib/merchant/init"}'>上一步</a>
    					<button class="btn btn-info m_l20 batchInsert" type="button" data-url='{url path="goodslib/merchant/add"}'>{t domain="goodslib"}开始导入{/t}</button>
    				</fieldset>
    			</div>
    		</div>
		</div>
	</div>
</div>
<!-- {/block} -->