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
					<label class="control-label">{t domain="goods"}属性名称：{/t}</label>
					<div class="controls">
						<input class="w350" type='text' name='attr_name' value="{$attr.attr_name}" size='30'/>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="goods"}所属规格模板：{/t}</label>
					<div class="controls no-chzn-container">
						<select class="w350" name="spec_cat_id">
							{$goods_type_list}
						</select>
						<span class="input-must">*</span>
					</div>
				</div>
				
				<div class="control-group formSep">
					<label class="control-label">{t domain="goods"}属性类型：{/t}</label>
					<div class="controls chk_radio">
						<input class="uni_style" type="radio" name="attr_cat_type" value="0" {if $attr.attr_cat_type eq 0} checked="checked" {/if}/><span>{t domain="goods"}普通{/t}</span>
						<input class="uni_style" type="radio" name="attr_cat_type" value="1" {if $attr.attr_cat_type eq 1} checked="checked" {/if}/><span>{t domain="goods"}颜色{/t}</span>
					</div>
				</div>
				
				<div class="control-group formSep attr_values">
					<label class="control-label">{t domain="goods"}可选值列表：{/t}</label>
					<div class="controls">
						<textarea class="w350" name="attr_values" cols="30" rows="8">{$attr.attr_values}</textarea>
						<span class="input-must">*</span>
						<span class="help-block">多个可选值时，换行输入，每行一个可选值。</span>
					</div>
				</div>
				
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t domain="goods"}确定{/t}</button>
						<input type="hidden" name="attr_id" value="{$attr.attr_id}"/>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->