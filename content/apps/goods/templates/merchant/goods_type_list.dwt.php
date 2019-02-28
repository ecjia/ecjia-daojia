<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.goods_type.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

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
				<form class="form-inline pull-right" name="searchForm" method="post" action="{$form_search}{if $filter.type}&type={$filter.type}{/if}">
					<div class="form-group">
						<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain="goods"}请输入商品规格关键字{/t}"/>
						<button type="button" class="btn btn-primary search_btn"><i class="fa fa-search"></i> {t domain="goods"}搜索{/t} </button>
					</div>
				</form>
			</div>
			
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit">
						<thead>
							<tr>
								<th class="w150">{t domain="goods"}商品规格名称{/t}</th>
								<th class="w100">{t domain="goods"}属性分组{/t}</th>
								<th class="w130">{t domain="goods"}属性数{/t}</th>
								<th class="w80">{t domain="goods"}状态{/t}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$goods_type_list.item item=goods_type} -->
							<tr>
								<td class="hide-edit-area">
									<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/mh_spec/edit_type_name')}" data-name="edit_type_name" data-pk="{$goods_type.cat_id}" data-title="{t domain="goods"}请输入规格名称{/t}"><!-- {$goods_type.cat_name} --></span>
									<div class="edit-list">
										<a class="data-pjax" href='{url path="goods/mh_attribute/init" args="cat_id={$goods_type.cat_id}"}' title="{t domain="goods"}查看规格属性{/t}">{t domain="goods"}查看规格属性{/t}</a>&nbsp;|&nbsp;
										<a class="data-pjax" href='{url path="goods/mh_spec/edit" args="cat_id={$goods_type.cat_id}"}' title="{t domain="goods"}编辑{/t}">{t domain="goods"}编辑{/t}</a>&nbsp;|&nbsp;
										<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t domain="goods" escape=no}删除商品规格将会清除该规格下的所有属性。<br>您确定要删除选定的商品规格吗？{/t}" href='{url path="goods/mh_spec/remove" args="id={$goods_type.cat_id}"}' title="{t domain="goods"}删除{/t}">{t domain="goods"}删除{/t}</a>
									</div>
								</td>
								<td>{$goods_type.attr_group}</td>
								<td>{$goods_type.attr_count}</td>
								<td><i class="fa cursor_pointer {if $goods_type.enabled}fa-check {else}fa-times{/if}" title="{t domain="goods"}点击修改状态{/t}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/mh_spec/toggle_enabled')}" data-id="{$goods_type.cat_id}"></i></td>
							</tr>
							<!-- {foreachelse} -->
							<tr><td class="no-records" colspan="4">{t domain="goods"}没有找到任何记录{/t}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</section>
				<!-- {$goods_type_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->