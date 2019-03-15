<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.store_category.init();
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
		<form class="form-horizontal" method="post" action="{$form_action}" name="theForm" enctype="multipart/form-data" data-edit-url="{RC_Uri::url('seller/admin_store_category/edit')}">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="store"}分类名称：{/t}</label>
					<div class="controls">
						<input class="w350" type='text' name='cat_name' maxlength="20" value='{$cat_info.cat_name|escape:html}' size='27'/>
						<span class="input-must">*</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="store"}上级分类：{/t}</label>
					<div class="controls">
						<select class="w350" name="store_cat_id">
							<option value="0">{t domain="store"}顶级分类{/t}</option>
							<!-- {$cat_select} -->
						</select>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="store"}排序：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name='sort_order' value='{if $cat_info.sort_order}{$cat_info.sort_order}{else}50{/if}' size="12"/>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="store"}是否显示：{/t}</label>
					<div class="controls">
						<div id="info-toggle-button">
			                <input class="nouniform" name="is_show" type="checkbox"  {if $cat_info.is_show eq 1}checked="checked"{/if}  value="1"/>
			            </div>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="store"}分类图片：{/t}</label>
					<div class="controls">
						<div class="fileupload {if $cat_info.cat_image}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
							<div class="fileupload-preview thumbnail fileupload-exists" style="width: 50px; height: 50px; line-height: 50px;">
								<img src="{$cat_info.cat_image}" alt='{t domain="store"}暂无图片{/t}' />
							</div>
							<span class="btn btn-file">
							<span class="fileupload-new">{t domain="store"}浏览{/t}</span>
							<span class="fileupload-exists">{t domain="store"}修改{/t}</span>
							<input type="file" name="cat_image"/>
							</span>
							<a class="btn fileupload-exists" data-toggle="removefile" data-msg='{t domain="store"}您确定要删除此文件吗？{/t}' data-href='{RC_Uri::url("store/admin_store_category/del","cat_id={$cat_info.cat_id}")}' {if $cat_info.cat_image}data-removefile="true"{/if}>{t domain="store"}删除{/t}</a>
						</div>
					</div>
				</div>
				<div class="control-group formSep" >
					<label class="control-label">{t domain="store"}关键字：{/t}</label>
					<div class="controls">
						<input class="w350" type="text" name="keywords" value="{$cat_info.keywords|escape}" size="40" />
						<br />
						<p class="help-block w280 m_t5">{t domain="store"}用英文逗号分隔{/t}</p>
					</div>
				</div>
				<div class="control-group formSep" >
					<label class="control-label">{t domain="store"}分类描述：{/t}</label>
					<div class="controls">
						<textarea class="w350" name='cat_desc' rows="6" cols="48">{$cat_info.cat_desc}</textarea>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t domain="store"}确认{/t}</button>
						<input type="hidden" name="cat_id" value="{$cat_info.cat_id}"/>
						<input type="hidden" name="old_cat_name" value="{$cat_info.cat_name}"/>		 
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->