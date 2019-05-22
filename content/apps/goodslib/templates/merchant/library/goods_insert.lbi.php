<?php defined('IN_ECJIA') or exit('No permission resources.');?> 

<div class="modal fade" id="insertGoods">
	<div class="modal-dialog">
    	<div class="modal-content">
			<div class="modal-header">
				<button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
				<h4 class="modal-title">{t domain="goodslib"}导入商品{/t}</h4>
			</div>
			<div class="modal-body" style="height:auto;">
				<form class="form-horizontal" action="{$form_action}" method="post" name="insertForm">
					<div class="form-group">
          				<label class="control-label col-lg-2">{t domain="goodslib"}商品名称{/t}</label>
          				<div class="controls col-lg-7">
                        	<input class="form-control" name="goods_name" type="text" value="" />
                      	</div>
                      	<span class="input-must m_l15">*</span>
          			</div>
          			<div class="form-group">
          				<label class="control-label col-lg-2">{t domain="goodslib"}本店售价{/t}</label>
          				<div class="controls col-lg-7">
                        	<input class="form-control" name="shop_price" type="text" value="" />
                      	</div>
                      	<div class="col-lg-2 p_l0">
                          	<a class="btn btn-primary" data-toggle="marketPriceSetted">{t domain="goodslib"}按市场价计算{/t}</a>
						</div>
						<span class="input-must m_l15">*</span>
          			</div>
              			
          			<div class="form-group">
          				<label class="control-label col-lg-2">{t domain="goodslib"}市场售价{/t}</label>
          				<div class="col-lg-7">
                        	<input class="form-control" name="market_price" type="text" value="" />
                      	</div>
                      	<div class="col-lg-2 p_l0">
                          	<button class="btn btn-primary" type="button" data-toggle="integral_market_price">{t domain="goodslib"}取整数{/t}</button>
						</div>
          			</div>

                    <div class="form-group">
                        <label class="control-label col-lg-2">{t domain="goodslib"}成本价{/t}</label>
                        <div class="col-lg-7">
                            <input class="form-control" name="cost_price" type="text" value="" />
                        </div>
                    </div>
              			
          			<div class="form-group">
          				<label class="control-label col-lg-2">{t domain="goodslib"}库存数量{/t}</label>
          				<div class="controls col-lg-7">
                        	<input class="form-control" name="goods_number" type="text" value="{ecjia::config('default_storage')}" />
                      	</div>
                      	<span class="input-must">*</span>
          			</div>
          			<div class="form-group">
          				<label class="control-label col-lg-2">{t domain="goodslib"}店铺分类{/t}</label>
          				<div class="controls col-lg-7">
                        	 <select class="form-control" name="merchant_cat_id" style="width: 348px;">
                                <option value="0">{t domain="goodslib"}请选择...{/t}</option>
								<!-- {$merchant_cat} -->
                            </select>
                      	</div>
                      	<span class="input-must">*</span>
          			</div>
          			<div class="form-group">
          				<label class="control-label col-lg-2">{t domain="goodslib"}加入推荐{/t}</label>
          				<div class="col-lg-10">
          					<div class="checkbox-inline">
              					<input id="is_best" type="checkbox" name="is_best" value="1" {if $goods.store_best}checked{/if}>
              					<label for="is_best">{t domain="goodslib"}精品{/t}</label>
                  				
                  				<input id="is_new" type="checkbox" name="is_new" value="1" {if $goods.store_new}checked{/if}>
                  				<label for="is_new">{t domain="goodslib"}新品{/t}</label>
                  				
                  				<input id="is_hot" type="checkbox" name="is_hot" value="1" {if $goods.store_hot}checked{/if}>
                  				<label for="is_hot">{t domain="goodslib"}热销{/t}</label>
                  			</div>
                   		</div>
                  	</div>
          			<div class="form-group">
              			<label class="control-label col-lg-2">{t domain="goodslib"}包邮{/t}</label>
              			<div class="col-lg-10">
              				<div class="checkbox-inline">
                            	<input id="is_shipping" type="checkbox" name="is_shipping" value="1" {if $goods.is_shipping}checked{/if}>
                            	<label for="is_shipping">{t domain="goodslib"}打勾表示此商品不会产生运费花销，否则按照正常运费计算。{/t}</label>
                            </div>
                   		</div>
              		</div>
              		<div class="form-group">
          				<label class="control-label col-lg-2">{t domain="goodslib"}上架{/t}</label>
          				<div class="col-lg-10">
              				<div class="checkbox-inline">
                     			<input id="is_on_sale" type="checkbox" name="is_on_sale" value="1" {if $goods.is_on_sale}checked{/if}>
                       			<label for="is_on_sale">{t domain="goodslib"}打勾表示允许销售，否则不允许销售。{/t}</label>
                       		</div>
                   		</div>
                  	</div>
                  	<input type="hidden" name="goods_id" value="" />
                  	
					<div class="form-group t_c">
						<a class="btn btn-primary insertSubmit" href="javascript:;">{t domain="goodslib"}开始导入{/t}</a>
					</div>
				</form>
           </div>
		</div>
	</div>
</div>
