<?php
/*
Name: 商品祥情的简要评论
Description: 这是商品祥情的简要评论
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>

{if $comment_list.list}
<div class="ecjia-goods-comment ecjia-seller-comment border_t_e">
    <!-- {foreach from=$comment_list.list item=comment key=key} -->
    {if $key lt 5}
    <div class="assess-flat">
        <div class="assess-wrapper">
            <div class="assess-top">
                <span class="user-portrait"><img src="{if $comment.avatar_img}{$comment.avatar_img}{else}{$theme_url}images/default_user.png{/if}"></span>
                <div class="user-right">
                    <span class="user-name">{$comment.author}</span>
                    <span class="assess-date">{$comment.add_time}</span>
                </div>
                <p class="comment-item-star score-goods" data-val="{$comment.rank}"></p>
            </div>
            <div class="assess-bottom">
                <p class="assess-content">{$comment.content}</p>
                <p class="goods-attr">{$comment.goods_attr}</p>
                <!-- {if $comment.picture} -->
                <div class="img-list img-pwsp-list" data-pswp-uid="{$key}">
                    <!-- {foreach from=$comment.picture item=img} -->
                    <figure><span><a class="nopjax external" href="{$img}"><img src="{$img}" /></a></span></figure>
                    <!-- {/foreach} -->
                </div>
                <!-- {/if} -->
                {if $comment.reply_content}
                <div class="store-reply">{t domain="h5"}商家回复：{/t}{$comment.reply_content}</div>
                {/if}
            </div>
        </div>
    </div>
    {/if}
    <!-- {/foreach} -->
</div>
{/if}