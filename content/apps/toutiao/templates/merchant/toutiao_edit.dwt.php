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
									<div class="default">{lang key='wechat::wechat.cover_images'}</div>
									<h4 class='news_main_title title_show'>{$list.title}</h4>
								</div>
								<div class="edit_mask">
									<a class="data-pjax" href='{url path="toutiao/merchant/edit" args="id={$list.id}"}'><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;
								</div>
							</div>
							<!-- {else} -->
							<div class="select_mobile_area mobile_news_auxiliary {if $id eq $list.id}active{/if}">
								<div class="span7 news_auxiliary_title title_show">{$list.title}</div>
								<div class="span4 thumb_image"><div>{lang key='wechat::wechat.thumbnail'}</div><div class="show_image"><img src='{$list.image}'></div></div>
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
							<h4 class="heading new_heading">图文素材{$key+1}</h4>
							<fieldset>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_title'}</label>
									<div class="col-lg-9 controls">
										<input class='span8 form-control' type='text' name='title' value='{$list.title}'/>
									</div>
									<span class="input-must">*</span>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.cover'}</label>
									<div class="col-lg-9 controls">
										<div class="fileupload fileupload-{if $list.real_image}exists{else}new{/if}" data-provides="fileupload">
											{if $list.real_image}
											<div class="fileupload-{if $list.real_image}exists{else}new{/if} thumbnail image_preview" style="max-width: 60px;">
												<img src="{$list.image}" style="width:50px; height:50px;"/>
											</div>
											{/if}
											<div class="fileupload-preview fileupload-{if $list.real_image}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
											<span class="btn btn-primary btn-file btn-sm">
												<span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
												<span class="fileupload-exists"> 修改</span>
												<input type="file" class="default" name="image" />
											</span>
											{if $list.real_image}
											<a class="btn btn-danger btn-sm fileupload-exists" data-toggle="ajaxremove" data-msg="您确定要删除封面吗？" data-href='{url path="toutiao/merchant/remove_file" args="id={$list.id}"}'>删除</a>
											{else}
											<a class="btn btn-danger btn-sm fileupload-exists" data-dismiss="fileupload">删除</a>
											{/if}
											<span class="input-must">*</span>
										</div>
										<span class="help-block">{lang key='wechat::wechat.img_size900x500'}</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.summary'}</label>
									<div class="col-lg-9 controls">
										<textarea name="description" cols="55" rows="6" class="span8 form-control">{$list.description}</textarea>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.text_link'}</label>
									<div class="col-lg-9 controls">
										<input name='content_url' class='span8 form-control' type='text' value='{$list.content_url}'/>
									</div>
								</div>
								<div class="form-group row sort_form">
									<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_sort'}</label>
									<div class="col-lg-9 controls">
										<input name='sort' class='span8 form-control' type='text' value='{$list.sort}'/>
										<span class="help-block">排序从小到大</span>
									</div>
								</div>
								<div class="form-group row">
									<h3 class="heading card-title col-lg-12">
									{lang key='wechat::wechat.main_body'}
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
										<a class="btn btn-info" data-toggle="ajaxremove" data-msg="您确定要发送该图文素材吗？" href='{RC_Uri::url("toutiao/merchant/send", "id={$id}")}'>发送</a>
										{/if}
										<a href='{RC_Uri::url("toutiao/mobile/preview", "id={$id}")}' target="__blank" class="btn btn-primary btn-preview {if $residue_degree gt 0}m_l10{/if}">预览</a>
										<input type="submit" value="存入素材库" class="btn btn-info m_l10"/>
										<p class="help-block m_t10">你今日还可群发 {$residue_degree} 次消息</p>
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
	<div class="span7 news_auxiliary_title title_show">{lang key='wechat::wechat.title'}</div>
	<div class="span4 thumb_image"><div>{lang key='wechat::wechat.thumbnail'}</div><div class="show_image"></div></div>
	<div class="edit_mask">
		<a href="javascript:;"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:;" data-toggle="remove_edit_mask" data-parent=".mobile_news_auxiliary" data-href='{RC_Uri::Url("toutiao/merchant/edit", "id={$id}")}'><i class="fa fa-trash-o"></i></a>
	</div>
</div>
<!-- {/block} -->