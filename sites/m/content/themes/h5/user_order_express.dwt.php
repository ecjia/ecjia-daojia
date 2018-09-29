<?php
/*
Name: 物流信息模板
Description: 这是订单物流信息页
Libraries: page_menu,page_header
 */
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.user.copy_btn();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-express-detail">
	<div class="express-info">
		<div class="express-left">
			<img src="{$goods_info.img.small}" />
		</div>
		<div class="express-right">
			<div class="express-name">物流公司：{$express_info.shipping_name}</div>
			<div class="express-num">运单编号：{$express_info.shipping_number}
				<span class="copy-btn copy-express-btn" data-clipboard-text="{$express_info.shipping_number}">复制</span>
			</div>
		</div>
	</div>

	{if $express_info.content.time neq 'error'}
	<div class="express-status">
		<at-timeline>
			{foreach from=$express_info.content item=v key=k}
			<div class="at-timeline at-timeline at-timeline--pending at-timeline--pending">
				<div class="at-timelineitem at-timelineitem">
					<div class="at-timelineitem__tail at-timelineitem__tail"></div>
					<div class="at-timelineitem__dot at-timelineitem__dot"></div>
					<div class="at-timelineitem__content at-timelineitem__content">
						<div class="at-timelineitem__content-item at-timelineitem__content-item">{$v.context}</div>
						<div class="at-timelineitem__content-item-time">{$v.time}</div>
					</div>
				</div>
			</div>
			{/foreach}
		</at-timeline>
	</div>
	{else}
	<div class="no-express-info">
		<img src="{$theme_url}/images/wallet/null280.png" />
		暂无物流信息
	</div>
	{/if}
	
</div>
<!-- {/block} -->