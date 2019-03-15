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
    		<li id="step1" class="{if $step eq 1}current-step{/if}"><div>{t domain="shopguide"}设置商店的一些基本信息{/t}</div><span class="m_t5">{t domain="shopguide"}商店的名称、标题、地区等{/t}</span><span class="stepNb">1</span></li>
    		<li id="step2" class="{if $step eq 2}current-step{/if}"><div>{t domain="shopguide"}添加分类{/t}</div><span class="m_t5">{t domain="shopguide"}添加商品分类、店铺分类{/t}</span><span class="stepNb">2</span></li>
    		<li id="step3" class="{if $step eq 3}current-step{/if}"><div>{t domain="shopguide"}插件设置{/t}</div><span class="m_t5">{t domain="shopguide"}设置配送方式、支付方式{/t}</span><span class="stepNb">3</span></li>
    		<li id="step3" class="{if $step eq 4}current-step{/if}"><div>{t domain="shopguide"}完成向导{/t}</div><span class="m_t5">{t domain="shopguide"}恭喜您！网店可以使用了{/t}</span><span class="stepNb">4</span></li>
    	</ul>
        <form class="stepy-wizzard form-horizontal application-installer" id="validate_wizard" action="{url path='shopguide/admin/step_post'}{if $smarty.get.step}&step={$smarty.get.step}{/if}" method="post" name="theForm">
            <!-- {if !$smarty.get.step || $smarty.get.step eq '1'} -->
            <fieldset class="step_one step">
            	<h2>{t domain="shopguide"}地区管理{/t}</h2>
            	<div class="control-group m_t10 ecjiaf-pr">
            		<label>{t domain="shopguide"}地区同步：{/t}<span class="color_838383">{t domain="shopguide"}点以下按钮可获取四级地区信息到本地。{/t}<br/>{t domain="shopguide"}请务必先同步地区，才可进行其他操作。{/t}</span></label>
            		<div class="controls"><button class="get_region_info btn m_t5" data-msg='{t domain="shopguide"}你确定执行此操作吗？{/t}' data-url='{RC_Uri::url("shopguide/admin/get_regioninfo")}' data-value="get_regioninfo">{t domain="shopguide"}同步地区表信息{/t}</button></div>
            	</div>
            	
                <h2>{t domain="shopguide"}基本信息{/t}</h2>
                <div class="control-group m_t10 ecjiaf-pr">
					<label>{t domain="shopguide"}商店名称：{/t}</label>
					<div class="controls">
						<input class="w500" type="text" name="shop_name" value="{$data.shop_name}" placeholder='{t domain="shopguide"}请输入商店名称{/t}' />
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
					<div class="image-content fileupload fileupload-{if $data.shop_logo}exists{else}new{/if}" data-provides="fileupload">
						<div class="fileupload-preview thumbnail fileupload-exists shop-logo">
							<img src="{if $data.shop_logo}{$data.shop_logo}?{time()}{else}{$app_url}/shop-logo.png{/if}" />
						</div>
						<span class="text">{t domain="shopguide"}请在上传前将文件名命名为logo.gif{/t}</span>
						<span class="btn btn-file">
							<span class="fileupload-new">{t domain="shopguide"}上传logo{/t}</span>
							<span class="fileupload-exists">{t domain="shopguide"}修改{/t}</span>
							<input type="file" name="shop_logo" />
						</span>
						<a class="btn fileupload-exists" {if $data.shop_logo}data-toggle="ajaxremove"{else}data-dismiss="fileupload"{/if} data-msg='{t domain="shopguide"}您确定要删除该logo吗？{/t}' href="{url path='shopguide/admin/drop_logo'}">{t}删除{/t}</a>
					</div>
				</div>
				
				<div class="control-group">
					<label>{t domain="shopguide"}商店标题：{/t}<span class="color_838383">{t domain="shopguide"}商店的标题将显示在浏览器的标题栏{/t}</span></label>
					<input class="w500" type="text" name="shop_title" value="{$data.shop_title}" placeholder='{t domain="shopguide"}请输入商店标题{/t}' />
				</div>
				
				<div class="control-group">
					<label>{t domain="shopguide"}所在地区{/t}</label>
					<div>
						<select class="w160" name="shop_country" id="selCountries" data-toggle="regionSummary" data-url="{RC_Uri::url('setting/region/init')}" data-target="region-summary-provinces">
							<option value='0'>{t domain="shopguide"}请选择国家...{/t}</option>
							<!-- {foreach from=$countries key=key item=region} -->
							<option value="{$key}" {if $key eq $ecjia_config.shop_country}selected{/if}>{$region}</option>
							<!-- {/foreach} -->
						</select>
						<div class="f_l m_l17">
							<select class="w160 region-summary-provinces" name="shop_province" id="selProvinces" data-toggle="regionSummary" data-target="region-summary-cities">
								<option value='0'>{t domain="shopguide"}请选择省份...{/t}</option>
								<!-- {foreach from=$provinces item=region} -->
								<option value="{$region.region_id}" {if $region.region_id eq $data.shop_province}selected{/if}>{$region.region_name}</option>
								<!-- {/foreach} -->
							</select>
						</div>
						
						<div class="f_l m_l17">
							<select class="w160 region-summary-cities" name="shop_city" id="selCities">
								<option value='0'>{t domain="shopguide"}请选择城市...{/t}</option>
								<!-- {foreach from=$cities item=region} -->
								<option value="{$region.region_id}" {if $region.region_id eq $data.shop_city}selected{/if}>{$region.region_name}</option>
								<!-- {/foreach} -->
							</select>
						</div>
					</div>
				</div>
				<div class="control-group">
					<input class="w500" type="text" name="shop_address" placeholder='{t domain="shopguide"}请输入详细地址{/t}'  value="{$data.shop_address}"/>
				</div>	
				
				<div class="control-group">
					<label>{t domain="shopguide"}公司名称：{/t}</label>
					<input class="w500" type="text" name="company_name" placeholder='{t domain="shopguide"}请输入公司名称{/t}'  value="{$data.company_name}"/>
				</div>
				
				<div class="control-group">
					<label>{t domain="shopguide"}客服电话：{/t}</label>
					<input class="w500" type="text" name="service_phone" placeholder='{t domain="shopguide"}请输入客服电话{/t}'  value="{$data.service_phone}"/>
				</div>
				
				<div class="control-group">
					<label>{t domain="shopguide"}客服账号：{/t}<span class="color_838383">{t domain="shopguide"}除邮件之外，如果您有多个客服的号码，请在每个号码之间使用半角逗号（,）分隔{/t}</span></label>
					<input class="w500" type="text" name="qq" placeholder='{t domain="shopguide"}请输入qq号码{/t}' value="{$data.qq}"/><br/>
					<input class="w500 m_t10" type="text" name="ym" placeholder='{t domain="shopguide"}请输入微信号码{/t}' value="{$data.ym}"/><br/>
					<input class="w500 m_t10" type="text" name="msn" placeholder='{t domain="shopguide"}请输入微博号码{/t}' value="{$data.msn}"/><br/>
					<input class="w500 m_t10" type="text" name="service_email" placeholder='{t domain="shopguide"}请输入电子邮件地址{/t}' value="{$data.service_email}"/>
				</div>

				<div class="control-group">
					<input class="btn btn-gebo" type="submit" value='{t domain="shopguide"}下一步{/t}' />
				</div>
            </fieldset>
            <!-- {elseif $smarty.get.step eq '2'} -->
            <fieldset class="step_two step">
            	<h3>{t domain="shopguide"}添加商品分类{/t}</h3>
				<div class="control-group m_t10">
					<label>{t domain="shopguide"}商品分类：{/t}
                        </label>
					<div class="controls">
						<input class="w500" type="text" name="cat_name" placeholder='{t domain="shopguide"}请输入商品分类{/t}' value="{$data.cat_name}"/>
						<input type="hidden" name="cat_id" value="{$cat_id}" />
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
                    <span class="help-block" id="">{t domain="shopguide"}新网站必须添加至少一个商品分类，方便添加新商品。{/t}</span>
				</div>

                <h3>{t domain="shopguide"}添加店铺分类{/t}</h3>
				<div class="control-group m_t10">
					<label>{t domain="shopguide"}店铺分类：{/t}</label>
					<div class="controls">
						<input class="w500" type="text" name="store_cat" placeholder='{t domain="shopguide"}请输入店铺分类{/t}' value="{$data.store_cat_name}"/>
						<input type="hidden" name="store_cat_id" value="{$store_cat_id}" />
						<span class="input-must"><span class="require-field" style="color:#FF0000,">*</span></span>
					</div>
                    <span class="help-block" id="">{t domain="shopguide"}新网站必须添加至少一个店铺分类，方便商家入驻。{/t}</span>
				</div>		
				
				<div class="control-group">
					<a class="btn data-pjax" href="{RC_Uri::url('shopguide/admin/init')}&type=prev">{t domain="shopguide"}上一步{/t}</a>
					<input class="btn btn-gebo m_l10" type="submit" value='{t domain="shopguide"}下一步{/t}' />
				</div>
			</fieldset>
			<!-- {elseif $smarty.get.step eq '3'} -->
			<fieldset class="step_three step">
				<h2>{t domain="shopguide"}配送信息{/t}<span class="color_838383 m_l10">{t domain="shopguide"}可开启配送方式，启用之后，点击配送方式可设置配送区域，配送方式可设置多个。此项非必填项，您可选择暂时跳过此步骤。{/t}</span></h2>
				<ul class="step-ul">
					<!-- {foreach from=$shipping_list item=val} -->
					<a target="_blank" href="{RC_Uri::url('shipping/admin_plugin/init')}&shipping_id={$val.shipping_id}&code={$val.shipping_code}">
						<li class="step-li color_fff">{$val.shipping_name}
							{if $val.enabled eq 1}<image class="check" src="{$app_url}/check.png" />{/if}
						</li>
					</a>
					<!-- {/foreach} -->
					<a target="_blank" href="{RC_Uri::url('shipping/admin_plugin/init')}"><li class="step-li">{t domain="shopguide"}安装配送方式{/t}</li></a>
				</ul>
				<div class="color_838383 m_b20">{t domain="shopguide"}温馨提示：配送方式安装完成后，请刷新此页面查看安装后效果。{/t}</div>
				
				<h2>{t domain="shopguide"}支付方式{/t}<span class="color_838383 m_l10">{t domain="shopguide"}可开启支付方式，启用之后，点击支付方式可设置支付方式信息，配送方式可设置多个。此项非必填项，您可选择暂时跳过此步骤。{/t}</span></h2>
				<ul class="step-ul">
					<!-- {foreach from=$payment_list item=val} -->
					<a target="_blank" href="{RC_Uri::url('payment/admin_plugin/edit')}&code={$val.pay_code}">
						<li class="step-li color_fff">
							{$val.pay_name}
							{if $val.enabled eq 1}<image class="check" src="{$app_url}/check.png" />{/if}
						</li>
					</a>
					<!-- {/foreach} -->
					<a target="_blank" href="{RC_Uri::url('payment/admin_plugin/init')}"><li class="step-li">{t domain="shopguide"}安装支付方式{/t}</li></a>
				</ul>
				<div class="color_838383 m_b20">{t domain="shopguide"}温馨提示：支付方式安装完成后，请刷新此页面查看安装后效果。{/t}</div>
				
				<div class="control-group">
					<a class="btn data-pjax" href="{RC_Uri::url('shopguide/admin/init')}&step=2&type=prev{if $cat_id}&cat_id={$cat_id}{/if}{if $store_cat_id}&store_cat_id={$store_cat_id}{/if}">{t domain="shopguide"}上一步{/t}</a>
					<input class="btn btn-gebo m_l10" type="submit" value='{t domain="shopguide"}跳过{/t}' />
					<input class="btn btn-gebo m_l10" type="submit" value='{t domain="shopguide"}下一步{/t}' />
				</div>
			</fieldset>
			<!-- {elseif $smarty.get.step eq '4'} -->
			<div class="step_three step">
				<div class="shopguide-complete">
					<div class="complete-header t_c">
						<img src="{$app_url}/complete.png" />
						<div class="complete-notice">{t domain="shopguide"}恭喜您！网店可以使用了！{/t}</div>
						<a class="step-li m_0" href="{RC_Uri::url('@index/init')}">{t domain="shopguide"}完成向导{/t}</a>
						<div class="complete-title">{t domain="shopguide"}以下是部分常用功能的链接，您关闭本页面后，依然可以在左侧或顶部菜单中找到{/t}</div>
					</div>
					<ul class="complete-bottom">
						<a class="complete-li" href="{RC_Uri::url('theme/admin_template/init')}"><img src="{$app_url}/theme.png">{t domain="shopguide"}主题选择{/t}</a>
						<a class="complete-li" href="{RC_Uri::url('setting/shop_config/init')}&code=shop_info"><img src="{$app_url}/store-setting.png">{t domain="shopguide"}商店设置{/t}</a>
						<a class="complete-li" href="{RC_Uri::url('mail/admin_mail_settings/init')}"><img src="{$app_url}/mail-setting.png">{t domain="shopguide"}邮件设置{/t}</a>
					
						<a class="complete-li" href="{RC_Uri::url('adsense/admin_cycleimage/init')}"><img src="{$app_url}/cycleimage.png">{t domain="shopguide"}轮播图{/t}</a>
						<a class="complete-li" href="{RC_Uri::url('adsense/admin_shortcut/init')}"><img src="{$app_url}/goods-type.png">{t domain="shopguide"}快捷菜单{/t}</a>
						<a class="complete-li" href="{RC_Uri::url('friendlink/admin/init')}"><img src="{$app_url}/friendlink.png">{t domain="shopguide"}友情链接{/t}</a>
					
						<a class="complete-li" href="{RC_Uri::url('platform/admin/init')}"><img src="{$app_url}/wechat-platform.png">{t domain="shopguide"}公众号管理{/t}</a>
                        <a class="complete-li" href="{RC_Uri::url('weapp/admin/init')}"><img src="{$app_url}/weapp.png">{t domain="shopguide"}小程序管理{/t}</a>
                        <a class="complete-li" href="{RC_Uri::url('setting/admin_region/init')}"><img src="{$app_url}/weapp.png">{t domain="shopguide"}地区管理{/t}</a>

						<a class="complete-li" href="{RC_Uri::url('withdraw/admin_plugin/init')}"><img src="{$app_url}/withdraw.png">{t domain="shopguide"}提现方式{/t}</a>
						<a class="complete-li" href="{RC_Uri::url('sms/admin_plugin/init')}"><img src="{$app_url}/sms.png">{t domain="shopguide"}短信渠道{/t}</a>
                        <a class="complete-li" href="{RC_Uri::url('cron/admin_plugin/init')}"><img src="{$app_url}/cron.png">{t domain="shopguide"}计划任务{/t}</a>
					</ul>
				</div>
			</div>
			<!-- {/if} -->
        </form>
    </div>
</div>
<!-- {/block} -->