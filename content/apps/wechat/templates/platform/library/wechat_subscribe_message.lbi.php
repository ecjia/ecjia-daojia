{if $type eq 'image'}
<div class="img_preview">
	<img class="preview_img margin_10" src="{$media_content.img_url}" alt="点击查看" data-type="image">
</div>
{/if}

{if $type eq 'voice'}
<div class="img_preview">
	<img class="preview_img margin_10" src="{$media_content.img_url}" title="点击播放" data-src="{$media_content.voice_url}" data-type="voice"></img>
</div>
{/if}

{if $type eq 'video'}
<div class="img_preview">
	<img class="preview_img margin_10" src="{$media_content.img_url}" title="点击播放" data-src="{$media_content.video_url}" data-type="video"></img>
</div>
{/if}

{if $type eq 'mpnews'}
<div class="weui-desktop-media__list-col margin_10">
	<li class="thumbnail move-mod-group big grid-item">
		<!-- {foreach from=$media_content.articles key=key item=val} -->
		{if $key eq 0}
	    <div class="article">
	        <div class="cover">
	            <a target="__blank" href="{$val.url}">
	                <img src="{$val.picurl}" />
	            </a>
	            <span>{$val.title}</span>
	        </div>
	    </div>
	    {else}
	    <div class="article_list">
	        <div class="f_l">{$val.title}</div>
	        <a target="__blank" href="{$val.url}">
	            <img src="{$val.picurl}" class="pull-right" />
	        </a>
	    </div>
		{/if}
	    <!-- {/foreach} -->
	</li>
</div>
{/if}
