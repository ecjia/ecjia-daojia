<?php 
/*
Name: 发现页
Description: 帮助发现首页
Libraries: model_bar
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.index.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->

<div class="ecjia-discover clearfix pb_50">
	<div class="ecjia-discover-icon">
		<div class="swiper-container" id="swiper-discover-icon">
			<div class="swiper-wrapper">
				<div class="swiper-slide"><a href="{RC_Uri::url('mobile/discover/init')}"><img src="{$theme_url}images/discover/75_2.png" /><span>百宝箱</span></a></div>
				<div class="swiper-slide"><a href="{$signup_reward_url}"><img src="{$theme_url}images/discover/75_3.png" /><span>新人有礼</span></a></div>
				<div class="swiper-slide"><a href="{RC_Uri::url('user/index/spread')}"><img src="{$theme_url}images/discover/75_4.png" /><span>推广</span></a></div>
				<div class="swiper-slide"><a href="{RC_Uri::url('goods/index/new')}"><img src="{$theme_url}images/discover/75_5.png" /><span>新品推荐</span></a></div>
				<div class="swiper-slide"><a href="{RC_Uri::url('goods/index/promotion')}"><img src="{$theme_url}images/discover/75_6.png" /><span>促销商品</span></a></div>
			</div>
		</div>
	</div>
	
	<!-- {if $cycleimage} -->
	<div class="ecjia-discover-cycleimage">
		<div class="swiper-container" id="swiper-discover-cycleimage">
			<div class="swiper-wrapper">
				<!--{foreach from=$cycleimage item=img}-->
				<div class="swiper-slide"><a href="{$img.url}"><img src="{$img.photo.url}" /></a></div>
				<!--{/foreach}-->
			</div>
			<div class="swiper-pagination"></div>
		</div>
	</div>
	<!-- {/if} -->
	
	<div class="ecjia-discover-article">
		<div class="swiper-container" id="swiper-article-cat">
			<div class="swiper-wrapper">
				<div class="swiper-slide active" data-url="{url path='article/index/ajax_article_list'}&action_type=stickie" data-type="stickie">精选</div>
				<!-- {foreach from=$article_cat item=cat key=key} -->
				<div class="swiper-slide" data-url="{url path='article/index/ajax_article_list'}&action_type={$cat.cat_id}" data-type="{$cat.cat_id}">{$cat.cat_name}</div>
				<!-- {/foreach} -->
			</div>
		</div>
		<div class="article-add"><i class="iconfont icon-jiantou-bottom"></i></div>
		
		<div class="ecjia-down-navi clearfix"> 
			<ul class="navi-list">
				<li class="navi active" data-id="stickie"><p class="navi-name">精选</p></li>
				<!-- {foreach from=$article_cat item=cat key=key} -->
				<li class="navi" data-id="{$cat.cat_id}"><p class="navi-name">{$cat.cat_name}</p></li>
				<!-- {/foreach} -->
			</ul>
		</div>
	</div>
	
	<div class="article-container" id="article-container">
		<ul class="ecjia-article article-list" id="discover-article-list" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='article/index/ajax_article_list'}" data-type="stickie" data-color="#f7f7f7">
		</ul>
	</div>
	<!-- #BeginLibraryItem "/library/model_bar.lbi" --><!-- #EndLibraryItem -->
</div>

<!-- {/block} -->
{nocache}