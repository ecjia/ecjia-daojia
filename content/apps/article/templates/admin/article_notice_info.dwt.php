<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.store_notice.init();
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
		<div class="tabbable">
			<form class="form-horizontal" action="{$form_action}" method="post" enctype="multipart/form-data" name="theForm">
				<div class="control-group formSep">
					<input type="text" name="title" size="40" maxlength="60" class="span10" value="{$article.title}" placeholder="{lang key='article::article.article_title_required'}"/> 
					<span class="input-must">{lang key='system::system.require_field'}</span>
				</div>
				
				<div class="control-group formSep">
					<div>{ecjia:editor content=$article.content textarea_name='content'}</div>
				</div>
				
				<div class="foldable-list move-mod-group">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#upload_thumb">
								<strong>{lang key='article::article.upload_thumb'}</strong>
							</a>
						</div>
						<div class="accordion-body collapse" id="upload_thumb">
							<div class="accordion-inner">
								<div class="control-group control-group-small m_t15">
									{if $article.file_url neq ''}
									<label class="control-label">{lang key='article::article.label_preview_image'}</label>
									<div class="controls">
							       		<div class="t_l">
											<img class="w150 w150" class="img-polaroid" src="{$article.image_url} " />
										</div>
							       		<span class="ecjiaf-db m_t5 m_b5 ecjiaf-wwb">{lang key='article::article.label_image_address'}{$article.file_url}</span>
										<a class="ajaxremove ecjiafc-red ecjiaf-db" data-toggle="ajaxremove" data-msg="{lang key='article::article.drop_image_confirm'}" href='{RC_Uri::url("article/admin_notice/del_file", "id={$article.article_id}")}' title="{lang key='article::article.drop_image'}">
								        {lang key='article::article.drop_image'}
								        </a>
								        <input name="file" value="{$article.file_url}" class="hide">
									</div>
									{else}
									<label class="control-label">{lang key='article::article.label_upload_image'}</label>
									<div class="controls">
										<div data-provides="fileupload" class="fileupload fileupload-new">
											<span class="btn btn-file">
												<span class="fileupload-new">{lang key='article::article.select_image'}</span>
												<span class="fileupload-exists">{lang key='article::article.modify_image'}</span>
												<input type="file" name="file">
											</span>
											<span class="fileupload-preview"></span>
											<a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="#">&times;</a>
										</div>
									</div>
									{/if}
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="foldable-list move-mod-group">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#collapse001">
								<strong>{lang key='article::article.seo_optimization'}</strong>
							</a>
						</div>
						<div class="accordion-body collapse" id="collapse001">
							<div class="accordion-inner">
								<div class="control-group control-group-small">
									<label class="control-label">{lang key='article::article.keywords'}</label>
									<div class="controls">
										<input class="span12" type="text" name="keywords" value="{$article.keywords}" size="40" />
										<br />
										<p class="help-block w280 m_t5">{lang key='article::article.split'}</p>
									</div>
								</div>
								<div class="control-group control-group-small" >
									<label class="control-label">{lang key='article::article.simple_description'}</label>
									<div class="controls">
										<textarea class="span12 h100" name="description" value="{$article.description}" cols="40" rows="3">{$article.description}</textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<p class="ecjiaf-tac">
					<!-- {if $article.article_id} -->
					<button class="btn btn-gebo" type="submit">{lang key='article::article.update'}</button>
					<input type="hidden" name="id" value="{$article.article_id}" />
					<!-- {else} -->
					<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
					<!-- {/if} -->
				</p>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->