<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="admin_shop_config.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.admin.admin_config.init();
</script>
<!-- {/block} -->

<!-- {block name="alert_info"} -->
<div class="alert alert-info">
	<a class="close" data-dismiss="alert">×</a>
	<strong>{t domain="store"}温馨提示：{/t}</strong>{t domain="store"}这里的后台设置仅限改善商家后台的显示效果。{/t}
</div>
<!-- {/block} -->

<!-- {block name="admin_config_form"} -->
<div class="row-fluid edit-page">
	<form class="form-horizontal"  name="theForm" action="{$form_action}" method="post"  enctype="multipart/form-data" >
		<div class="span12">
			<h3 class="heading">
				{if $ur_here}{$ur_here}{/if}
				{if $action_link}
				<a href="{$action_link.href}" class="btn data-pjax"  style="float:right;margin-top:-3px;"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
				{/if}
			</h3>
    		<div class="control-group formSep">
    			<label class="control-label">{t domain="store"}登录Logo：{/t}</label>
    			<div class="controls">
    				<div class="fileupload {if $config_logo}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
    				<a tabindex="0" role="button" href="javascript:;" class="no-underline cursor_pointor" data-trigger="focus" data-toggle="popover" data-placement="top">	
    					<div class="fileupload-preview thumbnail fileupload-exists" style="width: 230px; height: 50px; line-height: 50px;">
    						<img src="{$config_logoimg}" alt='{t domain="store"}预览图片{/t}' />
    					</div>
    				</a>
    				<div class="hide" id="content_1"><img class="mh150" src="{$config_logoimg}"></div> 
    					<span class="btn btn-file">
    					<span class="fileupload-new">{t domain="store"}浏览{/t}</span>
    					<span class="fileupload-exists">{t domain="store"}修改{/t}</span>
    					<input type="file" name="merchant_admin_login_logo"/>
    					</span>
    					<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{t domain="store"}您确定要删除该图片吗？{/t}" data-href="{RC_Uri::url('store/admin_config/del')}&type=logo" {if $config_logo}data-removefile="true"{/if}>{t domain="store"}删除{/t}</a>
    					<span class="help-block">{t domain="store"}推荐尺寸：230*50px{/t}</span>
    				</div>
    			</div>
    		</div>

			<div class="control-group formSep">
    			<label class="control-label">{t domain="store"}是否关闭入驻商加盟：{/t}</label>
    			<div class="controls l_h30">
					<input type="radio" name="merchant_join_close" value="0" {if $merchant_join_close eq 0}checked{/if}/>{t domain="store"}否{/t}
					<input type="radio" name="merchant_join_close" value="1" {if $merchant_join_close eq 1}checked{/if}/>{t domain="store"}是{/t} 
				</div>
    		</div>
    		
    		<h3 class="heading">
				{t domain="store"}入驻商家保证金{/t}
			</h3>
	    	<div class="control-group formSep">
    			<label class="control-label">{t domain="store"}默认保证金：{/t}</label>
    			<div class="controls">
    				<input type="text" name="store_deposit" value="{$store_deposit}" />{t domain="store"}元{/t}
    				<span class="help-block">{t domain="store"}商家入驻后需要向平台缴纳的保证金金额，提现时账户余额大于等于保证金{/t}</span>
    			</div>
    		</div>
    		
    		<h3 class="heading">
				{t domain="store"}商家员工数量{/t}
			</h3>
	    	<div class="control-group formSep">
    			<label class="control-label">{t domain="store"}默认员工数：{/t}</label>
    			<div class="controls">
    				<input type="text" name="merchant_staff_max_number" value="{$merchant_staff_max_number}" />
    				<span class="help-block">{t domain="store"}设置所有商家默认最多可添加员工数量{/t}</span>
    			</div>
    		</div>

		    <h3 class="heading">
				{t domain="store"}定位{/t}
			</h3>
	    	<div class="control-group formSep">
    			<label class="control-label">{t domain="store"}定位范围：{/t}</label>
    			<div class="controls">
    				<select name="mobile_location_range">
    					<option value='0' {if $mobile_location_range eq '0'}selected="true"{/if}>{t domain="store"}全城{/t}</option>
    					<option value='1' {if $mobile_location_range eq '1'}selected="true"{/if}>{t domain="store"}约周边5000公里{/t}</option>
    					<option value='2' {if $mobile_location_range eq '2'}selected="true"{/if}>{t domain="store"}约周边1000公里{/t}</option>
    					<option value='3' {if $mobile_location_range eq '3'}selected="true"{/if}>{t domain="store"}约周边120公里{/t}</option>
    					<option value='4' {if $mobile_location_range eq '4'}selected="true"{/if}>{t domain="store"}约周边30公里{/t}</option>
    					<option value='5' {if $mobile_location_range eq '5'}selected="true"{/if}>{t domain="store"}约周边4公里{/t}</option>
    					<option value='6' {if $mobile_location_range eq '6'}selected="true"{/if}>{t domain="store"}约周边1公里{/t}</option>
    					<option value='7' {if $mobile_location_range eq '7'}selected="true"{/if}>{t domain="store"}约周边200米{/t}</option>
    				</select>
    			</div>
    		</div>
    		
    		<h3 class="heading">
				{t domain="store"}门店模式{/t}
			</h3>
	    	<div class="control-group formSep">
    			<label class="control-label">{t domain="store"}门店切换模式：{/t}</label>
    			<div class="controls l_h30">
    				<input type="radio" name="store_model" value="0" {if $model eq 0 || !$model}checked{/if} />{t domain="store"}附近门店{/t}
    				<input type="radio" name="store_model" value="1" {if $model eq 1}checked{/if} />{t domain="store"}单门店{/t}
    				<input type="radio" name="store_model" value="2" {if $model eq 2}checked{/if} />{t domain="store"}多门店{/t}
					<input type="radio" name="store_model" value="3" {if $model eq 3}checked{/if} />{t domain="store"}平台模式{/t}
    				<span class="help-block">
						{t domain="store"}设置门店的切换模式，如果选择“单门店”则可设置单独的一家门店{/t}<br>
						{t domain="store"}如果选择“多门店”则可设置多家门店{/t}<br>
						{t domain="store"}如果选择“平台模式”，则显示多商户版小程序{/t}
					</span>
    			</div>
    			<div class="controls search" data-url="{url path='store/admin_config/search_store'}">
    				<div class="search_content {if $model neq 1 && $model neq 2}hide{/if}">
	    				<div class="f_l">
		    				<select name="cat_id">
		    					<option value="0">{t domain="store"}请选择店铺分类{/t}</option>
		    					<!-- {$cat_list} -->
		    				</select>
	    				</div>
	    				<input type="text" name="keywords" value="" placehholder='{t domain="store"}请输入店铺名称关键字{/t}'/>
	    				<a href="javascript:;" class="btn search-store">{t domain="store"}搜索{/t}</a>
	    				<div class="clear m_t10">
	    					<span class="help-block">{t domain="store"}请选择店铺分类或输入店铺名称关键词进行搜索{/t}</span>
	    				</div>
    				</div>
    			</div> 
    			
    			<div class="controls mode mode_1 {if $model neq 1}hide{/if}">
    				<select name="store" class="store_list" style="width:445px;">
						{if $store_list.store_id && $model eq 1}
							<option value="{$store_list.store_id}">{$store_list.merchants_name}</option>
						{else}
							<option value='0'>{t domain="store"}请选择...{/t}</option>
						{/if}
					</select>
    			</div>
    			
				<div class="controls draggable mode mode_2 {if $model neq 2}hide{/if}">
					<div class="ms-container" id="ms-custom-navigation">
						<div class="ms-selectable">
							<div class="search-header">
								<div class="custom-header custom-header-align">{t domain="store"}可选门店{/t}</div>
							</div>
							<ul class="ms-list nav-list-ready nav-store-list">
								<li class="ms-elem-selectable disabled"><span>{t domain="store"}暂无内容{/t}</span></li>
							</ul>
						</div>
						<div class="ms-selection">
							<div class="custom-header custom-header-align">{t domain="store"}已选门店{/t}</div>
							<ul class="ms-list nav-list-content">
								<!-- {if $model eq 2} -->
									<!-- {foreach from=$store_list item=store key=key} -->
									<li class="ms-elem-selection">
										<input type="hidden" value="{$store.store_id}" name="store_id[]" />
										<!-- {$store.merchants_name} -->
										<span class="edit-list"><i class="fontello-icon-minus-circled ecjiafc-red del"></i></span>
									</li>
									<!-- {/foreach} -->
								<!-- {/if} -->
							</ul>
						</div>
					</div>
				</div>
    		</div>
 
    		<!-- 热门城市start -->
			<h3 class="heading">{t domain="store"}经营区域{/t}</h3>
			
			<div class="alert alert-warnning">
				<a class="close" data-dismiss="alert">×</a>
				<strong>{t domain="store"}温馨提示：{/t}</strong>{t domain="store"}1、此模块仅限老版本设置，新版本请到“商家管理－经营城市”中设置。{/t}<a target="__blank" href="{RC_Uri::url('store/admin_store_business_city/init')}">{t domain="store"}去往经营城市设置 >>{/t}</a>
			</div>

			<div class="control-group formSep">
				<label class="control-label">{t domain="store"}已选择的经营区域：{/t}</label>
				<div class="controls selected_area chk_radio">
					<!-- {foreach from=$mobile_recommend_city item=region key=id} -->
					<input class="uni_style" type="checkbox" name="regions[]" value="{$id}" checked="checked" /> <span class="m_r10">{$region}&nbsp;&nbsp;</span>
					<!-- {/foreach} -->
				</div>
			</div>
			<div class="control-group formSep">
				<label class="control-label">{t domain="store"}请选择经营区域：{/t}</label>
				<div class="controls">
					<div class="ms-container ms-shipping span12" id="ms-custom-navigation">
						<div class="ms-selectable ms-mobile-selectable span2" style="width: 23%;">
							<div class="search-header">
								<input class="span12" type="text" placeholder='{t domain="store"}搜索省份{/t}' autocomplete="off" id="selProvinces" />
							</div>
							<ul class="ms-list ms-list-mobile nav-list-ready selProvinces" data-url="{url path='setting/region/init' args='target=selCities'}" data-next="selCities">
								<!-- {foreach from=$provinces item=province key=key} -->
								<li class="ms-elem-selectable select_hot_city" data-val="{$province.region_id}"><span>{$province.region_name|escape:html}</span></li>
								<!-- {foreachelse} -->
								<li class="ms-elem-selectable select_hot_city" data-val="0"><span>{t domain="store"}没有可选的省份地区……{/t}</span></li>
								<!-- {/foreach} -->
							</ul>
						</div>
						
						<div class="ms-selectable ms-mobile-selectable span2" style="width: 23%;">
							<div class="search-header">
								<input class="span12" type="text" placeholder='{t domain="store"}搜索市{/t}' autocomplete="off" id="selCities" />
							</div>
							<ul class="ms-list ms-list-mobile nav-list-ready selCities" data-url="{url path='setting/region/init' args='target=selDistricts'}" data-next="selDistricts">
								<li class="ms-elem-selectable select_hot_city" data-val="0"><span>{t domain="store"}请选择市{/t}</span></li>
							</ul>
						</div>
						
						<div class="ms-selectable ms-mobile-selectable span2" style="width: 23%;">
							<div class="search-header">
								<input class="span12" type="text" placeholder='{t domain="store"}搜索区/县{/t}' autocomplete="off" id="selDistricts" />
							</div>
							<ul class="ms-list ms-list-mobile nav-list-ready selDistricts" data-url="{url path='setting/region/init' args='target=selTown'}" data-next="selTown">
								<li class="ms-elem-selectable select_hot_city" data-val="0"><span>{t domain="store"}请选择区/县{/t}</span></li>
							</ul>
						</div>
						
						<div class="ms-selectable ms-mobile-selectable span2" style="width: 23%;">
							<div class="search-header">
								<input class="span12" type="text" placeholder='{t domain="store"}搜索区街道/镇{/t}' autocomplete="off" id="selTown" />
							</div>
							<ul class="ms-list ms-list-mobile nav-list-ready selTown">
								<li class="ms-elem-selectable select_hot_city" data-val="0"><span>{t domain="store"}请选择街道/镇{/t}</span></li>
							</ul>
						</div>
						
					</div>
				</div>
			</div>
			<!-- 热门城市end -->

    		<div class="control-group">
				<div class="controls">
					<input type="submit" value='{t domain="store"}确定{/t}' class="btn btn-gebo" />
				</div>
			</div>
		</div>
	</form>
</div>
<!-- {/block} -->