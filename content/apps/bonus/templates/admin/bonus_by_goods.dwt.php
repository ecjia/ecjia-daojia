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
		<a  class="btn data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="tabbable">
			<form class="form-horizontal" action="{$form_action}" method="post" name="theForm">
				<div class="tab-content">
					<fieldset>
						<div class="control-group choose_list span12" data-url="{url path='bonus/admin/get_goods_list'}">
							<!-- <div class="f_l"> -->
								<select name="cat_id">
									<option value="0">{t domain="bonus"}所有分类{/t}{$cat_list}</option>
								</select>
								<select name="brand_id">
									<option value="0">{t domain="bonus"}所有品牌{/t}{html_options options=$brand_list}</option>
								</select>
							<!-- </div> -->
							<input type="text" name="keyword" />
							<input type="hidden" name="type_id" value="{$id}">
							<a class="btn" data-toggle="searchGoods"><!-- {t domain="bonus"}搜索{/t} --></a>
							<span class="help-block m_t5">{t domain="bonus"}搜索要发放此类型红包的商品展示在左侧区域中，点击左侧列表中选项，商品即可进入右侧发放红包区域。您还可以在右侧编辑将发放红包的商品。{/t}</span>
						</div>
						<div class="control-group draggable">
							<div class="ms-container " id="ms-custom-navigation">
								<div class="ms-selectable">
									<div class="search-header">
										<input class="span12" id="ms-search" type="text" placeholder='{t domain="bonus"}筛选搜索到的商品信息{/t}' autocomplete="off">
									</div>
									<ul class="ms-list nav-list-ready">
										<li class="ms-elem-selectable disabled"><span>{t domain="bonus"}暂无内容{/t}</span></li>
									</ul>
								</div>
								<div class="ms-selection">
									<div class="custom-header custom-header-align">{t domain="bonus"}发放此类型红包的商品{/t}</div>
									<ul class="ms-list nav-list-content">
										<!-- {foreach from=$goods_list item=goods} -->
										<li class="ms-elem-selection">
											<input type="hidden" value="{$goods.goods_id}" name="article_id[]" />
											<!-- {$goods.goods_name} -->
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
					<button class="btn btn-gebo" type="submit">{t domain="bonus"}确定发放红包{/t}</button>
					<input type="hidden" id="bonus_type_id" value="{$bonus_type_id}" />
				</p>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->