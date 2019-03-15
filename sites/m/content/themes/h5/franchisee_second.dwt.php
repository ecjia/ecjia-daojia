<?php
/*
Name: 收货地址列表模板
Description: 收货地址列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {nocache} -->
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.franchisee.second();</script>
<script type="text/javascript">ecjia.touch.franchisee.coordinate();</script>
<script type="text/javascript">ecjia.touch.franchisee.choices();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<form class="ecjia-address-list" name="theForm" action="{$form_action}" method="post">
	<div class="form-group form-group-text franchisee">
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}images/user_center/f_store.png" width="30" height="30"></span>
			<input name="seller_name" placeholder='{t domain="h5"}请输入店铺名称10字以内{/t}' type="text"  {if $smarty.cookies.franchisee_seller_name neq ''}value="{$smarty.cookies.franchisee_seller_name}" {else} value="{$second_show.seller_name}" {/if}/>
		</label>
	</div>
	
	<div class="form-group form-group-text franchisee">
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}images/user_center/f_category.png" width="30" height="30"></span>
			<i class="iconfont  icon-jiantou-right"></i>
			<input class="ecjia-franchisee-category" style="padding-left: 3.5em;" name="seller_category_name" placeholder='{t domain="h5"}请选择店铺分类{/t}' type="text"  {if $smarty.cookies.franchisee_seller_category neq ''} value="{$smarty.cookies.franchisee_seller_category}" {else} value="{$second_show.seller}" {/if}/>
		    <input name="category" type="hidden" value={$category} />
		    <input name="seller_category" type="hidden" value="{if $smarty.cookies.franchisee_seller_category_id}{$smarty.cookies.franchisee_seller_category_id}{else}{$category_arr.data.0.id}{/if}" />
		</label>
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}images/user_center/f_type.png" width="30" height="30"></span>
			<i class="iconfont  icon-jiantou-right"></i>
			<input class="ecjia-franchisee-type" style="padding-left: 3.5em;" name="validate_type" placeholder='{t domain="h5"}请选择入驻类型 {/t}' type="text" {if $smarty.cookies.franchisee_validate_type neq ''} value="{$smarty.cookies.franchisee_validate_type}" {else} value="{$second_show.validate_type}" {/if} />
		</label>
	</div>
	<div class="form-group form-group-text franchisee" id="get_location_region" data-url="{url path='franchisee/index/get_region'}">
		<label class="input">
    		<span class="ecjiaf-fl"><img src="{$theme_url}images/user_center/f_location.png" width="30" height="30"></span>
    		<i class="iconfont  icon-jiantou-right"></i>
    		<div class="ecjia-franchisee-location-pcd"/>{if $second_show.pcd_name}{$second_show.pcd_name}{else}{t domain="h5"}请选择省、市、区{/t}{/if}</div>
	        <input type="hidden" name="f_province" value="{$smarty.cookies.franchisee_province_id}"/>
			<input type="hidden" name="f_city" value="{$smarty.cookies.franchisee_city_id}"/>
			<input type="hidden" name="f_district" value="{$smarty.cookies.franchisee_district_id}"/>
			
			
			<input type="hidden" name="f_province_name" disabled/>
			<input type="hidden" name="f_city_name" disabled/>
			<input type="hidden" name="f_district_name" disabled/>
			<input type="hidden" name="f_street_name" disabled/>
    	</label>
    	
    	<label class="input">
    		<span class="ecjiaf-fl"></span>
    		<i class="iconfont  icon-jiantou-right"></i>
    		<div class="ecjia-franchisee-location-street">{if $second_show.street_name}{$second_show.street_name}{else}{t domain="h5"}请选择街道{/t}{/if}</div>
    		<input name="f_street" type="hidden" value="{$smarty.cookies.franchisee_street_id}" />
    	</label>
    	
		<label class="input">
    	   <input name="f_address" placeholder='{t domain="h5"}输入详细地址{/t}' type="text" {if $smarty.cookies.franchisee_address neq ''} value="{$smarty.cookies.franchisee_address}" {else} value="{$second_show.address}" {/if}>
		</label>
	</div>

	<p class="coordinate" data-url="{url path='franchisee/index/location'}">{t domain="h5"}获取精准坐标{/t}</p>
	
	<input name="longitude" type="hidden" value="{$longitude}" />
	<input name="latitude" type="hidden" value="{$latitude}" />
	<input type="hidden" name="mobile" value={$mobile} />
	<input type="hidden" name="code" value={$code} />
	
	<input type="hidden" name="province_list" disabled value='{$region_data.province_list}' />
	<input type="hidden" name="city_list" disabled value='{$region_data.city_list}' />
	<input type="hidden" name="district_list" disabled value='{$region_data.district_list}' />
	<input type="hidden" name="street_list" disabled value='{$region_data.street_list}' />
	
	<div class="ecjia-margin-t ecjia-margin-b">
		<input class="btn btn-info nopjax external" name="franchisee_submit" type="submit" value='{t domain="h5"}提交{/t}' />
	</div>
	
</form>
<!-- {/block} -->
<!-- {/nocache} -->