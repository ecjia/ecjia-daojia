<?php
/*
Name: PC端选择城市弹窗
Description: 这是PC端的选择城市弹窗
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<div class="choose-city-div">
	<div class="city-content">
		<div class="header">
			<div class="title">选择城市</div>
			<span class="close_div">X</span>
		</div>
		<div class="content">
			{if $info.location_address}
			<div class="content-position">
				<div class="guess-position">当前定位城市</div>
				<div class="position">
					<li class="position-li select-city-li active" data-id="{$info.location_id}"><i class="icon-position"></i>{$info.location_address}</i>
				</div>
			</div>
			{/if}
			
			<div class="ecjia-history-city"></div>

			{if $info.region_list}
			<div class="ecjia-select-city">
				<!--显示点击的是哪一个字母-->
				<div id="showLetter" class="showLetter"><span>A</span></div>
				<!--城市列表-->
				<div class="city-container">
					<div class="city-list">
		                <!--{foreach from=$info.region_list key=key item=val}-->
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
		<!--城市索引查询-->
		<div class="letter">
			<ul>
				{if $info.location_address}
				<li><a href="javascript:;" data-top="top">定位</a></li>
				{/if}
				<!--{foreach from=$info.region_list key=key item=val}-->
				<li><a href="javascript:;">{$key}</a></li>
				<!--{/foreach}-->
			</ul>
		</div>
	</div>
</div>
<div class="choose-city-overlay"></div>
{/nocache}
