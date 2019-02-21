<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_photo.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
{if $step eq '4'}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} --><a class="btn plus_or_reply data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i><!-- {$action_link.text} --></a><!-- {/if} -->
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
		</div>
		<div class="fileupload" data-action="{$form_action}" data-remove="{url path='goods/admin_gallery/drop_image'}">
		</div>
	</div>
</div>
<div class="row-fluid goods-photo-list{if !$img_list} hide{/if}">
	<div class="span12">
		<h3 class="heading m_b10">{t domain="goods"}商品相册{/t}<small>{t domain="goods"}（编辑、排序、删除）{/t}</small></h3>
		<div class="m_b20">
			<span class="help-inline">{t domain="goods"}排序后请点击“保存排序”{/t}</span>
		</div>
		<div class="wmk_grid ecj-wookmark wookmark_list">
			<ul class="wookmark-goods-photo move-mod nomove">
				<!-- {foreach from=$img_list item=img} -->
				<li class="thumbnail move-mod-group">
				<div class="attachment-preview">
					<div class="ecj-thumbnail">
						<div class="centered">
							<a class="bd" href="{$img.img_url}" title="{$img.img_desc}">
							<img data-original="{$img.img_original}" src="{$img.img_url}" alt=""/>
							</a>
						</div>
					</div>
				</div>
				<p>
					<a href="javascript:;" title="{t domain="goods"}取消{/t}" data-toggle="sort-cancel" style="display:none;"><i class="fontello-icon-cancel"></i></a>
					<a href="javascript:;" title="{t domain="goods"}保存{/t}" data-toggle="sort-ok" data-imgid="{$img.img_id}" data-saveurl="{url path='goods/admin_gallery/update_image_desc'}" style="display:none;"><i class="fontello-icon-ok"></i></a>
					<a class="ajaxremove" data-imgid="{$img.img_id}" data-toggle="ajaxremove" data-msg="{t domain="goods"}您确定要删除这张相册图片吗？{/t}" href='{url path="goods/admin_gallery/drop_image" args="img_id={$img.img_id}&goods_id={$smarty.get.goods_id}"}' title="{t domain="goods"}删除{/t}"><i class="icon-trash"></i></a>
					<a class="move-mod-head" href="javascript:void(0)" title="{t domain="goods"}移动{/t}"><i class="icon-move"></i></a>
					<a href="javascript:;" title="{t domain="goods"}编辑{/t}" data-toggle="edit"><i class="icon-pencil"></i></a>
					<span class="edit_title">{if $img.img_desc}{$img.img_desc}{else}{t domain="goods"}无标题{/t}{/if}</span>
				</p>
				</li>
				<!-- {/foreach} -->
			</ul>
		</div>
	</div>
	<a class="btn btn-info save-sort" data-sorturl="{url path='goods/admin_gallery/sort_image'}">{t domain="goods"}保存排序{/t}</a>
</div>
<div class="row-fluid">
	{if $step}
	<fieldset class="t_c">
		<button class="btn btn-gebo next_step" data-url="{$url}">{t domain="goods"}下一步{/t}</button>
		<button class="btn btn-gebo complete" data-url='{if $code}{url path="goods/admin/init" args="extension_code={$code}"}{else}{url path="goods/admin/init"}{/if}'>{t domain="goods"}完成{/t}</button>
		<input type="hidden" name="step" value="{$step}"/>
	</fieldset>
	{/if}
</div>
<!-- {/block} -->