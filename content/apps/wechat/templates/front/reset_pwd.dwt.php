{nocache}
<!DOCTYPE html>
<html>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=8,IE=9,IE=10,IE=11"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <head lang="zh-CN">
        <title>{t domain="wechat"}重设密码{/t}</title>
        {ecjia:hook id=front_enqueue_scripts}
        {ecjia:hook id=front_print_styles}
        {ecjia:hook id=front_print_scripts}
    </head>

    <header class="ecjia-header">
        <div class="ecjia-header-left">
        </div>
        <div class="ecjia-header-title">{t domain="wechat"}设置新密码{/t}</div>
    </header>
    <body>
        <div class="ecjia-form ecjia-login">
            <div class="form-group margin-right-left">
                <label class="input">
                    <i class="iconfont icon-attention ecjia-login-margin-l" id="password1"></i>
                    <input class="padding-left05" type="password" id="password" name="password" placeholder='{t domain="wechat"}请输入新密码{/t}'/>
                </label>
            </div>
            <div class="form-group ecjia-login-margin-top margin-right-left">
                <label class="input">
                    <i class="iconfont icon-attention ecjia-login-margin-l show-password" id="password2"></i>
                    <input class="padding-left05" type="password" id="confirm_password" name="confirm_password" placeholder='{t domain="wechat"}请再次输入新密码{/t}'/>
                </label>
            </div>
            <div class="ecjia-login-b ecjia-login-margin-top">
                <div class="around">
                    <a class="finish_pwd btn" href="{url path='wechat/mobile_profile/reset_pwd_update'}">{t domain="wechat"}完成{/t}</a>
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