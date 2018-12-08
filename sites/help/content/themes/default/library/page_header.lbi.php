<div class="tools">
    <div class="wrap">
        <div class="bl-name" title="{$shop_name}"><div class="txt">Hi，欢迎来到{$shop_name}</div><b></b></div>
        {if ecjia::config('pc_enabled_member')}
        <div class="tools-right">
            <ul>
                <li id="user_not_login" class="box">
                    <div>
                        <a href="{$site_member}" target="_blank" class=""><span>会员中心</span></a>
                        <a href="{$url_order}" target="_blank" class=""><span>我的订单</span></a>
                    </div>
                </li>
            </ul>
        </div>
        {/if}
    </div>
</div>

<div class="infomation">
    <div class="wrap ">
        <div class="info-header">
            <div class="info-logo">
                <a href="{$site_index}"> <img src="{$shop_logo}" alt="{$shop_name}"></a>
            </div>
            <div class="info-menu">
                <ul>
                    <li onclick="javascript:document.getElementById('shop_help').click();" class="help-center {if $smarty.get.c eq 'help' || empty($smarty.get.c) } current {/if}">
                        <a id="shop_help" href='{url path="article/help/init"}'><span>帮助中心</span> </a>
                    </li>
                    <li onclick="javascript:document.getElementById('shop_notice').click();" class="new-ad {if $smarty.get.c eq 'notice'} current {/if}">
                        <a id="shop_notice" href='{url path="article/notice/init"}'><span>商城公告</span></a>
                    </li>
                    <li onclick="javascript:document.getElementById('shop_info').click();" class="about-our {if $smarty.get.c eq 'info'} current {/if}">
                        <a id="shop_info" href='{url path="article/info/init"}'> <span>关于我们</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="banner help-banner">
    <div class="help-banner-wp">
        <a role="button" style="background:url('{$theme_url}images/banner.png') center center no-repeat;"></a>
    </div>
</div>
