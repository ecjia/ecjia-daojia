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
	        			<li {if $tag.active} class="active"{/if}><a class="data-pjax" {if $tag.active} href="javascript:;"{else} data-toggle="alertgo" data-message="{lang key='goods::goods.discard_changes'}" href='{$tag.href}'{/if}>{$tag.name}</a></li>
	            	<!-- {/foreach} -->
	    		</ul>
	    	</div>
			{/if}
          	
			<div class="panel-body panel-body-small">
				<div class="form">
					<form class="form-horizontal" enctype="multipart/form-data" action="{$form_action}" method="post" name="theForm">
						<div class="col-lg-7 pull-left">
	                		<div class="form-group m_t10">
		              			<label class="control-label col-lg-2">{lang key='goods::goods.lab_goods_name'}</label>
		              			<div class="controls col-lg-7">
		                            <input class="form-control" name="goods_name" type="text" value="{$goods.goods_name|escape}" style="color:{$goods_name_color};"/>
		                 		</div>
                           		<span class="input-must">{lang key='system::system.require_field'}</span>
		              		</div>
		              		
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{lang key='goods::goods.lab_goods_sn'}</label>
	              				<div class="col-lg-7">
	                            	<input class="form-control" name="goods_sn" type="text" value="{$goods.goods_sn|escape}" />
	                          	</div>
	              			</div>
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{lang key='goods::goods.lab_shop_price'}</label>
	              				<div class="controls col-lg-7">
	                            	<input class="form-control" name="shop_price" type="text" value="{$goods.shop_price}" />
	                          	</div>
	                          	<div class="col-lg-2 p_l0">
		                          	<a class="btn btn-primary" data-toggle="marketPriceSetted">{lang key='goods::goods.compute_by_mp'}</a>
								</div>
								<span class="input-must m_l15">{lang key='system::system.require_field'}</span>
	              			</div>
		              			
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{lang key='goods::goods.lab_market_price'}</label>
	              				<div class="col-lg-7">
	                            	<input class="form-control" name="market_price" type="text" value="{$goods.market_price}" />
	                          	</div>
	                          	<div class="col-lg-2 p_l0">
		                          	<button class="btn btn-primary" type="button" data-toggle="integral_market_price">{lang key='goods::goods.integral_market_price'}</button>
								</div>
	              			</div>
		              			
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{lang key='goods::goods.lab_goods_number'}</label>
	              				<div class="controls col-lg-7">
	                            	<input class="form-control" name="goods_number" type="text" value="{$goods.goods_number}" />
	                          	</div>
	                          	<span class="input-must">{lang key='system::system.require_field'}</span>
	              			</div>
		              			
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{lang key='goods::goods.lab_warn_number'}</label>
	              				<div class="col-lg-7">
	                            	<input class="form-control" name="warn_number" type="text" value="{$goods.warn_number}" />
	                          	</div>
	              			</div>
		              		
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{lang key='goods::goods.lab_goods_weight'}</label>
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
		            			<label class="control-label col-lg-2">{lang key='goods::goods.label_as_goods'}</label>
		              			<div class="col-lg-10">
		              				<div class="checkbox">
                                       	<input id="is_alone_sale" type="checkbox" name="is_alone_sale" value="1" {if $goods.is_alone_sale}checked{/if}>
                                   		<label for="is_alone_sale">{lang key='goods::goods.alone_sale'}</label>
                                 	</div>
		              			</div>
		         			</div>
		              			
		              		<div class="form-group">
		              			<label class="control-label col-lg-2">{lang key='goods::goods.lab_is_free_shipping'}</label>
		              			<div class="col-lg-10">
		              				<div class="checkbox">
                                    	<input id="is_shipping" type="checkbox" name="is_shipping" value="1" {if $goods.is_shipping}checked{/if}>
                                    	<label for="is_shipping">{lang key='goods::goods.free_shipping'}</label>
                                    </div>
		                   		</div>
		              		</div>
		              			
							<div class="panel-group" id="accordionOne">
					            <div class="panel panel-info">
					                <div class="panel-heading">
					                    <a data-toggle="collapse" data-parent="#accordionOne" href="#collapseOne" class="accordion-toggle">
					                    	<span class="glyphicon"></span>
					                        <h4 class="panel-title">{lang key='goods::goods.seo'}</h4>
					                    </a>
					                </div>
					                <div id="collapseOne" class="panel-collapse collapse in">
					                	<div class="panel-body">
										 	<div class="form-group">
					              				<label class="control-label col-lg-2 p_l0">{lang key='goods::goods.label_keywords'}</label>
					              				<div class="col-lg-9 p_l0">
					                            	<input class="form-control" name="keywords" type="text" value="{$goods.keywords|escape}" />
					                          	</div>
					              			</div>
					              			<div class="form-group m_b0">
					              				<label class="control-label col-lg-2 p_l0">{lang key='goods::goods.lab_goods_brief'}</label>
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
					                        <h4 class="panel-title">{lang key='goods::goods.remark_info'}</h4>
					                    </a>
					                </div>
					                <div id="collapseTwo" class="panel-collapse collapse in">
					                	<div class="panel-body">
					              			<div class="form-group m_b0">
					              				<label class="control-label col-lg-2 p_l0">{lang key='goods::goods.lab_seller_note'}</label>
					              				<div class="col-lg-9 p_l0">
					                            	<textarea class="form-control" name="seller_note" cols="40" rows="3">{$goods.seller_note}</textarea>
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
					                        <h4 class="panel-title">{lang key='goods::goods.issue'}</h4>
					                    </a>
					                </div>
					                <div id="collapseThree" class="panel-collapse collapse in">
					                	<div class="panel-body">
					              			<div class="form-group">
					              				<label class="control-label col-lg-3">{lang key='goods::goods.lab_is_on_sale'}</label>
					              				<div class="checkbox">
                                         			<input id="is_on_sale" type="checkbox" name="is_on_sale" value="1" {if $goods.is_on_sale}checked{/if}>
                                           			<label for="is_on_sale">{lang key='goods::goods.on_sale_desc'}</label>
                                           		</div>
				                          	</div>
				                          	
				                          	<div class="form-group">
					              				<label class="control-label col-lg-3">{lang key='goods::goods.lab_intro'}</label>
					              				<div class="col-lg-9 p_l0">
					              					<div class="checkbox">
					                  					<input id="is_best" type="checkbox" name="is_best" value="1" {if $goods.store_best}checked{/if}>
					                  					<label for="is_best">{lang key='goods::goods.is_best'}</label>
					                      				
					                      				<input id="is_new" type="checkbox" name="is_new" value="1" {if $goods.store_new}checked{/if}>
					                      				<label for="is_new">{lang key='goods::goods.is_new'}</label>
					                      				
					                      				<input id="is_hot" type="checkbox" name="is_hot" value="1" {if $goods.store_hot}checked{/if}>
					                      				<label for="is_hot">{lang key='goods::goods.is_hot'}</label>
					                      			</div>
                                           		</div>
				                          	</div>
				                          	
				                          	<div class="form-group m_b0">
				                          		<label class="control-label {if $goods.goods_id}col-lg-5{else}col-lg-6{/if}">
				                          			<button class="btn btn-info" type="submit">{if $goods.goods_id}{lang key='goods::goods.update'}{else}{lang key='goods::goods.next_step'}{/if}</button>
				                          			{if $step}
				                          			<button class="btn btn-info complete m_l5" type="submit" data-url='{url path="goods/merchant/edit"}'>直接完成</button>
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
					                        <h4 class="panel-title">{lang key='goods::goods.category'}</h4>
					                    </a>
					                </div>
					                <div id="collapseFour" class="panel-collapse collapse in">
					                	<div class="panel-body">
					                		<div class="form-group p_l15 m_b10">
		                                     	<label>所属平台商品分类：</label>{$cat_html}<br/>
		                                     	{if $goods.goods_id}
		                                     	<a class="data-pjax" href="{$select_cat}&goods_id={$goods.goods_id}">重新选择平台分类</a>
		                                     	{/if}
						                	</div>
						                	
						                	<div class="form-group p_l15 p_r15 m_b0">
		                                     	<label>选择店铺商品分类</label>
		                                     	<span class="input-must m_l10">{lang key='system::system.require_field'}</span>
		                                     	<div class="controls">
			                                        <select class=" form-control ecjiaf-fn" name="merchant_cat_id">
			                                        <option value="0">{lang key='system::system.select_please'}</option>
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
					                        <h4 class="panel-title">{lang key='goods::goods.goods_image'}</h4>
					                    </a>
					                </div>
					                <div id="collapseSix" class="panel-collapse collapse in">
				              			<div class="panel-body">
	                                        <label>{lang key='goods::goods.lab_picture'}</label>
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
																	<label class="ecjiaf-db">{lang key='goods::goods.goods_thumb'}</label>
																	<span {if $goods.goods_img}class="btn fileupload-btn preview-img" style="background-image: url({$goods.goods_thumb});"{else}class="btn fileupload-btn"{/if}>
																		<span class="fileupload-exists"><i class="fontello-icon-plus"></i></span>
																	</span>
																	<input class="hide" type="file" name="thumb_img" onchange="ecjia.merchant.goods_info.previewImage(this)" />
																</div>
																<div><span class="help-inline">{lang key='goods::goods.thumb_img_notice'}</span></div>
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
					                        <h4 class="panel-title">{lang key='goods::goods.promote_price'}</h4>
					                    </a>
					                </div>
					                <div id="collapseSeven" class="panel-collapse collapse">
				              			<div class="panel-body mt_15">
				              				{if $user_rank_list}
	                                        <label>{lang key='goods::goods.lab_user_price'}</label>
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
												<span class="l_h30 f_l">{lang key='goods::goods.volume_number'}</span>
												<div class="col-lg-4">
	                                            	<input class="form-control" type="text" name="volume_number[]" value="{$volume_price.number}"/>
	                                          	</div>
												<span class="l_h30 f_l">{lang key='goods::goods.volume_price'}</span>
												
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
											<a class="m_l5 l_h30 add_volume_price" href="javascript:;">{lang key='goods::goods.add_promote_price'}</a>
											<span class="help-block">购买数量达到优惠数量时享受的优惠价格</span>
	                                    </div>
			              			</div>
				        		</div>
			        		</div>
					        		
			        		<div class="panel-group">
					            <div class="panel panel-info">
					                <div class="panel-heading">
					                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseEight" class="collapsed accordion-toggle">
					                        <span class="glyphicon"></span>
					                        <h4 class="panel-title">{lang key='goods::goods.promotion_info'}</h4>
					                    </a>
					                </div>
					                <div id="collapseEight" class="panel-collapse collapse">
				              			<div class="panel-body mt_15">
	                                        <div class="form-group">
					              				<div class="control-label col-lg-4 p_r5">
					              					<input id="is_promote" class="toggle_promote l_h30" type="checkbox" name="is_promote" value="1" {if $goods.is_promote}checked{/if} />
					              					<label for="is_promote"><span class="ecjiaf-fs2">{lang key='goods::goods.lab_promote_price'}</span></label>
					              				</div>
					              				<div class="col-lg-6 p_l0">
					                          		<input class="form-control" type="text" id="promote_1" name="promote_price" value="{$goods.promote_price}" size="20"{if !$goods.is_promote} disabled{/if} />
					                          	</div>
					              			</div>
					              			
					              			<div class="form-group">
					              				<label class="control-label col-lg-4">{lang key='goods::goods.lab_promote_date'}</label>
					              				<div class="col-lg-8 p_l0">
					              					<div class="col-lg-5 p_l0 p_r0">
					                          			<input class="form-control date" type="text" name="promote_start_date" size="12" value="{$goods.promote_start_date}" />
					                          		</div>
					                          		<div class="col-lg-1">
														<span class="l_h30">-</span>
													</div>
													<div class="col-lg-5 p_l0 p_r0">
														<input class="form-control date" type="text" name="promote_end_date" size="12" value="{$goods.promote_end_date}" />
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
					                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseNine" class="collapsed accordion-toggle">
					                        <span class="glyphicon"></span>
					                        <h4 class="panel-title">{lang key='goods::goods.integral_about'}</h4>
					                    </a>
					                </div>
					                <div id="collapseNine" class="panel-collapse collapse">
				              			<div class="panel-body mt_15">
	                                        <div class="form-group">
					              				<label class="control-label col-lg-5">{lang key='goods::goods.lab_give_integral'}</label>
					              				<div class="col-lg-6">
					                            	<input class="form-control" type="text" name="give_integral" value="{$goods.give_integral}" size="20" data-toggle="parseint_input" />
					                          	</div>
					              			</div>
					              			<p class="help-block">{lang key='goods::goods.notice_give_integral'}</p>
					              			
					              			<div class="form-group">
					              				<label class="control-label col-lg-5">{lang key='goods::goods.lab_rank_integral'}</label>
					              				<div class="col-lg-6">
					                          		<input class="form-control" type="text" name="rank_integral" value="{$goods.rank_integral}" size="20" data-toggle="parseint_input" />
					                          	</div>
					              			</div>
					              			<p class="help-block">{lang key='goods::goods.notice_rank_integral'}</p>
	              			
	                                        <div class="form-group">
					              				<label class="control-label col-lg-5">{lang key='goods::goods.lab_integral'}</label>
					              				<div class="col-lg-6">
					                          		<input class="form-control" type="text" name="integral" value="{$goods.integral}" size="20" data-toggle="parseint_input" />
					                          	</div>
					              			</div>
					              			<p class="help-block">{lang key='goods::goods.notice_integral'}</p>
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