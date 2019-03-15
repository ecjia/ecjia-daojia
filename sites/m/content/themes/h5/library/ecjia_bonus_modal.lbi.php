<?php
/*
Name: 添加红包弹出层
Description: 这是添加红包弹出层
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!--{nocache}-->
<div class="ecjia-normal-modal {$type}">
	{if $type eq 'success'}
	<div class="ecjia-normal-modal-content">
		<div class="title">{t domain="h5"}恭喜您！{/t}</div>
		<div class="title">{t domain="h5"}红包添加成功！{/t}</div>
		<div class="">
			<img src="{$theme_url}images/wallet/bonus_success.png" />
		</div>
		<a class="btn close-normal-btn success" href="javascript:;">{t domain="h5"}确认{/t}</a>	
	</div>
	{else if $type eq 'error'}
	<div class="ecjia-normal-modal-content">
		<div class="title">{t domain="h5"}您输入的号码有误，{/t}</div>
		<div class="title">{t domain="h5"}请核对后重新输入！{/t}</div>
		<div class="">
			<img src="{$theme_url}images/wallet/bonus_error.png" />
		</div>
		<a class="btn close-normal-btn" href="javascript:;">{t domain="h5"}重新输入{/t}</a>	
	</div>
	{else if $type eq 'bonus_info'}
	<div class="ecjia-normal-modal-content">
		<div class="bonus_title">{t domain="h5"}红包详情{/t}</div>
		<div class="bonus_item">
			<div class="left">{t domain="h5"}红包名称：{/t}</div>
			<div class="right">{$bonus_info.bonus_name}</div>
		</div>
		<div class="bonus_item">
			<div class="left">{t domain="h5"}红包金额：{/t}</div>
			<div class="right red_color">{$bonus_info.formatted_bonus_amount}</div>
		</div>
		<div class="bonus_item">
			<div class="left">{t domain="h5"}使用期限：{/t}</div>
			<div class="right red_color">{$bonus_info.formatted_start_date}-{$bonus_info.formatted_end_date}</div>
		</div>
		<div class="bonus_item new_line">
			<div class="left">{t domain="h5"}使用条件：{/t}</div>
			<div class="right">{$bonus_info.label_request_amount}</div>
		</div>
		<a class="btn confirm-add-btn nopjax external" href="javascript:;" data-href="{RC_Uri::url('user/bonus/add_bonus')}">{t domain="h5"}确认添加{/t}</a>
		<a class="btn close-normal-btn gray" href="javascript:;">{t domain="h5"}取消添加{/t}</a>
	</div>
	{/if}
</div>
<div class="ecjia-normal-modal-overlay"></div>
<!--{/nocache}-->