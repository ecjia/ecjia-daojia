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
        					<label class="control-label">{lang key='store::store.store_title_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="merchants_name" type="text" value="{$store.merchants_name}" />
        					</div>
        				</div>
        			    <div class="control-group formSep" >
        					<label class="control-label">{lang key='store::store.store_cat_lable'}</label>
        					<div class="controls">
        						<select name="store_cat">
        							<option value="0">{lang key='store::store.select_plz'}</option>
        							<!-- {html_options options=$cat_list selected=$store.cat_id} -->
        						</select>
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.store_keywords_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="shop_keyword" type="text" value="{$store.shop_keyword}" />
        					</div>
        				</div>

        				<div class="control-group formSep">
        					<label class="control-label">联系手机：</label>
        					<div class="controls">
        						<input class="span6" name="contact_mobile" type="text" value="{$store.contact_mobile}" />
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.email_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="email" type="text" value="{$store.email}" />
        					</div>
        				</div>
        				<!-- 地区 -->
        				<div class="control-group formSep">
        					<label class="control-label">选择地区：</label>
        					<div class="controls choose_list">
        						<select class="region-summary-provinces w120" name="province" id="selProvinces" data-url="{url path='store/admin_preaudit/get_region'}" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities" >
        							<option value='0'>{lang key='system::system.select_please'}</option>
        							<!-- {foreach from=$province item=region} -->
        							<option value="{$region.region_id}" {if $region.region_id eq $store.province}selected{/if}>{$region.region_name}</option>
        							<!-- {/foreach} -->
        						</select>
        						<select class="region-summary-cities w120" name="city" id="selCities" data-url="{url path='store/admin_preaudit/get_region'}" data-toggle="regionSummary" data-type="3" data-target="region-summary-district">
        							<option value='0'>{lang key='system::system.select_please'}</option>
        							<!-- {foreach from=$city item=region} -->
        							<option value="{$region.region_id}" {if $region.region_id eq $store.city}selected{/if}>{$region.region_name}</option>
        							<!-- {/foreach} -->
        						</select>
        						<select class="region-summary-district w120" name="district" id="seldistrict" >
        							<option value='0'>{lang key='system::system.select_please'}</option>
        							<!-- {foreach from=$district item=region} -->
        							<option value="{$region.region_id}" {if $region.region_id eq $store.district}selected{/if}>{$region.region_name}</option>
        							<!-- {/foreach} -->
        						</select>
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.address_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="address" type="text" value="{$store.address}" />
                                <div class="input-must">
                                    <button class="btn btn-info small-btn" data-toggle="get-gohash" data-url="{url path='store/admin/getgeohash'}">获取精准坐标</button>
                                </div>
        					</div>
        				</div>

        				<div class="control-group formSep ">
        					<label class="control-label">店铺精确位置：</label>
        					{if !$store.latitude || !$store.longitude}
        					<div class="controls">请先输入地址，然后点击“获取精准坐标”按钮</div>
        					{/if}
        					<div class="controls" style="overflow:hidden;">
        						<div class="span6" id="allmap" style="height:320px;"></div>
        					</div>
                            <div class="m_t30 controls help-block">点击选择店铺精确位置，双击放大地图，拖动查看地图其他区域</div>
        				</div>


        				<div class="control-group formSep">
        					<label class="control-label">经纬度：</label>
                            <div class="controls">
                                <div class="l_h30 long f_l"> <input type="text" name="longitude" readonly="true" value="{$store.longitude}"></div>
            					<div class="l_h30 latd f_l m_l10"><input type="text" name="latitude" readonly="true" value="{$store.latitude}"></div>
                            </div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">店铺模式：</label>
        					<div class="controls chk_radio">
								<label class="ecjiafd-iblock"><div class="uni-radio"><input name="manage_mode" type="radio" value="self" {if  $store.manage_mode eq 'self'}checked="checked" {/if}/></div><span>自营</span></label>
								<label class="ecjiafd-iblock"><div class="uni-radio"><input name="manage_mode" type="radio" value="join" {if  $store.manage_mode eq 'join'}checked="checked" {/if}/></div><span>入驻</span></label>
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">商品审核：</label>
        					<div class="controls chk_radio">
        					    <label class="ecjiafd-iblock"><div class="uni-radio"><input name="shop_review_goods" type="radio" value="0" {if  $store.shop_review_goods eq '' || $store.shop_review_goods eq 0 }checked="checked" {/if}/></div><span>关闭</span></label>
								<label class="ecjiafd-iblock"><div class="uni-radio"><input name="shop_review_goods" type="radio" value="1" {if  $store.shop_review_goods eq '1'}checked="checked" {/if}/></div><span>开启</span></label>
        					</div>
        					<div class="controls help-block">当商店设置中商品审核关闭时，对单个店铺设置失效。</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">店铺开关：</label>
        					<div class="controls chk_radio">
        					    <label class="ecjiafd-iblock"><div class="uni-radio"><input name="shop_close" type="radio" value="0" {if  $store.shop_close eq 0}checked="checked" {/if}/></div><span>开</span></label>
								<label class="ecjiafd-iblock"><div class="uni-radio"><input name="shop_close" type="radio" value="1" {if  $store.shop_close eq 1}checked="checked" {/if}/></div><span>关</span></label>
        					</div>
        					<div class="controls help-block">当商店设置中开启“商家强制认证”后，未认证通过的商家不能开店和显示</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">到期时间：</label>
        					<div class="controls chk_radio">
        					    <input class="date" name="expired_time" type="text" placeholder="" value="{$store.expired_time}">
        					</div>
        				</div>

        				{else if $step eq 'identity'}
        				{if $store.validate_type eq 1}
        				<div class="control-group formSep" >
        					<label class="control-label">{lang key='store::store.validate_type'}</label>
        					<div class="controls l_h30">
        						<span class="span6" name="validate_type" value="{$store.validate_type}">{lang key='store::store.personal'}</span>
        						<input type="hidden"  name="validate_type" value="{$store.validate_type}" />
        					</div>
        				</div>

        				<div class="control-group formSep">
        					<label class="control-label">负责人：</label>
        					<div class="controls">
        						<input class="span6" name="responsible_person" type="text" value="{$store.responsible_person}" />
        					</div>
        				</div>

        				<div class="control-group formSep" >
        					<label class="control-label">{lang key='store::store.identity_type_lable'}</label>
        					<div class="controls">
        						<select name="identity_type">
        							<option value="0">{lang key='store::store.select_plz'}</option>
        							<!-- {html_options options=$certificates_list selected=$store.identity_type} -->
        						</select>
        					</div>
        				</div>

        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.identity_number_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="identity_number" type="text" value="{$store.identity_number}" />
        					</div>
        				</div>
        				{elseif $store.validate_type eq 2}
        				<div class="control-group formSep" >
        					<label class="control-label">{lang key='store::store.validate_type'}</label>
        					<div class="controls l_h30">
        						<span class="span6 " name="validate_type" value="{$store.validate_type}">{lang key='store::store.company'}</span>
        						<input type="hidden"  name="validate_type" value="{$store.valtidate_type}" />
        					</div>
        				</div>

        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.companyname_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="company_name" type="text" value="{$store.company_name}" />
        					</div>
        				</div>

        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.person_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="responsible_person" type="text" value="{$store.responsible_person}" />
        					</div>
        				</div>

        				<div class="control-group formSep" >
        					<label class="control-label">{lang key='store::store.identity_type_lable'}</label>
        					<div class="controls">
        						<select name="identity_type">
        							<option value="0">{lang key='store::store.select_plz'}</option>
        							<!-- {html_options options=$certificates_list selected=$store.identity_type} -->
        						</select>
        					</div>
        				</div>

        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.identity_number_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="identity_number" type="text" value="{$store.identity_number}" />
        					</div>
        				</div>
                        <div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.business_licence_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="business_licence" type="text" value="{$store.business_licence}" />
        					</div>
        				</div>

        				{/if}

        				{else if $step eq 'bank'}
        				<!-- 银行 -->
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.bank_name_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="bank_name" type="text" value="{$store.bank_name}" />
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.bank_account_number_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="bank_account_number" type="text" value="{$store.bank_account_number}" />
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.bank_account_name_label'}</label>
        					<div class="controls">
        						<input class="span6" name="bank_account_name" type="text" value="{$store.bank_account_name}" />
        					</div>
        				</div>
                        <div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.bank_branch_name_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="bank_branch_name" type="text" value="{$store.bank_branch_name}" />
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.bank_address_lable'}</label>
        					<div class="controls">
        						<input class="span6" name="bank_address" type="text" value="{$store.bank_address}" />
        					</div>
        				</div>
        				{else if $step eq 'pic'}

        				<div class="control-group formSep">
    						<label class="control-label">{lang key='store::store.identity_pic_front_lable'}</label>
    						<div class="controls">
    							<div class="fileupload fileupload-new" data-provides="fileupload">
    							    {if $store.identity_pic_front neq ''}
    								<img class="w120 h120"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$store.identity_pic_front}"><br><br>
    								{lang key='store::store.file_address'}{$store.identity_pic_front}<br><br>
    								{/if}
    								<input type="hidden" name="{$var.code}" />
    								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
    								<span class="btn btn-file">
    								    {if $store.identity_pic_front neq ''}
    									<span class="fileupload-new">{lang key='store::store.change_image'}</span>
    									{else}
    									<span class="fileupload-new">{lang key='store::store.browse'}</span>
    									{/if}
    									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
    									<input type='file' name='two' size="35" />
    								</span>
    								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
    								<input type="hidden" name="{$var.code}" />
    								<input type="hidden" name="{$store.identity_pic_front}" />
    								<input name="identity_pic_front" value="{$store.identity_pic_front}" class="hide">
    							</div>
    						</div>
        				</div>

        				<div class="control-group formSep">
    						<label class="control-label">{lang key='store::store.identity_pic_back_lable'}</label>
    						<div class="controls">
    							<div class="fileupload fileupload-new" data-provides="fileupload">
    							    {if $store.identity_pic_back neq ''}
    								<img class="w120 h120"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$store.identity_pic_back}"><br><br>
    								{lang key='store::store.file_address'}{$store.identity_pic_back}<br><br>
    								{/if}
    								<input type="hidden" name="{$var.code}" />
    								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
    								<span class="btn btn-file">
    								    {if $store.identity_pic_back neq ''}
    									<span class="fileupload-new">{lang key='store::store.change_image'}</span>
    									{else}
    									<span class="fileupload-new">{lang key='store::store.browse'}</span>
    									{/if}
    									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
    									<input type='file' name='three' size="35" />
    								</span>
    								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
    								<input type="hidden" name="{$var.code}" />
    								<input type="hidden" name="{$store.identity_pic_back}" />
    								<input name="identity_pic_back" value="{$store.identity_pic_back}" class="hide">
    							</div>
    						</div>
        				</div>

        				<div class="control-group formSep">
    						<label class="control-label">{lang key='store::store.personhand_identity_pic_lable'}</label>
    						<div class="controls">
    							<div class="fileupload fileupload-new" data-provides="fileupload">
    								{if $store.personhand_identity_pic neq ''}
    								<img class="w120 h120"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$store.personhand_identity_pic}"><br><br>
    								{lang key='store::store.file_address'}{$store.personhand_identity_pic}<br><br>
    								{/if}
    								<input type="hidden" name="{$var.code}" />
    								<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
    								<span class="btn btn-file">
    									{if $store.personhand_identity_pic neq ''}
    									<span class="fileupload-new">{lang key='store::store.change_image'}</span>
    									{else}
    									<span class="fileupload-new">{lang key='store::store.browse'}</span>
    									{/if}
    									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
    									<input type='file' name='four' size="35" />
    								</span>
    								<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
    								<input type="hidden" name="{$var.code}" />
    								<input type="hidden" name="{$store.personhand_identity_pic}" />
    								<input name="personhand_identity_pic" value="{$store.personhand_identity_pic}" class="hide">
    							</div>
    						</div>
        				</div>

        				{if $store.validate_type eq 2}
        				<div class="control-group formSep">
        					<label class="control-label">{lang key='store::store.business_licence_pic_lable'}</label>
        					<div class="controls">
        						<div class="fileupload fileupload-new" data-provides="fileupload">
        							{if $store.business_licence_pic neq ''}
        							<img class="w120 h120"  class="img-polaroid" src="{RC_Upload::upload_url()}/{$store.business_licence_pic}"><br><br>
        							{lang key='store::store.file_address'}{$store.business_licence_pic}<br><br>
        							{/if}
        							<input type="hidden" name="{$var.code}" />
        							<div class="fileupload-preview fileupload-exists thumbnail" style="width: 50px; height: 50px; line-height: 50px;"></div>
        								<span class="btn btn-file">
        								    {if $store.business_licence_pic neq ''}
        									<span class="fileupload-new">{lang key='store::store.change_image'}</span>
        									{else}
        									<span class="fileupload-new">{lang key='store::store.browse'}</span>
        									{/if}
        									<span class="fileupload-exists">{lang key='store::store.modify'}</span>
        									<input type='file' name='one' size="35" />
        								</span>
        							<a class="btn fileupload-exists" data-dismiss="fileupload" href="#">{lang key='system::system.drop'}</a>
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
        						<button class="btn btn-gebo" type="submit">{lang key='store::store.sub_update'}</button>
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
