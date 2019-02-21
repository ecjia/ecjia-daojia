<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_brand_info.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
	<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" method="post" action="{$form_action}" name="theForm" enctype="multipart/form-data" data-edit-url="{RC_Uri::url('goods/admin_brand/edit')}">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goods"}品牌名称：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="brand_name" maxlength="60" value="{$brand.brand_name}"/>
						<span class="input-must">*</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goods"}品牌网址：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="site_url" maxlength="60" size="40" value="{$brand.site_url}"/>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goods"}品牌LOGO：{/t}</label>
					<div class="controls chk_radio">
						<input type="radio" name="brand_logo_type" value='0'{if !$brand.type} checked="checked"{/if} autocomplete="off"/><span>{t domain="goods"}远程链接{/t}</span>
						<input type="radio" name="brand_logo_type" value='1'{if $brand.type} checked="checked"{/if} autocomplete="off"/><span>{t domain="goods"}本地上传{/t}</span>
					</div>
					<div class="controls cl_both brand_logo_type" id="show_src">
						<input class="w350" type='text' name='url_logo' size="42" value="{if !$brand.type}{$brand.brand_logo}{/if}"/>
						<span class="help-block">{t domain="goods"}在指定远程LOGO图片时，LOGO图片的URL网址必须为http:// 或 https://开头的正确URL格式！{/t}</span>
					</div>
					<div class="controls cl_both brand_logo_type" id="show_local" style="display:none;">
						<div class="fileupload {if $brand.url && $brand.type}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
							<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
								{if $brand.url && $brand.type}
								<img src="{$brand.url}"/>
								{/if}
							</div>
							<span class="btn btn-file">
							<span class="fileupload-new">{t domain="goods"}浏览{/t}</span>
							<span class="fileupload-exists">{t domain="goods"}修改{/t}</span>
							<input type='file' name='brand_img' size="35"/>
							</span>
							<a class="btn fileupload-exists" {if !$brand.url}data-dismiss="fileupload" href="javascript:;"{else}data-toggle="ajaxremove" data-msg="{t domain="goods"}你确认要删除该品牌LOGO吗？{/t}" href='{url path="goods/admin_brand/drop_logo" args="id={$brand.brand_id}"}' title="{t domain="goods"}删除{/t}"{/if}>{t domain="goods"}删除{/t}</a>
						</div>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goods"}品牌描述：{/t}</label>
					<div class="controls">
						<textarea class="w350" name="brand_desc" cols="60" rows="5">{$brand.brand_desc}</textarea>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goods"}排序：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="sort_order" maxlength="40" size="15" value="{$brand.sort_order}"/>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goods"}是否显示：{/t}</label>
					<div class="controls chk_radio">
						<input class="uni_style" type="radio" name="is_show" value="1" style="opacity: 0;" {if $brand.is_show eq 1}checked="checked"{/if}/><span>{t domain="goods"}是{/t}</span>
						<input class="uni_style" type="radio" name="is_show" value="0" style="opacity: 0;" {if $brand.is_show eq 0}checked="checked"{/if}/><span>{t domain="goods"}否{/t}</span>
						<span class="help-block">{t domain="goods"}当品牌下还没有商品的时候，首页及分类页的品牌区将不会显示该品牌。{/t}</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<!-- {if $brand.brand_id} -->
						<input type="hidden" id="type" value="{$brand.type}"/>
						<input type="hidden" name="id" value="{$brand.brand_id}"/>
						<input type="hidden" name="old_brandlogo" value="{$brand.brand_logo}">
						<button class="btn btn-gebo" type="submit">{t domain="goods"}更新{/t}</button>
						<!-- {else} -->
						<button class="btn btn-gebo" type="submit">{t domain="goods"}确定{/t}</button>
						<!-- {/if} -->
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->