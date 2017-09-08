<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} --> 
<script type="text/javascript">
	ecjia.merchant.goods_arrt.init();
</script> 
<!-- {/block} --> 

<!-- {block name="home-content"} -->

<div class="page-header">
	<div class="pull-left">
		<h2>
			<!-- {if $ur_here}{$ur_here}{/if} -->
		</h2>	
	</div>	
	<div class="pull-right">
		<!-- {if $action_link2} -->
		<a class="btn btn-primary data-pjax" href="{$action_link2.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link2.text} </a>
		<!-- {/if} -->	
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn btn-primary data-pjax"><i class="fa fa-plus"></i> {$action_link.text} </a>
		<!-- {/if} -->
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
		                <li><a class="batch-trash-btn" data-toggle="ecjiabatch" data-idClass=".checkbox:checked" data-url='{RC_Uri::url("goods/mh_attribute/batch", "cat_id={$cat_id}")}' data-msg="{lang key='goods::attribute.drop_select_confirm'}" data-noSelectMsg="{lang key='goods::attribute.no_select_arrt'}" href="javascript:;"> <i class="glyphicon glyphicon-trash"></i> {lang key='goods::attribute.batchdrop'}</a></li>
		           	</ul>
				</div>
				
				<div class="choose_list f_r">
					<span class="l_h30">{lang key='goods::attribute.by_goods_type'}</span>
					<div class="pull-right">
						<select class="w130" name="goods_type" data-url="{url path='goods/mh_attribute/init' args='cat_id='}">
							<option value="0">所有商品规格</option>
							<!-- {$goods_type_list} -->
						</select>
					</div>
				</div>
			</div>
			
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-advance table-hover">
						<thead>
							<tr>
								<th class="table_checkbox check-list w50">
									<div class="check-item">
		                            	<input id="checkall" type="checkbox" data-toggle="selectall" data-children=".checkbox" autocomplete="off" />
		                            	<label for="checkall"></label>
		                            </div>
								</th>
								<th class="w130">{lang key='goods::attribute.attr_name'}</th>
								<th class="w130">{lang key='goods::attribute.cat_id'}</th>
								<th class="w150">{lang key='goods::attribute.attr_input_type'}</th>
								<th>{lang key='goods::attribute.attr_values'}</th>
								<th class="w100">{lang key='system::system.sort_order'}</th>
								<th class="w100">{lang key='system::system.handler'}</th>
							</tr>
						</thead>
						<tbody>
							<!-- {foreach from=$attr_list.item item=attr} -->
						<tr>
							<td class="check-list">
								<div class="check-item">
									<input class="checkbox" id="check_{$attr.attr_id}" value="{$attr.attr_id}" name="checkboxes[]" type="checkbox" autocomplete="off" />
									<label for="check_{$attr.attr_id}"></label>
								</div>
							</td>
							<td class="first-cell">
								<span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/mh_attribute/edit_attr_name')}" data-name="edit_attr_name" data-pk="{$attr.attr_id}" data-title="{lang key='goods::attribute.name_not_null'}"> 
									{$attr.attr_name}
								</span>
							</td>
							<td><span>{$attr.cat_name}</span></td>
							<td><span>{$attr.attr_input_type_desc}</span></td>
							<td><span>{$attr.attr_values}</span></td>
							<td><span class="cursor_pointer" data-trigger="editable" data-url="{RC_Uri::url('goods/mh_attribute/edit_sort_order')}" data-name="edit_sort_order" data-pjax-url='{url path="goods/mh_attribute/init" args="cat_id={$smarty.get.cat_id}"}' data-pk="{$attr.attr_id}" data-title="{lang key='goods::attribute.order_not_null'}">{$attr.sort_order}</span></td>
							<td>
								<a class="data-pjax no-underline" href='{RC_Uri::url("goods/mh_attribute/edit", "attr_id={$attr.attr_id}")}' title="{lang key='system::system.edit'}"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
								<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{lang key='goods::attribute.drop_confirm'}" href='{RC_Uri::url("goods/mh_attribute/remove", "id={$attr.attr_id}")}' title="{lang key='system::system.remove'}"><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></a>
							</td>
						</tr>
						<!-- {foreachelse} -->
						<tr><td class="no-records" colspan="7">{lang key='system::system.no_records'}</td></tr>
						<!-- {/foreach} -->
					</tbody>
				</table>
			</section>
			<!-- {$attr_list.page} -->
		</div>
	</div>
</div>
<!-- {/block} -->