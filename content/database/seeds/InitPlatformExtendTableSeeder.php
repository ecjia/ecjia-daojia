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
 * 插入数据 `ecjia_platform_extend` 公众平台扩展
 */
use Royalcms\Component\Database\Seeder;

class InitPlatformExtendTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array(
                'ext_id'        => '1',
                'ext_name'      => '积分查询',
                'ext_desc'      => '使用插件可以在微信上查询您的积分。 <cite>By ECJIA TEAM.</cite>',
                'ext_code'      => 'mp_jfcx',
                'ext_config'    => 'a:0:{}',
                'enabled'       => '1'
            ),
            array(
                'ext_id'        => '2',
                'ext_name'      => '订单查询',
                'ext_desc'      => '使用插件可以在微信上查询您的订单信息。 <cite>By ECJIA TEAM.</cite>',
                'ext_code'      => 'mp_orders',
                'ext_config'    => 'a:0:{}',
                'enabled'       => '1'
            ),
            array(
                'ext_id'        => '3',
                'ext_name'      => '刮刮卡',
                'ext_desc'      => '使用插件可以让微信公众平台用户参加刮刮卡活动。 <cite>By ECJIA TEAM.</cite>',
                'ext_code'      => 'mp_ggk',
                'ext_config'    => "a:10:{i:0;a:3:{s:4:\"name\";s:12:\"point_status\";s:4:\"type\";s:8:\"radiobox\";s:5:\"value\";s:1:\"1\";}i:1;a:3:{s:4:\"name\";s:11:\"point_value\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:2:\"20\";}i:2;a:3:{s:4:\"name\";s:9:\"point_num\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:2:\"30\";}i:3;a:3:{s:4:\"name\";s:14:\"point_interval\";s:4:\"type\";s:6:\"select\";s:5:\"value\";s:5:\"86400\";}i:4;a:3:{s:4:\"name\";s:9:\"prize_num\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:2:\"30\";}i:5;a:3:{s:4:\"name\";s:9:\"starttime\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:10:\"2016-12-22\";}i:6;a:3:{s:4:\"name\";s:7:\"endtime\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:10:\"2016-12-31\";}i:7;a:3:{s:4:\"name\";s:4:\"list\";s:4:\"type\";s:8:\"textarea\";s:5:\"value\";s:103:\"特等奖,500,1,1%\n一等奖,300,10,9%\n二等奖,100,50,20%\n三等奖,10,100,25%\n谢谢参与,0,300,35%\";}i:8;a:3:{s:4:\"name\";s:11:\"description\";s:4:\"type\";s:8:\"textarea\";s:5:\"value\";s:15:\"刮开有惊喜\";}i:9;a:3:{s:4:\"name\";s:8:\"media_id\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:1:\"4\";}}",
                'enabled'       => '1'
            ),
            array(
                'ext_id'        => '4',
                'ext_name'      => '签到',
                'ext_desc'      => '使用插件可以让微信公众平台用户签到获取积分。 <cite>By ECJIA TEAM.</cite>',
                'ext_code'      => 'mp_checkin',
                'ext_config'    => 'a:4:{i:0;a:3:{s:4:"name";s:12:"point_status";s:4:"type";s:8:"radiobox";s:5:"value";s:1:"1";}i:1;a:3:{s:4:"name";s:11:"point_value";s:4:"type";s:4:"text";s:5:"value";s:2:"10";}i:2;a:3:{s:4:"name";s:9:"point_num";s:4:"type";s:4:"text";s:5:"value";s:2:"10";}i:3;a:3:{s:4:"name";s:14:"point_interval";s:4:"type";s:6:"select";s:5:"value";s:2:"60";}}',
                'enabled'       => '1'
            ),
            array(
                'ext_id'        => '5',
                'ext_name'      => '大转盘',
                'ext_desc'      => '使用插件可以让微信公众平台用户参加大转盘活动。 <cite>By ECJIA TEAM.</cite>',
                'ext_code'      => 'mp_dzp',
                'ext_config'    => 'a:10:{i:0;a:3:{s:4:"name";s:12:"point_status";s:4:"type";s:8:"radiobox";s:5:"value";s:1:"0";}i:1;a:3:{s:4:"name";s:11:"point_value";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:2;a:3:{s:4:"name";s:9:"point_num";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:3;a:3:{s:4:"name";s:14:"point_interval";s:4:"type";s:6:"select";s:5:"value";s:5:"86400";}i:4;a:3:{s:4:"name";s:9:"prize_num";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:5;a:3:{s:4:"name";s:9:"starttime";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:6;a:3:{s:4:"name";s:7:"endtime";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:7;a:3:{s:4:"name";s:4:"list";s:4:"type";s:8:"textarea";s:5:"value";s:0:"";}i:8;a:3:{s:4:"name";s:11:"description";s:4:"type";s:8:"textarea";s:5:"value";s:0:"";}i:9;a:3:{s:4:"name";s:8:"media_id";s:4:"type";s:4:"text";s:5:"value";s:0:"";}}',
                'enabled'       => '1'
            ),
            array(
                'ext_id'        => '6',
                'ext_name'      => '砸金蛋',
                'ext_desc'      => '使用插件可以让微信公众平台用户参加砸金蛋活动。 <cite>By ECJIA TEAM.</cite>',
                'ext_code'      => 'mp_zjd',
                'ext_config'    => 'a:10:{i:0;a:3:{s:4:"name";s:12:"point_status";s:4:"type";s:8:"radiobox";s:5:"value";s:1:"1";}i:1;a:3:{s:4:"name";s:11:"point_value";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:2;a:3:{s:4:"name";s:9:"point_num";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:3;a:3:{s:4:"name";s:14:"point_interval";s:4:"type";s:6:"select";s:5:"value";s:5:"86400";}i:4;a:3:{s:4:"name";s:9:"prize_num";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:5;a:3:{s:4:"name";s:9:"starttime";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:6;a:3:{s:4:"name";s:7:"endtime";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:7;a:3:{s:4:"name";s:4:"list";s:4:"type";s:8:"textarea";s:5:"value";s:0:"";}i:8;a:3:{s:4:"name";s:11:"description";s:4:"type";s:8:"textarea";s:5:"value";s:0:"";}i:9;a:3:{s:4:"name";s:8:"media_id";s:4:"type";s:4:"text";s:5:"value";s:1:"5";}}',
                'enabled'       => '1'
            ),
            array(
                'ext_id'        => '7',
                'ext_name'      => '多客服转接',
                'ext_desc'      => '使用插件可以玩转客服。 <cite>By ECJIA TEAM.</cite>',
                'ext_code'      => 'mp_kefu',
                'ext_config'    => 'a:2:{i:0;a:3:{s:4:"name";s:11:"kefu_status";s:4:"type";s:8:"radiobox";s:5:"value";s:0:"";}i:1;a:3:{s:4:"name";s:10:"kefu_value";s:4:"type";s:4:"text";s:5:"value";s:0:"";}}',
                'enabled'       => '1'
            ),
            array(
                'ext_id'        => '8',
                'ext_name'      => '用户绑定',
                'ext_desc'      => '使用插件可以将微信公众平台用户绑定到本站会员上。 <cite>By ECJIA TEAM.</cite>',
                'ext_code'      => 'mp_userbind',
                'ext_config'    => 'a:6:{i:0;a:3:{s:4:"name";s:12:"point_status";s:4:"type";s:8:"radiobox";s:5:"value";s:0:"";}i:1;a:3:{s:4:"name";s:11:"point_value";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:2;a:3:{s:4:"name";s:9:"point_num";s:4:"type";s:4:"text";s:5:"value";s:0:"";}i:3;a:3:{s:4:"name";s:14:"point_interval";s:4:"type";s:6:"select";s:5:"value";s:0:"";}i:4;a:3:{s:4:"name";s:12:"bonus_status";s:4:"type";s:6:"select";s:5:"value";s:0:"";}i:5;a:3:{s:4:"name";s:8:"bonus_id";s:4:"type";s:4:"text";s:5:"value";s:0:"";}}',
                'enabled'       => '1'
            ),
            array(
                'ext_id'        => '9',
                'ext_name'      => '商品推荐',
                'ext_desc'      => '商品推荐，获得商城的商品信息。 <cite>By ECJIA TEAM.</cite>',
                'ext_code'      => 'mp_goods',
                'ext_config'    => 'a:0:{}',
                'enabled'       => '1'
            )
        );

        RC_DB::table('platform_extend')->truncate();
        RC_DB::table('platform_extend')->insert($data);
    }
}