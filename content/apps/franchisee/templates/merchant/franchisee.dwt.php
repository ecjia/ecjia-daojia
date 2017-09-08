<!-- {extends file="ecjia-merchant.dwt.php"} -->

<!-- {block name="meta"} -->
<title>
{if $type eq 'edit_apply'}修改申请{else}商家入驻{/if} - {ecjia::config('shop_name')}
</title>
<!-- {/block} -->

<!-- {block name="title"} -->
{if $type eq 'edit_apply'}修改申请{else}商家入驻{/if} - {ecjia::config('shop_name')}
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
{if $browser_warning}
<div class="alert alert-warning">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<strong>温馨提示：</strong>{$browser_warning}
</div>
{/if}

{if $step eq 1 && $type neq 'edit_apply'}
<div class="alert alert-info">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true"><i class="fa fa-times" data-original-title="" title=""></i></button>
	<strong>温馨提示：</strong>如您的手机号码已申请入驻，可点击右侧查询按钮查询审核进度。
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
	                <p>个人信息</p>
	            </li>
	            <li>
	                <span>2</span>
	                <p>店铺信息</p>
	            </li>
	            <li>
	                <span>3</span>
	                <p>等待审核</p>
	            </li>
	            <li>
	                <span>4</span>
	                <p>审核完成</p>
	            </li>
	        </ul>
	    </div>
        <section class="panel">
            <div class="panel-body">
				{if $step eq 1}
				<form class="cmxform form-horizontal" name="theForm" action="{$form_action}" method="post">
					<div class="form-group">
					  	<label class="control-label col-lg-2">手机号码：</label>
					  	<div class="controls col-lg-6">
					      	<input class="form-control" name="mobile" id="mobile" placeholder="请输入手机号码" type="text" value="{$info.contact_mobile}" {if $type eq 'edit_apply'}readonly{/if}/>
					  	</div>
					  	{if $type neq 'edit_apply'}
					 	<a class="btn btn-primary" data-url="{url path='franchisee/merchant/get_code_value'}" id="get_code">获取短信验证码</a>
					 	{/if}
					</div>
					
					{if $type neq 'edit_apply'}
					<div class="form-group">
					  	<label class="control-label col-lg-2">{t}短信验证码：{/t}</label>
					  	<div class="col-lg-6">
					      	<input class="form-control" name="code" placeholder="请输入手机短信验证码" type="text" />
					  	</div>
					</div>
					{/if}
					
					<div class="form-group">
                        <label for="firstname" class="control-label col-lg-2">入驻类型：</label>
                        <div class="col-lg-6 controls">
                        	<input type="radio" id="validate_type_1" name="validate_type" value="1" {if $info.validate_type eq 1}checked{/if}>
                        	<label for="validate_type_1">个人</label>
							<input type="radio" id="validate_type_2" name="validate_type" value="2" {if $info.validate_type eq 2}checked{/if}>
							<label for="validate_type_2">企业</label>
                        </div>
                    </div>
                    
                    <div class="form-group responsible_person">
						<label class="control-label col-lg-2">负责人姓名：</label>
						<div class="controls col-lg-6">
							<input class="form-control" name="responsible_person" type="text" value="{$info.responsible_person}"/>
						</div>
						<span class="input-must">*</span>
					</div>
					
					<div class="form-group company_responsible_person">
						<label class="control-label col-lg-2">法定代表人姓名：</label>
						<div class="controls col-lg-6">
							<input class="form-control" name="company_responsible_person" type="text" value="{$info.responsible_person}"/>
						</div>
						<span class="input-must">*</span>
					</div>
						
					<div class="form-group">
						<label class="control-label col-lg-2">电子邮箱：</label>
						<div class="col-lg-6 controls">
							<input class="form-control" name="email" type="text"  value="{$info.email}"/>
						</div>
						<span class="input-must">*</span>
					</div>
					<div class="form-group ">
						<div class="col-lg-6 col-md-offset-2">
							<input class="btn btn-primary" type="submit" value="下一步">
					  	</div>
					</div>
				</form>
       			{/if} 
                        
				{if $step eq 2}
                <form class="cmxform form-horizontal" name="theForm" action="{$form_action}" method="post" enctype="multipart/form-data">
                	<header class="panel-heading">店铺信息 <hr></header>
                    <div class="form-group">
                        <label for="firstname" class="control-label col-lg-2">店铺分类：</label>
                        <div class="col-lg-6 controls">
                            <select class="form-control" name="store_cat">
								<option value="0">请选择...</option>
								<!-- {html_options options=$cat_list selected=$data.cat_id} -->
							</select>
                        </div>
                        <span class="input-must">*</span>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-lg-2">店铺名称：</label>
                       	<div class="col-lg-6 controls">
                            <input class="form-control" name="merchants_name" type="text" value="{$data.merchants_name}"/>
                        </div>
                        <span class="input-must">*</span>
                    </div>
                   
                    <div class="form-group">
                        <label class="control-label col-lg-2">店铺关键字：</label>
                       	<div class="col-lg-6 controls">
                            <input class="form-control" name="shop_keyword" type="text" value="{$data.shop_keyword}"/>
                        </div>
                    </div>

                    <div class="form-group">
						<label class="control-label col-lg-2">联系方式：</label>
						<div class="col-lg-6 controls">
							<input class="form-control" name="contact_mobile" type="text" value="{$contact_mobile}" readonly/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-lg-2">电子邮箱：</label>
						<div class="col-lg-6 controls">
							<input class="form-control" name="email" type="text" value="{$info.email}" readonly/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-lg-2">选择地区：</label>
						<div class="col-lg-6 controls">
							<div class="col-lg-4 p_l0 p_r5">
								<select class="region-summary-provinces col-lg-12" name="province" id="selProvinces" data-url="{url path='franchisee/merchant/get_region'}" data-toggle="regionSummary" data-type="2" data-target="region-summary-cities">
									<option value='0'>{lang key='system::system.select_please'}</option>
									<!-- {foreach from=$province item=region} -->
									<option value="{$region.region_id}" {if $region.region_id eq $data.province}selected{/if}>{$region.region_name}</option>
									<!-- {/foreach} -->
								</select>
							</div>
							
							<div class="col-lg-4 p_l0 p_r5">
								<select class="region-summary-cities col-lg-12" name="city" id="selCities" data-url="{url path='franchisee/merchant/get_region'}" data-toggle="regionSummary" data-type="3" data-target="region-summary-district">
									<option value='0'>{lang key='system::system.select_please'}</option>
									<!-- {foreach from=$city item=region} -->
									<option value="{$region.region_id}" {if $region.region_id eq $data.city}selected{/if}>{$region.region_name}</option>
									<!-- {/foreach} -->
								</select>
							</div>
							
							<div class="col-lg-4 p_l0 p_r0">
								<select class="region-summary-district col-lg-12" name="district" id="seldistrict">
									<option value='0'>{lang key='system::system.select_please'}</option>
									<!-- {foreach from=$district item=region} -->
									<option value="{$region.region_id}" {if $region.region_id eq $data.district}selected{/if}>{$region.region_name}</option>
									<!-- {/foreach} -->
								</select>
							</div>
						</div>
						<span class="input-must">*</span>
					</div>
					
					<div class="form-group">
						<label class="control-label col-lg-2">详细地址：</label>
					 	<div class="controls col-lg-6">
					 		<input class="form-control" name="address" type="text" value="{$data.address}"/>
					 		<div class="help-block">点击获取精确位置显示地图坐标</div>
						</div>
						<span class="input-must">*</span>
						<div class="input-must">
                     		<button class="btn btn-info small-btn" data-toggle="get-gohash" data-url="{url path='franchisee/merchant/getgeohash'}">获取精准坐标</button>
                  		</div>
					</div>
					
                        <div class="form-group location-address {if !$data.longitude || !$data.latitude}hide{/if}">
                            <label class="control-label col-lg-2">店铺精确位置：</label>
                            <div class="col-lg-6">
                                <div id="allmap" style="height:320px;"></div>
                                <div class="help-block">点击选择店铺精确位置，双击放大地图，拖动查看地图其他区域</div>
                                <div class="help-block">
                                    <label class="control-label f_l">经纬度：</label>
                                    <span class="col-lg-4"><input class="form-control required" type="text" readonly name="longitude" value="{$data.longitude}"></span>
                                    <span class="col-lg-4"><input class="form-control required" type="text" readonly name="latitude" value="{$data.latitude}"></span>
                                </div>
                            </div>
                        </div>				
					
	  				<!-- 经营主体信息start -->
	  				<header class="panel-heading">经营主体信息 <hr></header>
					<div class="form-group">
						<label class="control-label col-lg-2">{if $info.validate_type eq 1}负责人姓名：{elseif $info.validate_type eq 2}法定代表人姓名：{/if}</label>
						<div class="controls col-lg-6">
							<input class="form-control" name="responsible_person" type="text" value="{$info.responsible_person}" readonly/>
						</div>
					</div>	
					
					<div class="form-group">
						<label class="control-label col-lg-2">证件类型：</label>
						<div class="controls col-lg-6">
							<select class="form-control" name="identity_type">
								<option value="0">请选择...</option>
								<!-- {html_options options=$certificates_list selected=$data.identity_type} -->
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">证件号码：</label>
						<div class="controls col-lg-6">
							<input class="form-control" name="identity_number" type="text" value="{$data.identity_number}"/>
						</div>
						<span class="input-must">*</span>
					</div>
					
					{if $info.validate_type eq 2}
					<div class="form-group">
						<label class="control-label col-lg-2">公司名称：</label>
						<div class="controls col-lg-6">
							<input class="form-control" name="company_name" type="text" value="{$data.company_name}"/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-lg-2">营业执照注册号：</label>
						<div class="controls col-lg-6">
							<input class="form-control" name="business_licence" type="text" value="{$data.business_licence}"/>
						</div>
					</div>
					{/if}
					<!-- 经营主体信息end -->	
					
					<header class="panel-heading">证件电子版 <hr></header>
					<div class="form-group">
						<label class="control-label col-lg-2">证件正面：</label>
						<div class="col-lg-6">
                        	<div class="fileupload fileupload-{if $data.identity_pic_front}exists{else}new{/if}"  data-provides="fileupload">
                        	{if $data.identity_pic_front}
                            <div class="fileupload-{if $data.identity_pic_front}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                           		<img src="{$data.identity_pic_front}" alt="店铺LOGO" style="width:50px; height:50px;"/>
                      		</div>
                      		{/if}
                        	<div class="fileupload-preview fileupload-{if $data.identity_pic_front}new{else}exists{/if} thumbnail" style="max-width: 60px; max-height: 60px; line-height: 10px;"></div>
                   				<span class="btn btn-primary btn-file btn-sm">
                                 	<span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
                                 	<span class="fileupload-exists"> 修改</span>
                               		<input type="file" class="default" name="identity_pic_front">
                            	</span>
                         		<a class="btn btn-danger btn-sm fileupload-exists" {if $data.identity_pic_front}data-toggle="ajaxremove" data-msg="您确定要执行该操作吗？"{else}data-dismiss="fileupload"{/if} href="{url path='franchisee/merchant/drop_file' args="code=identity_pic_front"}">删除</a>
                			</div>
                			<span class="help-block">大小不超过1M</span>
               			</div>						
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">证件反面：</label>
						<div class="col-lg-6">
                        	<div class="fileupload fileupload-{if $data.identity_pic_back}exists{else}new{/if}"  data-provides="fileupload">
                        	{if $data.identity_pic_back}
                            <div class="fileupload-{if $data.identity_pic_back}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                           		<img src="{$data.identity_pic_back}" alt="店铺LOGO" style="width:50px; height:50px;"/>
                      		</div>
                      		{/if}
                        	<div class="fileupload-preview fileupload-{if $data.identity_pic_back}new{else}exists{/if} thumbnail" style="max-width: 60px; max-height: 60px; line-height: 10px;"></div>
                   				<span class="btn btn-primary btn-file btn-sm">
                                 	<span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
                                 	<span class="fileupload-exists"> 修改</span>
                               		<input type="file" class="default" name="identity_pic_back">
                            	</span>
                         		<a class="btn btn-danger btn-sm fileupload-exists" {if $data.identity_pic_back}data-toggle="ajaxremove" data-msg="您确定要执行该操作吗？"{else}data-dismiss="fileupload"{/if} href="{url path='franchisee/merchant/drop_file' args="code=identity_pic_back"}">删除</a>
                			</div>
                			<span class="help-block">大小不超过1M</span>
               			</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">手持证件：</label>
						<div class="col-lg-6">
                        	<div class="fileupload fileupload-{if $data.personhand_identity_pic}exists{else}new{/if}"  data-provides="fileupload">
                        	{if $data.personhand_identity_pic}
                            <div class="fileupload-{if $data.personhand_identity_pic}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                           		<img src="{$data.personhand_identity_pic}" alt="店铺LOGO" style="width:50px; height:50px;"/>
                      		</div>
                      		{/if}
                        	<div class="fileupload-preview fileupload-{if $data.personhand_identity_pic}new{else}exists{/if} thumbnail" style="max-width: 60px; max-height: 60px; line-height: 10px;"></div>
                   				<span class="btn btn-primary btn-file btn-sm">
                                 	<span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
                                 	<span class="fileupload-exists"> 修改</span>
                               		<input type="file" class="default" name="personhand_identity_pic">
                            	</span>
                         		<a class="btn btn-danger btn-sm fileupload-exists" {if $data.personhand_identity_pic}data-toggle="ajaxremove" data-msg="您确定要执行该操作吗？"{else}data-dismiss="fileupload"{/if} href="{url path='franchisee/merchant/drop_file' args="code=personhand_identity_pic"}">删除</a>
                			</div>
                			<span class="help-block">大小不超过1M</span>
               			</div>						
					</div>
					
					{if $info.validate_type eq 2}
					<div class="form-group">
						<label class="control-label col-lg-2">营业执照电子版：</label>
						<div class="col-lg-6">
                        	<div class="fileupload fileupload-{if $data.business_licence_pic}exists{else}new{/if}"  data-provides="fileupload">
                        	{if $data.business_licence_pic}
                            <div class="fileupload-{if $data.business_licence_pic}exists{else}new{/if} thumbnail" style="max-width: 60px;">
                           		<img src="{$data.business_licence_pic}" style="width:50px; height:50px;"/>
                      		</div>
                      		{/if}
                        	<div class="fileupload-preview fileupload-{if $data.business_licence_pic}new{else}exists{/if} thumbnail" style="max-width: 60px; max-height: 60px; line-height: 10px;"></div>
                   				<span class="btn btn-primary btn-file btn-sm">
                                 	<span class="fileupload-new"><i class="fa fa-paper-clip"></i>浏览</span>
                                 	<span class="fileupload-exists"> 修改</span>
                               		<input type="file" class="default" name="business_licence_pic">
                            	</span>
                            	<a class="btn btn-danger btn-sm fileupload-exists" {if $data.business_licence_pic}data-toggle="ajaxremove" data-msg="您确定要执行该操作吗？"{else}data-dismiss="fileupload"{/if} href="{url path='franchisee/merchant/drop_file' args="code=business_licence_pic"}">删除</a>
                			</div>
                			<span class="help-block">大小不超过1M</span>
               			</div>						
					</div>
					{/if}
					
                    <div class="form-group">
                        <div class="col-lg-6 col-md-offset-2">
                           <input class="btn btn-primary" type="submit" value="提交">
                        </div>
                    </div>
                </form>
                {/if} 
                       
                {if $step eq 3}
                	<div class="f_r">
               		 {if $edit_apply}
		            	<a class="btn btn-info" href="{$edit_apply}">修改申请信息</a>
		           	{/if}
		           	{if $remove_apply}
               			<a class="btn btn-info remove_apply" data-msg="您确定要撤销该申请吗？" data-href="{$remove_apply}">撤销申请</a>
                 	{/if}
                 	</div>
	                <div class="jumbotron text-center">
	                	{if $type eq 'view'}
	                	正在审核中，请耐心等待。
	                	{else}
						恭喜你，你的申请已提交，请耐心等待审核。
						{/if}
	             	</div>
                {/if} 
                
                {if $step eq 4}
                 <div class="panel">
		            <div class="panel-body">
		            	<div class="f_r">
		            		{if $edit_apply}
		            		<a class="btn btn-info" href="{$edit_apply}">修改申请信息</a>
		            		{/if}
		            		
		            		{if $remove_apply}
                      		<a class="btn btn-info" data-toggle="ajaxremove" data-msg="您确定要撤销该申请吗？" href="{$remove_apply}">撤销申请</a>
                      		{/if}
                      	</div>
                      	
						<div class="row">
							<div class="form-group col-lg-8">
								<label class="control-label col-lg-2">审核状态：</label>
								<div class="controls col-lg-8">{$message}</div>
							</div>
							{if $refuse_info}
							<div class="form-group col-lg-8">
								<label class="control-label col-lg-2">拒绝原因：</label>
								<div class="controls col-lg-8">{$refuse_info}</div>
							</div>
							{/if}
						</div>
                      	
		                <section>
		                    <h3 class="page-header">店铺信息</h3>
		                    <div class="row">
		                        <div class="col-md-12">
		                            <table class="table table-th-block">
		                                <tr>
		                                    <td class="active w350" align="right" style="border-top:0px;">入驻类型：</td>
		                                    <td style="border-top:0px;">{if $data.validate_type eq 1}个人{else}企业{/if}入驻</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">店铺名称：</td>
		                                    <td>{$data.merchants_name}{if $data.manage_mode eq 'self'}<span class="merchant_tags">自营</span>{/if}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">店铺分类：</td>
		                                    <td>{if $data.cat_name}{$data.cat_name}{else}<i>< 还未选择 ></i>{/if}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">店铺关键字：</td>
		                                    <td>{if $data.shop_keyword}{$data.shop_keyword}{else}<i>< 还未填写 ></i>{/if}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">详细地址：</td>
		                                    <td>{if $data.province || $data.city || $data.district || $data.address}
		                                        {$data.province} {$data.city} {$data.district} {$data.address}
		                                        {else}
		                                        <i>< 还未填写 ></i>
		                                        {/if}
		                                    </td>
		                                </tr>
		                                <!-- {if $data.longitude && $data.latitude} -->
		                                <tr>
		                                    <td class="active w350" align="right">{lang key='merchant::merchant.merchant_addres'}：</td>
		                                    <td>
		                                        <div id="allmap" style="height:320px;"></div>
		                                        <div class="help-block">双击放大地图，拖动查看地图其他区域</div>
		                                        <div class="help-block">当前经纬度：{$data.longitude},{$data.latitude}</div>
		                                    </td>
		                                </tr>
		                                <!-- {/if} -->
		                            </table>
		                        </div>
		                    </div>
		                </section>
		
		                <section>
		                    <h3 class="page-header">联系人信息</h3>
		                    <div class="row">
		                        <div class="col-md-12">
		                            <table class="table table-th-block">
		                                <tr>
		                                    <td class="active w350" align="right" style="border-top:0px;">负责人：</td>
		                                    <td style="border-top:0px;">
		                                        <!-- {if $data.responsible_person} -->
		                                        {$data.responsible_person}
		                                        <!-- {else} -->
		                                        <i>< 还未填写 ></i>
		                                        <!-- {/if} -->
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">联系邮箱：</td>
		                                    <td>
		                                        <!-- {if $data.email} -->
		                                        {$data.email}
		                                        <!-- {else} -->
		                                        <i>< 还未填写 ></i>
		                                        <!-- {/if} -->
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">联系手机：</td>
		                                    <td>
		                                        <!-- {if $data.contact_mobile} -->
		                                        {$data.contact_mobile}
		                                        <!-- {else} -->
		                                        <i>< 还未填写 ></i>
		                                        <!-- {/if} -->
		                                    </td>
		                                </tr>
		                            </table>
		                        </div>
		                    </div>
		                </section>
		
		                <section>
		                    <h3 class="page-header">资质信息</h3>
		                    <div class="row">
		                        <div class="col-md-12">
		                            <table class="table table-th-block">
		                                <tr>
		                                    <td class="active w350" align="right" style="border-top:0px;">证件类型：</td>
		                                    <td style="border-top:0px;">
		                                   		{if $data.identity_type eq 0}< 还未填写 ></i>{/if}
		                                        {if $data.identity_type eq 1}身份证{/if}
		                                        {if $data.identity_type eq 2}护照{/if}
		                                        {if $data.identity_type eq 3}港澳身份证{/if}
		                                    </td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">证件号码：</td>
		                                    <td>{if $data.identity_number}{$data.identity_number}{else}<i>< 还未填写 ></i>{/if}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">证件正面：</td>
		                                    <td>{if $data.identity_pic_front}<img class="merchant-info-img w200 h120" src="{$data.identity_pic_front}" alt="证件正面"/>{else}<i>< 还未上传 ></i>{/if}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">证件反面：</td>
		                                    <td>{if $data.identity_pic_back}<img class="merchant-info-img w200 h120" src="{$data.identity_pic_back}" alt="证件反面"/>{else}<i>< 还未上传 ></i>{/if}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">手持证件拍照：</td>
		                                    <td>{if $data.personhand_identity_pic}<img class="merchant-info-img w200 h120" src="{$data.personhand_identity_pic}" alt="手持证件拍照"/>{else}<i>< 还未上传 ></i>{/if}</td>
		                                </tr>
		                            </table>
		                        </div>
		                    </div>
		                </section>
		                <!-- {if $data.validate_type eq 2} -->
		                <section>
		                    <h3 class="page-header">公司信息</h3>
		                    <div class="row">
		                        <div class="col-md-12">
		                            <table class="table table-th-block">
		                                <tr>
		                                    <td class="active w350" align="right" style="border-top:0px;">公司名称：</td>
		                                    <td style="border-top:0px;">{$data.company_name}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">营业执照注册号：</td>
		                                    <td>{$data.business_licence}</td>
		                                </tr>
		                                <tr>
		                                    <td class="active w350" align="right">营业执照电子版：</td>
		                                    <td>{if $data.business_licence_pic}<img class="merchant-info-img w200 h120" src="{$data.business_licence_pic}" alt="营业执照"/>{/if}</td>
		                                </tr>
		                            </table>
		                        </div>
		                    </div>
		                </section>
		                <!-- {/if} -->
		                
		                <!-- {if $check_log_list} -->
		                <section>
		                    <h3>审核日志</h3>
		                    <div class="row">
		                        <div class="col-md-12">
		                            <table class="table table-th-block">
		                                <tr>
		                                    <th>审核人</th>
		                                    <th>备注信息</th>
		                                    <th class="w150">审核时间</th>
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