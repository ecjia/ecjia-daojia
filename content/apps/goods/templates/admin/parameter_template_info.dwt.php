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
					<label class="control-label">{t domain="goods"}参数模板名称：{/t}</label>
					<div class="controls">
						<input class="w355" type="text" name="cat_name" value="{$parameter_template_info.cat_name}"/>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="goods"}状态：{/t}</label>
					<div class="controls chk_radio">
						<input class="uni_style" type="radio" name="enabled" value="1" {if $parameter_template_info.enabled eq 1} checked="checked" {/if}/><span>{t domain="goods"}启用{/t}</span>
						<input class="uni_style" type="radio" name="enabled" value="0" {if $parameter_template_info.enabled eq 0} checked="checked" {/if}/><span>{t domain="goods"}禁用{/t}</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="goods"}参数分组：{/t}</label>
					<div class="controls">
						<textarea class="w350" name="attr_group" rows="8" cols="30">{$parameter_template_info.attr_group}</textarea>
						<span class="help-block">{t domain="goods"}多个参数组时，换行输入，排序也将按照自然顺序排序。{/t}</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t domain="goods"}确定{/t}</button>
						<input type="hidden" name="cat_id" value="{$parameter_template_info.cat_id}"/>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->