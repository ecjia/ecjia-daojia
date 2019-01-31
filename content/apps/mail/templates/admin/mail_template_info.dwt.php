<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.mail_template_info.init();
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

<div class="row-fluid edit-page" id="conent_area">
	<div class="span12">
		<form id="form-privilege" class="form-horizontal" name="theForm"  method="post" action="{url path='mail/admin/save_template'}">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="mail"}邮件模板：{/t}</label>
					<div class="controls users">
						<p>{$template.template_name}</p>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="mail"}邮件主题：{/t}</label>
					<div class="controls">
						<input type="text" name="subject" id="subject" value="{$template.template_subject}" class="span4"/>
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="mail"}邮件类型：{/t}</label>
					<div class="controls chk_radio">
						<input type="radio" class="uni_style" name="mail_type" value="0" {if $template.is_html eq '0'}checked="true"{/if} data-toggle="change_editor" data-url='{url path="mail/admin/loat_template" args="mail_type=0&tpl={$tpl}"}' />{t domain="mail"}纯文本邮件{/t}
						<input type="radio" class="uni_style" name="mail_type" value="1" {if $template.is_html eq '1'}checked="true"{/if} data-toggle="change_editor" data-url='{url path="mail/admin/loat_template" args="mail_type=1&tpl={$tpl}"}' />{t domain="mail"}HTML 邮件{/t}
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">{t domain="mail"}模板内容：{/t}</label>
					<div class="controls">
						{if $template.is_html eq '1'}
							{ecjia:editor content=$template.template_content}
						{else}
							<textarea name="content" id="content" rows="16" >{$template.template_content}</textarea>
							<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
						{/if}
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t domain="mail"}更新{/t}</button>
						<input type="hidden" name="tpl" value="{$tpl}" />
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->