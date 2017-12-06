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
<script type="text/javascript">
	ecjia.touch.address_form.init();
	ecjia.touch.user.address_save();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
{if $local eq 0}
<p class="showTit ecjia-margin-t ecjia-padding-l">这个地址超过该门店的配送范围</p>
{/if}
<form class="ecjia-address-list" name="theForm" action="{$form_action}" data-save-url="{url path='user/address/save_temp_data'}" method="post">
	<div class="form-group form-group-text margin-bottom0 ecjia-border-t">
		<div class="input">
			<span>所在地区</span>
			<div class="ecjia_user_address_picker" data-url="{$get_region_url}">
				{if $info.province_name || $info.city_name || $info.district_name}
				{$info.province_name}-{$info.city_name}-{$info.district_name}
				{/if}
			</div>
			<i class="iconfont icon-jiantou-right"></i>
			<input type="hidden" name="province" value="{if $info.province}{$info.province}{/if}"/>
			<input type="hidden" name="city" value="{if $info.city}{$info.city}{/if}"/>
			<input type="hidden" name="district" value="{if $info.district}{$info.district}{/if}"/>
		</div>
	</div>
	
	<div class="form-group form-group-text margin-bottom0">
		<div class="input">
			<span>街道</span>
			<div class="ecjia_user_address_street_picker" data-url="{$get_region_url}">{if $info.street_name}{$info.street_name}{/if}</div>
			<i class="iconfont icon-jiantou-right"></i>
			<input type="hidden" name="street" value="{if $info.street}{$info.street}{/if}"/>
		</div>
	</div>
	
	<div class="form-group form-group-text margin-bottom0">
		<label class="input">
			<span class="ecjiaf-fl">详细地址 </span>
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
			<span class="ecjiaf-fl">收货人 </span>
			<input name="consignee" placeholder="{t}请输入真实姓名，限6个字{/t}" type="text" value="{if $temp.tem_consignee}{$temp.tem_consignee}{else}{$info.consignee|escape}{/if}" datatype="*1-15" errormsg="请输入正确格式联系人" nullmsg="请填写收货姓名" />
		</label>
	</div>
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl">手机号 </span>
			<input name="mobile" placeholder="{t}请确保收货电话真实有效{/t}" type="tel" value="{if $temp.tem_mobile}{$temp.tem_mobile}{else}{$info.mobile|escape}{/if}" datatype="n6-14" errormsg="请输入正确格式的联系方式" nullmsg="请填写收货电话" />
		</label>
	</div>
	<div class="ecjia-margin-t ecjia-margin-b">
	    <input name="temp_key" type="hidden" value="{$temp_key}" />
		<input class="btn btn-info nopjax" name="submit" type="submit" value="{t}保存{/t}"/>
		<input name="address_id" type="hidden" value="{$info.id}" />
		<input name="referer_url" type="hidden" value="{$referer_url}" />
	</div>
	
	<input type="hidden" name="province_list" disabled value='{$region_data.province_list}' />
	<input type="hidden" name="city_list" disabled value='{$region_data.city_list}' />
	<input type="hidden" name="district_list" disabled value='{$region_data.district_list}' />
	<input type="hidden" name="street_list" disabled value='{$region_data.street_list}' />
	
	<input type="hidden" name="clear" disabled value='{$clear}' />
</form>
<!-- {/block} -->
{/nocache}