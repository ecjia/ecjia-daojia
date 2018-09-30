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

class G02Basic extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'basic';

    /**
     * 名称
     * @var string
     */
    protected $name = '基本设置';

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
            ['code' => 'lang', 'value' => 'zh_CN', 'options' => ['type' => 'manual']],
            ['code' => 'icp_number', 'value' => '沪ICP备20170120号', 'options' => ['type' => 'text']],
            ['code' => 'icp_file', 'value' => '', 'options' => ['type' => 'file', 'store_dir' => 'data/cert/']],
            ['code' => 'watermark', 'value' => '', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'watermark_place', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1,2,3,4,5']],
            ['code' => 'watermark_alpha', 'value' => '65', 'options' => ['type' => 'text']],
            ['code' => 'use_storage', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'market_price_rate', 'value' => '1.2', 'options' => ['type' => 'text']],
            ['code' => 'rewrite', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1,2']],
            ['code' => 'integral_name', 'value' => '积分', 'options' => ['type' => 'text']],
            ['code' => 'integral_scale', 'value' => '1', 'options' => ['type' => 'text']],
            ['code' => 'integral_percent', 'value' => '1', 'options' => ['type' => 'text']],
            ['code' => 'sn_prefix', 'value' => 'ECS', 'options' => ['type' => 'text']],
            ['code' => 'no_picture', 'value' => '', 'options' => ['type' => 'file', 'store_dir' => 'data/assets/']],
            ['code' => 'stats_code', 'value' => "<script>\r\nvar _hmt = _hmt || [];\r\n(function() {\r\n  var hm = document.createElement(\"script\");\r\n  hm.src = \"https://hm.baidu.com/hm.js?45572e750ba4de1ede0e776212b5f6cd\";\r\n  var s = document.getElementsByTagName(\"script\")[0]; \r\n  s.parentNode.insertBefore(hm, s);\r\n})();\r\n</script>", 'options' => ['type' => 'textarea']],
            ['code' => 'cache_time', 'value' => '3600', 'options' => ['type' => 'text']],
            ['code' => 'register_points', 'value' => '20', 'options' => ['type' => 'text']],
            ['code' => 'enable_gzip', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
            ['code' => 'top10_time', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '0,1,2,3,4']],
            ['code' => 'timezone', 'value' => '8', 'options' => ['type' => 'options', 'store_range' => '-12,-11,-10,-9,-8,-7,-6,-5,-4,-3.5,-3,-2,-1,0,1,2,3,3.5,4,4.5,5,5.5,5.75,6,6.5,7,8,9,9.5,10,11,12']],
            ['code' => 'upload_size_limit', 'value' => '64', 'options' => ['type' => 'options', 'store_range' => '-1,0,64,128,256,512,1024,2048,4096']],
//             ['code' => 'comment_factor', 'value' => '0', 'options' => ['type' => 'hidden', 'store_range' => '0,1,2,3']],
            ['code' => 'enable_order_check', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
            ['code' => 'default_storage', 'value' => '1000', 'options' => ['type' => 'text']],
            ['code' => 'bgcolor', 'value' => '#FFFFFF', 'options' => ['type' => 'text']],
            ['code' => 'visit_stats', 'value' => 'on', 'options' => ['type' => 'select', 'store_range' => 'on,off']],
            ['code' => 'send_mail_on', 'value' => 'off', 'options' => ['type' => 'select', 'store_range' => 'on,off']],
            ['code' => 'auto_generate_gallery', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'retain_original_img', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'member_email_validate', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'message_board', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'certificate_id', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'token', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'certi', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'send_verify_email', 'value' => '0', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'ent_id', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'ent_ac', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'ent_sign', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'ent_email', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'message_check', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '1,0']],
            ['code' => 'review_goods', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
            ['code' => 'store_identity_certification', 'value' => '1', 'options' => ['type' => 'select', 'store_range' => '0,1']],
            ['code' => 'comment_award_open', 'value' => '0', 'options' => ['type' => 'hidden']],
            ['code' => 'comment_award', 'value' => '0', 'options' => ['type' => 'hidden']],
            ['code' => 'comment_award_rules', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'comment_check', 'value' => '1', 'options' => ['type' => 'hidden']],
        ];

        return $data;
    }





}