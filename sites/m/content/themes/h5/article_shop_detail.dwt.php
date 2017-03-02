<?php
/*
Name: 网店信息页
Description: 网店信息页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<div class="ecjia-article article-info">
	<h2>{$title}</h2>
	<div class="article-img">
	   <img src="{$theme_url}images/user_center/750x80.png">
	</div>
	
	<div class="article-info-con">{$data}</div>
</div>
<!-- {/block} -->
