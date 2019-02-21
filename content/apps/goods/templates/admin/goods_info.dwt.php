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
				<li{if $tag.active} class="active"{/if}><a class="data-pjax" {if $tag.active} href="javascript:;"{else} data-toggle="alertgo" data-message="{t domain="goods"}是否放弃本页面修改？{/t}" href='{$tag.href}'{/if}><!-- {$tag.name} --></a></li>
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
												<label class="control-label">{t domain="goods"}商品名称：{/t}</label>
												<div class="controls">
													<input class="f_l w330" type="text" name="goods_name" value="{$goods.goods_name|escape}" style="color:{$goods_name_color};" size="30"/>
													<div class="input-append color" data-color="{$goods_name_color}" id="color">
														<input class="w50" type="text" name="goods_name_color" value="{$goods_name_color}"/>
														<span class="add-on">
														<i class="dft_color"></i>
														</span>
													</div>
													<span class="input-must">*</span>
												</div>
											</div>
											<div class="control-group control-group-small formSep">
												<label class="control-label">{t domain="goods"}商品货号：{/t}</label>
												<div class="controls">
													<input class="w330" type="text" name="goods_sn" value="{$goods.goods_sn|escape}" size="20" data-toggle="checkGoodsSn" data-id="{$goods.goods_id}" data-url="{url path='goods/admin/check_goods_sn'}"/>
													<label id="goods_sn_notice" class="error"></label>
													<span class="help-block" id="noticeGoodsSN">{t domain="goods"}如果您不输入商品货号，系统将自动生成一个唯一的货号。{/t}</span>
												</div>
											</div>
											<!--本店售价-->
											<div class="control-group control-group-small formSep">
												<label class="control-label">{t domain="goods"}本店售价：{/t}</label>
												<div class="controls">
													<input class="w330" type="text" name="shop_price" value="{$goods.shop_price}" size="20" data-toggle="priceSetted"/>
													<a class="btn" data-toggle="marketPriceSetted">{t domain="goods"}按市场价计算{/t}</a>
													<span class="input-must">*</span>
												</div>
											</div>
											<!--市场售价-->
											<div class="control-group control-group-small formSep">
												<label class="control-label">{t domain="goods"}市场售价：{/t}</label>
												<div class="controls">
													<input class="w330" type="text" name="market_price" value="{$goods.market_price}" size="20"/>
													<button class="btn" type="button" data-toggle="integral_market_price">{t domain="goods"}取整数{/t}</button>
												</div>
											</div>
											<!-- {if $cfg.use_storage} -->
											<div class="control-group control-group-small formSep">
												<label class="control-label">{t domain="goods"}库存数量：{/t}</label>
												<div class="controls">
													<input class="input-small w330" type="text" name="goods_number" value="{$goods.goods_number}" size="20"/>
													<span class="input-must">*</span>
													<span class="help-block" {if $help_open}style="display:block" {else} style="display:none" {/if} id="noticeStorage">{t domain="goods"}库存在商品为虚货或商品存在货品时为不可编辑状态，库存数值取决于其虚货数量或货品数量{/t}</span>
												</div>
											</div>
											<div class="control-group control-group-small formSep">
												<label class="control-label">{t domain="goods"}警告数量：{/t}</label>
												<div class="controls">
													<input class="input-small w330" type="text" name="warn_number" value="{$goods.warn_number}" size="20"/>
												</div>
											</div>
											<!-- {/if} -->
											<!-- {if $code eq ''} -->
											<div class="control-group control-group-small formSep">
												<label class="control-label">{t domain="goods"}商品重量：{/t}</label>
												<div class="controls">
													<input class="f_l m_r5 input-small w330" type="text" name="goods_weight" value="{$goods.goods_weight_by_unit}" size="20"/>
													<select name="weight_unit" class="w100">
														<!-- {html_options options=$unit_list selected=$weight_unit} -->
													</select>
												</div>
											</div>
											<!-- {/if} -->
											<div class="control-group control-group-small formSep">
												<label class="control-label">{t domain="goods"}作为商品：{/t}</label>
												<div class="controls chk_radio">
													<input type="checkbox" name="is_alone_sale" value="1" style="opacity: 0;" {if $goods.is_alone_sale}checked="checked"{/if}>
													<span>{t domain="goods"}打勾表示能作为普通商品销售，否则只能作为配件或赠品销售。{/t}</span>
												</div>
											</div>
											<div class="control-group control-group-small formSep">
												<label class="control-label">{t domain="goods"}是否包邮：{/t}</label>
												<div class="controls chk_radio">
													<input type="checkbox" name="is_shipping" value="1" style="opacity: 0;" {if $goods.is_shipping}checked="checked"{/if}>
													<span>{t domain="goods"}打勾表示此商品不会产生运费花销，否则按照正常运费计算。{/t}</span>
												</div>
											</div>
										</div>
										<div class="foldable-list move-mod-group" id="goods_info_sort_seo">
											<div class="accordion-group">
												<div class="accordion-heading">
													<a class="accordion-toggle collapsed acc-in move-mod-head" data-toggle="collapse" data-target="#goods_info_area_seo">
													<strong>{t domain="goods"}SEO优化{/t}</strong>
													</a>
												</div>
												<div class="accordion-body in collapse" id="goods_info_area_seo">
													<div class="accordion-inner">
														<div class="control-group control-group-small">
															<label class="control-label">{t domain="goods"}关键字：{/t}</label>
															<div class="controls">
																<input class="span12" type="text" name="keywords" value="{$goods.keywords|escape}" size="40"/>
																<br/>
																<p class="help-block w280 m_t5">
																	{t domain="goods"}用英文逗号分隔{/t}
																</p>
															</div>
														</div>
														<div class="control-group control-group-small">
															<label class="control-label">{t domain="goods"}简单描述：{/t}</label>
															<div class="controls">
																<textarea class="span12 h100" name="goods_brief" cols="40" rows="3">{$goods.goods_brief|escape}</textarea>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="foldable-list move-mod-group" id="goods_info_sort_note">
											<div class="accordion-group">
												<div class="accordion-heading">
													<a class="accordion-toggle collapsed acc-in move-mod-head" data-toggle="collapse" data-target="#goods_info_area_note">
													<strong>{t domain="goods"}备注信息{/t}</strong>
													</a>
												</div>
												<div class="accordion-body in collapse" id="goods_info_area_note">
													<div class="accordion-inner">
														<div class="control-group control-group-small">
															<label class="control-label">{t domain="goods"}商家备注：{/t}</label>
															<div class="controls">
																<textarea name="seller_note" cols="40" rows="3" class="span12 h100">{$goods.seller_note}</textarea>
																<span class="help-block" {if $help_open}style="display:block" {else} style="display:none" {/if} id="noticeSellerNote">{t domain="goods"}仅供商家自己看的信息{/t}</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- 选填信息 -->
									<div class="right-bar move-mod">
										<div class="foldable-list move-mod-group" id="goods_info_sort_submit">
											<div class="accordion-group">
												<div class="accordion-heading">
													<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_submit">
													<strong>{t domain="goods"}发布{/t}</strong>
													</a>
												</div>
												<div class="accordion-body in collapse" id="goods_info_area_submit">
													<div class="accordion-inner">
														<div class="control-group control-group-small">
														{t domain="goods"}上架：{/t}
															<input type="checkbox" name="is_on_sale" value="1" style="opacity: 0;" {if $goods.is_on_sale}checked="checked"{/if}>
															<span>{t domain="goods"}打勾表示允许销售，否则不允许销售。{/t}</span>
														</div>
														<div class="control-group control-group-small">
														{t domain="goods"}加入推荐：{/t}
															<input type="checkbox" name="is_best" value="1" style="opacity: 0;" {if $goods.is_best}checked="checked"{/if}>
															<span>{t domain="goods"}精品{/t}</span>
															<input type="checkbox" name="is_new" value="1" style="opacity: 0;" {if $goods.is_new}checked="checked"{/if}>
															<span>{t domain="goods"}新品{/t}</span>
															<input type="checkbox" name="is_hot" value="1" style="opacity: 0;" {if $goods.is_hot}checked="checked"{/if}>
															<span>{t domain="goods"}热销{/t}</span>
														</div>
														<input type="hidden" name="goods_id" value="{$goods.goods_id}"/>
														<input type="hidden" name="goods_copyid" value="{$goods.goods_copyid}"/>
													{if $code neq ''}
														<input type="hidden" name="extension_code" value="{$code}"/>
													{/if}
														<button class="btn btn-gebo" type="submit">{if $goods.goods_id}{t domain="goods"}更新{/t}{else}{t domain="goods"}下一步{/t}{/if}</button>
														<input type="hidden" id="type" value="{$link.type}"/>
													</div>
												</div>
											</div>
										</div>
										<div class="foldable-list move-mod-group" id="goods_info_sort_cat">
											<div class="accordion-group">
												<div class="accordion-heading">
													<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_cat">
													<strong>{t domain="goods"}商品分类{/t}</strong>
													</a>
												</div>
												<div class="accordion-body in in_visable collapse" id="goods_info_area_cat">
													<div class="accordion-inner">
														<div class="control-group m_b0">
															<label><b>{t domain="goods"}选择商品分类{/t}</b></label>
															<div>
																<select class="w300" name="cat_id">
																	<option value="0">{t domain="goods"}请选择...{/t}</option>
																	<!-- {foreach from=$cat_list item=cat} -->
																	<option {if $goods.cat_id eq $cat.cat_id}selected="selected"{/if} value="{$cat.cat_id}" {if $cat.level}style="padding-left:{$cat.level * 20}px"{/if}>{$cat.cat_name}</option>
																	<!-- {/foreach} -->
																</select>
																<div class="f_error">
																	<label class="cat_id_error ecjiafc-red">{t domain="goods"}请选择商品分类！{/t}</label>
																</div>
															</div>
															<label><b>{t domain="goods"}选择扩展分类{/t}</b></label>
															<div class="goods-cat m_b10">
																<div class="goods-span">
																	<!-- {foreach from=$cat_list item=cat} -->
																	<label style="padding-left:{$cat.level * 20}px" class="cat_{$cat.cat_id}">
																	<input type="checkbox" name="other_cat[]" value="{$cat.cat_id}" {if $cat.is_other_cat}checked="checked"{/if}/>
																	<span><!-- {$cat.cat_name} --></span>
																	</label>
																	<!-- {/foreach} -->
																</div>
															</div>
															<a class="l_h30 cursor_pointer add_cat_link">{t domain="goods"}添加商品分类{/t}</a>
															<label class="l_h30 add_cat_div hide"><b>{t domain="goods"}快速添加分类{/t}</b></label>
															<div class="add_cat_div hide cursor_pointer" data-url="{url path='goods/admin/add_category'}">
																<label>
																<input type="text" name="cat_name"/>
																<a class="add_cat_ok btn">{t domain="goods"}确定{/t}</a><br>
																</label>
																<a class="add_cat_cancel ecjiafc-red">{t domain="goods"}取消{/t}</a>
																<label class="help-block">{t domain="goods"}如已选择商品分类则添加该分类子类，否则为顶级分类{/t}</label>
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
													<strong>{t domain="goods"}商品品牌{/t}</strong>
													</a>
												</div>
												<div class="accordion-body in in_visable collapse" id="goods_info_area_brand">
													<div class="accordion-inner">
														<div class="control-group m_b0">
															<label><b>{t domain="goods"}选择商品品牌{/t}</b></label>
															<select class="w300" name="brand_id">
																<option value="0">{t domain="goods"}请选择...{/t}{html_options options=$brand_list selected=$goods.brand_id}</option>
															</select>
															<a class="l_h30 cursor_pointer add_brand_link">{t domain="goods"}添加商品品牌{/t}</a>
															<label class="l_h30 add_brand_div hide"><b>{t domain="goods"}快速添加品牌{/t}</b></label>
															<div class="add_brand_div hide cursor_pointer" data-url="{url path='goods/admin/add_brand'}">
																<label>
																<input type="text" name="brand_name"/>
																<a class="add_brand_ok btn">{t domain="goods"}确定{/t}</a>
																</label>
																<a class="add_brand_cancel ecjiafc-red">{t domain="goods"}取消{/t}</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="foldable-list move-mod-group" id="goods_info_sort_img">
											<div class="accordion-group">
												<div class="accordion-heading">
													<a class="accordion-toggle collapsed move-mod-head" data-toggle="collapse" data-target="#goods_info_area_img">
													<strong>{t domain="goods"}商品图片{/t}</strong>
													</a>
												</div>
												<div class="accordion-body in collapse" id="goods_info_area_img">
													<div class="accordion-inner">
														<div class="control-group">
															<label>{t domain="goods"}上传商品图片：{/t}</label>
															<div class="ecjiaf-db">
																<div class="goods_img">
																	<span {if $goods.goods_img}class="btn fileupload-btn preview-img" style="background-image: url({$goods.goods_img});"{else}class="btn fileupload-btn"{/if}>
																	<span class="fileupload-exists"><i class="fontello-icon-plus"></i></span>
																	</span>
																	<input class="hide" type="file" name="goods_img" onchange="ecjia.admin.goods_info.previewImage(this)"/>
																</div>
																<div class="thumb_img{if !$goods.goods_thumb} hide{/if}">
																	<label>{t domain="goods"}商品缩略图：{/t}</label>
																	<span {if $goods.goods_img}class="btn fileupload-btn preview-img" style="background-image: url({$goods.goods_thumb});"{else}class="btn fileupload-btn"{/if}>
																	<span class="fileupload-exists"><i class="fontello-icon-plus"></i></span>
																	</span>
																	<input class="hide" type="file" name="thumb_img" onchange="ecjia.admin.goods_info.previewImage(this)"/>
																</div>
																<div>
																	<span class="help-inline">{t domain="goods"}点击更换商品图片或商品缩略图。{/t}</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="foldable-list move-mod-group" id="goods_info_sort_rankprice">
											<div class="accordion-group">
												<div class="accordion-heading">
													<a class="accordion-toggle move-mod-head" data-toggle="collapse" data-target="#goods_info_area_rankprice">
													<strong>{t domain="goods"}折扣、促销价格{/t}</strong>
													</a>
												</div>
												<div class="accordion-body collapse" id="goods_info_area_rankprice">
													<div class="accordion-inner">
														<!-- {if $user_rank_list}  -->
														<!-- 会员价格  -->
														<div class="control-group control-group-small">
															<label class="w80 fl t_r">
															<b>{t domain="goods"}会员价格：{/t}</b>
															</label>
															<div class="f_l m_l30">
																<div class="goods-span">
																	<!-- {foreach from=$user_rank_list item=user_rank} -->
																	<div class="m_b5">
																		<span class="f_l w80 t_l l_h30">{$user_rank.rank_name|truncate:"10":".."}</span>
																		<input type="text" id="rank_{$user_rank.rank_id}" class="span4" name="user_price[]" value="{$member_price_list[$user_rank.rank_id]|default:-1}" size="8"/>
																		<input type="hidden" name="user_rank[]" value="{$user_rank.rank_id}"/>
																		<span class="m_l5" id="nrank_{$user_rank.rank_id}"></span>&nbsp;
																	</div>
																	<!-- {/foreach} -->
																	<p class="help-block w280 m_t5" id="noticeUserPrice">
																		{t domain="goods"}会员价格为-1时表示会员价格按会员等级折扣率计算。你也可以为每个等级指定一个固定价格{/t}
																	</p>
																</div>
															</div>
														</div>
														<!-- {/if} -->
														<!-- 优惠价格 -->
														<div class="control-group control-group-small">
															<label class="w80 f_l t_r"><b>{t domain="goods"}优惠价格{/t}：</b></label>
															<div class="f_l m_l10">
																<!-- {foreach from=$volume_price_list item=volume_price name="volume_price_tab"} -->
																<div class="goods-span">
																	<span class="m_l5 l_h30">{t domain="goods"}优惠数量{/t}</span>
																	<input class="w50" type="text" name="volume_number[]" size="8" value="{$volume_price.number}"/>
																	<span class="m_l5 l_h30">{t domain="goods"}优惠价格{/t}</span>
																	<input class="w80" type="text" name="volume_price[]" size="8" value="{$volume_price.price}"/>
																	<span>
																	{if $smarty.foreach.volume_price_tab.last}
																	<a class="l_h30 t_l no-underline" href="javascript:;" data-toggle="clone-obj" data-parent=".goods-span">
																	<i class="fontello-icon-plus hide"></i>
																	</a>
																	{else}
																	<a class="l_h30 t_l no-underline" href="javascript:;" data-toggle="remove-obj" data-parent=".goods-span">
																	<i class="fontello-icon-cancel ecjiafc-red"></i>
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
											</div>
										</div>
										<div class="foldable-list move-mod-group" id="goods_info_sort_promote">
											<div class="accordion-group">
												<div class="accordion-heading">
													<a class="accordion-toggle move-mod-head" data-toggle="collapse" data-target="#goods_info_area_promote">
													<strong>{t domain="goods"}促销信息{/t}</strong>
													</a>
												</div>
												<div class="accordion-body collapse" id="goods_info_area_promote">
													<div class="accordion-inner">
														<div class="control-group control-group-small">
															<input class="toggle_promote" type="checkbox" name="is_promote" value="1" {if $goods.is_promote}checked="checked"{/if}/>
															<span>{t domain="goods"}促销价：{/t}</span>
															<input class="span4" type="text" id="promote_1" name="promote_price" value="{$goods.promote_price}" size="20"{if !$goods.is_promote} disabled{/if}/>
														</div>
														<div class="control-group control-group-small">
															<div class="w300">
																<span class="m_l5 l_h30">{t domain="goods"}促销日期：{/t}</span>
																<input class="date span4" type="text" name="promote_start_date" size="12" value="{$goods.promote_start_date}"/>
																<span class="l_h30">-</span>
																<input class="date span4" type="text" name="promote_end_date" size="12" value="{$goods.promote_end_date}"/>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- 积分相关 -->
										<div class="foldable-list move-mod-group" id="goods_info_sort_integral">
											<div class="accordion-group">
												<div class="accordion-heading">
													<a class="accordion-toggle move-mod-head" data-toggle="collapse" data-target="#goods_info_area_integral">
													<strong>{t domain="goods"}积分相关{/t}</strong>
													</a>
												</div>
												<div class="accordion-body collapse" id="goods_info_area_integral">
													<div class="accordion-inner">
														<!-- 赠送消费积分数-->
														<div class="control-group control-group-small">
															<label class="f_l w120 m_t5">{t domain="goods"}赠送消费积分数：{/t}</label>
															<div class="m_l5 l_h30">
																<input class="span3" type="text" name="give_integral" value="{$goods.give_integral}" size="20" data-toggle="parseint_input"/>
																<span class="help-block" id="giveIntegral">
																{t domain="goods"}购买该商品时赠送消费积分数,-1表示按商品价格赠送{/t}
																</span>
															</div>
														</div>
														<!-- 赠送成长值 -->
														<div class="control-group control-group-small">
															<label class="f_l w120 m_t5">{t domain="goods"}赠送成长值：{/t}</label>
															<div class="m_l5 l_h30">
																<input class="span3" type="text" name="rank_integral" value="{$goods.rank_integral}" size="20" data-toggle="parseint_input"/>
																<span class="help-block" id="rankIntegral">{t domain="goods"}购买该商品时赠送成长值数,-1表示按商品价格赠送{/t}</span>
															</div>
														</div>
														<!-- 积分购买金额 -->
														<div class="control-group control-group-small">
															<label class="f_l w120 m_t5">{t domain="goods"}积分购买金额：{/t}</label>
															<div class="m_l5 l_h30">
																<input class="span3" type="text" name="integral" value="{$goods.integral}" size="20" data-toggle="parseint_input"/>
																<span class="help-block" id="noticPoints">{t domain="goods"}(此处需填写金额)购买该商品时最多可以使用积分的金额{/t}</span>
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