<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.edit_arrt.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn plus_or_reply data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" name="theForm" action="{$form_action}" method="post">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{lang key='goods::attribute.label_attr_name'}</label>
					<div class="controls">
						<input class="w350" type='text' name='attr_name' value="{$attr.attr_name}" size='30'/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='goods::attribute.label_cat_id'}</label>
					<div class="controls no-chzn-container">
						<select class="w350" name="cat_id" data-url="{url path= 'goods/admin_attribute/get_attr_group'}">
							<option value="0">{lang key='system::system.select_please'}</option>
							<!-- {$goods_type_list} -->
						</select>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep {if !$attr_groups}hide{/if}" id="attrGroups">
					<label class="control-label">{lang key='goods::attribute.label_attr_group'}</label>
					<div class="controls no-chzn-container">
						<select class="w350 attr_list" name="attr_group">
							<!-- {if $attr_groups} -->
							<!-- {html_options options=$attr_groups selected=$attr.attr_group} -->
							<!-- {/if} -->
						</select>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='goods::attribute.label_attr_index'}</label>
					<div class="controls chk_radio">
						<input class="uni_style" name="attr_index" type="radio" value="0" {if $attr.attr_index eq 0} checked="true"{/if} autocomplete="off"/><span>{lang key='goods::attribute.no_index'}</span>
						<input class="uni_style" name="attr_index" type="radio" value="1" {if $attr.attr_index eq 1} checked="true"{/if} autocomplete="off"/><span>{lang key='goods::attribute.keywords_index'}</span>
						<input class="uni_style" name="attr_index" type="radio" value="2" {if $attr.attr_index eq 2} checked="true"{/if} autocomplete="off"/><span>{lang key='goods::attribute.range_index'}</span>
						<span class="help-block" {if $help_open}style="display:block" {else} style="display:none" {/if} id="noticeindex">{lang key='goods::attribute.note_attr_index'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='goods::attribute.label_is_linked'}</label>
					<div class="controls chk_radio">
						<input class="uni_style" name="is_linked" type="radio" value="0" {if $attr.is_linked eq 0} checked="true"{/if} autocomplete="off"/><span>{lang key='system::system.no'}</span>
						<input class="uni_style" name="is_linked" type="radio" value="1" {if $attr.is_linked eq 1} checked="true"{/if} autocomplete="off"/><span>{lang key='system::system.yes'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='goods::attribute.label_attr_type'}</label>
					<div class="controls chk_radio">
						<input class="uni_style" name="attr_type" type="radio" value="0" {if $attr.attr_type eq 0} checked="true"{/if} autocomplete="off"/><span>{lang key='goods::attribute.attr_type_values.0'}</span>
						<input class="uni_style" name="attr_type" type="radio" value="1" {if $attr.attr_type eq 1} checked="true"{/if} autocomplete="off"/><span>{lang key='goods::attribute.attr_type_values.1'}</span>
						<input class="uni_style" name="attr_type" type="radio" value="2" {if $attr.attr_type eq 2} checked="true"{/if} autocomplete="off"/><span>{lang key='goods::attribute.attr_type_values.2'}</span>
						<span class="help-block" {if $help_open}style="display:block" {else} style="display:none" {/if} id="noticeAttrType">{lang key='goods::attribute.note_attr_type'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='goods::attribute.label_attr_input_type'}</label>
					<div class="controls chk_radio">
						<input class="uni_style" name="attr_input_type" type="radio" value="0" {if $attr.attr_input_type eq 0} checked="true"{/if} autocomplete="off"/><span>{lang key='goods::attribute.text'}</span>
						<input class="uni_style" name="attr_input_type" type="radio" value="1" {if $attr.attr_input_type eq 1} checked="true"{/if} autocomplete="off"/><span>{lang key='goods::attribute.select'}</span>
						<input class="uni_style" name="attr_input_type" type="radio" value="2" {if $attr.attr_input_type eq 2} checked="true"{/if} autocomplete="off"/><span>{lang key='goods::attribute.text_area'}</span>
					</div>
				</div>
				<div class="control-group formSep attr_values">
					<label class="control-label">{lang key='goods::attribute.label_attr_values'}</label>
					<div class="controls">
						<textarea class="w350" name="attr_values" cols="30" rows="8">{$attr.attr_values}</textarea>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
						<input type="hidden" name="attr_id" value="{$attr.attr_id}"/>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->