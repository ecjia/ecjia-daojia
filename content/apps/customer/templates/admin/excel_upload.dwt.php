<?php defined('IN_ECJIA') or exit('No permission resources.'); ?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.excel_upload.init();
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
<div class="alert alert-info" style=" line-height: 150%">	
	提示：<br>
	1. 系统当前只支持xls文件的数据导入。<b><a href="{$download_url}">下载Excel模板</a></b> <br>
    2. 请按系统提供的EXCEL模板，调整对应的数据，第一行的字段名称是固定的，更改后，系统将无法识别，也不可删除。<br>
    3. 导入文件的第一行将视为字段名，不会被导入。<br>
    4. 日期格式必须是2011-01-01或2011-01-01 08:10:10格式的，否则系统将按空值或当前日期处理。<br>
    5. 数值型格式必须合法，否则系统将按0处理。<br>
    6. 客户名称为必填字段，请确保在导入时存在有效值。<br>
    7. 合同开始日期和结束日期，如果不填，默认为1900-01-01。<br>
    8. 一次性导入的数据量，不要超过500条数据，以避免因网络故障导致的数据库相关问题。 <br>
</div>
<div class="row-fluid edit-page" >
    <div class="span12">
        <form class="form-horizontal" method="post" action="{$form_action}" name="theForm"  data-edit-url="{RC_Uri::url('customer/admin/edit&status')}" >
            <fieldset class="">
                <div class="move-mod ui-sortable">
                    <div class="control-group formSep" >
                        <label class="control-label">{t}选择EXCEL文件：{/t}</label>
						<div data-provides="fileupload" class="fileupload fileupload-new controls">
							<span class="btn btn-file"><span class="fileupload-new">上传文件</span><span class="fileupload-exists">修改文件</span><input type="file" name="file"></span>
							<span class="fileupload-preview"></span>
							<a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="">&times;</a>
							<span class="input-must">*</span>
						</div>
                    </div>
                    <div class="control-group" >
                       <label  class="control-label"> </label>
					   <div class="controls">
							<button class="btn btn-gebo" type="submit">开始导入</button>
					   </div>
                    </div>
                    <div class="control-group" >
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<!-- {/block} -->
