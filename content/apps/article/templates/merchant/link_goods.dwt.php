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
					<li><a class="data-pjax" href='{url path="article/merchant/edit" args="id={$smarty.get.id}"}'>{t domain="article"}通用信息{/t}</a></li>
					<li class="active"><a href="javascript:;">{t domain="article"}关联商品{/t}</a></li>
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
											<option value="0">{t domain="article"}所有分类{/t}</option>
											<!-- {foreach from=$cat_list item=cat} -->
											<option value="{$cat.cat_id}" {if $cat.cat_id == $smarty.get.cat_id}selected{/if} {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
											<!-- {/foreach} -->
										</select>
									</div>
									
									<div class="form-group">
										<input class="form-control" type="text" name="keyword" placeholder='{t domain="article"}商品名称{/t}' />
									</div>
									
									<button type="button" class="btn btn-primary" data-toggle="searchGoods"><i class="fa fa-search"></i> {t domain="article"}搜索{/t}</button>
									
									<div class="form-group">
										<span class="help-block">{t domain="article"}搜索要关联的商品，搜到商品会展示在左侧列表框中。点击左侧列表中选项，关联商品即可进入右侧已关联列表。保存后生效。您还可以在右侧编辑关联模式。{/t}</span>
									</div>
								</div>
							</div>
								
							<div class="row draggable">
								<div class="ms-container " id="ms-custom-navigation">
									<div class="ms-selectable">
										<div class="search-header">
											<input class="form-control" id="ms-search" type="text" placeholder='{t domain="article"}筛选搜索到的商品信息{/t}' autocomplete="off">
										</div>
										<ul class="ms-list nav-list-ready">
											<li class="ms-elem-selectable disabled"><span>{t domain="article"}暂无内容{/t}</span></li>
										</ul>
									</div>
									<div class="ms-selection">
										<div class="custom-header custom-header-align">{t domain="article"}关联商品{/t}</div>
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
							<button class="btn btn-info" type="submit">{t domain="article"}确定{/t}</button>
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->