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
                <!-- {foreach $article_list as $article_list_cat} -->
                <input id="help_onekey" type="hidden" value="新闻公告">
                <p class="menu_head current-header">商城公告</p>
                <ul  class="menu_body" style="display: none">
                    <!-- {foreach $article_list_cat.article as $key => $article_list_child_cat} -->
                    <li style="font-size: 14px;">
                        <a  href='{url path="article/notice/init"}&date={$key}' style='cursor: pointer;' {if $date eq $key} class='current' {/if}>{$key}</a>
                    </li>
                    <!-- {/foreach} -->
                </ul>
                <!-- {/foreach} -->
            </div>


            {if $smarty.get.show neq 'detail'}
            <div class="help-right new-block-list" id="newNavigate">
                <div>
                    <ul class="crumb clearfix">
                        <li><a href='{url path="article/notice/init"}'>商城公告</a> <i>&gt;</i></li>
                        <li id="help_one" class="last-one">
                            热点公告
                        </li>
                    </ul>
                </div>
                <div class="detail help-list new-list" id="newArt">
                    <ul>
                        <!-- {foreach $article_list as $article_list_cat} -->
                        <!-- {foreach $article_list_cat.article as $key => $article_list_child_cat} -->
                        {if $key eq $date}
                        <!-- {foreach $article_list_child_cat as $article_cat} -->
                        <li class="clearfix">
                            <div class="new-list-detail" id="newsPart">
                                <a style="cursor: pointer;" class="current" href='{url path="article/notice/init"}&date={$date}&aid={$article_cat.id}&show=detail'>{$article_cat.title}</a>
                            </div>
                            <div class="new-list-time" style="float: right">{$article_cat.date}</div>
                        </li>
                        <!-- {/foreach} -->
                        {/if}
                        <!-- {/foreach} -->
                        <!-- {/foreach} -->
                    </ul>
                </div>
            </div>
            {/if}


            {if $smarty.get.show eq 'detail'}
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
                <div id="topNavigate" style="margin-bottom: 15px;margin-left: 20px;font-size: 14px;color: #a5a5a5;text-align: center">{RC_Time::local_date('Y-m-d H:i:s', $article.add_time)}</div>
                <div class="detail help-list" id="artricleText">
                    {rc_stripslashes($article.content)}
                </div>
            </div>
            {/if}


        </div>
    </div>
</div>
{insert name='page_footer'}
</body>
</html>
