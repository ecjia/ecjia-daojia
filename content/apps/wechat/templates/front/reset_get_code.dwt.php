{nocache}
<!DOCTYPE html>
<html>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <head lang="zh-CN">
        <title>{t domain="wechat"}重设密码{/t}</title>
        {ecjia:hook id=front_head}
    </head>

    <header class="ecjia-header">
        <div class="ecjia-header-left">
        </div>
        <div class="ecjia-header-title">{t domain="wechat"}设置新密码{/t}</div>
    </header>
    <body>
        <div class="ecjia-form ecjia-login">
            <input name="mobile" type="hidden" value="{$mobile}"/>
            <p class="text-st-mobile">{t domain="wechat"}绑定手机号：{/t}{$mobile}</p>
            <p class="text-st">{t domain="wechat"}请输入收到的短信验证码{/t}</p>
            <div class="form-group small-text">
                <label class="input-1">
                    <input name="code" type="text" value="" placeholder='{t domain="wechat"}输入验证码{/t}'/>
                </label>
            </div>
            <div class="small-submit">
                <a class="get_code btn" id="get_code" href="{url path='wechat/mobile_profile/get_code'}">{t domain="wechat"}获取验证码{/t}</a>
            </div>
            <div class="around">
                <a class="next_pwd btn ecjia-login-margin-top" href="{url path='wechat/mobile_profile/next_pwd'}">{t domain="wechat"}下一步{/t}</a>
            </div>
        </div>

        {ecjia:hook id=front_print_footer_scripts}
        <script type="text/javascript">
            ecjia.bind.init();
        </script>
    </body>
</html>
{/nocache}