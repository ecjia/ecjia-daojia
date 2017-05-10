<?php
/*
Name: 底部下载
Description: 这是底部下载弹出层
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{if !$close_download && $download_app_switch}
<div class="ecjia-download">
	<a class="btn_install" href="{$down_url}"><img src="{$app_download_img}"></a>
	<a class="close_tip"></a>
	<iframe name="openapp" style="display:none"></iframe>
</div>
{/if}