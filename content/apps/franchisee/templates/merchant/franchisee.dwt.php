<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="meta"} -->
<title>
{if $type eq 'edit_apply'}{t domain="franchisee"}修改申请{/t}{else}{t domain="franchisee"}商家入驻{/t}{/if} - {ecjia::config('shop_name')}
</title>
<!-- {/block} -->

<!-- {block name="title"} -->
{if $type eq 'edit_apply'}{t domain="franchisee"}修改申请{/t}{else}{t domain="franchisee"}商家入驻{/t}{/if} - {ecjia::config('shop_name')}
<!-- {/block} -->

<!-- {block name="common_header"} -->
<!-- #BeginLibraryItem "/library/franchisee_nologin_header.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.merchant.franchisee.init();
</script>
<script type="text/javascript">
	//腾讯地图
	var map, markersArray = [];
	var step='{$step}';
    var lat = '{$data.latitude}';
    var lng = '{$data.longitude}';
	var latLng = new qq.maps.LatLng(lat, lng);
	if (lat != '' && lng != '') {
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
	}
</script>
<!-- {/block} -->

<!-- {block name="home-content"} -->
{if $browser_warning}
<div class="alert alert-warning">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<strong>{t domain="franchisee"}温馨提示：{/t}</strong>{$browser_warning}
</div>
{/if}

{if $step eq 1 && $type neq 'edit_apply'}
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<strong>{t domain="franchisee"}温馨提示：{/t}</strong>{t domain="franchisee"}如您的手机号码已申请入驻，可点击右侧查询按钮查询审核进度。{/t}
</div>
{/if}
	
<div class="page-header">
	<div class="pull-left">
		<h2><!-- {if $ur_here}{$ur_here}{/if} --></h2>
  	</div>
  	<div class="pull-right">
  		{if $action_link}
		<a href="{$action_link.href}" class="btn btn-primary data-pjax">
			<i class="fa fa-search"></i> {$action_link.text}
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
	                <p>{t domain="franchisee"}个人信息{/t}</p>
	            </li>
	            <li>
	                <span>2</span>
	                <p>{t domain="franchisee"}店铺信息{/t}</p>
	            </li>
	            <li>
	                <span>3</span>
	                <p>{t domain="franchisee"}等待审核{/t}</p>
	            </li>
	            <li>
	                <span>4</span>
	                <p>{t domain="franchisee"}审核完成{/t}</p>
	            </li>
	        </ul>
	    </div>
        <section class="panel">
            <div class="panel-body">
				{if $step eq 1}
				<form class="cmxform form-horizontal" name="theForm" action="{$form_action}" method="post">
					<div class="form-group">
					  	<label class="control-label col-lg-2">{t domain="franchisee"}手机号码：{/t}</label>
					  	<div class="controls col-lg-6">
					      	<input class="form-control" name="mobile" id="mobile" placeholder='{t domain="franchisee"}请输入手机号码{/t}' type="text" value="{$info.contact_mobile}" {if $type eq 'edit_apply'}readonly{/if}/>
					  	</div>
					  	{if $type neq 'edit_apply' && !$check_captcha}
					  	<a class="btn btn-primary" data-url="{url path='franchisee/merchant/get_code_value'}" id="get_code">{t domain="franchisee"}获取短信验证码{/t}</a>
					  	{/if}
					</div>
					
					{if $type neq 'edit_apply'}
						{if $check_captcha}
						<div class="form-group">
						  	<label class="control-label col-lg-2">{t domain="franchisee"}图形验证码：{/t}</label>
						    <!-- {ecjia:hook id=merchant_join_captcha} -->
						    <a class="btn btn-primary" data-url="{url path='franchisee/merchant/get_code_value'}" id="get_code">{t domain="franchisee"}获取短信验证码{/t}</a>
						</div>
						{/if}
						<div class="form-group">
						  	<label class="control-label col-lg-2">{t domain="franchisee"}短信验证码：{/t}</label>
						  	<div class="col-lg-6">
						      	<input class="form-control" name="code" placeholder='{t domain="franchisee"}请输入手机短信验证码{/t}' type="text" />
						  	</div>
						</div>
					{/if}
					
					<div class="form-group">
                        <label for="firstname" class="control-label col-lg-2">{t domain="franchisee"}入驻类型：{/t}</label>
                        <div class="col-lg-6 controls">
                        	<input type="radio" id="validate_type_1" name="validate_type" value="1" {if $info.validate_type eq 1}checked{/if}>
                        	<label for="validate_type_1">{t domain="franchisee"}个人{/t}</label>
							<input type="radio" id="validate_type_2" name="validate_type" value="2" {if $info.validate_type eq 2}checked{/if}>
							<label for="validate_type_2">{t domain="franchisee"}企业{/t}</label>
                        </div>
                    </div>
                    
                    <div class="form-group responsible_person">
						<label class="control-label col-lg-2">{t domain="franchisee"}负责人姓名：{/t}</label>
						<div class="controls col-lg-6">
							<input class="form-control" name="responsible_person" type="text" value="{$info.responsible_person}"/>
						</div>
						<span class="input-must">*</span>
					</div>
					
					<div class="form-group company_responsible_person">
						<label class="control-label col-lg-2">{t domain="franchisee"}法定代表人姓名：{/t}</label>
						<div class="controls col-lg-6">
							<input class="form-control" name="company_responsible_person" type="text" value="{$info.responsible_person}"/>
						</div>
						<span class="input-must">*</span>
					</div>
						
					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="franchisee"}电子邮箱：{/t}</label>
						<div class="col-lg-6 controls">
							<input class="form-control" name="email" type="text"  value="{$info.email}"/>
						</div>
						<span class="input-must">*</span>
					</div>
					<div class="form-group ">
						<div class="col-lg-6 col-md-offset-2">
							<input class="btn btn-primary" type="submit" value='{t domain="franchisee"}下一步{/t}'>
					  	</div>
					</div>
				</form>
       			{/if} 
                        
				{if $step eq 2}
                <form class="cmxform form-horizontal" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data">
                	<header class="panel-heading">{t domain="franchisee"}店铺信息{/t} <hr></header>
                    <div class="form-group">
                        <label for="firstname" class="control-label col-lg-2">{t domain="franchisee"}店铺分类：{/t}</label>
                        <div class="col-lg-6 controls">
                            <select class="form-control" name="store_cat">
								<option value="0">{t domain="franchisee"}请选择...{/t}</option>
								<!-- {html_options options=$cat_list selected=$data.cat_id} -->
							</select>
                        </div>
                        <span class="input-must">*</span>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-lg-2">{t domain="franchisee"}店铺名称：{/t}</label>
                       	<div class="col-lg-6 controls">
                            <input class="form-control" name="merchants_name" type="text" value="{$data.merchants_name}"/>
                        </div>
                        <span class="input-must">*</span>
                    </div>
                   
                    <div class="form-group">
                        <label class="control-label col-lg-2">{t domain="franchisee"}店铺关键字：{/t}</label>
                       	<div class="col-lg-6 controls">
                            <input class="form-control" name="shop_keyword" type="text" value="{$data.shop_keyword}"/>
                        </div>
                    </div>

                    <div class="form-group">
						<label class="control-label col-lg-2">{t domain="franchisee"}联系方式：{/t}</label>
						<div class="col-lg-6 controls">
							<input class="form-control" name="contact_mobile" type="text" value="{$contact_mobile}" readonly/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="franchisee"}电子邮箱：{/t}</label>
						<div class="col-lg-6 controls">
							<input class="form-control" name="email" type="text" value="{$info.email}" readonly/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="franchisee"}选择地区：{/t}</label>
						<div class="controls">
							<div class="w120 f_l m_l15 m_r10">
								<select class="region-summary-provinces col-lg-12" name="province" id="selProvinces" data-url="{url path='franchisee/merchant/get_region'}" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities">
									<option value='0'>{t domain="franchisee"}请选择...{/t}</option>
									<!-- {foreach from=$province item=region} -->
									<option value="{$region.region_id}" {if $region.region_id eq $data.province}selected{/if}>{$region.region_name}</option>
									<!-- {/foreach} -->
								</select>
							</div>
							
							<div class="w120 f_l m_r10">
								<select class="region-summary-cities col-lg-12" name="city" id="selCities" data-toggle="regionSummary" data-type="3" data-target="region-summary-district">
									<option value='0'>{t domain="franchisee"}请选择...{/t}</option>
									<!-- {foreach from=$city item=region} -->
									<option value="{$region.region_id}" {if $region.region_id eq $data.city}selected{/if}>{$region.region_name}</option>
									<!-- {/foreach} -->
								</select>
							</div>
							
							<div class="w120 f_l m_r10">
								<select class="form-control region-summary-district" id="selDistrict" data-toggle="regionSummary" name="district" data-type="4" data-target="region-summary-street">
									<option value='0'>{t domain="franchisee"}请选择...{/t}</option>
									<!-- {foreach from=$district item=region} -->
									<option value="{$region.region_id}" {if $region.region_id eq $data.district}selected{/if}>{$region.region_name}</option>
									<!-- {/foreach} -->
								</select>
							</div>
							
							<div class="w120 f_l m_r10">
                          		<select class="form-control region-summary-street" name="street" >
                                    <option value='0'>{t domain="franchisee"}请选择...{/t}</option>
                                    <!-- {foreach from=$street item=region} -->
                                    <option value="{$region.region_id}" {if $region.region_id eq $data.street}selected{/if}>{$region.region_name}</option>
                                    <!-- {/foreach} -->
                                </select>
                            </div>
                            <span class="input-must">*</span>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="franchisee"}详细地址：{/t}</label>
					 	<div class="controls col-lg-6">
					 		<input class="form-control" name="address" type="text" value="{$data.address}"/>
					 		<div class="help-block">{t domain="franchisee"}点击获取精确位置显示地图坐标{/t}</div>
						</div>
						<span class="input-must">*</span>
						<div class="input-must">
                     		<button class="btn btn-info small-btn" data-toggle="get-gohash" data-url="{url path='franchisee/merchant/getgeohash'}">{t domain="franchisee"}获取精准坐标{/t}</button>
                  		</div>
					</div>
					
                        <div class="form-group location-address {if !$data.longitude || !$data.latitude}hide{/if}">
                            <label class="control-label col-lg-2">{t domain="franchisee"}店铺精确位置：{/t}</label>
                            <div class="col-lg-6">
                                <div id="allmap" style="height:320px;"></div>
                                <div class="help-block">{t domain="franchisee"}点击选择店铺精确位置，双击放大地图，拖动查看地图其他区域{/t}</div>
                                <div class="help-block">
                                    <label class="control-label f_l">{t domain="franchisee"}经纬度：{/t}</label>
                                    <span class="col-lg-4"><input class="form-control required" type="text" readonly name="longitude" value="{$data.longitude}"></span>
                                    <span class="col-lg-4"><input class="form-control required" type="text" readonly name="latitude" value="{$data.latitude}"></span>
                                </div>
                            </div>
                        </div>				
					
	  				<!-- 经营主体信息start -->
	  				<header class="panel-heading">{t domain="franchisee"}经营主体信息{/t} <hr></header>
					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="franchisee"}负责人姓名：{/t}</label>
						<div class="controls col-lg-6">
							<input class="form-control" name="responsible_person" type="text" value="{$info.responsible_person}" readonly/>
						</div>
					</div>	
					
					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="franchisee"}证件类型：{/t}</label>
						<div class="controls col-lg-6">
							<select class="form-control" name="identity_type">
								<option value="0">{t domain="franchisee"}请选择...{/t}</option>
								<!-- {html_options options=$certificates_list selected=$data.identity_type} -->
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="franchisee"}证件号码：{/t}</label>
						<div class="controls col-lg-6">
							<input class="form-control" name="identity_number" type="text" value="{$data.identity_number}"/>
						</div>
						<span class="input-must">*</span>
					</div>
					
					{if $info.validate_type eq 2}
					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="franchisee"}公司名称：{/t}</label>
						<div class="controls col-lg-6">
							<input class="form-control" name="company_name" type="text" value="{$data.company_name}"/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="franchisee"}营业执照注册号：{/t}</label>
						<div class="controls col-lg-6">
							<input class="form-control" name="business_licence" type="text" value="{$data.business_licence}"/>
						</div>
					</div>
					{/if}
					<!-- 经营主体信息end -->	
					
					<header class="panel-heading">{t domain="franchisee"}证件电子版{/t} <hr></header>
					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="franchisee"}证件正面：{/t}</label>
						<div class="col-lg-6">
                        	<div class="fileupload fileupload-{if $data.identity_pic_front}exists{else}new{/if}"  data-provides="fileupload">
                        	{if $data.identity_pic_front}
                            <div class="fileupload-{if $data.identity_pic_front}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                           		<img src="{$data.identity_pic_front}" alt='{t domain="franchisee"}店铺LOGO{/t}' style="width:50px; height:50px;"/>
                      		</div>
                      		{/if}
                        	<div class="fileupload-preview fileupload-{if $data.identity_pic_front}new{else}exists{/if} thumbnail" style="max-width: 60px; max-height: 60px; line-height: 10px;"></div>
                   				<span class="btn btn-primary btn-file btn-sm">
                                 	<span class="fileupload-new"><i class="fa fa-paper-clip"></i>{t domain="franchisee"}浏览{/t}</span>
                                 	<span class="fileupload-exists"> {t domain="franchisee"}修改{/t}</span>
                               		<input type="file" class="default" name="identity_pic_front">
                            	</span>
                         		<a class="btn btn-danger btn-sm fileupload-exists" {if $data.identity_pic_front}data-toggle="ajaxremove" data-msg='{t domain="franchisee"}您确定要执行该操作吗？{/t}'{else}data-dismiss="fileupload"{/if} href="{url path='franchisee/merchant/drop_file' args="code=identity_pic_front"}">{t domain="franchisee"}删除{/t}</a>
                			</div>
                			<span class="help-block">{t domain="franchisee"}大小不超过1M{/t}</span>
               			</div>						
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="franchisee"}证件反面：{/t}</label>
						<div class="col-lg-6">
                        	<div class="fileupload fileupload-{if $data.identity_pic_back}exists{else}new{/if}"  data-provides="fileupload">
                        	{if $data.identity_pic_back}
                            <div class="fileupload-{if $data.identity_pic_back}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                           		<img src="{$data.identity_pic_back}" alt='{t domain="franchisee"}店铺LOGO{/t}' style="width:50px; height:50px;"/>
                      		</div>
                      		{/if}
                        	<div class="fileupload-preview fileupload-{if $data.identity_pic_back}new{else}exists{/if} thumbnail" style="max-width: 60px; max-height: 60px; line-height: 10px;"></div>
                   				<span class="btn btn-primary btn-file btn-sm">
                                 	<span class="fileupload-new"><i class="fa fa-paper-clip"></i>{t domain="franchisee"}修改{/t}</span>
                                 	<span class="fileupload-exists"> {t domain="franchisee"}修改{/t}</span>
                               		<input type="file" class="default" name="identity_pic_back">
                            	</span>
                         		<a class="btn btn-danger btn-sm fileupload-exists" {if $data.identity_pic_back}data-toggle="ajaxremove" data-msg='{t domain="franchisee"}您确定要执行该操作吗？{/t}'{else}data-dismiss="fileupload"{/if} href="{url path='franchisee/merchant/drop_file' args="code=identity_pic_back"}">{t domain="franchisee"}删除{/t}</a>
                			</div>
                			<span class="help-block">{t domain="franchisee"}大小不超过1M{/t}</span>
               			</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="franchisee"}手持证件：{/t}</label>
						<div class="col-lg-6">
                        	<div class="fileupload fileupload-{if $data.personhand_identity_pic}exists{else}new{/if}"  data-provides="fileupload">
                        	{if $data.personhand_identity_pic}
                            <div class="fileupload-{if $data.personhand_identity_pic}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                           		<img src="{$data.personhand_identity_pic}" alt='{t domain="franchisee"}店铺LOGO{/t}' style="width:50px; height:50px;"/>
                      		</div>
                      		{/if}
                        	<div class="fileupload-preview fileupload-{if $data.personhand_identity_pic}new{else}exists{/if} thumbnail" style="max-width: 60px; max-height: 60px; line-height: 10px;"></div>
                   				<span class="btn btn-primary btn-file btn-sm">
                                 	<span class="fileupload-new"><i class="fa fa-paper-clip"></i>{t domain="franchisee"}浏览{/t}</span>
                                 	<span class="fileupload-exists">{t domain="franchisee"}修改{/t}</span>
                               		<input type="file" class="default" name="personhand_identity_pic">
                            	</span>
                         		<a class="btn btn-danger btn-sm fileupload-exists" {if $data.personhand_identity_pic}data-toggle="ajaxremove" data-msg='{t domain="franchisee"}您确定要执行该操作吗？{/t}'{else}data-dismiss="fileupload"{/if} href="{url path='franchisee/merchant/drop_file' args="code=personhand_identity_pic"}">{t domain="franchisee"}删除{/t}</a>
                			</div>
                			<span class="help-block">{t domain="franchisee"}大小不超过1M{/t}</span>
               			</div>						
					</div>
					
					{if $info.validate_type eq 2}
					<div class="form-group">
						<label class="control-label col-lg-2">{t domain="franchisee"}营业执照电子版：{/t}</label>
						<div class="col-lg-6">
                        	<div class="fileupload fileupload-{if $data.business_licence_pic}exists{else}new{/if}"  data-provides="fileupload">
                        	{if $data.business_licence_pic}
                            <div class="fileupload-{if $data.business_licence_pic}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                           		<img src="{$data.business_licence_pic}" style="width:50px; height:50px;"/>
                      		</div>
                      		{/if}
                        	<div class="fileupload-preview fileupload-{if $data.business_licence_pic}new{else}exists{/if} thumbnail" style="max-width: 60px; max-height: 60px; line-height: 10px;"></div>
                   				<span class="btn btn-primary btn-file btn-sm">
                                 	<span class="fileupload-new"><i class="fa fa-paper-clip"></i>{t domain="franchisee"}浏览{/t}</span>
                                 	<span class="fileupload-exists">{t domain="franchisee"}修改{/t}</span>
                               		<input type="file" class="default" name="business_licence_pic">
                            	</span>
                            	<a class="btn btn-danger btn-sm fileupload-exists" {if $data.business_licence_pic}data-toggle="ajaxremove" data-msg='{t domain="franchisee"}您确定要执行该操作吗？{/t}'{else}data-dismiss="fileupload"{/if} href="{url path='franchisee/merchant/drop_file' args="code=business_licence_pic"}">{t domain="franchisee"}删除{/t}</a>
                			</div>
                			<span class="help-block">{t domain="franchisee"}大小不超过1M{/t}</span>
               			</div>						
					</div>
					{/if}
					
                    <div class="form-group">
                        <div class="col-lg-6 col-md-offset-2">
                           <input class="btn btn-primary" type="submit" value='{t domain="franchisee"}提交{/t}'>
                        </div>
                    </div>
                </form>
                {/if} 
                       
                {if $step eq 3}
                	<div class="f_r">
               		 {if $edit_apply}
		            	<a class="btn btn-info" href="{$edit_apply}">{t domain="franchisee"}修改申请信息{/t}</a>
		           	{/if}
		           	{if $remove_apply}
               			<a class="btn btn-info remove_apply" data-msg='{t domain="franchisee"}您确定要撤销该申请吗？{/t}' data-href="{$remove_apply}">{t domain="franchisee"}撤销申请{/t}</a>
                 	{/if}
                 	</div>
	                <div class="jumbotron text-center">
	                	{if $type eq 'view'}
	                	{t domain="franchisee"}正在审核中，请耐心等待。{/t}
	                	{else}
						{t domain="franchisee"}恭喜你，你的申请已提交，请耐心等待审核。{/t}
						{/if}
	             	</div>
                {/if} 
                
                {if $step eq 4}
                 <div class="panel">
		            <div class="panel-body">
		            	<div class="f_r">
		            		{if $edit_apply}
		            		<a class="btn btn-info" href="{$edit_apply}">{t domain="franchisee"}修改申请信息{/t}</a>
		            		{/if}
		            		
		            		{if $remove_apply}
                      		<a class="btn btn-info" data-toggle="ajaxremove" data-msg='{t domain="franchisee"}您确定要撤销该申请吗？{/t}' href="{$remove_apply}">{t domain="franchisee"}撤销申请{/t}</a>
                      		{/if}
                      	</div>
                      	
						<div class="row">
							<div class="form-group col-lg-8">
								<label class="control-label col-lg-2">{t domain="franchisee"}审核状态：{/t}</label>
								<div class="controls col-lg-8">{$message}</div>
							</div>
							{if $refuse_info}
							<div class="form-group col-lg-8">
								<label class="control-label col-lg-2">{t domain="franchisee"}拒绝原因：{/t}</label>
								<div class="controls col-lg-8">{$refuse_info}</div>
							</div>
							{/if}
						</div>
                      	
		                <section>
		                    <h3 class="page-header">{t domain="franchisee"}店铺信息{/t}</h3>
		                    <div class="row">
		                        <div class="col-md-12">
		                            <table class="table table-th-block">
		                                <tr>
		                                    <td class="active w350" align="right" style="border-top:0px;">{t domain="franchisee"}入驻类型：{/t}</td>
		                                    <td style="border-top:0px;">{if $data.validate_type eq 1}{t domain="franchisee"}个人{/t}{else}{t domain="franchisee"}企业{/t}{/if}{t domain="franchisee"}入驻{/t}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">{t domain="franchisee"}店铺名称：{/t}</td>
		                                    <td>{$data.merchants_name}{if $data.manage_mode eq 'self'}<span class="merchant_tags">{t domain="franchisee"}自营{/t}</span>{/if}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">{t domain="franchisee"}店铺分类：{/t}</td>
		                                    <td>{if $data.cat_name}{$data.cat_name}{else}<i>< {t domain="franchisee"}还未选择{/t} ></i>{/if}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">{t domain="franchisee"}店铺关键字：{/t}</td>
		                                    <td>{if $data.shop_keyword}{$data.shop_keyword}{else}<i>< {t domain="franchisee"}还未填写 {/t}></i>{/if}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">{t domain="franchisee"}详细地址：{/t}</td>
		                                    <td>{if $data.province || $data.city || $data.district || $data.address}
		                                        {$data.province} {$data.city} {$data.district} {$data.address}
		                                        {else}
		                                        <i>< {t domain="franchisee"}还未填写{/t} ></i>
		                                        {/if}
		                                    </td>
		                                </tr>
		                                <!-- {if $data.longitude && $data.latitude} -->
		                                <tr>
		                                    <td class="active w350" align="right">{t domain="franchisee"}店铺精确位置：{/t}</td>
		                                    <td>
		                                        <div id="allmap" style="height:320px;"></div>
		                                        <div class="help-block">{t domain="franchisee"}双击放大地图，拖动查看地图其他区域{/t}</div>
		                                        <div class="help-block">{t domain="franchisee"}当前经纬度：{/t}{$data.longitude},{$data.latitude}</div>
		                                    </td>
		                                </tr>
		                                <!-- {/if} -->
		                            </table>
		                        </div>
		                    </div>
		                </section>
		
		                <section>
		                    <h3 class="page-header">{t domain="franchisee"}联系人信息{/t}</h3>
		                    <div class="row">
		                        <div class="col-md-12">
		                            <table class="table table-th-block">
		                                <tr>
		                                    <td class="active w350" align="right" style="border-top:0px;">{t domain="franchisee"}负责人：{/t}</td>
		                                    <td style="border-top:0px;">
		                                        <!-- {if $data.responsible_person} -->
		                                        {$data.responsible_person}
		                                        <!-- {else} -->
		                                        <i>< {t domain="franchisee"}还未填写{/t} ></i>
		                                        <!-- {/if} -->
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">{t domain="franchisee"}联系邮箱：{/t}</td>
		                                    <td>
		                                        <!-- {if $data.email} -->
		                                        {$data.email}
		                                        <!-- {else} -->
		                                        <i>< {t domain="franchisee"}还未填写{/t} ></i>
		                                        <!-- {/if} -->
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">{t domain="franchisee"}联系手机：{/t}</td>
		                                    <td>
		                                        <!-- {if $data.contact_mobile} -->
		                                        {$data.contact_mobile}
		                                        <!-- {else} -->
		                                        <i>< {t domain="franchisee"}还未填写{/t} ></i>
		                                        <!-- {/if} -->
		                                    </td>
		                                </tr>
		                            </table>
		                        </div>
		                    </div>
		                </section>
		
		                <section>
		                    <h3 class="page-header">{t domain="franchisee"}资质信息{/t}</h3>
		                    <div class="row">
		                        <div class="col-md-12">
		                            <table class="table table-th-block">
		                                <tr>
		                                    <td class="active w350" align="right" style="border-top:0px;">{t domain="franchisee"}证件类型：{/t}</td>
		                                    <td style="border-top:0px;">
		                                   		{if $data.identity_type eq 0}< {t domain="franchisee"}还未填写{/t} ></i>{/if}
		                                        {if $data.identity_type eq 1}{t domain="franchisee"}身份证{/t}{/if}
		                                        {if $data.identity_type eq 2}{t domain="franchisee"}护照{/t}{/if}
		                                        {if $data.identity_type eq 3}{t domain="franchisee"}港澳身份证{/t}{/if}
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">{t domain="franchisee"}证件号码：{/t}</td>
		                                    <td>{if $data.identity_number}{$data.identity_number}{else}<i>< {t domain="franchisee"}还未填写{/t} ></i>{/if}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">{t domain="franchisee"}证件正面：{/t}</td>
		                                    <td>{if $data.identity_pic_front}<img class="merchant-info-img w200 h120" src="{$data.identity_pic_front}" alt='{t domain="franchisee"}证件正面：{/t}'/>{else}<i>< {t domain="franchisee"}还未上传{/t} ></i>{/if}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">{t domain="franchisee"}证件反面：{/t}</td>
		                                    <td>{if $data.identity_pic_back}<img class="merchant-info-img w200 h120" src="{$data.identity_pic_back}" alt='{t domain="franchisee"}证件反面{/t}'/>{else}<i>< {t domain="franchisee"}还未上传{/t} ></i>{/if}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">{t domain="franchisee"}手持证件拍照：{/t}</td>
		                                    <td>{if $data.personhand_identity_pic}<img class="merchant-info-img w200 h120" src="{$data.personhand_identity_pic}" alt='{t domain="franchisee"}手持证件拍照{/t}'/>{else}<i>< {t domain="franchisee"}还未上传{/t} ></i>{/if}</td>
		                                </tr>
		                            </table>
		                        </div>
		                    </div>
		                </section>
		                <!-- {if $data.validate_type eq 2} -->
		                <section>
		                    <h3 class="page-header">{t domain="franchisee"}公司信息{/t}</h3>
		                    <div class="row">
		                        <div class="col-md-12">
		                            <table class="table table-th-block">
		                                <tr>
		                                    <td class="active w350" align="right" style="border-top:0px;">{t domain="franchisee"}公司名称：{/t}</td>
		                                    <td style="border-top:0px;">{$data.company_name}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">{t domain="franchisee"}营业执照注册号：{/t}</td>
		                                    <td>{$data.business_licence}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">{t domain="franchisee"}营业执照电子版：{/t}</td>
		                                    <td>{if $data.business_licence_pic}<img class="merchant-info-img w200 h120" src="{$data.business_licence_pic}" alt='{t domain="franchisee"}营业执照{/t}'/>{/if}</td>
		                                </tr>
		                            </table>
		                        </div>
		                    </div>
		                </section>
		                <!-- {/if} -->
		                
		                <!-- {if $check_log_list} -->
		                <section>
		                    <h3>{t domain="franchisee"}审核日志{/t}</h3>
		                    <div class="row">
		                        <div class="col-md-12">
		                            <table class="table table-th-block">
		                                <tr>
		                                    <th>{t domain="franchisee"}审核人{/t}</th>
		                                    <th>{t domain="franchisee"}备注信息{/t}</th>
		                                    <th class="w150">{t domain="franchisee"}审核时间{/t}</th>
		                                </tr>
		                                <!-- {foreach from=$check_log_list item=list} -->
		                                <tr>
		                                    <td>{$list.name}</td>
		                                    <td>{$list.info}</td>
		                                    <td>{$list.time}</td>
		                                </tr>
		                                <!-- {/foreach} -->
		                            </table>
		                        </div>
		                    </div>
		                </section>
		                <!-- {/if} -->
		            </div>
		        </div>
                {/if}
            </div>
        </section>
    </div>
</div>
{if ecjia::config('stats_code')}
	{stripslashes(ecjia::config('stats_code'))}
{/if}
<!-- {/block} -->