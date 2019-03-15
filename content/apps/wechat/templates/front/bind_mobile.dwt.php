{nocache}
<!DOCTYPE html>
<html>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <head lang="zh-CN">
        <title>{t domain="wechat"}用户中心{/t}</title>
        {ecjia:hook id=front_enqueue_scripts}
        {ecjia:hook id=front_print_styles}
        {ecjia:hook id=front_print_scripts}
    </head>

    <header class="ecjia-header">
        <div class="ecjia-header-left">
        </div>
        <div class="ecjia-header-title">{t domain="wechat"}绑定手机号{/t}</div>
    </header>

    <body>
        <div class="ecjia-form ecjia-login">
            <div class="form-group margin-right-left">
                <label class="input-1">
                    <input name="mobile" type="text" placeholder='{t domain="wechat"}请输入要绑定的手机号{/t}'/>
                </label>
            </div>
            <p class="text-st">{t domain="wechat"}请输入收到的短信验证码{/t}</p>
            <div class="form-group small-text">
                <label class="input-1">
                    <input name="code" type="text" id="code" placeholder='{t domain="wechat"}短信验证码{/t}'/>
                </label>
            </div>
            <div class="small-submit">
                <a class="get_code btn" id="get_code" href="{url path='wechat/mobile_profile/get_code'}">{t domain="wechat"}获取验证码{/t}</a>
            </div>
            <div class="around">
                <a class="bind_mobile btn ecjia-login-margin-top" href="{url path='wechat/mobile_profile/bind_mobile_update'}">{t domain="wechat"}立即绑定{/t}</a>
            </div>
        </div>

        {ecjia:hook id=front_print_footer_scripts}
        <script type="text/javascript">
            ecjia.bind.init();
        </script>
    </body>
</html>
{/nocache}