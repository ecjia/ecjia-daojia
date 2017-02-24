<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.link_goods.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
{if $step eq '5'}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}
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
			{if !$step}
			<ul class="nav nav-tabs">
				<!-- {foreach from=$tags item=tag} -->
				<li{if $tag.active} class="active"{/if}><a{if $tag.active} href="javascript:;"{else}{if $tag.pjax} class="data-pjax"{/if} href='{$tag.href}'{/if}><!-- {$tag.name} --></a></li>
				<!-- {/foreach} -->
			</ul>
			{/if}
			
			<form class="form-horizontal" action='{url path="goods/admin/add_link_goods" args="goods_id={$smarty.get.goods_id}{if $code}&extension_code={$code}{/if}"}' method="post" name="theForm">
				<div class="tab-content">
					<fieldset>
						<div class="control-group span12 search_link_goods" data-url="{url path='goods/admin/get_goods_list'}">
							<div class="ecjiaf-cb">
								<div class="f_l m_r5">
									<select name="cat_id">
										<option value="0">{lang key='system::system.all_category'}</option>
										<!-- {foreach from=$cat_list item=cat} -->
										<option value="{$cat.cat_id}" {if $cat.cat_id eq $smarty.get.cat_id}selected{/if} {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
										<!-- {/foreach} -->
									</select>
								</div>
								
								<div class="f_l m_r5">
									<select name="brand_id">
										<option value="0">{lang key='system::system.all_brand'}{html_options options=$brand_list}</option>
									</select>
								</div>
								
								<input type="text" name="keyword" placeholder="{lang key='goods::goods.goods_name'}" />
								<a class="btn" data-toggle="searchGoods"><!-- {lang key='system::system.button_search'} --></a>
							</div>
							<span class="help-inline m_t5">{lang key='goods::goods.link_goods_notice'}</span>
						</div>
						<div class="control-group draggable">
							<div class="ms-container" id="ms-custom-navigation">
								<div class="ms-selectable">
									<div class="search-header">
										<input class="span12" id="ms-search" type="text" placeholder="{lang key='goods::goods.filter_goods_info'}" autocomplete="off">
									</div>
									<ul class="ms-list nav-list-ready">
										<li class="ms-elem-selectable disabled"><span>{lang key='goods::goods.no_content'}</span></li>
									</ul>
								</div>
								<div class="ms-selection">
									<div class="custom-header custom-header-align">{lang key='goods::goods.tab_linkgoods'}</div>
									<ul class="ms-list nav-list-content">
										<!-- {foreach from=$link_goods_list item=link_good key=key} -->
										<li class="ms-elem-selection">
											<input type="hidden" value="{$link_good.goods_id}" name="goods_id[]" data-double="{if $link_good.is_double}1{else}0{/if}" />
											<span class="link_static m_r5">{if $link_good.is_double}[{lang key='goods::goods.double'}]{else}[{lang key='goods::goods.single'}]{/if}</span><!-- {$link_good.goods_name} -->
											<span class="edit-list"><a class="change_links_mod" href="javascript:;">{lang key='goods::goods.switch_relation'}</a><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span>
										</li>
										<!-- {/foreach} -->
									</ul>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<fieldset class="t_c">
					<input type="hidden" name="goods_id" value={$goods_id}>
					{if $step}
					<button class="btn btn-gebo" type="submit">{lang key='goods::goods.next_step'}</button>
					<button class="btn btn-gebo complete" type="submit" data-url='{if $code}{url path="goods/admin/init" args="extension_code={$code}"}{else}{url path="goods/admin/init"}{/if}'>{lang key='goods::goods.complete'}</button>
					<input type="hidden" name="step" value="{$step}" />
					{else}
					<button class="btn btn-gebo" type="submit">{lang key='goods::goods.save'}</button>
					{/if}
				</fieldset>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->