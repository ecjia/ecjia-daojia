<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.response.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->

{if $errormsg}
 	<div class="alert alert-error">
        <strong>{lang key='wechat::wechat.label_notice'}</strong>{$errormsg}
    </div>
{/if}

<div>
	<h3 class="heading">
		{if $ur_here}{$ur_here}{/if}
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
	
<div class="row-fluid">
	<div class="rule_form">
		<div class="span12">
			<form class="form-horizontal" method="post" action="{$form_action}" name="theForm">
				<fieldset>
					<!-- {if !$id} -->
					<div class="add_rule_form m_b20">
						<div class="control-group formSep">
							<label class="control-label">{lang key='wechat::wechat.label_rule_name'}</label>
							<div class="controls">
								<input type="text" class="w280" name="rule_name" maxlength="60" size="30"/>
								<span class="input-must">{lang key='system::system.require_field'}</span>
								<span class="help-block">{lang key='wechat::wechat.rule_name_max'}</span>
							</div>
						</div>
						
	    				<div class="control-group formSep">
							<label class="control-label">{lang key='wechat::wechat.lable_keyword'}</label>
							<div class="controls">
								<input type="text" class="w280" name="rule_keywords" maxlength="60" size="30"/>
								<span class="input-must">{lang key='system::system.require_field'}</span>
								<span class="help-block">{lang key='wechat::wechat.more_keywords_split'}</span>
							</div>
						</div>
						
						<div class="control-group formSep">
							<label class="control-label">{lang key='wechat::wechat.lable_reply'}</label>
							<div class="controls">
								<div class="material-table span12" data-url="{url path='wechat/admin_response/get_material_list'}">
									<div class="w-box">
										<div class="w-box-content cnt_a">
											<div class="page-toolbar clearfix">
												<div class="btn-group pull-left">
													<a title="{lang key='wechat::wechat.character'}" class="btn toolbar-icon text-material"><i class="icon-pencil"></i></a>
													<a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.picture'}" class="btn toolbar-icon picture-material"><i class="icon-picture"></i></a>
													<a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.voice'}" class="btn toolbar-icon music-material"><i class="fontello-icon-mic"></i></a>
													<a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.video'}" class="btn toolbar-icon video-material"><i class="icon-facetime-video"></i></a>
													<a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.text_message'}" class="btn toolbar-icon list-material"><i class=" icon-list-alt"></i></a>
												</div>
												<span class="input-must">{lang key='system::system.require_field'}</span>
												
												<div class="text m_b10 {if $data.media_id}hidden{/if}">
													<textarea class="m_t10 span12" name="content" cols="40" rows="5"></textarea>
												</div>
											
												<div class="material_picture {if empty($data.media_id)}hidden{/if}">
													 {if $data['media']}
						                                {if $data['media']['type'] == 'voice'}
						                                    <input type='hidden' name='media_id' value="{$data['media_id']}"><img src="{$data['media']['file']}" class='img-rounded material_show' />
						                                {elseif $subscribe['media']['type'] == 'video'}
						                                    <input type='hidden' name='media_id' value="{$data['media_id']}"><img src="{$data['media']['file']}" class='img-rounded material_show' />
						                                {else}
						                                    <input type='hidden' name='media_id' value="{$data['media_id']}"><img src="{$data['media']['file']}" class='img-rounded material_show' />
						                                {/if}
						                            {/if}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="control-group">
							<div class="controls">
			                    <input type="hidden" name="content_type" value="text">
			                    <input type="submit" class="btn btn-gebo" {if $errormsg}disabled{/if} value="{lang key='wechat::wechat.add'}">
		                    </div>
	                  	</div>
					</div>
					
					<!-- {elseif $id} -->
					<div class="edit_rule_form m_b20">
						<div class="control-group formSep">
							<label class="control-label">{lang key='wechat::wechat.rule_name'}</label>
							<div class="controls">
								<input type="text" class="w280" name="rule_name" maxlength="60" size="30" value="{if $id}{$data.rule_name}{/if}"/>
								<span class="input-must">{lang key='system::system.require_field'}</span>
								<span class="help-block">{lang key='wechat::wechat.rule_name_max'}</span>
							</div>
						</div>
						
	    				<div class="control-group formSep">
							<label class="control-label">{lang key='wechat::wechat.lable_keyword'}</label>
							<div class="controls">
								<input type="text" class="w280" name="rule_keywords" maxlength="60" size="30" value="{if $id}{$data.rule_keywords_string}{/if}"/>
								<span class="input-must">{lang key='system::system.require_field'}</span>
								<span class="help-block">{lang key='wechat::wechat.more_keywords_split'}</span>
							</div>
						</div>
						
						<div class="control-group formSep">
							<label class="control-label">{lang key='wechat::wechat.lable_reply'}</label>
							<div class="controls">
								<div class="material-table span12" data-url="{url path='wechat/admin_response/get_material_list'}">
									<div class="w-box">
										<div class="w-box-content cnt_a">
											<div class="page-toolbar clearfix">
												<div class="btn-group pull-left">
													<a href="#" title="{lang key='wechat::wechat.character'}" class="btn toolbar-icon text-material"><i class="icon-pencil"></i></a>
													<a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.picture'}" class="btn toolbar-icon picture-material"><i class="icon-picture"></i></a>
													<a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.voice'}" class="btn toolbar-icon music-material"><i class="fontello-icon-mic"></i></a>
													<a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.video'}" class="btn toolbar-icon video-material"><i class="icon-facetime-video"></i></a>
													<a href="#add_material" data-toggle="modal" title="{lang key='wechat::wechat.text_message'}" class="btn toolbar-icon list-material"><i class=" icon-list-alt"></i></a>
												</div>
												<span class="input-must">{lang key='system::system.require_field'}</span>
												
												<div class="m_b10 text {if $data.media_id}hidden{/if}">
													<textarea class="span12 m_t10" name="content" cols="40" rows="5">{$data.content}</textarea>
												</div>
											
												<div class="material_picture {if empty($data.media_id)}hidden{/if}">
													 <!-- {if $data.media} -->
						                                {if $data['reply_type'] == 'voice' || $data['reply_type'] == 'video' || $data['reply_type'] == 'image'}
						                                    <input type='hidden' name='media_id' value="{$data['media_id']}"><img src="{$data['media']['file']}" class='img-rounded material_show' />
						                                	<!-- {if $data.reply_type neq image} --><div class="material_filename">{$data['media']['file_name']}</div><!-- {/if} -->
						                                {elseif $data['reply_type'] == 'news'}
						                                	<div class="wmk_grid ecj-wookmark wookmark_list material_pictures w200">
																<div class="thumbnail move-mod-group">
								                                    <div class="article_media">
								                                        <div class="article_media_title">{$data['media']['title']}</div>
								                                        <div>{$data['media']['add_time']}</div>
								                                        <div class="cover"><img src="{$data['media']['file']}" /></div>
								                                        <div class="articles_content">{$data['media']['content']}</div>
								                                    </div>
							                                    </div>
							                                </div>
							                                <input type='hidden' name='media_id' value="{$data['media_id']}">
						                                {/if}
						                            <!-- {elseif $data.medias} -->
							                            <div class="wmk_grid ecj-wookmark wookmark_list material_pictures w200">
															<div class="thumbnail move-mod-group">
																<!-- {foreach from=$data.medias key=k item=val} -->
																	{if $k == 0}
																	<div class="article">
								                                		<div class="cover">
								                                			<img src="{$val.file}" />
								                                			<span>{$val.title}</span>
								                                		</div>
																	</div>
																	{else}
																	<div class="article_list">
																	 	<div class="f_l">{if $val.title}{$val.title}{else}{lang key='wechat::wechat.no_title'}{/if}</div>
								                               	 		<img src="{$val.file}" class="pull-right material_content" />
																	</div>
																	{/if}
								                                <!-- {/foreach} -->
										               		</div>
										               		<input type='hidden' name='media_id' value="{$data.media_id}">
								                        </div>
						                            <!-- {/if} -->
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="control-group">
							<div class="controls">
			                    <input type="hidden" name="content_type" value="{$data['reply_type']}">
			                    <input type="hidden" name="id" value="{$data.id}">
			                    <input type="submit" class="btn btn-gebo" value="{lang key='wechat::wechat.update'}">
		                    </div>
	                  	</div>
	            	</div>
	            	<!-- {/if} -->
				</fieldset>
			</form>
		</div>
	</div>
</div>

<div class="modal hide fade keywords_material" id="add_material">
	<div class="modal-header">
		<button class="close" data-dismiss="modal">×</button>
		<h3>{lang key='wechat::wechat.select_material'}</h3>
	</div>

	<div class="modal-body keywords_modal_body">
		<div class="row-fluid">
			<div class="span12 form-horizontal material_choose" data-url="{url path='wechat/admin_response/get_material_info'}">
				<div class="material_choose_list">
					<div class="material_select m_0">
						<table class="table smpl_tbl dataTable m_b0">
							<thead>
							</thead>
							<tbody class="material_select_tbody">
							</tbody>
						</table>
					</div>
				</div>
				<div class="control-group m_t10 m_b0 hide">
					<div class="t_c">
						<input type="button" class="btn btn-gebo material_verify" value="{lang key='wechat::wechat.ok'}" />
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->