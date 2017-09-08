<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_type.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn plus_or_reply data-pjax" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
		<form class="form-horizontal" action="{$form_action}" method="post" name="theForm">
			<fieldset>
				<div class="control-group formSep">
					<label class="control-label">{lang key='goods::goods_spec.label_goods_type_name'}</label>
					<div class="controls">
						<input class="w355" type="text" name="cat_name" value="{$goods_type.cat_name|escape}"/>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='goods::goods_spec.label_goods_type_status'}</label>
					<div class="controls chk_radio">
						<input class="uni_style" type="radio" name="enabled" value="0" {if $goods_type.enabled eq 0} checked="checked" {/if}/><span>{lang key='goods::goods_spec.arr_goods_status.0'}</span>
						<input class="uni_style" type="radio" name="enabled" value="1" {if $goods_type.enabled eq 1} checked="checked" {/if}/><span>{lang key='goods::goods_spec.arr_goods_status.1'}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{lang key='goods::goods_spec.label_attr_groups'}</label>
					<div class="controls">
						<textarea class="span9" name="attr_group" rows="8" cols="40">{$goods_type.attr_group|escape}</textarea>
						<span class="help-block">{lang key='goods::goods_spec.notice_attr_groups'}</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{lang key='system::system.button_submit'}</button>
						<input type="hidden" name="cat_id" value="{$goods_type.cat_id}"/>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->