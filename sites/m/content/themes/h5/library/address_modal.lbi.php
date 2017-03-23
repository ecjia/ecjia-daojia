<?php
/*
Name: 选择地址
Description: 这是选择地址弹窗
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>

<div class="ecjia-modal">
	<div class="modal-inner">
		<div class="modal-title"><i class="position"></i>您当前使用的地址是：</div>
		<div class="modal-text">{$smarty.cookies.location_name}</div>
	</div>
	<div class="modal-buttons modal-buttons-2 modal-buttons-vertical">
		<a href="{RC_Uri::url('user/address/add_address')}&clear=1{if $smarty.cookies.location_address}&addr={$smarty.cookies.location_name}{/if}{if $referer_url}&referer_url={$referer_url}{/if}"><span class="modal-button" style="border-radius: 0;"><span class="create_address">新建收货地址</span></span></a>
		<a href="{RC_Uri::url('location/index/select_location')}{if $referer_url}&referer_url={$referer_url}{/if}"><span class="modal-button"><span class="edit_address">更换地址</span></span></a>
	</div>
</div>
<div class="ecjia-modal-overlay ecjia-modal-overlay-visible"></div>