<?php
/*
Name: 页面二维码
Description: 这是页页面二维码
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="ecjia-wap-qrcode-container">
    <p class="example">{ecjia::config('shop_name')}</p>
    <div class="wap-qrcode-image" id="wap-qrcode"><img src="data:image/png;base64,{$ecjia_qrcode_image}" /></div>
    <p class="example">微信“扫一扫”浏览</p>
</div>
