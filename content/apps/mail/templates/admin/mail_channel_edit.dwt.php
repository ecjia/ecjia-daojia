<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.channel_edit.edit();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a href="{$action_link.href}" class="btn plus_or_reply" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form id="form-privilege" class="form-horizontal" name="editForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{t domain="mail"}名称{/t}</label>
					<div class="controls">
						<input class="w350" name="channel_name" type="text" value="{$channel.channel_name|escape}" size="40" />
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="mail"}描述{/t}</label>
					<div class="controls">
						<textarea class="w350" name="channel_desc" cols="10" rows="6">{$channel.channel_desc|escape}</textarea>
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
				</div>
				<!-- {foreach from=$channel.channel_config item=config key=key} -->
				<div class="control-group formSep">
					<label class="control-label">{$config.label}</label>
					<div class="controls">
                        {assign var="input_name" value={$config.name}}
						<!-- {if $config.type == "text"} -->
						<input class="w350" id="cfg_value[]" name="cfg_value[{$input_name}]" type="{$config.type}" value="{$config.value}" size="40" />
                        <!-- {elseif $config.type == "password"} -->
                        <input class="w350" id="cfg_value[]" name="cfg_value[{$input_name}]" type="{$config.type}" value="{$config.value}" size="40" />
                        <!-- {elseif $config.type == "textarea"} -->
						<textarea class="w350" id="cfg_value[]" name="cfg_value[{$input_name}]" cols="80" rows="5">{$config.value}</textarea>
						<!-- {elseif $config.type == "select"} -->
						<select class="w350" id="cfg_value[]" name="cfg_value[{$input_name}]"  >
                            <!-- {html_options options=$config.range name="cfg_value[$input_name]" selected=$config.value} -->
						</select>
                        <!-- {elseif $config.type == "radiobox"} -->
                        <!-- {html_radios options=$config.range name="cfg_value[$input_name]" values=array_keys($config.range) output=array_values($config.range) selected=$config.value labels=0} -->
                        <!-- {/if} -->
						<input name="cfg_name[{$input_name}]" type="hidden" value="{$config.name}" />
						<input name="cfg_type[{$input_name}]" type="hidden" value="{$config.type}" />
						<input name="cfg_lang[{$input_name}]" type="hidden" value="{$config.lang}" />
						{if $config.desc}
    					<span class="help-block">{$config.desc}</span>
    					{/if}
					</div>
				</div>
				<!-- {/foreach} -->
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t domain="mail"}确定{/t}</button>
						<input type="hidden" name="channel_id" value="{$channel.channel_id}" />
						<input type="hidden" name="channel_code" value="{$channel.channel_code}" />
						<input type="hidden" name="channel_type" value="{$channel.channel_type}" />
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->