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
						<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder="{lang key='goods::goods_spec.goods_type_keywords'}"/> 
						<button type="button" class="btn btn-primary search_btn"><i class="fa fa-search"></i> {lang key='goods::goods_spec.search'} </button>
					</div>
				</form>
			</div>
			
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit">
						<thead>
							<tr>
								<th class="w150">{lang key='goods::goods_spec.goods_type_name'}</th>
								<th class="w100">{lang key='goods::goods_spec.attr_groups'}</th>
								<th class="w130">{lang key='goods::goods_spec.attribute_number'}</th>
								<th class="w80">{lang key='goods::goods_spec.goods_type_status'}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$goods_type_list.item item=goods_type} -->
							<tr>
								<td class="hide-edit-area">
									<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/mh_spec/edit_type_name')}" data-name="edit_type_name" data-pk="{$goods_type.cat_id}" data-title="{lang key='goods::goods_spec.enter_type_name'}"><!-- {$goods_type.cat_name} --></span>
									<div class="edit-list">
										<a class="data-pjax" href='{url path="goods/mh_attribute/init" args="cat_id={$goods_type.cat_id}"}' title="{lang key='goods::goods_spec.view_type_attr'}">{lang key='goods::goods_spec.view_type_attr'}</a>&nbsp;|&nbsp;
										<a class="data-pjax" href='{url path="goods/mh_spec/edit" args="cat_id={$goods_type.cat_id}"}' title="{lang key='system::system.edit'}">{lang key='system::system.edit'}</a>&nbsp;|&nbsp;
										<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{lang key='goods::goods_spec.remove_confirm'}" href='{url path="goods/mh_spec/remove" args="id={$goods_type.cat_id}"}' title="{lang key='system::system.drop'}">{lang key='system::system.drop'}</a>
									</div>
								</td>
								<td>{$goods_type.attr_group}</td>
								<td>{$goods_type.attr_count}</td>
								<td><i class="fa cursor_pointer {if $goods_type.enabled}fa-check {else}fa-times{/if}" title="{lang key='goods::goods_spec.click_edit_stats'}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/mh_spec/toggle_enabled')}" data-id="{$goods_type.cat_id}"></i></td>
							</tr>
							<!-- {foreachelse} -->
							<tr><td class="no-records" colspan="4">{lang key='system::system.no_records'}</td></tr>
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