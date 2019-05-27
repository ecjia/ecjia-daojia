<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.goods_type.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">
		<i class="fa fa-times" data-original-title="" title=""></i>
	</button>
	{t domain="orders"}商品规格：指商品的销售属性，供买家在下单时点选，如“规格”、“颜色分类”、“尺码”等设置，它将影响买家的购买和店铺商品的库存管理。{/t}
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
					<li class="{if !$smarty.get.store_type}active{/if}"><a class="data-pjax" href='{url path="goods/mh_spec/init" args="{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}"}'>{t domain="goods"}店铺规格{/t} <span class="badge badge-info">{if $type_count.merchant}{$type_count.merchant}{else}0{/if}</span> </a></li>
					<li class="{if $smarty.get.store_type eq 1}active{/if}"><a class="data-pjax" href='{url path="goods/mh_spec/init" args="store_type=1{if $smarty.get.keywords}&keywords={$smarty.get.keywords}{/if}"}'>{t domain="goods"}平台规格{/t} <span class="badge badge-info">{if $type_count.platform}{$type_count.platform}{else}0{/if}</span> </a></li>
				</ul>
				
				<form class="form-inline pull-right" name="searchForm" method="post" action="{$form_search}{if $filter.store_type}&type={$filter.store_type}{/if}">
					<div class="screen f_r">
						<div class="form-group">
							<input type="text" class="form-control" name="keywords" value="{$smarty.get.keywords}" placeholder="{t domain='goods'}请输入规格模板名称{/t}"/>
							<button type="button" class="btn btn-primary search_btn"><i class="fa fa-search"></i> {t domain="goods"}搜索{/t} </button>
						</div>
					</div>	
				</form>
			</div>
			
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-hover table-hide-edit">
						<thead>
							<tr>
								<th class="w150">{t domain="goods"}模板名称{/t}</th>
								<th class="w130">{t domain="goods"}属性统计{/t}</th>
								
								{if !$smarty.get.store_type}
								<th class="w80">{t domain="goods"}状态{/t}</th>
								{/if}
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$spec_template_list.item item=list} -->
							<tr>
								<td class="hide-edit-area">
									{if !$smarty.get.store_type}
										<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/mh_spec/edit_type_name')}" data-name="edit_type_name" data-pk="{$list.cat_id}" data-title="{t domain='goods'}请输入规格模板名称{/t}">{$list.cat_name}</span>
									{else}
										{$list.cat_name}
									{/if}
								
									<div class="edit-list">
										<a class="data-pjax" href='{url path="goods/mh_spec_attribute/init" args="cat_id={$list.cat_id}"}'>{t domain="goods"}查看规格属性{/t}</a>
										{if !$smarty.get.store_type}
										&nbsp;|&nbsp;<a class="data-pjax" href='{url path="goods/mh_spec/edit" args="cat_id={$list.cat_id}"}'>{t domain="goods"}编辑{/t}</a>&nbsp;|&nbsp;
										<a class="ajaxremove ecjiafc-red" data-toggle="ajaxremove" data-msg="{t domain='goods' escape=no}删除后将会清除该模板下所有属性，您确定要删除？{/t}" href='{url path="goods/mh_spec/remove" args="id={$list.cat_id}"}' title="{t domain="goods"}删除{/t}">{t domain="goods"}删除{/t}</a>
										{/if}
									</div>
								</td>
								<td>{$list.attr_count}</td>
								{if !$smarty.get.store_type}
								<td><i class="fa cursor_pointer {if $list.enabled}fa-check {else}fa-times{/if}" title="{t domain='goods'}点击修改状态{/t}" data-trigger="toggleState" data-url="{RC_Uri::url('goods/mh_spec/toggle_enabled')}" data-id="{$list.cat_id}"></i></td>
								{/if}
							</tr>
							<!-- {foreachelse} -->
							<tr><td class="no-records" colspan="3">{t domain="goods"}没有找到任何记录{/t}</td></tr>
							<!-- {/foreach} -->
						</tbody>
					</table>
				</section>
				<!-- {$spec_template_list.page} -->
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->