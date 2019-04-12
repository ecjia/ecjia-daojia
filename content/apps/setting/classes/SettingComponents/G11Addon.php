<?php
//
//    ______         ______           __         __         ______
//   /\  ___\       /\  ___\         /\_\       /\_\       /\  __ \
//   \/\  __\       \/\ \____        \/\_\      \/\_\      \/\ \_\ \
//    \/\_____\      \/\_____\     /\_\/\_\      \/\_\      \/\_\ \_\
//     \/_____/       \/_____/     \/__\/_/       \/_/       \/_/ /_/
//
//   上海商创网络科技有限公司
//
//  ---------------------------------------------------------------------------------
//
//   一、协议的许可和权利
//
//    1. 您可以在完全遵守本协议的基础上，将本软件应用于商业用途；
//    2. 您可以在协议规定的约束和限制范围内修改本产品源代码或界面风格以适应您的要求；
//    3. 您拥有使用本产品中的全部内容资料、商品信息及其他信息的所有权，并独立承担与其内容相关的
//       法律义务；
//    4. 获得商业授权之后，您可以将本软件应用于商业用途，自授权时刻起，在技术支持期限内拥有通过
//       指定的方式获得指定范围内的技术支持服务；
//
//   二、协议的约束和限制
//
//    1. 未获商业授权之前，禁止将本软件用于商业用途（包括但不限于企业法人经营的产品、经营性产品
//       以及以盈利为目的或实现盈利产品）；
//    2. 未获商业授权之前，禁止在本产品的整体或在任何部分基础上发展任何派生版本、修改版本或第三
//       方版本用于重新开发；
//    3. 如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回并承担相应法律责任；
//
//   三、有限担保和免责声明
//
//    1. 本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；
//    2. 用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未获得商业授权之前，我们不承
//       诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；
//    3. 上海商创网络科技有限公司不对使用本产品构建的商城中的内容信息承担责任，但在不侵犯用户隐
//       私信息的前提下，保留以任何方式获取用户信息及商品信息的权利；
//
//   有关本产品最终用户授权协议、商业授权与技术服务的详细内容，均由上海商创网络科技有限公司独家
//   提供。上海商创网络科技有限公司拥有在不事先通知的情况下，修改授权协议的权力，修改后的协议对
//   改变之日起的新授权用户生效。电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和
//   等同的法律效力。您一旦开始修改、安装或使用本产品，即被视为完全理解并接受本协议的各项条款，
//   在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本
//   授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。
//
//  ---------------------------------------------------------------------------------
//
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/23
 * Time: 11:56 AM
 */

namespace Ecjia\App\Setting\SettingComponents;


use Ecjia\App\Setting\ComponentAbstract;

class G11Addon extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'addon';


    public function __construct()
    {
        $this->name = __('插件设置', 'setting');
    }


    public function handle()
    {
        $data = [
            ['code' => 'addon_active_applications', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_active_plugins', 'value' => 'a:16:{i:0;s:25:"calculator/calculator.php";i:1;s:37:"captcha_royalcms/captcha_royalcms.php";i:2;s:25:"mp_checkin/mp_checkin.php";i:3;s:17:"mp_dzp/mp_dzp.php";i:4;s:17:"mp_ggk/mp_ggk.php";i:5;s:21:"mp_goods/mp_goods.php";i:6;s:19:"mp_jfcx/mp_jfcx.php";i:7;s:19:"mp_kefu/mp_kefu.php";i:8;s:23:"mp_orders/mp_orders.php";i:9;s:27:"mp_userbind/mp_userbind.php";i:10;s:17:"mp_zjd/mp_zjd.php";i:11;s:25:"pay_alipay/pay_alipay.php";i:12;s:27:"pay_balance/pay_balance.php";i:13;s:19:"pay_cod/pay_cod.php";i:14;s:17:"sns_qq/sns_qq.php";i:15;s:19:"ueditor/ueditor.php";}', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_system_plugins', 'value' => 'a:1:{s:10:"calculator";s:25:"calculator/calculator.php";}', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_widget_nav_menu', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_widget_cat_articles', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_widget_cat_goods', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_widget_brand_goods', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_widget_ad_position', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_user_integrate_plugins', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_mobile_payment_plugins', 'value' => 'a:2:{s:11:"pay_balance";s:27:"pay_balance/pay_balance.php";s:10:"pay_alipay";s:25:"pay_alipay/pay_alipay.php";}', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_shipping_plugins', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_captcha_plugins', 'value' => 'a:1:{s:16:"captcha_royalcms";s:37:"captcha_royalcms/captcha_royalcms.php";}', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_platform_plugins', 'value' => 'a:9:{s:7:"mp_jfcx";s:19:"mp_jfcx/mp_jfcx.php";s:9:"mp_orders";s:23:"mp_orders/mp_orders.php";s:6:"mp_ggk";s:17:"mp_ggk/mp_ggk.php";s:10:"mp_checkin";s:25:"mp_checkin/mp_checkin.php";s:6:"mp_dzp";s:17:"mp_dzp/mp_dzp.php";s:6:"mp_zjd";s:17:"mp_zjd/mp_zjd.php";s:7:"mp_kefu";s:19:"mp_kefu/mp_kefu.php";s:11:"mp_userbind";s:27:"mp_userbind/mp_userbind.php";s:8:"mp_goods";s:21:"mp_goods/mp_goods.php";}', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_merchant_plugins', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_cron_plugins', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_connect_plugins', 'value' => 'a:1:{s:6:"sns_qq";s:17:"sns_qq/sns_qq.php";}', 'options' => ['type' => 'hidden']],
            ['code' => 'addon_global_plugins', 'value' => 'a:1:{s:7:"ueditor";s:19:"ueditor/ueditor.php";}', 'options' => ['type' => 'hidden']],
        ];

        return $data;
    }


    public function getConfigs()
    {
        $config = [
        ];

        return $config;
    }


}