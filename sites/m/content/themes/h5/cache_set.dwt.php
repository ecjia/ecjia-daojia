<?php 
/*
Name: 缓存设置页面
Description: 缓存设置页面
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-article m_p_0" id="ecjia-article">
	<ul class="list-one user-address-list ecjia-list list-short">
		<div class="pf"><span>{t domain="h5"}缓存设置{/t}</span></div>
		<li class="article-init border-top">
			<div class="form-group form-group-text">
				<a class="external clear_cache" data-url='{url path="touch/index/clear_cache"}' data-message='{t domain="h5"}清除缓存后您将退出登录，确定清除缓存？{/t}'>
					<span>{t domain="h5"}清除本地缓存{/t}</span>
					<i class="ecjiaf-fr iconfont icon-jiantou-right"></i>
				</a>
			</div>
		</li>
	</ul>
</div>
<!-- {/block} -->