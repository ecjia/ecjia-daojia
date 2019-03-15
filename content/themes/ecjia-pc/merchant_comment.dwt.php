<?php defined('IN_ECJIA') or header("HTTP/1.0 404 Not Found");exit('404 Not Found');?>
<!-- {extends file="ecjia-pc.dwt.php"} -->

<!-- {block name="footer"} -->
<script type="text/javascript">
    ecjia.pc.init();
</script>
<!-- {/block} -->

<!-- {block name="main-content"} -->
<!-- #BeginLibraryItem "/library/page_header.lbi" --><!-- #EndLibraryItem -->
{if $shop_info}
<!-- #BeginLibraryItem "/library/merchant_header.lbi" --><!-- #EndLibraryItem -->
<div class="background-f6">
<div class="ecjia-content">
	<div class="store-comment">
        <ul class="store-header">
            <a href='{$goods_url}' class="store-header-li"><li>{t domain="ecjia-pc"}商品{/t}</li></a>
            <a href='javascript:;' class="store-header-li active"><li>{t domain="ecjia-pc"}评价{/t}</li></a>
            <a href='{$detail_url}' class="nopjax store-header-li"><li>{t domain="ecjia-pc"}商家详情{/t}</li></a>
        </ul>
        <hr class="store-header-hr" />
        
        <ul class="screen-list">
		    <li class="screen-module">
		        <a href='{$comment_url}&level=all'><div data-type="all" class="comment1 {if $data.level eq 'all'}active{/if}">{t domain="ecjia-pc" 1={$data.all}}全部评价（%1）{/t}</div></a>
		    </li>
		    <li class="screen-module">
		        <a href='{$comment_url}&level=good'><div data-type="good" class="comment2 {if $data.level eq 'good'}active{/if}">{t domain="ecjia-pc" 1={$data.good}}好评（%1）{/t}</div></a>
		    </li>
		    <li class="screen-module">
		        <a href='{$comment_url}&level=general'><div data-type="general" class="comment3 {if $data.level eq 'general'}active{/if}">{t domain="ecjia-pc" 1={$data.general}}中评（%1）{/t}</div></a>
		    </li>
		    <li class="screen-module">
		        <a href='{$comment_url}&level=low'><div data-type="low" class="comment4 {if $data.level eq 'low'}active{/if}">{t domain="ecjia-pc" 1={$data.low}}差评（%1）{/t}</div></a>
		    </li>
		    <li class="screen-module">
		        <a href='{$comment_url}&level=print'><div data-type="print" class="comment5 {if $data.level eq 'print'}active{/if}">{t domain="ecjia-pc" 1={$data.print}}晒图（%1）{/t}</div></a>
		    </li>
		</ul>
		<ul class="comment-list">
		    <!-- {foreach from=$data.item name=foo item=val key=k} -->
		    <li {if $smarty.foreach.foo.last && $data.count lt 11}class="no_bottom"{/if}>
		        <div class="user-avatar">
		        {if $val.avatar_img}
		            <img src="{$val.avatar_img}" />
		        {else}
		            <img src="{$theme_url}/images/default_avatar.png" />
		        {/if}
		        </div>
		        <div class="comment-right">
		            <div class="comment-time">
		                <span>{t domain="ecjia-pc"}评价时间{/t}</span>
		                <span>{$val.add_time}</span>
		            </div>
		            <div class="comment-username">
		            {if $val.is_anonymous eq 0}{$val.user_name}{else}{t domain="ecjia-pc"}匿名发表{/t}{/if}
		            </div><br />
		            <span class="score-val" data-val="{$val.comment_rank}"></span>&nbsp;&nbsp;&nbsp;{$val.level}
		            <div class="comment-content">{$val.content}</div>
		            <div>{$val.goods_attr}</div>
		            <!-- {if $val.picture} -->
	                <div class="img-list img-pwsp-list" data-pswp-uid="{$k}">
                        <!-- {foreach from=$val.picture item=img} -->
                        <figure><span><img class="commentimg img_s" src="{$img}" /></span></figure>
                        <!-- {/foreach} -->
                    </div>
                    <!-- {/if} -->
                    {if $val.reply_content}
                    <div class="store-reply">{t domain="ecjia-pc"}商家回复：{/t}{$val.reply_content}</div>
                    {/if}
		        </div>
		    </li>
		    <!-- {foreachelse} -->
                <p class="no-comment">{t domain="ecjia-pc"}暂无评论{/t}</p>
            <!-- {/foreach} -->
	    </ul>
		{$data.page}
	</div>
</div>
</div>
{else}
<div class="m_t80">
<!-- #BeginLibraryItem "/library/no_content.lbi" --><!-- #EndLibraryItem -->
</div>
{/if}
<!-- #BeginLibraryItem "/library/page_footer.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/choose_city.lbi" --><!-- #EndLibraryItem -->
<!-- #BeginLibraryItem "/library/nav.lbi" --><!-- #EndLibraryItem -->
<!-- {/block} -->
