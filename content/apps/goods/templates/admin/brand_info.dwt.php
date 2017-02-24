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
					<label class="control-label">{lang key='goods::brand.label_brand_name'}</label>
					<div class="controls">
						<input class="w350" type="text" name="brand_name" maxlength="60" value="{$brand.brand_name}"/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='goods::brand.label_site_url'}</label>
					<div class="controls">
						<input class="w350" type="text" name="site_url" maxlength="60" size="40" value="{$brand.site_url}"/>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='goods::brand.label_brand_logo'}</label>
					<div class="controls chk_radio">
						<input type="radio" name="brand_logo_type" value='0'{if !$brand.type} checked="checked"{/if} autocomplete="off"/><span>{lang key='goods::brand.link_url'}</span>
						<input type="radio" name="brand_logo_type" value='1'{if $brand.type} checked="checked"{/if} autocomplete="off"/><span>{lang key='goods::brand.local_upload'}</span>
					</div>
					<div class="controls cl_both brand_logo_type" id="show_src">
						<input class="w350" type='text' name='url_logo' size="42" value="{if !$brand.type}{$brand.brand_logo}{/if}"/>
						<span class="help-block">{lang key='goods::brand.help_info'}</span>
					</div>
					<div class="controls cl_both brand_logo_type" id="show_local" style="display:none;">
						<div class="fileupload {if $brand.url && $brand.type}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
							<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
								{if $brand.url && $brand.type}
								<img src="{$brand.url}"/>
								{/if}
							</div>
							<span class="btn btn-file">
							<span class="fileupload-new">{lang key='goods::brand.browse'}</span>
							<span class="fileupload-exists">{lang key='goods::brand.modify'}</span>
							<input type='file' name='brand_img' size="35"/>
							</span>
							<a class="btn fileupload-exists" {if !$brand.url}data-dismiss="fileupload" href="javascript:;"{else}data-toggle="ajaxremove" data-msg="{lang key='goods::brand.confirm_drop_logo'}" href='{url path="goods/admin_brand/drop_logo" args="id={$brand.brand_id}"}' title="{lang key='system::system.drop'}"{/if}>{lang key='system::system.drop'}</a>
						</div>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='goods::brand.label_brand_desc'}</label>
					<div class="controls">
						<textarea class="w350" name="brand_desc" cols="60" rows="5">{$brand.brand_desc}</textarea>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='goods::brand.label_sort_order'}</label>
					<div class="controls">
						<input class="w350" type="text" name="sort_order" maxlength="40" size="15" value="{$brand.sort_order}"/>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='goods::brand.label_is_show'}</label>
					<div class="controls chk_radio">
						<input class="uni_style" type="radio" name="is_show" value="1" style="opacity: 0;" {if $brand.is_show eq 1}checked="checked"{/if}/><span>{lang key='system::system.yes'}</span>
						<input class="uni_style" type="radio" name="is_show" value="0" style="opacity: 0;" {if $brand.is_show eq 0}checked="checked"{/if}/><span>{lang key='system::system.no'}</span>
						<span class="help-block">{lang key='goods::brand.visibility_notes'}</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<!-- {if $brand.brand_id} -->
						<input type="hidden" id="type" value="{$brand.type}"/>
						<input type="hidden" name="id" value="{$brand.brand_id}"/>
						<input type="hidden" name="old_brandlogo" value="{$brand.brand_logo}">
						<button class="btn btn-gebo" type="submit">{lang key='goods::brand.update'}</button>
						<!-- {else} -->
						<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
						<!-- {/if} -->
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->