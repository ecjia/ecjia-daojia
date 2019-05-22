<?php
/*
Name: 奖励明细
Description: 奖励明细
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
    <!--{foreach from=$data item=record}-->
    <li>
        <span class="record-label">{$record.label_reward_type}</span>
		<span class="icon-price-red ecjiaf-fr">{$record.give_reward}</span>
        <span class="record-time">{$record.reward_time}</span>
    </li>
   	<!-- {foreachelse} -->
	<div class="ecjia-nolist">
		<div class="img-noreward">{t domain="h5"}暂无奖励{/t}</div>
	</div>
    <!-- {/foreach} -->
<!-- {/block} -->
{/nocache}