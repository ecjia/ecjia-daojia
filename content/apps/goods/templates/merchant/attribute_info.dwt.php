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
							<label class="control-label col-lg-3">{lang key='goods::attribute.label_attr_name'}</label>
							<div class="controls col-lg-6">
								<input class="form-control" type='text' name='attr_name' value="{$attr.attr_name}" size='30' />
							</div>
							<span class="input-must">{lang key='system::system.require_field'}</span>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">{lang key='goods::attribute.label_cat_id'}</label>
							<div class="controls col-lg-6">
								<select class="form-control" name="cat_id" data-url="{url path= 'goods/mh_attribute/get_attr_group'}">
									<option value="0">{lang key='system::system.select_please'}</option>
									<!-- {$goods_type_list} -->
								</select>
							</div>
							<span class="input-must">{lang key='system::system.require_field'}</span>
						</div>
		
						<div class="form-group {if !$attr_groups}hide{/if}" id="attrGroups">
							<label class="control-label col-lg-3">{lang key='goods::attribute.label_attr_group'}</label>
							<div class="col-lg-6 no-chzn-container">
								<select class="form-control attr_list" name="attr_group">
									<!-- {if $attr_groups} -->
									<!-- {html_options options=$attr_groups selected=$attr.attr_group} -->
									<!-- {/if} -->
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">{lang key='goods::attribute.label_attr_index'}</label>
							<div class="col-lg-9">
								<input name="attr_index" id="attr_index_1" type="radio" value="0" {if $attr.attr_index eq 0}checked{/if} autocomplete="off" />
								<label for="attr_index_1">{lang key='goods::attribute.no_index'}</label>
								
								<input name="attr_index" id="attr_index_2" type="radio" value="1" {if $attr.attr_index eq 1}checked{/if} autocomplete="off" />
								<label for="attr_index_2">{lang key='goods::attribute.keywords_index'}</label>
								
								<input name="attr_index" id="attr_index_3" type="radio" value="2" {if $attr.attr_index eq 2}checked{/if} autocomplete="off" />
								<label for="attr_index_3">{lang key='goods::attribute.range_index'}</label>
								
							</div>
							<span class="help-block" {if $help_open}style="display:block" {else} style="display:none" {/if} id="noticeindex">{lang key='goods::attribute.note_attr_index'}</span>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">{lang key='goods::attribute.label_is_linked'}</label>
							<div class="col-lg-9">
								<input name="is_linked" id="is_linked_1" type="radio" value="0" {if $attr.is_linked eq 0}checked{/if} autocomplete="off" />
								<label for="is_linked_1">{lang key='system::system.no'}</label>
								
								<input name="is_linked" id="is_linked_2" type="radio" value="1" {if $attr.is_linked eq 1}checked{/if} autocomplete="off" />
								<label for="is_linked_2">{lang key='system::system.yes'}</label>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">{lang key='goods::attribute.label_attr_type'}</label>
							<div class="col-lg-9">
								<input name="attr_type" id="attr_type_1" type="radio" value="0" {if $attr.attr_type eq 0}checked{/if} autocomplete="off" />
								<label for="attr_type_1">{lang key='goods::attribute.attr_type_values.0'}</label>
								
								<input name="attr_type" id="attr_type_2" type="radio" value="1" {if $attr.attr_type eq 1}checked{/if} autocomplete="off" />
								<label for="attr_type_2">{lang key='goods::attribute.attr_type_values.1'}</label>
								
								<input name="attr_type" id="attr_type_3" type="radio" value="2" {if $attr.attr_type eq 2}checked{/if} autocomplete="off" />
								<label for="attr_type_3">{lang key='goods::attribute.attr_type_values.2'}</label>
							</div>
							<span class="help-block" {if $help_open}style="display:block" {else} style="display:none" {/if} id="noticeAttrType">{lang key='goods::attribute.note_attr_type'}</span>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">{lang key='goods::attribute.label_attr_input_type'}</label>
							<div class="col-lg-9">
								<input name="attr_input_type" id="attr_input_type_1" type="radio" value="0" {if $attr.attr_input_type eq 0}checked{/if} autocomplete="off" />
								<label for="attr_input_type_1">{lang key='goods::attribute.text'}</label>
								
								<input name="attr_input_type" id="attr_input_type_2" type="radio" value="1" {if $attr.attr_input_type eq 1}checked{/if} autocomplete="off" />
								<label for="attr_input_type_2">{lang key='goods::attribute.select'}</label>
								
								<input name="attr_input_type" id="attr_input_type_3" type="radio" value="2" {if $attr.attr_input_type eq 2}checked{/if} autocomplete="off" />
								<label for="attr_input_type_3">{lang key='goods::attribute.text_area'}</label>
							</div>
						</div>
						
						<div class="form-group attr_values">
							<label class="control-label col-lg-3">{lang key='goods::attribute.label_attr_values'}</label>
							<div class="col-lg-6">
								<textarea class="form-control" name="attr_values" cols="30" rows="8">{$attr.attr_values}</textarea>
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-lg-offset-3 col-lg-6">
								<button class="btn btn-info" type="submit">{lang key='system::system.button_submit'}</button>
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