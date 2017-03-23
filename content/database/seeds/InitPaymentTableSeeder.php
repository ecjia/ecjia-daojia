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
 * 插入数据 `ecjia_payment` 支付方式
 */
use Royalcms\Component\Database\Seeder;

class InitPaymentTableSeeder extends Seeder
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
              'pay_id'      => '9',
              'pay_code'    => 'pay_balance',
              'pay_name'    => '余额支付',
              'pay_fee'     => '0',
              'pay_desc'    => '使用帐户余额支付。只有会员才能使用，通过设置信用额度，可以透支。 <cite>By ECJIA TEAM.</cite>',
              'pay_order'   => '0',
              'pay_config'  => 'a:0:{}',
              'enabled'     => '1',
              'is_cod'      => '0',
              'is_online'   => '1'
            ),
            array(
                'pay_id'      => '10',
                'pay_code'    => 'pay_alipay',
                'pay_name'    => '支付宝',
                'pay_fee'     => '0',
                'pay_desc'    => '支付宝网站(www.alipay.com) 是国内先进的网上支付平台。<br/>支付宝收款接口：在线即可开通，<font color=\\"red\\"><b>零预付，免年费</b></font>，单笔阶梯费率，无流量限制。<br/><a href=\\"https://b.alipay.com/order/productSet.htm#prodAreaWap\\" target=\\"_blank\\"><font color=\\"red\\">立即在线申请</font></a><cite>By ECJIA TEAM.</cite>',
                'pay_order'   => '0',
                'pay_config'  => 'a:6:{i:0;a:3:{s:4:"name";s:14:"alipay_account";s:4:"type";s:4:"text";s:5:"value";s:12:"请先填写";}i:1;a:3:{s:4:"name";s:10:"alipay_key";s:4:"type";s:4:"text";s:5:"value";s:12:"请先填写";}i:2;a:3:{s:4:"name";s:14:"alipay_partner";s:4:"type";s:4:"text";s:5:"value";s:16:"2088xxxxxxxxxxxx";}i:3;a:3:{s:4:"name";s:17:"alipay_pay_method";s:4:"type";s:6:"select";s:5:"value";s:1:"2";}i:4;a:3:{s:4:"name";s:11:"private_key";s:4:"type";s:8:"textarea";s:5:"value";s:0:"";}i:5;a:3:{s:4:"name";s:17:"private_key_pkcs8";s:4:"type";s:8:"textarea";s:5:"value";s:0:"";}}',
                'enabled'     => '1',
                'is_cod'      => '0',
                'is_online'   => '1'
            ),
            array(
                'pay_id'      => '11',
                'pay_code'    => 'pay_cod',
                'pay_name'    => '货到付款',
                'pay_fee'     => '0',
                'pay_desc'    => '开通城市：×××货到付款区域：××× <cite>By ECJIA TEAM.</cite>',
                'pay_order'   => '0',
                'pay_config'  => 'a:0:{}',
                'enabled'     => '1',
                'is_cod'      => '1',
                'is_online'   => '0'
            ),
            array(
                'pay_id'      => '12',
                'pay_code'    => 'pay_cash',
                'pay_name'    => '现金支付',
                'pay_fee'     => '0',
                'pay_desc'    => '现金支付 <cite>By ECJIA TEAM.</cite>',
                'pay_order'   => '0',
                'pay_config'  => 'a:0:{}',
                'enabled'     => '1',
                'is_cod'      => '1',
                'is_online'   => '0'
            ),
            array(
                'pay_id'      => '15',
                'pay_code'    => 'pay_bank',
                'pay_name'    => '银行转帐',
                'pay_fee'     => '0',
                'pay_desc'    => '银行名称收款人信息：全称 ××× ；帐号或地址 ××× ；开户行 ×××。注意事项：办理电汇时，请在电汇单“汇款用途”一栏处注明您的订单号。 <cite>By ECJIA TEAM.</cite>',
                'pay_order'   => '0',
                'pay_config'  => 'a:1:{i:0;a:3:{s:4:"name";s:17:"bank_account_info";s:4:"type";s:8:"textarea";s:5:"value";s:0:"";}}',
                'enabled'     => '1',
                'is_cod'      => '0',
                'is_online'   => '0'
            ),
        );

        RC_DB::table('payment')->truncate();
        RC_DB::table('payment')->insert($data);
    }
}