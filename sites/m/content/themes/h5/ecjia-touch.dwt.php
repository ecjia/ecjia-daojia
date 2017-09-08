<?php
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {if not is_pjax()} -->
<!-- {if is_ajax()} -->
<!-- {block name="ajaxinfo"} --><!-- {/block} -->
<!-- {else} -->
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="format-detection" content="telephone=no" />
	<title>{$page_title}</title>
	<link href="{if ecjia::config('wap_logo')}{RC_Upload::upload_url(ecjia::config('wap_logo'))}{else}favicon.ico{/if}" rel="shortcut icon bookmark">
	<link href="{if ecjia::config('wap_logo')}{RC_Upload::upload_url(ecjia::config('wap_logo'))}{else}favicon.ico{/if}" rel="apple-touch-icon-precomposed">

	<!-- {block name="ready_meta"} --><!-- {/block} -->
	<link rel="stylesheet" href="{$theme_url}lib/bootstrap3/css/bootstrap.css">

	<link rel="stylesheet" href="{$theme_url}dist/css/iconfont.min.css">
	<link rel="stylesheet" href="{$theme_url}css/ecjia.touch.css">
	<link rel="stylesheet" href="{$theme_url}css/ecjia.touch.develop.css">
	<link rel="stylesheet" href="{$theme_url}css/ecjia.touch.b2b2c.css">
	<link rel="stylesheet" href="{$theme_url}css/ecjia_city.css">
	<link rel="stylesheet" href="{$theme_url}css/ecjia_help.css">
    <!-- 弹窗 -->
	<link rel="stylesheet" href="{$theme_url}css/ecjia.touch.models.css">
	<link rel="stylesheet" href="{$theme_url}dist/other/swiper.min.css">
    <link rel="stylesheet" href="{$theme_url}lib/datePicker/css/datePicker.min.css">
    <link rel="stylesheet" href="{$theme_url}lib/winderCheck/css/winderCheck.min.css">
    <!-- 图片预览 -->
    <link rel="stylesheet" href="{$theme_url}lib/photoswipe/css/photoswipe.css">
    <link rel="stylesheet" href="{$theme_url}lib/photoswipe/css/default-skin/default-skin.css">
    
	<!-- skin -->
	<link rel="stylesheet" href="{$theme_url}{$curr_style}">
	<link rel="stylesheet" href="{$theme_url}lib/iOSOverlay/css/iosOverlay.css">
</head>
<body>
	<div class="ecjia" id="get_location" data-url="{url path='location/index/get_location_msg'}">
		<input type="hidden" name="key" value="{$key}"/>
		<input type="hidden" name="referer" value="{$referer}"/>
		<input type="hidden" name="wxconfig_url" value="{url path='user/index/wxconfig'}"/>
		<!-- {block name="main-content"} --><!-- {/block} -->
		<!-- #BeginLibraryItem "/library/page_menu.lbi" --><!-- #EndLibraryItem -->
	</div>
	<!-- {block name="ready_footer"} --><!-- {/block} -->
	<script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&libraries=convertor"></script>
	<script type="text/javascript" src="{$theme_url}lib/jquery/jquery.min.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/multi-select/js/jquery.quicksearch.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/jquery/jquery.pjax.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/jquery/jquery.cookie.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/iscroll/js/iscroll.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/bootstrap3/js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/ecjiaUI/ecjia.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/jquery-form/jquery.form.min.js" ></script>	
	<script type="text/javascript" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
	
	<script type="text/javascript" src="{$theme_url}lib/jquery-localstorage/jquery.localstorage.js" ></script>	
	<!-- 图片预览 -->
	<script type="text/javascript" src="{$theme_url}lib/photoswipe/js/photoswipe.min.js"></script>
	<script type="text/javascript" src="{$theme_url}lib/photoswipe/js/photoswipe-ui-default.min.js"></script>

	<!-- {block name="meta"} --><!-- {/block} -->
	<script type="text/javascript" src="{$theme_url}js/ecjia.touch.koala.js" ></script>
	<script type="text/javascript" src="{$theme_url}js/ecjia.touch.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.others.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.goods.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.user.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.flow.js" ></script>

    <script type="text/javascript">var theme_url = "{$theme_url}";</script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.goods_detail.js" ></script>
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>
 	<script type="text/javascript" src="{$theme_url}js/ecjia.touch.spread.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.user_account.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.franchisee.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.comment.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.raty.js" ></script>
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.fly.js" ></script>
    <!-- 弹窗 -->
    <script type="text/javascript" src="{$theme_url}js/ecjia.touch.intro.min.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/Validform/Validform_v5.3.2_min.js"></script>

	<script type="text/javascript" src="{$theme_url}lib/swiper/js/swiper.min.js"></script>
    <script type="text/javascript" src="{$theme_url}lib/datePicker/js/datePicker.min.js"></script>
    <script type="text/javascript" src="{$theme_url}lib/winderCheck/js/winderCheck.min.js"></script>
    <script type="text/javascript" src="{$theme_url}js/greenCheck.js"></script>
    
    <script type="text/javascript" src="{$theme_url}lib/iOSOverlay/js/iosOverlay.js"></script>
    <script type="text/javascript" src="{$theme_url}lib/iOSOverlay/js/prettify.js"></script>
	<!-- {block name="footer"} --><!-- {/block} -->
	<script type="text/javascript">
    	window.onunload = unload;
    	function unload (e){
    	  window.scrollTo(0,0);
    	}
	</script>
	<script type="text/javascript">
		var hidenav = {if $hidenav eq 1}1{else}0{/if}, hidetab = {if $hidetab eq 1}1{else}0{/if}, hideinfo = {if $hideinfo}1{else}0{/if};
		if (hideinfo) {
			$('header').hide();
			$('footer').hide();
			$('.ecjia-menu').hide();
		} else {
			hidenav && $('header').hide();
			hidetab && $('footer').hide();
		}
	</script>
</body>
</html>
<!-- {/if} -->
<!-- {else} -->
<title>{block name="title"}{$page_title}{/block}</title>
<!-- {block name="meta"} --><!-- {/block} -->
<input type="hidden" name="wxconfig_url" value="{url path='user/index/wxconfig'}"/>
<!-- {block name="main-content"} --><!-- {/block} -->
<!-- #BeginLibraryItem "/library/page_menu.lbi" --><!-- #EndLibraryItem -->
<!-- {block name="footer"} --><!-- {/block} -->
<!-- {/if} -->