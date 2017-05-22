<?php
/*
Name:  查看绑定手机号
Description:  查看绑定手机号
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">ecjia.touch.user.init();</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
{if $type eq 'mobile'}
<div class="ecjia-check-info">
    <div class="bind-info">
        <p>已绑：{$user.mobile_phone}</p>
    </div>
    <div>
    	<a class="btn btn-info nopjax external" href="{RC_uri::url('user/profile/account_bind')}&type=mobile&status=change">更换手机号</a>
    </div>
</div>
{elseif $type eq 'email'}
<div class="ecjia-check-info">
    <div class="bind-info">
        <p>已绑：{$user.email}</p>
    </div>

    <div>
    	<a class="btn btn-info nopjax external" href="{RC_uri::url('user/profile/account_bind')}&type=email&status=change">更换邮箱号</a>
    </div>
</div>
{/if}
<!-- {/block} -->