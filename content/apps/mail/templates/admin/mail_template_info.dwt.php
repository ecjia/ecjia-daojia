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
		{$action_links}
	</h3>
</div>

<div class="row-fluid edit-page" id="conent_area">
	<div class="span12">
		<form id="form-privilege" class="form-horizontal" name="theForm"  method="post" action="{$form_action}">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="mail"}邮件事件：{/t}</label>
					<div class="controls">
						<select name="template_code" class="span6" id="template_code">
	                        <option value='0'>{t domain="mail"}请选择{/t}</option>
	        				<!-- {html_options options=$template_code_list selected=$data.template_code} -->
						</select>
					</div>
				</div>
								
				<div class="control-group formSep">
					<label class="control-label">{t domain="mail"}邮件主题：{/t}</label>
					<div class="controls">
						<input type="text" name="subject" id="subject" value="{$data.template_subject}" class="span6"/>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">
                        <span class="input-must">*</span>{t domain="mail"}模板内容：{/t}
                    </label>
					<div class="controls">
                        {ecjia:editor content=$data.template_content}
						<span class="help-block">{$desc}</span>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
						<input type="hidden" value="{$data.id}" name="id"/>
						<input type="hidden" value="{url path='mail/admin_template/ajax_event'}" id="data-href"/>
						<input type="hidden" value="{$channel_code}" name="channel_code" id="channel_code"/>
						{if $action eq "insert"}
						<button class="btn btn-gebo" type="submit">{t domain="mail"}确定{/t}</button>
						{else}
						<button class="btn btn-gebo" type="submit">{t domain="mail"}更新{/t}</button>
						{/if}
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->