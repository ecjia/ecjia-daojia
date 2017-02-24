<?php
/*
Name: 悬浮导航
Description: 这是页面中的悬浮导航菜单
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {if $hidenav neq 1 && $hidetab neq 1} -->
<div class="ecjia-menu" id="ecjia-menu">
	<ul>
		<li><a href="{url path='touch/index/init'}"><i class="iconfont icon-home"></i></a></li>
		<li><a href="{url path='touch/index/search'}"><i class="iconfont icon-search"></i></a></li>
		<li><a href="{url path='cart/index/init'}"><i class="iconfont icon-gouwuche"></i></a></li>
		<li><a href="{url path='touch/my/init'}"><i class="iconfont icon-gerenzhongxin"></i></a></li>
		<li><a href="javascript:;"><i class="iconfont icon-top"></i></a></li>
	</ul>
	<div class="main"><a class="nopjax" href="javascript:;"><i class="iconfont icon-add"></i></a></div>
</div>
<!-- {/if} -->
