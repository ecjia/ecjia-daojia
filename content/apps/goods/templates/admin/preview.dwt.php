<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	var images_url = "{$images_url}";
	ecjia.admin.preview.init();
	ecjia.admin.goods_list.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->

<!-- #BeginLibraryItem "/library/goods_check.lbi" --><!-- #EndLibraryItem -->

<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		{if $action_link}
		<a class="btn plus_or_reply data-pjax" href="{$action_link.href}{if $code}&extension_code={$code}{/if}" id="sticky_a" ><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		{/if}
	</h3>	
</div>

<div id="detail">
	<div class="tm-detail-meta tm-clear">
		<div class="row-fluid tm-clear" style="margin-bottom:20px;">
			<div class="span8">
				<div class="tb-property">
				  	<div class="">
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
					     	<dt class="tb-metatit">{t domain="goods"}促销时间{/t}</dt>
					      	<dd>
					          	<span class="tm-price">{$goods.promote_start_time} {t domain="goods"}至{/t} {$goods.promote_end_time}</span>
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
				        		<!-- {if $goods.goods_barcode} -->
					        		<dl class="tb-amount tm-clear">
					          			<dt class="tb-metatit">{t domain="goods"}商品条形码{/t}</dt>
					          			<dd id="J_Amount">
								            <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.goods_barcode}</em>
								            <span id="J_StockTips"></span>
					          			</dd>
					        		</dl>
					        	<!-- {/if} -->
					        	<!-- {if $goods.goods_weight gt 0} -->
						        	<dl class="tb-amount tm-clear">
									    <dt class="tb-metatit">{t domain="goods"}商品重量{/t}</dt>
									    <dd id="J_Amount">
									        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.goods_weight}{if $goods.weight_unit eq 1}克{else}千克{/if}</em>
									        <span id="J_StockTips"></span>
									    </dd>
									</dl>
								<!-- {/if} -->
				        		<dl class="tb-amount tm-clear">
				          			<dt class="tb-metatit">{t domain="goods"}警告数量{/t}</dt>
				          			<dd id="J_Amount">
				            			<em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.warn_number}{t domain="goods"}件{/t}</em>
				            			<span id="J_StockTips"></span>
				          			</dd>
				        		</dl>
								<dl class="tb-amount tm-clear">
								    <dt class="tb-metatit">{t domain="goods"}平台分类{/t}</dt>
								    <dd id="J_Amount">
								        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{if $goods.category_model}{$goods.category_model.cat_name}{/if}</em>
								        <span id="J_StockTips"></span>
								    </dd>
								</dl>
								<dl class="tb-amount tm-clear">
								    <dt class="tb-metatit">{t domain="goods"}店铺分类{/t}</dt>
								    <dd id="J_Amount">
								        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{if $goods->merchants_category_model}{$goods->merchants_category_model->cat_name}{/if}</em>
								        <span id="J_StockTips"></span>
								    </dd>
								</dl>
								<!-- {if $goods->brand_model} -->
									<!-- {if $goods->brand_model->brand_name} -->
										<dl class="tb-amount tm-clear">
										    <dt class="tb-metatit">{t domain="goods"}商品品牌{/t}</dt>
										    <dd id="J_Amount">
										        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{if $goods->brand_model}{$goods->brand_model->brand_name}{/if}</em>
										        <span id="J_StockTips"></span>
										    </dd>
										</dl>
									<!-- {/if} -->
								<!-- {/if} -->
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
								    <dt class="tb-metatit">{t domain="goods"}库存{/t}</dt>
								    <dd id="J_Amount">
								        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.goods_number}</em>
								        <span id="J_StockTips"></span>
								    </dd>
								</dl>
								<dl class="tb-amount tm-clear">
									{if $preview_type eq 'await_check' And $goods.review_status eq 1}
										<a class="btn btn-gebo" data-toggle="modal" data-backdrop="static" href="#myModal2" goods-id="{$goods.goods_id}">{t domain='goods'}审核{/t}</a>
									{/if}
									{if $action}
								    	<a class="btn btn-gebo" target="_blank" href="{RC_Uri::url('goods/admin/autologin')}&store_id={$goods.store_id}&url={$edit_url}">去编辑</a>
									{/if}
									{if $preview_type eq 'selling'}
										<a class="btn btn-gebo" target="_blank" href="{RC_Uri::url('goods/admin/pc_preview')}&id={$goods.goods_id}">PC效果</a>
										<a class="btn btn-gebo" target="_blank" href="{RC_Uri::url('goods/admin/h5_preview')}&id={$goods.goods_id}">手机端效果</a>
									{/if}
								</dl>
							</div>
				    	</div>
				  	</div>
				</div>
			</div>
			<div class="span4">
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
				    	<img src="{$no_picture}" id="mainphoto"/>
				    </div>
				    {/if}
				</div>
				<!-- #BeginLibraryItem "/library/goods_store_info.lbi" --><!-- #EndLibraryItem -->
			</div>
		</div>
		
		{if $product_list}
			<!-- #BeginLibraryItem "/library/goods_products.lbi" --><!-- #EndLibraryItem -->
		{/if}
		
		{if $common_parameter_list OR $group_parameter_list}
			<h3 class="heading">{t domain="goods"}商品参数{/t}</h3>
		{/if}
		{if $common_parameter_list}
			<!-- #BeginLibraryItem "/library/goods_common_prameter.lbi" --><!-- #EndLibraryItem -->
		{/if}
		{if $group_parameter_list}
			<!-- #BeginLibraryItem "/library/goods_group_prameter.lbi" --><!-- #EndLibraryItem -->
		{/if}
		<div>
			<h3 class="heading">{t domain="goods"}图文详情{/t}</h3>
			<div class="t_c clear">{$goods.goods_desc}</div>
		</div>
	</div>
</div>
<!-- {/block} -->