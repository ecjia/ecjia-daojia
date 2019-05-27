<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.goods_category_list.init();
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
		<!-- {if $action_link} -->
		<a href="{$action_link.href}" class="btn btn-primary data-pjax"><i class="fa fa-plus"></i> {$action_link.text} </a>
		<!-- {/if} -->
		
		<!-- {if $action_link1} -->
		<a class="btn btn-primary data-pjax" href="{$action_link1.href}" id="sticky_a"><i class="fa fa-exchange"></i> {$action_link1.text} </a>
		<!-- {/if} -->	
		
		<!-- {if $back_link} -->
		<a class="btn btn-primary data-pjax" href="{$back_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$back_link.text} </a>
		<!-- {/if} -->	
	</div>	
	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
		   <div id="actionmodal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
	                    <div class="modal-header">
		                    <button data-dismiss="modal" class="close" type="button">×</button>
		                    <h4 class="modal-title">{t domain="goods"}内部链接{/t}</h4>
	                    </div>
	                    
	                    <div class="modal-body">
		                   <div class="success-msg"></div>
		                   <div class="error-msg"></div>
	                       <textarea class="form-control" id="link_value"  name="link_value" disabled="disabled"></textarea>
	                       <button id="copy_btn" class="btn btn-info m_t10">{t domain="goods"}复制{/t}</button>
	                    </div>
                    </div>
                 </div>
            </div>
           
			<div class="panel-body panel-body-small">
				<section class="panel">
					<table class="table table-striped table-advance table-hover" id="list-table">
						<thead>
							<tr>
								<th>{t domain="goods"}分类名称{/t}</th>
								<th class="w200">{t domain="goods"}商品数量{/t}</th>
								<th class="w200">{t domain="goods"}排序{/t}</th>
								<th class="w200">{t domain="goods"}是否显示{/t}</th>
								<th class="w200">{t domain="goods"}操作{/t}</th>
							</tr>
						</thead>
						<!-- {foreach from=$cat_list item=cat} -->
						<tr class="{$cat.level}" id="{$cat.level}_{$cat.cat_id}">
							{if $cat.parent_id eq $cat_id}
							<td class="first-cell" align="left">
								<!-- {if $cat.is_leaf neq 1} -->
								<i class="fa fa-minus-square-o cursor_pointer ecjiafc-blue" id="icon_{$cat.level}_{$cat.cat_id}" style="margin-left:{$cat.level}em" onclick="rowClicked(this)" /></i>
								<!-- {else} -->
								<i class="fa fa-arrow-circle-right cursor_pointer ecjiafc-blue" style="margin-left:{$cat.level}em" /></i>
								<!-- {/if} -->
								{if $cat.has_children > 0}
								<span><a href='{url path="goods/mh_category/init" args="cat_id={$cat.cat_id}"}'>{$cat.cat_name}</a></span>
								{else}
				                <span>{$cat.cat_name}</span>
				                {/if}
								<!-- {if $cat.cat_image} -->
								<img src="../{$cat.cat_image}" border="0" style="vertical-align:middle;" width="60px" height="21px">
								<!-- {/if} -->
							</td>
							
							<td>{$cat.goods_num}</td>
							<td>
								<span class="cursor_pointer" data-trigger="editable" data-placement="top" data-url="{url path='goods/mh_category/edit_sort_order'}" data-name="sort_order" data-pk="{$cat.cat_id}" data-title="{t domain="goods"}请输入排序序号{/t}">
									{$cat.sort_order}
								</span>
							</td>
							<td>
								<i class="cursor_pointer fa {if $cat.is_show eq '1'}fa-check {else}fa-times {/if}" data-trigger="toggleState" data-url="{url path='goods/mh_category/toggle_is_show'}" data-id="{$cat.cat_id}"></i>
							</td>
							<td>
								<a href="#actionmodal" data-toggle="modal" id="modal" copy-url="ecjiaopen://app?open_type=merchant&merchant_id={$store_id}&category_id={$cat.cat_id}"><button class="btn btn-primary btn-xs"><i class="fa fa-link"></i></button></a>
							    {if $cat.has_children > 0}
								<a class="data-pjax no-underline" title="{t domain='goods'}进入{/t}" href='{url path="goods/mh_category/init" args="cat_id={$cat.cat_id}"}'><button class="btn btn-primary btn-xs"><i class="fa fa-sign-in"></i></button></a>
								{/if}
								<a class="data-pjax no-underline" href='{url path="goods/mh_category/edit" args="cat_id={$cat.cat_id}"}' title="{t domain='goods'}编辑{/t}"><button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button></a>
								<a class="ajaxremove no-underline" data-toggle="ajaxremove" data-msg="{t domain='goods'}您确定要删除该分类吗？{/t}" href='{url path="goods/mh_category/remove" args="id={$cat.cat_id}"}'><button class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></button></a>
							</td>
							{/if}
						</tr>
						<!-- {foreachelse}-->
						<tr>
							<td class="no-records" colspan="4">{t domain="goods"}没有找到任何记录{/t}</td>
						</tr>	
						<!-- {/foreach} -->
					</table>
				</section>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->