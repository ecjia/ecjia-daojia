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
					设置基本信息
				</div>
				<span class="m_t5">店铺名称、店铺信息等</span><span class="stepNb">1</span></li>
				<li id="step2" class="{if $step eq 2}current-step{/if}">
				<div>
					添加商品
				</div>
				<span class="m_t5">选择平台分类、添加商品</span><span class="stepNb">2</span></li>
				<li id="step3" class="{if $step eq 3}current-step{/if}">
				<div>
					配送设置
				</div>
				<span class="m_t5">设置店铺配送方式</span><span class="stepNb">3</span></li>
				<li id="step3" class="{if $step eq 4}current-step{/if}">
				<div>
					完成向导
				</div>
				<span class="m_t5">恭喜您！店铺可以使用了</span><span class="stepNb">4</span></li>
			</ul>
			<form class="form-horizontal cmxform" id="default" action="{url path='shopguide/merchant/step_post'}{if $smarty.get.step}&step={$smarty.get.step}{/if}" method="post" name="theForm" enctype="multipart/form-data" data-toggle='from'>
				<!-- {if !$smarty.get.step || $smarty.get.step eq '1'} -->
				<fieldset class="step1">
					<div class="form-group">
						<h3 class="control-label col-lg-3 m_t20">基本信息</h3>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t}店铺名称：{/t}</label>
						<div class="col-lg-6">
							<h4 class="col-lg-title">{$data.merchants_name}</h4>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-lg-3">店铺LOGO：<span class="help-block">推荐图片的尺寸为：512x512px</span></label>
						<div class="col-lg-6">
							<div class="fileupload fileupload-{if $data.shop_logo}exists{else}new{/if}" data-provides="fileupload">
								{if $data.shop_logo}
								<div class="fileupload-{if $data.shop_logo}exists{else}new{/if} thumbnail" style="max-width: 60px;">
									<img src="{$data.shop_logo}" alt="店铺LOGO" style="width:50px; height:50px;"/>
								</div>
	                       		{/if}
								<div class="fileupload-preview fileupload-{if $data.shop_logo}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;">
								</div>
								<span class="btn btn-primary btn-file btn-sm">
								<span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
								<span class="fileupload-exists"> 修改</span>
								<input type="file" class="default" name="shop_logo"/>
								</span>
								<a class="btn btn-danger btn-sm fileupload-exists" {if $data.shop_logo}data-toggle="ajaxremove"{else}data-dismiss="fileupload"{/if} data-msg="您确定要删除该店铺logo吗？" href="{url path='shopguide/merchant/drop_file' args="code=shop_logo"}">删除</a>
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-lg-3">{t}APP Banner图：{/t}<span class="help-block">推荐图片的尺寸为：3:1（600x200px）</span></label>
						<div class="col-lg-6">
							<div class="fileupload fileupload-{if $data.shop_banner_pic}exists{else}new{/if}" data-provides="fileupload">
                              	{if $data.shop_banner_pic}
								<div class="fileupload-{if $data.shop_banner_pic}exists{else}new{/if} thumbnail" style="max-width: 60px;">
									<img src="{$data.shop_banner_pic}" alt="banner图" style="width:50px; height:50px;"/>
								</div>
                             	{/if}
								<div class="fileupload-preview fileupload-{if $data.shop_banner_pic}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;">
								</div>
								<span class="btn btn-primary btn-file btn-sm">
								<span class="fileupload-new"><i class="fa fa-paper-clip"></i> 浏览</span>
								<span class="fileupload-exists"> 修改</span>
								<input type="file" class="default" name="shop_banner_pic"/>
								</span>
								<a class="btn btn-danger btn-sm fileupload-exists" {if $data.shop_banner_pic}data-toggle="ajaxremove"{else}data-dismiss="fileupload"{/if} data-msg="您确定要删除该APP Banner图吗？" href="{url path='shopguide/merchant/drop_file' args="code=shop_banner_pic"}">删除</a>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t}营业时间：{/t}</label>
						<div class="col-lg-12">
							<div class="range">
								<input class="range-slider" name="shop_trade_time" type="hidden" value="{$data.shop_time_value}"/>
							</div>
							<span class="help-block">拖拽选取营业时间段</span>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t}客服电话：{/t}</label>
						<div class="col-lg-6">
							<input class="form-control" type="text" name="shop_kf_mobile" value="{$data.shop_kf_mobile}"/>
						</div>
					</div>
					<div class="form-group">
						<label for="ccomment" class="control-label col-lg-3">{t}店铺公告：{/t}</label>
						<div class="col-lg-6 controls">
							<textarea class="form-control required" name="shop_notice">{$data.shop_notice}</textarea>
						</div>
						<span class="input-must">
						<span class="input-must">*</span>
						</span>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">{t}店铺简介：{/t}</label>
						<div class="col-lg-6 controls">
							<textarea class="form-control required" name="shop_description">{$data.shop_description}</textarea>
						</div>
						<span class="input-must">
						<span class="input-must">*</span>
						</span>
					</div>
					<div class="form-group">
						<div class="col-lg-6 m_t0">
							<input class="btn btn-info" type="submit" value="{lang key='shopguide::shopguide.next_step'}"/>
						</div>
					</div>
				</fieldset>
				<!-- {elseif $smarty.get.step eq '2'} -->
				<fieldset class="step2">
					<div class="form-group">
						<h3 class="control-label col-lg-3 m_t20">选择平台商品分类</h3>
					</div>
					<div class="form-group">
						<div class="tab-content">
							<fieldset>
								<div class="control-group draggable goods-cat-container">
									<div class="ms-container goods_cat_container" id="ms-custom-navigation" data-url='{url path="shopguide/merchant/get_cat_list"}'>
										<div class="ms-selectable">
											<div class="search-header">
												<input class="form-control" id="ms-search_zero" type="text" placeholder="请输入商品分类关键字" autocomplete="off">
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
												<li class="ms-elem-selectable disabled"><span>暂无内容</span></li>
												<!-- {/foreach} -->
											</ul>
										</div>
										<div class="ms-selectable">
											<div class="search-header">
												<input class="form-control" id="ms-search_one" type="text" placeholder="请输入商品分类关键字" autocomplete="off">
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
												<li class="ms-elem-selectable disabled"><span>暂无内容</span></li>
													{/if}
											</ul>
										</div>
										<div class="ms-selectable">
											<div class="search-header">
												<input class="form-control" id="ms-search_two" type="text" placeholder="请输入商品分类关键字" autocomplete="off">
											</div>
											<ul class="ms-list nav-list-ready level_2">
													{if $type eq 'prev' && $cat_info.level eq 2}
												<!-- {foreach from=$cat_list item=item} -->
														{if $item.level eq 2 && $item.parent_id eq $cat_info.parent_id}
												<li class="ms-elem-selectable {if $cat_info.cat_id eq $item.cat_id}selected{/if}" data-id="{$item.cat_id}" data-level="{$item.level}"><span>{$item.cat_name}</span></li>
														{/if}
												<!-- {/foreach} -->
													{else}
												<li class="ms-elem-selectable disabled"><span>暂无内容</span></li>
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
						<h3 class="control-label col-lg-3">添加商品</h3>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">{lang key='shopguide::shopguide.label_goods_name'}</label>
						<div class="controls col-lg-10">
							<input class="form-control" type="text" name="goods_name" value="{$goods_info.goods_name}"/>
						</div>
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3">商品图片：<span class="help-block">推荐图片的尺寸为：800，点击浏览按钮进行上传</span></label>
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
								<span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
								<span class="fileupload-exists"> 修改</span>
								<input type="file" class="default" name="goods_img"/>
								</span>
								<a class="btn btn-danger btn-sm fileupload-exists" {if $goods_info.goods_img}data-toggle="ajaxremove"{else}data-dismiss="fileupload"{/if} data-msg="您确定要删除该商品图片吗？" href="{url path='shopguide/merchant/drop_file' args="code=goods_img&goods_id={$goods_info.goods_id}"}">删除</a>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">{lang key='shopguide::shopguide.label_goods_price'}</label>
						<div class="col-lg-10">
							<input class="form-control" type="text" name="goods_price" value="{$goods_info.shop_price}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">商品库存：</label>
						<div class="col-lg-10">
							<input class="form-control" type="text" name="goods_num" value="{$goods_info.goods_number}"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">{lang key='shopguide::shopguide.label_goods_desc'}</label>
						<div class="col-lg-10">
							<textarea class="form-control" name="goods_brief">{$goods_info.goods_brief}</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 control-label">{lang key='shopguide::shopguide.label_add_recommend'}</label>
						<div class="col-lg-6">
							<div class="checkbox">
								<input id="is_best" type="checkbox" name="is_best" {if $goods_info.store_best eq 1}checked{/if}/>
								<label for="is_best">{lang key='shopguide::shopguide.is_best'}</label>
								<input id="is_new" type="checkbox" name="is_new" {if $goods_info.store_new eq 1}checked{/if}/>
								<label for="is_new">{lang key='shopguide::shopguide.is_new'}</label>
								<input id="is_hot" type="checkbox" name="is_hot" {if $goods_info.store_hot eq 1}checked{/if}/>
								<label for="is_hot">{lang key='shopguide::shopguide.is_hot'}</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-lg-6 m_t0">
							<input type="hidden" name="goods_id" value="{$goods_info.goods_id}"/>
							<a class="btn btn-info data-pjax" href="{RC_Uri::url('shopguide/merchant/init')}&type=prev">上一步</a>
							<input class="btn btn-info m_l10" type="submit" value="{lang key='shopguide::shopguide.next_step'}"/>
						</div>
					</div>
				</fieldset>
				<!-- {elseif $smarty.get.step eq '3'} -->
				<fieldset class="step3 step">
					<div class="form-group">
						<h3 class="control-label col-lg-3 m_t20">配送信息<span class="color_838383 m_l10">可开启配送方式，启用之后，点击配送方式可设置配送区域，配送方式可设置多个。此项非必填项，您可选择暂时跳过此步骤。</span></h3>
					</div>
					<ul class="step-ul">
						<!-- {foreach from=$shipping_list item=val} -->
						<a target="__blank" href="{RC_Uri::url('shipping/mh_area/init')}&shipping_id={$val.id}&code={$val.code}">
						<li class="step-li color_fff">{$val.name}<image class="check" src="{$app_url}/mh-check.png"/></li>
						</a>
						<!-- {/foreach} -->
						<a target="__blank" href="{RC_Uri::url('shipping/merchant/init')}">
						<li class="step-li">安装配送方式</li>
						</a>
					</ul>
					<div class="color_838383 m_l54">
						温馨提示：配送方式安装完成后，请刷新此页面查看安装后效果。
					</div>
					<div class="form-group">
						<div class="col-lg-6 m_t0">
							<a class="btn btn-info data-pjax" href="{RC_Uri::url('shopguide/merchant/init')}&step=2&type=prev{if $goods_info.goods_id}&goods_id={$goods_info.goods_id}{/if}">上一步</a>
							<input class="btn btn-info m_l10" type="submit" value="跳过"/>
							<input class="btn btn-info m_l10" type="submit" value="{lang key='shopguide::shopguide.next_step'}"/>
						</div>
					</div>
				</fieldset>
				<!-- {elseif $smarty.get.step eq '4'} -->
				<div class="step_three step">
					<div class="shopguide-complete">
						<div class="complete-header t_c">
							<img src="{$app_url}/mh-complete.png"/>
							<div class="complete-notice">
								恭喜您！网店可以使用了！
							</div>
							<a class="step-li m_0" href="{RC_Uri::url('merchant/dashboard/init')}">完成向导</a>
							<div class="complete-title">
								以下是部分常用功能的链接，您关闭本页面后，依然可以在左侧菜单中找到
							</div>
						</div>
						<ul class="complete-bottom">
							<a class="complete-li" href="{RC_Uri::url('goods/mh_category/init')}"><img src="{$app_url}/goods-category.png">商品分类</a>
							<a class="complete-li" href="{RC_Uri::url('goods/merchant/init')}"><img src="{$app_url}/goods-list.png">{lang key='shopguide::shopguide.goods_list'}</a>
							<a class="complete-li" href="{RC_Uri::url('goods/mh_spec/init')}"><img src="{$app_url}/goods-type.png">{lang key='shopguide::shopguide.goods_type'}</a>
							<a class="complete-li" href="{RC_Uri::url('staff/mh_group/add')}"><img src="{$app_url}/store.png">添加员工组</a>
							<a class="complete-li" href="{RC_Uri::url('staff/merchant/add')}&step=1"><img src="{$app_url}/add-user.png">添加员工</a>
							<a class="complete-li" href="{RC_Uri::url('favourable/merchant/add')}"><img src="{$app_url}/add-favourable.png">{lang key='shopguide::shopguide.add_favourable'}</a>
							<a class="complete-li" href="{RC_Uri::url('staff/mh_profile/init')}"><img src="{$app_url}/mail-setting.png">个人设置</a>
							<a class="complete-li" href="{RC_Uri::url('merchant/merchant/init')}"><img src="{$app_url}/store-setting.png">店铺设置</a>
							<a class="complete-li" href="{RC_Uri::url('shipping/merchant/init')}"><img src="{$app_url}/add-user.png">设置配送方式</a>
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