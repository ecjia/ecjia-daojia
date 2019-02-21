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
							<label class="control-label col-lg-3">{t domain="goods"}属性名称{/t}</label>
							<div class="controls col-lg-6">
								<input class="form-control" type='text' name='attr_name' value="{$attr.attr_name}" size='30' />
							</div>
							<span class="input-must">*</span>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">{t domain="goods"}所属商品规格：{/t}</label>
							<div class="controls col-lg-6">
								<select class="form-control" name="cat_id" data-url="{url path= 'goods/mh_attribute/get_attr_group'}">
									<option value="0">{t domain="goods"}请选择...{/t}</option>
									<!-- {$goods_type_list} -->
								</select>
							</div>
							<span class="input-must">*</span>
						</div>
		
						<div class="form-group {if !$attr_groups}hide{/if}" id="attrGroups">
							<label class="control-label col-lg-3">{t domain="goods"}属性分组：{/t}</label>
							<div class="col-lg-6 no-chzn-container">
								<select class="form-control attr_list" name="attr_group">
									<!-- {if $attr_groups} -->
									<!-- {html_options options=$attr_groups selected=$attr.attr_group} -->
									<!-- {/if} -->
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">{t domain="goods"}能否进行检索：{/t}</label>
							<div class="col-lg-9">
                                {foreach from=$attr_indexs item=value key=key}
                                <input name="attr_index" id="attr_index_{$key}" type="radio" value="{$key}" {if $attr.attr_index eq $key}checked{/if} autocomplete="off" />
                                <label for="attr_index_{$key}">{$value}</label>
                                {/foreach}
                                <span class="help-block" id="noticeindex">{t domain="goods" escape=no}不需要该属性成为检索商品条件的情况请选择不需要检索，需要该属性进行关键字检索商品时选择关键字检索，<br/>如果该属性检索时希望是指定某个范围时，选择范围检索。{/t}</span>
							</div>

						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">{t domain="goods"}相同属性商品是否关联：{/t}</label>
							<div class="col-lg-9">
								<input name="is_linked" id="is_linked_1" type="radio" value="0" {if $attr.is_linked eq 0}checked{/if} autocomplete="off" />
								<label for="is_linked_1">{t domain="goods"}否{/t}</label>
								
								<input name="is_linked" id="is_linked_2" type="radio" value="1" {if $attr.is_linked eq 1}checked{/if} autocomplete="off" />
								<label for="is_linked_2">{t domain="goods"}是{/t}</label>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">{t domain="goods"}属性是否可选：{/t}</label>
							<div class="col-lg-9">
                                {foreach from=$attr_types item=value key=key}
                                <input name="attr_type" id="attr_type_{$key}" type="radio" value="{$key}" {if $attr.attr_type eq $key}checked{/if} autocomplete="off" />
                                <label for="attr_type_{$key}">{$value}</label>
                                {/foreach}
                                <span class="help-block" id="noticeAttrType">{t domain="goods" escape=no}选择"单选/复选属性"时，可以对商品该属性设置多个值，同时还能对不同属性值指定不同的价格加价，用户购买商品时需要选定具体的属性值。<br/>选择"唯一属性"时，商品的该属性值只能设置一个值，用户只能查看该值。{/t}</span>
							</div>

						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">{t domain="goods"}该属性值的录入方式：{/t}</label>
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
							</div>
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