<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-platform.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.platform.material_edit.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->

<!-- {if $errormsg} -->
<div class="alert alert-danger">
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{$errormsg}
</div>
<!-- {/if} -->

{if $warn && $wechat_type eq 0}
<div class="alert alert-danger">
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{t domain="wechat"}抱歉！您当前公众号属于“未认证的公众号”，该模块目前还不支持“未认证的公众号”。{/t}
</div>
{/if}

{if $media_data.wait_upload_article eq 1}
<div class="alert alert-info">
	<strong>{t domain="wechat"}温馨提示：{/t}</strong>{t domain="wechat"}该素材已修改，请点击 “发布素材” 按钮上传到微信公众平台。{/t}
</div>
{/if}

<!-- {if ecjia_screen::get_current_screen()->get_help_sidebar()} -->
<div class="alert alert-light alert-dismissible mb-2" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">×</span>
	</button>
	<h4 class="alert-heading mb-2">{t domain="wechat"}操作提示{/t}</h4>
    <!-- {ecjia_screen::get_current_screen()->get_help_sidebar()} -->
</div>
<!-- {/if} -->

<div class="row edit-page">
    <div class="col-12">
        <div class="card">
			<div class="card-header">
                <h4 class="card-title">
                	{$ur_here}
                	{if $action_link}
					<a class="btn btn-outline-primary plus_or_reply float-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
					{/if}
					
                	{if $media_data.wait_upload_article eq 1}
                	<a class="btn btn-outline-info plus_or_reply float-right m_r10 article_handle" href="javascript:;" data-url="{RC_Uri::url('wechat/platform_material/upload_multi_articles')}&id={$parent_id}"><i class="ft-arrow-up"></i> 发布素材</a>
                	{/if}
                	
                	<a class="btn btn-outline-info plus_or_reply float-right m_r10 article_handle" href="javascript:;" data-url="{RC_Uri::url('wechat/platform_material/get_wechat_article')}&id={$parent_id}"><i class="ft-arrow-down"></i> 获取最新素材</a>
                </h4>
            </div>
            <div class="col-lg-12">
				<form method="post" class="form-horizontal" action="{$form_action}" name="theForm" enctype="multipart/form-data">
					<!-- {if $article.articles}-->
						<div class="f_l">
							<div class="mobile_news_view">
								<!-- {foreach from=$article.articles key=key item=list}-->
									<!-- {if $key eq 0} -->
									<div class="select_mobile_area mobile_news_main {if $id eq $list.id}active{/if}">
										<div class="show_image"><img src='{$list.file}'></div>
										<div class="item">
											<div class="default">{t domain="wechat"}封面图片{/t}</div>
											<h4 class='news_main_title title_show'>{$list.title}</h4>
										</div>
										<div class="edit_mask">
											<a href="javascript:;" class="data-pjax" data-id="{$list.id}" data-href='{url path="wechat/platform_material/get_material_info" args="id={$list.id}&material=1"}'><i class="ft-edit-2"></i></a>&nbsp;&nbsp;&nbsp;
										</div>
									</div>
									<!-- {else} -->
									<div class="select_mobile_area mobile_news_auxiliary {if $id eq $list.id}active{/if}">
										<div class="span7 news_auxiliary_title title_show">{$list.title}</div>
										<div class="span4 thumb_image"><div>{t domain="wechat"}缩略图{/t}</div><div class="show_image"><img src='{$list.file}'></div></div>
										<div class="edit_mask">
											<a href="javascript:;" class="data-pjax" data-id="{$list.id}" data-href='{url path="wechat/platform_material/get_material_info" args="id={$list.id}&material=1"}'><i class="ft-edit-2"></i></a>&nbsp;&nbsp;&nbsp;
											<a href="javascript:;" data-toggle="remove_child_material" data-url='{url path="wechat/platform_material/remove_child_article" args="id={$list.id}"}'><i class="ft-trash-2"></i></a>
										</div>
									</div>
									<!-- {/if} -->
								<!-- {/foreach} -->
								<a href="javascript:;" class="create_news" data-toggle="clone-object" data-parent=".mobile_news_auxiliary_clone" 
								data-clone-area=".create_news" data-child=".mobile_news_editarea_clone" data-child-clone-area=".mobile_news_edit"><i class="ft-plus"></i></a>
							</div>
						</div>
						<div class="mobile_news_edit material_info">
							<!-- {foreach from=$article.articles key=key item=list}-->
								<!-- {if $list.id eq $id} -->
								<div class="mobile_news_edit_area">
									<h4 class="heading">{t domain="wechat"}图文{/t}{$key+1}</h4>
									<fieldset>
										<div class="form-group row">
											<label class="col-lg-2 label-control text-right">{t domain="wechat"}标题：{/t}</label>
											<div class="col-lg-9 controls">
												<input class='span8 form-control' type='text' name='title' value='{$list.title}'/>
											</div>
											<span class="input-must">*</span>
										</div>
										<div class="form-group row">
											<label class="col-lg-2 label-control text-right">{t domain="wechat"}作者：{/t}</label>
											<div class="col-lg-9 controls">
												<input class='span8 form-control' type='text' name='author' value='{$list.author}'/>
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-lg-2 label-control text-right">{t domain="wechat"}封面：{/t}</label>
											<div class="col-lg-9 controls">
												<div class="fileupload fileupload-exists" data-provides="fileupload">
													{if $list.file}
													<div class="fileupload-preview fileupload-exists thumbnail m_r10 show_cover" style="width: 50px; height: 50px; line-height: 50px;">
														<img src="{$list.file}">
													</div>
													{/if}
													<a class="btn btn-outline-primary choose_material" href="javascript:;" data-url="{RC_Uri::url('wechat/platform_material/choose_material')}&material=1" 
													data-type="thumb">{t domain="wechat"}从素材库选择{/t}</a>
													<span class="m_l5 input-must">*</span>
													<input type="hidden" name="thumb_media_id" size="35" value="{$list.thumb}"/>
												</div>
												<input type="checkbox" name="is_show" value="1" id="is_show_1" {if $list.is_show}checked{/if}/><label for="is_show_1"></label>{t domain="wechat"}封面图片显示在正文中{/t}
												<span class="help-block">{t domain="wechat"}（大图片建议尺寸：900像素 * 500像素）{/t}</span>
											</div>
										</div>
									
										<div class="form-group row">
											<label class="col-lg-2 label-control text-right">{t domain="wechat"}摘要：{/t}</label>
											<div class="col-lg-9 controls">
												<textarea name="digest" cols="55" rows="6" class="span8 form-control">{$list.digest}</textarea>
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-lg-2 label-control text-right">{t domain="wechat"}原文链接：{/t}</label>
											<div class="col-lg-9 controls">
												<input name='link' class='span8 form-control' type='text' value='{$list.link}'/>
											</div>
										</div>
										
										<div class="form-group row sort_form">
											<label class="col-lg-2 label-control text-right">{t domain="wechat"}排序：{/t}</label>
											<div class="col-lg-9 controls">
												<input name='sort' class='span8 form-control' type='text' value='{$list.sort}'/>
												<span class="help-block">{t domain="wechat"}排序从小到大{/t}</span>
											</div>
										</div>
		
										<div class="form-group row">
											<h3 class="heading card-title col-lg-12">
                                                {t domain="wechat"}正文{/t}
											</h3>
											<div class="col-lg-11">
												{ecjia:editor content=$list.content textarea_name='content' is_teeny=0}
											</div>
										</div>
										
										<div class="form-group row">
											<label class="col-lg-2 label-control text-right"></label>
											<div class="col-lg-9 controls">
												<input type="hidden" name="index" />
												<input type="submit" value='{t domain="wechat"}更新{/t}' class="btn btn-outline-primary"/>
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
<input type="hidden" name="update_url" value="{RC_Uri::url('wechat/platform_material/update')}" />
<input type="hidden" name="add_url" value="{RC_Uri::url('wechat/platform_material/add_child_article')}&parent_id={$parent_id}" />

<div class="select_mobile_area mobile_news_auxiliary mobile_news_auxiliary_clone hide material_info_select">
	<div class="span7 news_auxiliary_title title_show">{t domain="wechat"}标题{/t}</div>
	<div class="span4 thumb_image"><div>{t domain="wechat"}缩略图{/t}</div><div class="show_image"></div></div>
	<div class="edit_mask">
		<a href="javascript:;"><i class="ft-edit-2"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:;" data-toggle="remove_edit_mask" data-parent=".mobile_news_auxiliary"><i class="ft-trash-2"></i></a>
	</div>
</div>

<!-- {include file="./library/wechat_choose_material.lbi.php"} -->

<!-- {/block} -->