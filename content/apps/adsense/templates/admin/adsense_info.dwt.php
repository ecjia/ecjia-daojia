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
								<label class="control-label">{t domain="adsense"}广告名称：{/t}</label>
								<div class="controls">
									<input type="text" name="ad_name" value="{$ads.ad_name}" size="35"/>
									<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
									<span class="help-block">{t domain="adsense"}广告名称只是作为辨别多个广告条目之用，并不显示在广告中{/t}</span>
								</div>
							</div>
					
							{if $action eq "insert"}
								<div class="control-group formSep">
									<label class="control-label">{t domain="adsense"}媒介类型：{/t}</label>
									<div class="controls">
										<select name="media_type" id="media_type">
											<option value='0'>{t domain="adsense"}图片{/t}</option>
											<option value='2'>{t domain="adsense"}代码{/t}</option>
											<option value='3'>{t domain="adsense"}文字{/t}</option>
										</select>
									</div>
								</div>
							{else}
								<input type="hidden" name="media_type" value="{$ads.media_type}" />
							{/if}
					
							<div class="control-group formSep">
								<label class="control-label">{t domain="adsense"}广告位置：{/t}</label>
								<div class="controls">
									<select name="position_id">
			                            <option value='0'>{t domain="adsense"}站外广告{/t}</option>
	        							<!-- {html_options options=$position_list selected=$ads.position_id} -->
								</select>
								</div>
							</div>
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="adsense"}开始日期：{/t}</label>
								<div class="controls">
									<input type="text" class="date" name="start_time" size="22" value="{$ads.start_time}" />
								</div>  
							</div>  
					
							<div class="control-group formSep">
								<label class="control-label">{t domain="adsense"}结束日期：{/t}</label>
								<div class="controls">
									<input type="text" class="date" name="end_time" size="22" value="{$ads.end_time}" />
								</div>  
							</div>  
					
							<!-- 图片 0-->
							{if $ads.media_type eq 0 OR $action eq "insert"}
							<div id="media_type_0">
								<div class="control-group formSep">
									<label class="control-label">{t domain="adsense"}广告链接：{/t}</label>
									<div class="controls">
										<input type="text" name="ad_link"  value="{$ads.ad_link}" size="35"/>
									</div>
								</div>
								
								<div class="control-group formSep">
									<label class="control-label">{t domain="adsense"}上传图片：{/t}</label>
									<div class="controls">
										<div class="fileupload {if $ads.url}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
											<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
												{if $ads.url}
												<img src="{$ads.url}"/>
												{/if}
											</div>
											<span class="btn btn-file">
											<span class="fileupload-new">{t domain="adsense"}浏览{/t}</span>
											<span class="fileupload-exists">{t domain="adsense"}修改{/t}</span>
											<input type='file' name='ad_img' size="35"/>
											</span>
											<a class="btn fileupload-exists" {if !$ads.url} data-dismiss="fileupload" href="javascript:;"{else}data-toggle="ajaxremove" data-msg='{t domain="adsense"}你确认要删除该广告图片吗？{/t}' href='{url path="adsense/admin/delfile" args="ad_id={$ads.ad_id}&position_id={$ads.position_id}&show_client={$show_client}"}' title='{t domain="adsense"}删除{/t}'{/if}>{t domain="adsense"}删除{/t}</a>
										</div>
									</div>
								</div>
							</div>
							{/if}

							<!-- 代码2 -->
							{if $ads.media_type eq 2 OR $action eq "insert"}
							<div id="media_type_2" style="{if $ads.media_type neq 2 OR $action eq 'add'}display:none{/if}">
								<div class="control-group formSep">
									<label class="control-label">{t domain="adsense"}广告代码：{/t}</label>
									<div class="controls">
										<textarea name="ad_code" cols="50" rows="6">{$ads.ad_code}</textarea>
									</div>
								</div>	
							</div>									
							{/if}
					
							<!-- 文字3 -->
							{if $ads.media_type eq 3 OR $action eq "insert"}
							<div id="media_type_3" style="{if $ads.media_type neq 3 OR $action eq 'add'}display:none{/if}">
								<div class="control-group formSep">
									<label class="control-label">{t domain="adsense"}广告链接：{/t}</label>
									<div class="controls">
										<input type="text" name="ad_link2" value="{$ads.ad_link}"/>
									</div>
								</div>	
								<div class="control-group formSep">
									<label class="control-label">{t domain="adsense"}广告内容：{/t}</label>
									<div class="controls">
										<textarea name="ad_text" cols="50" rows="6" >{$ads.ad_code}</textarea>
									</div>
								</div>											
							</div>						
							{/if}
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="adsense"}投放平台：{/t}</label>
			  					<div class="controls chk_radio">
			  						 <!-- {foreach from=$client_list key=key item=val} -->
										<input type="checkbox" name="show_client[]" value="{$val}" {if in_array($val, $ads.show_client)}checked="true"{/if}/>{$key}
									 <!-- {/foreach} -->
								</div>
							</div>
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="adsense"}启用{/t}</label>
								<div class="controls">
									 <input type="radio" name="enabled" value="1" {if $ads.enabled eq 1} checked="true" {/if} />{t domain="adsense"}开启{/t}
						        	 <input type="radio" name="enabled" value="0" {if $ads.enabled eq 0} checked="true" {/if} />{t domain="adsense"}关闭{/t}
								</div>
							</div>	
							
							<div class="control-group formSep">
								<label class="control-label">{t domain="adsense"}排序：{/t}</label>
								<div class="controls">
									<input  name="sort_order" type="text" value="{if $ads.sort_order}{$ads.sort_order}{else}50{/if}" />
								</div>
							</div>
							
							<div class="control-group">
					        	<div class="controls">
					        		<!-- {if $ads.ad_id} -->
					        		<input type="submit" value='{t domain="adsense"}更新{/t}' class="btn btn-gebo" />
									<input type="hidden" name="id" value="{$ads.ad_id}" />
									<input type="hidden" name="show_client_value" value="{$show_client}" />
									<input type="hidden" id="type" value="{$ads.type}" />	
									<!-- {else} -->
									<input type="submit" value='{t domain="adsense"}确定{/t}' class="btn btn-gebo" />
									<!-- {/if} --> 
							    </div>
					        </div>	    
						</div>
						<!-- 右边 -->
						<div class="right-bar move-mod">
							<div class="foldable-list move-mod-group">
								<div class="accordion-group">
									<div class="accordion-heading">
										<a class="accordion-toggle acc-in move-mod-head" data-toggle="collapse" data-target="#position_data"><strong>{t domain="adsense"}广告位信息{/t}</strong></a>
									</div>
									<div class="accordion-body in collapse" id="position_data">
										<div class="accordion-inner">
											<div class="control-group control-group-small">
												<label class="control-label">{t domain="adsense"}名称：{/t}</label>
												<div class="span6 l_h30">{$position_data.position_name}<br>{if $position_data.position_code}（{$position_data.position_code}）{else}（无）{/if}</div>
											</div>
											
											<div class="control-group control-group-small">
												<label class="control-label">{t domain="adsense"}所在城市：{/t}</label>
												<div class="span6 l_h30">{$position_data.city_name}</div>
											</div>
											
											<div class="control-group control-group-small">
												<label class="control-label">{t domain="adsense"}显示数量：{/t}</label>
												<div class="span6 l_h30">{$position_data.max_number}</div>
											</div>
											
											<div class="control-group control-group-small">
												<label class="control-label">{t domain="adsense"}建议大小：{/t}</label>
												<div class="span6 l_h30">{$position_data.ad_width} x {$position_data.ad_height}</div>
											</div>
										</div>
									</div>
								</div>
								
								<div class="accordion-group">
									<div class="accordion-heading">
										<a class="accordion-toggle acc-in move-mod-head" data-toggle="collapse" data-target="#telescopic1"><strong>{t domain="adsense"}广告联系人信息{/t}</strong></a>
									</div>
									<div class="accordion-body in collapse" id="telescopic1">
										<div class="accordion-inner">
											<div class="control-group control-group-small formSep">
												<label class="control-label">{t domain="adsense"}姓名：{/t}</label>
												<div class="span8">
													<input name="link_man" type="text" value="{$ads.link_man}"  />
												</div>
											</div>
											
											<div class="control-group control-group-small formSep">
												<label class="control-label">{t domain="adsense"}Email：{/t}</label>
												<div class="span8">
													<input name="link_email" type="text" value="{$ads.link_email}"  />
												</div>
											</div>
											
											<div class="control-group control-group-small">
												<label class="control-label">{t domain="adsense"}电话：{/t}</label>
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