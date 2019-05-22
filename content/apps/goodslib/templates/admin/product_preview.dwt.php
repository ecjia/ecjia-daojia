<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.preview.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} --> 

<div>
	<h3 class="heading"> 
		<!-- {if $ur_here}{$ur_here}{/if} --> 
		<!-- {if $action_link} -->
    	<a class="btn plus_or_reply data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
    	<!-- {/if} -->
	</h3>
</div>

<div id="detail">
	<div class="tm-detail-meta tm-clear">
		<div class="row-fluid tm-clear" style="margin-bottom:20px;">
			<div class="span7">
				<div class="tb-property">
				  	<div class="">
				    	<div data-spm="1000983" class="goods-name-style"><strong>{$product.product_name}</strong></div>
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
					          	<span class="tm-price">{$product.product_shop_price}</span>&nbsp;&nbsp;
					      	</dd>
				    	</dl>
				  	</div>
				  	<div class="tb-key">
				    	<div class="tb-skin">
				      		<div class="tb-sku">
				      			<dl class="tb-amount tm-clear">
				          			<dt class="tb-metatit">{t domain="goods"}商品货号{/t}</dt>
				          			<dd id="J_Amount">
							            <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$product.product_sn}</em>
							            <span id="J_StockTips"></span>
				          			</dd>
				        		</dl>
				        		<!-- {if $product.product_bar_code} -->
					        		<dl class="tb-amount tm-clear">
					          			<dt class="tb-metatit">{t domain="goods"}商品条形码{/t}</dt>
					          			<dd id="J_Amount">
								            <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$product.product_bar_code}</em>
								            <span id="J_StockTips"></span>
					          			</dd>
					        		</dl>
					        	<!-- {/if} -->
								<dl class="tb-amount tm-clear">
								    <dt class="tb-metatit">{t domain="goods"}商品分类{/t}</dt>
								    <dd id="J_Amount">
								        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{if $goods.category_model}{$goods.category_model.cat_name}{/if}</em>
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
								    <a class="btn btn-gebo" target="_blank" href="{RC_Uri::url('goodslib/admin/product_edit')}&id={$product.product_id}&goods_id={$goods.goods_id}">去编辑</a>
								</dl>
							</div>
				    	</div>
				  	</div>
				</div>
			</div>
			<div class="span5">
				<div id="tbody">
					{if $product_photo_list}
				    <div id="mainbody">
				    	<!-- {foreach from=$product_photo_list key=k item=val} -->
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
					        <!-- {foreach from=$product_photo_list key=k item=val} -->
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
			</div>
		</div>
		
		<!-- {if $common_parameter_list OR $group_parameter_list}-->
			<div>
				<h3 class="heading">{t domain="goods"}商品参数{/t}
					<a class="pra-handle" "target="_blank" href='{url path="goodslib/admin/edit_goods_parameter" args="goods_id={$goods.goods_id}"}'><span class="pra-edit">{t domain='goodslib'}编辑{/t}>></span></a>
				</h3>
			</div>
		<!-- {/if}-->
		
		<!-- {if $common_parameter_list}-->
			<!-- #BeginLibraryItem "/library/goods_common_prameter.lbi" --><!-- #EndLibraryItem -->
		<!-- {/if}-->
		
		<!-- {if $group_parameter_list}-->
			<!-- #BeginLibraryItem "/library/goods_group_prameter.lbi" --><!-- #EndLibraryItem -->
		<!-- {/if}-->
		<div>
			<h3 class="heading">{t domain="goods"}图文详情{/t}
				<a class="pra-handle" "target="_blank" href='{url path="goodslib/admin/edit_goods_desc" args="goods_id={$goods.goods_id}"}'><span class="pra-edit">{t domain='goodslib'}编辑{/t}>></span></a>
			</h3>
			<div class="t_c clear">{$product.product_desc}</div>
		</div>
	</div>
</div>	
<!-- {/block} -->