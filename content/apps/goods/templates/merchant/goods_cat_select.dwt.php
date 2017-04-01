<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.goods_info.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

{if $step}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --><span class="f_s15 m_l5">{if $cat_html}{$cat_html}{/if}</span></h2>
	</div>
  	<div class="pull-right">
		<!-- {if $action_link} -->
			<a class="btn btn-primary data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fa fa-reply"></i> {$action_link.text}</a>
		<!-- {/if} -->
	</div>
  	<div class="clearfix"></div>
</div>

<div class="row-fluid edit-page">
   <div class="panel">
        <div class="panel-body">
			<div class="span12">
				<div class="tabbable">
					{if $action eq 'edit'}
					<ul class="nav nav-tabs">
						<!-- {foreach from=$tags item=tag} -->
						<li {if $tag.active} class="active"{/if}><a class="data-pjax" {if $tag.active} href="javascript:;"{else} data-toggle="alertgo" data-message="{lang key='goods::goods.discard_changes'}" href='{$tag.href}'{/if}><!-- {$tag.name} --></a></li>
						<!-- {/foreach} -->
					</ul>
					{/if}
					<form class="form-horizontal" action='{$form_url}' method="post" name="theForm">
						<div class="form-group">
							<div class="tab-content">
								<fieldset>
									<div class="control-group draggable goods-cat-container">
										<div class="ms-container goods_cat_container" id="ms-custom-navigation" data-url='{url path="goods/merchant/get_cat_list"}'>
											<div class="ms-selectable">
												<div class="search-header">
													<input class="form-control" id="ms-search_zero" type="text" placeholder="请输入商品分类关键字" autocomplete="off">
												</div>
												<ul class="ms-list nav-list-ready level_0">
													<!-- {foreach from=$cat_list item=item} -->
													<li class="ms-elem-selectable" data-id="{$item.cat_id}" data-level="{$item.level}"><span>{$item.cat_name}</span></li>
													<!-- {foreachelse} -->
													<li class="ms-elem-selectable disabled"><span>暂无内容</span></li>
													<!-- {/foreach} -->
												</ul>
											</div>
											<div class="ms-selectable">
												<div class="search-header">
													<input class="form-control" id="ms-search_one" type="text" placeholder="请输入商品分类关键字" autocomplete="off">
												</div>
												<ul class="ms-list nav-list-ready level_1">
													<li class="ms-elem-selectable disabled"><span>暂无内容</span></li>
												</ul>
											</div>
											<div class="ms-selectable">
												<div class="search-header">
													<input class="form-control" id="ms-search_two" type="text" placeholder="请输入商品分类关键字" autocomplete="off">
												</div>
												<ul class="ms-list nav-list-ready level_2">
													<li class="ms-elem-selectable disabled"><span>暂无内容</span></li>
												</ul>
											</div>
										</div>
									</div>
								</fieldset>
							</div>
						</div>
						<div class="form-group">
							<fieldset class="t_c">
								<input type="hidden" name="goods_id" value="{$goods_id}" />
								<input type="hidden" name="cat_id" />
								{if $step}
								<button class="btn btn-info next_step" disabled type="button" data-url='{url path="goods/merchant/add"}'>{lang key='goods::goods.next_step'}</button>
								<input type="hidden" name="step" value="{$step}" />
								{else}
								<button class="btn btn-info" type="submit">{lang key='goods::goods.save'}</button>
								{/if}
							</fieldset>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->