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

class WapSetting extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'wap';

    /**
     * 排序
     * @var int
     */
    protected $sort = 9;

    public function __construct()
    {
        $this->name = __('H5设置', 'setting');
    }


    public function handle()
    {
        $data = [
            ['code' => 'wap_config', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'wap_logo', 'value' => 'data/assets/ecjia-intro/wap_logo.png', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'map_qq_key', 'value' => 'HVNBZ-HHR3P-HVBDP-LID55-D2YM3-2AF2W', 'options' => ['type' => 'text', 'sort_order' => '2']],
            ['code' => 'map_qq_referer', 'value' => 'ecjiaapp', 'options' => ['type' => 'text', 'sort_order' => '3']],
            ['code' => 'wap_app_download_show', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0', 'sort_order' => '11']],
            ['code' => 'wap_app_download_img', 'value' => 'data/assets/ecjia-intro/wap_app_download_img.png', 'options' => ['type' => 'file', 'store_range' => 'data/assets/', 'sort_order' => '12']],
        ];

        return $data;
    }

    public function getConfigs()
    {
        $config = [
            [
                'cfg_code' => 'wap_config',
                'cfg_name' => __('是否使用H5应用功能', 'setting'),
                'cfg_desc' => __('此功能不仅可以在APP中内嵌使用，还可以在微信公众号中作为微信商城使用。', 'setting'),
                'cfg_range' => array(
                    '0' => __('关闭', 'setting'),
                    '1' => __('开启', 'setting'),
                ),
            ],

            [
                'cfg_code' => 'wap_logo',
                'cfg_name' => __('H5 LOGO上传', 'setting'),
                'cfg_desc' => __('适用于收藏夹图标，为了更好地兼容各种手机类型，LOGO 最好为png图片', 'setting'),
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'wap_app_download_show',
                'cfg_name' => __('是否推广APP下载', 'setting'),
                'cfg_desc' => __('在H5首页底部推广您的APP，增加下载量。', 'setting'),
                'cfg_range' => array(
                    '0' => '关闭',
                    '1' => '开启',
                ),
            ],

            [
                'cfg_code' => 'wap_app_download_img',
                'cfg_name' => __('推广APP下载图片', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'map_qq_referer',
                'cfg_name' => __('腾讯地图应用名称', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'map_qq_key',
                'cfg_name' => __('腾讯地图KEY', 'setting'),
                'cfg_desc' => __('使用QQ账号，进行<a target="_blank" href="http://lbs.qq.com/key.html">开发密钥申请</a>，填写应用名及应用描述即可申请。一个账号可以申请多个key。', 'setting'),
                'cfg_range' => '',
            ],

        ];

        return $config;
    }



}