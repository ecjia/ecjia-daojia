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
				<form class="form" method="post" name="theForm" action="{$form_action}" enctype="multipart/form-data">
					<div class="f_l">
						<div class="mobile_news_view">
							<div class="select_mobile_area mobile_news_main">
								<div class="show_image"></div>
								<div class="item">
									<div class="default">{lang key='wechat::wechat.cover_images'}</div>
									<h4 class='news_main_title title_show'>{lang key='wechat::wechat.title'}</h4>
								</div>
								<div class="edit_mask">
									<a href="javascript:void(0);"><i class="fa fa-edit"></i></a>
								</div>
							</div>
						</div>
					</div>
					<div class="mobile_news_edit">
						<div class="mobile_news_edit_area">
							<h4 class="heading new_heading">图文素材1</h4>
							<fieldset>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_title'}</label>
									<div class="col-lg-9 controls">
										<input class="span8 form-control" type="text" name="title" value='' />
									</div>
									<span class="input-must">*</span>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.cover'}</label>
									<div class="col-lg-9 controls">
										<div class="fileupload fileupload-new" data-provides="fileupload">
											<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
											<span class="btn btn-primary btn-file btn-sm">
												<span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
												<span class="fileupload-exists"> 修改</span>
												<input type="file" class="default" name="image" />
											</span>
											<a class="btn btn-danger btn-sm fileupload-exists" data-dismiss="fileupload" href="" >删除</a>
											<span class="input-must">*</span>
										</div>
										<span class="help-block">{lang key='wechat::wechat.img_size900x500'}</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.summary'}</label>
									<div class="col-lg-9 controls">
										<textarea name="description" cols="55" rows="6" class="span8 form-control"></textarea>
										<span class="help-block">{lang key='wechat::wechat.optional_for54'}</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.text_link'}</label>
									<div class="col-lg-9 controls">
										<input name='content_url' class='span8 form-control' type='text' value='{t}http://{/t}' />
									</div>
								</div>
								<div class="form-group row sort_form">
									<label class="col-lg-2 label-control text-right">{lang key='wechat::wechat.label_sort'}</label>
									<div class="col-lg-9 controls">
										<input name='sort' class='span8 form-control' type='text'/>
									</div>
								</div>
								<div class="form-group row">
									<h3 class="heading card-title col-lg-12">{lang key='wechat::wechat.main_body'}</h3>
									<div class="col-lg-11">
										{ecjia:editor content='' textarea_name='content'}
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right"></label>
									<div class="col-lg-9 controls">
										<input type="submit" value="存入素材库" class="btn btn-info" />
									</div>
								</div>
							</fieldset>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->