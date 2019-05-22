<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.product_spec.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
{if $step eq '3'}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}

{if $has_template}
<div class="alert alert-info">
	<strong>{t domain="goodslib"}温馨提示：{/t}</strong><br>{t domain="goods"}1、请先设置商品规格属性，才可以进行货品添加。{/t}</br>{t domain="goods"}2、如果该商品存在货品，那么货品相关设置项优先使用。{/t}
</div>
{/if}

<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} --> 
		{if $action_link} 
	<a href="{$action_link.href}" class="btn plus_or_reply data-pjax" id="sticky_a"><i class="fontello-icon-reply"></i>{$action_link.text}</a> {/if}
	</h3>
</div>

<div class="modal hide fade" id="myModal1"></div>
<div class="add_pro modal hide fade" id="myModal2"></div>

<div class="row-fluid">
	<div class="span12">
		<div class="tabbable">
		
			{if !$step}
			<ul class="nav nav-tabs">
				<!-- {foreach from=$tags item=tag} -->
				<li{if $tag.active} class="active"{/if}><a{if $tag.active} href="javascript:;"{else}{if $tag.pjax} class="data-pjax"{/if} href='{$tag.href}'{/if}><!-- {$tag.name} --></a></li>
				<!-- {/foreach} -->
			</ul>
			{/if}
			
			<form class="form-horizontal" action="{$form_action}" method="post" name="theForm">
				<div class="template_box">
						<div class="box_content">
							<div class="control-group">
								<label class="control-label">{t domain="goodslib"}商品货号：{/t}</label>
								<div class="controls">
									<input class="w350" type="text" name="goods_sn" value="{$goodslib_info.goods_sn}" disabled="disabled" />
								</div>
							</div>
							
							<div class="form-group">
								<label class="control-label col-lg-2 ">{t domain="goodslib"}商品条形码：{/t}</label>
								<div class="controls">
									<input class="w350" type="text" name="goods_barcode" value="{$goodslib_info.goods_barcode}" >
									<span class="help-block">非必填项，条形码必须搭配条码秤才可使用</span>
								</div>
							</div>
						 </div>
					</div> 
					
					<div class="template_box">
						{if $has_template}
							<div class="box_content">
								<div class="control-group">
									<label class="control-label">{t domain="goodslib"}规格模板：{/t}</label>
									<div class="controls l_h35">
										{$template_info.cat_name}
										<span class="m_l10">
											<a href='{url path="goods/admin_category/edit" args="cat_id={$goodslib_info.cat_id}"}'><button type="button" class="btn btn-gebo" >{t domain="goodslib"}更换模板{/t}</button></a>
										</span>
										<a data-toggle="modal" data-backdrop="static" href="#myModal1" goods-id="{$goodslib_info.goods_id}" attr-url="{RC_Uri::url('goodslib/admin/select_spec_values')}" ><button class="btn btn-gebo"><i class="fontello-icon-cog"></i> {t domain="goods"}设置规格属性{/t}</button></a>
										{if $has_spec}
                                        <a data-type="add-pro" data-toggle="modal" data-backdrop="static" href="#myModal2" goods-id="{$goodslib_info.goods_id}" attr-url="{RC_Uri::url('goodslib/admin/spec_add_product')}" ><button class="btn btn-gebo"><i class="fontello-icon-plus"></i> {t domain="goods"}添加货品{/t}</button></a>
                                        {/if} 
									</div>
								</div>
								{if $product_list}
								<table class="table table-striped table-hide-edit">
                                  <thead>
                                      <tr>
                                        <th>货品（SKU）</th>
                                          <th class="product_sn">{t domain='goodslib'}商品货号{/t}</th>
                                          <th>{t domain='goodslib'}条形码{/t}</th>
                                          <th>{t domain='goodslib'}价格{/t}</th>
                                          <th>{t domain='goodslib'}库存{/t}</th>
                                          <th class="w100">{t domain='goodslib'}操作{/t}</th>
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
                                            <a class="data-pjax" href='{url path="goodslib/admin/product_edit" args="id={$product.product_id}&goods_id={$goods_id}"}' >{t domain='goodslib'}编辑{/t}</a>&nbsp;|&nbsp;
                                            <a class="ecjiafc-red" data-toggle="ajaxremove" data-msg="{t domain='goodslib'}您确定要把该货品删除吗？{/t}" href='{url path="goodslib/admin/product_remove" args="id={$product.product_id}"}' >{t domain='goodslib'}删除{/t}</a>
                                        </td>
                                      </tr>
                                      <!-- {/foreach} -->
                                  </tbody>
                                </table>
								{/if}
							</div>
						{else}
							<div class="box_content">
								<div class="control-group">
									<label class="control-label">{t domain="goodslib"}规格模板：{/t}</label>
									<div class="controls l_h35">
										<i class="fontello-icon-attention-circled ecjiafc-red"></i><span class="ecjiafc-red">您当前还未绑定任何参数模板，请先绑定后，再来设置</span>
									</div>
								</div>
								
								<div class="control-group">
									<div class="controls l_h35">
										<a href='{url path="goods/admin_category/edit" args="cat_id={$goodslib_info.cat_id}"}'><button type="button" class="btn btn-info" >{t domain="goodslib"}绑定模板{/t}</button></a>
									</div>
								</div>
							</div>
						{/if}
					</div>
					
				{if $has_template}
				<div class="control-group">
					<div class="controls m_t10">
						<button class="btn btn-gebo" type="submit">{t domain="goodslib"}保存{/t}</button>
						<input type="hidden" name="cat_id" value="{$goodslib_info.cat_id}" />
						<input type="hidden" name="goods_id" value="{$goodslib_info.goods_id}" />
						<input type="hidden" name="template_id" value="{$template_id}" />
					</div>
				</div>
				{/if}
			</form>
		</div>
	</div>
</div>
<!-- {/block} -->