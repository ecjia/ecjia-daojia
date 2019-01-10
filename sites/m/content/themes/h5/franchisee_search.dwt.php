<?php
/*
Name: 收货地址列表模板
Description: 收货地址列表页
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
	<div class="franchisee-search-title ecjia-margin-t">输入手机号</div>

	<div class="franchisee-search-input">
		<input name="f_mobile" placeholder="{t}请输入手机号码 {/t}" type="tel" />
	</div>
	<div class="ecjia-margin-t2 ecjia-margin-b">
		<input class="btn btn-info process_search" type="button" value="下一步" data-url="{$url}"/>
	</div>
</div>
<!-- {/block} -->
<!-- {/nocache} -->