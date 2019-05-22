<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.goods_type.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
      	<section class="panel">
        	<div class="panel-body">
            	<div class="form edit-page">
              		<form class="form-horizontal tasi-form" method="post" action="{$form_action}" name="theForm">
              			<div class="form-group">
              				<label class="control-label col-lg-2">{t domain="goods"}规格模板名称：{/t}</label>
              				<div class="controls col-lg-6">
                            	<input class="form-control" name="cat_name" type="text" value="{$spec_template_info.cat_name}" />
                          	</div>
                          	<span class="input-must">*</span>
              			</div>
                                    
              			<div class="form-group">
              				<label class="control-label col-lg-2">{t domain="goods"}状态：{/t}</label>
                     		<div class="col-lg-6">
                     			<input type="radio" id="enabled_2" name="enabled" value="1" {if $spec_template_info.enabled eq 1} checked {/if}>
                      			<label for="enabled_2">{t domain="goods"}启用{/t}</label>
                      			
                  				<input type="radio" id="enabled_1" name="enabled" value="0" {if $spec_template_info.enabled eq 0} checked {/if}>
                      			<label for="enabled_1">{t domain="goods"}禁用{/t}</label>
        					</div> 
              			</div>
              			
              			<div class="form-group">
              				<div class="col-lg-offset-2 col-lg-6">
                      			<button class="btn btn-info" type="submit">{t domain="goods"}确定{/t}</button>
                             	<input type="hidden" name="cat_id" value="{$spec_template_info.cat_id}" />
                         	</div>
              			</div>
              		</form>
              	</div>
          	</div>
    	</section>
	</div>
</div>
<!-- {/block} -->