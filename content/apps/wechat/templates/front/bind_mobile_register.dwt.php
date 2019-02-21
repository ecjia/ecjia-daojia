{nocache}
<!DOCTYPE html>
<html>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <head lang="zh-CN">
        <title>{t domain="wechat"}绑定手机号{/t}</title>
        {ecjia:hook id=front_head}
    </head>

    <header class="ecjia-header">
        <div class="ecjia-header-left">
        </div>
        <div class="ecjia-header-title">{t domain="wechat"}绑定手机号{/t}</div>
    </header>
    <body>
        <div class="ecjia-form  ecjia-login">
            <div class="form-group margin-right-left">
                <label class="input">
                    <span class="roaming">+86</span>
                    <input placeholder='{t domain="wechat"}手机号{/t}' name="mobile_phone" class="mobile_phone">
                </label>
            </div>

            <div class="ecjia-login-b">
                <div class="around">
                    <input type="hidden" name="openid" value="{$openid}">
                    <input type="hidden" name="uuid" value="{$uuid}">
                    <a class="ecjia-mobile_confirm btn" href="{url path='wechat/mobile_userbind/get_code'}">{t domain="wechat"}确定{/t}</a>
                </div>
            </div>
        </div>

        {ecjia:hook id=front_print_footer_scripts}

        <script type="text/javascript">
            ecjia.bind.init();
        </script>
    </body>
</html>
{/nocache}