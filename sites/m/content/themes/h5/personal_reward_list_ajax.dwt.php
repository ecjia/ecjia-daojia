<?php
/*
Name: 销售个人奖励
Description: 销售个人奖励
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
		订单编号：{$val.order_sn}
		<span class="ecjiaf-fr ecjia-color-red">{if $status eq 'await_separate'}待分成{/if}{if $status eq 'separated'}已分成{/if}</span>
	</div>
	<div class="flow-goods-list">
		<a class="ecjiaf-db" href='{url path="user/personal/reward_detail" args="id={$val.log_id}"}'>
            {if $val.type eq 'buy'}
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
            {/if}

            {if $val.type eq 'quickpay'}
            <ul class="goods-item">
                <li class="goods-img">
                    <img class="ecjiaf-fl" src="{$theme_url}images/default-goods-pic.png" />
                </li>
                <div class="goods-right">
                    <div class="goods-name">优惠买单</div>
                    {if $v.referrer}<p class="block">{$v.referrer}</p>{/if}
                </div>
            </ul>
            {/if}
		</a>
	</div>
	<div class="reward-ft">
        {$val.formatted_order_time}
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