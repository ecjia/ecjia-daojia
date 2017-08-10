{nocache}
<!-- {block name="ajaxinfo"} -->
	<!-- {foreach from=$data item=val key=key} -->
	<div class="article-item"> 
		<a href="{RC_Uri::url('article/index/detail')}&article_id={$val.article_id}">
			<div class="article-left"> 
				<p class="article-title line-clamp2">{$val.title}</p> 
				<p class="article-summary line-clamp2">{$val.description}</p> 
				<div class="article-author clearfix" data-lazy="false"> 
					<img class="lazy-img article-author-pic" src="{if $val.store_info.store_id eq 0}{$theme_url}images/store_logo.png{else}{$val.store_info.store_logo}{/if}"> 
					<span class="lazy-img article-author-name">{$val.store_info.store_name}</span> 
				</div> 
			</div> 
			<div class="article-right" data-lazy="false"> 
				<div class="img-box"> 
					<img class="lazy-img" src="{$val.cover_image}"> 
				</div> 
				<div class="article-info clearfix"> 
					<div class="article-time"> 
						<div class="clock little-icon"></div> 
						<span>{$val.add_time}</span> 
					</div> 
					<div class="article-viewed"> 
						<span>{$val.click_count}</span> 
						<div class="eye little-icon"></div> 
					</div> 
				</div> 
			</div>
		</a> 
	</div>
	<!-- {foreachelse} -->
	<div class="ecjia-nolist"><img src="{$theme_url}images/wallet/null280.png"><p class="tags_list_font">暂无文章</p></div>
	<!-- {/foreach} -->
<!-- {/block} -->
{/nocache}
