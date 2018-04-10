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
	<strong>温馨提示：</strong>{t}这里的后台设置仅限改善商家后台的显示效果。{/t}
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
    			<label class="control-label">{t}登录Logo：{/t}</label>
    			<div class="controls">
    				<div class="fileupload {if $config_logo}fileupload-exists{else}fileupload-new{/if}" data-provides="fileupload">
    				<a tabindex="0" role="button" href="javascript:;" class="no-underline cursor_pointor" data-trigger="focus" data-toggle="popover" data-placement="top">	
    					<div class="fileupload-preview thumbnail fileupload-exists" style="width: 230px; height: 50px; line-height: 50px;">
    						<img src="{$config_logoimg}" alt="{t}预览图片{/t}" />
    					</div>
    				</a>
    				<div class="hide" id="content_1"><img class="mh150" src="{$config_logoimg}"></div> 
    					<span class="btn btn-file">
    					<span class="fileupload-new">{t}浏览{/t}</span>
    					<span class="fileupload-exists">{t}修改{/t}</span>
    					<input type="file" name="merchant_admin_login_logo"/>
    					</span>
    					<a class="btn fileupload-exists" data-toggle="removefile" data-msg="{t}您确定要删除该图片吗？{/t}" data-href="{RC_Uri::url('store/admin_config/del')}&type=logo" {if $config_logo}data-removefile="true"{/if}>{t}删除{/t}</a>
    					<span class="help-block">推荐尺寸：230*50px</span>
    				</div>
    			</div>
    		</div>

			<div class="control-group formSep">
    			<label class="control-label">{t}是否关闭入驻商加盟：{/t}</label>
    			<div class="controls l_h30">
					<input type="radio" name="merchant_join_close" value="0" {if $merchant_join_close eq 0}checked{/if}/>否
					<input type="radio" name="merchant_join_close" value="1" {if $merchant_join_close eq 1}checked{/if}/>是 
				</div>
    		</div>
    		
    		<h3 class="heading">
				保证金
			</h3>
	    	<div class="control-group formSep">
    			<label class="control-label">{t}默认保证金：{/t}</label>
    			<div class="controls">
    				<input type="text" name="store_deposit" value="{$store_deposit}" /> 元
    				<span class="help-block">商家入驻后需要向平台缴纳的保证金金额，提现时账户余额大于等于保证金</span>
    			</div>
    		</div>

		    <h3 class="heading">
				定位
			</h3>
	    	<div class="control-group formSep">
    			<label class="control-label">{t}定位范围：{/t}</label>
    			<div class="controls">
    				<select name="mobile_location_range">
    					<option value='0' {if $mobile_location_range eq '0'}selected="true"{/if}>全城</option>
    					<option value='1' {if $mobile_location_range eq '1'}selected="true"{/if}>约周边5000公里</option>
    					<option value='2' {if $mobile_location_range eq '2'}selected="true"{/if}>约周边1000公里</option>
    					<option value='3' {if $mobile_location_range eq '3'}selected="true"{/if}>约周边120公里</option>
    					<option value='4' {if $mobile_location_range eq '4'}selected="true"{/if}>约周边30公里</option>
    					<option value='5' {if $mobile_location_range eq '5'}selected="true"{/if}>约周边4公里</option>
    					<option value='6' {if $mobile_location_range eq '6'}selected="true"{/if}>约周边1公里</option>
    					<option value='7' {if $mobile_location_range eq '7'}selected="true"{/if}>约周边200米</option>
    				</select>
    			</div>
    		</div>
    		
    		<h3 class="heading">
				门店模式
			</h3>
	    	<div class="control-group formSep">
    			<label class="control-label">{t}门店切换模式：{/t}</label>
    			<div class="controls l_h30">
    				<input type="radio" name="store_model" value="0" {if $model eq 0 || !$model}checked="true"{/if} />附近门店
    				<input type="radio" name="store_model" value="1" {if $model eq 1}checked="true"{/if} />单门店
    				<input type="radio" name="store_model" value="2" {if $model eq 2}checked="true"{/if} />多门店
    				<span class="help-block">设置门店的切换模式，如选择“单门店”则可设置单独的一家门店，如选择“多门店”则可设置多家门店</span>
    			</div>
    			<div class="controls search" data-url="{url path='store/admin_config/search_store'}">
    				<div class="search_content {if $model neq 1 && $model neq 2}hide{/if}">
	    				<div class="f_l">
		    				<select name="cat_id">
		    					<option value="0">请选择店铺分类</option>
		    					<!-- {$cat_list} -->
		    				</select>
	    				</div>
	    				<input type="text" name="keywords" value="" placehholder="请输入店铺名称关键字"/>
	    				<a href="javascript:;" class="btn search-store">搜索</a>
	    				<div class="clear m_t10">
	    					<span class="help-block">请选择店铺分类或输入店铺名称关键词进行搜索</span>
	    				</div>
    				</div>
    			</div> 
    			
    			<div class="controls mode mode_1 {if $model neq 1}hide{/if}">
    				<select name="store" class="store_list" style="width:445px;">
						{if $store_list.store_id && $model eq 1}
							<option value="{$store_list.store_id}">{$store_list.merchants_name}</option>
						{else}
							<option value='0'>请选择...</option>
						{/if}
					</select>
    			</div>
    			
				<div class="controls draggable mode mode_2 {if $model neq 2}hide{/if}">
					<div class="ms-container" id="ms-custom-navigation">
						<div class="ms-selectable">
							<div class="search-header">
								<div class="custom-header custom-header-align">可选门店</div>
							</div>
							<ul class="ms-list nav-list-ready nav-store-list">
								<li class="ms-elem-selectable disabled"><span>暂无内容</span></li>
							</ul>
						</div>
						<div class="ms-selection">
							<div class="custom-header custom-header-align">已选门店</div>
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
			<h3 class="heading">经营区域</h3>
			<div class="control-group formSep">
				<label class="control-label">已选择的经营区域：</label>
				<div class="controls selected_area chk_radio">
					<!-- {foreach from=$mobile_recommend_city item=region key=id} -->
					<input class="uni_style" type="checkbox" name="regions[]" value="{$id}" checked="checked" /> <span class="m_r10">{$region}&nbsp;&nbsp;</span>
					<!-- {/foreach} -->
				</div>
			</div>
			<div class="control-group formSep">
				<label class="control-label">请选择经营区域：</label>
				<div class="controls">
					<div class="ms-container ms-shipping span12" id="ms-custom-navigation">
						<div class="ms-selectable ms-mobile-selectable span2" style="width: 23%;">
							<div class="search-header">
								<input class="span12" type="text" placeholder="搜索省份" autocomplete="off" id="selProvinces" />
							</div>
							<ul class="ms-list ms-list-mobile nav-list-ready selProvinces" data-url="{url path='setting/region/init' args='target=selCities'}" data-next="selCities">
								<!-- {foreach from=$provinces item=province key=key} -->
								<li class="ms-elem-selectable select_hot_city" data-val="{$province.region_id}"><span>{$province.region_name|escape:html}</span></li>
								<!-- {foreachelse} -->
								<li class="ms-elem-selectable select_hot_city" data-val="0"><span>没有可选的省份地区……</span></li>
								<!-- {/foreach} -->
							</ul>
						</div>
						
						<div class="ms-selectable ms-mobile-selectable span2" style="width: 23%;">
							<div class="search-header">
								<input class="span12" type="text" placeholder="搜索市" autocomplete="off" id="selCities" />
							</div>
							<ul class="ms-list ms-list-mobile nav-list-ready selCities" data-url="{url path='setting/region/init' args='target=selDistricts'}" data-next="selDistricts">
								<li class="ms-elem-selectable select_hot_city" data-val="0"><span>请选择市</span></li>
							</ul>
						</div>
						
						<div class="ms-selectable ms-mobile-selectable span2" style="width: 23%;">
							<div class="search-header">
								<input class="span12" type="text" placeholder="搜索区/县" autocomplete="off" id="selDistricts" />
							</div>
							<ul class="ms-list ms-list-mobile nav-list-ready selDistricts" data-url="{url path='setting/region/init' args='target=selTown'}" data-next="selTown">
								<li class="ms-elem-selectable select_hot_city" data-val="0"><span>请选择区/县</span></li>
							</ul>
						</div>
						
						<div class="ms-selectable ms-mobile-selectable span2" style="width: 23%;">
							<div class="search-header">
								<input class="span12" type="text" placeholder="搜索区街道/镇" autocomplete="off" id="selTown" />
							</div>
							<ul class="ms-list ms-list-mobile nav-list-ready selTown">
								<li class="ms-elem-selectable select_hot_city" data-val="0"><span>请选择街道/镇</span></li>
							</ul>
						</div>
						
					</div>
				</div>
			</div>
			<!-- 热门城市end -->

    		<div class="control-group">
				<div class="controls">
					<input type="submit" value="{lang key='system::system.button_submit'}" class="btn btn-gebo" />
				</div>
			</div>
		</div>
	</form>
</div>
<!-- {/block} -->