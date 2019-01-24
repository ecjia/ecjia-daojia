<?php
/*
Name: 团队列表
Description: 团队列表
Libraries: model_bar
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<!--{nocache}-->
<!-- {extends file="ecjia-touch.dwt.php"} -->
<!-- {block name="main-content"} -->
<div class="ecjia-reward-team">
	<div class="reward-team-top">
		<p class="total-num">团队总人数（人）</p>
		<p class="number">{if $data.total_count}{$data.total_count}{else}0{/if}</p>
	</div>

	<div class="reward-team-bottom">
		<div class="bottom-hd">团队列表</div>
		<ul class="team-item" id="team-list" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/personal/ajax_team_list'}">
		</ul>
	</div>
</div>
<!-- {/block} -->

<!-- {block name="ajaxinfo"} -->
<!-- {if $list} -->
<!-- {foreach from=$list item=val} 循环商品 -->
<li class="team-item-li">
	<div class="team-img">
		<img class="ecjiaf-fl" src="{$val.avatar_img}" />
	</div>
	<div class="team-right">
		<div class="name">{$val.user_name}</div>
		<p class="block">加入时间：{$val.formatted_reg_time}</p>
	</div>
</li>
<!-- {/foreach} -->
<!-- {else} -->
<div class="ecjia-mod search-no-pro">
	<div class="ecjia-nolist">
		<p><img src="{$theme_url}images/wallet/null280.png"></p>
		暂无团队成员
	</div>
</div>
<!-- {/if} -->
<!-- {/block} -->
<!--{/nocache}-->