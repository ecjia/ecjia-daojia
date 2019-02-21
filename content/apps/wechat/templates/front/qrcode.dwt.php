{nocache}
<!DOCTYPE html>
<html>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <head lang="zh-CN">
        <title>{$name}{t domain="wechat"}公众号扫码关注{/t}</title>
        <link rel="stylesheet" type="text/css" href="{$front_url}/css/qrcode.css"/>
    </head>
    <body>
        <div id="app" class="wrapper">
            <div>
                <div class="pn_index" style="background-image: url({$front_url}/images/qrcode_back.png);">
                    <div class="pn_index_title">
                        <img src="{$user_info.headimgurl}"><span>{$user_info.nickname}</span>
                    </div>
                    <div class="pn_index_redpacket">
                        <img src="{$url}">
                    </div>
                    <div class="pn_index_redpacket_cover">
                        <img src="{$front_url}/images/progress.png">
                        <div class="cover_content">
                            <span>{t domain="wechat"}扫描二维码{/t}</span>
                            <span>{t domain="wechat"}关注公众号{/t}</span>
                            <span>{t domain="wechat"}邀请成功{/t}</span>
                        </div>
                    </div>
                    <div class="pn_index_invite">
                        <dl>{t domain="wechat"}我邀请的人数：{/t}<span>{$count}</span>人</dl>
                        <div class="invite_content">
                            <!-- {foreach from=$user_list item=val} -->
                            <dt>
                            <dd><span>{date('Y-m-d H:i', $val.subscribe_time)}</span>
                                <div class="right">{$val.nickname}</div>
                            </dd>
                            <dt>
                                <!-- {foreachelse} -->
                                <div class="t_c">{t domain="wechat"}暂无邀请{/t}</div>
                                <!-- {/foreach} -->
                            </dt>
                        </div>
                    </div>
                </div>
            </div>
    </body>
</html>
{/nocache}