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
<!-- {foreach from=$comment item=list key=key} -->
<div class="assess-flat">    
	<div class="assess-wrapper">        
		<div class="assess-top">            
			<span class="user-portrait"><img src="{if $list.avatar_img}{$list.avatar_img}{else}{$theme_url}images/default_user.png{/if}"></span>           
			<div class="user-right"> 
				<span class="user-name">{$list.author}</span>     
				<span class="assess-date">{$list.add_time}</span>
			</div>
			<p class="comment-item-star score-goods" data-val="{$list.rank}"></p> 
		</div>        
		<div class="assess-bottom">            
			<p class="assess-content">{$list.content}</p>
			<p class="goods-attr">{$list.goods_attr}</p>
			<!-- {if $list.picture} -->
			<div class="img-list img-pwsp-list" data-pswp-uid="{$key}">
				<!-- {foreach from=$list.picture item=img} -->
				<figure><span><a class="nopjax external" href="{$img}"><img src="{$img}" /></a></span></figure>
				<!-- {/foreach} -->
			</div>
			<!-- {/if} -->
			{if $list.reply_content}
			<div class="store-reply">{t domain="h5"}商家回复：{/t}{$list.reply_content}</div>
			{/if}
		</div>    
	</div>    
</div>
<!-- {foreachelse} -->
<div class="ecjia-nolist">
    <img src="{$theme_url}images/wallet/null280.png">
    <p class="tags_list_font">{t domain="h5"}暂无商品评论{/t}</p>
</div>
<!-- {/foreach} -->
<!-- {/block} -->
{/nocache}