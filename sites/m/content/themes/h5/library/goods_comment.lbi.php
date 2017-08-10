<?php
/*
Name: 商品评论
Description: 这是商品评论页面
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
<div class="store-option">
	<dl class="active" data-url="{$ajax_url}&action_type=all&status=toggle" data-type="all">
		<dt>全部</dt>
		<dd>{$comment_number.all}</dd>
	</dl>
	<dl data-url="{$ajax_url}&action_type=good&status=toggle" data-type="good">
		<dt>好评</dt>
		<dd>{$comment_number.good}</dd>
	</dl>
	<dl data-url="{$ajax_url}&action_type=general&status=toggle" data-type="general">
		<dt>中评</dt>
		<dd>{$comment_number.general}</dd>
	</dl>
	<dl data-url="{$ajax_url}&action_type=low&status=toggle" data-type="low">
		<dt>差评</dt>
		<dd>{$comment_number.low}</dd>
	</dl>
	<dl data-url="{$ajax_url}&action_type=picture&status=toggle" data-type="picture">
		<dt>晒图</dt>
		<dd>{$comment_number.picture}</dd>
	</dl>
</div>
<div class="store-comment" {if $is_last neq 1}data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{$ajax_url}" data-type="all" data-page="{if $comment_list.list}2{else}1{/if}"{/if}>
    {if $comment_list.list}
    <!-- {foreach from=$comment_list.list item=list key=key} -->
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
                <!-- {if $comment.picture} -->
                <div class="img-list img-pwsp-list" data-pswp-uid="{$key}">
                    <!-- {foreach from=$list.picture item=img} -->
                    <figure><span><a class="nopjax external" href="{$img}"><img src="{$img}" /></a></span></figure>
                    <!-- {/foreach} -->
                </div>
                <!-- {/if} -->
                {if $list.reply_content}
                <div class="store-reply">商家回复：{$list.reply_content}</div>
                {/if}
            </div>    
        </div>    
    </div>
    <!-- {/foreach} -->
    {else}
    <div class="ecjia-nolist">
        <img src="{$theme_url}images/wallet/null280.png">
        <p class="tags_list_font">暂无商品评论</p>
    </div>
    {/if}
</div>