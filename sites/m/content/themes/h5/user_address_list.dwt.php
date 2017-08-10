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
<script type="text/javascript">ecjia.touch.delete_list_click();</script>
<script type="text/javascript">
$('.setdefault').click(function(){
	var data_id = $(this).attr('data-id');
    var url = $("input[name='setdefault_url']").val();
    $.get(url, {
		id: data_id
	}, function(data) {
		ecjia.touch.showmessage(data);
	}, 'json');
});

$.localStorage('address_title', '个人中心');
$.localStorage('address_url', "{RC_Uri::url('touch/my/init')}");
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-address-list">
	<div class="nav-header">
		<a href="{url path='user/address/add_address' args='clear=1'}">
			<i class="icon-add-address"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{t}新建收货地址{/t}
			<span class="ecjiaf-fr"><i class="iconfont icon-jiantou-right"></i></span>
		</a>
	</div>
	<section>
		<input type="hidden" name="setdefault_url" value="{RC_uri::url('user/address/set_default')}">
		<!-- {if $address_list} -->
		{if $type eq 'choose'}
		<ul class="ecjia-list list-one ecjia-margin-b" id="J_ItemList">
			<!-- 配送地址 start-->
			<!-- {foreach from=$address_list.local item=value}-->
			<li class="ecjia-margin-t">
				<a class="choose_address" data-toggle="choose_address" href="{RC_Uri::url('user/address/choose_address')}&address_id={$value.id}&type=choose" data-referer="{$referer_url}&address_id={$value.id}">
					<div class="ecjia-of-h">
						<p class="ecjiaf-fl ecjia-mw6">{$value.consignee}</p>
						<p class="ecjiaf-fl ecjia-margin-l ecjia-address-mobile">{$value.mobile}</p>
					</div>
					<div class="address ecjiaf-wwb">{$value.province_name} {$value.city_name} {$value.address} {$value.address_info}</div>
				</a>
				<hr />
				<!-- {if $value.default_address eq 1} -->
				<p class="ecjiaf-fl"><i class="icon-is-default"></i>&nbsp;&nbsp;{t}设为默认{/t}</p>
				<!-- {else} -->
				<p class="setdefault ecjiaf-csp ecjiaf-fl" data-id="{$value.id}"><i class="icon-not-default"></i>&nbsp;&nbsp;{t}设为默认{/t}</p>
				<!-- {/if} -->
				<a class="delete-address nopjax ecjiaf-fr ecjia-margin-l external" href="javascript:;" data-toggle="del_list" data-url="{url path='user/address/del_address'}" data-id="{$value.id}" data-msg="{t}您确定要删除此收货地址吗？{/t}"><div class="icon-delete-address"></div>{t}删除{/t}</a>
				<a class="edit-address ecjiaf-fr" href="{RC_uri::url('user/address/edit_address')}&id={$value.id}&clear=1"><div class="icon-edit-address"></div>{t}编辑{/t}</a>
			</li>
			<!-- {/foreach} -->
			<!-- 配送地址end-->
		</ul>
		
		<!-- {if $address_list.other} -->
		<ul class="ecjia-list list-one ecjia-margin-b over" id="J_ItemList">
			<p class="m3">* 以下地址超出配送范围</p>
			<!-- 配送地址 start-->
			<!-- {foreach from=$address_list.other item=value key=key}-->
			<li class="ecjia-margin-t">
				<a class="choose_address" data-toggle="choose_address">
					<div class="ecjia-of-h">
						<p class="ecjiaf-fl ecjia-mw6">{$value.consignee}</p>
						<p class="ecjiaf-fl ecjia-margin-l ecjia-address-mobile">{$value.mobile}</p>
					</div>
					<div class="address ecjiaf-wwb">{$value.province_name} {$value.city_name} {$value.address} {$value.address_info}</div>
				</a>
				<hr />
				<!-- {if $value.default_address eq 1} -->
				<p class="ecjiaf-fl"><i class="icon-is-default"></i>&nbsp;&nbsp;{t}设为默认{/t}</p>
				<!-- {else} -->
				<p class="ecjiaf-csp ecjiaf-fl" data-id="{$value.id}"><i class="icon-not-default"></i>&nbsp;&nbsp;{t}设为默认{/t}</p>
				<!-- {/if} -->
				<a class="delete-address nopjax ecjiaf-fr ecjia-margin-l external" href="javascript:;" data-toggle="del_list" data-url="{url path='user/address/del_address'}" data-id="{$value.id}" data-msg="{t}您确定要删除此收货地址吗？{/t}"><div class="icon-delete-address"></div>{t}删除{/t}</a>
				<a class="edit-address ecjiaf-fr" href="{RC_uri::url('user/address/edit_address')}&id={$value.id}&clear=1"><div class="icon-edit-address"></div>{t}编辑{/t}</a>
			</li>
			<!-- {/foreach} -->
			<!-- 配送地址end-->
		</ul>
		<!-- {/if} -->
		
		{else}
		<ul class="ecjia-list list-one ecjia-margin-b" id="J_ItemList">
			<!-- 配送地址 start-->
			<!-- {foreach from=$address_list item=value}-->
			<li class="ecjia-margin-t">
				<div class="ecjia-of-h">
					<p class="ecjiaf-fl ecjia-mw6">{$value.consignee}</p>
					<p class="ecjiaf-fl ecjia-margin-l ecjia-address-mobile">{$value.mobile}</p>
				</div>
				<div class="address ecjiaf-wwb">{$value.province_name} {$value.city_name} {$value.address} {$value.address_info}</div>
				<hr />
				<!-- {if $value.default_address eq 1} -->
				<p class="ecjiaf-fl"><i class="icon-is-default"></i>&nbsp;&nbsp;{t}设为默认{/t}</p>
				<!-- {else} -->
				<p class="setdefault ecjiaf-csp ecjiaf-fl" data-id="{$value.id}"><i class="icon-not-default"></i>&nbsp;&nbsp;{t}设为默认{/t}</p>
				<!-- {/if} -->
				<a class="delete-address nopjax ecjiaf-fr ecjia-margin-l external" href="javascript:;" data-toggle="del_list" data-url="{url path='user/address/del_address'}" data-id="{$value.id}" data-msg="{t}您确定要删除此收货地址吗？{/t}"><div class="icon-delete-address"></div>{t}删除{/t}</a>
				<a class="edit-address ecjiaf-fr" href="{RC_uri::url('user/address/edit_address')}&id={$value.id}&clear=1"><div class="icon-edit-address"></div>{t}编辑{/t}</a>
			</li>
			<!-- {/foreach} -->
			<!-- 配送地址end-->
		</ul>		
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
</div>
<!-- {/block} -->
{/nocache}