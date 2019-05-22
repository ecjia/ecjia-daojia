<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} --> 
<script type="text/javascript">
	ecjia.merchant.product_spec.init();
</script> 
<!-- {/block} --> 

<!-- {block name="home-content"} -->

{if $step}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}

{if $has_template}
<div class="alert alert-info">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
            <i class="fa fa-times" data-original-title="" title=""></i>
      </button>
      <strong>{t domain="goods"}温馨提示：{/t}</strong>
      <br>
      {t domain="goods"}1、请先设置商品规格属性，才可以进行货品添加。{/t}
      </br>
      {t domain="goods"}2、如果该商品存在货品，那么货品相关设置项优先使用。{/t}<br>
      {t domain="goods"}3、如需更换规格模板，请先点击【清除数据】按钮然后在重新绑定即可。{/t}<br>
      {t domain="goods"}4、清除后会将之前设置的规格属性以及添加的货品清除，请谨慎操作。{/t}
</div>
{/if}

<div class="page-header">
	<div class="pull-left">
		<h2> 
			<!-- {if $ur_here}{$ur_here}{/if} --> 
		</h2>	
	</div>
	<div class="pull-right">
		{if $action_link} 
		<a href="{$action_link.href}" class="btn btn-primary data-pjax" id="sticky_a">
		<i class="fa fa-reply"></i> {$action_link.text}</a> 
		{/if}
	</div>
	<div class="clearfix"></div>
</div>

<div class="modal fade" id="myModal1"></div>
<div class="add_pro modal fade" id="myModal2"></div>

<div class="row">
	<div class="col-lg-12">
		<div class="panel">
			{if !$step}
           	<div class="panel-body panel-body-small">
				<ul class="nav nav-tabs">
					<!-- {foreach from=$tags item=tag} -->
					<li {if $tag.active} class="active"{/if}><a {if $tag.active} href="javascript:;"{else}{if $tag.pjax} class="data-pjax"{/if} href='{$tag.href}'{/if}><!-- {$tag.name} --></a></li>
					<!-- {/foreach} -->
				</ul>
			</div>
			{/if}
				
			<div class="panel-body">
                <div class="tab-content">
                	<div class="form">
						<form class="form-horizontal" action="{$form_action}" method="post" name="theForm">
							<fieldset>
								<div class="template_box">
									<div class="box_content">
										<div class="form-group">
											<label class="control-label col-lg-2 ">{t domain="goods"}商品货号：{/t}</label>
											<div class="col-lg-6">
												<input class="form-control" type="text" name="goods_sn" value="{$goods_info.goods_sn}" disabled="disabled" />
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-lg-2 ">{t domain="goods"}库存数量：{/t}</label>
											<div class="col-lg-6">
												<input class="form-control" type="text" name="goods_number" value="{$goods_info.goods_number}" >
											
											</div>
										</div>
										
										<div class="form-group">
											<label class="control-label col-lg-2 ">{t domain="goods"}商品条形码：{/t}</label>
											<div class="col-lg-6">
												<input class="form-control" type="text" name="goods_barcode" value="{$goods_info.goods_barcode}" >
												<span class="help-block">非必填项，条形码必须搭配条码秤才可使用</span>
											</div>
										</div>
									 </div>
								</div> 
								
								<div class="template_box">
									{if $has_template}
										<div class="box_content">
											<div class="form-group">
												<label class="control-label col-lg-2 ">{t domain="goods"}规格模板：{/t}</label>
												<div class="col-lg-6 l_h35">
													{$template_info.cat_name}
													
													{if $goods_info.specification_id}
	                                                	<a data-toggle="clear_data" data-href='{url path="goods/merchant/clear_spec_data"}' goods-id="{$goods_info.goods_id}" ><button type="button" class="btn btn-default" >{t domain="goods"}更换模板{/t}</button></a>
                                                    {else}
                                                        <a href='{url path="goods/mh_category/edit" args="cat_id={$goods_info.merchant_cat_id}"}'><button type="button" class="btn btn-default" >{t domain="goods"}更换模板{/t}</button></a>
                                                    {/if} 
                                                    
													<a data-toggle="modal" data-backdrop="static" href="#myModal1" goods-id="{$goods_info.goods_id}" attr-url="{RC_Uri::url('goods/merchant/select_spec_values')}" ><button class="btn btn-info"><i class="fa fa-cog"></i> {t domain="goods"}设置规格属性{/t}</button></a>
													
													{if $has_spec}
	                                                    <a data-type="add-pro" data-toggle="modal" data-backdrop="static" href="#myModal2" goods-id="{$goods_info.goods_id}" attr-url="{RC_Uri::url('goods/merchant/spec_add_product')}" ><button class="btn btn-info"><i class="fa fa-plus"></i> {t domain="goods"}添加货品{/t}</button></a>
	                                                {/if} 
												</div>
											</div>
											
											{if $product_list}
											<table class="table table-striped table-hide-edit">
                                              <thead>
                                                  <tr>
                                                    <th>货品（SKU）</th>
                                                      <th class="product_sn">{t domain='goods'}商品货号{/t}</th>
                                                      <th>{t domain='goods'}条形码{/t}</th>
                                                      <th>{t domain='goods'}价格{/t}</th>
                                                      <th>{t domain='goods'}库存{/t}</th>
                                                      <th class="w100">{t domain='goods'}操作{/t}</th>
                                                  </tr>
                                              </thead>
                           
                                              <tbody>
                                                  <!-- {foreach from=$product_list item=product} -->
                                                  <tr>
                                                    <td>
                                                    <!-- {foreach from=$product.goods_attr item=goods_attr} -->
                                                      {$goods_attr} {if $goods_attr@last}{else}/{/if}
                                                      <!-- {/foreach} -->
                                                      </td>
                                                      <td><input class="form-control" type="text" name="product_sn[]" value="{$product.product_sn}" /></td>
                                                      <td><input class="form-control" type="text" name="product_bar_code[]" value="{$product.product_bar_code}" /></td>
                                                      <td><input class="form-control" type="text" name="product_shop_price[]" value="{$product.product_shop_price}" /></td>
                                                      <td><input class="form-control" type="text" name="product_number[]" value="{$product.product_number}" /></div></td>
                                                      <td style="margin-top: 10px;">
                                                        <a class="data-pjax" href='{url path="goods/merchant/product_edit" args="id={$product.product_id}&goods_id={$goods_id}"}' >{t domain='goods'}编辑{/t}</a>&nbsp;|&nbsp;
                                                        <a class="ecjiafc-red" data-toggle="ajaxremove" data-msg="{t domain='goods'}您确定要把该货品删除吗？{/t}" href='{url path="goods/merchant/product_remove" args="id={$product.product_id}"}' >{t domain='goods'}删除{/t}</a>
                                                    </td>
                                                  </tr>
                                                  <!-- {/foreach} -->
                                              </tbody>
                                            </table>
											{/if}
											
										</div>
									{else}
										<div class="box_content">
											<div class="form-group">
												<label class="control-label col-lg-2 ">{t domain="goods"}规格模板：{/t}</label>
												<div class="col-lg-6 l_h35">
													<span class="badge bg-important">!</span> <span class="ecjiafc-red">您当前还未绑定任何规格模板，请先绑定后，再来设置</span>
												</div>
											</div>
											
											<div class="form-group">
												<div class="col-lg-offset-2 col-lg-6">
													<a href='{url path="goods/mh_category/edit" args="cat_id={$goods_info.merchant_cat_id}"}'><button type="button" class="btn btn-info" >{t domain="goods"}绑定模板{/t}</button></a>
												</div>
											</div>
										</div>
									{/if}
								</div>
		
								{if $has_template}
									<div class="form-group">
										<div class="col-lg-offset-2 col-lg-6 m_t10">
											<button class="btn btn-info" type="submit">{t domain="goods"}保存{/t}</button>
											<input type="hidden" name="mer_cat_id" value="{$goods_info.merchant_cat_id}" />
											<input type="hidden" name="goods_id" value="{$goods_info.goods_id}" />
											<input type="hidden" name="template_id" value="{$template_id}" />
										</div>
									</div>
								{/if}
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- {/block} -->