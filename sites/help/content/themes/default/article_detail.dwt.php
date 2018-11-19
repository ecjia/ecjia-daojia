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
                <input id="help_onekey" type="hidden" value="商城公告">
                <p class="menu_head current-header">商城公告</p>
                {else}
                <!-- {foreach $article_list as $article_list_cat} -->
                <input id="help_onekey" type="hidden" value="商城公告">
                <p class="menu_head current-header">商城公告</p>
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

            <div id="rightContent" class="help-right">
                <div>
                    <ul class="crumb clearfix">
                        <li><a href='{url path="article/notice/init"}'>商城公告</a> <i>&gt;</i></li>
                        <!-- {foreach $article_list as $article_list_cat} -->
                        <!-- {foreach $article_list_cat.article as  $article_list_child_cat} -->
                        <!-- {foreach $article_list_child_cat as  $article_cat} -->
                        {if $article_cat.id eq $aid}
                        <li id="help_one" class="last-one">{$article_cat.title}</li>
                        {/if}
                        <!-- {/foreach} -->
                        <!-- {/foreach} -->
                        <!-- {/foreach} -->
                    </ul>
                </div>
                <div class="help-title" id="topNavigate" >{$article.title}</div>
                <div class="time-title">{RC_Time::local_date('Y-m-d H:i:s', $article.add_time)}</div>
                <div class="detail help-list" id="artricleText">
                    {rc_stripslashes($article.content)}
                </div>
            </div>

        </div>
    </div>
</div>
{insert name='page_footer'}
</body>
</html>
