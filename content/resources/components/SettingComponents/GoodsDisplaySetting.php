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

class GoodsDisplaySetting extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'goods_display';

    /**
     * 排序
     * @var int
     */
    protected $sort = 12;

    public function __construct()
    {
        $this->name = __('商品显示设置', 'goods');
    }

    public function handle()
    {
        $config = [
            [
                'cfg_code' => 'page_size',
                'cfg_name' => __('商品分类页列表的数量', 'goods'),
                'cfg_desc' => __('设置商品列表页商品显示数量，如设置10，则列表只能显示10件', 'goods'),
                'cfg_range' => '',
                'cfg_value' => '20',
                'cfg_type'  => 'text',
            ],

            [
                'cfg_code' => 'bought_goods',
                'cfg_name' => __('相关商品数量', 'goods'),
                'cfg_desc' => __('显示多少个购买此商品的人还买过哪些商品', 'goods'),
                'cfg_range' => '',
                'cfg_value' => '15',
                'cfg_type'  => 'text',
            ],

            [
                'cfg_code' => 'related_goods_number',
                'cfg_name' => __('关联商品显示数量', 'goods'),
                'cfg_desc' => __('此设置项，控制用户端商品详情关联商品模块的商品显示数量','goods'),
                'cfg_range' => '',
                'cfg_value' => '5',
                'cfg_type'  => 'text',
            ],

            [
                'cfg_code' => 'goods_gallery_number',
                'cfg_name' => __('商品详情页相册图片数量', 'goods'),
                'cfg_desc' => __('此设置项，控制商品详请页商品相册的显示数量','goods'),
                'cfg_range' => '',
                'cfg_value' => '5',
                'cfg_type'  => 'text'
            ],

            [
                'cfg_code' => 'recommend_order',
                'cfg_name' => __('推荐商品排序', 'goods'),
                'cfg_desc' => __('推荐排序适合少量推荐，随机显示大量推荐', 'goods'),
                'cfg_range' => array(
                    '0' => __('推荐排序', 'goods'),
                    '1' => __('随机显示', 'goods'),
                ),
                'cfg_value' => '0',
                'cfg_type'  => 'select'
            ],

            [
                'cfg_code' => 'show_goodssn',
                'cfg_name' => __('是否显示货号', 'goods'),
                'cfg_desc' => __('此设置项，控制用户端商品详情页货号显示开关，设置“不显示”，商品详情不需要显示货号', 'goods'),
                'cfg_range' => array(
                    '0' => __('不显示', 'goods'),
                    '1' => __('显示', 'goods'),
                ),
                'cfg_value' => '0',
                'cfg_type'  => 'select'
            ],

            [
                'cfg_code' => 'show_goodsweight',
                'cfg_name' => __('是否显示重量', 'goods'),
                'cfg_desc' => __('此设置项，控制用户端商品详情页重量显示开关，设置“不显示”，商品详情不需要显示重量', 'goods'),
                'cfg_range' => array(
                    '0' => __('不显示', 'goods'),
                    '1' => __('显示', 'goods'),
                ),
                'cfg_value' => '0',
                'cfg_type'  => 'select'
            ],

            [
                'cfg_code' => 'show_goodsnumber',
                'cfg_name' => __('是否显示库存', 'goods'),
                'cfg_desc' => __('此设置项，控制用户端商品详情页库存显示开关，设置“不显示”，商品详情不需要显示库存', 'goods'),
                'cfg_range' => array(
                    '0' => __('不显示', 'goods'),
                    '1' => __('显示', 'goods'),
                ),
                'cfg_value' => '1',
                'cfg_type'  => 'select'
            ],

            [
                'cfg_code' => 'show_addtime',
                'cfg_name' => __('是否显示上架时间', 'goods'),
                'cfg_desc' => __('此设置项，控制用户端商品详情页上架时间显示开关，设置“不显示”，商品详情不需要显示上架时间', 'goods'),
                'cfg_range' => array(
                    '0' => __('不显示', 'goods'),
                    '1' => __('显示', 'goods'),
                ),
                'cfg_value' => '0',
                'cfg_type'  => 'select'
            ],

            [
                'cfg_code' => 'show_marketprice',
                'cfg_name' => __('是否显示市场价格', 'goods'),
                'cfg_desc' => __('此设置项，控制用户端商品详情页市场价格显示开关，设置“不显示”，商品详情不需要显示市场价格', 'goods'),
                'cfg_range' => array(
                    '0' => __('不显示', 'goods'),
                    '1' => __('显示', 'goods'),
                ),
                'cfg_value' => '1',
                'cfg_type'  => 'select'
            ],

            [
                'cfg_code' => 'show_brand',
                'cfg_name' => __('是否显示品牌', 'goods'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '0' => __('不显示', 'goods'),
                    '1' => __('显示', 'goods'),
                ),
                'cfg_value' => '1',
                'cfg_type'  => 'select'
            ],

            [
                'cfg_code' => 'show_product',
                'cfg_name' => __('商品列表是否显示货品', 'goods'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '0' => __('不显示', 'goods'),
                    '1' => __('显示', 'goods'),
                ),
                'cfg_value' => '1',
                'cfg_type'  => 'select'
            ],

            [
                'cfg_code' => 'best_number',
                'cfg_name' => __('精品推荐数量', 'goods'),
                'cfg_desc' => __('此设置项，控制用户端精品推荐商品显示数量', 'goods'),
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'text'
            ],

            [
                'cfg_code' => 'new_number',
                'cfg_name' => __('新品推荐数量', 'goods'),
                'cfg_desc' => __('此设置项，控制用户端新品推荐商品显示数量', 'goods'),
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'text'
            ],

            [
                'cfg_code' => 'hot_number',
                'cfg_name' => __('热销商品数量', 'goods'),
                'cfg_desc' => __('此设置项，控制用户端热销商品显示数量', 'goods'),
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'text'
            ],

            [
                'cfg_code' => 'promote_number',
                'cfg_name' => __('促销商品的数量', 'goods'),
                'cfg_desc' => __('此设置项，控制用户端促销商品显示数量', 'goods'),
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'text'
            ],

            [
                'cfg_code' => 'group_goods_number',
                'cfg_name' => __('团购商品的数量', 'goods'),
                'cfg_desc' => __('此设置项，控制用户端团购商品显示数量', 'goods'),
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'text'
            ],

            [
                'cfg_code' => 'top_number',
                'cfg_name' => __('销量排行数量', 'goods'),
                'cfg_desc' => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'text'
            ],

            [
                'cfg_code' => 'history_number',
                'cfg_name' => __('浏览历史数量', 'goods'),
                'cfg_desc' => '',
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'text'
            ],

            [
                'cfg_code' => 'comments_number',
                'cfg_name' => __('评论数量', 'goods'),
                'cfg_desc' => __('显示在商品详情页的用户评论数量。', 'goods'),
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type'  => 'text'
            ],

            [
                'cfg_code' => 'attr_related_number',
                'cfg_name' => __('属性关联的商品数量', 'goods'),
                'cfg_desc' => __('在商品详情页面显示多少个属性关联的商品。', 'goods'),
                'cfg_range' => '',
                'cfg_value' => '5',
                'cfg_type'  => 'text'
            ],
        ];
        return $config;
    }
}