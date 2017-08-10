<?php
/*
Name: 选择收货地址列表模板
Description: 选择收货地址列表页
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.delete_list_click();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-address-list p_t0">
	<section class="m_b5">
		<!-- {if $address_list} -->
		{if $type eq 'choose'}
		<ul class="ecjia-list list-one ecjia-margin-b" id="J_ItemList">
			<!-- 配送地址 start-->
			<!-- {foreach from=$address_list.local item=value}-->
			<li class="ecjia-margin-t choose_address-list m_t0">
				<a class="choose_address" data-toggle="choose_address" href="{RC_Uri::url('user/address/choose_address')}&address_id={$value.id}&type=choose" data-referer="{$referer_url}&address_id={$value.id}">
					<i class="{if $smarty.session.order_address_temp.address_id eq $value.id}icon-default{else}icon-not-default{/if}"></i>
					<div class="ecjia-address-info">
						<div class="ecjia-of-h">
							{if $value.default_address eq 1}<span class="deafult-span">默认</span>{/if}
							<p class="ecjiaf-fl ecjia-mxw6">{$value.consignee}</p>
							<p class="ecjiaf-fl ecjia-margin-l ecjia-address-mobile">{$value.mobile}</p>
						</div>
						<div class="address ecjiaf-wwb">{$value.province_name} {$value.city_name} {$value.address} {$value.address_info}</div>
					</div>
				</a>
				<a class="edit-address ecjiaf-fr" href="{RC_uri::url('user/address/edit_address')}&id={$value.id}&clear=1"><div class="icon-edit-address"></div></a>
			</li>
			<!-- {/foreach} -->
			<!-- 配送地址end-->
		</ul>
		
		<!-- {if $address_list.other} -->
		<ul class="ecjia-list list-one ecjia-margin-b over" id="J_ItemList">
			<p class="m3">* 以下地址超出配送范围</p>
			<!-- 配送地址 start-->
			<!-- {foreach from=$address_list.other item=value key=key}-->
			<li class="ecjia-margin-t choose_address-list">
				<a class="choose_address" data-toggle="choose_address">
					<i class="{if $smarty.session.order_address_temp.address_id eq $value.id}icon-default{else}icon-not-default{/if}"></i>
					<div class="ecjia-address-info">
						<div class="ecjia-of-h">
							{if $value.default_address eq 1}<span class="deafult-span">默认</span>{/if}
							<p class="ecjiaf-fl ecjia-mxw6">{$value.consignee}</p>
							<p class="ecjiaf-fl ecjia-margin-l ecjia-address-mobile">{$value.mobile}</p>
						</div>
						<div class="address ecjiaf-wwb">{$value.province_name} {$value.city_name} {$value.address} {$value.address_info}</div>
					</div>
				</a>
				<a class="edit-address ecjiaf-fr" href="{RC_uri::url('user/address/edit_address')}&id={$value.id}&clear=1"><div class="icon-edit-address"></div></a>
			</li>
			<!-- {/foreach} -->
			<!-- 配送地址end-->
		</ul>
		<!-- {/if} -->
		{/if}
		
		<!-- {else} -->
		<div class="ecjia-margin-t">
			<div class="ecjia-nolist">
				<p><img src="{$theme_url}images/wallet/null280.png"></p>
				暂无收货地址，请添加
			</div>
		</div>
		<!-- {/if} -->
	</section>
	
	<section class="ecjia-margin-t jm">
		<a class="btn" href="{url path='user/address/add_address' args='clear=1'}"><img src="{$theme_url}images/address_list/50x50_7.png">新建收货地址</a>
	</section>
</div>
<!-- {/block} -->
{/nocache}