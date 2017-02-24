<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.platform.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a  href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>
</div>
<div class="row-fluid">
	<div class="span12">
		<form id="form-privilege" class="form-horizontal" name="editForm" action="{$form_action}" method="post">
			<fieldset>
				<div class="control-group formSep" >
					<label class="control-label">{lang key='platform::platform.lable_platform_name'}</label>
					<div class="controls l_h30">
					{$name}
					</div>
				</div>
				
				<div class="control-group formSep" >
					<label class="control-label">{lang key='platform::platform.lable_plug_name'}</label>
					<div class="controls l_h30">
					{$bd.ext_name}
					</div>
				</div>
				
				<!-- {foreach from=$bd.ext_config item=config key=key} -->
				<div class="control-group formSep">
					<label class="control-label">{$config.label}</label>
					<div class="controls">
						<!-- {if $config.type == "text"} -->
						<input class="w350" name="cfg_value[]" type="{$config.type}" value="{$config.value}" size="40" />
						<span class="help-block">{$config.desc}</span>
						<!-- {elseif $config.type == "textarea"} -->
						<textarea class="w350" name="cfg_value[]" cols="80" rows="5">{$config.value}</textarea>
						<span class="help-block">{$config.desc}</span>
						<!-- {elseif $config.type == "select"} -->
						<select class="w350"   name="cfg_value[]"  >
							<!-- {html_options options=$config.range selected=$config.value} -->
						</select>
						<!-- {elseif $config.type == "radiobox"} -->
						<!-- {foreach from=$config.range item=val key=k} -->
							<input type="radio" name="cfg_value[]" value="{$k}" {if $config.value eq $k} checked="true" {/if}/>{$val}
						<!-- {/foreach} -->
						<!-- {/if} -->
						<input name="cfg_name[]" type="hidden" value="{$config.name}" />
						<input name="cfg_type[]" type="hidden" value="{$config.type}" />
						<input name="cfg_lang[]" type="hidden" value="{$config.lang}" />
					</div>
				</div>
				<!-- {/foreach} -->
			
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{lang key='platform::platform.update'}</button>
						<input type="hidden" name="account_id" value="{$bd.account_id}" />
						<input type="hidden" name="ext_code" value="{$bd.ext_code}" />
					</div>
				</div>
				
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->