<?php
/*
Name: 售后进度模板
Description: 这是售后进度页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="main-content"} -->
<!-- #EndLibraryItem -->
<div class="return-status-content">
	<div class="q5">
		<div class="qi">
			<!-- {foreach from=$refund_logs item=log} -->
			<div class="q6">
				<i class="or ot iconState6"></i>
				<span class="firstLine"></span>
				<div class="q8">
					<span class="q7">{$log.label_status}</span>
				</div>
				<div class="q9">{$log.formatted_action_time}</div>
				<div class="qa">{$log.log_description}</div>
			</div>
			<!-- {/foreach} -->
		</div>
	</div>
</div>
<!-- {/block} -->
{/nocache}