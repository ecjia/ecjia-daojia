<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	var images_url = "{$images_url}";
	ecjia.merchant.preview.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
<div class="page-header">
	<div class="pull-left">
		<h2>
			<!-- {if $ur_here}{$ur_here}{/if} -->
		</h2>	
	</div>	
	<div class="pull-right">
		<!-- {if $action_link} -->
		<a class="btn btn-primary data-pjax" href="{$action_link.href}" id="sticky_a"><i class="fa fa-reply"></i> {$action_link.text} </a>
		<!-- {/if} -->	
	</div>	
	<div class="clearfix"></div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-body">
			<div id="detail">
				<div class="tm-detail-meta tm-clear">
					<div class="tm-clear">
						<div class="tb-property">
							<div class="tb-wrap">
							  	<div class="tb-detail-hd">
							    	<div data-spm="1000983" class="goods-name-style"><strong>{$goods.goods_name}</strong></div>
							    	<div class="tb-detail-sellpoint"></div>
							 	</div>
							  	<div class="tm-fcs-panel">
							    	<dl class="tm-tagPrice-panel">
							      		<dt class="tb-metatit">{t domain="goods"}市场售价{/t}</dt>
							      		<dd>
							     			<em class="tm-yen">¥</em>
							    			<span class="tm-price">{$goods.market_price}</span>
							    		</dd>
							    	</dl>
							    	<dl class="{if $goods.is_promote_now}tm-tagPrice-panel{else}tm-promo-price{/if}">
								     	<dt class="tb-metatit">{t domain="goods"}本店售价{/t}</dt>
								      	<dd>
								          	<em class="tm-yen">¥</em>
								          	<span class="tm-price">{$goods.shop_price}</span>&nbsp;&nbsp;
								      	</dd>
							    	</dl>
							    	
							    	{if $goods.is_promote_now}
								    	<dl class="tm-promo-panel tm-promo-cur">
									     	<dt class="tb-metatit">{t domain="goods"}促销价格{/t}</dt>
									      	<dd>
									        	<div class="tm-promo-price">
									          		<em class="tm-yen">¥</em>
									          		<span class="tm-price">{$goods.promote_price}</span>&nbsp;&nbsp;
									          	</div>
									      	</dd>
								    	</dl>
								    	
								    	<dl class="tm-promo-panel tm-promo-cur">
									     	<dt class="tb-metatit">{t domain="goods"}促销有效期{/t}</dt>
									      	<dd>
									          	<span class="tm-price"><span class="ecjiafc-red">{$goods.formated_promote_start_date}</span> {t domain="goods"}至{/t} <span class="ecjiafc-red">{$goods.formated_promote_end_date}</span></span>
									      	</dd>
								    	</dl>
							    	{/if}
							  	</div>
							  	<div class="tb-key">
							    	<div class="tb-skin">
							      		<div class="tb-sku">
							      			<!-- {if $goods.cost_price gt 0} -->
								      			<dl class="tb-amount tm-clear">
								          			<dt class="tb-metatit">{t domain="goods"}成本价{/t}</dt>
								          			<dd id="J_Amount">
											            <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.format_cost_price}</em>
											            <span id="J_StockTips"></span>
								          			</dd>
								        		</dl>
							        		<!-- {/if} -->
							      			<dl class="tb-amount tm-clear">
							          			<dt class="tb-metatit">{t domain="goods"}商品货号{/t}</dt>
							          			<dd id="J_Amount">
										            <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.goods_sn}</em>
										            <span id="J_StockTips"></span>
							          			</dd>
							        		</dl>
							        		{if $goods.goods_barcode}
								        		<dl class="tb-amount tm-clear">
								          			<dt class="tb-metatit">{t domain="goods"}条形码{/t}</dt>
								          			<dd id="J_Amount">
											            <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.goods_barcode}</em>
											            <span id="J_StockTips"></span>
								          			</dd>
								        		</dl>
								        	{/if}
								        	{if $goods.goods_weight gt 0}
								        		<dl class="tb-amount tm-clear">
								          			<dt class="tb-metatit">{t domain="goods"}商品重量{/t}</dt>
								          			<dd id="J_Amount">
											            <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.goods_weight}{if $goods.weight_unit eq 1}克{else}千克{/if}</em>
											            <span id="J_StockTips"></span>
								          			</dd>
								        		</dl>
							        		{/if}
							        		{if $goods->category_model}
							        			{if $goods->category_model->cat_name}
												<dl class="tb-amount tm-clear">
												    <dt class="tb-metatit">{t domain="goods"}平台分类{/t}</dt>
												    <dd id="J_Amount">
												        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{if $goods->category_model}{$goods->category_model->cat_name}{/if}</em>
												        <span id="J_StockTips"></span>
												    </dd>
												</dl>
												{/if}
											{/if}
											<dl class="tb-amount tm-clear">
											    <dt class="tb-metatit">{t domain="goods"}店铺分类{/t}</dt>
											    <dd id="J_Amount">
											        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{if $goods->merchants_category_model}{$goods->merchants_category_model->cat_name}{/if}</em>
											        <span id="J_StockTips"></span>
											    </dd>
											</dl>
											<dl class="tb-amount tm-clear">
							          			<dt class="tb-metatit">{t domain="goods"}商品排序{/t}</dt>
							          			<dd id="J_Amount">
							            			<em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.sort_order}</em>
							            			<span id="J_StockTips"></span>
							          			</dd>
							        		</dl>
											<dl class="tb-amount tm-clear">
											    <dt class="tb-metatit">{t domain="goods"}添加时间{/t}</dt>
											    <dd id="J_Amount">
											        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.add_time}</em>
											        <span id="J_StockTips"></span>
											    </dd>
											</dl>
											<dl class="tb-amount tm-clear">
											    <dt class="tb-metatit">{t domain="goods"}库存{/t}</dt>
											    <dd id="J_Amount">
											        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.goods_number}</em>
											        <span id="J_StockTips"></span>
											    </dd>
											</dl>
											<dl class="tb-amount tm-clear">
												{if $goods.is_on_sale eq '1'}
													<a class="btn btn-info off-sale" data-trigger="goods_on_sale" data-url="{RC_Uri::url('goods/merchant/toggle_on_sale')}" data-id="{$goods.goods_id}" refresh-url="{RC_Uri::url('goods/merchant/preview')}&id={$goods.goods_id}">{t domain="goods"}商品下架{/t}</a>
													{if $preview_type eq 'selling'}
														<a target="_blank" class="btn btn-info" href='{url path="goods/merchant/pc_preview" args="id={$goods.goods_id}"}'>{t domain='goods'}PC效果{/t}</a>
														<a target="_blank" class="btn btn-info" href='{url path="goods/merchant/h5_preview" args="id={$goods.goods_id}"}'>{t domain='goods'}手机端效果{/t}</a>
													{/if}
												{else}
													<a class="btn btn-info on-sale" data-trigger="goods_on_sale" data-url="{RC_Uri::url('goods/merchant/toggle_on_sale')}" data-id="{$goods.goods_id}" refresh-url="{RC_Uri::url('goods/merchant/preview')}&id={$goods.goods_id}">{t domain="goods"}商品上架{/t}</a>
												{/if}
											</dl>
										</div>
							    	</div>
							  	</div>
							</div>
						</div>
						<div class="tb-gallery">
							<div id="tbody">
								{if $goods_photo_list}
							    <div id="mainbody">
							    	<!-- {foreach from=$goods_photo_list key=k item=val} -->
							    	{if $k eq 0}
							      	<img src="{$val.img_url}" id="mainphoto" />
							      	{/if}
							      	<!-- {/foreach} -->
							    </div>
							    <img src="{$images_url}/goleft.gif" width="11" height="56" id="goleft" />
							    <img src="{$images_url}/goright.gif" width="11" height="56" id="goright" />
							    <div id="photos">
							    	<div id="showArea">
								        <!-- SRC: 缩略图地址 REL: 大图地址  NAME: 网址 -->
								        <!-- {foreach from=$goods_photo_list key=k item=val} -->
								        <img src="{$val.thumb_url}" rel="{$val.img_url}" />
								        <!-- {/foreach} -->
							      	</div>
							    </div>
							    {else}
							    <div id="mainbody">
							    	<img src="{$no_picture}" id="mainphoto" />
							    </div>
							    {/if}
							</div>
						</div>
					</div>
					
					{if $product_list}
					<!-- #BeginLibraryItem "/library/goods_products.lbi" --><!-- #EndLibraryItem -->
					{/if}
					
					<div class="goods-pra">
						<div class="pra">{t domain="goods"}商品参数{/t}
							<div class="pra-handle">
								<a target="_blank" href='{url path="goods/merchant/edit_goods_parameter" args="goods_id={$goods.goods_id}"}'><span class="pra-edit">{t domain='goods'}编辑{/t}>></span></a>
							</div>
						</div>
						<hr style="margin-top:0px;">
					</div>
					{if $common_parameter_list}
						<!-- #BeginLibraryItem "/library/goods_common_prameter.lbi" --><!-- #EndLibraryItem -->
					{/if}
					
					{if $group_parameter_list}
						<!-- #BeginLibraryItem "/library/goods_group_parameter.lbi" --><!-- #EndLibraryItem -->
					{/if}
					{if $goods.goods_desc}
					<div class="goods-pra">
						<div class="pra">{t domain="goods"}图文详情{/t}
							<div class="pra-handle">
								<a target="_blank" href='{url path="goods/merchant/edit_goods_desc" args="goods_id={$goods.goods_id}"}'><span class="pra-edit">{t domain='goods'}编辑{/t}>></span></a>
							</div>
						</div>
						<hr style="margin-top:0px;">
					</div>
					<div class="t_c clear">{$goods.goods_desc}</div>
					{/if}
				</div>
			</div>
		</div>
	</div>
</div>


<!-- {/block} -->