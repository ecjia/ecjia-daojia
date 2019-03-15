<!doctype html>
<html>
<head>
    <!-- #BeginLibraryItem "/library/tag_head.lbi" --><!-- #EndLibraryItem -->
</head>

<body class="w1200">

{insert name='page_header'}

<div class="wrap-bg">
    <div class="wrap">
        <div class="info-block help clearfix" id="helpaa">
            <div id="leftMenu" class="help-left">
                {if empty($article_list)}
                <input id="help_onekey" type="hidden" value='{t domain="default"}商城公告{/t}'>
                <p class="menu_head current-header">{t domain="default"}商城公告{/t}</p>
                {else}
                <!-- {foreach $article_list as $article_list_cat} -->
                <input id="help_onekey" type="hidden" value='{t domain="default"}商城公告{/t}'>
                <p class="menu_head current-header">{t domain="default"}商城公告{/t}</p>
                <ul  class="menu_body" style="display: none">
                    <!-- {foreach $article_list_cat.article as $key => $article_list_child_cat} -->
                    <li>
                        <a  href='{url path="article/notice/init"}&date={$key}' {if $date eq $key} class='current' {/if}>{$key}</a>
                    </li>
                    <!-- {/foreach} -->
                </ul>
                <!-- {/foreach} -->
                {/if}
            </div>

            <div class="help-right new-block-list" id="newNavigate">
                <div>
                    <ul class="crumb clearfix">
                        <li><a href='{url path="article/notice/init"}'>{t domain="default"}商城公告{/t}</a> <i>&gt;</i></li>
                        <li id="help_one" class="last-one">
                            {t domain="default"}热点公告{/t}
                        </li>
                    </ul>
                </div>
                <div class="detail help-list new-list" id="newArt">
                    {if empty($article_list)}
                    {t domain="default"}暂无商城公告{/t}
                    {else}
                    <ul>
                        <!-- {foreach $article_list as $article_list_cat} -->
                        <!-- {foreach $article_list_cat.article as $key => $article_list_child_cat} -->
                        {if $key eq $date}
                        <!-- {foreach $article_list_child_cat as $article_cat} -->
                        <li class="clearfix">
                            <div class="new-list-detail" id="newsPart">
                                <a class="current" href='{url path="article/notice/detail"}&date={$date}&aid={$article_cat.id}'>{$article_cat.title}</a>
                            </div>
                            <div class="new-list-time">{$article_cat.date}</div>
                        </li>
                        <!-- {/foreach} -->
                        {/if}
                        <!-- {/foreach} -->
                        <!-- {/foreach} -->
                    </ul>
                    {/if}
                </div>
            </div>

        </div>
    </div>
</div>
{insert name='page_footer'}
</body>
</html>
