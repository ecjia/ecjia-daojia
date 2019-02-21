<!-- {if $articles.articles} -->
<li class="thumbnail move-mod-group grid-item big">
    <div class="article">
        <div class="cover">
            <a target="__blank" href="{$articles.file}">
                <img src="{$articles.file}" />
            </a>
            <span>{$articles.title}</span>
        </div>
    </div>

    <!-- {foreach from=$articles.articles key=key item=val} -->
    <div class="article_list">
        <div class="f_l">{if $val.title}{$val.title}{else}{t domain="wechat"}无标题{/t}{/if}</div>
        <a target="__blank" href="{$val.file}">
            <img src="{$val.file}" class="pull-right" />
        </a>
    </div>
    <!-- {/foreach} -->
    <p>
        <a class="ajaxremove" data-imgid="{$val.id}" data-toggle="ajaxremove" data-msg='{t domain="wechat"}您确定要删除该图文素材吗？{/t}' href='{url path="wechat/platform_material/remove" args="id={$articles.id}"}' title='{t domain="wechat"}删除{/t}'><i class="ft-trash-2"></i></a>
        <a href='{url path="wechat/platform_material/edit" args="id={$articles.id}"}'><i class="ft-edit-2"></i></a>
    </p>
</li>
<!-- {else} -->
<li class="thumbnail move-mod-group grid-item big">
    <div class="articles">
        <div class="articles_title">{if $articles.title}{$articles.title}{else}{t domain="wechat"}无标题{/t}{/if}</div>
        <a target="__blank" href="{$articles.file}">
            <img src="{$articles.file}"/>
        </a>
        <div class="articles_content">{$articles.content}</div>
    </div>
    <p>
        <a class="ajaxremove" data-imgid="{$articles.id}" data-toggle="ajaxremove" data-msg='{t domain="wechat"}您确定要删除该图文素材吗？{/t}' href='{url path="wechat/platform_material/remove" args="id={$articles.id}"}' title='{t domain="wechat"}删除{/t}'><i class="ft-trash-2"></i></a>
        <!-- {if $articles.article_id} -->
        <a href='{url path="wechat/platform_material/edit" args="id={$articles.id}"}'><i class="ft-edit-2"></i></a>
        <!-- {else} -->
        <a href='{url path="wechat/platform_material/edit" args="id={$articles.id}"}'><i class="ft-edit-2"></i></a>
        <!-- {/if} -->
    </p>
</li>
<!-- {/if} -->