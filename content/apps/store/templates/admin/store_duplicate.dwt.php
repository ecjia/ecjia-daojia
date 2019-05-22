<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.store_edit.init();
</script>
<script type="text/javascript">
	//腾讯地图
	var map, markersArray = [];
	var latLng = new qq.maps.LatLng(31.22926, 121.40934);
	var map = new qq.maps.Map(document.getElementById("allmap"),{
	    center: latLng,
	    zoom: 16
	});
	$('input[name="longitude"]').val(121.40934);
    $('input[name="latitude"]').val(31.22926);
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
    <div class="alert alert-info">
        <a class="close" data-dismiss="alert">×</a>
        <strong>
            <p>{t domain="store"}复制店铺{/t}</p>
        </strong>
        <p>{t domain="store"}用于店铺开分店，重新上传产品、设置店铺相关信息又太过于麻烦，使用复制功能，可以轻松处理，一键克隆。{/t}</p>
    </div>
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

<!--                    <h3>入驻信息</h3><br>-->
				<form class="form-horizontal" id="form-privilege" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data" >
        			<fieldset>

        			    <div class="control-group formSep">
        					<label class="control-label">{t domain="store"}店铺名称：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="merchants_name" type="text" value="{$store.merchants_name}" />
        						<span class="input-must">*</span>
        					</div>
        				</div>
        			    <div class="control-group formSep" >
        					<label class="control-label">{t domain="store"}商家分类：{/t}</label>
        					<div class="controls">
        						<select name="store_cat">
        							<option value="0">{t domain="store"}请选择……{/t}</option>
                                    {html_options options=$cat_list selected=$store.cat_id}
        							<!-- {html_options options=$cat_list selected=$store.cat_id} -->
        						</select>
        						<span class="input-must">*</span>
        					</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}真实姓名：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="responsible_person" type="text" value="{$store.responsible_person}" />
        					</div>
        				</div>

        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}联系手机：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="contact_mobile" type="text" value="" />
        						<span class="input-must">*</span>
        					</div>
        					<div class="m_t30 controls help-block">{t domain="store"}号码不能与原店铺号码相同，请重新更换{/t}</div>
        				</div>
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}电子邮箱：{/t}</label>
        					<div class="controls">
        						<input class="span6" name="email" type="text" value="" />
        					</div>
                            <div class="m_t30 controls help-block">{t domain="store"}账号不能与原店铺相同，非必填项{/t}</div>
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
        						<span class="input-must">*</span>
                                <div class="input-must">
                                    <button class="btn btn-info small-btn" data-toggle="get-gohash" data-url="{url path='store/admin/getgeohash'}">{t domain="store"}获取精准坐标{/t}</button>
                                </div>
        					</div>
        				</div>

        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}店铺精确位置：{/t}</label>
        					<div class="controls" style="overflow:hidden;">
        						<div class="span6" id="allmap" style="height:320px;"></div>
        					</div>
                            <div class="m_t30 controls help-block">{t domain="store"}点击选择店铺精确位置，拖动查看地图其他区域{/t}</div>
        				</div>


        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}经纬度：{/t}</label>
                            <div class="controls">
                                <div class="l_h30 long f_l"> <input type="text" name="longitude" readonly="true" value="{$store.longitude}"></div>
            					<div class="l_h30 latd f_l m_l10"><input type="text" name="latitude" readonly="true" value="{$store.latitude}"></div>
            					<span class="input-must">*</span>
                            </div>
        				</div>

                        {if $store.manage_mode eq 'join'}
        				<div class="control-group formSep">
        					<label class="control-label">{t domain="store"}入驻类型：{/t}</label>
        					<div class="controls chk_radio">

        					    <label class="ecjiafd-iblock"><div class="uni-radio"><input name="validate_type" type="radio" value="1" checked="checked"/></div><span>{t domain="store"}个人{/t}</span></label>
								<label class="ecjiafd-iblock"><div class="uni-radio"><input name="validate_type" type="radio" value="2"/></div><span>{t domain="store"}企业{/t}</span></label>
        					</div>
        				</div>
                        {/if}


        				<div class="control-group">
        					<div class="controls">
        						<input type="hidden"  name="store_id" value="{$store.store_id}" />
        						<button class="btn btn-gebo" type="submit">{t domain="store"}下一步{/t}</button>
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
