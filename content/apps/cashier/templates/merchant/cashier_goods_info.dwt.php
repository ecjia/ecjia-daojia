<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!--{extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.cashier_goods_info.init();
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
			<div class="panel-body panel-body-small">
				<div class="form">
					<form class="form-horizontal" enctype="multipart/form-data" action="{$form_action}" method="post" name="theForm">
						<div class="col-lg-7 pull-left">
	                		<div class="form-group m_t10">
		              			<label class="control-label col-lg-2">商品名称：</label>
		              			<div class="controls col-lg-7">
		                            <input class="form-control" name="goods_name" type="text" value="{$goods.goods_name|escape}"/>
		                 		</div>
                           		<span class="input-must">{lang key='system::system.require_field'}</span>
		              		</div>
		              		
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">商品货号：</label>
	              				<div class="col-lg-7">
	                            	<input class="form-control" name="goods_sn" type="text" value="{$goods.goods_sn|escape}" />
	                          	</div>
	              			</div>
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">本店售价：</label>
	              				<div class="controls col-lg-7">
	                            	<input class="form-control" name="shop_price" type="text" value="{$goods.shop_price}" />
	                          	</div>
	                          	<div class="col-lg-2 p_l0">
		                          	<a class="btn btn-primary" data-toggle="marketPriceSetted">按市场价计算</a>
								</div>
								<span class="input-must m_l15">{lang key='system::system.require_field'}</span>
	              			</div>
		              			
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">市场售价：</label>
	              				<div class="controls col-lg-7">
	                            	<input class="form-control" name="market_price" type="text" value="{$goods.market_price}" />
	                          	</div>
	                          	<div class="col-lg-2 p_l0">
		                          	<button class="btn btn-primary" type="button" data-toggle="integral_market_price">取整数</button>
								</div>
	              			</div>
		              		
		              		<div class="form-group">
	              				<label class="control-label col-lg-2">库存数量：</label>
	              				<div class="controls col-lg-7">
	                            	<input class="form-control" name="goods_number" type="text" value="{if $goods.goods_number}{$goods.goods_number}{else}1000{/if}" />
	                          	</div>
								<span class="input-must m_l15">{lang key='system::system.require_field'}</span>
	              			</div>
	              			
	              			<div class="form-group">
	              				<label class="control-label col-lg-2">警告数量：</label>
	              				<div class="col-lg-7">
	                            	<input class="form-control" name="warn_number" type="text" value="{$goods.warn_number}" />
	                          	</div>
	              			</div>
		              			
							<div class="panel-group" id="accordionOne">
					            <div class="panel panel-info">
					                <div class="panel-heading">
					                    <a data-toggle="collapse" data-parent="#accordionOne" href="#collapseOne" class="accordion-toggle">
					                    	<span class="glyphicon"></span>
					                        <h4 class="panel-title">特殊属性</h4>
					                    </a>
					                </div>
					                <div id="collapseOne" class="panel-collapse collapse in">
					                	<div class="panel-body">
										 	<div class="form-group">
					              				<label class="control-label col-lg-2 p_l0">进货价：</label>
					              				<div class="col-lg-9 p_l0">
					                            	<input class="form-control" name="cost_price" type="text" value="{$goods.cost_price}" />
					                          	</div>
					              			</div>
					              			<div class="form-group">
					              				<label class="control-label col-lg-2 p_l0">生产日期：</label>
					              				<div class="col-lg-9 p_l0">
					                            	<input class="form-control date generate-date" name="generate_date" action='{url path="cashier/mh_bulk_goods/get_expire_date"}' type="text" value="{$goods.generate_date}" />
					                          	</div>
					              			</div>
					              			<div class="form-group">
					              				<label class="control-label col-lg-2 p_l0">保质期：</label>
					              				<div class="col-lg-7 p_l0">
					                            	<input class="form-control limitday" name="limit_days" action='{url path="cashier/mh_bulk_goods/get_expire_date"}' type="text" value="{if $goods.limitdays}{$goods.limitdays}{else}1{/if}" />
					                          	</div>
				                          		<div class="col-lg-2 p_l0">
						                          	<select name="limit_days_unit" class="form-control day-unit" action='{url path="cashier/mh_cashier_goods/get_expire_date"}'>
														<!-- {foreach from=$limit_days_unit key=key item=val} -->
														<option value="{$key}" {if $goods.limitday_unit eq $key}selected{/if}>{$val}</option>
														<!-- {/foreach} -->
													</select>
												</div>
					              			</div>
					              			<div class="form-group">
					              				<label class="control-label col-lg-2 p_l0">过期日期：</label>
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
					                        <h4 class="panel-title">备注信息</h4>
					                    </a>
					                </div>
					                <div id="collapseTwo" class="panel-collapse collapse in">
					                	<div class="panel-body">
					              			<div class="form-group m_b0">
					              				<label class="control-label col-lg-2 p_l0">商家备注：</label>
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
					                        <h4 class="panel-title">发布</h4>
					                    </a>
					                </div>
					                <div id="collapseThree" class="panel-collapse collapse in">
					                	<div class="panel-body">
					              			<div class="form-group">
					              				<label class="control-label col-lg-3">上架：</label>
					              				<div class="checkbox">
                                         			<input id="is_on_sale" type="checkbox" name="is_on_sale" value="1" {if $goods.is_on_sale}checked{/if}>
                                           			<label for="is_on_sale">打勾表示允许销售，否则不允许销售。</label>
                                           		</div>
				                          	</div>
				                          	
				                          	<div class="form-group m_b0">
				                          		<label class="control-label {if $goods.goods_id}col-lg-5{else}col-lg-6{/if}">
				                          			<button class="btn btn-info" type="submit">{if $goods.goods_id}更新{else}完成{/if}</button>
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
					                        <h4 class="panel-title">商品分类</h4>
					                    </a>
					                </div>
					                <div id="collapseFour" class="panel-collapse collapse in">
					                	<div class="panel-body">
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
					                    <a data-toggle="collapse" data-parent="#accordionTwo" href="#collapseSeven" class="collapsed accordion-toggle">
					                        <span class="glyphicon"></span>
					                        <h4 class="panel-title">折扣、促销价格</h4>
					                    </a>
					                </div>
					                <div id="collapseSeven" class="panel-collapse collapse">
				              			<div class="panel-body mt_15">
				              				{if $user_rank_list}
	                                        <label>会员价格：</label>
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
												<span class="l_h30 f_l">优惠数量</span>
												<div class="col-lg-4">
	                                            	<input class="form-control" type="text" name="volume_number[]" value="{$volume_price.number}"/>
	                                          	</div>
												<span class="l_h30 f_l">优惠价格</span>
												
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
											<a class="m_l5 l_h30 add_volume_price" href="javascript:;">添加优惠价格</a>
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
					                        <h4 class="panel-title">促销信息</h4>
					                    </a>
					                </div>
					                <div id="collapseEight" class="panel-collapse collapse">
				              			<div class="panel-body mt_15">
	                                        <div class="form-group">
					              				<div class="control-label col-lg-4 p_r5">
					              					<input id="is_promote" class="toggle_promote l_h30" type="checkbox" name="is_promote" value="1" {if $goods.is_promote}checked{/if} />
					              					<label for="is_promote"><span class="ecjiaf-fs2">促销价：</span></label>
					              				</div>
					              				<div class="col-lg-6 p_l0">
					                          		<input class="form-control" type="text" id="promote_1" name="promote_price" value="{$goods.promote_price}" size="20"{if !$goods.is_promote} disabled{/if} />
					                          	</div>
					              			</div>
					              			
					              			<div class="form-group">
					              				<label class="control-label col-lg-4">促销日期：</label>
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
					                        <h4 class="panel-title">积分相关</h4>
					                    </a>
					                </div>
					                <div id="collapseNine" class="panel-collapse collapse">
				              			<div class="panel-body mt_15">
	                                        <div class="form-group">
					              				<label class="control-label col-lg-5">积分购买金额：</label>
					              				<div class="col-lg-6">
					                          		<input class="form-control" type="text" name="integral" value="{$goods.integral}" size="20" data-toggle="parseint_input" />
					                          	</div>
					              			</div>
					              			<p class="help-block">(此处需填写金额)购买该商品时最多可以使用积分的金额'</p>
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