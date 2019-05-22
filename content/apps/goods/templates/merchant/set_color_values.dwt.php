<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
		    <button data-dismiss="modal" class="close" type="button">×</button>
		    <h4 class="modal-title">{t domain="goods"}设置色值{/t}</h4>
		</div>

		<div class="modal-body">
		   <div class="success-msg"></div>
		   <div class="error-msg"></div>
		   <form class="form-horizontal" method="post" name="insertForm" id="insertForm" action='{url path="goods/mh_spec_attribute/set_color_values_insert"}'>
		  		<!-- {foreach from=$color_list_array key=key item=val} --> 
		   		<div class="form-group">
					<div class="col-lg-4">
					   <input  class="form-control" type='text' name='attr_values[]' value="{$key}" />
					</div>  
					<pan>
						<div class="col-lg-4">
						   <input class="form-control colorpicker-default" type="text" name="color_values[]" value="{$val}"  style="color:{$val};" >
						</div> 
					</pan> 
				</div>
				<!-- {/foreach} -->	
				
				<div class="form-group">
	              <div class="col-lg-4">
	                   <input  type="hidden" name="cat_id" value="{$cat_id}">
	                   <input  type="hidden" name="attr_id" value="{$attr_id}">
	                   <a class="btn btn-info insertSubmit" href="javascript:;">{t domain="goods"}确认{/t}</a>
	              </div>
	           	</div>
		   </form>
		</div>
	</div>
</div>