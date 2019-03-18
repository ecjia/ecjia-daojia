<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.bulk_goods_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="modal fade" id="movetype">
	<div class="modal-dialog">
    	<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title">{t domain="cashier"}转移商品至分类{/t}</h4>
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
								<option value="0">{t domain="cashier"}暂无任何分类{/t}</option>
							<!-- {/if} -->
							</select>
						</div>
					</div>
					<div class="form-group t_c">
						<a class="btn btn-primary m_l5 disabled" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=move_to&" data-msg='{t domain="cashier"}是否将选中商品转移至分类？{/t}' data-noSelectMsg='{t domain="cashier"}请选择要转移的商品{/t}' href="javascript:;" name="move_cat_ture">{t domain="cashier"}开始转移{/t}</a>
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
						<a class="data-pjax" href="{RC_Uri::url('cashier/mh_bulk_goods/init')}
							{if $filter.keywords}&keywords={$filter.keywords}{/if}">{t domain="cashier"}全部{/t} 
							<span class="badge badge-info">{$filter.count.count_goods_num}</span>
						</a>
					</li>
					
					<li class="{if $smarty.get.type eq 1}active{/if}">
						<a class="data-pjax" href='{RC_Uri::url("cashier/mh_bulk_goods/init", "type=1
							{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>{t domain="cashier"}已上架{/t}
							<span class="badge badge-info use-plugins-num">{$filter.count.count_on_sale}</span>
						</a>
					</li>
					
					<li class="{if $smarty.get.type eq 2}active{/if}">	
						<a class="data-pjax" href='{RC_Uri::url("cashier/mh_bulk_goods/init", "type=2
							{if $filter.keywords}&keywords={$filter.keywords}{/if}")}'>{t domain="cashier"}未上架{/t}
							<span class="badge badge-info unuse-plugins-num">{$filter.count.count_not_sale}</span>
						</a>
					</li>
				</ul>	
				<div class="clearfix"></div>
			</div>
			
			<div class="panel-body panel-body-small">
				<div class="btn-group f_l">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> {t domain="cashier"}批量操作{/t} <span class="caret"></span></button>
					<ul class="dropdown-menu">
		                <li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=trash&page={$smarty.get.page}" data-msg='{t domain="cashier"}您确定要把选中的商品放入回收站吗？{/t}' data-noSelectMsg='{t domain="cashier"}请选择要移至回收站的商品{/t}' href="javascript:;"><i class="fa fa-archive"></i>{t domain="cashier"}移至回收站{/t}</a></li>
						<li><a class="batch-sale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=on_sale&page={$smarty.get.page}" data-msg='{t domain="cashier"}您确定要把选中的商品上架吗？{/t}' data-noSelectMsg='{t domain="cashier"}请选择要上架的商品{/t}' href="javascript:;"><i class="fa fa-arrow-circle-o-up"></i>{t domain="cashier"}上架{/t}</a></li>
						<li><a class="batch-notsale-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=not_on_sale&page={$smarty.get.page}" data-msg='{t domain="cashier"}您确定要把选中的商品下架吗？{/t}' data-noSelectMsg='{t domain="cashier"}请选择要下架的商品{/t}' href="javascript:;"><i class="fa fa-arrow-circle-o-down"></i>{t domain="cashier"}下架{/t}</a></li>
						<li><a class="batch-move-btn" data-name="move_cat" data-move="data-operatetype" href="javascript:;"><i class="fa fa-mail-forward"></i> {t domain="cashier"}转移到分类{/t}</a></li>
		           	</ul>
				</div>
				
				<form class="form-inline f_r" action="{RC_Uri::url('cashier/mh_bulk_goods/init')}" method="post" name="search_form">
					<div class="screen f_r">
						<div class="form-group">
							<input type="text" class="form-control" style="width:250px;" name="keywords" value="{$smarty.get.keywords}" placeholder='{t domain="cashier"}请输入商品名，商品货号等关键字{/t}'>
						</div>
						<button class="btn btn-primary screen-btn" type="submit"><i class="fa fa-search"></i> {t domain="cashier"}搜索{/t} </button>
					</div>
				</form>
			</div>
			
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit ecjiaf-tlf">
						<thead>
							<tr data-sorthref='{RC_Uri::url("cashier/mh_bulk_goods/init", "{if $smarty.get.type}&type={$smarty.get.type}{/if}")}'>
								<th class="table_checkbox check-list w30">
									<div class="check-item">
										<input id="checkall" type="checkbox" name="select_rows" data-toggle="selectall" data-children=".checkbox"/>
										<label for="checkall"></label>
									</div>
								</th>
								<th class="w250" data-toggle="sortby" data-sortby="goods_id">{t domain="cashier"}商品名称{/t}</th>
								<th class="w100 sorting" data-toggle="sortby" data-sortby="goods_sn">{t domain="cashier"}货号{/t}</th>
								<th class="sorting text-center" data-toggle="sortby" data-sortby="shop_price">{t domain="cashier"}价格{/t}</th>
								<th class="text-center">{t domain="cashier"}单位{/t}</th>
								<th class="text-center" data-toggle="sortby" data-sortby="goods_number"> {t domain="cashier"}库存{/t} </th>
								<th class="text-center"> {t domain="cashier"}上架{/t} </th>
								<th class="sorting text-center" data-toggle="sortby" data-sortby="store_sort_order">{t domain="cashier"}排序{/t}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$bulk_goods_list.goods item=goods}-->
							<tr>
								<td class="check-list">
									<div class="check-item">
										<input id="check_{$goods.goods_id}" class="checkbox" type="checkbox" name="checkboxes[]" value="{$goods.goods_id}"/>
										<label for="check_{$goods.goods_id}"></label>
									</div>
								</td>						
								<td class="hide-edit-area {if $goods.is_promote}ecjiafc-red{/if}">
									<span class="cursor_pointer ecjiaf-pre ecjiaf-wsn" data-text="textarea" data-trigger="editable" data-url="{RC_Uri::url('cashier/mh_bulk_goods/edit_goods_name')}" data-name="goods_edit_name" data-pk="{$goods.goods_id}" data-title='{t domain="cashier"}请输入商品名称{/t}'>{$goods.goods_name|escape:html}</span>
									<br/>
									<div class="edit-list">
										<a class="data-pjax" href='{url path="cashier/mh_bulk_goods/edit" args="goods_id={$goods.goods_id}"}'>{t domain="cashier"}编辑{/t}</a>&nbsp;|&nbsp;
										<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg='{t domain="cashier"}您确定要把该商品放入回收站吗？{/t}' href='{url path="cashier/mh_bulk_goods/remove" args="id={$goods.goods_id}"}'>{t domain="cashier"}删除{/t}</a>
									</div>
								</td>	
								<td>
									<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('cashier/mh_bulk_goods/edit_goods_sn')}" data-name="goods_edit_goods_sn" data-pk="{$goods.goods_id}" data-title='{t domain="cashier"}请输入商品货号{/t}'>
										{$goods.goods_sn} 
									</span>
								</td>
								<td align="center">
									<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('cashier/mh_bulk_goods/edit_goods_price')}" data-name="goods_price" data-pk="{$goods.goods_id}" data-title='{t domain="cashier"}请输入商品价格{/t}'> 
										{$goods.shop_price}
									</span> 
								</td>
								<td align="center">{if $goods.weight_unit eq '1'}{t domain="cashier"}克{/t}{else}{t domain="cashier"}千克{/t}{/if}</td>
								
								<td align="center">
									<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('cashier/mh_bulk_goods/edit_weight_stock')}" data-name="goods_number" data-pk="{$goods.goods_id}" data-title='{t domain="cashier"}请输入重量库存{/t}'>
										{if $goods.weight_stock}{$goods.weight_stock}{else}0.000{/if}
									</span>
								</td>
								<td align="center">
									<i class="cursor_pointer fa {if $goods.is_on_sale}fa-check {else}fa-times{/if}" data-trigger="toggle_on_sale" data-url="{RC_Uri::url('cashier/mh_bulk_goods/toggle_on_sale')}" 
									refresh-url="{RC_Uri::url('cashier/mh_bulk_goods/init')}{if $filter.type}&type={$filter.type}{/if}{if $filter.cat_id}&cat_id={$filter.cat_id}{/if}{if $filter.keywords}&keywords={$filter.keywords}{/if}{if $smarty.get.page}&page={$smarty.get.page}{/if}" 
									data-id="{$goods.goods_id}"></i>
								</td>
								<td align="center">
									<span class="cursor_pointer" data-trigger="editable" data-placement="left" data-url="{RC_Uri::url('cashier/mh_bulk_goods/edit_sort_order')}" data-name="sort_order" data-pk="{$goods.goods_id}" data-title='{t domain="cashier"}请输入排序序号{/t}'> 
										{$goods.store_sort_order}
									</span>
								</td>
							</tr>
							<!-- {foreachelse}-->
							<tr>
								<td class="no-records" colspan="8">{t domain="cashier"}没有找到任何记录{/t}</td>
							</tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</section>
				<!-- {$bulk_goods_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->