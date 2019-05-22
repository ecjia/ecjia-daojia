<?php 
/*
Name: 文章评论列表模版
Description: 文章评论列表页
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch-ajax.dwt.php"} -->

<!-- {block name="ajaxinfo"} -->
	<!-- {foreach from=$data.list item=val key=key} -->
	<li class="comment-item">
		<div class="comment-left">
			<img src="{if $val.avatar_img}{$val.avatar_img}{else}{$theme_url}images/default_user.png{/if}" >
		</div>
		<div class="comment-right">
			<div class="user-name">{$val.author}<div class="time">{$val.add_time}</div></div>
			<div class="content">{$val.content}</div>
		</div>
	</li>
	<!-- {foreachelse} -->
	<div class="ecjia-nolist"><img src="{$theme_url}images/wallet/null280.png"><p class="tags_list_font">{t domain="h5"}暂无评论{/t}</p></div>
	<!-- {/foreach} -->
<!-- {/block} -->
{/nocache}