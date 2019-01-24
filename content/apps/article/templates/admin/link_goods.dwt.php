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
				<li><a class="data-pjax" href='{url path="article/admin/edit" args="id={$smarty.get.id}{if $publishby}&publishby={$publishby}{/if}"}#tab1'>{t domain="article"}通用信息{/t}</a></li>
<!-- 				<li><a class="data-pjax" href='{url path="article/admin/edit" args="id={$smarty.get.id}"}#tab2'>{t domain="article"}文章内容{/t}</a></li> -->
				<li class="active"><a href="javascript:;">{t domain="article"}关联商品{/t}</a></li>
			</ul>
			
			<form class="form-horizontal" action='{url path="article/admin/insert_link_goods" args="id={$smarty.get.id}{if $publishby}&publishby={$publishby}{/if}"}' method="post" name="theForm">
				<div class="tab-content">
					<fieldset>
						<div class="control-group choose_list span12" data-url="{url path='article/admin/get_goods_list'}">
							<!-- <div class="f_l"> -->
								<select name="cat_id">
									<option value="0">{t domain="article"}所有分类{/t}{$cat_list}</option>
								</select>
								<select name="brand_id">
									<option value="0">{t domain="article"}所有品牌{/t}{html_options options=$brand_list}</option>
								</select>
							<!-- </div> -->
							<input type="text" name="keyword" />
							<a class="btn" data-toggle="searchGoods"><!-- {t domain="article"}搜索{/t} --></a>
							<span class="help-inline m_t5">{t domain="article"}搜索要关联的商品，搜到商品会展示在左侧列表框中。点击左侧列表中选项，关联商品即可进入右侧已关联列表。保存后生效。您还可以在右侧编辑关联模式。{/t}</span>
						</div>
						<div class="control-group draggable">
							<div class="ms-container " id="ms-custom-navigation">
								<div class="ms-selectable">
									<div class="search-header">
										<input class="span12" id="ms-search" type="text" placeholder="{t domain="article"}筛选搜索到的商品信息{/t}" autocomplete="off">
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
					<button class="btn btn-gebo" type="submit">{t domain="article"}确定{/t}</button>
				</p>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->