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
							<label class="control-label">{lang key='mobile::mobile.upload_img'}</label>
							<div class="controls">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<input type="hidden" name="{$var.code}" />
									<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
									<span class="btn btn-file">
										<span class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
										<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
										<input type='file' name='img_file_src' size="35" />
									</span>
									<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
									<span class="input-must">{lang key='system::system.require_field'}</span> 
									<br />
									<span class="help-block">{lang key='mobile::mobile.shortcut_img_notice'}</span>
								</div>
							</div>
						{else}
							<label class="control-label">{lang key='mobile::mobile.preview_img'}</label>
							<div class="controls">
								<div class="fileupload fileupload-new" data-provides="fileupload">
									<img class="w120 h120"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$rt.img_src}"><br><br>
									{lang key='mobile::mobile.file_address'}{$rt.img_src}<br><br>
									<input type="hidden" name="{$var.code}" />
									<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
									<span class="btn btn-file">
										<span class="fileupload-new">{lang key='mobile::mobile.change_image'}</span>
										<span class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
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
					<label class="control-label">{lang key='mobile::mobile.label_shortcut_link'}</label>
					<div class="controls">
						<input class="span8" name="img_url" type="text" value="{if $smarty.get.ad_link}{$smarty.get.ad_link}{else}{$rt.img_url}{/if}" size="40" />
						<span class="input-must">{lang key='system::system.require_field'}</span> 
					</div>
				</div>
				<div class="control-group formSep" >
					<label class="control-label">{lang key='mobile::mobile.label_shortcut_text'}</label>
					<div class="controls">
						<textarea class="span8" name="img_text" cols="40" rows="3">{$rt.img_txt}</textarea>
					</div>
				</div>
				<div class="control-group formSep" >
					<label class="control-label">{lang key='mobile::mobile.label_is_show'}</label>
				   	<div class="controls">
			            <div id="info-toggle-button">
			                <input class="nouniform" name="img_display" type="checkbox"  {if $rt.img_display eq 1}checked="checked"{/if}  value="1"/>
			            </div>
			        </div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='mobile::mobile.label_shortcut_order'}</label>
					<div class="controls">
						<input class="span8" name="img_sort" type="text" value="{$rt.img_sort}" size="5" maxlength="4"/>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="hidden"  name="id"		value="{$rt.id}" />
						<input type="hidden"  name="step"	value="2" />
						{if $rt.id eq ''}
						<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
						{else}
						<button class="btn btn-gebo" type="submit">{lang key='mobile::mobile.update'}</button>
						{/if}
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->