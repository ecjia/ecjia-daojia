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
									<div class="default">{t domain="toutiao"}封面图片{/t}</div>
									<h4 class='news_main_title title_show'>{t domain="toutiao"}标题{/t}</h4>
								</div>
								<div class="edit_mask">
									<a href="javascript:void(0);"><i class="fa fa-edit"></i></a>
								</div>
							</div>
						</div>
					</div>
					<div class="mobile_news_edit">
						<div class="mobile_news_edit_area">
							<h4 class="heading new_heading">{t domain="toutiao"}图文素材{/t}1</h4>
							<fieldset>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{t domain="toutiao"}标题：{/t}</label>
									<div class="col-lg-9 controls">
										<input class="span8 form-control" type="text" name="title" value='' />
									</div>
									<span class="input-must">*</span>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{t domain="toutiao"}封面：{/t}</label>
									<div class="col-lg-9 controls">
										<div class="fileupload fileupload-new" data-provides="fileupload">
											<div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
											<span class="btn btn-primary btn-file btn-sm">
												<span class="fileupload-new"><i class="fa fa-paper-clip"></i>{t domain="toutiao"}浏览{/t}</span>
												<span class="fileupload-exists"> {t domain="toutiao"}修改{/t}</span>
												<input type="file" class="default" name="image" />
											</span>
											<a class="btn btn-danger btn-sm fileupload-exists" data-dismiss="fileupload" href="" >{t domain="toutiao"}删除{/t}</a>
											<span class="input-must">*</span>
										</div>
										<span class="help-block">{t domain="toutiao"}（大图片建议尺寸：900像素 * 500像素）{/t}</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{t domain="toutiao"}摘要：{/t}</label>
									<div class="col-lg-9 controls">
										<textarea name="description" cols="55" rows="6" class="span8 form-control"></textarea>
										<span class="help-block">{t domain="toutiao"}选填，如果不填写会默认抓取正文前54个字{/t}</span>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right">{t domain="toutiao"}原文链接：{/t}</label>
									<div class="col-lg-9 controls">
										<input name='content_url' class='span8 form-control' type='text' value='{t domain="toutiao"}http://{/t}' />
									</div>
								</div>
								<div class="form-group row sort_form">
									<label class="col-lg-2 label-control text-right">{t domain="toutiao"}排序：{/t}</label>
									<div class="col-lg-9 controls">
										<input name='sort' class='span8 form-control' type='text'/>
									</div>
								</div>
								<div class="form-group row">
									<h3 class="heading card-title col-lg-12">{t domain="toutiao"}正文{/t}</h3>
									<div class="col-lg-11">
										{ecjia:editor content='' textarea_name='content'}
									</div>
								</div>
								<div class="form-group row">
									<label class="col-lg-2 label-control text-right"></label>
									<div class="col-lg-9 controls">
										<input type="submit" value='{t domain="toutiao"}存入素材库{/t}' class="btn btn-info" />
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