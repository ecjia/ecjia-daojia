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

class BasicSetting extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'basic';

    /**
     * 排序
     * @var int
     */
    protected $sort = 2;

    public function __construct()
    {
        $this->name = __('基本设置', 'setting');
    }

    public function handle()
    {
        $data = [
            ['code' => 'lang', 'value' => 'zh_CN', 'options' => ['type' => 'manual']],
            ['code' => 'icp_number', 'value' => '沪ICP备20170120号', 'options' => ['type' => 'text']],
            ['code' => 'icp_file', 'value' => '', 'options' => ['type' => 'file', 'store_dir' => 'data/cert/']],
            ['code' => 'name_of_region_1', 'value' => '国家', 'options' => ['type' => 'text']],
            ['code' => 'name_of_region_2', 'value' => '省', 'options' => ['type' => 'text']],
            ['code' => 'name_of_region_3', 'value' => '市', 'options' => ['type' => 'text']],
            ['code' => 'name_of_region_4', 'value' => '区', 'options' => ['type' => 'text']],
            ['code' => 'date_format', 'value' => 'Y-m-d', 'options' => ['type' => 'hidden']],
            ['code' => 'time_format', 'value' => 'Y-m-d H:i:s', 'options' => ['type' => 'text']],
            ['code' => 'stats_code', 'value' => "<script>\r\nvar _hmt = _hmt || [];\r\n(function() {\r\n  var hm = document.createElement(\"script\");\r\n  hm.src = \"https://hm.baidu.com/hm.js?45572e750ba4de1ede0e776212b5f6cd\";\r\n  var s = document.getElementsByTagName(\"script\")[0]; \r\n  s.parentNode.insertBefore(hm, s);\r\n})();\r\n</script>", 'options' => ['type' => 'textarea']],
            ['code' => 'rewrite', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1,2']],
            ['code' => 'cache_time', 'value' => '3600', 'options' => ['type' => 'text']],
            ['code' => 'enable_gzip', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
            ['code' => 'timezone', 'value' => '8', 'options' => ['type' => 'options', 'store_range' => '-12,-11,-10,-9,-8,-7,-6,-5,-4,-3.5,-3,-2,-1,0,1,2,3,3.5,4,4.5,5,5.5,5.75,6,6.5,7,8,9,9.5,10,11,12']],
            ['code' => 'upload_size_limit', 'value' => '64', 'options' => ['type' => 'options', 'store_range' => '-1,0,64,128,256,512,1024,2048,4096']],
            ['code' => 'visit_stats', 'value' => 'on', 'options' => ['type' => 'select', 'store_range' => 'on,off']],
            ['code' => 'watermark', 'value' => '', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'watermark_place', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1,2,3,4,5']],
            ['code' => 'watermark_alpha', 'value' => '65', 'options' => ['type' => 'text']],
            ['code' => 'search_keywords', 'value' => '苹果,连衣裙,男鞋,笔记本,光碟', 'options' => ['type' => 'text']],
            ['code' => 'store_identity_certification', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],

//            ['code' => 'message_board', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
//            ['code' => 'message_check', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],

        ];

        return $data;
    }


    public function getConfigs()
    {
        $config = [
            [
                'cfg_code' => 'lang',
                'cfg_name' => __('系统语言', 'setting'),
                'cfg_desc' => __('商店系统使用的语言，zh_cn是简体中文，zh_tw是繁体中文，en_us是英文', 'setting'),
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'icp_number',
                'cfg_name' => __('ICP证书或ICP备案证书号', 'setting'),
                'cfg_desc' => __('ICP证书号，显示在网站前台底部', 'setting'),
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'icp_file',
                'cfg_name' => __('ICP 备案证书文件', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'name_of_region_1',
                'cfg_name' => __('一级配送区域名称', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'name_of_region_2',
                'cfg_name' => __('二级配送区域名称', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'name_of_region_3',
                'cfg_name' => __('三级配送区域名称', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'name_of_region_4',
                'cfg_name' => __('四级配送区域名称', 'setting'),
                'cfg_desc' => __('最多就支持四级配送区域，分别是国家，省，市，区。这里的区域名称也是可以修改的', 'setting'),
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'date_format',
                'cfg_name' => __('日期格式', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'time_format',
                'cfg_name' => __('时间格式', 'setting'),
                'cfg_desc' => __('例:Y-m-d H:i:s，分别为“年-月-日 小时:分钟:秒”，设置后，主要影响活动商品倒计时', 'setting'),
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'stats_code',
                'cfg_name' => __('统计代码', 'setting'),
                'cfg_desc' => __('您可以将其他访问统计服务商提供的代码添加到每一个页面。', 'setting'),
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'rewrite',
                'cfg_name' => __('URL重写', 'setting'),
                'cfg_desc' => __('URL重写是一种搜索引擎优化技术，可以将动态的地址模拟成静态的HTML文件。需要Apache的支持。', 'setting'),
                'cfg_range' => array(
                    '0' => __('禁用', 'setting'),
                    '1' => __('简单重写', 'setting'),
                    '2' => __('复杂重写', 'setting'),
                ),
            ],

            [
                'cfg_code' => 'cache_time',
                'cfg_name' => __('缓存存活时间（秒）', 'setting'),
                'cfg_desc' => __('前台页面缓存的存活时间，以秒为单位。', 'setting'),
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'enable_gzip',
                'cfg_name' => __('是否启用Gzip模式', 'setting'),
                'cfg_desc' => __('启用Gzip模式可压缩发送页面大小，加快网页传输。需要php支持Gzip。如果已经用Apache等对页面进行Gzip压缩，请禁止该功能。', 'setting'),
                'cfg_range' => array(
                    '0' => __('禁用', 'setting'),
                    '1' => __('启用', 'setting'),
                ),
            ],

            [
                'cfg_code' => 'timezone',
                'cfg_name' => __('默认时区', 'setting'),
                'cfg_desc' => __('如果在中国的话建议选择 (GMT + 08:00)beijing', 'setting'),
                'cfg_range' => array(
                    '-12' 	=> __('(GMT -12:00) 国际日期变更线西', 'setting'),
                    '-11' 	=> __('(GMT -11:00) 中途岛萨摩亚群岛', 'setting'),
                    '-10' 	=> __('(GMT -10:00) 夏威夷', 'setting'),
                    '-9'	=> __('(GMT -09:00) 阿拉斯加', 'setting'),
                    '-8' 	=> __('(GMT -08:00) 太平洋时间 （美国和加拿大）蒂华纳', 'setting'),
                    '-7' 	=> __('(GMT -07:00) 山地时间 （美国和加拿大）', 'setting'),
                    '-6' 	=> __('(GMT -06:00) 中部时间 （美国和加拿大）墨西哥城', 'setting'),
                    '-5' 	=> __('(GMT -05:00) 东部时间（美国和加拿大）, 波哥大, 利马, 基多', 'setting'),
                    '-4' 	=> __('(GMT -04:00) 大西洋时间（加拿大），加拉加斯，拉巴斯', 'setting'),
                    '-3.5' 	=> __('(GMT -03:30) 纽芬兰', 'setting'),
                    '-3' 	=> __('(GMT -03:00) 布拉西拉，布宜诺斯艾利斯，乔治敦，福克兰群岛', 'setting'),
                    '-2' 	=> __('(GMT -02:00) 大西洋中部，阿森松岛，圣赫勒拿岛', 'setting'),
                    '-1' 	=> __('(GMT -01:00) 亚速尔群岛，佛得角群岛', 'setting'),
                    '0' 	=> __('(GMT) 卡萨布兰卡，都柏林，爱丁堡，伦敦，里斯本，蒙罗维亚', 'setting'),
                    '1' 	=> __('(GMT +01:00) 阿姆斯特丹，柏林，布鲁塞尔，马德里，巴黎，罗马', 'setting'),
                    '2' 	=> __('(GMT +02:00) 开罗，赫尔辛基，加里宁格勒，南非', 'setting'),
                    '3' 	=> __('(GMT +03:00) 巴格达，利雅得，莫斯科，内罗毕', 'setting'),
                    '3.5' 	=> __('(GMT +03:30) 德黑兰', 'setting'),
                    '4' 	=> __('(GMT +04:00) 阿布扎比，巴库，马斯喀特，第比利斯', 'setting'),
                    '4.5' 	=> __('(GMT +04:30) 喀布尔', 'setting'),
                    '5' 	=> __('(GMT +05:00) 叶卡捷琳堡，伊斯兰堡，卡拉奇，塔什干', 'setting'),
                    '5.5' 	=> __('(GMT +05:30) 孟买，加尔各答，马德拉斯，新德里', 'setting'),
                    '5.75' 	=> __('(GMT +05:45) 加德满都', 'setting'),
                    '6' 	=> __('(GMT +06:00) 阿拉木图，科伦坡，达卡，新西伯利亚', 'setting'),
                    '6.5' 	=> __('(GMT +06:30) 仰光', 'setting'),
                    '7' 	=> __('(GMT +07:00) 曼谷，河内，雅加达', 'setting'),
                    '8' 	=> __('(GMT +08:00) 北京，香港，珀斯，新加坡，台北', 'setting'),
                    '9' 	=> __('(GMT +09:00) 大阪，札幌，首尔，东京，雅库茨克', 'setting'),
                    '9.5' 	=> __('(GMT +09:30) 阿德莱德，达尔文', 'setting'),
                    '10' 	=> __('(GMT +10:00) 堪培拉，关岛，墨尔本，悉尼，符拉迪沃斯托克', 'setting'),
                    '11' 	=> __('(GMT +11:00) 马加丹，新喀里多尼亚，所罗门群岛', 'setting'),
                    '12' 	=> __('(GMT +12:00) 奥克兰，惠灵顿，斐济，马歇尔岛', 'setting'),
                ),
            ],

            [
                'cfg_code' => 'upload_size_limit',
                'cfg_name' => __('附件上传大小', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '-1' 	=> __('服务默认设置', 'setting'),
                    '0' 	=> __('0KB', 'setting'),
                    '64' 	=> __('64KB', 'setting'),
                    '128' 	=> __('128KB', 'setting'),
                    '256' 	=> __('256KB', 'setting'),
                    '512' 	=> __('512KB', 'setting'),
                    '1024' 	=> __('1MB', 'setting'),
                    '2048' 	=> __('2MB', 'setting'),
                    '4096' 	=> __('4MB', 'setting'),
                ),
            ],

            [
                'cfg_code' => 'visit_stats',
                'cfg_name' => __('站点访问统计', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    'on' => __('关闭', 'setting'),
                    'off' => __('开启', 'setting'),
                ),
            ],

            [
                'cfg_code' => 'watermark',
                'cfg_name' => __('水印文件', 'setting'),
                'cfg_desc' => __('水印文件须为gif格式才可支持透明度设置。', 'setting'),
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'watermark_place',
                'cfg_name' => __('水印位置', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '0' => __('无', 'setting'),
                    '1' => __('左上', 'setting'),
                    '2' => __('右上', 'setting'),
                    '3' => __('居中', 'setting'),
                    '4' => __('左下', 'setting'),
                    '5' => __('右下', 'setting'),
                ),
            ],

            [
                'cfg_code' => 'watermark_alpha',
                'cfg_name' => __('水印透明度', 'setting'),
                'cfg_desc' => __('水印的透明度，可选值为0-100。当设置为100时则为不透明。', 'setting'),
                'cfg_range' => '',
            ],

            [
                'cfg_code' => 'search_keywords',
                'cfg_name' => __('首页搜索的关键字', 'setting'),
                'cfg_desc' => __('首页显示的搜索关键字,请用半角逗号(,)分隔多个关键字', 'setting'),
                'cfg_range' => '',
            ],


            [
                'cfg_code' => 'store_identity_certification',
                'cfg_name' => __('商家强制认证', 'setting'),
                'cfg_desc' => __('设置是否需要认证商家资质，如果开启则认证通过后的商家才能开店和显示', 'goods'),
                'cfg_range' => array(
                    '0' => __('否', 'setting'),
                    '1' => __('是', 'setting'),
                ),
            ],





        ];

        return $config;
    }


}