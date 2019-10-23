<?php
/*
Name: 开店个人奖励
Description: 开店个人奖励
Libraries: model_bar
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
<!-- {if $list} -->
<!-- {foreach from=$list item=val} -->
<li class="reward-item ecjia-margin-t">
	<div class="reward-hd">
		加入时间：{$val.formatted_add_time}
	</div>
	<div class="flow-goods-list">
		<a class="ecjiaf-db" href='javascript:;'>
			<ul class="goods-item">
				<li class="goods-img">
					<img class="ecjiaf-fl" src="{$theme_url}images/spread/store.png" />
				</li>
				<div class="goods-right">
					<div class="goods-name">{$val.store_name}</div>
                    <p class="block">推荐人：{$val.referrer}</p>
                    <p class="block">成交订单数：{if $val.total_number}{$val.total_number}{else}0{/if}单</p>
				</div>
			</ul>
		</a>
	</div>
	<div class="reward-ft">
		<em class="ecjiaf-fr ecjia-color-red">成交总金额：{$val.formatted_total_amount}</em>
	</div>
</li>
<!-- {/foreach} -->
<!-- {else} -->

<!--<div class="ecjia-mod search-no-pro ecjia-margin-t ecjia-margin-b">-->
	<div class="ecjia-nolist">
		<p><img src="{$theme_url}images/wallet/null280.png"></p>
		暂无店铺
	</div>
<!--</div>-->
<!-- {/if} -->
<!-- {/block} -->
{/nocache}