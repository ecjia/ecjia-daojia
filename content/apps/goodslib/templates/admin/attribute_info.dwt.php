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
					<label class="control-label">{t domain="goodslib"}属性名称{/t}</label>
					<div class="controls">
						<input class="w350" type='text' name='attr_name' value="{$attr.attr_name}" size='30'/>
						<span class="input-must">*</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goodslib"}所属商品规格：{/t}</label>
					<div class="controls no-chzn-container">
						<select class="w350" name="cat_id" data-url="{url path= 'goodslib/admin_attribute/get_attr_group'}">
							<option value="0">{t domain="goodslib"}请选择...{/t}</option>
							<!-- {$goods_type_list} -->
						</select>
						<span class="input-must">*</span>
					</div>
				</div>
				<div class="control-group formSep {if !$attr_groups}hide{/if}" id="attrGroups">
					<label class="control-label">{t domain="goodslib"}属性分组：{/t}</label>
					<div class="controls no-chzn-container">
						<select class="w350 attr_list" name="attr_group">
							<!-- {if $attr_groups} -->
							<!-- {html_options options=$attr_groups selected=$attr.attr_group} -->
							<!-- {/if} -->
						</select>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goodslib"}能否进行检索：{/t}</label>
					<div class="controls chk_radio">
                        {foreach from=$attr_indexs item=value key=key}
                        <input class="uni_style" name="attr_index" type="radio" value="{$key}" {if $attr.attr_index eq $key}checked="true"{/if} autocomplete="off" /><span>{$value}</span>
                        {/foreach}
                        <span class="help-block" id="noticeindex">{t domain="goodslib" escape=no}不需要该属性成为检索商品条件的情况请选择不需要检索，需要该属性进行关键字检索商品时选择关键字检索，<br/>如果该属性检索时希望是指定某个范围时，选择范围检索。{/t}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goodslib"}相同属性商品是否关联：{/t}</label>
					<div class="controls chk_radio">
						<input class="uni_style" name="is_linked" type="radio" value="0" {if $attr.is_linked eq 0} checked="true"{/if} autocomplete="off"/><span>{t domain="goodslib"}否{/t}</span>
						<input class="uni_style" name="is_linked" type="radio" value="1" {if $attr.is_linked eq 1} checked="true"{/if} autocomplete="off"/><span>{t domain="goodslib"}是{/t}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goodslib"}属性是否可选：{/t}</label>
					<div class="controls chk_radio">
                        {foreach from=$attr_types item=value key=key}
                        <input class="uni_style" name="attr_type" type="radio" value="{$key}" {if $attr.attr_type eq $key} checked="true"{/if} autocomplete="off"/><span>{$value}</span>
                        {/foreach}
						<span class="help-block" id="noticeAttrType">{t domain="goodslib" escape=no }选择"单选/复选属性"时，可以对商品该属性设置多个值，同时还能对不同属性值指定不同的价格加价，用户购买商品时需要选定具体的属性值。<br/>选择"唯一属性"时，商品的该属性值只能设置一个值，用户只能查看该值。{/t}</span>
					</div>
				</div>
				<div class="control-group formSep">
					<label class="control-label">{t domain="goodslib"}该属性值的录入方式：{/t}</label>
					<div class="controls chk_radio">
                        {foreach from=$attr_input_types item=value key=key}
                        <input class="uni_style" name="attr_input_type" type="radio" value="{$key}" {if $attr.attr_input_type eq $key} checked="true"{/if} autocomplete="off"/><span>{$value}</span>
                        {/foreach}
					</div>
				</div>
				<div class="control-group formSep attr_values">
					<label class="control-label">{t domain="goodslib"}可选值列表：{/t}</label>
					<div class="controls">
						<textarea class="w350" name="attr_values" cols="30" rows="8">{$attr.attr_values}</textarea>
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<button class="btn btn-gebo" type="submit">{t domain="goodslib"}确定{/t}</button>
						<input type="hidden" name="attr_id" value="{$attr.attr_id}"/>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<!-- {/block} -->