<?php
/*
Name: 销售个人奖励
Description: 销售个人奖励
Libraries: model_bar
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->
<!-- {block name="main-content"} -->
<div class="ecjia-reward-list">
	<div class="reward-head">
		<a class="fnUrlReplace" href='{url path="user/personal/reward"}'><div class="reward-head-item {if empty($status)}active{/if}"><span>待分成</span></div></a>
		<a class="fnUrlReplace" href='{url path="user/personal/reward"}&status=separated'><div class="reward-head-item {if $status eq 'separated'}active{/if}"><span>已分成</span></div></a>
	</div>
	<ul class="reward-list" id="reward-list" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/personal/ajax_personal_reward'}{if $smarty.get.status}&status={$smarty.get.status}{/if}">
	</ul>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<!-- {if $list} -->
<!-- {foreach from=$list item=val} -->
<li class="reward-item ecjia-margin-t">
	<div class="reward-hd">
		下单时间：{$val.formatted_order_time}
		<span class="ecjiaf-fr ecjia-color-red">{$val.label_status}</span>
	</div>
	<div class="flow-goods-list">
		<a class="ecjiaf-db" href='{url path="user/personal/reward_detail" args="id={$val.log_id}"}'>
			<!-- {foreach from=$val.goods_list item=v} -->
			<ul class="goods-item">
				<li class="goods-img">
					<img class="ecjiaf-fl" src="{$v.img.thumb}" />
				</li>
				<div class="goods-right">
					<div class="goods-name">{$v.goods_name}</div>
					<p class="block">{$v.formatted_goods_price}</p>
                    {if $v.referrer}<p class="block">{$v.referrer}</p>{/if}
				</div>
			</ul>
			<!-- {/foreach} -->
		</a>
	</div>
	<div class="reward-ft">
		<em class="ecjiaf-fr ecjia-color-red">{$val.formatted_affiliated_amount}</em>
	</div>
</li>
<!-- {/foreach} -->
<!-- {else} -->
<div class="ecjia-mod search-no-pro ecjia-margin-t ecjia-margin-b">
	<div class="ecjia-nolist">
		<p><img src="{$theme_url}images/wallet/null280.png"></p>
		暂无奖励
	</div>
</div>
<!-- {/if} -->
<!-- {/block} -->
{/nocache}