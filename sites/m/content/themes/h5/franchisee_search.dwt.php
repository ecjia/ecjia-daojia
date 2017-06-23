<?php
/*
Name: 收货地址列表模板
Description: 收货地址列表页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.franchisee.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-address-list">
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}images/user_center/f_mobile.png" width="30" height="30"></span>
			<input style="padding-left: 3.5em;" name="f_mobile" placeholder="{t}请输入手机号码 {/t}" type="tel"  />
		</label>
	</div>
	
	<div class="form-group form-group-text">
		<label class="input">
			<span class="ecjiaf-fl"><img src="{$theme_url}images/user_center/f_code.png" width="30" height="30"></span>
			<input style="padding-left: 3.5em;" name="f_code" placeholder="{t}请输入验证码{/t}" type="tel" />
			<input type="button" class="btn btn-small btn-info settled-message" value="{$lang.return_verification}" data-url="{url path='franchisee/index/validate' args='type=process'}" id="get_code" />
		</label>
	</div>
	
	<div class="ecjia-margin-t2 ecjia-margin-b">
		<input class="btn btn-info process_search" type="button" value="{t}查询{/t}" data-url="{$url}"/>
	</div>
	
</div>
<!-- {/block} -->