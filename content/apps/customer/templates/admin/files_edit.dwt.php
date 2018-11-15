<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.contract_doc.init();
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
<div class="row-fluid edit-page editpage-rightbar" >
    <div class="span12">
        <form class="form-horizontal" method="post" action="{$form_action}" name="theForm"  data-edit-url="{RC_Uri::url('customer/admin/edit')}" >
            <fieldset class="">
                <div class="left-bar move-mod ui-sortable">
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}文档名称：{/t}</label>
                        <div class="controls">
                            <input type="text" class="span8" name="doc_name" value="{$doc_info.doc_name}" />
                            <span class="input-must">*</span>
                        </div>
                    </div> 
                    <div class="control-group control-group-small">
                        <label class="control-label">{t}文档类型：{/t}</label>
                        <div class="controls">
                            <select class="span8" name="doc_category">
    			                <!-- {foreach from=$doc_category_list item=doc } -->
    							<option value="{$doc.doc_type_id}" {if $doc.doc_type_id == $doc_info.doc_category }selected{/if}>{$doc.doc_type_name}</option>
    							<!-- {/foreach} -->
    						</select>
                        </div>
                    </div>
                    <div class="control-group control-group-small">
						<label class="control-label">{t}上传文件：{/t}</label>
						<div class="controls">
								{if $doc_info.doc_path neq ''}
									<div class="t_c">
										<a href="{$doc_info.image_url}" target="_blank" title="点击预览"><img class="w100 f_l" src="{$doc_info.image_url} " /></a>
									</div>
							    	<div class="h100 ecjiaf-wwb">{t}文件地址：{/t}{$doc_info.doc_path}</div>
									<a class="ajaxremove ecjiafc-red ecjiaf-db" data-toggle="ajaxremove" data-msg="{t}您确定要删除该合同附件吗？{/t}" href='{RC_Uri::url("customer/admin/files_delfile","id={$doc_info.doc_id}&customer_id={$doc_info.customer_id}")}' title="{t}删除附件{/t}">
							        {t}删除文件{/t}
							        </a>
							        <input name="file_name" value="{$doc_info.doc_path}" class="hide">
								{else}
									<div data-provides="fileupload" class="fileupload fileupload-new"><input type="hidden" value="" name="">
										<span class="btn btn-file"><span class="fileupload-new">上传文件</span><span class="fileupload-exists">修改文件</span><input type="file" name="file"></span>
										<span class="fileupload-preview"></span>
										<a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="index.php-uid=1&page=form_extended.html#">&times;</a>
									</div>
								{/if}
						</div>
					</div>
                    <div class="control-group control-group-small" >
                        <label class="control-label">{t}文档描述：{/t}</label>
                        <div class="controls">
                            <textarea class="span10" rows="3" cols="40" name="doc_summary" style="height:80px">{$doc_info.doc_summary}</textarea>
                        </div>
                    </div>
                    <div class="control-group control-group-small" >
                        <label class="control-label"></label>
                        <input type="hidden" name="id" value="{$id}" />
    					<input type="hidden" name="doc_id" value="{$doc_info.doc_id}" />
    					<input type="hidden" name="types" value="{$type}"/>
     					<input type="hidden" name="page" value="{$page}"/>
        				<input type="hidden" name="keywords" value="{$keywords}"/>
    					<input type="hidden" name="statu" value="{$status}" />
    					<button class="btn btn-gebo"  type="submit">{if $doc_id !=''}更新{else}发布{/if}</button>
                    </div>
                    
                </div>

            </fieldset>
        </form>
    </div>
</div>

<!-- {/block} -->
