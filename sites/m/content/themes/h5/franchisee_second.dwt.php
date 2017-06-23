<?php
/*
Name: 收货地址列表模板
Description: 收货地址列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
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
			<input name="seller_name" placeholder="{t}请输入店铺名称10字以内{/t}" type="text"  {if $smarty.cookies.seller_name neq ''}value="{$smarty.cookies.seller_name}" {else} value="{$second_show.seller_name}" {/if}/>
		</label>
	</div>
	
	<div class="form-group form-group-text franchisee">
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}images/user_center/f_category.png" width="30" height="30"></span>
			<i class="iconfont  icon-jiantou-right"></i>
			<input class="ecjia-franchisee-category" style="padding-left: 3.5em;" name="seller_category" placeholder="{t}请选择店铺分类{/t}" type="text"  {if $smarty.cookies.seller neq ''} value="{$smarty.cookies.seller}" {else} value="{$second_show.seller}" {/if}/>
		    <input name="category" type="hidden" value={$category} />
		    <input name="seller_category_id" type="hidden" value="{if $smarty.cookies.seller_category_id}{$smarty.cookies.seller_category_id}{else}{$category_arr.data.0.id}{/if}" />
		</label>
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}images/user_center/f_type.png" width="30" height="30"></span>
			<i class="iconfont  icon-jiantou-right"></i>
			<input class="ecjia-franchisee-type" style="padding-left: 3.5em;" name="validate_type" placeholder="{t}请选择入驻类型 {/t}" type="text" {if $smarty.cookies.validate_type neq ''} value="{$smarty.cookies.validate_type}" {else} value="{$second_show.validate_type}" {/if} />
		</label>
	</div>
	<div class="form-group form-group-text franchisee" id="get_location_region" data-url="{url path='franchisee/index/get_region'}">
		<label class="input">
    		<span class="ecjiaf-fl"><img src="{$theme_url}images/user_center/f_location.png" width="30" height="30"></span>
    		<i class="iconfont  icon-jiantou-right"></i>
    		<input class="ecjia-franchisee-location_province" name="f_province" placeholder="{t}选择省{/t}" type="text" {if $smarty.cookies.province_name neq ''} value="{$smarty.cookies.province_name}" {else} value="{$second_show.province_name}" {/if}>
	        <input name="province" type="hidden" value={$province} />
    		<input name="province_id" type="hidden" value="{$smarty.cookies.province_id}" />
    	</label>
    	
    	<label class="input">
    		<span class="ecjiaf-fl"></span>
    		<i class="iconfont  icon-jiantou-right"></i>
    		<input class="ecjia-franchisee-location_city" name="f_city" placeholder="{t}选择市{/t}" type="text" {if $smarty.cookies.city_name neq ''} value="{$smarty.cookies.city_name}" {else}value="{$second_show.city_name}" {/if}>
    		<input name="city_id" type="hidden" value="{$smarty.cookies.city_id}" />
    	</label>
    	
    	<label class="input">
    		<span class="ecjiaf-fl"></span>
    		<i class="iconfont  icon-jiantou-right"></i>
    		<input class="ecjia-franchisee-location_district" name="f_district" placeholder="{t}选择区{/t}" type="text" {if $smarty.cookies.district_name neq ''} value="{$smarty.cookies.district_name}" {else}value="{$second_show.district_name}" {/if}/>
    		<input name="district_id" type="hidden" value="{$smarty.cookies.district_id}" />
    	</label>
    	
		<label class="input">
    	   <input name="f_address" placeholder="{t}输入详细地址{/t}" type="text" {if $smarty.cookies.address neq ''} value="{$smarty.cookies.address}" {else} value="{$second_show.address}" {/if}>
		</label>
	</div>

	<p class="coordinate" data-url="{url path='franchisee/index/location'}">获取精准坐标</p>
	
	<input name="longitude" type="hidden" value="{$longitude}" />
	<input name="latitude" type="hidden" value="{$latitude}" />
	<input type="hidden" name="mobile" value={$mobile} />
	<input type="hidden" name="code" value={$code} />
	
	<div class="ecjia-margin-t ecjia-margin-b">
		<input class="btn btn-info nopjax external" name="franchisee_submit" type="submit" value="{t}提交{/t}"/>
	</div>
	
</form>
<!-- {/block} -->
{/nocache}