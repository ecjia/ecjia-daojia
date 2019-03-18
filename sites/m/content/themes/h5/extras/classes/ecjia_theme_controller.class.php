<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-08
 * Time: 17:20
 */

class ecjia_theme_controller extends ecjia_front
{

    public function __construct()
    {
        parent::__construct();

    }

    protected function load_default_script_style()
    {
        self::registerDefaultStyleScripts();
    }

    public static function registerDefaultStyleScripts()
    {
        //加载样式
        RC_Style::enqueue_style('ecjia-touch-bootstrap', ecjia_extra::themeUrl('lib/bootstrap3/css/bootstrap.css'));
        RC_Style::enqueue_style('ecjia-touch-iconfont',  ecjia_extra::themeUrl('dist/css/iconfont.min.css'));
        RC_Style::enqueue_style('ecjia-touch-touch',     ecjia_extra::themeUrl('css/ecjia.touch.css'));
        RC_Style::enqueue_style('ecjia-touch-touch-develop', ecjia_extra::themeUrl('css/ecjia.touch.develop.css'));
        RC_Style::enqueue_style('ecjia-touch-touch-b2b2c',   ecjia_extra::themeUrl('css/ecjia.touch.b2b2c.css'));
        RC_Style::enqueue_style('ecjia-touch-ecjia_city',    ecjia_extra::themeUrl('css/ecjia_city.css'));
        RC_Style::enqueue_style('ecjia-touch-ecjia_help',    ecjia_extra::themeUrl('css/ecjia_help.css'));
        //弹窗
        RC_Style::enqueue_style('ecjia-touch-touch-models', ecjia_extra::themeUrl('css/ecjia.touch.models.css'));
        RC_Style::enqueue_style('ecjia-touch-swiper',       ecjia_extra::themeUrl('dist/other/swiper.min.css'));
        RC_Style::enqueue_style('ecjia-touch-datePicker',   ecjia_extra::themeUrl('lib/datePicker/css/datePicker.min.css'));
        RC_Style::enqueue_style('ecjia-touch-winderCheck',  ecjia_extra::themeUrl('lib/winderCheck/css/winderCheck.min.css'));
        //图片预览
        RC_Style::enqueue_style('ecjia-touch-photoswipe',   ecjia_extra::themeUrl('lib/photoswipe/css/photoswipe.css'));
        RC_Style::enqueue_style('ecjia-touch-default-skin', ecjia_extra::themeUrl('lib/photoswipe/css/default-skin/default-skin.css'));
        //skin
        RC_Style::enqueue_style('ecjia-touch-style',      ecjia_extra::themeUrl('style.css'));
        RC_Style::enqueue_style('ecjia-touch-iosOverlay', ecjia_extra::themeUrl('lib/iOSOverlay/css/iosOverlay.css'));


        //加载脚本
        RC_Script::enqueue_script('ecjia-touch-jquery', ecjia_extra::themeUrl('lib/jquery/jquery.min.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-jquery-quicksearch', ecjia_extra::themeUrl('lib/multi-select/js/jquery.quicksearch.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-jquery-pjax', ecjia_extra::themeUrl('lib/jquery/jquery.pjax.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-jquery-cookie', ecjia_extra::themeUrl('lib/jquery/jquery.cookie.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-iscroll', ecjia_extra::themeUrl('lib/iscroll/js/iscroll.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-bootstrap', ecjia_extra::themeUrl('lib/bootstrap3/js/bootstrap.min.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-ecjia', ecjia_extra::themeUrl('lib/ecjiaUI/ecjia.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-jquery-form', ecjia_extra::themeUrl('lib/jquery-form/jquery.form.min.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-clipboard', ecjia_extra::themeUrl('lib/clipboard/js/clipboard.min.js'), array(), false, 1);

        RC_Script::enqueue_script('ecjia-touch-jquery-localstorage', ecjia_extra::themeUrl('lib/jquery-localstorage/jquery.localstorage.js'), array(), false, 1);

        //图片预览
        RC_Script::enqueue_script('ecjia-touch-photoswipe', ecjia_extra::themeUrl('lib/photoswipe/js/photoswipe.min.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-photoswipe-ui-default', ecjia_extra::themeUrl('lib/photoswipe/js/photoswipe-ui-default.min.js'), array(), false, 1);

        RC_Script::enqueue_script('ecjia-touch-jquery-yomi', ecjia_extra::themeUrl('js/jquery.yomi.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-koala', ecjia_extra::themeUrl('js/ecjia.touch.koala.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch', ecjia_extra::themeUrl('js/ecjia.touch.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-others', ecjia_extra::themeUrl('js/ecjia.touch.others.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-goods',  ecjia_extra::themeUrl('js/ecjia.touch.goods.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-user',   ecjia_extra::themeUrl('js/ecjia.touch.user.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-flow',   ecjia_extra::themeUrl('js/ecjia.touch.flow.js'), array(), false, 1);

        RC_Script::enqueue_script('ecjia-touch-goods_detail', ecjia_extra::themeUrl('js/ecjia.touch.goods_detail.js'), array(), false, 1);

        //微信判断位置
        if(ecjia_is_weixin()) {
            RC_Script::enqueue_script('ecjia-touch-jweixin', ecjia_extra::themeUrl('js/jweixin-1.2.0.js'), array(), false, 1);
        }
        RC_Script::enqueue_script('ecjia-touch-spread', ecjia_extra::themeUrl('js/ecjia.touch.spread.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-user_account', ecjia_extra::themeUrl('js/ecjia.touch.user_account.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-franchisee', ecjia_extra::themeUrl('js/ecjia.touch.franchisee.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-comment', ecjia_extra::themeUrl('js/ecjia.touch.comment.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-raty', ecjia_extra::themeUrl('js/ecjia.touch.raty.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-fly', ecjia_extra::themeUrl('js/ecjia.touch.fly.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-quickpay', ecjia_extra::themeUrl('js/ecjia.touch.quickpay.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-share', ecjia_extra::themeUrl('js/ecjia.touch.share.js'), array(), false, 1);

        //弹窗
        RC_Script::enqueue_script('ecjia-touch-intro', ecjia_extra::themeUrl('js/ecjia.touch.intro.min.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-validform', ecjia_extra::themeUrl('lib/Validform/Validform_v5.3.2_min.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-swiper', ecjia_extra::themeUrl('lib/swiper/js/swiper.min.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-date-picker', ecjia_extra::themeUrl('lib/datePicker/js/datePicker.min.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-winder-check', ecjia_extra::themeUrl('lib/winderCheck/js/winderCheck.min.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-green-check', ecjia_extra::themeUrl('js/greenCheck.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-ios-overlay', ecjia_extra::themeUrl('lib/iOSOverlay/js/iosOverlay.js'), array(), false, 1);
        RC_Script::enqueue_script('ecjia-touch-prettify', ecjia_extra::themeUrl('lib/iOSOverlay/js/prettify.js'), array(), false, 1);
        RC_Script::enqueue_script('js-sprintf');

        RC_Script::localize_script('ecjia-touch', 'js_lang', ecjia_extra::loadJSLang());
    }

}