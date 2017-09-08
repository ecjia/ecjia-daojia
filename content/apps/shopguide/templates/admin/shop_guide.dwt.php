<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.admin.shopguide.init();
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
    <h3 class="heading">
        <!-- {if $ur_here}{$ur_here}{/if} -->
    </h3>
</div>

<div class="row-fluid">
    <div class="span12">
    	<ul id="validate_wizard-titles" class="stepy-titles clearfix">
    		<li id="step1" class="{if $step eq 1}current-step{/if}"><div>{lang key='shopguide::shopguide.base_info'}</div><span class="m_t5">商店的名称、标题、地区等</span><span class="stepNb">1</span></li>
    		<li id="step2" class="{if $step eq 2}current-step{/if}"><div>添加分类</div><span class="m_t5">添加商品分类、店铺分类</span><span class="stepNb">2</span></li>
    		<li id="step3" class="{if $step eq 3}current-step{/if}"><div>插件设置</div><span class="m_t5">设置配送方式、支付方式</span><span class="stepNb">3</span></li>
    		<li id="step3" class="{if $step eq 4}current-step{/if}"><div>完成向导</div><span class="m_t5">恭喜您！网店可以使用了</span><span class="stepNb">4</span></li>
    	</ul>
        <form class="stepy-wizzard form-horizontal application-installer" id="validate_wizard" action="{url path='shopguide/admin/step_post'}{if $smarty.get.step}&step={$smarty.get.step}{/if}" method="post" name="theForm">
            <!-- {if !$smarty.get.step || $smarty.get.step eq '1'} -->
            <fieldset class="step_one step">
                <h2>基本信息</h2>
                <div class="control-group m_t10 ecjiaf-pr">
					<label>{lang key='shopguide::shopguide.label_shop_name'}</label>
					<div class="controls">
						<input class="w500" type="text" name="shop_name" value="{$data.shop_name}" placeholder="请输入商店名称" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
					<div class="image-content fileupload fileupload-{if $data.shop_logo}exists{else}new{/if}" data-provides="fileupload">
						<div class="fileupload-preview thumbnail fileupload-exists shop-logo">
							<img src="{if $data.shop_logo}{$data.shop_logo}?{time()}{else}{$app_url}/shop-logo.png{/if}" />
						</div>
						<span class="text">请在上传前将文件名命名为logo.gif</span>
						<span class="btn btn-file">
							<span class="fileupload-new">上传logo</span>
							<span class="fileupload-exists">{t}修改{/t}</span>
							<input type="file" name="shop_logo" />
						</span>
						<a class="btn fileupload-exists" {if $data.shop_logo}data-toggle="ajaxremove"{else}data-dismiss="fileupload"{/if} data-msg="{t}您确定要删除该logo吗？{/t}" href="{url path='shopguide/admin/drop_logo'}">{t}删除{/t}</a>
					</div>
				</div>
				
				<div class="control-group">
					<label>{lang key='shopguide::shopguide.label_shop_title'}<span class="color_838383">商店的标题将显示在浏览器的标题栏</span></label>
					<input class="w500" type="text" name="shop_title" value="{$data.shop_title}" placeholder="请输入商店标题" />
				</div>
				
				<div class="control-group">
					<label>所在地区</label>
					<div>
						<select class="w160" name="shop_country" id="selCountries" data-toggle="regionSummary" data-url="{RC_Uri::url('shopguide/region/init')}" data-type="1" data-target="region-summary-provinces">
							<option value='0'>请选择国家...</option>
							<!-- {foreach from=$countries item=region} -->
							<option value="{$region.region_id}" {if $region.region_id eq $data.shop_country}selected{/if}>{$region.region_name}</option>
							<!-- {/foreach} -->
						</select>
						<div class="f_l m_l17">
							<select class="w160 region-summary-provinces" name="shop_province" id="selProvinces" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities">
								<option value='0'>请选择省份...</option>
								<!-- {foreach from=$provinces item=region} -->
								<option value="{$region.region_id}" {if $region.region_id eq $data.shop_province}selected{/if}>{$region.region_name}</option>
								<!-- {/foreach} -->
							</select>
						</div>
						
						<div class="f_l m_l17">
							<select class="w160 region-summary-cities" name="shop_city" id="selCities">
								<option value='0'>请选择城市...</option>
								<!-- {foreach from=$cities item=region} -->
								<option value="{$region.region_id}" {if $region.region_id eq $data.shop_city}selected{/if}>{$region.region_name}</option>
								<!-- {/foreach} -->
							</select>
						</div>
					</div>
				</div>
				<div class="control-group">
					<input class="w500" type="text" name="shop_address" placeholder="请输入详细地址"  value="{$data.shop_address}"/>
				</div>	
				
				<div class="control-group">
					<label>公司名称：</label>
					<input class="w500" type="text" name="company_name" placeholder="请输入公司名称"  value="{$data.company_name}"/>
				</div>
				
				<div class="control-group">
					<label>客服电话：</label>
					<input class="w500" type="text" name="service_phone" placeholder="请输入客服电话"  value="{$data.service_phone}"/>
				</div>
				
				<div class="control-group">
					<label>客服账号：<span class="color_838383">除邮件之外，如果您有多个客服的号码，请在每个号码之间使用半角逗号（,）分隔</span></label>
					<input class="w500" type="text" name="qq" placeholder="请输入qq号码" value="{$data.qq}"/><br/>
					<input class="w500 m_t10" type="text" name="ym" placeholder="请输入微信号码" value="{$data.ym}"/><br/>
					<input class="w500 m_t10" type="text" name="msn" placeholder="请输入微博号码" value="{$data.msn}"/><br/>
					<input class="w500 m_t10" type="text" name="service_email" placeholder="请输入电子邮件地址" value="{$data.service_email}"/>
				</div>

				<div class="control-group">
					<input class="btn btn-gebo" type="submit" value="{lang key='shopguide::shopguide.next_step'}" />
				</div>
            </fieldset>
            <!-- {elseif $smarty.get.step eq '2'} -->
            <fieldset class="step_two step">
            	<h2>添加分类</h2>
				<div class="control-group m_t10">
					<label>{lang key='shopguide::shopguide.label_goods_cat'}</label>
					<div class="controls">
						<input class="w500" type="text" name="cat_name" placeholder="请输入商品分类" value="{$data.cat_name}"/>
						<input type="hidden" name="cat_id" value="{$cat_id}" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>
				
				<div class="control-group m_t10">
					<label>{lang key='shopguide::shopguide.label_store_cat'}</label>
					<div class="controls">
						<input class="w500" type="text" name="store_cat" placeholder="请输入店铺分类" value="{$data.store_cat_name}"/>
						<input type="hidden" name="store_cat_id" value="{$store_cat_id}" />
						<span class="input-must">{lang key='system::system.require_field'}</span>
					</div>
				</div>		
				
				<div class="control-group">
					<a class="btn data-pjax" href="{RC_Uri::url('shopguide/admin/init')}&type=prev">上一步</a>
					<input class="btn btn-gebo m_l10" type="submit" value="{lang key='shopguide::shopguide.next_step'}" />
				</div>
			</fieldset>
			<!-- {elseif $smarty.get.step eq '3'} -->
			<fieldset class="step_three step">
				<h2>配送信息<span class="color_838383 m_l10">可开启配送方式，启用之后，点击配送方式可设置配送区域，配送方式可设置多个。此项非必填项，您可选择暂时跳过此步骤。</span></h2>
				<ul class="step-ul">
					<!-- {foreach from=$shipping_list item=val} -->
					<a target="__blank" href="{RC_Uri::url('shipping/admin_area_plugin/init')}&shipping_id={$val.shipping_id}&code={$val.shipping_code}">
						<li class="step-li color_fff">{$val.shipping_name}
							{if $val.enabled eq 1}<image class="check" src="{$app_url}/check.png" />{/if}
						</li>
					</a>
					<!-- {/foreach} -->
					<a target="__blank" href="{RC_Uri::url('shipping/admin_plugin/init')}"><li class="step-li">安装配送方式</li></a>
				</ul>
				<div class="color_838383 m_b20">温馨提示：配送方式安装完成后，请刷新此页面查看安装后效果。</div>
				
				<h2>支付方式<span class="color_838383 m_l10">可开启支付方式，启用之后，点击支付方式可设置支付方式信息，配送方式可设置多个。此项非必填项，您可选择暂时跳过此步骤。</span></h2>
				<ul class="step-ul">
					<!-- {foreach from=$payment_list item=val} -->
					<a target="__blank" href="{RC_Uri::url('payment/admin/edit')}&code={$val.pay_code}">
						<li class="step-li color_fff">
							{$val.pay_name}
							{if $val.enabled eq 1}<image class="check" src="{$app_url}/check.png" />{/if}
						</li>
					</a>
					<!-- {/foreach} -->
					<a target="__blank" href="{RC_Uri::url('payment/admin_plugin/init')}"><li class="step-li">安装支付方式</li></a>
				</ul>
				<div class="color_838383 m_b20">温馨提示：支付方式安装完成后，请刷新此页面查看安装后效果。</div>
				
				<div class="control-group">
					<a class="btn data-pjax" href="{RC_Uri::url('shopguide/admin/init')}&step=2&type=prev{if $cat_id}&cat_id={$cat_id}{/if}{if $store_cat_id}&store_cat_id={$store_cat_id}{/if}">上一步</a>
					<input class="btn btn-gebo m_l10" type="submit" value="跳过" />
					<input class="btn btn-gebo m_l10" type="submit" value="{lang key='shopguide::shopguide.next_step'}" />
				</div>
			</fieldset>
			<!-- {elseif $smarty.get.step eq '4'} -->
			<div class="step_three step">
				<div class="shopguide-complete">
					<div class="complete-header t_c">
						<img src="{$app_url}/complete.png" />
						<div class="complete-notice">恭喜您！网店可以使用了！</div>
						<a class="step-li m_0" href="{RC_Uri::url('@index/init')}">完成向导</a>
						<div class="complete-title">以下是部分常用功能的链接，您关闭本页面后，依然可以在左侧菜单中找到</div>
					</div>
					<ul class="complete-bottom">
						<a class="complete-li" href="{RC_Uri::url('@index/init')}"><img src="{$app_url}/store.png">{lang key='shopguide::shopguide.view_shop'}</a>
						<a class="complete-li" href="{RC_Uri::url('setting/shop_config/init')}&code=shop_info"><img src="{$app_url}/store-setting.png">{lang key='shopguide::shopguide.shop_config'}</a>
						<a class="complete-li" href="{RC_Uri::url('mail/admin_mail_settings/init')}"><img src="{$app_url}/mail-setting.png">邮件设置</a>
					
						<a class="complete-li" href="{RC_Uri::url('goods/admin_category/init')}"><img src="{$app_url}/goods-category.png">商品分类</a>
						<a class="complete-li" href="{RC_Uri::url('goods/admin/init')}"><img src="{$app_url}/goods-list.png">{lang key='shopguide::shopguide.goods_list'}</a>
						<a class="complete-li" href="{RC_Uri::url('goods/admin_goods_spec/init')}"><img src="{$app_url}/goods-type.png">{lang key='shopguide::shopguide.goods_type'}</a>
					
						<a class="complete-li" href="{RC_Uri::url('admincp/privilege/add')}"><img src="{$app_url}/add-admin.png">添加管理员</a>
						<a class="complete-li" href="{RC_Uri::url('user/admin/add')}"><img src="{$app_url}/add-user.png">{lang key='shopguide::shopguide.add_user'}</a>
						<a class="complete-li" href="{RC_Uri::url('favourable/admin/add')}"><img src="{$app_url}/add-favourable.png">{lang key='shopguide::shopguide.add_favourable'}</a>
					</ul>
				</div>
			</div>
			<!-- {/if} -->
        </form>
    </div>
</div>
<!-- {/block} -->