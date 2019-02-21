<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia-merchant.dwt.php"} -->
<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.shopguide.init();
</script>
<!-- {/block} -->
<!-- {block name="home-content"} -->
<div>
	<h3 class="heading">
	<!-- {if $ur_here}{$ur_here}{/if} -->
	</h3>
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
		<div class="panel-body">
			<ul id="validate_wizard-titles" class="stepy-titles clearfix">
				<li id="step1" class="{if $step eq 1}current-step{/if}">
				<div>
                    {t domain="shopguide"}设置基本信息{/t}
				</div>
				<span class="m_t5">{t domain="shopguide"}店铺名称、店铺信息等{/t}</span><span class="stepNb">1</span></li>
				<li id="step2" class="{if $step eq 2}current-step{/if}">
				<div>
                    {t domain="shopguide"}添加商品{/t}
				</div>
				<span class="m_t5">{t domain="shopguide"}选择平台分类、添加商品{/t}</span><span class="stepNb">2</span></li>
				<li id="step3" class="{if $step eq 3}current-step{/if}">
				<div>
                    {t domain="shopguide"}运费模板{/t}
				</div>
				<span class="m_t5">{t domain="shopguide"}设置店铺运费模板{/t}</span><span class="stepNb">3</span></li>
				<li id="step3" class="{if $step eq 4}current-step{/if}">
				<div>
                    {t domain="shopguide"}完成向导{/t}
				</div>
				<span class="m_t5">{t domain="shopguide"}恭喜您！店铺可以使用了{/t}</span><span class="stepNb">4</span></li>
			</ul>
			<form class="form-horizontal cmxform" id="default" action="{url path='shopguide/merchant/step_post'}{if $smarty.get.step}&step={$smarty.get.step}{/if}" method="post" name="theForm" enctype="multipart/form-data" data-toggle='from'>
				<!-- {if !$smarty.get.step || $smarty.get.step eq '1'} -->
				<fieldset class="step1">
					<div class="form-group">
						<h3 class="control-label col-lg-3 m_t20">{t domain="shopguide"}基本信息{/t}</h3>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="shopguide"}店铺名称：{/t}</label>
						<div class="col-lg-6">
							<h4 class="col-lg-title">{$data.merchants_name}</h4>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="shopguide"}店铺LOGO：{/t}<span class="help-block">{t domain="shopguide"}推荐图片的尺寸为：512x512px{/t}</span></label>
						<div class="col-lg-6">
							<div class="fileupload fileupload-{if $data.shop_logo}exists{else}new{/if}" data-provides="fileupload">
								{if $data.shop_logo}
								<div class="fileupload-{if $data.shop_logo}exists{else}new{/if} thumbnail" style="max-width: 60px;">
									<img src="{$data.shop_logo}" alt='{t domain="shopguide"}店铺LOGO{/t}' style="width:50px; height:50px;"/>
								</div>
	                       		{/if}
								<div class="fileupload-preview fileupload-{if $data.shop_logo}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;">
								</div>
								<span class="btn btn-primary btn-file btn-sm">
								<span class="fileupload-new"><i class="fa fa-paper-clip"></i>{t domain="shopguide"}浏览{/t}</span>
								<span class="fileupload-exists"> {t domain="shopguide"}修改{/t}</span>
								<input type="file" class="default" name="shop_logo"/>
								</span>
								<a class="btn btn-danger btn-sm fileupload-exists" {if $data.shop_logo}data-toggle="ajaxremove"{else}data-dismiss="fileupload"{/if} data-msg="您确定要删除该店铺logo吗？" href="{url path='shopguide/merchant/drop_file' args="code=shop_logo"}">删除</a>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="shopguide"}店铺顶部Banner图：{/t}<span class="help-block">{t domain="shopguide"}推荐图片的尺寸为：3:1（600x200px）{/t}</span></label>
						<div class="col-lg-6">
							<div class="fileupload fileupload-{if $data.shop_banner_pic}exists{else}new{/if}" data-provides="fileupload">
                              	{if $data.shop_banner_pic}
								<div class="fileupload-{if $data.shop_banner_pic}exists{else}new{/if} thumbnail" style="max-width: 60px;">
									<img src="{$data.shop_banner_pic}" alt='{t domain="shopguide"}banner图{/t}' style="width:50px; height:50px;"/>
								</div>
                             	{/if}
								<div class="fileupload-preview fileupload-{if $data.shop_banner_pic}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;">
								</div>
								<span class="btn btn-primary btn-file btn-sm">
								<span class="fileupload-new"><i class="fa fa-paper-clip"></i> {t domain="shopguide"}浏览{/t}</span>
								<span class="fileupload-exists"> {t domain="shopguide"}修改{/t}</span>
								<input type="file" class="default" name="shop_banner_pic"/>
								</span>
								<a class="btn btn-danger btn-sm fileupload-exists" {if $data.shop_banner_pic}data-toggle="ajaxremove"{else}data-dismiss="fileupload"{/if} data-msg="您确定要删除该图吗？" href="{url path='shopguide/merchant/drop_file' args="code=shop_banner_pic"}">删除</a>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="shopguide"}营业时间：{/t}</label>
						<div class="col-lg-12">
							<div class="range">
								<input class="range-slider" name="shop_trade_time" type="hidden" value="{$data.shop_time_value}"/>
							</div>
							<span class="help-block">{t domain="shopguide"}拖拽选取营业时间段{/t}</span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="shopguide"}客服电话：{/t}</label>
						<div class="col-lg-6">
							<input class="form-control" type="text" name="shop_kf_mobile" value="{$data.shop_kf_mobile}"/>
						</div>
					</div>
					<div class="form-group">
						<label for="ccomment" class="control-label col-lg-3">{t domain="shopguide"}店铺公告：{/t}</label>
						<div class="col-lg-6 controls">
							<textarea class="form-control required" name="shop_notice">{$data.shop_notice}</textarea>
						</div>
						<span class="input-must">
						<span class="input-must">*</span>
						</span>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="shopguide"}店铺简介：{/t}</label>
						<div class="col-lg-6 controls">
							<textarea class="form-control required" name="shop_description">{$data.shop_description}</textarea>
						</div>
						<span class="input-must">
						<span class="input-must">*</span>
						</span>
					</div>
					<div class="form-group">
						<div class="col-lg-6 m_t0">
							<input class="btn btn-info" type="submit" value="{t domain="shopguide"}下一步{/t}"/>
						</div>
					</div>
				</fieldset>
				<!-- {elseif $smarty.get.step eq '2'} -->
				<fieldset class="step2">
					<div class="form-group">
						<h3 class="control-label col-lg-3 m_t20">{t domain="shopguide"}选择平台商品分类{/t}</h3>
					</div>
					<div class="form-group">
						<div class="tab-content">
							<fieldset>
								<div class="control-group draggable goods-cat-container">
									<div class="ms-container goods_cat_container" id="ms-custom-navigation" data-url='{url path="shopguide/merchant/get_cat_list"}'>
										<div class="ms-selectable">
											<div class="search-header">
												<input class="form-control" id="ms-search_zero" type="text" placeholder='{t domain="shopguide"}请输入商品分类关键字{/t}' autocomplete="off">
											</div>
											<ul class="ms-list nav-list-ready level_0">
												<!-- {foreach from=$cat_list item=item} -->
													{if $item.level eq 0}
														{if $cat_info.level eq 2}
												<li class="ms-elem-selectable {if $cat_info.parents.cat_id eq $item.cat_id}selected{/if}" data-id="{$item.cat_id}" data-level="{$item.level}"><span>{$item.cat_name}</span></li>
														{/if}
														{if $cat_info.level eq 1}
												<li class="ms-elem-selectable {if $cat_info.parent_id eq $item.cat_id}selected{/if}" data-id="{$item.cat_id}" data-level="{$item.level}"><span>{$item.cat_name}</span></li>
														{/if}
														{if $cat_info.level eq 0}
												<li class="ms-elem-selectable {if $cat_info.cat_id eq $item.cat_id}selected{/if}" data-id="{$item.cat_id}" data-level="{$item.level}"><span>{$item.cat_name}</span></li>
														{/if}
													{/if}
												<!-- {foreachelse} -->
												<li class="ms-elem-selectable disabled"><span>{t domain="shopguide"}暂无内容{/t}</span></li>
												<!-- {/foreach} -->
											</ul>
										</div>
										<div class="ms-selectable">
											<div class="search-header">
												<input class="form-control" id="ms-search_one" type="text" placeholder='{t domain="shopguide"}请输入商品分类关键字{/t}' autocomplete="off">
											</div>
											<ul class="ms-list nav-list-ready level_1">
													{if $type eq 'prev' && $cat_info.level gt 0}
												<!-- {foreach from=$cat_list item=item} -->
														{if $item.level eq 1 && $item.parent_id eq $cat_info.parent.parent_id && $cat_info.level eq 2}
												<li class="ms-elem-selectable {if $cat_info.parent_id eq $item.cat_id}selected{/if}" data-id="{$item.cat_id}" data-level="{$item.level}"><span>{$item.cat_name}</span></li>
														{/if}
														{if $item.level eq 1 && $item.parent_id eq $cat_info.parent_id && $cat_info.level eq 1}
												<li class="ms-elem-selectable {if $cat_info.cat_id eq $item.cat_id}selected{/if}" data-id="{$item.cat_id}" data-level="{$item.level}"><span>{$item.cat_name}</span></li>
														{/if}
												<!-- {/foreach} -->
													{else}
												<li class="ms-elem-selectable disabled"><span>{t domain="shopguide"}暂无内容{/t}</span></li>
													{/if}
											</ul>
										</div>
										<div class="ms-selectable">
											<div class="search-header">
												<input class="form-control" id="ms-search_two" type="text" placeholder='{t domain="shopguide"}请输入商品分类关键字{/t}' autocomplete="off">
											</div>
											<ul class="ms-list nav-list-ready level_2">
													{if $type eq 'prev' && $cat_info.level eq 2}
												<!-- {foreach from=$cat_list item=item} -->
														{if $item.level eq 2 && $item.parent_id eq $cat_info.parent_id}
												<li class="ms-elem-selectable {if $cat_info.cat_id eq $item.cat_id}selected{/if}" data-id="{$item.cat_id}" data-level="{$item.level}"><span>{$item.cat_name}</span></li>
														{/if}
												<!-- {/foreach} -->
													{else}
												<li class="ms-elem-selectable disabled"><span>{t domain="shopguide"}暂无内容{/t}</span></li>
													{/if}
											</ul>
										</div>
									</div>
								</div>
							</fieldset>
							<input type="hidden" name="cat_id" value="{$cat_info.cat_id}"/>
						</div>
					</div>
					<div class="form-group">
						<h3 class="control-label col-lg-3">{t domain="shopguide"}添加商品{/t}</h3>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">{t domain="shopguide"}商品名称：{/t}</label>
						<div class="controls col-lg-10">
							<input class="form-control" type="text" name="goods_name" value="{$goods_info.goods_name}"/>
						</div>
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t domain="shopguide"}商品图片：{/t}<span class="help-block">{t domain="shopguide"}推荐图片的尺寸为：800，点击浏览按钮进行上传{/t}</span></label>
						<div class="col-lg-6">
							<div class="fileupload fileupload-{if $goods_info.goods_img}exists{else}new{/if}" data-provides="fileupload">
								{if $goods_info.goods_img}
								<div class="fileupload-{if $goods_info.goods_img}exists{else}new{/if} thumbnail" style="max-width: 60px;">
									<img src="{$goods_info.goods_img}" style="width:50px; height:50px;"/>
								</div>
	                       		{/if}
								<div class="fileupload-preview fileupload-{if $goods_info.goods_img}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;">
								</div>
								<span class="btn btn-primary btn-file btn-sm">
								<span class="fileupload-new"><i class="fa fa-paper-clip"></i>{t domain="shopguide"}浏览{/t}</span>
								<span class="fileupload-exists"> {t domain="shopguide"}修改{/t}</span>
								<input type="file" class="default" name="goods_img"/>
								</span>
								<a class="btn btn-danger btn-sm fileupload-exists" {if $goods_info.goods_img}data-toggle="ajaxremove"{else}data-dismiss="fileupload"{/if} data-msg='{t domain="shopguide"}您确定要删除该商品图片吗？{/t}' href="{url path='shopguide/merchant/drop_file' args="code=goods_img&goods_id={$goods_info.goods_id}"}">删除</a>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">{t domain="shopguide"}商品价格：{/t}</label>
						<div class="col-lg-10">
							<input class="form-control" type="text" name="goods_price" value="{$goods_info.shop_price}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">{t domain="shopguide"}商品库存：{/t}</label>
						<div class="col-lg-10">
							<input class="form-control" type="text" name="goods_num" value="{$goods_info.goods_number}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">{t domain="shopguide"}简单描述：{/t}</label>
						<div class="col-lg-10">
							<textarea class="form-control" name="goods_brief">{$goods_info.goods_brief}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">{t domain="shopguide"}加入推荐：{/t}</label>
						<div class="col-lg-6">
							<div class="checkbox">
								<input id="is_best" type="checkbox" name="is_best" {if $goods_info.store_best eq 1}checked{/if}/>
								<label for="is_best">{t domain="shopguide"}精品{/t}</label>
								<input id="is_new" type="checkbox" name="is_new" {if $goods_info.store_new eq 1}checked{/if}/>
								<label for="is_new">{t domain="shopguide"}新品{/t}</label>
								<input id="is_hot" type="checkbox" name="is_hot" {if $goods_info.store_hot eq 1}checked{/if}/>
								<label for="is_hot">{t domain="shopguide"}热卖{/t}</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-6 m_t0">
							<input type="hidden" name="goods_id" value="{$goods_info.goods_id}"/>
							<a class="btn btn-info data-pjax" href="{RC_Uri::url('shopguide/merchant/init')}&type=prev">{t domain="shopguide"}上一步{/t}</a>
							<input class="btn btn-info m_l10" type="submit" value='{t domain="shopguide"}下一步{/t}'/>
						</div>
					</div>
				</fieldset>
				<!-- {elseif $smarty.get.step eq '3'} -->
				<fieldset class="step3 step">
					<div class="form-group">
						<h3 class="control-label col-lg-3 m_t20">{t domain="shopguide"}运费模板{/t}<span class="color_838383 m_l10">{t domain="shopguide"}点击添加运费模板，运费模板添加好后即可开启配送方式，可添加多个运费模板。此项非必填项，您可选择暂时跳过此步骤。{/t}</span></h3>
					</div>
					<ul class="step-ul">
						<!-- {foreach from=$shipping_list item=list} -->
						<div class="template-item">
							<div class="template-head">
								<div class="head-left">{$list.shipping_area_name}</div>
								<div class="head-right">
									<a target="__blank" href='{RC_Uri::url("shipping/mh_shipping/edit_shipping_template")}&template_name={$list.shipping_area_name}'>{t domain="shopguide"}查看详情{/t}</a> &nbsp;|&nbsp;
									<a data-toggle="ajaxremove" class="ajaxremove ecjiafc-red" data-msg='{t domain="shopguide"}您确定要删除该运费模板吗？{/t}' href='{RC_Uri::url("shipping/mh_shipping/remove_shipping_template", "name={$list.shipping_area_name}")}' title='{t domain="shopguide"}删除{/t}'>{t domain="shopguide"}删除{/t}</a>
								</div>
							</div>
							<div class="template-content">
								<div class="content-group">
									<div class="content-label">{t domain="shopguide"}物流快递：{/t}</div>
									<div class="content-controls">
										{$list.shipping_name}
									</div>
								</div>
								<div class="content-group">
									<div class="content-label">{t domain="shopguide"}配送区域：{/t}</div>
									<div class="content-controls">
										{$list.shipping_area}
									</div>
								</div>
							</div>
						</div>
						<!-- {/foreach} -->
						<a target="__blank" href="{RC_Uri::url('shipping/mh_shipping/add_shipping_template')}">
						<li class="step-li">{t domain="shopguide"}添加运费模板{/t}</li>
						</a>
					</ul>
					<div class="color_838383 m_l54">
                        {t domain="shopguide"}温馨提示：运费模板添加完成后，请刷新此页面查看安装后效果。{/t}
					</div>
					<div class="form-group">
						<div class="col-lg-6 m_t0">
							<a class="btn btn-info data-pjax" href="{RC_Uri::url('shopguide/merchant/init')}&step=2&type=prev{if $goods_info.goods_id}&goods_id={$goods_info.goods_id}{/if}">{t domain="shopguide"}上一步{/t}</a>
							<input class="btn btn-info m_l10" type="submit" value='{t domain="shopguide"}跳过{/t}'/>
							<input class="btn btn-info m_l10" type="submit" value='{t domain="shopguide"}下一步{/t}'/>
						</div>
					</div>
				</fieldset>
				<!-- {elseif $smarty.get.step eq '4'} -->
				<div class="step_three step">
					<div class="shopguide-complete">
						<div class="complete-header t_c">
							<img src="{$app_url}/mh-complete.png"/>
							<div class="complete-notice">
                                {t domain="shopguide"}恭喜您！网店可以使用了！{/t}
							</div>
							<a class="step-li m_0" href="{RC_Uri::url('merchant/dashboard/init')}">{t domain="shopguide"}完成向导{/t}</a>
							<div class="complete-title">
                                {t domain="shopguide"}以下是部分常用功能的链接，您关闭本页面后，依然可以在左侧菜单中找到{/t}
							</div>
						</div>
						<ul class="complete-bottom">
							<a class="complete-li" href="{RC_Uri::url('goods/mh_category/init')}"><img src="{$app_url}/goods-category.png">{t domain="shopguide"}商品分类{/t}</a>
							<a class="complete-li" href="{RC_Uri::url('goods/merchant/init')}"><img src="{$app_url}/goods-list.png">{t domain="shopguide"}商品列表{/t}</a>
							<a class="complete-li" href="{RC_Uri::url('goods/mh_spec/init')}"><img src="{$app_url}/goods-type.png">{t domain="shopguide"}商品类型{/t}</a>
							<a class="complete-li" href="{RC_Uri::url('staff/mh_group/add')}"><img src="{$app_url}/store.png">{t domain="shopguide"}添加员工组{/t}</a>
							<a class="complete-li" href="{RC_Uri::url('staff/merchant/add')}&step=1"><img src="{$app_url}/add-user.png">{t domain="shopguide"}添加员工{/t}</a>
							<a class="complete-li" href="{RC_Uri::url('favourable/merchant/add')}"><img src="{$app_url}/add-favourable.png">{t domain="shopguide"}添加优惠活动{/t}</a>
							<a class="complete-li" href="{RC_Uri::url('staff/mh_profile/init')}"><img src="{$app_url}/mail-setting.png">{t domain="shopguide"}个人设置{/t}</a>
							<a class="complete-li" href="{RC_Uri::url('merchant/merchant/init')}"><img src="{$app_url}/store-setting.png">{t domain="shopguide"}店铺设置{/t}</a>
							<a class="complete-li" href="{RC_Uri::url('shipping/mh_shipping/add_shipping_template')}"><img src="{$app_url}/add-user.png">{t domain="shopguide"}添加运费模板{/t}</a>
						</ul>
					</div>
				</div>
				<!-- {/if} -->
			</form>
		</div>
		</section>
	</div>
</div>
<!-- {/block} -->