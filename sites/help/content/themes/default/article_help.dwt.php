<!doctype html>
<html>
<head>
    <!-- #BeginLibraryItem "/library/tag_head.lbi" --><!-- #EndLibraryItem -->
</head>

<body class="w1200">

{insert name='page_header'}

<div class="wrap-bg">
    <div class="wrap">
        <div  class="info-block help clearfix" id="helpaa">
            <div id="leftMenu" class="help-left">
                {if empty($article_list)}
                <input id="help_onekey" type="hidden" value="帮助中心">
                <p class="menu_head current-header">帮助中心</p>
                {else}
                <!-- {foreach $article_list as $article_list_cat} -->
                <input id="help_onekey" type="hidden" value="{$article_list_cat.name}">
                <p class="menu_head">{$article_list_cat.name}</p>
                <ul class="menu_body" style="display: none">
                    <!-- {foreach $article_list_cat.article as $key => $article_list_child_cat} -->
                    <li style="font-size: 14px;">
                        <a  href='{url path="article/help/init"}&aid={$article_list_child_cat.id}' style='cursor: pointer;' {if $article_list_child_cat.id eq $aid} class='current' {/if}>{$article_list_child_cat.title}</a>
                    </li>
                    <!-- {/foreach} -->
                </ul>
                <!-- {/foreach} -->
                {/if}
            </div>

            <div id="rightContent" class="help-right">
                <div>
                    <ul class="crumb clearfix">
                        {if empty($article_list)}
                        <li><a href='{url path="article/info/init"}'>帮助中心</a></li>
                        {else}
                        <li><a href='{url path="article/help/init"}'>帮助中心</a> <i>&gt;</i></li>
                        <!-- {foreach $article_list as $article_list_cat} -->
                        <!-- {foreach $article_list_cat.article as  $article_list_child_cat} -->
                        {if $article_list_child_cat.id eq $aid}
                        {if not empty($article_list_cat.name) }
                        <li id="help_one" class="last-one">{$article_list_cat.name}<i>&gt;</i></li>
                        {/if}
                        <li id="help_one" class="last-one">{$article_list_child_cat.title}</li>
                        {/if}
                        <!-- {/foreach} -->
                        <!-- {/foreach} -->
                        {/if}
                    </ul>
                </div>
                {if empty($article_list)}
                <div class="detail help-list">暂无内容</div>
                {else}
                <div class="help-title" id="topNavigate" >{$article.title}</div>
                <div class="detail help-list" id="artricleText">
                    {rc_stripslashes($article.content)}
                </div>
                {/if}
            </div>

        </div>
    </div>
</div>
{insert name='page_footer'}
</body>
</html>

