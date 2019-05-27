<?php defined('IN_ECJIA') or exit('No permission resources.');?>

<div class="modal-dialog" style="width:800px;">
	<div class="modal-content" style="width:800px;">
		<div class="modal-header">
		    <button data-dismiss="modal" class="close sprc_close" type="button">×</button>
		    <h4 class="modal-title">{t domain="goods"}设置规格属性{/t}</h4>
		</div>
		
		<div class="modal-body">
		{if $goods_attr_html}
		   <div class="success-msg"></div>
		   <div class="error-msg"></div>
		   <form class="form-horizontal" method="post" name="insertForm" id="insertForm" action='{url path="goods/merchant/select_spec_values_insert"}'>
		   	   {if $has_product}
			   <div class="form-group">
					<label class="control-label col-lg-2 "></label>
					<div class="col-lg-12 l_h35">
						<span class="badge bg-important">!</span> <span class="ecjiafc-red">您当前设置的规格属性已生成货品，如需更改请先删除货品。</span>
					</div>
				</div>
				{/if}
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
		{else}
		 <form class="form-horizontal">
			<div class="form-group">
				<label class="control-label col-lg-2 "></label>
				<div class="col-lg-6 l_h35">
					<span class="badge bg-important">!</span> <span class="ecjiafc-red">您当前绑定的模板还未设置规格属性。</span>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-lg-offset-2 col-lg-6">
					<a href='{url path="goods/mh_spec_attribute/init" args="cat_id={$template_id}"}'><button type="button" class="btn btn-info" >{t domain="goods"}查看{/t}</button></a>
				</div>
			</div>
		</form>
		{/if}
		</div>
		
	</div>
</div>