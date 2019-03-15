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
	                	<p>{if $merchant_info.shop_description}{$merchant_info.shop_description}{else}{t domain="staff"}店长有点懒哦，赶紧去完善店铺资料吧~~{/t}{/if}</p>
	                	<div class="panel-type">
	                		<div class="panel-type-item">
	                			{if $merchant_info.manage_mode eq 'self'}
	                			<img src="{$ecjia_main_static_url}img/merchant_dashboard/self.png" />
	                			<div class="type">{t domain="staff"}自营店{/t}</div>
								{else}
								<img src="{$ecjia_main_static_url}img/merchant_dashboard/join.png" />
								<div class="type">{t domain="staff"}入驻店{/t}</div>
								{/if}	                			
	                		</div>
	               			<div class="panel-type-item">
	                			{if $merchant_info.validate_type eq 1}
	                			<img src="{$ecjia_main_static_url}img/merchant_dashboard/personal.png" />
	                			<div class="type">{t domain="staff"}个人入驻{/t}</div>
								{else $merchant_info.validate_type eq 2}
								<img src="{$ecjia_main_static_url}img/merchant_dashboard/enterprise.png" />
								<div class="type">{t domain="staff"}企业入驻{/t}</div>
								{/if}	                			
	                		</div>
	                		<div class="panel-type-item">
	                			{if $merchant_info.shop_close neq 1 && $merchant_info.shop_closed neq 1}
	                			<img src="{$ecjia_main_static_url}img/merchant_dashboard/open.png" />
	                			<div class="type">{t domain="staff"}营业中{/t}</div>
								{else}
								<img src="{$ecjia_main_static_url}img/merchant_dashboard/close.png" />
								<div class="type">{t domain="staff"}打烊{/t}</div>
								{/if}	                			
	                		</div>
	                	</div>
	            	</div>
	            	
	            	<div class="col-sm-4">
		                <h4 class="title-real-estates">
		                    <strong>{t domain="staff"}小店资料{/t}</strong>
		                </h4>
	                	<hr style="margin-top: 10px;margin-bottom: 10px;">
            			<div><label>{t domain="staff"}营业时间：{/t}</label>{$merchant_info.shop_time_value}</div>
            			<div><label>{t domain="staff"}店铺公告：{/t}</label>{$merchant_info.shop_notice}</div>
	            	</div>
	        	</div>
	    	</div>
		</div>
	</div>
</div>
