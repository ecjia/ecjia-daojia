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
 * 插入数据 `ecjia_mail_templates` 邮件模板
 */
use Royalcms\Component\Database\Seeder;

class InitMailTemplatesTableSeeder extends Seeder
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
                'template_id'       => '1',
                'template_code'     => 'send_password',
                'is_html'           => '1',
                'template_subject'  => '密码找回',
                'template_content'  => "<p>{\$user_name}您好！<br/> <br/> 您已经进行了密码重置的操作，请点击以下链接(或者复制到您的浏览器):<br/> <br/> <a href=\"{\$reset_email}\" target=\"_blank\">{\$reset_email}</a><br/> <br/> 以确认您的新密码重置操作！<br/> <br/> {\$shop_name}<br/> {\$send_date}</p>",
                'last_modify'       => '1443408734',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '2',
                'template_code'     => 'order_confirm',
                'is_html'           => '0',
                'template_subject'  => '订单确认通知',
                'template_content'  => "亲爱的{\$order.consignee}，你好！ \n\n我们已经收到您于 {\$order.formated_add_time} 提交的订单，该订单编号为：{\$order.order_sn} 请记住这个编号以便日后的查询。\n\n{\$shop_name}\n{\$sent_date}\n\n\n",
                'last_modify'       => '1158226370',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '3',
                'template_code'     => 'deliver_notice',
                'is_html'           => '1',
                'template_subject'  => '发货通知',
                'template_content'  => "亲爱的{\$order.consignee}。你好！</br></br>\n\n您的订单{\$order.order_sn}已于{\$send_time}按照您预定的配送方式给您发货了。</br>\n</br>\n{if \$order.invoice_no}发货单号是{\$order.invoice_no}。</br>{/if}\n</br>\n在您收到货物之后请点击下面的链接确认您已经收到货物：</br>\n<a href=\"{\$confirm_url}\" target=\"_blank\">{\$confirm_url}</a></br></br>\n如果您还没有收到货物可以点击以下链接给我们留言：</br></br>\n<a href=\"{\$send_msg_url}\" target=\"_blank\">{\$send_msg_url}</a></br>\n<br>\n再次感谢您对我们的支持。欢迎您的再次光临。 <br>\n<br>\n{\$shop_name} </br>\n{\$send_date}",
                'last_modify'       => '1194823291',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '4',
                'template_code'     => 'order_cancel',
                'is_html'           => '0',
                'template_subject'  => '订单取消',
                'template_content'  => "亲爱的{\$order.consignee}，你好！ \n\n您的编号为：{\$order.order_sn}的订单已取消。\n\n{\$shop_name}\n{\$send_date}",
                'last_modify'       => '1156491130',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '5',
                'template_code'     => 'order_invalid',
                'is_html'           => '0',
                'template_subject'  => '订单无效',
                'template_content'  => "亲爱的{\$order.consignee}，你好！\n\n您的编号为：{\$order.order_sn}的订单无效。\n\n{\$shop_name}\n{\$send_date}",
                'last_modify'       => '1156491164',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '6',
                'template_code'     => 'send_bonus',
                'is_html'           => '0',
                'template_subject'  => '发红包',
                'template_content'  => "亲爱的{\$user_name}您好！\n\n恭喜您获得了{\$count}个红包，金额{if \$count > 1}分别{/if}为{\$money}\n\n{\$shop_name}\n{\$send_date}\n",
                'last_modify'       => '1156491184',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '7',
                'template_code'     => 'group_buy',
                'is_html'           => '1',
                'template_subject'  => '团购商品',
                'template_content'  => '<p>亲爱的{$consignee}，您好！<br/><br/>您于{$order_time}在本店参加团购商品活动，所购买的商品名称为：{$goods_name}，数量：{$goods_number}，订单号为：{$order_sn}，订单金额为：{$order_amount}<br/><br/>此团购商品现在已到结束日期，并达到最低价格，您现在可以对该订单付款。<br/><br/>请尽快登录到用户中心，查看您的订单详情信息。 <br/><br/>{$shop_name} <br/><br/>{$send_date}</p>',
                'last_modify'       => '1441161456',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '8',
                'template_code'     => 'register_validate',
                'is_html'           => '1',
                'template_subject'  => '邮件验证',
                'template_content'  => "{\$user_name}您好！<br><br>\r\n\r\n这封邮件是 {\$shop_name} 发送的。你收到这封邮件是为了验证你注册邮件地址是否有效。如果您已经通过验证了，请忽略这封邮件。<br>\r\n请点击以下链接(或者复制到您的浏览器)来验证你的邮件地址:<br>\r\n<a href=\"{\$validate_email}\" target=\"_blank\">{\$validate_email}</a><br><br>\r\n\r\n{\$shop_name}<br>\r\n{\$send_date}",
                'last_modify'       => '1162201031',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '10',
                'template_code'     => 'attention_list',
                'is_html'           => '0',
                'template_subject'  => '关注商品',
                'template_content'  => "亲爱的{\$user_name}您好~\n\n您关注的商品 : {\$goods_name} 最近已经更新,请您查看最新的商品信息\n\n{\$goods_url}\r\n\r\n{$shop_name} \r\n{$send_date}",
                'last_modify'       => '1183851073',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '11',
                'template_code'     => 'remind_of_new_order',
                'is_html'           => '0',
                'template_subject'  => '新订单通知',
                'template_content'  => "亲爱的店长，您好：\r\n   快来看看吧，又有新订单了。\r\n    订单号:{\$order.order_sn} \r\n 订单金额:{\$order.order_amount}，\r\n 用户购买商品:{foreach from=\$goods_list item=goods_data}{\$goods_data.goods_name}(货号:{\$goods_data.goods_sn})    {/foreach} \r\n\r\n 收货人:{\$order.consignee}， \r\n 收货人地址:{\$order.address}，\r\n 收货人电话:{\$order.tel} {\$order.mobile}, \r\n 配送方式:{\$order.shipping_name}(费用:{\$order.shipping_fee}), \r\n{if \$order.pay_id eq 1}\r\n 付款方式:{\$order.pay_name}(费用:{\$order.surplus})。\r\n{else}\r\n 付款方式:{\$order.pay_name}(费用:{\$order.pay_fee})。\r\n{/if}\r\n\r\n               系统提醒\r\n               {\$send_date}",
                'last_modify'       => '1433268639',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '12',
                'template_code'     => 'goods_booking',
                'is_html'           => '1',
                'template_subject'  => '缺货回复',
                'template_content'  => '亲爱的{$user_name}。你好！</br></br>{$dispose_note}</br></br>您提交的缺货商品链接为</br></br><a href="{$goods_link}" target="_blank">{$goods_name}</a></br><br>{$shop_name} </br>{$send_date}',
                'last_modify'       => '0',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '13',
                'template_code'     => 'user_message',
                'is_html'           => '1',
                'template_subject'  => '留言回复',
                'template_content'  => '亲爱的{$user_name}。你好！</br></br>对您的留言：</br>{$message_content}</br></br>店主作了如下回复：</br>{$message_note}</br></br>您可以随时回到店中和店主继续沟通。</br>{$shop_name}</br>{$send_date}',
                'last_modify'       => '0',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '14',
                'template_code'     => 'recomment',
                'is_html'           => '1',
                'template_subject'  => '用户评论回复',
                'template_content'  => '亲爱的{$user_name}。你好！</br></br>对您的评论：</br>“{$comment}”</br></br>店主作了如下回复：</br>“{$recomment}”</br></br>您可以随时回到店中和店主继续沟通。</br>{$shop_name}</br>{$send_date}',
                'last_modify'       => '0',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '15',
                'template_code'     => 'sale_notice',
                'is_html'           => '1',
                'template_subject'  => '降价通知',
                'template_content'  => "<p>{\$user_name}您好！<br />\r\n<br />\r\n您期望的商品 ({\$goods_name}) 已降价，请点击以下链接(或者复制到您的浏览器):<br />\r\n<br />\r\n<a target=\"_blank\" href=\"{\$goods_link}\">{\$goods_link}</a><br />\r\n<br />\r\n此信息无需回复！<br />\r\n<br />\r\n<br />\r\n{\$send_date}</p>",
                'last_modify'       => '1407196355',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '26',
                'template_code'     => 'send_validate',
                'is_html'           => '1',
                'template_subject'  => '发送验证码',
                'template_content'  => '<p>{$user_name}您好！<br/> <br/> 您的验证码为：{$code}，请在页面中输入以完成验证。如非本人操作，请忽略本短信。如有问题请拨打客服电话：{$service_phone}。<br/> <br/> {$shop_name}<br/> {$send_date}</p>',
                'last_modify'       => '1443408734',
                'last_send'         => '0',
                'type'              => 'template'
            ),
            array(
                'template_id'       => '27',
                'template_code'     => '抢单成功',
                'is_html'           => '0',
                'template_subject'  => '抢单成功',
                'template_content'  => '您已成功抢到配送单号，单号为：{$express_info.express_sn}。',
                'last_modify'       => '1482116824',
                'last_send'         => '0',
                'type'              => 'push'
            ),
            array(
                'template_id'       => '28',
                'template_code'     => '系统派单',
                'is_html'           => '0',
                'template_subject'  => '系统派单',
                'template_content'  => '有单啦！系统已分配配送单（{$express_info.express_sn}）到您账户，赶快行动起来吧！',
                'last_modify'       => '1482118095',
                'last_send'         => '0',
                'type'              => 'push'
            ),
            array(
                'template_id'       => '29',
                'template_code'     => '取货成功',
                'is_html'           => '0',
                'template_subject'  => '取货成功',
                'template_content'  => '您已成功取得配送单号为：{$express_info.express_sn}的配送货物',
                'last_modify'       => '1482175925',
                'last_send'         => '0',
                'type'              => 'push'
            ),
            array(
                'template_id'       => '30',
                'template_code'     => '配送成功',
                'is_html'           => '0',
                'template_subject'  => '配送成功',
                'template_content'  => '买家已成功确认收货，配送单号为：{$express_info.express_sn}。',
                'last_modify'       => '1482176182',
                'last_send'         => '0',
                'type'              => 'push'
            ),
            array(
                'template_id'       => '31',
                'template_code'     => '客户下单',
                'is_html'           => '0',
                'template_subject'  => '客户下单',
                'template_content'  => '客户已下单，订单号为：{$order.order_sn}，订单金额为：{$order.order_amount}。',
                'last_modify'       => '1483050309',
                'last_send'         => '0',
                'type'              => 'push'
            ),
            array(
                'template_id'       => '32',
                'template_code'     => '客户付款',
                'is_html'           => '0',
                'template_subject'  => '客户付款',
                'template_content'  => '订单号：{$order.order_sn}，客户已付款。',
                'last_modify'       => '1483050347',
                'last_send'         => '0',
                'type'              => 'push'
            ),
            array(
                'template_id'       => '33',
                'template_code'     => '发货通知',
                'is_html'           => '0',
                'template_subject'  => '发货通知',
                'template_content'  => '订单号为：{$order.order_sn}，商家已发货，请注意查收！',
                'last_modify'       => '1483050408',
                'last_send'         => '0',
                'type'              => 'push'
            ),
        );

        RC_DB::table('mail_templates')->truncate();
        RC_DB::table('mail_templates')->insert($data);
    }
}