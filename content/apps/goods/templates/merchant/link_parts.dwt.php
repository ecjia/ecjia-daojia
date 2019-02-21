<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} --> 
<script type="text/javascript">
	ecjia.merchant.link_parts.init();
</script> 
<!-- {/block} --> 

<!-- {block name="home-content"} -->

{if $step}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}

<div class="page-header">
	<h2 class="pull-left"> 
		<!-- {if $ur_here}{$ur_here}{/if} --> 
	</h2>
	<div class="pull-right">
		{if $action_link} 
			<a href="{$action_link.href}" class="btn btn-primary data-pjax" id="sticky_a">
			<i class="fa fa-reply"></i> {$action_link.text}</a> 
		{/if}
	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			{if !$step}
           	<div class="panel-body panel-body-small">
				<ul class="nav nav-tabs">
					<!-- {foreach from=$tags item=tag} -->
					<li {if $tag.active} class="active"{/if}><a {if $tag.active} href="javascript:;"{else}{if $tag.pjax} class="data-pjax"{/if} href='{$tag.href}'{/if}><!-- {$tag.name} --></a></li>
					<!-- {/foreach} -->
				</ul>
			</div>
			{/if}
			
			<div class="panel-body panel-body-small">
				<div class="panel-heading">
					<form class="form" action='{url path="goods/merchant/add_link_parts" args="goods_id={$smarty.get.goods_id}{if $code}&extension_code={$code}{/if}"}' method="post" name="theForm" >
						<fieldset>
							<div class="form-inline row goods_list" data-url="{url path='goods/merchant/get_goods_list'}">
								<div class="pull-left">
									<div class="form-group">
										<select class="form-control" name="cat_id">
											<option value="0">{t domain="goods"}所有分类{/t}{$cat_list}</option>
										</select>
									</div>
									
									<div class="form-group">
										<input class="form-control" type="text" name="keyword" placeholder="{t domain="goods"}商品名称{/t}" />
										<button type="button" class="btn btn-primary" data-toggle="searchGoods"><i class="fa fa-search"></i> <!-- {t domain="goods"}搜索{/t} --></button>
									</div>
								</div>
								<div class="form-group">
									<span class="help-block">{t domain="goods"}搜索要关联的配件，搜到配件会展示在左侧列表框中。点击左侧列表中选项，配件即可进入右侧已关联列表。保存后生效。您还可以在右侧编辑关联配件的价格。{/t}</span>
								</div>
							</div>
								<div class="row draggable">
									<div class="ms-container" id="ms-custom-navigation">
										<div class="ms-selectable">
											<div class="search-header">
												<input class="form-control" id="ms-search" type="text" placeholder="{t domain="goods"}筛选搜索到的商品信息{/t}" autocomplete="off">
											</div>
											<ul class="ms-list nav-list-ready">
												<li class="ms-elem-selectable disabled"><span>{t domain="goods"}暂无内容{/t}</span></li>
											</ul>
										</div>
										<div class="ms-selection">
											<div class="custom-header custom-header-align">{t domain="goods"}关联配件{/t}</div>
											<ul class="ms-list nav-list-content">
												<!-- {foreach from=$group_goods_list item=link_good key=key} -->
												<li class="ms-elem-selection">
													<input type="hidden" name="goods_id[]" data-double="0" data-price="{$link_good.goods_price}" value="{$link_good.goods_id}" />
													<!-- {$link_good.goods_name} --><span class="link_price m_l5">[{t domain="goods"}价格{/t}:{$link_good.goods_price}]</span>
													<span class="edit-list"><a class="change_link_price" href="javascript:;">{t domain="goods"}修改价格{/t}</a> <i class="fa fa-minus-circle del"></i></span>
												</li>
												<!-- {/foreach} -->
											</ul>
										</div>
									</div>
								</div>
						</fieldset>
						<fieldset class="t_c m_t20">
							{if $step}
							<button class="btn btn-info" type="submit">{t domain="goods"}下一步{/t}</button>
							<button class="btn btn-info complete m_l5" type="submit" data-url='{if $code}{url path="goods/merchant/init" args="extension_code={$code}"}{else}{url path="goods/merchant/init"}{/if}'>{t domain="goods"}完成{/t}</button>
							<input type="hidden" name="step" value="{$step}" />
							{else}
							<button class="btn btn-info" type="submit">{t domain="goods"}保存{/t}</button>
							{/if}
							<input type="hidden" name="goods_id" value="{$goods_id}" />
							{if $code neq ''}
							<input type="hidden" name="extension_code" value="{$code}" />
							{/if}
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->