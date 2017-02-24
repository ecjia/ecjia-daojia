<div class="row">
	<div class="col-lg-12">
		<div class="panel">
	    	<div class="panel-body">
	        	<div class="row">
	            	<div class="col-sm-3">
	            		 {if $merchant_info.shop_logo}
	                	 	<img src="{$merchant_info.shop_logo}" width="200" height="200" class="thumbnail" style="margin-left: 20px;margin-bottom: 0;" />
	                	 {else}
	                	 	<img src="{$ecjia_main_static_url}img/merchant_logo.jpg"  width="200" height="200" class="thumbnail" style="margin-left: 20px;margin-bottom: 0;" />
	                	 {/if}
	            	</div>
	            	<div class="col-sm-5">
		                <h4>
		                    <strong>{$ecjia_merchant_cpname}</strong>
		                </h4>
	                	<hr style="margin-top: 10px;margin-bottom: 10px;">
	                	<p>{if $merchant_info.shop_description}{$merchant_info.shop_description}{else}店长有点懒哦，赶紧去完善店铺资料吧~~{/if}</p>
	            	</div>
	            	
	            	<div class="col-sm-4">
		                <h4 class="title-real-estates">
		                    <strong>小店资料</strong>
		                </h4>
	                	<hr style="margin-top: 10px;margin-bottom: 10px;">
            			<div><label>营业时间：</label>{$merchant_info.shop_trade_time}</div>
            			<div><label>店铺公告：</label>{$merchant_info.shop_notice}</div>
	            	</div>
	        	</div>
	    	</div>
		</div>
	</div>
</div>
