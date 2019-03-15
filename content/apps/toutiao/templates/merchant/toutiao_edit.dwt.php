<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.material_edit.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2>{if $ur_here}{$ur_here}{/if}</h2>
	</div>
	<div class="pull-right">
		<a  class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
	</div>
	<div class="clearfix"></div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			<div class="panel-body">
				<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
					<!-- {if $article.articles}-->
					<div class="f_l">
						<div class="mobile_news_view">
							<!-- {foreach from=$article.articles key=key item=list}-->
							<!-- {if $key eq 0} -->
							<div class="select_mobile_area mobile_news_main {if $id eq $list.id}active{/if}">
								<div class="show_image"><img src='{$list.image}'></div>
								<div class="item">
									<div class="default">{t domain="toutiao"}封面图片{/t}</div>
									<h4 class='news_main_title title_show'>{$list.title}</h4>
								</div>
								<div class="edit_mask">
									<a class="data-pjax" href='{url path="toutiao/merchant/edit" args="id={$list.id}"}'><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
								</div>
							</div>
							<!-- {else} -->
							<div class="select_mobile_area mobile_news_auxiliary {if $id eq $list.id}active{/if}">
								<div class="span7 news_auxiliary_title title_show">{$list.title}</div>
								<div class="span4 thumb_image"><div>{t domain="toutiao"}缩略图{/t}</div><div class="show_image"><img src='{$list.image}'></div></div>
								<div class="edit_mask">
									<a class="data-pjax" href='{url path="toutiao/merchant/edit" args="id={$list.id}"}'><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
									<a href="javascript:;" data-toggle="remove_child_material" data-url='{url path="toutiao/merchant/remove_child_article" args="id={$list.id}"}'><i class="fa fa-trash-o"></i></a>
								</div>
							</div>
							<!-- {/if} -->
							<!-- {/foreach} -->
							<a href="javascript:;" class="create_news" data-toggle="clone-object" data-parent=".mobile_news_auxiliary_clone"
							data-clone-area=".create_news" data-child=".mobile_news_editarea_clone" data-child-clone-area=".mobile_news_edit"><i class="fa fa-plus"></i></a>
						</div>
					</div>
					<div class="mobile_news_edit material_info">
						<!-- {foreach from=$article.articles key=key item=list}-->
						<!-- {if $list.id eq $id} -->
						<div class="mobile_news_edit_area">
							<h4 class="heading new_heading">{t domain="toutiao"}图文素材{/t}{$key+1}</h4>
							<fieldset>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{t domain="toutiao"}标题：{/t}</label>
									<div class="col-lg-9 controls">
										<input class='span8 form-control' type='text' name='title' value='{$list.title}'/>
									</div>
									<span class="input-must">*</span>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{t domain="toutiao"}封面：{/t}</label>
									<div class="col-lg-9 controls">
										<div class="fileupload fileupload-{if $list.real_image}exists{else}new{/if}" data-provides="fileupload">
											{if $list.real_image}
											<div class="fileupload-{if $list.real_image}exists{else}new{/if} thumbnail image_preview" style="max-width: 60px;">
												<img src="{$list.image}" style="width:50px; height:50px;"/>
											</div>
											{/if}
											<div class="fileupload-preview fileupload-{if $list.real_image}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
											<span class="btn btn-primary btn-file btn-sm">
												<span class="fileupload-new"><i class="fa fa-paper-clip"></i>{t domain="toutiao"}浏览{/t}</span>
												<span class="fileupload-exists"> {t domain="toutiao"}修改{/t}</span>
												<input type="file" class="default" name="image" />
											</span>
											{if $list.real_image}
											<a class="btn btn-danger btn-sm fileupload-exists" data-toggle="ajaxremove" data-msg='{t domain="toutiao"}您确定要删除封面吗？{/t}' data-href='{url path="toutiao/merchant/remove_file" args="id={$list.id}"}'>{t domain="toutiao"}删除{/t}</a>
											{else}
											<a class="btn btn-danger btn-sm fileupload-exists" data-dismiss="fileupload">{t domain="toutiao"}删除{/t}</a>
											{/if}
											<span class="input-must">*</span>
										</div>
										<span class="help-block">{t domain="toutiao"}（大图片建议尺寸：900像素 * 500像素）{/t}</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{t domain="toutiao"}摘要：{/t}</label>
									<div class="col-lg-9 controls">
										<textarea name="description" cols="55" rows="6" class="span8 form-control">{$list.description}</textarea>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{t domain="toutiao"}原文链接：{/t}</label>
									<div class="col-lg-9 controls">
										<input name='content_url' class='span8 form-control' type='text' value='{$list.content_url}'/>
									</div>
								</div>
								<div class="form-group row sort_form">
									<label class="col-lg-2 label-control text-right">{t domain="toutiao"}排序：{/t}</label>
									<div class="col-lg-9 controls">
										<input name='sort' class='span8 form-control' type='text' value='{$list.sort}'/>
										<span class="help-block">{t domain="toutiao"}排序从小到大{/t}</span>
									</div>
								</div>
								<div class="form-group row">
									<h3 class="heading card-title col-lg-12">
									{t domain="toutiao"}正文{/t}
									</h3>
									<div class="col-lg-11">
										{ecjia:editor content=$list.content textarea_name='content' is_teeny=0}
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right"></label>
									<div class="col-lg-9 controls">
										<input type="hidden" name="index" />
										{if $residue_degree gt 0}
										<a class="btn btn-info" data-toggle="ajaxremove" data-msg='{t domain="toutiao"}您确定要发送该图文素材吗？{/t}' href='{RC_Uri::url("toutiao/merchant/send", "id={$id}")}'>{t domain="toutiao"}发送{/t}</a>
										{/if}
										<a href='{RC_Uri::url("toutiao/mobile/preview", "id={$id}")}' target="_blank" class="btn btn-primary btn-preview {if $residue_degree gt 0}m_l10{/if}">{t domain="toutiao"}预览{/t}</a>
										<input type="submit" value='{t domain="toutiao"}存入素材库{/t}' class="btn btn-info m_l10"/>
										<p class="help-block m_t10">{t domain="toutiao" 1={$residue_degree}}你今日还可群发 %1 次消息{/t}</p>
									</div>
								</div>
							</fieldset>
						</div>
						<!-- {/if} -->
						<!-- {/foreach} -->
					</div>
					<!-- {/if} -->
				</form>
			</div>
		</div>
	</div>
</div>
<input type="hidden" name="update_url" value="{RC_Uri::url('toutiao/merchant/update')}" />
<input type="hidden" name="add_url" value="{RC_Uri::url('toutiao/merchant/add_child_article')}&group_id={$group_id}" />
<div class="select_mobile_area mobile_news_auxiliary mobile_news_auxiliary_clone hide material_info_select">
	<div class="span7 news_auxiliary_title title_show">{t domain="toutiao"}标题{/t}</div>
	<div class="span4 thumb_image"><div>{t domain="toutiao"}缩略图{/t}</div><div class="show_image"></div></div>
	<div class="edit_mask">
		<a href="javascript:;"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:;" data-toggle="remove_edit_mask" data-parent=".mobile_news_auxiliary" data-href='{RC_Uri::Url("toutiao/merchant/edit", "id={$id}")}'><i class="fa fa-trash-o"></i></a>
	</div>
</div>
<!-- {/block} -->