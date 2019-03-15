<?php
/*
Name: 绑定手机模板
Description: 这是绑定手机页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" -->
<!-- #EndLibraryItem -->
<div class="ecjia-form ecjia-login">
	<div class="form-group margin-right-left">
		<label class="input">
			<span class="roaming">+86</span>
			<input placeholder='{t domain="h5"}手机号{/t}' name="mobile_phone" class="mobile_phone">
		</label>
	</div>
    <div class="around">
        <input type="button" class="btn btn-info login-btn" name="ecjia-mobile-login" value="确认" data-url="{url path='connect/index/mobile_login'}"/>
    </div>
</div>
<!-- {/block} -->
{/nocache}