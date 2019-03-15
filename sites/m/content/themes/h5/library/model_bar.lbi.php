<?php
/*
Name: 底部导航
Description: 这是底部导航模块
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-mod ecjia-floor ecjia-bottom-bar-pannel o {$active}">
	<a class="index" href="{RC_Uri::url('touch/index/init')}">{t domain="h5"}首页{/t}</a>
	<a class="category" href="{RC_Uri::url('goods/category/init')}">{t domain="h5"}分类{/t}</a>
	<a class="discover" href="{RC_Uri::url('article/index/init')}">{t domain="h5"}发现{/t}</a>
	<a class="cartList" href="{RC_Uri::url('cart/index/init')}">{t domain="h5"}购物车{/t}</a>
	<a class="mine" href="{RC_Uri::url('touch/my/init')}">{t domain="h5"}我的{/t}</a>
</div>