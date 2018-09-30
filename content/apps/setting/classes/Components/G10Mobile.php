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

namespace Ecjia\App\Setting\Components;


use Ecjia\App\Setting\ComponentAbstract;

class G10Mobile extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'mobile';

    /**
     * 名称
     * @var string
     */
    protected $name = '手机设置';

    /**
     * 描述
     * @var string
     */
    protected $description = '';

    /**
     * 缩略图
     * @var string
     */
    protected $thumb = null; //图片未添加


    public function handle()
    {
        $data = [
            ['code' => 'mobile_recommend_city', 'value' => 'CN310101,CN310104,CN310105,CN310106,CN310107,CN310109,CN310112,CN310113,CN310114,CN310115,CN310117', 'options' => ['type' => 'manual']],
            ['code' => 'mobile_pc_url', 'value' => 'https://cityo2o.ecjia.com', 'options' => ['type' => 'text']],
            ['code' => 'mobile_touch_url', 'value' => 'https://cityo2o.ecjia.com/sites/m/', 'options' => ['type' => 'text', 'sort_order' => '2']],
            ['code' => 'mobile_iphone_download', 'value' => 'https://itunes.apple.com/cn/app/ec+dao-jia/id1118895347?mt=8', 'options' => ['type' => 'text', 'sort_order' => '3']],
            ['code' => 'mobile_android_download', 'value' => 'http://a.app.qq.com/o/simple.jsp?pkgname=com.ecjia.cityo2o', 'options' => ['type' => 'text', 'sort_order' => '4']],
            ['code' => 'mobile_ipad_download', 'value' => '', 'options' => ['type' => 'text', 'sort_order' => '5']],
            ['code' => 'mobile_app_icon', 'value' => 'data/assets/mobile_app_icon.png', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/', 'sort_order' => '6']],
            ['code' => 'mobile_app_description', 'value' => 'ECJia到家是上海商创网络科技有限公司推出的一款多商户原生APP，基于LBS定位功能让用户通过查找附近店铺 在手机APP下单，支付，评价，并由商家提供上门服务的一套新型服务模式的电商系统。', 'options' => ['type' => 'text', 'sort_order' => '7']],
            ['code' => 'mobile_pad_login_fgcolor', 'value' => '#ffffff', 'options' => ['type' => 'color']],
            ['code' => 'mobile_pad_login_bgcolor', 'value' => '#000000', 'options' => ['type' => 'color']],
            ['code' => 'mobile_pad_login_bgimage', 'value' => 'data/assets/mobile_pad_login_bgimage.png', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'mobile_phone_login_fgcolor', 'value' => '#04b24f', 'options' => ['type' => 'color']],
            ['code' => 'mobile_phone_login_bgcolor', 'value' => '#afafaf', 'options' => ['type' => 'color']],
            ['code' => 'mobile_phone_login_bgimage', 'value' => 'data/assets/mobile_phone_login_bgimage.png', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
//             ['code' => 'mobile_topic_adsense', 'value' => '', 'options' => ['type' => 'manual']],
            ['code' => 'mobile_shopkeeper_urlscheme', 'value' => 'com.ecjia.cityo2o://', 'options' => ['type' => 'hidden']],
            ['code' => 'mobile_iphone_qrcode', 'value' => 'data/assets/qrcode.png', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'mobile_ipad_qrcode', 'value' => '', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'mobile_android_qrcode', 'value' => 'data/assets/qrcode.png', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'bonus_readme_url', 'value' => '/index.php?m=article&c=mobile&a=info&id=-1', 'options' => ['type' => 'text']],
            ['code' => 'mobile_app_name', 'value' => 'EC+到家', 'options' => ['type' => 'text']],
            ['code' => 'mobile_app_version', 'value' => '1.10.0', 'options' => ['type' => 'text']],
            ['code' => 'mobile_app_preview', 'value' => 'a:2:{i:0;s:35:"data/assets/mobile_app_preview1.jpg";i:1;s:35:"data/assets/mobile_app_preview2.jpg";}', 'options' => ['type' => 'manual']],
            ['code' => 'mobile_app_video', 'value' => 'https://dn-ecmoban.qbox.me/DJ20170930-rwxf.mp4', 'options' => ['type' => 'text']],
            ['code' => 'mobile_shop_urlscheme', 'value' => 'com.ecjia.cityo2o://', 'options' => ['type' => 'text']],
            ['code' => 'mobile_share_link', 'value' => 'https://cityo2o.ecjia.com/sites/api/index.php?m=affiliate&c=mobile&a=init&invite_code={$invite_code}', 'options' => ['type' => 'text']],
            ['code' => 'mobile_feedback_autoreply', 'value' => '', 'options' => ['type' => 'textarea']],
            ['code' => 'mobile_touch_qrcode', 'value' => 'data/assets/mobile_touch_qrcode.png', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'mobile_location_range', 'value' => '3', 'options' => ['type' => 'select', 'store_range' => '0,1,2,3,4,5']],
            ['code' => 'mobile_signup_reward_notice', 'value' => "1.本活动仅限手机号注册新用户参与；\r\n2.每个手机号仅限参与一次；\r\n3.领取红包查看方式：【我的－我的钱包】查看；", 'options' => ['type' => 'text']],
            ['code' => 'mobile_signup_reward', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1']],
        ];

        return $data;
    }





}