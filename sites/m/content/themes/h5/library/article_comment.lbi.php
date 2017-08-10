{nocache}
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
	<div class="ecjia-nolist"><img src="{$theme_url}images/wallet/null280.png"><p class="tags_list_font">暂无评论</p></div>
	<!-- {/foreach} -->
<!-- {/block} -->
{/nocache}