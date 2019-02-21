<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.link_article.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
{if $step eq '6'}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} --> 
		{if $action_link} 
	<a class="btn plus_or_reply data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a> {/if}
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
		<div class="tabbable">
			{if !$step}
			<ul class="nav nav-tabs">
				<!-- {foreach from=$tags item=tag} -->
				<li{if $tag.active} class="active"{/if}><a{if $tag.active} href="javascript:;"{else}{if $tag.pjax} class="data-pjax"{/if} href='{$tag.href}'{/if}><!-- {$tag.name} --></a></li>
				<!-- {/foreach} -->
			</ul>
			{/if}
			<form class="form-horizontal" action='{url path="goods/admin/add_link_article" args="goods_id={$smarty.get.goods_id}{if $code}&extension_code={$code}{/if}"}' method="post" name="theForm">
				<div class="tab-content">
					<fieldset>
						<div class="control-group choose_list span12" data-url="{url path='goods/admin/get_article_list'}">
							<div class="ecjiaf-cb">
								<input id="article_title" name="article_title" type="text" placeholder="{t domain="goods"}文章标题{/t}"/>
								<a class="btn" href="javascript:;" data-toggle="searchArticle"><!-- {t domain="goods"}搜索{/t} --></a>
							</div>
							<span class="help-inline m_t5">{t domain="goods"}搜索要关联的文章，搜到的文章会展示在左侧列表框中。点击左侧列表中选项，关联文章即可进入右侧已关联列表。保存后生效。{/t}</span>
						</div>
						<div class="control-group draggable">
							<div class="ms-container" id="ms-custom-navigation">
								<div class="ms-selectable">
									<div class="search-header">
										<input class="span12" id="ms-search" type="text" placeholder="{t domain="goods"}筛选搜索到的文章信息{/t}" autocomplete="off">
									</div>
									<ul class="ms-list nav-list-ready">
										<li class="ms-elem-selectable disabled"><span>{t domain="goods"}暂无内容{/t}</span></li>
									</ul>
								</div>
								<div class="ms-selection">
									<div class="custom-header custom-header-align">
										{t domain="goods"}关联文章{/t}
									</div>
									<ul class="ms-list nav-list-content">
										<!-- {foreach from=$goods_article_list item=link_article key=key} -->
										<li class="ms-elem-selection">
										<input type="hidden" value="{$link_article.article_id}" name="article_id[]"/>
										<!-- {$link_article.title} -->
										<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span>
										</li>
										<!-- {/foreach} -->
									</ul>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<fieldset class="t_c">
					<input type="hidden" name="goods_id" value="{$goods_id}">
					{if $step}
					<button class="btn btn-gebo" type="submit">{t domain="goods"}下一步{/t}</button>
					<button class="btn btn-gebo complete" type="submit" data-url='{if $code}{url path="goods/admin/init" args="extension_code={$code}"}{else}{url path="goods/admin/init"}{/if}'>{t domain="goods"}完成{/t}</button>
					<input type="hidden" name="step" value="{$step}"/>
					{else}
					<button class="btn btn-gebo" type="submit">{t domain="goods"}保存{/t}</button>
					{/if}
				</fieldset>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->