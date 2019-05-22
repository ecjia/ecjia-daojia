<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.goods_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

{if $step}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>


<div class="row edit-page">
    <div class="col-lg-12">
    	<div class="panel">
    		{if !$step}
    		<div class="panel-body panel-body-small">
				<ul class="nav nav-tabs">
	            	<!-- {foreach from=$tags item=tag} -->
	        			<li {if $tag.active} class="active"{/if}><a class="data-pjax" {if $tag.active} href="javascript:;"{else} data-toggle="alertgo" data-message="{t domain="goods"}是否放弃本页面修改？{/t}" href='{$tag.href}'{/if}>{$tag.name}</a></li>
	            	<!-- {/foreach} -->
	    		</ul>
	    	</div>
			{/if}
          	
			<div class="panel-body panel-body-small">
				<div class="form">
					<form class="form-horizontal" enctype="multipart/form-data" action="{$form_action}" method="post" name="theForm">
						<div class="col-lg-7 pull-left">
	                		<div class="form-group m_t10">
		              			<label class="control-label col-lg-2">{t domain="goods"}商品名称：{/t}</label>
		              			<div class="controls col-lg-7">
		                            <input class="form-control" name="goods_name" type="text" value="{$goods.goods_name|escape}" style="color:{$goods_name_color};"/>
		                 		</div>
                           		<span class="input-must">*</span>
		              		</div>
		              		
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{t domain="goods"}本店售价：{/t}</label>
	              				<div class="controls col-lg-7">
	                            	<input class="form-control" name="shop_price" type="text" value="{$goods.shop_price}" />
	                          	</div>
	                          	<div class="col-lg-2 p_l0">
		                          	<a class="btn btn-primary" data-toggle="marketPriceSetted">{t domain="goods"}按市场价计算{/t}</a>
								</div>
								<span class="input-must m_l15">*</span>
	              			</div>
		              			
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{t domain="goods"}市场售价：{/t}</label>
	              				<div class="col-lg-7">
	                            	<input class="form-control" name="market_price" type="text" value="{$goods.market_price}" />
	                          	</div>
	                          	<div class="col-lg-2 p_l0">
		                          	<button class="btn btn-primary" type="button" data-toggle="integral_market_price">{t domain="goods"}取整数{/t}</button>
								</div>
	              			</div>
	              			
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{t domain="goods"}成本价：{/t}</label>
	              				<div class="col-lg-7">
	                            	<input class="form-control" name="cost_price" type="text" value="{$goods.cost_price}" />
	                            	<span class="help-block">设置单品的销售成本，作为统计利润的依据，单位（元）</span>
	                          	</div>
	              			</div>
	              			
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{t domain="goods"}警告数量：{/t}</label>
	              				<div class="col-lg-7">
	                            	<input class="form-control" name="warn_number" type="text" value="{$goods.warn_number}" />
	                          	</div>
	              			</div>
		              		
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{t domain="goods"}商品重量：{/t}</label>
	              				<div class="col-lg-7">
	                            	<input class="form-control" name="goods_weight" type="text" value="{$goods.goods_weight_by_unit}" />
	                          	</div>
	                          	<div class="col-lg-2 p_l0">
		                          	<select name="weight_unit" class="form-control">
										<!-- {html_options options=$unit_list selected=$weight_unit} -->
									</select>
								</div>
	              			</div>
		              			
		              		<div class="form-group">
		            			<label class="control-label col-lg-2">{t domain="goods"}作为商品：{/t}</label>
		              			<div class="col-lg-10">
		              				<div class="checkbox">
                                       	<input id="is_alone_sale" type="checkbox" name="is_alone_sale" value="1" {if $goods.is_alone_sale}checked{/if}>
                                   		<label for="is_alone_sale">{t domain="goods"}打勾表示能作为普通商品销售，否则只能作为配件或赠品销售。{/t}</label>
                                 	</div>
		              			</div>
		         			</div>
		              			
		              		<div class="form-group">
		              			<label class="control-label col-lg-2">{t domain="goods"}是否包邮：{/t}</label>
		              			<div class="col-lg-10">
		              				<div class="checkbox">
                                    	<input id="is_shipping" type="checkbox" name="is_shipping" value="1" {if $goods.is_shipping}checked{/if}>
                                    	<label for="is_shipping">{t domain="goods"}打勾表示此商品不会产生运费花销，否则按照正常运费计算。{/t}</label>
                                    </div>
		                   		</div>
		              		</div>
		              			
							<div class="panel-group" id="accordionOne">
					            <div class="panel panel-info">
					                <div class="panel-heading">
					                    <a data-toggle="collapse" data-parent="#accordionOne" href="#collapseOne" class="accordion-toggle">
					                    	<span class="glyphicon"></span>
					                        <h4 class="panel-title">{t domain="goods"}SEO优化{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseOne" class="panel-collapse collapse in">
					                	<div class="panel-body">
										 	<div class="form-group">
					              				<label class="control-label col-lg-2 p_l0">{t domain="goods"}关键字：{/t}</label>
					              				<div class="col-lg-9 p_l0">
					                            	<input class="form-control" name="keywords" type="text" value="{$goods.keywords|escape}" />
					                          	</div>
					              			</div>
					              			<div class="form-group m_b0">
					              				<label class="control-label col-lg-2 p_l0">{t domain="goods"}简单描述：{/t}</label>
					              				<div class="col-lg-9 p_l0">
					                            	<textarea class="form-control" name="goods_brief" cols="40" rows="3">{$goods.goods_brief|escape}</textarea>
					                          	</div>
					              			</div>
				              			</div>
					        		</div>
					   	 		</div>
							</div>
							
							<div class="panel-group">
					            <div class="panel panel-info">
					                <div class="panel-heading">
					                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseTwo" class="accordion-toggle">
					                        <span class="glyphicon"></span>
					                        <h4 class="panel-title">{t domain="goods"}备注信息{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseTwo" class="panel-collapse collapse in">
					                	<div class="panel-body">
					              			<div class="form-group m_b0">
					              				<label class="control-label col-lg-2 p_l0">{t domain="goods"}商家备注：{/t}</label>
					              				<div class="col-lg-9 p_l0">
					                            	<textarea class="form-control" name="seller_note" cols="40" rows="3">{$goods.seller_note}</textarea>
					                            	<span class="help-block">此备注仅限商家管理员可见，主要用于记录特殊商品信息，方便管理员管理</span>
					                          	</div>
					              			</div>
				              			</div>
					        		</div>
					   	 		</div>
							</div>
						</div>
		                	
	                	<div class="col-lg-5 pull-right">
							<div class="panel-group">
					            <div class="panel panel-info">
					                <div class="panel-heading">
					                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseThree" class="accordion-toggle">
					                        <span class="glyphicon"></span>
					                        <h4 class="panel-title">{t domain="goods"}发布{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseThree" class="panel-collapse collapse in">
					                	<div class="panel-body">
					              			<div class="form-group">
					              				<label class="control-label col-lg-3">{t domain="goods"}上架：{/t}</label>
					              				<div class="checkbox">
                                         			<input id="is_on_sale" type="checkbox" name="is_on_sale" value="1" {if $goods.is_on_sale}checked{/if}>
                                           			<label for="is_on_sale">{t domain="goods"}打勾表示允许销售，否则不允许销售。{/t}</label>
                                           		</div>
				                          	</div>
				                          	
				                          	<div class="form-group">
					              				<label class="control-label col-lg-3">{t domain="goods"}加入推荐：{/t}</label>
					              				<div class="col-lg-9 p_l0">
					              					<div class="checkbox">
					                  					<input id="is_best" type="checkbox" name="is_best" value="1" {if $goods.store_best}checked{/if}>
					                  					<label for="is_best">{t domain="goods"}精品{/t}</label>
					                      				
					                      				<input id="is_new" type="checkbox" name="is_new" value="1" {if $goods.store_new}checked{/if}>
					                      				<label for="is_new">{t domain="goods"}新品{/t}</label>
					                      				
					                      				<input id="is_hot" type="checkbox" name="is_hot" value="1" {if $goods.store_hot}checked{/if}>
					                      				<label for="is_hot">{t domain="goods"}热销{/t}</label>
					                      			</div>
                                           		</div>
				                          	</div>
				                          	
				                          	<div class="form-group m_b0">
				                          		<label class="control-label {if $goods.goods_id}col-lg-5{else}col-lg-6{/if}">
				                          			<button class="btn btn-info" type="submit">{if $goods.goods_id}{t domain="goods"}更新{/t}{else}{t domain="goods"}下一步{/t}{/if}</button>
				                          			{if $step}
				                          			<button class="btn btn-info complete m_l5" type="submit" data-url='{url path="goods/merchant/edit"}' data-complete="1">{t domain="goods"}直接完成{/t}</button>
													{/if}
													<input type="hidden" id="type" value="{$link.type}" />
													<input type="hidden" name="goods_id" value="{$goods.goods_id}" />
				                          		</label>
				                          	</div>
			                          	</div>
			              			</div>
				        		</div>
				   	 		</div>
							
							<div class="panel-group">
					            <div class="panel panel-info">
					                <div class="panel-heading">
					                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseFour" class="accordion-toggle">
					                        <span class="glyphicon"></span>
					                        <h4 class="panel-title">{t domain="goods"}商品分类{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseFour" class="panel-collapse collapse in">
					                	<div class="panel-body">
					                		<div class="form-group p_l15 m_b10">
		                                     	<label>{t domain="goods"}所属平台商品分类：{/t}</label>{$cat_html}<br/>
		                                     	{if $goods.goods_id}
		                                     	<a class="data-pjax" href="{$select_cat}&goods_id={$goods.goods_id}">{t domain="goods"}重新选择平台分类{/t}</a>
		                                     	{/if}
						                	</div>
						                	
						                	<div class="form-group p_l15 p_r15 m_b0">
		                                     	<label>{t domain="goods"}选择店铺商品分类{/t}</label>
		                                     	<span class="input-must m_l10">*</span>
		                                     	<div class="controls">
			                                        <select class=" form-control ecjiaf-fn" name="merchant_cat_id">
			                                        <option value="0">{t domain="goods"}请选择...{/t}</option>
													<!-- {$merchant_cat} -->
			                                        </select>
		                                        </div>
						                	</div>
					                	</div>
				              		</div>
					 			</div>
							</div>
								
			        		<div class="panel-group">
				        		<div class="panel panel-info">
					                <div class="panel-heading">
					                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseSix" class="accordion-toggle">
					                        <span class="glyphicon"></span>
					                        <h4 class="panel-title">{t domain="goods"}商品图片{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseSix" class="panel-collapse collapse in">
				              			<div class="panel-body">
	                                        <label>{t domain="goods"}上传商品图片：{/t}</label>
	                                    	<div class="accordion-group">
		                                    	<div class="accordion-body in collapse" id="goods_info_area_img">
													<div class="accordion-inner">
														<div class="control-group">
															<div class="ecjiaf-db">
																<div class="goods_img">
																	<span {if $goods.goods_img}class="btn fileupload-btn preview-img" style="background-image: url({$goods.goods_img});"{else}class="btn fileupload-btn"{/if}>
																		<span class="fileupload-exists"><i class="glyphicon glyphicon-plus"></i></span>
																	</span>
																	<input class="hide" type="file" name="goods_img" onchange="ecjia.merchant.goods_info.previewImage(this)" />
																</div>
																<div class="thumb_img{if !$goods.goods_thumb} hide{/if}">
																	<label class="ecjiaf-db">{t domain="goods"}商品缩略图：{/t}</label>
																	<span {if $goods.goods_img}class="btn fileupload-btn preview-img" style="background-image: url({$goods.goods_thumb});"{else}class="btn fileupload-btn"{/if}>
																		<span class="fileupload-exists"><i class="fontello-icon-plus"></i></span>
																	</span>
																	<input class="hide" type="file" name="thumb_img" onchange="ecjia.merchant.goods_info.previewImage(this)" />
																</div>
																<div><span class="help-inline">{t domain="goods"}点击更换商品图片或商品缩略图。{/t}</span></div>
															</div>
														</div>
													</div>
												</div>
											</div>
	                                    </div>
			              			</div>
				        		</div>
			        		</div>
								
							<div class="panel-group">
					            <div class="panel panel-info">
					                <div class="panel-heading">
					                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseSeven" class="collapsed accordion-toggle">
					                        <span class="glyphicon"></span>
					                        <h4 class="panel-title">{t domain="goods"}折扣、促销价格{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseSeven" class="panel-collapse collapse">
				              			<div class="panel-body mt_15">
				              				{if $user_rank_list}
	                                        <label>{t domain="goods"}会员价格：{/t}</label>
	                                        <!-- {foreach from=$user_rank_list item=user_rank} -->
											<div class="m_l30">
												<span class="f_l w80 text-left l_h30">{$user_rank.rank_name|truncate:"10":".."}</span>
												<div class="col-lg-4">
												<input type="text" id="rank_{$user_rank.rank_id}" class="form-control " name="user_price[]" value="{$member_price_list[$user_rank.rank_id]|default:-1}" size="8" />
												</div>
												<input type="hidden" name="user_rank[]" value="{$user_rank.rank_id}" />
												<span class="m_l5 l_h30" id="nrank_{$user_rank.rank_id}"></span>&nbsp;
											</div>
											<br>
											<!-- {/foreach} -->
											{/if}

											<!-- {foreach from=$volume_price_list item=volume_price name="volume_price_tab"} -->
											<div class="m_l30 goods-span row m_t5">
												<span class="l_h30 f_l">{t domain="goods"}优惠数量{/t}</span>
												<div class="col-lg-4">
	                                            	<input class="form-control" type="text" name="volume_number[]" value="{$volume_price.number}"/>
	                                          	</div>
												<span class="l_h30 f_l">{t domain="goods"}优惠价格{/t}</span>
												
												<div class="col-lg-4">
													<input class="form-control" type="text" name="volume_price[]" value="{$volume_price.price}"/>
												</div>
												<span>
													{if $smarty.foreach.volume_price_tab.last}
													<a class="l_h30 t_l no-underline" href="javascript:;" data-toggle="clone-obj" data-parent=".goods-span">
														<i class="fontello-icon-plus hide"></i>
													</a>
													{else}
													<a class="l_h30 t_l no-underline" href="javascript:;" data-toggle="remove-obj" data-parent=".goods-span">
														<i class="fa fa-times"></i>
													</a>
													{/if}
												</span>
												
											</div>
											<!-- {/foreach} -->
											<a class="m_l5 l_h30 add_volume_price" href="javascript:;">{t domain="goods"}添加优惠价格{/t}</a>
											<span class="help-block">{t domain="goods"}购买数量达到优惠数量时享受的优惠价格{/t}</span>
	                                    </div>
			              			</div>
				        		</div>
			        		</div>
					        		
			        		<div class="panel-group">
					            <div class="panel panel-info">
					                <div class="panel-heading">
					                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseEight" class="collapsed accordion-toggle">
					                        <span class="glyphicon"></span>
					                        <h4 class="panel-title">{t domain="goods"}促销信息{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseEight" class="panel-collapse collapse">
				              			<div class="panel-body mt_15">
                                            {if $goods.is_promote eq 1}
                                            <div class="form-group">
                                                <div class="control-label col-lg-3 p_r5">
                                                    <label><span class="ecjiaf-fs2">{t domain="goods"}活动状态：{/t}</span></label>
                                                </div>
                                                <div class="col-lg-8 p_l0 checkbox">
                                                    <span class="promote-status {$goods.promote_status}">{$goods.promote_status_label}</span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="control-label col-lg-3 p_r5">
                                                    <label><span class="ecjiaf-fs2">{t domain="goods"}活动时间：{/t}</span></label>
                                                </div>
                                                <div class="col-lg-8 p_l0 checkbox">
                                                    {$goods.promote_start_date} ~ {$goods.promote_end_date}
                                                </div>
                                            </div>

                                            <div class="form-group m_b0">
                                                <div class="control-label col-lg-3 p_r5">
                                                    <a target="_blank" class="btn btn-info" href="{RC_Uri::url('promotion/merchant/edit')}&id={$goods.goods_id}">{t domain="goods"}查看促销{/t}</a>
                                                </div>
                                            </div>
                                            {else}
                                            <div class="form-group m_b0">
                                                <div class="control-label col-lg-3 p_r5">
                                                    <a target="_blank" class="btn btn-info" href="{RC_Uri::url('promotion/merchant/add')}{if $goods.goods_id}&id={$goods.goods_id}{/if}">{t domain="goods"}添加促销{/t}</a>
                                                </div>
                                            </div>
                                            {/if}
	                                    </div>
			              			</div>
				        		</div>
			        		</div>
					        		
			        		<div class="panel-group">
					            <div class="panel panel-info">
					                <div class="panel-heading">
					                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseNine" class="collapsed accordion-toggle">
					                        <span class="glyphicon"></span>
					                        <h4 class="panel-title">{t domain="goods"}积分相关{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseNine" class="panel-collapse collapse">
				              			<div class="panel-body mt_15">
	                                        <div class="form-group">
					              				<label class="control-label col-lg-5">{t domain="goods"}积分购买金额：{/t}</label>
					              				<div class="col-lg-6">
					                          		<input class="form-control" type="text" name="integral" value="{$goods.integral}" size="20" data-toggle="parseint_input" />
					                          	</div>
					              			</div>
					              			<p class="help-block">{t domain="goods"}(此处需填写金额)购买该商品时最多可以使用积分的金额{/t}</p>
	                                    </div>
			              			</div>
				        		</div>
			        		</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->