<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="modal-dialog" style="width:800px;">
	<div class="modal-content" style="width:800px;">
		<div class="modal-header">
		    <button data-dismiss="modal" class="close pro_close" type="button">×</button>
		    <h4 class="modal-title">{t domain="goods"}添加货品{/t}</h4>
		</div>

		<div class="modal-body">
		   <div class="success-msg"></div>
		   <div class="error-msg"></div>
		   <form class="form-horizontal" method="post" name="insertForm" id="insertForm">
			   {foreach from=$spec_attribute_list key=attribute_key item=attribute_value } 
			   <div class='form-group'>
				   <label class='control-label col-lg-2'>{$attribute_value.attr_name}</label>
				   <div class='controls col-lg-8'>
				   {foreach from=$attribute_value.attr_values key=key item=value}
					   <div class="check-box">
					   	   <input id="{$key}" name="{$attribute_value.attr_id}_radio_value" value="{$key}"  {if $value@first} checked="true"{/if} type="radio" />
						   <label for="{$key}">{$value}</label>
					   </div>
				   {/foreach}
				   </div>
			   </div>
			   {/foreach}
			   
		   	   <div class="form-group">
	             <div class="col-lg-offset-2 col-lg-6">
	             	<p class="product_sn_msg"></p>
	             </div>
	           </div>
	           
			   <div class="form-group">
	             <div class="col-lg-offset-2 col-lg-6">
	                   <input type="hidden" name="good_id" value="{$goods_id}"/>
	                   <input type="hidden" name="ajax_select_radio_url" value='{url path="goods/merchant/ajax_select_radio"}'/>
	                   <button type="button" class="add_pro_submint btn btn-info" goods-id="{$goods_id}" data-url='{url path="goods/merchant/spec_add_product_insert"}'>添加</button></a>
	                   <button type="button" class="del_pro_submint btn btn-danger" goods-id="{$goods_id}" data-url='{url path="goods/merchant/spec_del_product"}'>移除</button></a>
	             </div>
	           </div>
		   </form>
		</div>
	</div>
</div>