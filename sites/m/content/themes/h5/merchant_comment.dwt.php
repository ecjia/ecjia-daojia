<?php
/*
Name: 店铺商品
Description: 这是店铺商品页
Libraries: page_menu,page_header
*/
defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');
?>
{nocache}
<!-- {extends file="ecjia-touch.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
	ecjia.touch.category.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<div class="ecjia-mod page_hearder_hide ecjia-fixed">
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
</div>

<!-- #BeginLibraryItem "/library/merchant_head.lbi" --><!-- #EndLibraryItem -->
<div class="ecjia-mod ecjia-store-ul">
	<ul>
		<li class="ecjia-store-li" data-url="{$url}"><span class="">{t domain="h5"}购物{/t}</span></li>
		<li class="ecjia-store-li"><span class="active">{t domain="h5"}评价{/t}</span></li>
		<li class="ecjia-store-li"><span>{t domain="h5"}商家{/t}</span></li>
	</ul>
</div>

<div class="ecjia-mod ecjia-store-comment ecjia-store-toggle">
	<div class="ecjia-seller-comment">
		<div class="comment-body">
			<div class="store-hr"></div>
			<div class="store-header-title">
				<div class="store-score">
					<div class="score-name">{t domain="h5"}商品评分{/t} ({$store_info.comment.comment_goods})</div>
					<span class="score-val" data-val="{$store_info.comment.comment_goods_val}"></span>
				</div>
				<div class="store-option">
					<dl class="active" data-url="{$ajax_url}&action_type=all&status=toggle" data-type="all">
						<dt>{t domain="h5"}全部{/t}</dt>
						<dd>{$comment_number.all}</dd>
					</dl>
					<dl data-url="{$ajax_url}&action_type=good&status=toggle" data-type="good">
						<dt>{t domain="h5"}好评{/t}</dt>
						<dd>{$comment_number.good}</dd>
					</dl>
					<dl data-url="{$ajax_url}&action_type=general&status=toggle" data-type="general">
						<dt>{t domain="h5"}中评{/t}</dt>
						<dd>{$comment_number.general}</dd>
					</dl>
					<dl data-url="{$ajax_url}&action_type=low&status=toggle" data-type="low">
						<dt>{t domain="h5"}差评{/t}</dt>
						<dd>{$comment_number.low}</dd>
					</dl>
					<dl data-url="{$ajax_url}&action_type=picture&status=toggle" data-type="picture">
						<dt>{t domain="h5"}晒图{/t}</dt>
						<dd>{$comment_number.picture}</dd>
					</dl>
				</div>
			</div>
			<div class="store-container" id="store-scroll">
				<div class="store-comment-container">
					<div id="store-comment" class="store-comment" data-toggle="asynclist" data-loadimg="{$theme_url}dist/images/loader.gif" data-url="{$ajax_url}" data-type="all">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- #BeginLibraryItem "/library/merchant_detail.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/store_notice_modal.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/preview_image.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->

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