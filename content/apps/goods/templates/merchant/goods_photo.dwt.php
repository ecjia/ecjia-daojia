<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.goods_photo.init();
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
		<!-- {if $action_link} --><a class="btn btn-primary data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fa fa-reply"></i> <!-- {$action_link.text} --></a><!-- {/if} -->
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
			<div class="panel-body fileupload" data-action="{$form_action}" data-remove="{url path='goods/mh_gallery/drop_image'}"></div>
			
			{if $step && !$img_list}
				<div class="t_c m_t10 m_b10">
					<button class="btn btn-info complete m_l5" data-url='{if $code}{url path="goods/merchant/init" args="extension_code={$code}"}{else}{url path="goods/merchant/init"}{/if}'>{lang key='goods::goods.complete'}</button>
					<input type="hidden" name="step" value="{$step}" />
				</div>
			{/if}
		</div>
	</div>
</div>

{if $img_list}
<div class="page-header">
	<div class="pull-left">
		<h2>{lang key='goods::goods.tab_gallery'}<small>{lang key='goods::goods.goods_photo_notice'}</small></h2>
	</div>
	<div class="clearfix"></div>
</div>
{/if}

<div class="row {if !$img_list} hide{/if}">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body">
				<div class="{if !$img_list} hide{/if}">
					<div class="goods-photo-list">
						<div class="m_b20"><span class="help-inline">{lang key='goods::goods.goods_photo_help'}</span></div>
						<div class="wmk_grid ecj-wookmark wookmark_list">
							<ul class="wookmark-goods-photo move-mod nomove p_l5">
								<!-- {foreach from=$img_list item=img} -->
								<li class="thumbnail move-mod-group">
									<div class="attachment-preview">
										<div class="ecj-thumbnail">
											<div class="centered">
												<a class="bd" href="{$img.img_url}" title="{$img.img_desc}">
													<img data-original="{$img.img_original}" src="{$img.img_url}" alt="" />
												</a>
											</div>
										</div>
									</div>
									<p>
										<a href="javascript:;" title="{lang key='goods::goods.cancel'}" data-toggle="sort-cancel" style="display:none;"><i class="glyphicon glyphicon-remove"></i></a>
										<a href="javascript:;" title="{lang key='goods::goods.save'}" data-toggle="sort-ok" data-imgid="{$img.img_id}" data-saveurl="{url path='goods/mh_gallery/update_image_desc'}" style="display:none;"><i class="glyphicon glyphicon-ok"></i></a>
										<a class="ajaxremove" data-imgid="{$img.img_id}" data-toggle="ajaxremove" data-msg="{lang key='goods::goods.drop_photo_confirm'}" href='{url path="goods/mh_gallery/drop_image" args="img_id={$img.img_id}&goods_id={$smarty.get.goods_id}"}' title="{lang key='system::system.remove'}"><i class="glyphicon glyphicon-trash"></i></a>
										<a class="move-mod-head" href="javascript:void(0)" title="{lang key='goods::goods.move'}"><i class="glyphicon glyphicon-move"></i></a>
										<a href="javascript:;" title="{lang key='system::system.edit'}" data-toggle="edit"><i class="glyphicon glyphicon-pencil"></i></a>
										<span class="edit_title">{if $img.img_desc}{$img.img_desc}{else}{lang key='goods::goods.no_title'}{/if}</span>
									</p>
								</li>
								<!-- {/foreach} -->
							</ul>
						</div>
					</div>
					<div class="clearfix"></div>
					
					<div class="t_l m_t10">
						{if $img_list}
						<a class="btn btn-info save-sort" data-sorturl="{url path='goods/mh_gallery/sort_image'}">{lang key='goods::goods.save_sort'}</a>
						{/if}
					</div>
				</div>
			
				{if $step}
				<div class="t_c m_t10">
					<button class="btn btn-info complete m_l5" data-url='{url path="goods/merchant/edit" args="goods_id={$goods_id}"}'>{lang key='goods::goods.complete'}</button>
					<input type="hidden" name="step" value="{$step}" />
				</div>
				{/if}
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->