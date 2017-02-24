<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.adsense_edit.init();
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
				<fieldset>
					<div class="row-fluid edit-page editpage-rightbar">
						<div class="left-bar move-mod">
							<!--左边-->
							<div class="control-group formSep">
								<label class="control-label">{lang key='adsense::adsense.ad_name_lable'}</label>
								<div class="controls">
									<input type="text" name="ad_name" value="{$ads.ad_name}" size="35"/>
									<span class="input-must">{lang key='system::system.require_field'}</span>
									<br><span class="help-block">{lang key='adsense::adsense.ad_name_notic'}</span>
								</div>
							</div>
					
							{if $action eq "insert"}
							<div class="control-group formSep">
								<label class="control-label">{lang key='adsense::adsense.media_type_lable'}</label>
								<div class="controls">
									<select name="media_type" id="media_type">
										<option value='0'>{lang key='adsense::adsense.ad_img'}</option>
										<option value='1'>{lang key='adsense::adsense.ad_flash'}</option>
										<option value='2'>{lang key='adsense::adsense.ad_html'}</option>
										<option value='3'>{lang key='adsense::adsense.ad_text'}</option>
									</select>
								</div>
							</div>
							{else}
							<input type="hidden" name="media_type" value="{$ads.media_type}" />
							{/if}
					
							<div class="control-group formSep">
								<label class="control-label">{lang key='adsense::adsense.position_id_lable'}</label>
								<div class="controls">
									<select name="position_id">
			                            <option value='0'>{lang key='adsense::adsense.outside_posit'}</option>
	        							<!-- {html_options options=$position_list selected=$ads.position_id} -->
								</select>
								</div>
							</div>
							
							<div class="control-group formSep">
								<label class="control-label">{lang key='adsense::adsense.start_date_lable'}</label>
								<div class="controls">
									<input type="text" class="date" name="start_time" size="22" value="{$ads.start_time}" />
								</div>  
							</div>  
					
							<div class="control-group formSep">
								<label class="control-label">{lang key='adsense::adsense.end_date_lable'}</label>
								<div class="controls">
									<input type="text" class="date" name="end_time" size="22" value="{$ads.end_time}" />
								</div>  
							</div>  
					
							<!-- 图片 0-->
							{if $ads.media_type eq 0 OR $action eq "insert"}
							<div class="control-group">
								<div id="media_type_0">
									<div class="control-group formSep">
										<label class="control-label">{lang key='adsense::adsense.ad_link'}</label>
										<div class="controls">
											<input type="text" name="ad_link" value="{$ads.ad_link}" size="35"/>
										</div>
									</div>
									<div class="control-group formSep">
										<label class="control-label">{lang key='adsense::adsense.upfile_img'}</label>
										<div class="controls chk_radio">
											<input type="radio" name="brand_logo_type" value='0'{if !$ads.type} checked="checked"{/if} autocomplete="off" /><span>{lang key='adsense::adsense.remote_link'}</span>
											<input type="radio" name="brand_logo_type" value='1'{if $ads.type} checked="checked"{/if} autocomplete="off" /><span>{lang key='adsense::adsense.local_upfile_img'}</span>
										</div>
										<div class="controls cl_both brand_logo_type" id="show_src">
											<input class="w330" type='text' name='url_logo' size="42" value="{if !$ads.type}{$ads.ad_code}{/if}"/>
											<span class="help-block">{lang key='adsense::adsense.specify_logo'}</span>
										</div>
										<div class="controls cl_both brand_logo_type" id="show_local" style="display:none;">
											<div class="fileupload {if $ads.url && $ads.type}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">	
												<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
													{if $ads.url && $ads.type}
													<img src="{$ads.url}"/>
													{/if}
												</div>
												<span class="btn btn-file">
													<span  class="fileupload-new">{lang key='adsense::adsense.browse'}</span>
													<span  class="fileupload-exists">{lang key='adsense::adsense.modify'}</span>
													<input type='file' name='ad_img' size="35"/>
												</span>
												<a class="btn fileupload-exists" {if !$ads.url}data-dismiss="fileupload" href="javascript:;"{else}data-toggle="ajaxremove" data-msg="{lang key='adsense::adsense.confirm_remove'}" href='{url path="adsense/admin/delfile" args="id={$ads.ad_id}"}' title="{lang key='adsense::adsense.remove'}"{/if}>{lang key='adsense::adsense.remove'}</a>
											</div>
										</div>
									</div>
								</div>
							</div>
							{/if}
					
							<!-- flash 1 -->
							{if $ads.media_type eq 1 OR $action eq "insert"}
								<div id="media_type_1" style="{if $ads.media_type neq 1 OR $action eq 'insert'}display:none{/if}">
									<div class="control-group formSep">
										<label class="control-label">{lang key='adsense::adsense.upfile_flash'}</label>
										{if $ads.ad_code neq ''}
								      		<div class="t_c">
												<img class="w100 f_l" src="{RC_Uri::admin_url('statics/images/flashimg.png')}" />
											</div>
									    	<div class="ecjiaf-wwb">{lang key='adsense::adsense.flash_url'}{$ads.ad_code}</div>
											<a class="ajaxremove ecjiafc-red ecjiaf-db" data-toggle="ajaxremove" data-msg="{lang key='adsense::adsense.confirm_remove'}" href='{RC_Uri::url("adsense/admin/delfile","id={$ads.ad_id}")}' title="{lang key='adsense::adsense.remove'}">
									       	{lang key='adsense::adsense.remove'}
									        </a>
									        <input name="file_name" value="{$article.file_url}" class="hide">
										{else}
										<div class="controls">
											<div data-provides="fileupload" class="fileupload fileupload-new"><input type="hidden" value="" name="">
												<span class="btn btn-file"><span class="fileupload-new">{lang key='adsense::adsense.upload_flash_file'}</span><span class="fileupload-exists">{lang key='adsense::adsense.modify_Flash_file'}</span><input type="file" name="upfile_flash"></span>
												<span class="fileupload-preview"></span>
												<a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="index.php-uid=1&page=form_extended.html#">&times;</a>
											</div>
										</div>
										{/if}
									</div>
								</div>
							{/if}
					
							<!-- 代码2 -->
							{if $ads.media_type eq 2 OR $action eq "insert"}
							<div id="media_type_2" style="{if $ads.media_type neq 2 OR $action eq 'add'}display:none{/if}">
								<div class="control-group formSep">
									<label class="control-label">{lang key='adsense::adsense.ad_code_label'}</label>
									<div class="controls">
										<textarea name="ad_code" cols="50" rows="6" class="span10">{$ads.ad_code}</textarea>
										<span class="input-must">{lang key='system::system.require_field'}</span>
									</div>
								</div>	
							</div>									
							{/if}
					
							<!-- 文字3 -->
							{if $ads.media_type eq 3 OR $action eq "insert"}
							<div id="media_type_3" style="{if $ads.media_type neq 3 OR $action eq 'add'}display:none{/if}">
								<div class="control-group formSep">
									<label class="control-label">{lang key='adsense::adsense.ad_link'}</label>
									<div class="controls">
										<input type="text" class="span10" name="ad_link2" value="{$ads.ad_link}" size="35"/>
									</div>
								</div>	
								<div class="control-group formSep">
									<label class="control-label">{lang key='adsense::adsense.ad_code'}：</label>
									<div class="controls">
										<textarea name="ad_text" class="span10" cols="40" rows="6"  class="span10">{$ads.ad_code}</textarea>
										<span class="input-must">{lang key='system::system.require_field'}</span>
									</div>
								</div>											
							</div>						
							{/if}
							
							<div class="control-group formSep">
								<label class="control-label">{lang key='adsense::adsense.enabled'}</label>
								<div class="controls">
									 <input type="radio" name="enabled" value="1" {if $ads.enabled eq 1} checked="true" {/if} />{lang key='adsense::adsense.is_enabled'}
						        	 <input type="radio" name="enabled" value="0" {if $ads.enabled eq 0} checked="true" {/if} />{lang key='adsense::adsense.no_enabled'}
								</div>
							</div>	
							
							<div class="control-group">
					        	<div class="controls">
					        		<!-- {if $ads.ad_id} -->
					        		<input type="submit" value="{lang key='adsense::adsense.update'}" class="btn btn-gebo" />
									<input type="hidden" name="id" value="{$ads.ad_id}" />
									<input type="hidden" id="type" value="{$ads.type}" />	
									<!-- {else} -->
									<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
									<!-- {/if} --> 
							    </div>
					        </div>	    
						</div>
						<!-- 右边 -->
						<div class="right-bar move-mod">
							<div class="foldable-list move-mod-group">
								<div class="accordion-group">
									<div class="accordion-heading">
										<a class="accordion-toggle acc-in move-mod-head" data-toggle="collapse" data-target="#telescopic1"><strong>{lang key='adsense::adsense.ad_contact_info'}</strong></a>
									</div>
									<div class="accordion-body in collapse" id="telescopic1">
										<div class="accordion-inner">
											<div class="control-group control-group-small">
												<label class="control-label">{lang key='adsense::adsense.name'}</label>
												<div class="span8">
													<input name="link_man" type="text" value="{$ads.link_man}"  />
												</div>
											</div>
											
											<div class="control-group control-group-small">
												<label class="control-label">{lang key='adsense::adsense.email'}</label>
												<div class="span8">
													<input name="link_email" type="text" value="{$ads.link_email}"  />
												</div>
											</div>
											
											<div class="control-group control-group-small">
												<label class="control-label">{lang key='adsense::adsense.phone'}</label>
												<div class="span8">
													<input name="link_phone" type="text" value="{$ads.link_phone}"  />
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>				
					</div>
				</fieldset>
	    	</form>
		</div>
	</div>
</div>  
<!-- {/block} -->