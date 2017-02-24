<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.cycleimage_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
			<fieldset>
				<div class="control-group formSep">
					{if $rt.img_src eq ''}
					<label class="control-label">{lang key='cycleimage::flashplay.label_upload_image'}</label>
					<div class="controls">
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<input type="hidden" name="{$var.code}" />
							<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
							<span class="btn btn-file">
								<span class="fileupload-new">{lang key='cycleimage::flashplay.browse'}</span>
								<span class="fileupload-exists">{lang key='cycleimage::flashplay.modify'}</span>
								<input type='file' name='img_file_src' size="35" />
							</span>
							<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
							<span class="input-must"><span class="require-field" style="color:#FF0000;">*</span></span>
							<br />
							<span class="help-block">{lang key='cycleimage::flashplay.image_standard'}</span>
						</div>
					</div>
					{else}
					<label class="control-label">{lang key='cycleimage::flashplay.preview_image'}</label>
					<div class="controls">
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<img class="w600 h300"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$rt.img_src}"><br><br>
							{lang key='cycleimage::flashplay.label_img_src'} {$rt.img_src}<br><br>
							<input type="hidden" name="{$var.code}" />
							<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
							<span class="btn btn-file">
								<span class="fileupload-new">{lang key='cycleimage::flashplay.change_image'}</span>
								<span class="fileupload-exists">{lang key='cycleimage::flashplay.modify'}</span>
								<input type='file' name='img_file_src' size="35" />
							</span>
							<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
							<input type="hidden" name="{$var.code}" />
							<input type="hidden" name="{$rt.img_src}" />
							 <input name="img_src" value="{$rt.img_src}" class="hide">
						</div>
					</div>
					{/if}
				</div>

				<div class="control-group formSep">
					<label class="control-label">{lang key='cycleimage::flashplay.label_img_url'}</label>
					<div class="controls">
						<input class="span8" name="img_url" type="text" value="{if $smarty.get.ad_link}{$smarty.get.ad_link}{else}{$rt.img_url}{/if}" size="40" />
						<span class="input-must">*</span>
					</div>
				</div>
				<div class="control-group formSep" >
					<label class="control-label">{lang key='cycleimage::flashplay.label_img_desc'}</label>
					<div class="controls">
						<textarea class="span8" name="img_text" cols="40" rows="3">{$rt.img_txt}</textarea>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='cycleimage::flashplay.label_sort'}</label>
					<div class="controls">
						<input class="span8" name="img_sort" type="text" value="{$rt.img_sort}" size="5" maxlength="4"/>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="hidden" name="id" value="{$rt.id}" />
						<input type="hidden" name="step" value="2" />
						{if $rt.id eq ''}
						<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
						{else}
						<button class="btn btn-gebo" type="submit">{lang key='cycleimage::flashplay.update'}</button>
						{/if}
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->