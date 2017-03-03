<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.material_edit.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->

<!-- {if $errormsg} -->
	<div class="alert alert-error">
		<strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
	</div>
<!-- {/if} -->

{if $warn}
	{if $wechat_type eq 0}
	 	<div class="alert alert-error">
	        <strong>{lang key='wechat::wechat.label_notice'}</strong>{lang key='wechat::wechat.notice_public_not_certified'}
	    </div>
	{/if}
{/if}

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"  id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class='span m_b20'>
		<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
			<!-- {if $action neq 'video_add'} -->
			<div class="f_l">
				<div class="mobile_news_view">
					<div class="select_mobile_area mobile_news_main">
						<div class="show_image"></div>
						<div class="item">
							<div class="default">{lang key='wechat::wechat.cover_images'}</div>
							<h4 class='news_main_title title_show'>
								{lang key='wechat::wechat.title'}
							</h4>
						</div>
						<div class="edit_mask">
							<a href="javascript:void(0);"><i class="icon-pencil"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="mobile_news_edit">
				<div class="mobile_news_edit_area">
					<h4 class="heading">{lang key='wechat::wechat.graphic'} 1</h4>
					<fieldset>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{lang key='wechat::wechat.label_title'}</label>
							<div class="controls">
								<input class='span8' type='text' name='title' value='' />
								<span class="input-must">*</span>
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{lang key='wechat::wechat.author'}</label>
							<div class="controls">
								<input class='span8' type='text' name='author' value='' />
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{lang key='wechat::wechat.cover'}</label>
							<div class="controls">
								<div class="fileupload fileupload-new" data-provides="fileupload">	
									<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
									</div>
									<span class="btn btn-file">
										<span  class="fileupload-new">{lang key='wechat::wechat.browser'}</span>
										<span  class="fileupload-exists">{lang key='wechat::wechat.modify'}</span>
										<input type='file' name='image_url' size="35"/>
									</span>
									<a class="btn fileupload-exists" data-dismiss="fileupload" href="javascrpt:;">{lang key='wechat::wechat.delete'}</a>
									<span class="input-must">*</span>
								</div>
								<input type="checkbox" name="is_show" value="1" />{lang key='wechat::wechat.cover_img_centent'}
								<span class="help-block">{lang key='wechat::wechat.img_size900x500'}</span>
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{lang key='wechat::wechat.summary'}</label>
							<div class="controls">
								<textarea name="digest" cols="55" rows="6" class="span8"></textarea>
								<span class="help-block">{lang key='wechat::wechat.optional_for54'}</span>
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{lang key='wechat::wechat.text_link'}</label>
							<div class="controls">
								<input name='link' class='span8' type='text' value='{t}http://{/t}' />
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{lang key='wechat::wechat.label_sort'}</label>
							<div class="controls">
								<input name='sort' class='span8' type='text'/>
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<h3 class="heading">
							{lang key='wechat::wechat.main_body'}
							</h3>
							<div class="row-fluid">
								<div class="span12">
									{ecjia:editor content='' textarea_name='content'}
								</div>
							</div>
						</div>
						<div class="control-group control-group-small">
							<div class="controls">
								<input type="submit" value="{lang key='wechat::wechat.ok'}" {if $errormsg}disabled{/if} class="btn btn-gebo" />
							</div>
						</div>
					</fieldset>
				</div>
			</div>
			<!-- {else} -->
			<div class="control-group formSep">
				<label class="control-label">{lang key='wechat::wechat.label_title'}</label>
				<div class="controls">
					<input type="text" class="w280" name="video_title" maxlength="60" size="30" value="{$article.title}" />
					<span class="input-must">*</span>
				</div>
			</div>
			
			<!-- {if !$article.file} -->
			<div class="control-group formSep">
				<label class="control-label">{lang key='wechat::wechat.label_video'}</label>
				<div class="controls fileupload fileupload-new" data-provides="fileupload">
					<span class="btn btn-file">
						<span class="fileupload-new">{lang key='wechat::wechat.browser'}</span>
						<span class="fileupload-exists">{lang key='wechat::wechat.modify_video'}</span>
						<input type="file" name="video"/>
					</span>
					<span class="fileupload-preview m_t10"></span>
					<a class="close fileupload-exists" style="float: none" data-dismiss="fileupload" href="index.php-uid=1&page=form_extended.html#">&times;</a>	
					<span class="input-must">*</span>
					<div class="help-block">{lang key='wechat::wechat.uploadmp4_most10'}</div>
				</div>
			</div>
			<!-- {/if} -->
			
			<div class="control-group formSep">
				<label class="control-label">{lang key='wechat::wechat.label_video_intro'}</label>
				<div class="controls">
					<textarea name="video_digest" class="w280">{$article.digest}</textarea>
					{if $material eq 1}<span class="input-must">*</span>{/if}
				</div>
			</div>
			
			<div class="control-group">
				<div class="controls">
					{if $button_type eq 'add'}
					<input type="submit" class="btn btn-gebo" {if $errormsg}disabled{/if} value="{lang key='wechat::wechat.ok'}" />
					{else}
					<input type="submit" class="btn btn-gebo" {if $errormsg}disabled{/if} value="{lang key='wechat::wechat.update'}" />
			      	<input type="hidden" name="id" value="{$article.id}" />
			      	{/if}
				</div>
			</div>
			<!-- {/if} -->
		</form>
	</div>
</div>
<!-- {/block} -->