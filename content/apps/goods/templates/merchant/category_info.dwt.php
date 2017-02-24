<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.goods_category_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div>
	<h2 class="page-header">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn btn-primary data-pjax pull-right" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text} </a>
		{/if}
	</h2>
</div>

<div class="row">
	<div class="col-lg-12">
      	<section class="panel">
        	<div class="panel-body">
            	<div class="form">
					<form class="form-horizontal cmxform" action="{$form_action}" method="post" name="theForm" enctype="multipart/form-data" data-edit-url="{RC_Uri::url('goods/mh_category/edit')}">
						<div class="form-group">
							<label class="control-label col-lg-2">{lang key='goods::category.label_cat_name'}</label>
							<div class="controls col-lg-6">
								<input class="form-control" type='text' name='cat_name' maxlength="20" value='{$cat_info.cat_name|escape:html}' size='27'/>
							</div>
							<span class="input-must">{lang key='system::system.require_field'}</span>
						</div>
			
						<div class="form-group">
							<label class="control-label col-lg-2">{lang key='goods::category.label_parent_cat'}</label>
							<div class="col-lg-6">
								<select class="form-control m-bot15" name="parent_id">
									<option value="0">{lang key='goods::category.cat_top'}</option>
									<!-- {$cat_select} -->
								</select>
							</div>
						</div>
					
						<div class="form-group">
							<label class="control-label col-lg-2">{lang key='goods::category.label_sort_order'}</label>
							<div class="col-lg-6">
								<input class="form-control" type="text" name='sort_order' {if $cat_info.sort_order}value='{$cat_info.sort_order}'{else} value="50"{/if} size="15" />
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-lg-2">{lang key='goods::category.label_is_show'}</label>
							<div class="col-lg-6">
								<input type="radio" id="is_show_1" name="is_show" value="1" {if $cat_info.is_show neq 0}checked="checked"{/if}  />
								<label for="is_show_1">{lang key='system::system.yes'}</label>
								
								<input type="radio" id="is_show_2" name="is_show" value="0" {if $cat_info.is_show eq 0}checked="checked"{/if}  />
								<label for="is_show_2">{lang key='system::system.no'}</label>
							</div>
						</div>
												
						<div class="form-group" >
							<label class="control-label col-lg-2">{lang key='goods::category.label_cat_desc'}</label>
							<div class="col-lg-6">
								<textarea class="form-control" name='cat_desc' rows="6" cols="48">{$cat_info.cat_desc}</textarea>
							</div>
						</div>
						
						<div class="form-group">
              				<div class="col-lg-offset-2 col-lg-6">
								<!-- {if $cat_info.cat_id} -->
								<input type="hidden" name="old_cat_name" value="{$cat_info.cat_name}" />
								<input type="hidden" name="cat_id" value="{$cat_info.cat_id}" />
								<button class="btn btn-info" type="submit">{lang key='goods::category.update'}</button>
								<!-- {else} -->
								<button class="btn btn-info" type="submit">{lang key='system::system.button_submit'}</button>
								<!-- {/if} -->
							</div>
						</div>
					</form>
				</div>
          	</div>
    	</section>
	</div>
</div>
<!-- {/block} -->