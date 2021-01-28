<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.sms_template_test.init();
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
		<form id="form-privilege" class="form-horizontal" name="theForm"  method="post" action="{$form_action}">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="sms"}短信主题：{/t}</label>
					<div class="controls l_h30">{$data.template_subject}[{$data.template_code}]</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="sms"}手机区号：{/t}</label>
					<div class="controls">
						<input type="text" name="area_code" id="area_code" value="" class="span2" pro/>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="sms"}手机号码：{/t}</label>
					<div class="controls">
						<input type="text" name="mobile" id="mobile" value="" class="span6" pro/>
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="sms"}短信模板内容：{/t}</label>
					<div class="controls l_h30">{$data.template_content}</div>
				</div>
				
				<!-- {foreach from=$variable item=val} -->
					<div class="control-group formSep">
						<label class="control-label">{$val}：</label>
						<div class="controls">
							<input type="text" name="data[{$val}]" class="span6" />
							<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
						</div>
					</div>
				<!-- {/foreach} -->
				
				<div class="control-group">
					<div class="controls">
					    <input type="hidden" value="{$channel_code}" name="channel_code"/>
						<input type="hidden" value="{$data.template_code}" name="template_code"/>
						<button class="btn btn-gebo" type="submit">{t domain="sms"}提交测试{/t}</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->