<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="home-content"} -->

<div class="page-header">
	<div class="pull-left">
		<h2>
			<!-- {if $ur_here}{$ur_here}{/if} -->
		</h2>	
	</div>	
	<div class="pull-right">
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn btn-primary data-pjax"><i class="fa fa-plus"></i> {$action_link.text} </a>
		<!-- {/if} -->
		
		<!-- {if $action_link1} -->
		<a class="btn btn-primary data-pjax" href="{$action_link1.href}" id="sticky_a"><i class="fa fa-exchange"></i> {$action_link1.text} </a>
		<!-- {/if} -->	
	</div>	
	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-advance table-hover" id="list-table">
						<thead>
							<tr>
								<th>{lang key='goods::category.cat_name'}</th>
								<th class="w200">{lang key='goods::category.sort_order'}</th>
								<th class="w200">{lang key='goods::category.is_show'}</th>
								<th class="w100">{lang key='system::system.handler'}</th>
							</tr>
						</thead>
						<!-- {foreach from=$cat_info item=cat} -->
						<tr class="{$cat.level}" id="{$cat.level}_{$cat.cat_id}">
							<td class="first-cell" align="left">
								<!-- {if $cat.is_leaf neq 1} -->
								<i class="fa fa-minus-square-o cursor_pointer ecjiafc-blue" id="icon_{$cat.level}_{$cat.cat_id}" style="margin-left:{$cat.level}em" onclick="rowClicked(this)" /></i>
								<!-- {else} -->
								<i class="fa fa-arrow-circle-right cursor_pointer ecjiafc-blue" style="margin-left:{$cat.level}em" /></i>
								<!-- {/if} -->
								<span><a href='{url path="goods/merchant/init" args="cat_id={$cat.cat_id}"}'>{$cat.cat_name}</a></span>
								<!-- {if $cat.cat_image} -->
								<img src="../{$cat.cat_image}" border="0" style="vertical-align:middle;" width="60px" height="21px">
								<!-- {/if} -->
							</td>
							<td>
								<span class="cursor_pointer" data-trigger="editable" data-placement="top" data-url="{url path='goods/mh_category/edit_sort_order'}" data-name="sort_order" data-pk="{$cat.cat_id}" data-title="{lang key='goods::category.enter_order'}"> 
									{$cat.sort_order}
								</span>
							</td>
							<td>
								<i class="cursor_pointer fa {if $cat.is_show eq '1'}fa-check {else}fa-times {/if}" data-trigger="toggleState" data-url="{url path='goods/mh_category/toggle_is_show'}" data-id="{$cat.cat_id}"></i>
							</td>
							<td>
								<a class="data-pjax no-underline" href='{url path="goods/mh_category/edit" args="cat_id={$cat.cat_id}"}' title="{lang key='system::system.edit'}"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
								<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='goods::category.drop_cat_confirm'}" href='{url path="goods/mh_category/remove" args="id={$cat.cat_id}"}'><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></a>
							</td>
						</tr>
						<!-- {foreachelse}-->
						<tr>
							<td class="no-records" colspan="4">{lang key='system::system.no_records'}</td>
						</tr>	
						<!-- {/foreach} -->
					</table>
				</section>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->