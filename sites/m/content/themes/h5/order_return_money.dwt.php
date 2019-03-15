<?php
/*
Name: 退款详情模板
Description: 这是退款详情页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="return-status-content">
	<ul class="aam">
		<li>{t domain="h5"}退回金额{/t}<span class="aan ecjia-red">{$data.format_back_amount}</span></li>
		<li>{t domain="h5"}退回账户{/t}<span class="aan">{$data.back_account}</span></li>
		<li>{t domain="h5"}退款进度{/t}<span class="aan">{$data.label_back_status}</span></li>
	</ul>
	
	<div class="q5">
		<div class="qi">
			<span class="qj"></span>
			<span class="qk"></span>
			<span class="qk"></span>
			
			<!-- {foreach from=$data.back_logs item=logs} -->
			<div class="q6">
				<i class="or ot iconState6"></i>
				<span class="firstLine"></span>
				<div class="q8">
					<span class="q7">{$logs.log_description}</span>
				</div>
				<div class="q9">{$logs.action_time}</div>
			</div>
			<!-- {/foreach} -->
		</div>
	</div>
</div>
<!-- {/block} -->
{/nocache}