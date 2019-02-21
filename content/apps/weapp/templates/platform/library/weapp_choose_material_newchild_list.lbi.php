<!-- {if $articles.articles} -->
<li class="thumbnail move-mod-group big grid-item" data-id="{$articles.id}">
    <div class="article">
        <div class="cover">
            <a target="__blank" href="javascript:;">
                <img src="{$articles.file}"/>
            </a>
            <span>{$articles.title}</span>
        </div>
    </div>
    <div class="edit_mask appmsg_mask">
        <i class="icon_card_selected">{t domain="weapp"}已选择{/t}</i>
    </div>
    <!-- {foreach from=$articles.articles key=key item=val} -->
    <div class="article_list">
        <div class="f_l">{if $val.title}{$val.title}{else}{t domain="weapp"}无标题{/t}{/if}</div>
        <a target="__blank" href="javascript:;">
            <img src="{$val.file}" class="pull-right"/>
        </a>
    </div>
    <!-- {/foreach} -->
</li>
<!-- {else} -->
<li class="thumbnail move-mod-group big grid-item" data-id="{$articles.id}">
    <div class="articles">
        <div class="articles_title">{if $articles.title}{$articles.title}{else}{t domain="weapp"}无标题{/t}{/if}</div>
        <a target="__blank" href="javascript:;">
            <img src="{$articles.file}"/>
        </a>
        <div class="articles_content border-none">{$articles.content}</div>
    </div>
    <div class="edit_mask appmsg_mask">
        <i class="icon_card_selected">{t domain="weapp"}已选择{/t}</i>
    </div>
</li>
<!-- {/if} -->
