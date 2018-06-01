<?php
/*
Name: 城市模板
Description: 选择城市模板
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.select_city();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
{if $smarty.cookies.position_city_name}
<div class="location-city">
	<h2 class="location-city-title"><span>当前定位城市</span></h2>
	<div class="location-city-container">
		<i class="icon-position"></i><span class="select-city-li" data-id="{$smarty.cookies.position_city_id}">{$smarty.cookies.position_city_name}</span>
	</div>
</div>
{/if}

{if $smarty.get.type eq 'addcity'}
<div class="cityall" id="cityall" data-url='{url path="user/address/add_address" args="{if $referer_url}&referer_url={$referer_url|escape:"url"}{/if}"}'>
{else if $smarty.get.type eq 'editcity'}
<div class="cityall" id="cityall" data-url="{url path='user/address/edit_address'}">
{else if $smarty.get.type eq 'search'}
<div class="cityall" id="cityall" data-url="{url path='location/index/select_location'}">
{else}
<div class="cityall" id="cityall" data-url="{url path='location/index/select_location'}">
{/if}
	<input type="hidden" name="address_id" value="{$smarty.get.address_id}">

	<div class="ecjia-history-city">
		
	</div>

	{if $rs}
	<div class="ecjia-select-city">
		<!--显示点击的是哪一个字母-->
		<div id="showLetter" class="showLetter"><span>A</span></div>
		<!--城市索引查询-->
		<div class="letter">
			<ul>
				<li><a href="javascript:;" data-top="top">定位</a></li>
				<!--{foreach from=$rs key=key item=val}-->
				<li><a href="javascript:;">{$key}</a></li>
				<!--{/foreach}-->
			</ul>
		</div>

		<!--城市列表-->
		<div class="city-container">
			<div class="city-list">
                <!--{foreach from=$rs key=key item=val}-->
				<div class="city-item">
					<span class="city-letter" id="{$key}1">{$key}</span>
                    <!--{foreach from=$val item=v}-->
					<div class="city-li"><p class="select-city-li" data-id="{$v.business_city}">{$v.business_city_alias}</p></div>
                    <!--{/foreach}-->
				</div>
                <!--{/foreach}-->
			</div>
		</div>
	</div>
	{/if}

</div>
<!-- {/block} -->