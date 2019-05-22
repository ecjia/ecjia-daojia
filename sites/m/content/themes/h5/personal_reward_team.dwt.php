<?php
/*
Name: 团队列表
Description: 团队列表
Libraries: model_bar
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>

{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->
<!-- {block name="main-content"} -->
<div class="ecjia-reward-team">
	<div class="reward-team-top">
		<p class="total-num">{t domain="h5"}团队总人数（人）{/t}</p>
		<p class="number">{if $total_count}{$total_count}{else}0{/if}</p>
	</div>

	<div class="reward-team-bottom">
		<div class="bottom-hd">{t domain="h5"}团队列表{/t}</div>
		<ul class="team-item" id="team-list" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{url path='user/personal/ajax_team_list'}">
		</ul>
	</div>
</div>
<!-- {/block} -->
{/nocache}