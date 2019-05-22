<?php
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {if not is_pjax()} -->
<!DOCTYPE html>
<html lang="zh-CN">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui, viewport-fit=cover">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="format-detection" content="telephone=no" />
		<title>{$page_title}</title>
		<link href="{if ecjia::config('wap_logo')}{RC_Upload::upload_url(ecjia::config('wap_logo'))}{else}favicon.ico{/if}" rel="shortcut icon bookmark">
		<link href="{if ecjia::config('wap_logo')}{RC_Upload::upload_url(ecjia::config('wap_logo'))}{else}favicon.ico{/if}" rel="apple-touch-icon-precomposed">
	    <!-- {ecjia:hook id=front_enqueue_scripts} -->
	    <!-- {ecjia:hook id=front_print_styles} -->
	    <!-- {ecjia:hook id=front_print_scripts} -->
	    <!-- {block name="ready_meta"} --><!-- {/block} -->
	    <!-- {block name="meta"} --><!-- {/block} -->
		<!-- {ecjia:hook id=front_head} -->
        <script charset="utf-8" src="{ecjia_location_mapjs('convertor')}"></script>
        <script type="text/javascript">var theme_url = "{$theme_url}";</script>
		<script type="text/javascript" src="https://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
	</head>
	<body>
		<div class="ecjia" id="get_location" data-url="{url path='touch/location/get_location_msg'}">
			<input type="hidden" name="key" value="{$key}"/>
			<input type="hidden" name="referer" value="{$referer}"/>
			<!-- {block name="main-content"} --><!-- {/block} -->
			<!-- #BeginLibraryItem "/library/page_menu.lbi" --><!-- #EndLibraryItem -->
			<!--{if $ecjia_qrcode_image}-->
			<!-- #BeginLibraryItem "/library/page_qrcode.lbi" --><!-- #EndLibraryItem -->
			<!--{/if}-->
		</div>

	    <!-- {ecjia:hook id=front_print_footer_scripts} -->
	    <!-- {block name="ready_footer"} --><!-- {/block} -->
	    <!-- {block name="footer"} --><!-- {/block} -->
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
<!-- {else} -->
<title>{block name="title"}{$page_title}{/block}</title>
<!-- {block name="meta"} --><!-- {/block} -->
<!-- {block name="main-content"} --><!-- {/block} -->
<!-- #BeginLibraryItem "/library/page_menu.lbi" --><!-- #EndLibraryItem -->
<!--{if $ecjia_qrcode_image}-->
<!-- #BeginLibraryItem "/library/page_qrcode.lbi" --><!-- #EndLibraryItem -->
<!--{/if}-->
<!-- {block name="footer"} --><!-- {/block} -->
<!-- {/if} -->
{/nocache}