<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.link_goods.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="tabbable">
			<ul class="nav nav-tabs">
				<li><a class="data-pjax" href='{url path="article/admin/edit" args="id={$smarty.get.id}{if $publishby}&publishby={$publishby}{/if}"}#tab1'>{lang key='article::article.tab_general'}</a></li>
<!-- 				<li><a class="data-pjax" href='{url path="article/admin/edit" args="id={$smarty.get.id}"}#tab2'>{lang key='article::article.tab_content'}</a></li> -->
				<li class="active"><a href="javascript:;">{lang key='article::article.tab_goods'}</a></li>
			</ul>
			
			<form class="form-horizontal" action='{url path="article/admin/insert_link_goods" args="id={$smarty.get.id}{if $publishby}&publishby={$publishby}{/if}"}' method="post" name="theForm">
				<div class="tab-content">
					<fieldset>
						<div class="control-group choose_list span12" data-url="{url path='article/admin/get_goods_list'}">
							<!-- <div class="f_l"> -->
								<select name="cat_id">
									<option value="0">{lang key='system::system.all_category'}{$cat_list}</option>
								</select>
								<select name="brand_id">
									<option value="0">{lang key='system::system.all_brand'}{html_options options=$brand_list}</option>
								</select>
							<!-- </div> -->
							<input type="text" name="keyword" />
							<a class="btn" data-toggle="searchGoods"><!-- {lang key='system::system.button_search'} --></a>
							<span class="help-inline m_t5">{lang key='article::article.link_goods_tip'}</span>
						</div>
						<div class="control-group draggable">
							<div class="ms-container " id="ms-custom-navigation">
								<div class="ms-selectable">
									<div class="search-header">
										<input class="span12" id="ms-search" type="text" placeholder="{lang key='article::article.screen_search_goods'}" autocomplete="off">
									</div>
									<ul class="ms-list nav-list-ready">
										<li class="ms-elem-selectable disabled"><span>{lang key='article::article.no_content'}</span></li>
									</ul>
								</div>
								<div class="ms-selection">
									<div class="custom-header custom-header-align">{lang key='article::article.tab_goods'}</div>
									<ul class="ms-list nav-list-content">
										<!-- {foreach from=$link_goods_list item=link_goods key=key} -->
										<li class="ms-elem-selection">
											<input type="hidden" value="{$link_goods.goods_id}" name="article_id[]" />
											<!-- {$link_goods.goods_name} -->
											<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span>
										</li>
										<!-- {/foreach} -->
									</ul>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<p class="ecjiaf-tac">
					<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
				</p>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->