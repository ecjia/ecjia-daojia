<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="modal-header">
	<button class="close pro_close" data-dismiss="modal">×</button>
	<h3 class="modal-title">{t domain="goodslib"}添加货品{/t}</h3>
</div> 

<div class="modal-body">
     <div class="success-msg"></div>
	 <div class="error-msg"></div>
     <form class="form-horizontal" method="post" name="insertForm" id="insertForm">
		   {foreach from=$spec_attribute_list key=attribute_key item=attribute_value } 
		   <div class='control-group'>
			   <label class='control-label'>{$attribute_value.attr_name}</label>
			   <div class='controls chk_radio'>
			   {foreach from=$attribute_value.attr_values key=key item=value}
				   <div class="check-box">
					   <input class="uni_style" id="{$key}" type="radio" name="{$attribute_value.attr_id}_radio_value" value="{$key}" {if $value@first} checked="checked" {/if}/><span>{$value}</span>
				   </div>
			   {/foreach}
			   </div>
		   </div>
		   {/foreach}
		   
	   	   <div class="control-group">
             <div class="controls">
             	<p class="product_sn_msg"></p>
             </div>
           </div>
           
		   <div class="control-group">
             <div class="controls">
                   <input type="hidden" name="good_id" value="{$goods_id}"/>
                   <input type="hidden" name="ajax_select_radio_url" value='{url path="goodslib/admin/ajax_select_radio"}'/>
                   <button type="button" class="add_pro_submint btn btn-gebo" goods-id="{$goods_id}" data-url='{url path="goodslib/admin/spec_add_product_insert"}'>添加</button></a>
                   <button type="button" class="del_pro_submint btn btn-gebo" goods-id="{$goods_id}" data-url='{url path="goodslib/admin/spec_del_product"}'>移除</button></a>
             </div>
           </div>
	</form>
</div>

