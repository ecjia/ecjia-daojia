<?php
/*
Name: 底部导航
Description: 这是底部导航模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-mod ecjia-floor ecjia-bottom-bar-pannel o {$active}">
	<a class="index" href="{RC_Uri::url('touch/index/init')}">首页</a>
	<a class="category" href="{RC_Uri::url('goods/category/init')}">分类</a>
	<a class="discover" href="{RC_Uri::url('article/index/init')}">发现</a>
	<a class="cartList" href="{RC_Uri::url('cart/index/init')}">购物车</a>
	<a class="mine" href="{RC_Uri::url('touch/my/init')}">我的</a>
</div>