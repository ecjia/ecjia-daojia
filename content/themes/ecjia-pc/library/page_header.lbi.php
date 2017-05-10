<?php 
/*
 Name: PC端公用头部模块
 Description: 这是PC端公用头部模块
 */
defined('IN_ECJIA') or exit('No permission resources.');
?> 

<div class="ecjia-header fixed">
	<div class="ecjia-content">
		<div class="ecjia-fl ecjia-logo">
			<a href="{RC_Uri::home_url()}"><img class="wt-10" src="{if $info.shop_logo}{$info.shop_logo}{else}{$theme_url}images/shop_logo.png{/if}"></a>
			<div class="select-location">
				<i class="icon-position"></i>
				<span class="current-position">{$info.city_name}</span>
				<span class="choose-city">切换城市</span>
			</div>
		</div>
		<div class="ecjia-fl search" data-url="{RC_Uri::url('main/index/search')}">
			<input type="text" placeholder="搜索商品名称或商家" name="keywords" value="{$smarty.get.keywords}" autocomplete="off"/>
			<button class="button search-button" data-url="{RC_Uri::url('goods/index/init')}"><i class="iconfont"></i></button>
			<ul class="shelper"></ul>
		</div>
		<div class="ecjia-fr">
			<ul class="nav">
				<li {if $active eq 'main'}class="active"{/if}><a href="{RC_Uri::home_url()}">首页</a></li>
				<li {if $active eq 'category'}class="active"{/if}><a class="merchant-list" href="{RC_Uri::url('merchant/store/category')}">商家</a></li>
				<li><a class="nopjax" href="{RC_Uri::site_url('/sites/app/')}">下载APP</a></li>
				<li><a class="nopjax" href="{$info.merchant_url}" target="_blank">商家入驻</a></li>
				<li><a class="nopjax ecjia-back-green" href="{$info.merchant_login}" target="_blank">商家登录</a></li>
			</ul>
		</div>
	</div>
</div>

