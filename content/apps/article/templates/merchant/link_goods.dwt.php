<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.link_goods.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
	</div>
	<div class="pull-right">
		<!-- {if $action_link} -->
		<a class="btn btn-primary plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
		<!-- {/if} -->
	</div>
	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body panel-body-small">
				<ul class="nav nav-tabs">
					<li><a class="data-pjax" href='{url path="article/merchant/edit" args="id={$smarty.get.id}"}'>{lang key='article::article.tab_general'}</a></li>
					<li class="active"><a href="javascript:;">{lang key='article::article.tab_goods'}</a></li>
				</ul>
			</div>
				
			<div class="panel-body panel-body-small">
				<div class="panel-heading">
					<form class="form" action='{url path="article/merchant/insert_link_goods" args="id={$smarty.get.id}"}' method="post" name="theForm">
						<fieldset>
							<div class="form-inline row goods_list" data-url="{url path='article/merchant/get_goods_list'}">
								<div class="pull-left">
									<div class="form-group">
										<select class="w130" name="cat_id">
											<option value="0">{lang key='system::system.all_category'}</option>
											<!-- {foreach from=$cat_list item=cat} -->
											<option value="{$cat.cat_id}" {if $cat.cat_id == $smarty.get.cat_id}selected{/if} {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
											<!-- {/foreach} -->
										</select>
									</div>
									
									<div class="form-group">
										<input class="form-control" type="text" name="keyword" placeholder="{lang key='goods::goods.goods_name'}" />
									</div>
									
									<button type="button" class="btn btn-primary" data-toggle="searchGoods"><i class="fa fa-search"></i> {lang key='system::system.button_search'} </button>
									
									<div class="form-group">
										<span class="help-block">{lang key='article::article.link_goods_tip'}</span>
									</div>
								</div>
							</div>
								
							<div class="row draggable">
								<div class="ms-container " id="ms-custom-navigation">
									<div class="ms-selectable">
										<div class="search-header">
											<input class="form-control" id="ms-search" type="text" placeholder="{lang key='article::article.screen_search_goods'}" autocomplete="off">
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
												<span class="edit-list"><i class="fa fa-times ecjiafc-red del"></i></span>
											</li>
											<!-- {/foreach} -->
										</ul>
									</div>
								</div>
							</div>
						</fieldset>
						
						<fieldset class="t_c row m_t20">
							<button class="btn btn-info" type="submit">{lang key='system::system.button_submit'}</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->