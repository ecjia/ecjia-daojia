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

class ShopInfoSetting extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'shop_info';

    /**
     * 排序
     * @var int
     */
    protected $sort = 1;

    public function __construct()
    {
        $this->name = __('网店信息', 'setting');
    }


    public function handle()
    {
        $config = [
            [
                'cfg_code' => 'shop_name',
                'cfg_name' => __('商店名称', 'setting'),
                'cfg_desc' => __('网店的名称', 'setting'),
                'cfg_range' => '',
                'cfg_value' => 'ECJia到家',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'shop_title',
                'cfg_name' => __('商店标题', 'setting'),
                'cfg_desc' => __('商店的标题将显示在浏览器的标题栏', 'setting'),
                'cfg_range' => '',
                'cfg_value' => 'ECJia到家 - 同城上门O2O解决方案',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'shop_desc',
                'cfg_name' => __('商店描述', 'setting'),
                'cfg_desc' => __('商店描述内容，将显示在浏览器的Description', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'shop_keywords',
                'cfg_name' => __('商店关键字', 'setting'),
                'cfg_desc' => __('商店的关键字，将显示在浏览器的Keywords', 'setting'),
                'cfg_range' => '',
                'cfg_value' => 'ECJia',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'shop_country',
                'cfg_name' => __('指定运营国家', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => '',
                'cfg_value' => 'CN',
                'cfg_type' => 'manual',
            ],

            [
                'cfg_code' => 'shop_province',
                'cfg_name' => __('所在省份', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => '',
                'cfg_value' => 'CN31',
                'cfg_type' => 'manual',
            ],

            [
                'cfg_code' => 'shop_city',
                'cfg_name' => __('所在城市', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => '',
                'cfg_value' => 'CN3101',
                'cfg_type' => 'manual',
            ],

            [
                'cfg_code' => 'shop_address',
                'cfg_name' => __('详细地址', 'setting'),
                'cfg_desc' => __('填写后可以显示在前台页面的最底下', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'shop_closed',
                'cfg_name' => __('暂时关闭网站', 'setting'),
                'cfg_desc' => __('商店需升级或者其他原因临时关闭网站', 'setting'),
                'cfg_range' => array(
                    '0' => __('否', 'setting'),
                    '1' => __('是', 'setting'),
                ),
                'cfg_value' => '0',
                'cfg_type' => 'select',
            ],

            [
                'cfg_code' => 'shop_logo',
                'cfg_name' => __('商店 Logo', 'setting'),
                'cfg_desc' => __('请在上传前将图片的文件名命名为logo.gif', 'setting'),
                'cfg_range' => '',
                'cfg_value' => 'data/assets/ecjia-intro/shop_logo.gif',
                'cfg_type' => 'file',
                'cfg_store_dir' => 'content/themes/{$template}/images/',
            ],

            [
                'cfg_code' => 'shop_notice',
                'cfg_name' => __('商店公告', 'setting'),
                'cfg_desc' => __('以上内容将显示在首页商店公告中,注意控制公告内容长度不要超过公告显示区域大小。', 'setting'),
                'cfg_range' => '',
                'cfg_value' => 'ecjia系统，追求极致体验',
                'cfg_type' => 'textarea',
            ],

            [
                'cfg_code' => 'company_name',
                'cfg_name' => __('公司名称', 'setting'),
                'cfg_desc' => __('设置商城对应的公司名称', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '上海商创网络科技有限公司',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'licensed',
                'cfg_name' => __('是否显示 Licensed', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '0' => __('否', 'setting'),
                    '1' => __('是', 'setting'),
                ),
                'cfg_value' => '1',
                'cfg_type' => 'select',
            ],

            [
                'cfg_code' => 'close_comment',
                'cfg_name' => __('关闭网店的原因', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type' => 'hidden',
            ],
        ];
        return $config;
    }
}