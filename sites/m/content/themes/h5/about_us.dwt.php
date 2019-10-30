<?php 
/*
Name: 关于我们页面
Description: 关于我们页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} --><!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-article m_p_0 about_us" id="ecjia-article">
	<ul class="list-one ecjia-list list-short">
		<div class="pf">
			<span>{t domain="mendian"}官方客服{/t}</span>
		</div>
		<li class="article-init border-top">
		<div class="form-group form-group-text">
			<a class="external nopjax" href="tel:{$shop_config.service_phone}">
			<span class="icon-name">{t domain="mendian"}官方客服{/t}</span>
			<span class="icon-long">{$shop_config.service_phone}</span>
			<i class="ecjiaf-fr iconfont icon-jiantou-right"></i>
			</a>
		</div>
		</li>
		<li class="article-init">
		<div class="form-group form-group-text">
			<a class="external nopjax" href="{$shop_config.site_url}" target="_blank">
			<span class="icon-name">{t domain="mendian"}官方网址{/t}</span>
			<span class="icon-long">{$shop_config.site_url}</span>
			<i class="ecjiaf-fr iconfont icon-jiantou-right"></i>
			</a>
		</div>
		</li>
	</ul>
	{if $shop}
	<ul class="list-one ecjia-list list-short border-top-none">
		<div class="pf">
			<span>{t domain="mendian"}公司信息{/t}</span>
		</div>
		<!-- {foreach from=$shop key=key item=value} 网店信息 -->
		<li class="article-init {if $key eq 0}border-top{/if}">
		<div class="form-group form-group-text">
			<a class="external" href="{RC_uri::url('article/shop/detail')}&title={$value.title}&article_id={$value.id}">
			<span>{$value.title}</span>
			<i class="ecjiaf-fr iconfont icon-jiantou-right"></i>
			</a>
		</div>
		</li>
		<!-- {/foreach} -->
	</ul>
	{/if}
</div>
<!-- {/block} -->