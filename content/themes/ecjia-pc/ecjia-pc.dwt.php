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
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{$page_title}</title>
	<meta name="keywords" content="{$pc_keywords}" />
	<meta name="description" content="{$pc_description}" />
	<link href="{if ecjia_config::has('wap_logo')}{RC_Upload::upload_url(ecjia::config('wap_logo'))}{else}favicon.ico{/if}" rel="shortcut icon bookmark">
	<!-- {block name="ready_meta"} --><!-- {/block} -->
	<link rel="stylesheet" href="{$theme_url}lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="{$theme_url}fonts/iconfont.min.css">
	<link rel="stylesheet" href="{$theme_url}css/style.css">
	<link rel="stylesheet" href="{$theme_url}lib/swiper/css/swiper.min.css">
</head>
<body>
	<div class="main_content">
	<!-- {block name="main-content"} --><!-- {/block} -->
	</div>
	<!-- {block name="ready_footer"} --><!-- {/block} -->
	<script type="text/javascript" src="{$theme_url}lib/jquery/jquery.min.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/jquery/jquery.pjax.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/jquery/jquery.cookie.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/ecjiaUI/ecjia.js" ></script>
	<script type="text/javascript" src="{$theme_url}lib/swiper/js/swiper.min.js"></script>
	 <script type="text/javascript">var theme_url = "{$theme_url}";</script>
	 
	<!-- {block name="meta"} --><!-- {/block} -->
	<script type="text/javascript" src="{$theme_url}js/ecjia.pc.raty.js" ></script>
	<script type="text/javascript" src="{$theme_url}js/ecjia.pc.koala.js" ></script>
	<script type="text/javascript" src="{$theme_url}js/ecjia.pc.js" ></script>
	<!-- {block name="footer"} --><!-- {/block} -->
</body>
</html>
<!-- {/if} -->
<!-- {else} -->
<title>{block name="title"}{$page_title}{/block}</title>
<!-- {block name="meta"} --><!-- {/block} -->
<!-- {block name="main-content"} --><!-- {/block} -->
<!-- {block name="footer"} --><!-- {/block} -->
<!-- {/if} -->