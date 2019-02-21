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
					<label class="control-label">{t domain="goodslib"}规格名称：{/t}</label>
					<div class="controls">
						<input class="w355" type="text" name="cat_name" value="{$goods_type.cat_name|escape}"/>
						<span class="input-must">*</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goodslib"}状态：{/t}</label>
					<div class="controls chk_radio">
						<input class="uni_style" type="radio" name="enabled" value="0" {if $goods_type.enabled eq 0} checked="checked" {/if}/><span>{t domain="goodslib"}禁用{/t}</span>
						<input class="uni_style" type="radio" name="enabled" value="1" {if $goods_type.enabled eq 1} checked="checked" {/if}/><span>{t domain="goodslib"}启用{/t}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goodslib"}属性分组：{/t}</label>
					<div class="controls">
						<textarea class="span9" name="attr_group" rows="8" cols="40">{$goods_type.attr_group|escape}</textarea>
						<span class="help-block">{t domain="goodslib"}每行一个商品属性。排序也将按照自然顺序排序。{/t}</span>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t domain="goodslib"}确定{/t}</button>
						<input type="hidden" name="cat_id" value="{$goods_type.cat_id}"/>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->