<?php
/*
Name: 查询审核进度 输入图形验证码
Description: 输入图形验证码页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {nocache} -->
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.franchisee.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-address-list">
	<div class="franchisee-search-title ecjia-margin-t">{t domain="h5"}身份验证，请输入图中验证码{/t}</div>
	
	<div class="franchisee-img-captcha"><img src="data:image/png;base64,{$image}" ></div>
	<p class="franchisee-captcha-refresh" data-url="{url path='franchisee/index/captcha_refresh'}">{t domain="h5"}看不清，换一张{/t}</p>

	<div class="franchisee-input-captcha">
		<input class="input-captcha" name="f_code" placeholder='{t domain="h5"}请输入图形验证码 {/t}' type="text" /><br>
		
	</div>
	<div class="ecjia-margin-t2 ecjia-margin-b">
		<input class="btn btn-info process_search" type="button" value='{t domain="h5"}下一步{/t}' data-url="{$url}"/>
	</div>
</div>
<!-- {/block} -->
<!-- {/nocache} -->