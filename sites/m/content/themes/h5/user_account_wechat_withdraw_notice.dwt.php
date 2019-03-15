<?php
/*
Name: 账户提现模板
Description: 账户提现页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript" >
	ecjia.touch.user_account.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-user t_c ecjia-withdraw-notice">
	<img src="{$theme_url}images/user_center/apply.png" />
	<p class="green">{t domain="h5"}申请提交成功{/t}</p>
	<p>{t domain="h5"}我们将3-5工作日审核，请您耐心等待{/t}</p>
	<p>{t domain="h5"}如有疑问，请联系客服{/t}</p>
	<p>{ecjia::config('service_phone')}</p>
</div>

<div class="text-center">
	<a class="btn btn-info ecjia-withdraw-notice-btn fnUrlReplace" data-url="{RC_Uri::url('user/account/balance')}" href="javascript:;">{t domain="h5"}完成{/t}</a>
</div>
<!-- {/block} -->
