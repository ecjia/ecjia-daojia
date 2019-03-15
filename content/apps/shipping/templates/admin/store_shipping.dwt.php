<?php defined('IN_ECJIA') or exit('No permission resources.');?>
<!-- {extends file="ecjia.dwt.php"} -->

<!-- {block name="main_content"} -->
<div>
	<h3 class="heading">
		<!-- {if $ur_here}{$ur_here}{/if} -->
		<!-- {if $action_link} -->
		<a class="data-pjax btn plus_or_reply" id="sticky_a" href="{$action_link.href}"><i class="fontello-icon-reply"></i>{$action_link.text}</a>
		<!-- {/if} -->
	</h3>
</div>

<div class="row-fluid">
	<div class="span3">
		<!-- {ecjia:hook id=display_admin_store_menus} -->
	</div>
	<div class="span9">
		<div class="shipping-template-list">
			<!-- {foreach from=$data.item item=list} -->
			<div class="template-item">
				<div class="template-head">
					<div class="head-left">{$list.shipping_area_name}</div>
					<div class="head-right">
						<a class="data-pjax" href='{RC_Uri::url("shipping/admin_store_shipping/view")}&store_id={$store_id}&template_name={$list.shipping_area_name}'>{t domain="shipping"}查看详情{/t}</a>
					</div>
				</div>
				<div class="template-content">
					<div class="content-group">
						<div class="content-label">{t domain="shipping"}物流快递：{/t}</div>
						<div class="content-controls">
							{$list.shipping_name}
						</div>
					</div>
					<div class="content-group">
						<div class="content-label">{t domain="shipping"}配送区域：{/t}</div>
						<div class="content-controls">
							{$list.shipping_area}
						</div>
					</div>
				</div>
			</div>
			<!-- {foreachelse} -->
				<table class="table table-striped table-hide-edit">
					<tbody>
						<tr><td class="no-records" colspan="4">{t domain="shipping"}没有找到任何记录{/t}</td></tr>
					</tbody>
				</table>
			<!-- {/foreach} -->
			<!-- {$data.page} -->
		</div>
	</div>
</div>
<!-- {/block} -->