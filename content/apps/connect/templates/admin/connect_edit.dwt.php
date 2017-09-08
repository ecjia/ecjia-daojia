<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.connect_edit.init();
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
					<label class="control-label">{lang key='connect::connect.lable_name'}</label>
					<div class="controls">
						<input type="text" name="connect_name" id="connect_name" value="{$connect.connect_name}" class="span4"/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
		
				<div class="control-group formSep">
					<label class="control-label">{lang key='connect::connect.lable_desc'}</label>
					<div class="controls">
					<textarea class="span11 h200" name="connect_desc" id="connect_desc" rows="16" >{$connect.connect_desc}</textarea>
					<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<!-- {foreach from=$connect.connect_config item=config key=key} -->
    				<div class="control-group formSep">
    					<label class="control-label">{$config.label}</label>
    					<div class="controls">
    						<!-- {if $config.type == "text"} -->
    						<input class="w350" id="cfg_value[]" name="cfg_value[]" type="{$config.type}" value="{$config.value}" size="40" />
    						<!-- {elseif $config.type == "textarea"} -->
    						<textarea class="w350" id="cfg_value[]" name="cfg_value[]" cols="80" rows="5">{$config.value}</textarea>
    						<!-- {elseif $config.type == "select"} -->
    						<select class="w350" id="cfg_value[]" name="cfg_value[]"  >
    							<!-- {html_options options=$config.range selected=$config.value} -->
    						</select>
    						<!-- {/if} -->
    						<input name="cfg_name[]" type="hidden" value="{$config.name}" />
    						<input name="cfg_type[]" type="hidden" value="{$config.type}" />
    						<input name="cfg_lang[]" type="hidden" value="{$config.lang}" />
    						{if $config.desc}
    						<br><span class="help-block">{$config.desc}</span>
    						{/if}
    					</div>
    				</div>
    				<!-- {/foreach} -->
				<div class="control-group">
					<div class="controls">
					<input type="hidden" value="{$connect.connect_id}" name="id"/>
					<input type="hidden" value="{$connect.connect_name}" name="oldname"/>
					<input type="hidden" value="{$connect.connect_code}" name="connect_code"/>
					<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->