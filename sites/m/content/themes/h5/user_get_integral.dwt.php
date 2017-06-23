<?php
/*
Name: 赚积分
Description: 赚积分
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<div class="ecjia-spread ecjia-spread-get_integral">
    <div class="ecjia-margin-b ecjia-user-head">
    	<a href="{url path='user/index/spread'}">
            <div class="qrcode_image">
                <img src="{$theme_url}images/wallet/540x200_1.png">
            </div>
    	</a>
	</div>
    <div class="ecjia-margin-b">
    	<a href="{url path='touch/index/init'}">
            <div class="qrcode_image">
                <img src="{$theme_url}images/wallet/540x200_4.png">
            </div>
    	</a>
	</div>
    <div class="ecjia-margin-b">
    	<a href="{url path='user/order/order_list' args='type=allow_comment'}">
            <div class="qrcode_image">
                <img src="{$theme_url}images/wallet/540x200_5.png">
            </div>
    	</a>
	</div>
</div>
<!-- {/block} -->