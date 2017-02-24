<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.goods_trash.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<div class="btn-group">
					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cogs"></i> {lang key='goods::goods.batch_handle'} <span class="caret"></span></button>
					<ul class="dropdown-menu">
						<li><a data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=restore&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_restore_confirm'}"  data-noSelectMsg="{lang key='goods::goods.select_goods_msg'}" data-name="checkboxes" href="javascript:;"><i class="fa fa-share-square-o"></i> {lang key='system::system.restore'}</a></li>
						<li><a data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url="{$form_action}&type=drop&page={$smarty.get.page}" data-msg="{lang key='goods::goods.batch_drop_confirm'}"  data-noSelectMsg="{lang key='goods::goods.select_goods_msg'}" data-name="checkboxes" href="javascript:;"><i class="fa fa-trash-o"></i> {lang key='system::system.remove'}</a></li>
		           	</ul>
				</div>
				
				<form class="form-inline pull-right" action="{RC_Uri::url('goods/merchant/trash')}{if $filter.type}&type={$filter.type}{/if}" method="post" name="searchForm">
					<div class="form-group">
						<select class="w130" name="cat_id">
							<option value="0">{lang key='goods::goods.goods_cat'}</option>
							<!-- {foreach from=$cat_list item=cat} -->
							<option value="{$cat.cat_id}" {if $cat.cat_id == $smarty.get.cat_id}selected{/if} {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
							<!-- {/foreach} -->
						</select>
					</div>
					
					<div class="form-group">
						<input class="form-control" type="text" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='goods::goods.enter_goods_keywords'}"/>
					</div>
					<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> {lang key='system::system.button_search'} </button>
				</form>
			</div>

			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th class="table_checkbox check-list w50">
									<div class="check-item">
										<input id="checkall" type="checkbox" data-toggle="selectall" data-children=".checkbox"/>
										<label for="checkall"></label>
									</div>
								</th>
								<th class="w70">{lang key='system::system.record_id'}</th>
								<th>{lang key='goods::goods.goods_name'}</th>
								<th class="w100">{lang key='goods::goods.goods_sn'}</th>
								<th class="w100">{lang key='goods::goods.shop_price'}</th>
								<th class="w100">{lang key='system::system.handler'}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$goods_list.goods item=goods} -->
							<tr>
								<td class="check-list">
									<div class="check-item">
										<input id="check_{$goods.goods_id}" class="checkbox" value="{$goods.goods_id}" name="checkboxes[]" type="checkbox"/>
										<label for="check_{$goods.goods_id}"></label>
									</div>
								</td>
								<td>{$goods.goods_id}</td>
								<td>{$goods.goods_name|escape:html}</td>
								<td>{$goods.goods_sn}</td>
								<td>{$goods.shop_price}</td>
								<td>
									<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg='{lang key="goods::goods.restore_goods_confirm"}' href='{RC_Uri::url("goods/merchant/restore_goods", "id={$goods.goods_id}")}' title="{lang key='goods::goods.restore'}"><button class="btn btn-primary btn-xs"><i class="fa fa-reply"></i></button></a>
									<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg='{lang key="goods::goods.drop_goods_confirm"}' href='{RC_Uri::url("goods/merchant/drop_goods", "id={$goods.goods_id}")}' title="{lang key='system::system.drop'}"><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></a>
								</td>
							</tr>
							<!-- {foreachelse} -->
							<tr><td class="no-records" colspan="10">{lang key='system::system.no_records'}</td></tr>
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