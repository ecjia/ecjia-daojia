<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
ecjia.merchant.mh_shortcut.shortcut_info();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">
        <!-- {if $ur_here}{$ur_here}{/if} -->
        {if $action_link}
        	<a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a" style="float:right;margin-top:-3px;"><i class="fa fa-reply"></i> {$action_link.text}</a>
        {/if}
        </h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="tab-content">
            <div class="panel">
                <div class="panel-body">
                    <div class="form">
                        <form class="form-horizontal"  name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
                                <fieldset>
                                	<div class="form-group">
                                		{if !$data.ad_code}
										<label class="control-label col-lg-2">{t}上传图片：{/t}</label>
										<div class="col-lg-6">
											 <div class="fileupload fileupload-{if $data.ad_code}exists{else}new{/if}" data-provides="fileupload">
												<div class="fileupload-preview fileupload-{if $data.ad_code}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
												<span class="btn btn-primary btn-file btn-sm">
													<span class="fileupload-new">浏览</span>
			                                        <span class="fileupload-exists"> 修改</span>
													<input type='file' name='ad_code' class="default"/>
												</span>
												 <a class="btn btn-danger btn-sm fileupload-exists" {if $data.ad_code}data-toggle="ajaxremove"{else}data-dismiss="fileupload"{/if} href="{url path='merchant/merchant/drop_file' args="code=ad_code"}" >删除</a>
												<span class="input-must"><span class="require-field" style="color:#FF0000;">*</span></span>
												<span class="help-block">此模板的图片标准宽度为：{$data.ad_width}px 标准高度为：{$data.ad_height}px</span>
											</div>
										</div>
										{else}
										<label class="control-label col-lg-2">图片预览：</label>
										<div class="col-lg-6">
											 <div class="fileupload fileupload-{if $data.ad_code}exists{else}new{/if}" data-provides="fileupload">
												<img class="w600 h300"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$data.ad_code}"><br><br>
												图片地址： {$data.ad_code}<br><br>
												<div class="fileupload-preview fileupload-{if $data.ad_code}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
												<span class="btn btn-primary btn-file btn-sm">
													<span class="fileupload-new">更换图片</span>
			                                        <span class="fileupload-exists"> 修改</span>
													<input type='file' name='ad_code' class="default" />
												</span>
												<span class="input-must"><span class="require-field" style="color:#FF0000;">*</span></span>
												<span class="help-block">此模板的图片标准宽度为：{$data.ad_width}px 标准高度为：{$data.ad_height}px</span>
											</div>
										</div>
										{/if}
			                        </div>
                                	
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">图片链接：</label>
                                        <div class="controls col-lg-6">
                                            <input class="form-control" type="text" name="ad_link" id="ad_link" value="{$data.ad_link}"  />
                                        </div>
                                        <span class="input-must">{lang key='system::system.require_field'}</span>
                                    </div>
                                    
                                   	<div class="form-group">
				                        <label class="control-label col-lg-2">图片说明：</label>
				                        <div class="controls col-lg-6">
				                          <textarea class="form-control" id="ad_name" name="ad_name">{$data.ad_name}</textarea>
				                        </div>
			                      	</div>
			                      	
                      	       		<div class="form-group">
				                        <label class="control-label col-lg-2">投放平台：</label>
				                        <div class="col-lg-6 m_t5">
				                         <!-- {foreach from=$client_list key=key item=val} -->
											<input type="checkbox" name="show_client[]" value="{$val}" id="{$val}" {if in_array($val, $data.show_client)}checked="true"{/if}/> <label for="{$val}">{$key}</label>
										 <!-- {/foreach} -->
                                       	</div>
			                      	</div>
			                      	
                      	            <div class="form-group">
				                        <label class="control-label col-lg-2">是否开启：</label>
				                       	<div class="controls col-lg-6">
			                                <input id="open" name="enabled" value="1" type="radio" {if $data.enabled eq 1} checked="true" {/if}>
			                                <label for="open">开启</label>
			                                <input id="close" name="enabled" value="0" type="radio" {if $data.enabled eq 0} checked="true" {/if}>
			                                <label for="close">关闭</label>
			                            </div>
			                      	</div>
			                      	
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">排序：</label>
                                        <div class="controls col-lg-6">
                                            <input class="form-control" type="text" name="sort_order" id="sort_order" value="{$data.sort_order}" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-lg-offset-2 col-lg-9">
                                        	  <input type="hidden" name="id" value="{$data.ad_id}" />
											  <input type="hidden" name="position_id" value="{$position_id}" />
											  <input type="hidden" name="show_client_value" value="{$show_client}" />
                                              <button class="btn btn-info" type="submit">确定</button>
                                        </div>
                                    </div>
                                </fieldset>
                           </form>
                        </div>
                   </div>
              </div>
          </div>
     </div>
 </div>
<!-- {/block} -->