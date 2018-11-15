<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui">
    <title>{$page_title}</title>
    <link rel="stylesheet" href="{$theme_url}/js/swiper/swiper.css">
    <link rel="stylesheet" href="{$theme_url}/css/style.css?19">
    <script type="text/javascript" src="{$theme_url}/js/swiper/swiper.js"></script>
    <script type="text/javascript" src="{$theme_url}/js/jquery.min.js"></script>
</head>

<body>
    <div class="ecjia-header fixed">
        <div class="ecjia-content">
            <div class="ecjia-fl ecjia-logo wt-10">
                <a class="nopjax" href="{$main_url}">
                    <img src="{if $shop_logo}{$shop_logo}{else}{$theme_url}images/logo.png{/if}">
                </a>
            </div>
            <div class="ecjia-fr">
                <ul class="nav hover-font">
                    <li>
                        <a class="nopjax" href="{$main_url}">首页</a>
                    </li>
                    <li {if $active eq 'category'}class="active" {/if}>
                        <a class="nopjax" href="{$main_goods_url}">商家</a>
                    </li>
                    <li class="active">
                        <a href="javascript:;">下载APP</a>
                    </li>
                    {if $member_url}<li><a class="nopjax" href="{$member_url}" target="_blank">会员中心</a></li>{/if}
                    {if ecjia::config('merchant_join_close') eq 0}
                    <li><a class="nopjax" href="{$merchant_url}" target="_blank">商家入驻</a></li>
                    {/if}
                    <li>
                        <a class="nopjax ecjia-back-green" href="{$merchant_login}" target="_blank">商家登录</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="ecjia-container">
        <div class="ecjia-content">
            <div class="ecjia-fl wt-introduce">
                <p class="title">{$mobile_app_name}</p>
                <p class="title">
                    <!-- #BeginLibraryItem "/library/shop_subtitle.lbi" -->
                    <!-- #EndLibraryItem -->
                </p>
                <p class="title-notice">
                    <!-- #BeginLibraryItem "/library/brief_intro.lbi" -->
                    <!-- #EndLibraryItem -->
                </p>
                <div class="qrcode">
                    {if $has_weapp}
                    <div class="qrcode-item">
                        <div class="img">
                            <img src="{RC_Uri::url('weapp/wxacode/init')}" width="200" height="200" />
                        </div>
                        <p>扫码体验小程序</p>
                    </div>
                    {/if}
                    <div class="qrcode-item {if $has_weapp}last{/if}">
                        <div class="img">
                            <img src="{$touch_qrcode}" width="200" height="200" />
                        </div>
                        <p>扫码体验H5</p>
                    </div>
                </div>

            </div>
            <div class="ecjia-fr wt-phone">
                <div class="project-view ecjia-fl m-t-50">
                    <iframe src="{$mobile_touch_url}" frameborder="0" scrolling="auto"></iframe>
                </div>
            </div>
        </div>

        <div class="ecjia-content">
            <div class="ecjia-title">
                <h1 class="fsize-36">商家和配送员可使用原生APP</h1>
                <p class="top-title">与商城完美对接的原生APP，下载并安装成功后，商家可通过手机掌柜</p>
                <p class="bottom-title">随时随地管理店铺、商城配送员可通过配送员APP在线抢单、送单并获得相应的配送费用</p>
            </div>

            <div class="content-item">
                <div class="left-side ecjia-fl">
                    <img src="{$theme_url}images/shopkeeper.png" />
                </div>
                <div class="right-side ecjia-fr p_r0">
                    <p class="title">
                        <span class="num">1</span>掌柜</p>
                    <p class="notice">与我们商城后台完美同步，下载此APP后，可使用入驻商家账号直接登录，使用手机随时随地高效管理自己的店铺、商品、订单等。</p>
                    <div class="button-item">
                        <a class="ecjia-btn icon-btn green" href="https://itunes.apple.com/cn/app/ec-%E6%8E%8C%E6%9F%9C/id1015857619?mt=8" target="_blank">
                            <i class="iphone icon"></i>iPhone端下载</a>
                        <a class="ecjia-btn icon-btn blue" href="http://a.app.qq.com/o/simple.jsp?pkgname=com.ecjia.shopkeeper" target="_blank">
                            <i class="android icon"></i>Android端下载</a>
                    </div>
                </div>
            </div>

            <div class="content-item">
                <div class="right-side ecjia-fl">
                    <p class="title">
                        <span class="num">2</span>配送员</p>
                    <p class="notice w91">适用于商城配送员使用，如果您已成为我们的配送员，你可下载安装此APP，获取周边商家的订单，随时随地在线抢单、取货、配送等。</p>
                    <div class="button-item">
                        <a class="ecjia-btn icon-btn green" href="https://itunes.apple.com/cn/app/ec-%E9%85%8D%E9%80%81%E5%91%98/id1198119772?mt=8"
                            target="_blank">
                            <i class="iphone icon"></i>iPhone端下载</a>
                        <a class="ecjia-btn icon-btn blue" href="http://a.app.qq.com/o/simple.jsp?pkgname=com.ecjia.express" target="_blank">
                            <i class="android icon"></i>Android端下载</a>
                    </div>
                </div>
                <div class="left-side ecjia-fr">
                    <img class="ecjia-fr" src="{$theme_url}images/distributor.png" />
                </div>
            </div>

            <div class="content-item">
                <div class="left-side ecjia-fl">
                    <img src="{$theme_url}images/cloudshop.png" />
                </div>
                <div class="right-side ecjia-fr p_r0">
                    <p class="title">
                        <span class="num">3</span>云店</p>
                    <p class="notice">让H5手机网站免费在原生APP内运行，消费者只需下载此APP后，扫描你的店铺二维码，即可在此APP内访问H5商城，满足消费者更好的购物体验。</p>
                    <div class="button-item">
                        <a class="ecjia-btn icon-btn green" href="https://itunes.apple.com/cn/app/id990510286?mt=8" target="_blank">
                            <i class="iphone icon"></i>iPhone端下载</a>
                        <a class="ecjia-btn icon-btn blue" href="http://a.app.qq.com/o/simple.jsp?pkgname=com.ecjia.street" target="_blank">
                            <i class="android icon"></i>Android端下载</a>
                    </div>
                </div>
            </div>

            <div class="teach-item">
                <div class="teach-item-content">
                    <div class="title">三步教你如何使用APP</div>
                    <div class="content">
                        <img class="background" src="{$theme_url}images/casing.png" />
                        <img class="inner" src="{$street_qrcode}" />
                        <p>扫店铺二维码</p>
                        <img class="bottom" src="{$theme_url}images/arrow.png" />
                    </div>
                </div>
            </div>

            <div class="step-item">
                <div class="step-item-content">
                    <div class="step-item-li">
                        <div class="img">
                            <img class="inner" src="{$theme_url}images/step_1.png" />
                        </div>
                        <div class="right">
                            <p class="step">第一步</p>
                            <p>打开已下载的APP</p>
                        </div>
                    </div>
                    <div class="step-item-li">
                        <div class="img">
                            <img class="inner" src="{$theme_url}images/step_2.png" />
                        </div>
                        <div class="right">
                            <p class="step">第二步</p>
                            <p>扫描店铺二维码</p>
                        </div>
                    </div>
                    <div class="step-item-li">
                        <div class="img">
                            <img class="inner" src="{$theme_url}images/step_3.png" />
                        </div>
                        <div class="right">
                            <p class="step">第三步</p>
                            <p>输登录账号即可使用</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clyimges">
                <div class="cly-title">界面精彩截图</div>
                <div class="cly-tab">
                    <div class="cly-tab-content">
                        <div class="tab-li active" data-tab="shopkeeper">到家掌柜</div>
                        <div class="tab-li" data-tab="distributor">到家配送员</div>
                        <div class="tab-li" data-tab="cloudshop">云店</div>
                    </div>
                </div>
                <div class="wt-30">
                    <div class="swiper-container" id="shopkeeper-swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/shopkeeper/1.png">
                                <p>掌柜主页</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/shopkeeper/2.png">
                                <p>商品列表</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/shopkeeper/3.png">
                                <p>发货列表</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/shopkeeper/4.png">
                                <p>派单列表</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/shopkeeper/5.png">
                                <p>活动列表</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/shopkeeper/6.png">
                                <p>店铺设置</p>
                            </div>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    <div class="swiper-container" id="distributor-swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/distributor/1.png">
                                <p>配送员主页</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/distributor/2.png">
                                <p>待取货</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/distributor/3.png">
                                <p>历史配送</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/distributor/4.png">
                                <p>消息</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/distributor/5.png">
                                <p>用户中心</p>
                            </div>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    <div class="swiper-container" id="cloudshop-swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/cloudshop/1.png">
                                <p>主页</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/cloudshop/2.png">
                                <p>店铺首页</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/cloudshop/3.png">
                                <p>扫码购物</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/cloudshop/4.png">
                                <p>用户中心</p>
                            </div>
                            <div class="swiper-slide">
                                <img src="{$theme_url}images/cloudshop/5.png">
                                <p>付款码</p>
                            </div>
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>

                    <script type="text/javascript">
                        var swiper = new Swiper($('#shopkeeper-swiper'), {
                            slidesPerView: 3,
                            paginationClickable: true,
                            spaceBetween: 30,
                            nextButton: '.swiper-button-next',
                            prevButton: '.swiper-button-prev',
                            loop: true,
                            initialSlide: 0
                        });

                        $(window).scroll(function () {
                            if ($(window).scrollTop() > 0) {
                                $('.ecjia-header').addClass('navbar-transparent');
                            } else {
                                $('.ecjia-header').removeClass('navbar-transparent');
                            }
                        });
                        
                        $('.tab-li').off('click').on('click', function () {
                            var tab = $(this).attr('data-tab');
                            $(this).addClass('active').siblings('div').removeClass('active');
                            $('#' + tab + '-swiper').css('display', 'block').siblings('div').css('display',
                                'none');
                            //swiper过的不再swiper
                            if ($(this).hasClass('swipered') || tab == 'shopkeeper') {
                                return false;
                            }
                            $(this).addClass('swipered');
                            console.log(1);
                            var swiper = new Swiper('#' + tab + '-swiper', {
                                slidesPerView: 3,
                                paginationClickable: true,
                                spaceBetween: 30,
                                nextButton: '.swiper-button-next',
                                prevButton: '.swiper-button-prev',
                                loop: true,
                                initialSlide: 0
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
        <div class="page-footer">
            <div class="outlink">
                {if $shop_weibo_url}
                <span>
                    <a class="blog-ico" href="{$shop_weibo_url}" target="_blank"></a>
                </span>
                {/if} {if $shop_wechat_qrcode}
                <span class="outlink-qrcode">
                    <div class="wechat-code">
                        <img src="{$shop_wechat_qrcode}">
                        <span>打开微信扫一扫关注</span>
                    </div>
                    <a class="wechat" href="javascript:void(0)"></a>
                </span>
                {/if}
            </div>
            <div class="footer-links">
                <p>
                    {$shop_info_html}
                    <!-- {foreach from=$shop_info item=rs} -->
                    <a class="data-pjax" href="{$rs.url}" target="_blank">{$rs.title}</a>
                    <!-- {/foreach} -->
                </p>
            </div>
            <p>{if $company_name}{$company_name} 版权所有{/if} {if ecjia::config('icp_number')}&nbsp;&nbsp;
                <a href="http://www.miibeian.gov.cn" target="_blank"> {ecjia::config('icp_number')}</a>{/if}&nbsp;&nbsp;{$commoninfo.powered}</p>
            <p>{if $shop_address}地址：{$shop_address} {/if} {if $service_phone} 咨询热线：{$service_phone}{/if}</p>
        </div>
    </div>
    <div style="display:none">
        {$stats_code}
    </div>
</body>

</html>