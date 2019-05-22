<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="modal-dialog" style="width:800px;">
	<div class="modal-content" style="width:800px;">
		<div class="modal-header">
		    <button data-dismiss="modal" class="close sprc_close" type="button">×</button>
		    <h4 class="modal-title">{t domain="goods"}设置规格属性{/t}</h4>
		</div>

		<div class="modal-body">
		   <div class="success-msg"></div>
		   <div class="error-msg"></div>
		   <form class="form-horizontal" method="post" name="insertForm" id="insertForm" action='{url path="goods/merchant/select_spec_values_insert"}'>
	  			<div id="tbody-goodsAttr"> 
					{if $goods_attr_html}{$goods_attr_html}{/if}
				</div>
				
				<div class="form-group">
	              <div class="col-lg-offset-2 col-lg-6">
	                   <input  type="hidden" name="template_id" value="{$template_id}">
	                   <input  type="hidden" name="goods_id" value="{$goods_id}">
	                   <a class="btn btn-info insertSubmit" href="javascript:;" {if $has_product}disabled="disabled"{/if}>{t domain="goods"}确定{/t}</a>
	              </div>
	           	</div>
		   </form>
		</div>
	</div>
</div>