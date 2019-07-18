<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.store_edit.init();
</script>
<script type="text/javascript">
	//腾讯地图
	var map, markersArray = [];
    var lat = '{$store.latitude}';
    var lng = '{$store.longitude}';
	var latLng = new qq.maps.LatLng(lat, lng);
	var map = new qq.maps.Map(document.getElementById("allmap"),{
	    center: latLng,
	    zoom: 16
	});
	setTimeout(function(){
	    var marker = new qq.maps.Marker({
	        position: latLng, 
	        map: map
	      });
	    markersArray.push(marker);
	}, 500);
	//添加监听事件 获取鼠标单击事件
	qq.maps.event.addListener(map, 'click', function(event) {
	    if (markersArray) {
	        for (i in markersArray) {
	            markersArray[i].setMap(null);
	        }
	        markersArray.length = 0;
	    }
	    $('input[name="longitude"]').val(event.latLng.lng)
	    $('input[name="latitude"]').val(event.latLng.lat)
	       var marker = new qq.maps.Marker({
	        position: event.latLng, 
	        map: map
	      });
	    markersArray.push(marker);    
	});
</script>
<!-- {/block} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span12">
		<div class="tabbable tabs-left">

			<ul class="nav nav-tabs tab_merchants_nav">
                <!-- {foreach from=$menu item=val} -->
                <li {if $val.active}class="active"{/if}><a href="{$val.url}" {if $val.active}data-toggle="tab"{/if}>{$val.menu}</a></li>
                <!-- {/foreach} -->
            </ul>

			<div class="tab-content tab_merchants">
				<div class="tab-pane active " style="min-height:300px;">
				<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
        			<fieldset>
        			{if $step eq 'base'}
        			    <div class="control-group formSep">
        					<label class="control-label">{t domain="store"}店铺名称：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="merchants_name" type="text" value="{$store.merchants_name}" />
        					</div>
        				</div>
        			    <div class="control-group formSep" >
        					<label class="control-label">{t domain="store"}商家分类：{/t}</label>
        					<div class="controls">
        						<select name="store_cat">
        							<option value="0">{t domain="store"}请选择……{/t}</option>
        							<!-- {html_options options=$cat_list selected=$store.cat_id} -->
        						</select>
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}店铺关键词：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="shop_keyword" type="text" value="{$store.shop_keyword}" />
        					</div>
        				</div>

        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}联系手机：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="contact_mobile" type="text" value="{$store.contact_mobile}" />
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}电子邮箱：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="email" type="text" value="{$store.email}" />
        					</div>
        				</div>
        				<!-- 地区 -->
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}选择地区：{/t}</label>
        					<div class="controls choose_list">
        						<select class="region-summary-provinces w120" name="province" id="selProvinces" data-url="{url path='setting/region/init'}" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities" >
        							<option value='0'>{t domain="store"}请选择...{/t}</option>
        							<!-- {foreach from=$province item=region} -->
        							<option value="{$region.region_id}" {if $region.region_id eq $store.province}selected{/if}>{$region.region_name}</option>
        							<!-- {/foreach} -->
        						</select>
        						<select class="region-summary-cities w120" name="city" id="selCities" data-url="{url path='setting/region/init'}" data-toggle="regionSummary" data-type="3" data-target="region-summary-district">
        							<option value='0'>{t domain="store"}请选择...{/t}</option>
        							<!-- {foreach from=$city item=region} -->
        							<option value="{$region.region_id}" {if $region.region_id eq $store.city}selected{/if}>{$region.region_name}</option>
        							<!-- {/foreach} -->
        						</select>
        						<select class="region-summary-district w120" name="district" id="seldistrict" data-url="{url path='setting/region/init'}" data-toggle="regionSummary" data-type="4" data-target="region-summary-street">
        							<option value='0'>{t domain="store"}请选择...{/t}</option>
        							<!-- {foreach from=$district item=region} -->
        							<option value="{$region.region_id}" {if $region.region_id eq $store.district}selected{/if}>{$region.region_name}</option>
        							<!-- {/foreach} -->
        						</select>
        						<select class="region-summary-street w120" name="street" id="selstreet" >
        							<option value='0'>{t domain="store"}请选择...{/t}</option>
        							<!-- {foreach from=$street item=region} -->
        							<option value="{$region.region_id}" {if $region.region_id eq $store.street}selected{/if}>{$region.region_name}</option>
        							<!-- {/foreach} -->
        						</select>
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}通讯地址：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="address" type="text" value="{$store.address}" />
                                <div class="input-must">
                                    <button class="btn btn-info small-btn" data-toggle="get-gohash" data-url="{url path='store/admin/getgeohash'}">{t domain="store"}获取精准坐标{/t}</button>
                                </div>
        					</div>
        				</div>

        				<div class="control-group formSep ">
        					<label class="control-label">{t domain="store"}店铺精确位置：{/t}</label>
        					{if !$store.latitude || !$store.longitude}
        					<div class="controls">{t domain="store"}请先输入地址，然后点击“获取精准坐标”按钮{/t}</div>
        					{/if}
        					<div class="controls" style="overflow:hidden;">
        						<div class="span6" id="allmap" style="height:320px;"></div>
        					</div>
                            <div class="m_t30 controls help-block">{t domain="store"}点击选择店铺精确位置，双击放大地图，拖动查看地图其他区域{/t}</div>
        				</div>


        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}经纬度：{/t}</label>
                            <div class="controls">
                                <div class="l_h30 long f_l"> <input type="text" name="longitude" readonly="true" value="{$store.longitude}"></div>
            					<div class="l_h30 latd f_l m_l10"><input type="text" name="latitude" readonly="true" value="{$store.latitude}"></div>
                            </div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}店铺模式：{/t}</label>
        					<div class="controls chk_radio">
								<label class="ecjiafd-iblock"><div class="uni-radio"><input name="manage_mode" type="radio" value="self" {if  $store.manage_mode eq 'self'}checked="checked" {/if}/></div><span>{t domain="store"}自营{/t}</span></label>
								<label class="ecjiafd-iblock"><div class="uni-radio"><input name="manage_mode" type="radio" value="join" {if  $store.manage_mode eq 'join'}checked="checked" {/if}/></div><span>{t domain="store"}入驻{/t}</span></label>
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}商品审核：{/t}</label>
        					<div class="controls chk_radio">
        					    <label class="ecjiafd-iblock"><div class="uni-radio"><input name="shop_review_goods" type="radio" value="0" {if  $store.shop_review_goods eq '' || $store.shop_review_goods eq 0 }checked="checked" {/if}/></div><span>{t domain="store"}关闭{/t}</span></label>
								<label class="ecjiafd-iblock"><div class="uni-radio"><input name="shop_review_goods" type="radio" value="1" {if  $store.shop_review_goods eq '1'}checked="checked" {/if}/></div><span>{t domain="store"}开启{/t}</span></label>
        					</div>
        					<div class="controls help-block">{t domain="store"}当商店设置中商品审核关闭时，对单个店铺设置失效。自营店铺无需审核，此开关无效。{/t}</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}店铺开关：{/t}</label>
        					<div class="controls chk_radio">
        					    <label class="ecjiafd-iblock"><div class="uni-radio"><input name="shop_close" type="radio" value="0" {if  $store.shop_close eq 0}checked="checked" {/if}/></div><span>{t domain="store"}开{/t}</span></label>
								<label class="ecjiafd-iblock"><div class="uni-radio"><input name="shop_close" type="radio" value="1" {if  $store.shop_close eq 1}checked="checked" {/if}/></div><span>{t domain="store"}关{/t}</span></label>
        					</div>
        					<div class="controls help-block">{t domain="store"}当商店设置中开启“商家强制认证”后，未认证通过的商家不能开店和显示{/t}</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}到期时间：{/t}</label>
        					<div class="controls chk_radio">
        					    <input class="date" name="expired_time" type="text" placeholder="" value="{$store.expired_time}">
        					</div>
        				</div>

        				{else if $step eq 'identity'}
        				{if $store.validate_type eq 1}
        				<div class="control-group formSep" >
        					<label class="control-label">{t domain="store"}入驻类型：{/t}</label>
        					<div class="controls l_h30">
        						<span class="span6" name="validate_type" value="{$store.validate_type}">个人</span>
        						<input type="hidden"  name="validate_type" value="{$store.validate_type}" />
        					</div>
        				</div>

        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}负责人：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="responsible_person" type="text" value="{$store.responsible_person}" />
        					</div>
        				</div>

        				<div class="control-group formSep" >
        					<label class="control-label">{t domain="store"}证件类型：{/t}</label>
        					<div class="controls">
        						<select name="identity_type">
        							<option value="0">{t domain="store"}请选择……{/t}</option>
        							<!-- {html_options options=$certificates_list selected=$store.identity_type} -->
        						</select>
        					</div>
        				</div>

        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}证件号码：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="identity_number" type="text" value="{$store.identity_number}" />
        					</div>
        				</div>
        				{elseif $store.validate_type eq 2}
        				<div class="control-group formSep" >
        					<label class="control-label">{t domain="store"}入驻类型：{/t}</label>
        					<div class="controls l_h30">
        						<span class="span6 " name="validate_type" value="{$store.validate_type}">{t domain="store"}企业{/t}</span>
        						<input type="hidden"  name="validate_type" value="{$store.valtidate_type}" />
        					</div>
        				</div>

        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}公司名称：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="company_name" type="text" value="{$store.company_name}" />
        					</div>
        				</div>

        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}负责人：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="responsible_person" type="text" value="{$store.responsible_person}" />
        					</div>
        				</div>

        				<div class="control-group formSep" >
        					<label class="control-label">{t domain="store"}证件类型：{/t}</label>
        					<div class="controls">
        						<select name="identity_type">
        							<option value="0">{t domain="store"}请选择……{/t}</option>
        							<!-- {html_options options=$certificates_list selected=$store.identity_type} -->
        						</select>
        					</div>
        				</div>

        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}证件号码：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="identity_number" type="text" value="{$store.identity_number}" />
        					</div>
        				</div>
                        <div class="control-group formSep">
        					<label class="control-label">{t domain="store"}营业执照注册号：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="business_licence" type="text" value="{$store.business_licence}" />
        					</div>
        				</div>

        				{/if}

        				{else if $step eq 'bank'}
        				<!-- 银行 -->
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}收款银行：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="bank_name" type="text" value="{$store.bank_name}" />
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}银行账号：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="bank_account_number" type="text" value="{$store.bank_account_number}" />
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}账户名称：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="bank_account_name" type="text" value="{$store.bank_account_name}" />
        					</div>
        				</div>
                        <div class="control-group formSep">
        					<label class="control-label">{t domain="store"}开户银行支行名称：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="bank_branch_name" type="text" value="{$store.bank_branch_name}" />
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}开户银行支行地址：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="bank_address" type="text" value="{$store.bank_address}" />
        					</div>
        				</div>
        				{else if $step eq 'pic'}

        				<div class="control-group formSep">
    						<label class="control-label">{t domain="store"}证件正面：{/t}</label>
    						<div class="controls">
    							<div class="fileupload fileupload-new" data-provides="fileupload">
    							    {if $store.identity_pic_front neq ''}
    								<img class="w120 h120"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$store.identity_pic_front}"><br><br>
    									{t domain="store"}文件地址：{/t}{$store.identity_pic_front}<br><br>
    								{/if}
    								<input type="hidden" name="{$var.code}" />
    								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
    								<span class="btn btn-file">
    								    {if $store.identity_pic_front neq ''}
    									<span class="fileupload-new">{t domain="store"}更换图片{/t}</span>
    									{else}
    									<span class="fileupload-new">{t domain="store"}预览{/t}</span>
    									{/if}
    									<span class="fileupload-exists">{t domain="store"}修改{/t}</span>
    									<input type='file' name='two' size="35" />
    								</span>
    								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{t domain="store"}删除{/t}</a>
    								<input type="hidden" name="{$var.code}" />
    								<input type="hidden" name="{$store.identity_pic_front}" />
    								<input name="identity_pic_front" value="{$store.identity_pic_front}" class="hide">
    							</div>
    						</div>
        				</div>

        				<div class="control-group formSep">
    						<label class="control-label">{t domain="store"}证件反面：{/t}</label>
    						<div class="controls">
    							<div class="fileupload fileupload-new" data-provides="fileupload">
    							    {if $store.identity_pic_back neq ''}
    								<img class="w120 h120"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$store.identity_pic_back}"><br><br>
    									{t domain="store"}文件地址：{/t}{$store.identity_pic_back}<br><br>
    								{/if}
    								<input type="hidden" name="{$var.code}" />
    								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
    								<span class="btn btn-file">
    								    {if $store.identity_pic_back neq ''}
    									<span class="fileupload-new">{t domain="store"}更换图片{/t}</span>
    									{else}
    									<span class="fileupload-new">{t domain="store"}预览{/t}</span>
    									{/if}
    									<span class="fileupload-exists">{t domain="store"}修改{/t}</span>
    									<input type='file' name='three' size="35" />
    								</span>
    								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{t domain="store"}删除{/t}</a>
    								<input type="hidden" name="{$var.code}" />
    								<input type="hidden" name="{$store.identity_pic_back}" />
    								<input name="identity_pic_back" value="{$store.identity_pic_back}" class="hide">
    							</div>
    						</div>
        				</div>

        				<div class="control-group formSep">
    						<label class="control-label">{t domain="store"}手持证件：{/t}</label>
    						<div class="controls">
    							<div class="fileupload fileupload-new" data-provides="fileupload">
    								{if $store.personhand_identity_pic neq ''}
    								<img class="w120 h120"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$store.personhand_identity_pic}"><br><br>
    									{t domain="store"}文件地址：{/t}{$store.personhand_identity_pic}<br><br>
    								{/if}
    								<input type="hidden" name="{$var.code}" />
    								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
    								<span class="btn btn-file">
    									{if $store.personhand_identity_pic neq ''}
    									<span class="fileupload-new">{t domain="store"}更换图片{/t}</span>
    									{else}
    									<span class="fileupload-new">{t domain="store"}预览{/t}</span>
    									{/if}
    									<span class="fileupload-exists">{t domain="store"}修改{/t}</span>
    									<input type='file' name='four' size="35" />
    								</span>
    								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{t domain="store"}删除{/t}</a>
    								<input type="hidden" name="{$var.code}" />
    								<input type="hidden" name="{$store.personhand_identity_pic}" />
    								<input name="personhand_identity_pic" value="{$store.personhand_identity_pic}" class="hide">
    							</div>
    						</div>
        				</div>

        				{if $store.validate_type eq 2}
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}营业执照电子版：{/t}</label>
        					<div class="controls">
        						<div class="fileupload fileupload-new" data-provides="fileupload">
        							{if $store.business_licence_pic neq ''}
        							<img class="w120 h120"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$store.business_licence_pic}"><br><br>
        								{t domain="store"}文件地址：{/t}{$store.business_licence_pic}<br><br>
        							{/if}
        							<input type="hidden" name="{$var.code}" />
        							<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
        								<span class="btn btn-file">
        								    {if $store.business_licence_pic neq ''}
        									<span class="fileupload-new">{t domain="store"}更换图片{/t}</span>
        									{else}
        									<span class="fileupload-new">{t domain="store"}预览{/t}</span>
        									{/if}
        									<span class="fileupload-exists">{t domain="store"}修改{/t}</span>
        									<input type='file' name='one' size="35" />
        								</span>
        							<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{t domain="store"}删除{/t}</a>
        							<input type="hidden" name="{$var.code}" />
        							<input type="hidden" name="{$store.business_licence_pic}" />
        							<input name="business_licence_pic" value="{$store.business_licence_pic}" class="hide">
        						</div>
        					</div>
        				</div>
                        {/if}
                        
        				<!-- <div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.apply_time_lable'}</label>
        				 	<div class="controls l_h30">
        						{$store.apply_time}
        					</div>
        				</div> -->

        				{/if}

        				<div class="control-group">
        					<div class="controls">
        						<input type="hidden"  name="store_id" value="{$store.store_id}" />
        						<input type="hidden"  name="step" value="{$step}" />
        						<button class="btn btn-gebo" type="submit">{t domain="store"}更新{/t}</button>
        					</div>
        				</div>
        			</fieldset>
        		</form>
			    </div>
			</div>
		</div>
	</div>
</div>

<!-- {/block} -->
