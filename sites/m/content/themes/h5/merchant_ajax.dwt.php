<?php
/*
Name: 店铺商品
Description: 这是店铺商品页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
	<!-- 异步购物车列表 start-->
	<!-- {foreach from=$list item=val} 循环商品 -->
	<li class="a5n single {if $val.is_disabled eq 1}disabled{/if}">
		<span class="a69 a5o {if $val.is_checked}checked{/if} checkbox {if $val.is_disabled eq 1}disabled{/if}" data-toggle="toggle_checkbox" rec_id="{$val.rec_id}"></span>
		<table class="a5s">
			<tbody>
				<tr>
					<td style="width:75px; height:75px">
						<img class="a7g" src="{$val.img.small}">
						<div class="product_empty">
						{if $val.is_disabled eq 1}{$val.disabled_label}{/if}
						</div>
					</td>
					<td>
						<div class="a7j">{$val.goods_name}</div> 
						{if $val.attr}<div class="a7s">{$val.attr}</div>{/if}
						<span class="a7c">
						{if $val.goods_price eq 0}{t domain="h5"}免费{/t}{else}{$val.formated_goods_price}{/if}
						</span>
					</td>
				</tr>
			</tbody>
		</table>
		<div class="box" id="goods_cart_{$val.id}">
			<span class="a5u reduce {if $val.is_disabled eq 1}disabled{/if} {if $val.attr}attr_spec{/if}" data-toggle="remove-to-cart" rec_id="{$val.rec_id}" goods_id="{$val.id}"></span>
			<lable class="a5x" {if $val.is_disabled neq 1}data-toggle="change-number"{/if} rec_id="{$val.rec_id}" goods_id="{$val.id}" goods_num="{$val.goods_number}">{$val.goods_number}</lable>
			<span class="a5v {if $val.is_disabled eq 1}disabled{/if} {if $val.attr}attr_spec{/if}" data-toggle="add-to-cart" rec_id="{$val.rec_id}" goods_id="{$val.id}"></span>
		</div>
	</li>
	<input type="hidden" name="rec_id" value="{$val.rec_id}" />
	<!-- {/foreach} -->
	<!-- 异步购物车列表end -->
<!-- {/block} -->
	
	
{/nocache}