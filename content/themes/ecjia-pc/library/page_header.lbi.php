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
				<span class="choose-city">{t domain="ecjia-pc"}切换位置{/t}</span>
			</div>
		</div>
		<div class="ecjia-fl search" data-url="{RC_Uri::url('main/index/search')}">
			<input type="text" placeholder='{t domain="ecjia-pc"}搜索商品名称或商家{/t}' name="keywords" value="{$smarty.get.keywords}" autocomplete="off"/>
			<button class="button search-button" data-url="{RC_Uri::url('goods/index/init')}"><i class="iconfont"></i></button>
			<ul class="shelper"></ul>
		</div>
		<div class="ecjia-fr">
			<ul class="nav">
				<li {if $active eq 'main'}class="active"{/if}><a href="{RC_Uri::home_url()}">{t domain="ecjia-pc"}首页{/t}</a></li>
				<li {if $active eq 'category'}class="active"{/if}><a class="merchant-list" href="{RC_Uri::url('merchant/store/category')}">{t domain="ecjia-pc"}商家{/t}</a></li>
				<li><a class="nopjax" href="{RC_Uri::site_url('/sites/app/')}" target="_blank">{t domain="ecjia-pc"}下载APP{/t}</a></li>	
				{if ecjia::config('pc_enabled_member')}<li><a class="nopjax" href="{RC_Uri::site_url('/sites/member/')}" target="_blank">{t domain="ecjia-pc"}会员中心{/t}</a></li>{/if}
				{if ecjia::config('merchant_join_close') eq 0}
				<li><a class="nopjax" href="{$info.merchant_url}" target="_blank">{t domain="ecjia-pc"}商家入驻{/t}</a></li>
				{/if}
				<li><a class="nopjax ecjia-back-green" href="{$info.merchant_login}" target="_blank">{t domain="ecjia-pc"}商家登录{/t}</a></li>
			</ul>
		</div>
	</div>
</div>

