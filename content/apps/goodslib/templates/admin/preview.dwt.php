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

<div class="row-fluid">
	<div class="span12">
		<div class="panel panel-body admin_detail">
			
			<div id="detail">
				<div class="tm-detail-meta tm-clear">
					<div class="tm-clear">
						<div class="tb-property">
							<div class="tb-wrap">
							  	<div class="tb-detail-hd">
							    	<h1>{$goods.goods_name}</h1>
							    	<div class="tb-detail-sellpoint"></div>
							 	</div>
							  	<div class="tm-fcs-panel">
							    	<dl class="tm-tagPrice-panel">
							      		<dt class="tb-metatit">市场售价</dt>
							      		<dd>
							     			<em class="tm-yen">¥</em>
							    			<span class="tm-price">{$goods.market_price}</span>
							    		</dd>
							    	</dl>
							    	<dl class="{if $goods.is_promote_now}tm-tagPrice-panel{else}tm-promo-price{/if}">
								     	<dt class="tb-metatit">本店售价</dt>
								      	<dd>
								          	<em class="tm-yen">¥</em>
								          	<span class="tm-price shop_price">{$goods.shop_price}</span>&nbsp;&nbsp;
								          	<input type="hidden" name="original_price" value="{$goods.shop_price}">
								      	</dd>
							    	</dl>
							    	
							  	</div>
							  	<div class="tb-key">
							    	<div class="tb-skin">
							      		<div class="tb-sku clear">
							      			<dl class="tb-amount tm-clear">
							          			<dt class="tb-metatit">商品货号</dt>
							          			<dd id="J_Amount">
										            <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.goods_sn}</em>
										            <span id="J_StockTips"></span>
							          			</dd>
							        		</dl>
											<dl class="tb-amount tm-clear">
											    <dt class="tb-metatit">商品重量</dt>
											    <dd id="J_Amount">
											        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.goods_weight_by_unit} {$goods.goods_weight_unit}</em>
											        <span id="J_StockTips"></span>
											    </dd>
											</dl>
											{if $cat_name}
											<dl class="tb-amount tm-clear">
											    <dt class="tb-metatit">商品分类</dt>
											    <dd id="J_Amount">
											        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$cat_name}</em>
											        <span id="J_StockTips"></span>
											    </dd>
											</dl>
											{/if}
											{if $brand_name}
											<dl class="tb-amount tm-clear">
											    <dt class="tb-metatit">商品品牌</dt>
											    <dd id="J_Amount">
											        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$brand_name}</em>
											        <span id="J_StockTips"></span>
											    </dd>
											</dl>
											{/if}
											<dl class="tb-amount tm-clear">
											    <dt class="tb-metatit">添加时间</dt>
											    <dd id="J_Amount">
											        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.add_time}</em>
											        <span id="J_StockTips"></span>
											    </dd>
											</dl>
											<dl class="tb-amount tm-clear">
											    <dt class="tb-metatit">更新时间</dt>
											    <dd id="J_Amount">
											        <em id="J_EmStock" class="tb-hidden" style="display: inline;">{$goods.last_update}</em>
											        <span id="J_StockTips"></span>
											    </dd>
											</dl>
											<!-- {foreach from=$specification item=value key=key} -->
											<dl class="tb-amount tm-clear goods_spec">
                                            <dt class="tb-metatit">{$value.name}</dt>
                                                <dd>
                                                	<ul>
                                                    <!-- {foreach from=$value.value item=val key=key} -->
                                                    <li data-attr="{$val.id}" data-price="{$val.price}">{$val.label}</li>
                                            		<!-- {/foreach} -->
                                                	</ul>
                                                </dd>
                                            </dl>
                                            <!-- {/foreach} -->
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
					
					<ul id="myTab" class="nav nav-tabs m_t20">
                        <li class="active"><a href='{url path="goodslib/merchant/preview" args="&id={$goods.goods_id}"}#home' data-toggle="tab">商品详情</a></li>
                        <li class=""><a href='{url path="goodslib/merchant/preview" args="&id={$goods.goods_id}"}#attr' data-toggle="tab">商品参数</a></li>
                        <li class=""><a href='{url path="goodslib/merchant/preview" args="&id={$goods.goods_id}"}#products' data-toggle="tab">货品列表</a></li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active in" id="home">  
                            <p></p>
                            <div class="t_c clear">
                            {if $goods.goods_desc}{$goods.goods_desc}
                            {else}<p class="text-center m_t20">暂无！</p>
                            {/if}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="attr">
                        	{if $attr_list}
        					<div class="attributes-list" id="attributes">
        						<div class="tm-clear tb-hidden tm_brandAttr" style="display: block;">
        							<ul>
        								<!-- {foreach from=$attr_list item=val} -->
        			         			<li>{$val.attr_name}：{$val.attr_value}</li>
        			         			<!-- {/foreach} -->       			
        							</ul>
        						</div>
        					</div>
        					{else}
        					<p></p>
        					<p class="text-center m_t20">暂无参数！</p>
        					{/if}
                        </div>
                        <div class="tab-pane fade" id="products">
                            <p></p>
                            {if $products.product}
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>货号</th>
                                        <th class="text-center">{foreach from=$products.attr_name item=attr key=k}{if $k gt 0}|{/if}{$attr}{/foreach}</th>
                                        <th class="text-center">属性价</th>
                                        <!-- <th>规格图片</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                <!-- {foreach from=$products.product item=row} -->
                                    <tr>
                                        <td>{$row.product_sn}</td>
                                        <td class="text-center">{foreach from=$row.goods_attr item=attr key=k}{if $k gt 0}|{/if}{$attr}{/foreach}</td>
                                        <td class="text-center">{$row.goods_attr_price}</td>
                                        <!-- <td>{$row.attr_img_file}</td> -->
                                    </tr>
                                    <!-- {/foreach} -->
                                </tbody>
                            </table>
                            {else}
                            <p class="text-center m_t20">暂无货品！</p>
                            {/if}
                        </div>
                    </div>
					
				</div>
			</div>
		</div>
	</div>
</div>


<!-- {/block} -->