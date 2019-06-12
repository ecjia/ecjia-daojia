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
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>	
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
							<label class="control-label col-lg-3">{t domain="goods"}属性名称：{/t}</label>
							<div class="controls col-lg-6">
								<input class="form-control" type='text' name='attr_name' value="{$attr.attr_name}" />
							</div>
							<span class="input-must">*</span>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-3">{t domain="goods"}所属规格模板：{/t}</label>
							<div class="controls col-lg-6">
								<select class="form-control" name="spec_cat_id" >
									{$goods_type_list}
								</select>
							</div>
							<span class="input-must">*</span>
						</div>
						{if $attr.attr_id neq 0}
							<div class="form-group">
								<label class="control-label col-lg-3">{t domain="promotion"}属性类型：{/t}</label>
								<div class="col-lg-6 l_h30">{if $attr.attr_cat_type eq 0}{t domain="goods"}普通{/t}{elseif $attr.attr_cat_type eq 1}{t domain="goods"}颜色{/t}{/if}</div>
							</div>
						{else}
							<div class="form-group">
	              				<label class="control-label col-lg-3">{t domain="goods"}属性类型：{/t}</label>
	                     		<div class="col-lg-6">
	                     			<input type="radio" id="enabled_2" name="attr_cat_type" value="0" {if $attr.attr_cat_type eq 0} checked {/if}>
	                      			<label for="enabled_2">{t domain="goods"}普通{/t}</label>
	                      			
	                  				<input type="radio" id="enabled_1" name="attr_cat_type" value="1" {if $attr.attr_cat_type eq 1} checked {/if}>
	                      			<label for="enabled_1">{t domain="goods"}颜色{/t}</label>
	        					</div> 
	              			</div>
						{/if}
						

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