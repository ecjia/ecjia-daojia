<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.edit.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		{if $ur_here}{$ur_here}{/if}
		{if $action_link}
		<a href="{$action_link.href}" class="btn data-pjax plus_or_reply"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>

<div class="row-fluid ">
	<div class="span12">
		<form class="form-horizontal" name="theForm" action="{$form_action}" method="post"  enctype="multipart/form-data" >
			<fieldset>
			<div class="control-group formSep">
				<label class="control-label">{t domain="friendlink"}链接名称：{/t}</label>
				<div class="controls ">
					<input class="w350" name="link_name" type="text" value="{$link.link_name}" size="40" class="span4" />
					<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
				</div>
			</div>

            <div class="control-group formSep">
				<label class="control-label">{t domain="friendlink"}链接地址：{/t}</label>
				<div class="controls">
					<input class="w350" name="link_url" type="text" value="{$link.link_url}" size="40" class="span4" />
					<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
				</div>
			</div>

			<div class="control-group formSep">
				<label class="control-label">{t domain="friendlink"}链接LOGO：{/t}</label>
				<div class="controls chk_radio">
					<div class="fileupload {if $link.url && $link.type}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
						<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;">
							{if $link.url && $link.type}
							<img src="{$link.url}" alt='{t domain="friendlink"}图片预览{/t}' />
							{/if}
						</div>
						<span class="btn btn-file">
							<span class="fileupload-new">{t domain="friendlink"}浏览{/t}</span>
							<span class="fileupload-exists">{t domain="friendlink"}修改{/t}</span>
							<input type='file' name='link_img' size="35"/>
						</span>
						<a class="btn fileupload-exists" {if !$link.url && !$link.type}data-dismiss="fileupload" href="javascript:;"{else}data-toggle="ajaxremove" data-msg='{t domain="friendlink"}您确定要删除该友情链接LOGO吗？{/t}' href='{url path="friendlink/admin/remove_logo" args="id={$link.link_id}"}' title='{t domain="friendlink"}删除{/t}'{/if}>{t domain="friendlink"}删除{/t}</a>
					</div>
				</div>
			</div>

			<div class="control-group formSep">
				<label class="control-label">{t domain="friendlink"}排序：{/t}</label>
				<div class="controls">
                    <!-- {if $link.show_order} -->
						<input class="w350" name="show_order" type="text"  value="{$link.show_order}" />
                    <!-- {else} -->
                        <input class="w350" name="show_order" type="text"  value="50" />
                    <!-- {/if} -->
			    </div>
			</div>

			<div class="control-group">
	        	<div class="controls">
					<input type="hidden" name="id" value="{$link.link_id}" />
					<input type="hidden" id="type" value="{$link.type}" />
					<input class="btn btn-gebo" type="submit" value='{t domain="friendlink"}确定{/t}'/>
			    </div>
			</div>
		</form>
		</fieldset>
	</div>
</div>
<!-- {/block} -->