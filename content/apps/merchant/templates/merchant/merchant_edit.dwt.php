<?php defined('IN_ECJIA') or exit('No permission resources.');?> 
<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.merchant.merchant_info.init();
</script>
<script type="text/javascript">
	//腾讯地图
	var map, markersArray = [];
	var step='{$step}';
    var lat = '{$data.latitude}';
    var lng = '{$data.longitude}';
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
	if (step == 1) {
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
	}
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->

<!-- {if $step eq 2} -->
<div class="row">
    <div class="col-lg-12">
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
            入驻信息已经提交，不可更改，商家正在进行审核，请等待3-5工作日查看审核状态。
        </div>
    </div>
</div>
<!-- {/if} -->

<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-reply"></i> {$action_link.text}
		</a>
		{/if}
  	</div>
  	<div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="bar">
            <div class="step-bar">
                <div class="step_{$step}"></div>
            </div>
            <ul class="step">
                <li>
                    <span>1</span>
                    <p>提交申请</p>
                </li>
                <li>
                    <span>2</span>
                    <p>等待审核</p>
                </li>
                <li>
                    <span>3</span>
                    <p>审核状态</p>
                </li>
            </ul>
        </div>
        <section class="panel">
            <div class="panel-body {if $step eq 2}disable{/if}">
                <div class="form">
                    <form class="cmxform form-horizontal" name="theForm" action="{$form_action}"  method="post" enctype="multipart/form-data" >

                        <div class="form-group">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.merchants_name'}：</label>
                            <div class="col-lg-6">
                                <input class="form-control required" name="merchants_name" type="text" value="{$data.merchants_name}" />
                            </div>
                            <span class="input-must">
                                <span class="input-must">*</span>
                            </span>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.merchant_cat'}：</label>
                            <div class="col-lg-2">
                                <select class="form-control required" name="cat_id">
                                    <option value="0">请选择...</option>
                                    <!-- {foreach from=$cat_info item=cat} -->
                                        <option value="{$cat.cat_id}" {if $data.cat_id eq $cat.cat_id}selected{/if}>{$cat.cat_name}</option>
                                    <!-- {/foreach} -->
                                </select>
                            </div>
                            <span class="input-must">
                                <span class="input-must">*</span>
                            </span>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.shop_keyword'}：</label>
                            <div class="col-lg-6">
                                <textarea class="form-control required" name="shop_keyword" >{$data.shop_keyword}</textarea>
                                <div class="help-block">精确填写店铺关键字有利于店铺搜索</div>
                            </div>
                            <span class="input-must">
                                <span class="input-must">*</span>
                            </span>
                        </div>

                        <div class="form-group form-address">
                            <label class="control-label col-lg-2">{t}省份：{/t}</label>
                            <div class="col-lg-2">
                                <select class="form-control required" name="province" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities" data-url="{url path='merchant/mh_franchisee/get_region'}">
                                    <option value='0'>{t}请选择...{/t}</option>
                                    <!-- {foreach from=$province item=region} -->
                                        <option value="{$region.region_id}" {if $region.region_id eq $data.province}selected{/if}>{$region.region_name}</option>
                                    <!-- {/foreach} -->
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <select class="form-control required region-summary-cities" data-target="region-summary-distric" name="city" data-type="3" data-toggle="regionSummary">
                                    <option value='0'>{t}请选择...{/t}</option>
                                    <!-- {foreach from=$city item=region} -->
                                    <option value="{$region.region_id}" {if $region.region_id eq $data.city}selected{/if}>{$region.region_name}</option>
                                    <!-- {/foreach} -->
                                </select>
                            </div>

                            <div class="col-lg-2">
                                <select class="form-control required region-summary-distric" name="district" >
                                    <option value='0'>{t}请选择...{/t}</option>
                                    <!-- {foreach from=$district item=region} -->
                                    <option value="{$region.region_id}" {if $region.region_id eq $data.district}selected{/if}>{$region.region_name}</option>
                                    <!-- {/foreach} -->
                                </select>
                            </div>
                            <span class="input-must">
                                <span class="input-must">*</span>
                            </span>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.address'}：</label>
                            <div class="col-lg-6">
                                <input class="form-control required" type="text" name="address" value="{$data.address}">
                                <div class="help-block">点击获取精确位置显示地图坐标</div>
                            </div>
                            <span class="input-must">
                                <span class="input-must">*</span>
                            </span>
                            <div class="input-must">
                                <button class="btn btn-info small-btn" data-toggle="get-gohash" data-url="{url path='merchant/mh_franchisee/getgeohash'}">获取精准坐标</button>
                            </div>
                        </div>

                        <div class="form-group location-address {if !$data.longitude || !$data.latitude}hide{/if}">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.merchant_addres'}：</label>
                            <div class="col-lg-6">
                                <div id="allmap" style="height:320px;"></div>
                                <div class="help-block">点击选择店铺精确位置，双击放大地图，拖动查看地图其他区域</div>
                                <div class="help-block">
                                    <label class="control-label f_l">经纬度：</label>
                                    <span class="col-lg-4"><input class="form-control required" type="text" readonly="true" name="longitude" value="{$data.longitude}"></span>
                                    <span class="col-lg-4"><input class="form-control required" type="text" readonly="true" name="latitude" value="{$data.latitude}"></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.responsible_person'}：</label>
                            <div class="col-lg-6">
                                <input class="form-control required" name="responsible_person" type="text" value="{$data.responsible_person}"/>
                                <div class="help-block">必须和证件上名称保持一致</div>
                            </div>
                            <span class="input-must">
                                <span class="input-must">*</span>
                            </span>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.email'}：</label>
                            <div class="col-lg-6">
                                <input class="form-control required email" name="email" type="text" value="{$data.email}"/>
                            </div>
                            <span class="input-must">
                                <span class="input-must">*</span>
                            </span>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.contact_mobile'}：</label>
                            <div class="col-lg-6">
                                <input class="form-control required" name="contact_mobile" type="text" value="{$data.contact_mobile}"/>
                            </div>
                            <span class="input-must">
                                <span class="input-must">*</span>
                            </span>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.identity_type'}：</label>
                            <div class="col-lg-2">
                                <select class="form-control required" name="identity_type">
                                    <option value="1" {if $data.identity_type eq 1}selected="selected"{/if}>身份证</option>
                                    <option value="2" {if $data.identity_type eq 2}selected="selected"{/if}>护照</option>
                                    <option value="3" {if $data.identity_type eq 3}selected="selected"{/if}>港澳身份证</option>
                                </select>
                            </div>
                            <span class="input-must">
                                <span class="input-must">*</span>
                            </span>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.identity_number'}：</label>
                            <div class="col-lg-6">
                                <input class="form-control required" type="type" name="identity_number" value="{$data.identity_number}">
                            </div>
                            <span class="input-must">
                                <span class="input-must">*</span>
                            </span>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.identity_pic_front'}：</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-{if $data.identity_pic_front}exists{else}new{/if}" data-provides="fileupload">
                                    {if $data.identity_pic_front}
                                    <div class="fileupload-{if $data.identity_pic_front}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                                        <img src="{$data.identity_pic_front}" alt="证件正面" style="width:50px; height:50px;"/>
                                    </div>
                                    {/if}
                                    <div class="fileupload-preview fileupload-{if $data.identity_pic_front}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 浏览</span>
                                        <span class="fileupload-exists"> 修改</span>
                                        <input type="file" class="default" name="identity_pic_front" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" data-dismiss="fileupload">删除</a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.identity_pic_back'}：</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-{if $data.identity_pic_back}exists{else}new{/if}" data-provides="fileupload">
                                    {if $data.identity_pic_back}
                                    <div class="fileupload-{if $data.identity_pic_back}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                                        <img src="{$data.identity_pic_back}" alt="证件反面" style="width:50px; height:50px;"/>
                                    </div>
                                    {/if}
                                    <div class="fileupload-preview fileupload-{if $data.identity_pic_back}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 浏览</span>
                                        <span class="fileupload-exists"> 修改</span>
                                        <input type="file" class="default" name="identity_pic_back" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" data-dismiss="fileupload">删除</a>
                                </div>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.personhand_identity_pic'}：</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-{if $data.personhand_identity_pic}exists{else}new{/if}" data-provides="fileupload">
                                    {if $data.personhand_identity_pic}
                                    <div class="fileupload-{if $data.personhand_identity_pic}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                                        <img src="{$data.personhand_identity_pic}" alt="手持证件拍照" style="width:50px; height:50px;"/>
                                    </div>
                                    {/if}
                                    <div class="fileupload-preview fileupload-{if $data.personhand_identity_pic}new{else}exists{/if} thumbnail" style="max-width: 60px;max-height: 60px;line-height: 10px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 浏览</span>
                                        <span class="fileupload-exists">修改</span>
                                        <input type="file" class="default" name="personhand_identity_pic" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" data-dismiss="fileupload">删除</a>
                                </div>
                            </div>
                        </div>

                        <!-- {if $data.validate_type eq 2} -->
                        <div class="form-group ">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.company_name'}：</label>
                            <div class="col-lg-6">
                                <input class="form-control required" name="company_name" type="text" value="{$data.company_name}" />
                            </div>
                            <span class="input-must">
                                <span class="input-must">*</span>
                            </span>
                        </div>

                        <div class="form-group identity_type">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.business_licence'}：</label>
                            <div class="col-lg-6">
                                <input class="form-control required" type="text" name="business_licence" value="{$data.business_licence}">
                            </div>
                            <span class="input-must">
                                <span class="input-must">*</span>
                            </span>
                        </div>

                        <div class="form-group identity_type">
                            <label class="control-label col-lg-2">{lang key='merchant::merchant.business_licence_pic'}：</label>
                            <div class="col-lg-6">
                                <div class="fileupload fileupload-{if $data.business_licence_pic}exists{else}new{/if}" data-provides="fileupload">
                                    {if $data.business_licence_pic}
                                    <div class="fileupload-{if $data.business_licence_pic}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                                        <img src="{$data.business_licence_pic}" alt="营业执照" style="width:50px; height:50px;"/>
                                    </div>
                                    {/if}
                                    <div class="fileupload-preview fileupload-{if $data.business_licence_pic}new{else}exists{/if} thumbnail" style="max-width: 60px; max-height: 60px; line-height: 20px;"></div>
                                    <span class="btn btn-primary btn-file btn-sm">
                                        <span class="fileupload-new"><i class="fa fa-paper-clip"></i> 浏览</span>
                                        <span class="fileupload-exists"> 修改</span>
                                        <input type="file" class="default" name="business_licence_pic" />
                                    </span>
                                    <a class="btn btn-danger btn-sm fileupload-exists" data-dismiss="fileupload">删除</a>
                                </div>
                            </div>
                        </div>
                        <!-- {/if} -->

                        <div class="form-group ">
                            <div class="col-lg-6 col-md-offset-2">
                                <!-- {if $step eq 1} --><input class="btn btn-info" type="submit" name="name" value="提交修改"> <!-- {/if} -->
                                <!-- {if $step eq 2} --><a class="btn btn-primary nodisabled" disabled="false" data-toggle="ajax_remove" href="{url path='merchant/mh_franchisee/delete'}">撤销修改申请</a> <!-- {/if} -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<!-- {/block} -->
