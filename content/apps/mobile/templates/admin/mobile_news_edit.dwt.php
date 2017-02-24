<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.mobile_news.info();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
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
			<!-- {if $mobile_news}-->
			<div class="f_l">
				<div class="mobile_news_view">
					<!-- {foreach from=$mobile_news key=key item=list}-->
						<!-- {if $key eq '0'} -->
						<div class="select_mobile_area mobile_news_main">
							<div class="show_image"><img src='{$list.image}'></div>
							<div class="item">
								<div class="default">{lang key='mobile::mobile.cover_photo'}</div>
								<h4 class='news_main_title title_show'>
									{$list.title}
								</h4>
							</div>
							<div class="edit_mask">
								<a href="javascript:void(0);"><i class="icon-pencil"></i></a>
							</div>
						</div>
						<!-- {else} -->
						<div class="select_mobile_area mobile_news_auxiliary">
							<div class="span7 news_auxiliary_title title_show">{$list.title}</div>
							<div class="span4 thumb_image"><div>{lang key='mobile::mobile.thumbnail'}</div><div class="show_image"><img src='{$list.image}'></div></div>
							<div class="edit_mask">
								<a href="javascript:void(0);"><i class="icon-pencil"></i></a>&nbsp;&nbsp;&nbsp;
								<a {if $list.id}data-toggle="ajaxremove" class="ajaxremove" data-msg="{lang key='mobile::mobile.drop_mobile_news_confirm'}" href='{RC_Uri::url("mobile/admin_mobile_news/remove", "id={$list.id}")}'{else}href="javascript:void(0);" data-toggle="remove-obj" data-parent=".mobile_news_auxiliary"{/if}><i class="icon-trash"></i></a>
							</div>
						</div>
						<!-- {/if} -->
					<!-- {/foreach} -->
					<a href="javascript:;" class="create_news" data-toggle="clone-object" data-parent=".mobile_news_auxiliary_clone" data-clone-area=".create_news" data-child=".mobile_news_editarea_clone" data-child-clone-area=".mobile_news_edit"><i class="fontello-icon-plus"></i></a>
					<!-- {if $mobile_news_status} -->
						<input type="button" value="{lang key='mobile::mobile.cancel_issue'}" class="btn btn-gebo f_l m_t15 issue" data-url="{RC_Uri::url('mobile/admin_mobile_news/unissue', "id={$mobile_news_id}")}" />
					<!-- {else} -->
						<input type="button" value="{lang key='mobile::mobile.issue'}" class="btn btn-gebo f_l m_t15 issue" data-url="{RC_Uri::url('mobile/admin_mobile_news/issue', "id={$mobile_news_id}")}" />
					<!-- {/if} -->
				</div>
			</div>
			<div class="mobile_news_edit">
				<!-- {foreach from=$mobile_news key=key item=list name=mobile}-->
				<div class="mobile_news_edit_area {if $key neq '0'}ecjiaf-dn{/if}">
					<h4 class="heading">{lang key='mobile::mobile.mobile_news'} {$key+1}</h4>
					<fieldset>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{lang key='mobile::mobile.label_title'}</label>
							<div class="controls">
								<input class='span8' type='text' name='title[{$list.id}]' value='{$list.title}' />
								<span class="input-must">{lang key='system::system.require_field'}</span> 
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{lang key='mobile::mobile.label_cover'}</label>
							<div class="controls">
								<div class="fileupload {if $list.image}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
									<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
										{if $list.image}
										<img src="{$list.image}"/>
										{/if}
									</div>
									<span class="btn btn-file">
										<span  class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
										<span  class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
										<input type='file' name='image_url[{$list.id}]' size="35"/>
										<input type="hidden" name="url" value="{$list.image}" />
									</span>
									<span class="input-must">{lang key='system::system.require_field'}</span> 
								</div>
								<!-- {if $key eq '0'} -->
								<span class="help-block">{lang key='mobile::mobile.big_photo_notice'}</span>
								<!-- {else} -->
								<span class="help-block">{lang key='mobile::mobile.small_photo_notice'}</span>
								<!-- {/if} -->
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{lang key='mobile::mobile.label_abstract'}</label>
							<div class="controls">
								<textarea name="description[{$list.id}]" cols="55" rows="6" class="span8">{$list.description}</textarea>
								<span class="input-must">{lang key='system::system.require_field'}</span> 
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{lang key='mobile::mobile.image_text_url'}</label>
							<div class="controls">
								<input name='content_url[{$list.id}]' class='span8' type='text' value='{$list.content_url}' />
								<span class="input-must">{lang key='system::system.require_field'}</span> 
							</div>
						</div>
						<div class="control-group control-group-small">
							<div class="controls">
								<input type="hidden" name="group_id[{$list.id}]" value="{$list.group_id}">
								{if $key eq 0}
								<input type="hidden" name="id" value="{$list.id}">
								{/if}
								{if $smarty.foreach.mobile.last}
								<input type="hidden" name="max_id" value="{$list.id}">
								{/if}
								<input type="hidden" name="group_id" value="{$list.groupd_id}">
								<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
							</div>
						</div>
					</fieldset>
				</div>
				<!-- {/foreach} -->
			</div>
			<!-- {else} -->
			<div class="f_l">
				<div class="mobile_news_view">
					<div class="select_mobile_area mobile_news_main">
						<div class="show_image"></div>
						<div class="item">
							<div class="default">{lang key='mobile::mobile.cover_photo'}</div>
							<h4 class='news_main_title title_show'>
								{lang key='mobile::mobile.title'}
							</h4>
						</div>
						<div class="edit_mask">
							<a href="javascript:void(0);"><i class="icon-pencil"></i></a>
						</div>
					</div>
					<a href="javascript:;" class="create_news" data-toggle="clone-object" data-parent=".mobile_news_auxiliary_clone" data-clone-area=".create_news" data-child=".mobile_news_editarea_clone" data-child-clone-area=".mobile_news_edit"><i class="fontello-icon-plus"></i></a>
				</div>
			</div>
			<div class="mobile_news_edit">
				<div class="mobile_news_edit_area">
					<h4 class="heading">{lang key='mobile::mobile.mobile_news'}&nbsp;1</h4>
					<fieldset>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{lang key='mobile::mobile.label_title'}</label>
							<div class="controls">
								<input class='span8' type='text' name='title[]' value='' />
								<span class="input-must">{lang key='system::system.require_field'}</span> 
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{lang key='mobile::mobile.label_cover'}</label>
							<div class="controls">
								<div class="fileupload {if $ads.url && $ads.type}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
									<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
									</div>
									<span class="btn btn-file">
										<span  class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
										<span  class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
										<input type='file' name='image_url[]' size="35"/>
									</span>
									<a class="btn fileupload-exists" data-dismiss="fileupload" href="javascrpt:;">{lang key='system::system.drop'}</a>
									<span class="input-must">{lang key='system::system.require_field'}</span> 
								</div>
								<span class="help-block">{lang key='mobile::mobile.big_photo_notice'}</span>
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{lang key='mobile::mobile.label_abstract'}</label>
							<div class="controls">
								<textarea name="description[]" cols="55" rows="6" class="span8"></textarea>
								<span class="input-must">{lang key='system::system.require_field'}</span> 
							</div>
						</div>
						<div class="control-group control-group-small formSep">
							<label class="control-label">{lang key='mobile::mobile.image_text_url'}</label>
							<div class="controls">
								<input name='content_url[]' class='span8' type='text' value='' />
								<span class="input-must">{lang key='system::system.require_field'}</span> 
							</div>
						</div>
						<div class="control-group control-group-small">
							<div class="controls">
								<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
							</div>
						</div>
					</fieldset>
				</div>
			</div>
			<!-- {/if} -->
		</form>
	</div>
</div>
<div class="select_mobile_area mobile_news_auxiliary mobile_news_auxiliary_clone ecjiaf-dn">
	<div class="span7 news_auxiliary_title title_show">{lang key='mobile::mobile.title'}</div>
	<div class="span4 thumb_image"><div>{lang key='mobile::mobile.thumbnail'}</div><div class="show_image"></div></div>
	<div class="edit_mask">
		<a href="javascript:void(0);"><i class="icon-pencil"></i></a>&nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" data-toggle="remove-obj" data-parent=".mobile_news_auxiliary"><i class="icon-trash"></i></a>
	</div>
</div>
<div class="mobile_news_edit_area mobile_news_editarea_clone ecjiaf-dn">
	<h4 class="heading"></h4>
	<fieldset>
		<div class="control-group control-group-small formSep">
			<label class="control-label">{lang key='mobile::mobile.label_title'}</label>
			<div class="controls">
				<input class='span8' type='text' name='title[]' value='' />
				<span class="input-must">{lang key='system::system.require_field'}</span> 
			</div>
		</div>
		<div class="control-group control-group-small formSep">
			<label class="control-label">{lang key='mobile::mobile.label_cover'}</label>
			<div class="controls">
				<div class="fileupload {if $ads.url && $ads.type}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
					<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
					</div>
					<span class="btn btn-file">
						<span  class="fileupload-new">{lang key='mobile::mobile.browse'}</span>
						<span  class="fileupload-exists">{lang key='mobile::mobile.modify'}</span>
						<input type='file' name='image_url[]' size="35"/>
					</span>
					<a class="btn fileupload-exists" data-dismiss="fileupload" href="javascrpt:;">{lang key='system::system.drop'}</a>
					<span class="input-must">{lang key='system::system.require_field'}</span> 
				</div>
				<span class="help-block">{lang key='mobile::mobile.small_photo_notice'}</span>
			</div>
		</div>
		<div class="control-group control-group-small formSep">
			<label class="control-label">{lang key='mobile::mobile.label_abstract'}</label>
			<div class="controls">
				<textarea name="description[]" cols="55" rows="6" class="span8"></textarea>
				<span class="input-must">{lang key='system::system.require_field'}</span> 
			</div>
		</div>
		<div class="control-group control-group-small formSep">
			<label class="control-label">{lang key='mobile::mobile.image_text_url'}</label>
			<div class="controls">
				<input name='content_url[]' class='span8' type='text' value='' />
				<span class="input-must">{lang key='system::system.require_field'}</span> 
			</div>
		</div>
		<div class="control-group control-group-small">
			<div class="controls">
				<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
			</div>
		</div>
	</fieldset>
</div>
<!-- {/block} -->