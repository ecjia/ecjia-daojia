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

namespace Ecjia\Resources\Components\SettingComponents;


use Ecjia\Component\Config\Component\ComponentAbstract;

class ServiceSetting extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'service';

    /**
     * 排序
     * @var int
     */
    protected $sort = 17;

    public function __construct()
    {
        $this->name = __('客服设置', 'setting');
    }


    public function handle()
    {
        $config = [
            [
                'cfg_code' => 'qq',
                'cfg_name' => __('客服QQ号码', 'setting'),
                'cfg_desc' => __('如果您有多个客服的QQ号码，请在每个号码之间使用半角逗号（,）分隔。', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'ww',
                'cfg_name' => __('淘宝旺旺', 'setting'),
                'cfg_desc' => __('如果您有多个客服的淘宝旺旺号码，请在每个号码之间使用半角逗号（,）分隔。', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'skype',
                'cfg_name' => __('Skype', 'setting'),
                'cfg_desc' => __('如果您有多个客服的Skype号码，请在每个号码之间使用半角逗号（,）分隔。提示：你需要在你的Skype隐私设置中启用状态显示功能', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'ym',
                'cfg_name' => __('微信号码', 'setting'),
                'cfg_desc' => __('如果您有多个客服的微信码，请在每个号码之间使用半角逗号（,）分隔。', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'msn',
                'cfg_name' => __('微博号码', 'setting'),
                'cfg_desc' => __('如果您有多个客服的微博号码，请在每个号码之间使用半角逗号（,）分隔。', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'service_email',
                'cfg_name' => __('客服邮件地址', 'setting'),
                'cfg_desc' => __('设置客服邮件地址，如:开启下单发送邮件，系统会自动发送邮件给我们客服', 'setting'),
                'cfg_range' => '',
                'cfg_value' => 'ecjia@ecjia.com',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'service_phone',
                'cfg_name' => __('客服电话', 'setting'),
                'cfg_desc' => __('联系平台的电话', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '4001-021-758',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'shop_weibo_url',
                'cfg_name' => __('微博地址', 'setting'),
                'cfg_desc' => __('微博地址链接，例:商家后台底部点击微博后，跳到对应微博首页', 'setting'),
                'cfg_range' => '',
                'cfg_value' => 'http://weibo.com/ECMBT',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'shop_wechat_qrcode',
                'cfg_name' => __('微信二维码', 'setting'),
                'cfg_desc' => __('微信公众号二维码展示，例:商家后台底部展示', 'setting'),
                'cfg_range' => '',
                'cfg_value' => 'data/assets/ecjia-intro/shop_wechat_qrcode.jpg',
                'cfg_type' => 'file',
                'cfg_store_dir' => 'data/assets/',
            ],

        ];

        return $config;
    }
}