<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.link_goods.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

{if $step}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
	</div>
	<div class="pull-right">
		<!-- {if $action_link} -->
		<a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
		<!-- {/if} -->
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
					<form class="form" action='{url path="goods/merchant/add_link_goods" args="goods_id={$smarty.get.goods_id}{if $code}&extension_code={$code}{/if}"}' method="post" name="theForm">
						<fieldset>
							<div class="form-inline row goods_list" data-url="{url path='goods/merchant/get_goods_list'}">
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
										<span class="help-block">{lang key='goods::goods.link_goods_notice'}</span>
									</div>
								</div>
							</div>
								
							<div class="row draggable">
								<div class="ms-container" id="ms-custom-navigation">
									<div class="ms-selectable">
										<div class="search-header">
											<input class="form-control" id="ms-search" type="text" placeholder="{lang key='goods::goods.filter_goods_info'}" autocomplete="off">
										</div>
										<ul class="ms-list nav-list-ready">
											<li class="ms-elem-selectable disabled">
												<span>{lang key='goods::goods.no_content'}</span>
											</li>
										</ul>
									</div>
									<div class="ms-selection">
										<div class="custom-header custom-header-align">{lang key='goods::goods.tab_linkgoods'}</div>
										<ul class="ms-list nav-list-content">
											<!-- {foreach from=$link_goods_list item=link_good key=key} -->
											<li class="ms-elem-selection">
												<input type="hidden" value="{$link_good.goods_id}" name="goods_id[]" data-double="{if $link_good.is_double}1{else}0{/if}" />
												<span class="link_static m_r5">{if $link_good.is_double}[{lang key='goods::goods.double'}]{else}[{lang key='goods::goods.single'}]{/if}</span><!-- {$link_good.goods_name} -->
												<span class="edit-list"><a class="change_links_mod" href="javascript:;">{lang key='goods::goods.switch_relation'}</a> <i class="fa fa-minus-circle del"></i></span>
											</li>
											<!-- {/foreach} -->
										</ul>
									</div>
								</div>
							</div>
						</fieldset>
						
						<fieldset class="t_c row m_t20">
							<input type="hidden" name="goods_id" value={$goods_id}>
							{if $step}
							<button class="btn btn-info" type="submit">{lang key='goods::goods.next_step'}</button>
							<button class="btn btn-info complete m_l5" type="submit" data-url='{if $code}{url path="goods/merchant/init" args="extension_code={$code}"}{else}{url path="goods/merchant/init"}{/if}'>{lang key='goods::goods.complete'}</button>
							<input type="hidden" name="step" value="{$step}" />
							{else}
							<button class="btn btn-info" type="submit">{lang key='goods::goods.save'}</button>
							{/if}
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->