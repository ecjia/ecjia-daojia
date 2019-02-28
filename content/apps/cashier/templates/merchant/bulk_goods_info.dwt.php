<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.bulk_goods_info.init();
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

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
			<div class="panel-body panel-body-small">
				<div class="form">
					<form class="form-horizontal" enctype="multipart/form-data" action="{$form_action}" method="post" name="theForm">
						<div class="col-lg-7 pull-left">
	                		<div class="form-group m_t10">
		              			<label class="control-label col-lg-2">{t domain="cashier"}商品名称：{/t}</label>
		              			<div class="controls col-lg-7">
		                            <input class="form-control" name="goods_name" type="text" value="{$goods.goods_name|escape}"/>
		                 		</div>
                           		<span class="input-must">*</span>
		              		</div>
		              		
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{t domain="cashier"}商品货号：{/t}</label>
	              				<div class="col-lg-7">
	                            	<input class="form-control" name="goods_sn" type="text" value="{$goods.goods_sn|escape}" />
	                            	<span class="help-block">{t domain="cashier"}散装商品货号共7位，前2位必须填写条码秤编码{/t}</span>
	                          	</div>
	                          	<span class="input-must m_l15">*</span>
	              			</div>
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{t domain="cashier"}本店售价：{/t}</label>
	              				<div class="controls col-lg-7">
	                            	<input class="form-control" name="shop_price" type="text" value="{$goods.shop_price}" />
	                          	</div>
	                          	<div class="col-lg-2 p_l0">
		                          	<a class="btn btn-primary" data-toggle="marketPriceSetted">{t domain="cashier"}按市场价计算{/t}</a>
								</div>
								<span class="input-must m_l15">*</span>
	              			</div>
		              			
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{t domain="cashier"}市场售价：{/t}</label>
	              				<div class="col-lg-7">
	                            	<input class="form-control" name="market_price" type="text" value="{$goods.market_price}" />
	                          	</div>
	                          	<div class="col-lg-2 p_l0">
		                          	<button class="btn btn-primary" type="button" data-toggle="integral_market_price">{t domain="cashier"}取整数{/t}</button>
								</div>
	              			</div>
		              		
		              		<div class="form-group">
	              				<label class="control-label col-lg-2">{t domain="cashier"}库存重量：{/t}</label>
	              				<div class="col-lg-7">
	                            	<input class="form-control" name="weight_stock" type="text" value="{$goods.weight_stock}" />
	                          	</div>
	                          	<div class="col-lg-2 p_l0">
		                          	<select name="weight_unit" class="form-control">
										<!-- {html_options options=$unit_list selected=$weight_unit} -->
									</select>
								</div>
								<span class="input-must m_l15">*</span>
	              			</div>
	              			
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">{t domain="cashier"}警告重量：{/t}</label>
	              				<div class="col-lg-7">
	                            	<input class="form-control" name="warn_number" type="text" value="{$goods.warn_number}" />
	                          	</div>
	              			</div>
		              			
							<div class="panel-group" id="accordionOne">
					            <div class="panel panel-info">
					                <div class="panel-heading">
					                    <a data-toggle="collapse" data-parent="#accordionOne" href="#collapseOne" class="accordion-toggle">
					                    	<span class="glyphicon"></span>
					                        <h4 class="panel-title">{t domain="cashier"}特殊属性{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseOne" class="panel-collapse collapse in">
					                	<div class="panel-body">
										 	<div class="form-group">
					              				<label class="control-label col-lg-2 p_l0">{t domain="cashier"}进货价：{/t}</label>
					              				<div class="col-lg-9 p_l0">
					                            	<input class="form-control" name="cost_price" type="text" value="{$goods.cost_price}" />
					                          	</div>
					              			</div>
					              			<div class="form-group">
					              				<label class="control-label col-lg-2 p_l0">{t domain="cashier"}生产日期：{/t}</label>
					              				<div class="col-lg-9 p_l0">
					                            	<input class="form-control date generate-date" name="generate_date" action='{url path="cashier/mh_bulk_goods/get_expire_date"}' type="text" value="{$goods.generate_date}" />
					                          	</div>
					              			</div>
					              			<div class="form-group">
					              				<label class="control-label col-lg-2 p_l0">{t domain="cashier"}保质期：{/t}</label>
					              				<div class="col-lg-7 p_l0">
					                            	<input class="form-control limitday" name="limit_days" action='{url path="cashier/mh_bulk_goods/get_expire_date"}' type="text" value="{if $goods.limitdays}{$goods.limitdays}{else}1{/if}" />
					                          	</div>
				                          		<div class="col-lg-2 p_l0">
						                          	<select name="limit_days_unit" class="form-control day-unit" action='{url path="cashier/mh_bulk_goods/get_expire_date"}'>
														<!-- {foreach from=$limit_days_unit key=key item=val} -->
														<option value="{$key}" {if $goods.limitday_unit eq $key}selected{/if}>{$val}</option>
														<!-- {/foreach} -->
													</select>
												</div>
					              			</div>
					              			<div class="form-group">
					              				<label class="control-label col-lg-2 p_l0">{t domain="cashier"}过期日期：{/t}</label>
					              				<div class="col-lg-9 p_l0">
					                            	<input class="form-control date" name="expiry_date" type="text" value="{$goods.expiry_date}"/>
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
					                        <h4 class="panel-title">{t domain="cashier"}备注信息{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseTwo" class="panel-collapse collapse in">
					                	<div class="panel-body">
					              			<div class="form-group m_b0">
					              				<label class="control-label col-lg-2 p_l0">{t domain="cashier"}商家备注：{/t}</label>
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
					                        <h4 class="panel-title">{t domain="cashier"}发布{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseThree" class="panel-collapse collapse in">
					                	<div class="panel-body">
					              			<div class="form-group">
					              				<label class="control-label col-lg-3">{t domain="cashier"}上架：{/t}</label>
					              				<div class="checkbox">
                                         			<input id="is_on_sale" type="checkbox" name="is_on_sale" value="1" {if $goods.is_on_sale}checked{/if}>
                                           			<label for="is_on_sale">{t domain="cashier"}打勾表示允许销售，否则不允许销售。{/t}</label>
                                           		</div>
				                          	</div>
				                          	
				                          	<div class="form-group m_b0">
				                          		<label class="control-label {if $goods.goods_id}col-lg-5{else}col-lg-6{/if}">
				                          			<button class="btn btn-info" type="submit">{if $goods.goods_id}{t domain="cashier"}更新{/t}{else}{t domain="cashier"}完成{/t}{/if}</button>
													<input type="hidden" name="generatedate" value="{if $goods.generate_date}{$goods.generate_date}{/if}"/>
													<input type="hidden" name="limitdays" value="{if $goods.limitdays}{$goods.limitdays}{/if}"/>
													<input type="hidden" name="dayunit" value="{if $goods.limitday_unit}{$goods.limitday_unit}{else}1{/if}"/>
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
					                        <h4 class="panel-title">{t domain="cashier"}商品分类{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseFour" class="panel-collapse collapse in">
					                	<div class="panel-body">
						                	<div class="form-group p_l15 p_r15 m_b0">
		                                     	<label>{t domain="cashier"}选择店铺商品分类{/t}</label>
		                                     	<span class="input-must m_l10">*</span>
		                                     	<div class="controls">
			                                        <select class=" form-control ecjiaf-fn" name="merchant_cat_id">
			                                        <option value="0">{t domain="cashier"}请选择...{/t}</option>
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
					                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseSeven" class="collapsed accordion-toggle">
					                        <span class="glyphicon"></span>
					                        <h4 class="panel-title">{t domain="cashier"}折扣、促销价格{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseSeven" class="panel-collapse collapse">
				              			<div class="panel-body mt_15">
				              				{if $user_rank_list}
	                                        <label>{t domain="cashier"}会员价格：{/t}</label>
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
												<span class="l_h30 f_l">{t domain="cashier"}优惠数量{/t}</span>
												<div class="col-lg-4">
	                                            	<input class="form-control" type="text" name="volume_number[]" value="{$volume_price.number}"/>
	                                          	</div>
												<span class="l_h30 f_l">{t domain="cashier"}优惠价格{/t}</span>
												
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
											<a class="m_l5 l_h30 add_volume_price" href="javascript:;">{t domain="cashier"}添加优惠价格{/t}</a>
											<span class="help-block">{t domain="cashier"}购买数量达到优惠数量时享受的优惠价格{/t}</span>
	                                    </div>
			              			</div>
				        		</div>
			        		</div>
					        		
			        		<div class="panel-group">
					            <div class="panel panel-info">
					                <div class="panel-heading">
					                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseEight" class="collapsed accordion-toggle">
					                        <span class="glyphicon"></span>
					                        <h4 class="panel-title">{t domain="cashier"}促销信息{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseEight" class="panel-collapse collapse">
				              			<div class="panel-body mt_15">
	                                        <div class="form-group">
					              				<div class="control-label col-lg-4 p_r5">
					              					<input id="is_promote" class="toggle_promote l_h30" type="checkbox" name="is_promote" value="1" {if $goods.is_promote}checked{/if} />
					              					<label for="is_promote"><span class="ecjiaf-fs2">{t domain="cashier"}促销价：{/t}</span></label>
					              				</div>
					              				<div class="col-lg-6 p_l0">
					                          		<input class="form-control" type="text" id="promote_1" name="promote_price" value="{$goods.promote_price}" size="20"{if !$goods.is_promote} disabled{/if} />
					                          	</div>
					              			</div>
					              			
					              			<div class="form-group">
					              				<label class="control-label col-lg-4">{t domain="cashier"}促销日期：{/t}</label>
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
					                        <h4 class="panel-title">{t domain="cashier"}积分相关{/t}</h4>
					                    </a>
					                </div>
					                <div id="collapseNine" class="panel-collapse collapse">
				              			<div class="panel-body mt_15">
	                                        <div class="form-group">
					              				<label class="control-label col-lg-5">{t domain="cashier"}积分购买金额：{/t}</label>
					              				<div class="col-lg-6">
					                          		<input class="form-control" type="text" name="integral" value="{$goods.integral}" size="20" data-toggle="parseint_input" />
					                          	</div>
					              			</div>
					              			<p class="help-block">{t domain="cashier"}(此处需填写金额)购买该商品时最多可以使用积分的金额{/t}</p>
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