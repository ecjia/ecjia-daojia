<?php 
/*
Name: 增加收货地址模板
Description: 增加收货地址页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.address_from.init();ecjia.touch.user.address_save();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
{if $local eq 0}
<p class="showTit">这个地址超过该门店的配送范围</p>
{/if}
<form class="ecjia-address-list" name="theForm" action="{$form_action}" data-save-url="{url path='user/address/save_temp_data'}" method="post">
	<div class="form-group form-group-text ecjia-border-t">
		<a id="district" href='{url path="location/index/select_city" args="{if $info.id}type=editcity&address_id={$info.id}{else}type=addcity{/if}{if $temp.tem_city}&city_id={$temp.tem_city}{else}{if $info.city}&city_id={$info.city}{/if}{/if}{if $referer_url}&referer_url={$referer_url|escape:"url"}{/if}"}'>
		<label class="input">
			<span>所在地区： </span>
			<input name="city_name" placeholder="{t}请选择城市{/t}" type="text" ignore="ignore" datatype="*" value="{if $temp.tem_city_name && $temp.tem_city gt 0}{$temp.tem_city_name}{else}{if $info.city_name}{$info.city_name}{else}{$smarty.cookies.city_name}{/if}{/if}" nullmsg="请选择城市" readonly="readonly" />
			<input name="city_id" type="hidden" datatype="*" nullmsg="请选择城市" value="{if $temp.tem_city}{$temp.tem_city}{else}{if $info.city}{$info.city}{else}{$smarty.cookies.city_id}{/if}{/if}" />
			<i class="iconfont icon-jiantou-right"></i>
		</label>
		</a>
	</div>
	<div class="form-group form-group-text margin-bottom0 ecjia-border-t">
		<label class="input">
			<span class="ecjiaf-fl">收货地址： </span>
			<input name="address" placeholder="{t}写字楼，小区，学校，街道{/t}" type="text" value="{if $temp.tem_address_detail}{$temp.tem_address_detail}{if $temp.tem_name neq '我的位置'}{$temp.tem_name}{/if}{else}{if $info.address}{$info.address}{else}{if $smarty.cookies.location_address_id neq 0}{$smarty.cookies.location_name}{else}{$smarty.cookies.location_address}{/if}{/if}{/if}" nullmsg="请选择收货地址" />
			<a class="external" href="{$my_location}">
				<div class="position"></div>
			</a>
		</label>
	</div>
	<div class="form-group form-group-text">
		<label class="input">
			<input name="address_info" placeholder="{t}楼层，门牌{/t}" type="text" datatype="*" ignore="ignore" value="{if $temp.tem_address_info}{$temp.tem_address_info}{else}{$info.address_info}{/if}" />
		</label>
	</div>
	<div class="form-group form-group-text margin-bottom0 ecjia-border-t">
		<label class="input">
			<span class="ecjiaf-fl">收货姓名： </span>
			<input name="consignee" placeholder="{t}请输入真实姓名，限6个字{/t}" type="text" value="{if $temp.tem_consignee}{$temp.tem_consignee}{else}{$info.consignee|escape}{/if}" datatype="*1-15" errormsg="请输入正确格式联系人" nullmsg="请填写收货姓名" />
		</label>
	</div>
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl">收货电话： </span>
			<input name="mobile" placeholder="{t}请确保收货电话真实有效{/t}" type="tel" value="{if $temp.tem_mobile}{$temp.tem_mobile}{else}{$info.mobile|escape}{/if}" datatype="n6-14" errormsg="请输入正确格式的联系方式" nullmsg="请填写收货电话" />
		</label>
	</div>
	<div class="ecjia-margin-t ecjia-margin-b">
	    <input name="temp_key" type="hidden" value="{$temp_key}" />
		<input class="btn btn-info nopjax" name="submit" type="submit" value="{t}保存{/t}"/>
		<input name="address_id" type="hidden" value="{$info.id}" />
		<input name="referer_url" type="hidden" value="{$referer_url}" />
	</div>
</form>
<!-- {/block} -->
{/nocache}