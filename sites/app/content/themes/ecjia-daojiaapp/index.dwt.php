<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=0, minimal-ui">
        <title>{$page_title}</title>
        <link rel="stylesheet" href="{$theme_url}/js/swiper/swiper.css">
        <link rel="stylesheet" href="{$theme_url}/css/style.css?16">
        <script type="text/javascript" src="{$theme_url}/js/swiper/swiper.js"></script>
        <script type="text/javascript" src="{$theme_url}/js/jquery.min.js"></script>
    </head>
    <body>
        <div class="ecjia-header fixed">
            <div class="ecjia-content">
                <div class="ecjia-fl ecjia-logo wt-10">
                	<a class="nopjax" href="{$main_url}"><img src="{if $shop_logo}{$shop_logo}{else}{$theme_url}images/logo.png{/if}"></a>
                </div>
                <div class="ecjia-fr">
                    <ul class="nav hover-font">
                        <li><a class="nopjax" href="{$main_url}">首页</a></li>
                        <li {if $active eq 'category'}class="active"{/if}><a class="nopjax" href="{$main_goods_url}">商家</a></li>
						<li class="active"><a href="javascript:;">下载APP</a></li>
						<li><a class="nopjax" href="{$merchant_url}" target="_blank">商家入驻</a></li>
						<li><a class="nopjax ecjia-back-green" href="{$merchant_login}" target="_blank">商家登录</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="ecjia-container">
            <div class="ecjia-content">
                <div class="ecjia-fl wt-phone">
                    <div class="project-view ecjia-fl m-t-50">
                    {if $mobile_touch_url}
                        <iframe src="{$mobile_touch_url}" frameborder="0" scrolling="auto"></iframe>
                        <div class="ecjia-fl phone-tips">鼠标点击手机体验</div>
                    {else} 
                    <!-- 62 77 -->
                        <div class="swiper-container-phone">
                            <div class="swiper-wrapper">
                                {if $mobile_app_privew1}
                                <div class="swiper-slide">
                                    <img src="{$mobile_app_privew1}" alt="" width="320" height="567">
                                </div>
                                {/if}
                                {if $mobile_app_privew2}
                                <div class="swiper-slide">
                                    <img src="{$mobile_app_privew2}" alt="" width="320" height="567">
                                </div>
                                {/if}
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>
                        <script type="text/javascript">
                            var swiper = new Swiper('.swiper-container-phone', {
                            	autoplay: 3000,
                                slidesPerView: 1,
                                paginationClickable: true,
                                spaceBetween: 30,
                                pagination: '.swiper-pagination',
                               /*  nextButton: '.swiper-button-next',
                                prevButton: '.swiper-button-prev', */
                                loop: true
                            });
                        </script>
                    {/if}
                    </div>
                </div>
                <div class="ecjia-fl wt-135">
                    <div class="ecjia-desc">
                        <span class="ecjia-text-name fsize-36">{$mobile_app_name}</span>
						<span class="arrow-left edition-icon"></span>
                        <span class="ecjia-edition">{if $mobile_app_version}{$mobile_app_version}{else}1.0.0{/if}</span>
                        <h2 class="fsize-48 ecjia-truncate"><!-- #BeginLibraryItem "/library/shop_subtitle.lbi" --><!-- #EndLibraryItem --></h2>
                        <p class="fsize-24 ecjia-truncate"><!-- #BeginLibraryItem "/library/brief_intro.lbi" --><!-- #EndLibraryItem --></p>
                        <div class="two-btn wt-30">
                            {if $mobile_iphone_download}<a class="ecjia-btn icon-btn" href="{$mobile_iphone_download}" target="_blank"><i class="iphone icon"></i><span>iPhone端下载</span></a>{/if}
                            {if $mobile_android_download}<a class="ecjia-btn icon-btn" href="{$mobile_android_download}" target="_blank"><i class="android icon"></i><span>Android端下载</span></a>{/if}
                        </div>
                        <div class="ecjia-code wt-50">
                            {if $mobile_iphone_qrcode}
                            <span class="mr-20">
                                <img src="{$mobile_iphone_qrcode}" alt="" width="200" height="200">扫一扫，体验APP
                            </span>
                            {/if}
                            {if $touch_qrcode}
                            <span style="margin-right:32px;">
                                <img src="{$touch_qrcode}" alt="" width="200" height="200">扫一扫，体验微信H5界面
                            </span>
                            {/if}
                        </div>
                    </div>
                </div>
            </div>

            <div class="ecjia-content">
                <div class="ecjia-title wt-80">
                    <h1 class="fsize-36">{$mobile_app_name}简介</h1>
                    <p class="wt-30">{$mobile_app_description}</p>
                </div>

				{if $mobile_app_video}
				<div class="cly-title">应用视频介绍</div>
				<div class="video wt-30">
					<video width="900px" controls="controls">
						<source src="{$mobile_app_video}" type="video/mp4"></source>
						<source src="public/video/test.ogg" type="video/ogg"></source>
					</video>
				</div>
				{/if}
                <div class="clyimges">
                    {if $screenshots}
                    <div class="cly-title wt-30">界面精彩截图</div>
                    <div class="wt-30">
                        <div class="swiper-container">
                            <div class="swiper-wrapper">
                                <!-- {foreach from=$screenshots item=val} -->
                                <div class="swiper-slide">
                                    <img src="{$val.img_url}" alt="">
                                    <p>{$val.img_desc}</p>
                                </div>
                                <!-- {/foreach} -->
                            </div>

                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        <script type="text/javascript">
                            var swiper = new Swiper('.swiper-container', {
                                slidesPerView: 3,
                                paginationClickable: true,
                                spaceBetween: 30,
                                nextButton: '.swiper-button-next',
                                prevButton: '.swiper-button-prev',
                                loop: true
                            });

                    		$(window).scroll(function(){
                    			if ($(window).scrollTop() > 0) {
                    				$('.ecjia-header').addClass('navbar-transparent');
                    			} else {
                    				$('.ecjia-header').removeClass('navbar-transparent');
                    			}
                    		});
                        </script>
                    </div>
                    {/if}
                    <div class="wt-50 download">
                        <div class="two-btn wt-30">
                            {if $mobile_iphone_download}<a class="ecjia-btn icon-btn blue" href="{$mobile_iphone_download}" target="_blank"><i class="iphone icon"></i>iPhone端下载</a>{/if}
                            {if $mobile_android_download}<a class="ecjia-btn icon-btn green" href="{$mobile_android_download}" target="_blank"><i class="android icon"></i>Android端下载</a>{/if}
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-footer">
				<div class="outlink">
					{if $shop_weibo_url}
                    <span>
                        <a class="blog-ico" href="{$shop_weibo_url}" target="_blank"></a>
                    </span>
                    {/if}
                    {if $shop_wechat_qrcode}
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
                        <!-- {foreach from=$shop_info item=rs} -->
                        <a class="data-pjax" href="{$rs.url}" target="_blank">{$rs.title}</a>
                        <!-- {/foreach} -->
                    </p>
                </div>
                <p>{if $company_name}{$company_name} 版权所有{/if} {if ecjia::config('icp_number')}&nbsp;&nbsp;<a href="http://www.miibeian.gov.cn" target="_blank"> {ecjia::config('icp_number')}</a>{/if}&nbsp;&nbsp;{$powered}</p>
                <p>{if $shop_address}地址：{$shop_address} {/if} {if $service_phone} 咨询热线：{$service_phone}{/if}</p>
            </div>
        </div>
		<div style="display:none">
			{$stats_code}
		</div>
    </body>
</html>
