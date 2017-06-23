<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.merchant_adsense_edit.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}<a href="{$action_link.href}" class="btn btn-primary data-pjax"><i class="fa fa-reply"></i> {$action_link.text}</a>{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="tab-content">
            <div class="panel">
                <div class="panel-body">
                    <div class="form">
                        <form id="form-privilege" class="form-horizontal" name="theForm" action="{$form_action}" method="post" >
                            <div class="col-lg-8" style="padding-left:0px;">
                                <fieldset>
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">广告名称：</label>
                                        <div class="controls col-lg-8">
                                            <input class="form-control" type="text" name="ad_name" id="ad_name" value="{$ads.ad_name}" />
                                            <span class="help-block">广告名称只是作为辨别多个广告条目之用，并不显示在广告中。</span>
                                        </div>
                                        <span class="input-must">{lang key='system::system.require_field'}</span>
                                    </div>
                                    
                                    {if $action eq "insert"}
	                                    <div class="form-group">
	                                        <label class="control-label col-lg-3">媒介类型：</label>
	                                        <div class="controls col-lg-8">
	                                            <select name="media_type" id="media_type" class="form-control" >
													<option value='0'>图片</option>
													<option value='2'>代码</option>
													<option value='3'>文字</option>
												</select>
	                                        </div>
	                                    </div>
                                    {/if}
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">广告位置：</label>
                                        <div class="controls col-lg-8">
                                           <select name="position_id" class="form-control">
					                            <option value='0'>站外广告</option>
			        							<!-- {html_options options=$position_list selected=$ads.position_id} -->
										   </select>
                                        </div>
                                    </div>
                                    
                                    <!-- 媒介类型为图片0 -->
									{if $ads.media_type eq 0 OR $action eq "insert"}
									<div id="media_type_0">
				                      	<div class="form-group">
	                                        <label class="control-label col-lg-3">广告链接：</label>
	                                        <div class="controls col-lg-8">
	                                            <input class="form-control" type="text" name="ad_link" id="ad_link" value="{$ads.ad_link}" />
	                                        </div>
	                                    </div>
	                                    
	                                    <div class="form-group">
				                            <label class="control-label col-lg-3">{t}上传图片：{/t}</label>
				                            <div class="col-lg-6">
				                                <div class="fileupload fileupload-{if $ads.url}exists{else}new{/if}" data-provides="fileupload">
				                                    {if $ads.url}
					                                    <div class="fileupload-{if $ads.url}exists{else}new{/if} thumbnail" style="max-width: 60px;">
					                                        <img src="{$ads.url}" alt="广告图片" style="width:50px; height:50px;"/>
					                                    </div>
				                                    {/if}
				                                    <div class="fileupload-preview fileupload-{if $ads.url}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
				                                    <span class="btn btn-primary btn-file btn-sm">
				                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
				                                        <span class="fileupload-exists"> 修改</span>
				                                        <input type="file" class="default" name="ad_img" />
				                                    </span>
				                                    <a class="btn btn-danger btn-sm fileupload-exists" {if $ads.url}data-toggle="ajaxremove"{else}data-dismiss="fileupload"{/if} href="{url path='merchant/merchant/drop_file' args="code=ad_code"}" >删除</a>
				                                </div>
				                            </div>
				                        </div>
				                    </div>
			                        {/if}
			                        
			                        <!-- 代码2 -->
									{if $ads.media_type eq 2 OR $action eq "insert"}
									<div id="media_type_2" style="{if $ads.media_type neq 2 OR $action eq 'insert'}display:none{/if}">
										<div class="form-group">
											<label class="control-label col-lg-3">广告代码：</label>
											<div class="col-lg-8">
												<textarea class="form-control" name="ad_code" cols="50" rows="6">{$ads.ad_code}</textarea>
											</div>
										</div>	
									</div>									
									{/if}
							
									<!-- 文字3 -->
									{if $ads.media_type eq 3 OR $action eq "insert"}
									<div id="media_type_3" style="{if $ads.media_type neq 3 OR $action eq 'insert'}display:none{/if}">
										<div class="form-group">
											<label class="control-label col-lg-3">广告链接：</label>
											<div class="col-lg-8">
												<input class="form-control" type="text" name="ad_link2" value="{$ads.ad_link}"/>
											</div>
										</div>	
										
										<div class="form-group">
											<label class="control-label col-lg-3">广告内容：</label>
											<div class="col-lg-8">
												<textarea class="form-control"  name="ad_text" cols="50" rows="6" >{$ads.ad_code}</textarea>
											</div>
										</div>											
									</div>						
									{/if}
			                        
			                        <div class="form-group">
				                        <label class="control-label col-lg-3">投放平台：</label>
				                        <div class="col-lg-8 m_t5">
				                         <!-- {foreach from=$client_list key=key item=val} -->
											<input type="checkbox" name="show_client[]" value="{$val}" id="{$val}" {if in_array($val, $ads.show_client)}checked="true"{/if}/> <label for="{$val}">{$key}</label>
										 <!-- {/foreach} -->
                                       	</div>
			                      	</div>
			                      	
			                      	<div class="form-group">
                                        <label class="control-label col-lg-3">开始日期：</label>
                                        <div class="controls col-lg-8">
                                        	<input class="form-control date"  name="start_time" type="text" value="{$ads.start_time}"/>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">结束日期：</label>
                                        <div class="controls col-lg-8">
                                        	<input class="form-control date"  name="end_time" type="text" value="{$ads.end_time}"/>
                                        </div>
                                    </div>
			                      	
                      	            <div class="form-group">
				                        <label class="control-label col-lg-3">是否开启：</label>
				                       	<div class="controls col-lg-8">
			                                <input id="open" name="enabled" value="1" type="radio" {if $ads.enabled eq 1} checked="true" {/if}>
			                                <label for="open">开启</label>
			                                <input id="close" name="enabled" value="0" type="radio" {if $ads.enabled eq 0} checked="true" {/if}>
			                                <label for="close">关闭</label>
			                            </div>
			                      	</div>
                                    
                                    <div class="form-group">
                                        <label class="control-label col-lg-3">排序：</label>
                                        <div class="controls col-lg-8">
                                            <input class="form-control" type="text" name="sort_order" id="sort_order" value="{$ads.sort_order}" />
                                        </div>
                                    </div>
			                      	
                                    <div class="form-group">
                                        <div class="col-lg-offset-3 col-lg-8">
                                        	<input type="hidden" name="id" value="{$ads.ad_id}" />
											<input type="hidden" name="show_client_value" value="{$show_client}" />
											<input type="hidden" id="type" value="{$ads.type}" />	
                                           	{if $ads.position_id}
							        			<input type="submit" value="更新" class="btn btn-info" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							        		{else}
							        			<input type="submit" value="确定" class="btn btn-info" />
							        		{/if}
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-lg-4">
                                <fieldset>
                                    <div class="panel-group">
							            <div class="panel panel-info">
							                <div class="panel-heading">
							                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseNineinfo" class="accordion-toggle">
							                        <span class="glyphicon"></span>
							                        <h4 class="panel-title">广告位信息</h4>
							                    </a>
							                </div>
							                <div id="collapseNineinfo" class="panel-collapse collapse in">
						              			<div class="panel-body">
						              				<div class="form-group">
														<label class="control-label col-lg-4">名称：</label>
														<div class="col-lg-8 l_h30">{$position_data.position_name}<br>{if $position_data.position_code}（{$position_data.position_code}）{else}（无）{/if}</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-lg-4">显示数量：</label>
														<div class="col-lg-8 l_h30">{$position_data.max_number}</div>
													</div>
													
													<div class="form-group">
														<label class="control-label col-lg-4">建议大小：</label>
														<div class="col-lg-8 l_h30">{$position_data.ad_width} x {$position_data.ad_height}</div>
													</div>
			                                    </div>
					              			</div>
						        		</div>
					        		</div>
					        		
					        		<div class="panel-group">
							            <div class="panel panel-info">
							                <div class="panel-heading">
							                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseNine" class="accordion-toggle">
							                        <span class="glyphicon"></span>
							                        <h4 class="panel-title">广告联系人信息</h4>
							                    </a>
							                </div>
							                <div id="collapseNine" class="panel-collapse collapse in">
						              			<div class="panel-body">
			                                        <div class="form-group">
							              				<label class="control-label col-lg-4">姓名：</label>
							              				<div class="col-lg-8">
							                            	<input type="text" class="form-control" name="link_man" value="{$ads.link_man}"  />
							                          	</div>
							              			</div>
							              			
							              			<div class="form-group">
							              				<label class="control-label col-lg-4">Email：</label>
							              				<div class="col-lg-8">
							                            	<input type="text"  class="form-control" name="link_email" value="{$ads.link_email}" />
							                          	</div>
							              			</div>
							              			
							              			<div class="form-group">
							              				<label class="control-label col-lg-4">电话：</label>
							              				<div class="col-lg-8">
							                          		<input type="text" class="form-control" name="link_phone" value="{$ads.link_phone}" />
							                          	</div>
							              			</div>
			                                    </div>
					              			</div>
						        		</div>
					        		</div>
                                </fieldset>
                            </div>
                         </form>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- {/block} -->
