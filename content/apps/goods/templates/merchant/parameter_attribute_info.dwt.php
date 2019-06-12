<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.edit_arrt.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2>
			<!-- {if $ur_here}{$ur_here}{/if} -->
		</h2>	
	</div>	
	<div class="pull-right">
		<!-- {if $action_link} -->
		<a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text}</a>
		<!-- {/if} -->	
	</div>	
	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
      	<section class="panel">
        	<div class="panel-body">
            	<div class="form">
					<form class="form-horizontal tasi-form" name="theForm" action="{$form_action}" method="post">
						<div class="form-group">
							<label class="control-label col-lg-3">{t domain="goods"}参数名称：{/t}</label>
							<div class="controls col-lg-6">
								<input class="form-control" type='text' name='attr_name' value="{$attr.attr_name}" size='30' />
							</div>
							<span class="input-must">*</span>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">{t domain="goods"}所属参数模板：{/t}</label>
							<div class="controls col-lg-6">
								<select class="form-control" name="cat_id" data-url="{url path= 'goods/mh_parameter_attribute/get_attr_group'}">
									{$goods_type_list}
								</select>
							</div>
							<span class="input-must">*</span>
						</div>
		
						<div class="form-group {if !$attr_groups}hide{/if}" id="attrGroups">
							<label class="control-label col-lg-3">{t domain="goods"}参数分组：{/t}</label>
							<div class="col-lg-6 no-chzn-container">
								<select class="form-control attr_list" name="attr_group">
									<!-- {if $attr_groups} -->
										<!-- {foreach from=$attr_groups key=key item=val} -->
											<option value="{$val}" {if $attr.attr_group eq $val}selected{/if}>{$val}</option>
										<!-- {/foreach} -->
									<!-- {/if} -->
								</select>
							</div>
						</div>
						
						{if $attr.attr_id neq 0}
							<div class="form-group">
								<label class="control-label col-lg-3">{t domain="goods"}参数可选值：{/t}</label>
								<div class="controls col-lg-6 l_h30">
									{if $attr.attr_type eq 0}唯一参数{elseif $attr.attr_type eq 2}复选参数{/if}
									<input type="hidden" name="attr_type" value="{$attr.attr_type}" />
									<span class="help-block" id="noticeAttrType">{t domain="goods" escape=no}添加选择"唯一参数"时，商品的该参数值只能设置一个值，用户只能查看该值。<br/>添加选择"复选参数"时，可以对商品该参数设置多个值。{/t}</span>
								</div>
							</div>
						{else}
							<div class="form-group">
								<label class="control-label col-lg-3">{t domain="goods"}参数可选值：{/t}</label>
								<div class="col-lg-9">
	                                {foreach from=$attr_types item=value key=key}
	                                <input name="attr_type" id="attr_type_{$key}" type="radio" value="{$key}" {if $attr.attr_type eq $key}checked{/if} autocomplete="off" />
	                                <label for="attr_type_{$key}">{$value}</label>
	                                {/foreach}
	                                <span class="help-block" id="noticeAttrType">{t domain="goods" escape=no}选择"唯一参数"时，商品的该参数值只能设置一个值，用户只能查看该值。<br/>选择"复选参数"时，可以对商品该参数设置多个值。{/t}</span>
								</div>
							</div>
						{/if}
						
						<div class="form-group attr_input_type" {if $attr.attr_type eq 2}style="display: none;"{/if}>
							<label class="control-label col-lg-3">{t domain="goods"}该参数值的录入方式：{/t}</label>
							<div class="col-lg-9">
                                {foreach from=$attr_input_types item=value key=key}
								<input name="attr_input_type" id="attr_input_type_{$key}" type="radio" value="{$key}" {if $attr.attr_input_type eq $key}checked{/if} autocomplete="off" />
								<label for="attr_input_type_{$key}">{$value}</label>
                                {/foreach}
							</div>
						</div>
						
						<div class="form-group attr_values">
							<label class="control-label col-lg-3">{t domain="goods"}可选值列表：{/t}</label>
							<div class="col-lg-6">
								<textarea class="form-control" name="attr_values" cols="30" rows="8">{$attr.attr_values}</textarea>
								<span class="help-block">多个可选值时，换行输入，每行一个可选值。</span>
							</div>
							<span class="input-must">*</span>
						</div>
						
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-6">
								<button class="btn btn-info" type="submit">{t domain="goods"}确定{/t}</button>
								<input type="hidden" name="attr_id" value="{$attr.attr_id}" />
							</div>
						</div>
					</form>
				</div>
			</div>
		</section>
	</div>
</div>
<!-- {/block} -->