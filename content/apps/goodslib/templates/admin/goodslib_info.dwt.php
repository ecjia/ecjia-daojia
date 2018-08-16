<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.goods_info.init();
</script>
<!-- {/block} -->
<!-- {block name="main_content"} -->
{if $step}
<!-- #BeginLibraryItem "/library/goods_step.lbi" --><!-- #EndLibraryItem -->
{/if}
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	<!-- {if $action_link} -->
	<a class="btn plus_or_reply data-pjax" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
	<!-- {/if} -->
	</h3>
</div>
<div class="row-fluid edit-page">
	<div class="span12">
		<div class="tabbable">
			{if $action eq 'edit'}
			<ul class="nav nav-tabs">
				<!-- {foreach from=$tags item=tag} -->
				<li{if $tag.active} class="active"{/if}><a class="data-pjax" {if $tag.active} href="javascript:;"{else} data-toggle="alertgo" data-message="{lang key='goods::goods.discard_changes'}" href='{$tag.href}'{/if}><!-- {$tag.name} --></a></li>
				<!-- {/foreach} -->
			</ul>
			{/if}
			<form class="form-horizontal" enctype="multipart/form-data" action="{$form_action}" method="post" name="theForm">
				<div>
					<!--通用信息  -->
					<!-- <div class="tab-content">
					<div class="tab-pane active" id="tab1">
						 -->
						<div class="active" id="tab1">
							<fieldset>
								<div class="row-fluid edit-page editpage-rightbar">
									<div class="left-bar move-mod">
										<div class="goods_base_info">
											<div class="control-group control-group-small formSep">
												<label class="control-label">{lang key='goods::goods.lab_goods_name'}</label>
												<div class="controls">
													<input class="f_l w330" type="text" name="goods_name" value="{$goods.goods_name|escape}" style="color:{$goods_name_color};" size="30"/>
													<div class="input-append color" data-color="{$goods_name_color}" id="color">
														<input class="w50" type="text" name="goods_name_color" value="{$goods_name_color}"/>
														<span class="add-on">
														<i class="dft_color"></i>
														</span>
													</div>
													<span class="input-must">{lang key='system::system.require_field'}</span>
												</div>
											</div>
											<div class="control-group control-group-small formSep">
												<label class="control-label">{lang key='goods::goods.lab_goods_sn'}</label>
												<div class="controls">
													<input class="w330" type="text" name="goods_sn" value="{$goods.goods_sn|escape}" size="20" data-toggle="checkGoodsSn" data-id="{$goods.goods_id}" data-url="{url path='goodslib/admin/check_goods_sn'}"/>
													<label id="goods_sn_notice" class="error"></label>
													<span class="help-block" id="noticeGoodsSN">{lang key='goods::goods.notice_goods_sn'}</span>
												</div>
											</div>
											<!--本店售价-->
											<div class="control-group control-group-small formSep">
												<label class="control-label">{lang key='goods::goods.lab_shop_price'}</label>
												<div class="controls">
													<input class="w330" type="text" name="shop_price" value="{$goods.shop_price}" size="20" data-toggle="priceSetted"/>
													<a class="btn" data-toggle="marketPriceSetted">{lang key='goods::goods.compute_by_mp'}</a>
													<span class="input-must">{lang key='system::system.require_field'}</span>
												</div>
											</div>
											<!--市场售价-->
											<div class="control-group control-group-small formSep">
												<label class="control-label">{lang key='goods::goods.lab_market_price'}</label>
												<div class="controls">
													<input class="w330" type="text" name="market_price" value="{$goods.market_price}" size="20"/>
													<button class="btn" type="button" data-toggle="integral_market_price">{lang key='goods::goods.integral_market_price'}</button>
												</div>
											</div>
											<div class="control-group control-group-small formSep">
												<label class="control-label">{lang key='goods::goods.lab_goods_weight'}</label>
												<div class="controls">
													<input class="f_l m_r5 input-small w330" type="text" name="goods_weight" value="{$goods.goods_weight_by_unit}" size="20"/>
													<select name="weight_unit" class="w100">
														<!-- {html_options options=$unit_list selected=$weight_unit} -->
													</select>
												</div>
											</div>
											
											<div class="control-group control-group-small formSep">
												<label class="control-label">{lang key='goods::goods.lab_is_on_sale'}</label>
												<div class="controls">
													<input type="checkbox" name="is_display" value="1" style="opacity: 0;" {if $goods.is_display}checked="checked"{/if}>
													<span>打勾表示商家可见此商品，并允许商家将此商品导入店铺，否则不显示并不可导入</span>
												</div>
											</div>
											
										</div>
										<div class="foldable-list move-mod-group" id="goods_info_sort_seo">
											<div class="accordion-group">
												<div class="accordion-heading">
													<a class="accordion-toggle collapsed acc-in move-mod-head" data-toggle="collapse" data-target="#goods_info_area_seo">
													<strong>{lang key='goods::goods.seo'}</strong>
													</a>
												</div>
												<div class="accordion-body in collapse" id="goods_info_area_seo">
													<div class="accordion-inner">
														<div class="control-group control-group-small">
															<label class="control-label">{lang key='goods::goods.label_keywords'}</label>
															<div class="controls">
																<input class="span12" type="text" name="keywords" value="{$goods.keywords|escape}" size="40"/>
																<br/>
																<p class="help-block w280 m_t5">
																	{lang key='goods::goods.notice_keywords'}
																</p>
															</div>
														</div>
														<div class="control-group control-group-small">
															<label class="control-label">{lang key='goods::goods.lab_goods_brief'}</label>
															<div class="controls">
																<textarea class="span12 h100" name="goods_brief" cols="40" rows="3">{$goods.goods_brief|escape}</textarea>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row-fluid">
											<label class="control-label"></label>
    										<input type="hidden" name="goods_id" value="{$goods.goods_id}"/>
    										<input type="hidden" name="goods_copyid" value="{$goods.goods_copyid}"/>
    										<button class="btn btn-gebo" type="submit">{if $goods.goods_id}{lang key='goods::goods.update'}{else}{lang key='goods::goods.next_step'}{/if}</button>
    										<input type="hidden" id="type" value="{$link.type}"/>
    									</div>
									</div>
									<!-- 选填信息 -->
									<div class="right-bar move-mod">
										<div class="foldable-list move-mod-group" id="goods_info_sort_cat">
											<div class="accordion-group">
												<div class="accordion-heading">
													<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_cat">
													<strong>{lang key='goods::goods.category'}</strong>
													</a>
												</div>
												<div class="accordion-body in in_visable collapse" id="goods_info_area_cat">
													<div class="accordion-inner">
														<div class="control-group m_b0">
															<label><b>{lang key='goods::goods.choose_goods_cat'}</b></label>
															<div>
																<select class="w300" name="cat_id">
																	<option value="0">{lang key='system::system.select_please'}</option>
																	<!-- {foreach from=$cat_list item=cat} -->
																	<option {if $goods.cat_id eq $cat.cat_id}selected="selected"{/if} value="{$cat.cat_id}" {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
																	<!-- {/foreach} -->
																</select>
																<div class="f_error">
																	<label class="cat_id_error ecjiafc-red">{lang key='goods::goods.js_lang.category_id_select'}</label>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="foldable-list move-mod-group" id="goods_info_sort_brand">
											<div class="accordion-group">
												<div class="accordion-heading">
													<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_brand">
													<strong>{lang key='goods::goods.brand'}</strong>
													</a>
												</div>
												<div class="accordion-body in in_visable collapse" id="goods_info_area_brand">
													<div class="accordion-inner">
														<div class="control-group m_b0">
															<label><b>{lang key='goods::goods.select_goods_brand'}</b></label>
															<select class="w300" name="brand_id">
																<option value="0">{lang key='system::system.select_please'}{html_options options=$brand_list selected=$goods.brand_id}</option>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="foldable-list move-mod-group" id="goods_info_sort_img">
											<div class="accordion-group">
												<div class="accordion-heading">
													<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_img">
													<strong>{lang key='goods::goods.goods_image'}</strong>
													</a>
												</div>
												<div class="accordion-body in collapse" id="goods_info_area_img">
													<div class="accordion-inner">
														<div class="control-group">
															<label>{lang key='goods::goods.lab_picture'}</label>
															<div class="ecjiaf-db">
																<div class="goods_img">
																	<span {if $goods.goods_img}class="btn fileupload-btn preview-img" style="background-image: url({$goods.goods_img});"{else}class="btn fileupload-btn"{/if}>
																	<span class="fileupload-exists"><i class="fontello-icon-plus"></i></span>
																	</span>
																	<input class="hide" type="file" name="goods_img" onchange="ecjia.admin.goods_info.previewImage(this)"/>
																</div>
																<div class="thumb_img{if !$goods.goods_thumb} hide{/if}">
																	<label>{lang key='goods::goods.goods_thumb'}</label>
																	<span {if $goods.goods_img}class="btn fileupload-btn preview-img" style="background-image: url({$goods.goods_thumb});"{else}class="btn fileupload-btn"{/if}>
																	<span class="fileupload-exists"><i class="fontello-icon-plus"></i></span>
																	</span>
																	<input class="hide" type="file" name="thumb_img" onchange="ecjia.admin.goods_info.previewImage(this)"/>
																</div>
																<div>
																	<span class="help-inline">{lang key='goods::goods.thumb_img_notice'}</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
					<div class="row-fluid edit-page">
						<div class="span12 move-mod">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- {/block} -->