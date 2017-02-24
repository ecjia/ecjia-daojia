<?php 
/*
Name: 收货地址
Description: 购物车中的地址修改
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<div class="form-group">
		<label class="input">
			<input name="consignee" placeholder="{$lang.consignee_name}{$lang.require_field}" type="text" value="{$consignee.consignee|escape}" datatype="s1-15" errormsg="请输入长度为3 ~ 15的收货人姓名" />
		</label>
	</div>
	<div class="form-group">
		<label class="input">
			<input name="mobile" placeholder="{$lang.mobile}{$lang.require_field}" type="text" value="{$consignee.mobile|escape}" datatype="m" errormsg="请输入正确格式的联系方式" />
		</label>
	</div>
	<!-- {if $real_goods_count gt 0} --> 
	<!-- 购物车中存在实体商品显示国家和地区 -->
	<div class="form-group">
		<div class="ecjiaf-fl">
			<select class="form-select" name="country" id="selCountries" data-toggle="region_change" data-url="index.php?m=user&c=user_address&a=region" data-type="1" data-target="selProvinces" datatype="*">
				<option value="0">{$lang.please_select}{$name_of_region[0]}</option>
				<!-- {foreach from=$country_list item=country} -->
				<option value="{$country.region_id}"{if $country.region_id eq $consignee.country} selected{/if}>{$country.region_name}</option>
				<!-- {/foreach} -->
			</select>
		</div>
		<div class="ecjiaf-fl"> 
			<select class="form-select" name="province" id="selProvinces" data-toggle="region_change" data-url="index.php?m=user&c=user_address&a=region" data-type="2" data-target="selCities" datatype="*">
				<option value="0">{$lang.please_select}{$name_of_region[1]}</option>
				<!-- {foreach from=$province_list item=province} -->
				<option value="{$province.region_id}" {if $consignee.province eq $province.region_id}selected{/if}>{$province.region_name}</option>
				<!-- {/foreach} -->
			</select>
		</div>
		<div class="ecjiaf-fl">
			<select class="form-select" name="city" id="selCities" data-toggle="region_change" data-url="index.php?m=user&c=user_address&a=region" data-type="3" data-target="selDistricts" datatype="*">
				<option value="0">{$lang.please_select}{$name_of_region[2]}</option>
				<!-- {foreach from=$city_list item=city} -->
				<option value="{$city.region_id}" {if $consignee.city eq $city.region_id}selected{/if}>{$city.region_name}</option>
				<!-- {/foreach} -->
			</select>
		</div>
		<div class="ecjiaf-fl">
			<select class="form-select" name="district" id="selDistricts" datatype="*">
				<option value="0">{$lang.please_select}{$name_of_region[3]}</option>
				{$consignee.district}
				<!-- {foreach from=$district_list item=district} -->
				<option value="{$district.region_id}" {if $consignee.district eq $district.region_id}selected{/if}>{$district.region_name}</option>
				<!-- {/foreach} -->
			</select>
		</div>
	</div>
	<!-- {/if} --> 
	<!-- {if $real_goods_count gt 0} --> 
	<!-- 购物车中存在实体商品显示详细地址 -->
		<div class="form-group">
			<label class="textarea">
				<textarea name="address"  id="address" placeholder="{$lang.detailed_address}" datatype="*" >{$consignee.address|escape}</textarea>
			</label>
		</div>
<!-- {/if} -->
<div class="ecjia-margin-t btn-consignee {if $smarty.session.user_id gt 0 and $consignee.address_id gt 0} two-btn {/if}">
	<!-- {if $smarty.session.user_id gt 0 and $consignee.address_id gt 0} --> 
	<!-- 如果登录了，显示删除按钮 --> 
	<input  class="btn btn-info"  onclick="if (confirm('{$lang.drop_consignee_confirm}')) location.href='{url path='flow/drop_consignee' args="id={$consignee.address_id}"}'" value="{$lang.drop}">
	<!-- {/if} -->
	<input class="btn btn-info" name="Submit" type="submit" value="{$lang.shipping_address}">
</div>
<input type="hidden" name="step" value="consignee" />
<input type="hidden" name="act" value="checkout" />
<input type="hidden" name="referer" value="{$smarty.get.referer}" />
<input name="address_id" type="hidden" value="{$consignee.address_id}" />