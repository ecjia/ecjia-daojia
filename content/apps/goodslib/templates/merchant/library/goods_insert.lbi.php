<?php defined('IN_ECJIA') or exit('No permission resources.');?> 

<div class="modal fade" id="insertGoods">
	<div class="modal-dialog">
    	<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title">导入商品</h4>
			</div>
			<div class="modal-body" style="height:auto;">
				<form class="form-horizontal" action="{$form_action}" method="post" name="insertForm">
					<div class="form-group">
          				<label class="control-label col-lg-2">商品名称</label>
          				<div class="controls col-lg-7">
                        	<input class="form-control" name="goods_name" type="text" value="" />
                      	</div>
                      	<span class="input-must m_l15">{lang key='system::system.require_field'}</span>
          			</div>
          			<div class="form-group">
          				<label class="control-label col-lg-2">商品货号</label>
          				<div class="controls col-lg-7">
                        	<input class="form-control" name="goods_sn" type="text" value="" />
                      	</div>
          			</div>
          			<div class="form-group">
          				<label class="control-label col-lg-2">本店售价</label>
          				<div class="controls col-lg-7">
                        	<input class="form-control" name="shop_price" type="text" value="" />
                      	</div>
                      	<div class="col-lg-2 p_l0">
                          	<a class="btn btn-primary" data-toggle="marketPriceSetted">{lang key='goods::goods.compute_by_mp'}</a>
						</div>
						<span class="input-must m_l15">{lang key='system::system.require_field'}</span>
          			</div>
              			
          			<div class="form-group">
          				<label class="control-label col-lg-2">市场售价</label>
          				<div class="col-lg-7">
                        	<input class="form-control" name="market_price" type="text" value="" />
                      	</div>
                      	<div class="col-lg-2 p_l0">
                          	<button class="btn btn-primary" type="button" data-toggle="integral_market_price">{lang key='goods::goods.integral_market_price'}</button>
						</div>
          			</div>
              			
          			<div class="form-group">
          				<label class="control-label col-lg-2">库存数量</label>
          				<div class="controls col-lg-7">
                        	<input class="form-control" name="goods_number" type="text" value="{ecjia::config('default_storage')}" />
                      	</div>
                      	<span class="input-must">{lang key='system::system.require_field'}</span>
          			</div>
          			<div class="form-group">
          				<label class="control-label col-lg-2">加入推荐</label>
          				<div class="col-lg-10">
          					<div class="checkbox-inline">
              					<input id="is_best" type="checkbox" name="is_best" value="1" {if $goods.store_best}checked{/if}>
              					<label for="is_best">{lang key='goods::goods.is_best'}</label>
                  				
                  				<input id="is_new" type="checkbox" name="is_new" value="1" {if $goods.store_new}checked{/if}>
                  				<label for="is_new">{lang key='goods::goods.is_new'}</label>
                  				
                  				<input id="is_hot" type="checkbox" name="is_hot" value="1" {if $goods.store_hot}checked{/if}>
                  				<label for="is_hot">{lang key='goods::goods.is_hot'}</label>
                  			</div>
                   		</div>
                  	</div>
          			<div class="form-group">
              			<label class="control-label col-lg-2">包邮</label>
              			<div class="col-lg-10">
              				<div class="checkbox-inline">
                            	<input id="is_shipping" type="checkbox" name="is_shipping" value="1" {if $goods.is_shipping}checked{/if}>
                            	<label for="is_shipping">{lang key='goods::goods.free_shipping'}</label>
                            </div>
                   		</div>
              		</div>
              		<div class="form-group">
          				<label class="control-label col-lg-2">上架</label>
          				<div class="col-lg-10">
              				<div class="checkbox-inline">
                     			<input id="is_on_sale" type="checkbox" name="is_on_sale" value="1" {if $goods.is_on_sale}checked{/if}>
                       			<label for="is_on_sale">{lang key='goods::goods.on_sale_desc'}</label>
                       		</div>
                   		</div>
                  	</div>
                  	<input type="hidden" name="goods_id" value="" />
                  	
					<div class="form-group t_c">
						<a class="btn btn-primary insertSubmit" href="javascript:;">开始导入</a>
					</div>
				</form>
           </div>
		</div>
	</div>
</div>
