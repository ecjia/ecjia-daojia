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
					<input type="text" name="title" size="40" maxlength="60" class="span10" value="{$article.title}" placeholder="{t domain="article"}请输入文章标题{/t}"/> 
					<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
				</div>
				
				<div class="control-group formSep">
					<div>{ecjia:editor content=$article.content textarea_name='content'}</div>
				</div>
				
				<div class="foldable-list move-mod-group">
					<div class="accordion-group">
						<div class="accordion-heading">
							<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#upload_thumb">
								<strong>{t domain="article"}上传缩略图{/t}</strong>
							</a>
						</div>
						<div class="accordion-body collapse" id="upload_thumb">
							<div class="accordion-inner">
								<div class="control-group control-group-small m_t15">
									{if $article.file_url neq ''}
									<label class="control-label">{t domain="article"}预览图片：{/t}</label>
									<div class="controls">
							       		<div class="t_l">
											<img class="w150 w150" class="img-polaroid" src="{$article.image_url} " />
										</div>
							       		<span class="ecjiaf-db m_t5 m_b5 ecjiaf-wwb">{t domain="article"}图片地址：{/t}{$article.file_url}</span>
										<a class="ajaxremove ecjiafc-red ecjiaf-db" data-toggle="ajaxremove" data-msg="{t domain="article"}您确定要删除该图片吗？{/t}" href='{RC_Uri::url("article/admin_notice/del_file", "id={$article.article_id}")}' title="{t domain="article"}删除图片{/t}">
								        {t domain="article"}删除图片{/t}
								        </a>
								        <input name="file" value="{$article.file_url}" class="hide">
									</div>
									{else}
									<label class="control-label">{t domain="article"}上传图片：{/t}</label>
									<div class="controls">
										<div data-provides="fileupload" class="fileupload fileupload-new">
											<span class="btn btn-file">
												<span class="fileupload-new">{t domain="article"}选择图片{/t}</span>
												<span class="fileupload-exists">{t domain="article"}修改图片{/t}</span>
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
								<strong>{t domain="article"}SEO优化{/t}</strong>
							</a>
						</div>
						<div class="accordion-body collapse" id="collapse001">
							<div class="accordion-inner">
								<div class="control-group control-group-small">
									<label class="control-label">{t domain="article"}关键字：{/t}</label>
									<div class="controls">
										<input class="span12" type="text" name="keywords" value="{$article.keywords}" size="40" />
										<br />
										<p class="help-block w280 m_t5">{t domain="article"}用英文逗号分隔{/t}</p>
									</div>
								</div>
								<div class="control-group control-group-small" >
									<label class="control-label">{t domain="article"}简单描述：{/t}</label>
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
					<button class="btn btn-gebo" type="submit">{t domain="article"}更新{/t}</button>
					<input type="hidden" name="id" value="{$article.article_id}" />
					<!-- {else} -->
					<button class="btn btn-gebo" type="submit">{t domain="article"}确定{/t}</button>
					<!-- {/if} -->
				</p>
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->