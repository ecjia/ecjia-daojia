<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	var images_url = "{$images_url}";
	ecjia.merchant.preview.init();
	ecjia.merchant.goods_list.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<!-- #BeginLibraryItem "/library/goods_insert.lbi" --><!-- #EndLibraryItem -->

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
							    	<dl class="tm-promo-price">
								     	<dt class="tb-metatit">{t domain="goods"}本店售价{/t}</dt>
								      	<dd>
								          	<em class="tm-yen">¥</em>
								          	<span class="tm-price">{$goods.shop_price}</span>&nbsp;&nbsp;
								      	</dd>
							    	</dl>
							  	</div>
							  	<div class="tb-key">
							    	<div class="tb-skin">
							      		<div class="tb-sku">
							      			{if $goods.cost_price gt 0 }
								      			<dl class="tb-amount tm-clear">
								          			<dt class="tb-metatit">{t domain="goods"}成本价{/t}</dt>
								          			<dd id="J_Amount">
											            <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.cost_price}</em>
											            <span id="J_StockTips"></span>
								          			</dd>
								        		</dl>
							        		{/if}
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
											<dl class="tb-amount tm-clear">
											    <dt class="tb-metatit">{t domain="goods"}平台分类{/t}</dt>
											    <dd id="J_Amount">
											        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{if $goods->category_model}{$goods->category_model->cat_name}{/if}</em>
											        <span id="J_StockTips"></span>
											    </dd>
											</dl>
											<dl class="tb-amount tm-clear">
											    <dt class="tb-metatit">{t domain="goods"}商品品牌{/t}</dt>
											    <dd id="J_Amount">
											        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{if $goods->brand_model}{$goods->brand_model->brand_name}{/if}</em>
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
											    <dt class="tb-metatit">{t domain="goods"}更新时间{/t}</dt>
											    <dd id="J_Amount">
											        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.last_update}</em>
											        <span id="J_StockTips"></span>
											    </dd>
											</dl>
											<dl class="tb-amount tm-clear">
												<a class="btn btn-info insert-goods-btn" href="javascript:;" data-href='{url path="goodslib/merchant/insert" args="goods_id={$goods.goods_id}"}' data-id="{$goods.goods_id}" data-name="{$goods.goods_name}" data-sn="{$goods.goods_sn}" data-shopprice="{$goods.shop_price}" data-marketprice="{$goods.market_price}"><i class="fa fa-plus"></i> {t domain="goodslib"}立即导入{/t}</a>
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
					{if $common_parameter_list OR $group_parameter_list}
						<div class="goods-pra">
							<div class="pra">{t domain="goods"}商品参数{/t}</div>
							<hr style="margin-top:0px;">
						</div>
					{/if}
					{if $common_parameter_list}
						<!-- #BeginLibraryItem "/library/goods_common_prameter.lbi" --><!-- #EndLibraryItem -->
					{/if}
					
					{if $group_parameter_list}
						<!-- #BeginLibraryItem "/library/goods_group_parameter.lbi" --><!-- #EndLibraryItem -->
					{/if}
					{if $goods.goods_desc}
						<div class="goods-pra">
							<div class="pra">{t domain="goods"}图文详情{/t}</div>
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