<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} --> 
<script type="text/javascript">
	ecjia.merchant.link_article.init();
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
			<a class="btn btn-primary data-pjax" id="sticky_a" href="{$action_link.href}"> <i class="fa fa-reply"></i> {$action_link.text} </a> 
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
					<form class="form" action='{url path="goods/merchant/add_link_article" args="goods_id={$smarty.get.goods_id}{if $code}&extension_code={$code}{/if}"}' method="post" name="theForm" >
						<fieldset>
							<div class="form-inline row article_list" data-url="{url path='goods/merchant/get_article_list'}" >
								<div class="pull-left">
									<div class="form-group">
										<input class="form-control" id="article_title" name="article_title" type="text" placeholder="{t domain="goods"}文章标题{/t}" />
										<button type="button" class="btn btn-primary" data-toggle="searchArticle"><i class="fa fa-search"></i> <!-- {t domain="goods"}搜索{/t} --></button>
									</div>
									<span class="help-block">{t domain="goods"}搜索要关联的文章，搜到的文章会展示在左侧列表框中。点击左侧列表中选项，关联文章即可进入右侧已关联列表。保存后生效。{/t}</span>
								</div>
							</div>
							<div class="row draggable">
								<div class="ms-container" id="ms-custom-navigation">
									<div class="ms-selectable">
										<div class="search-header">
											<input class="form-control" id="ms-search" type="text" placeholder="{t domain="goods"}筛选搜索到的文章信息{/t}" autocomplete="off">
										</div>
										<ul class="ms-list nav-list-ready">
											<li class="ms-elem-selectable disabled"><span>{t domain="goods"}暂无内容{/t}</span></li>
										</ul>
									</div>
									<div class="ms-selection">
										<div class="custom-header custom-header-align">{t domain="goods"}关联文章{/t}</div>
										<ul class="ms-list nav-list-content">
											<!-- {foreach from=$goods_article_list item=link_article key=key} -->
											<li class="ms-elem-selection">
												<input type="hidden" value="{$link_article.article_id}" name="article_id[]" />
												<!-- {$link_article.title} -->
												<span class="edit-list"><i class="fa fa-minus-circle del"></i></span>
											</li>
											<!-- {/foreach} -->
										</ul>
									</div>
								</div>
							</div>
						</fieldset>
						<fieldset class="t_c m_t20">
							<input type="hidden" name="goods_id" value={$goods_id}>
							{if $step}
							<button class="btn btn-info" type="submit">{t domain="goods"}下一步{/t}</button>
							<button class="btn btn-info complete m_l5" type="submit" data-url='{if $code}{url path="goods/merchant/init" args="extension_code={$code}"}{else}{url path="goods/merchant/init"}{/if}'>{t domain="goods"}完成{/t}</button>
							<input type="hidden" name="step" value="{$step}" />
							{else}
							<button class="btn btn-info" type="submit">{t domain="goods"}保存{/t}</button>
							{/if}
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->