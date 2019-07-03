<div class="tools">
    <!-- {nocache} -->
    <div class="wrap">
        <div class="bl-name" title="{$shop_name}"><div class="txt">{t domain="default"}Hi，欢迎来到{/t}{$shop_name}</div><b></b></div>
        {if ecjia::config('pc_enabled_member')}
        <div class="tools-right">
            <ul>
                <li id="user_not_login" class="box">
                    <div>
                        <a href="{$site_member}" target="_blank" class=""><span>{t domain="default"}会员中心{/t}</span></a>
                        <a href="{$url_order}" target="_blank" class=""><span>{t domain="default"}我的订单{/t}</span></a>
                    </div>
                </li>
            </ul>
        </div>
        {/if}
    </div>
    <!-- {/nocache} -->
</div>

<div class="infomation">
    <div class="wrap ">
        <div class="info-header">
            <div class="info-logo">
                <a href="{$site_index}"> <img src="{$shop_logo}" alt="{$shop_name}"></a>
            </div>
            <div class="info-menu">
                <ul>
                    <li onclick="document.getElementById('shop_help').click();" class="help-center {if $menu_c eq 'help' || empty($menu_c) } current {/if}">
                        <a id="shop_help" href='{url path="article/help/init"}'><span>{t domain="default"}帮助中心{/t}</span> </a>
                    </li>
                    <li onclick="document.getElementById('shop_notice').click();" class="new-ad {if $menu_c eq 'notice'} current {/if}">
                        <a id="shop_notice" href='{url path="article/notice/init"}'><span>{t domain="default"}商城公告{/t}</span></a>
                    </li>
                    <li onclick="document.getElementById('shop_info').click();" class="about-our {if $menu_c eq 'info'} current {/if}">
                        <a id="shop_info" href='{url path="article/info/init"}'> <span>{t domain="default"}关于我们{/t}</span></a>
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
