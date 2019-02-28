<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
            <meta content="IE=edge" http-equiv="X-UA-Compatible">
                <meta content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover" name="viewport">
                    <meta content="yes" name="apple-mobile-web-app-capable">
                        <meta content="black" name="apple-mobile-web-app-status-bar-style">
                            <meta content="telephone=no" name="format-detection">
                                <link href="{$statics_url}css/mobile.css" rel="stylesheet" type="text/css"/>
                                <title>
                                    {$data.title}
                                </title>
                            </meta>
                        </meta>
                    </meta>
                </meta>
            </meta>
        </meta>
    </head>
    <body class="zh_CN mm_appmsg appmsg_skin_default appmsg_style_default rich_media_empty_extra not_in_mm" id="activity-detail">
        <div class="rich_media" id="js_article">
            <div class="top_banner" id="js_top_ad_area">
            </div>
            <div class="rich_media_inner">
                <div class="rich_media_area_primary" id="page-content">
                    <div class="rich_media_area_primary_inner">
                        <div id="img-content">
                            <h2 class="rich_media_title" id="activity-name">
                                {$data.title}
                            </h2>
                            <div class="rich_media_meta_list" id="meta_content">
                                <span class="rich_media_meta rich_media_meta_text">
                                    ECJia
                                </span>
                                <em class="rich_media_meta rich_media_meta_text" id="publish_time">
                                    {RC_Time::local_date('Y-m-d H:i:s', $data.create_time)}
                                </em>
                            </div>
                            <div class="rich_media_content" id="js_content">
                                {$data.content}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="qr_code_pc_outer" id="js_pc_qr_code">
                    <div class="qr_code_pc_inner">
                        <div class="qr_code_pc">
                            <img class="qr_code_pc_img" id="js_pc_qr_code_img" src="{$store_qrcode}"/>
                            <p>
                                {t domain="toutiao"}微信扫一扫{/t}
                                <br>
                                {t domain="toutiao"}访问该店铺{/t}
                                </br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>