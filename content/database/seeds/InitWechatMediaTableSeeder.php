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
 * 插入数据 `ecjia_wechat_media` 公众平台素材
 */
use Royalcms\Component\Database\Seeder;

class InitWechatMediaTableSeeder extends Seeder
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
                'id'            => '8',
                'wechat_id'     => '1',
                'title'         => '刮刮卡',
                'command'       => '',
                'author'        => '送钱',
                'is_show'       => '0',
                'digest'        => '',
                'content'       => '快来参与活动吧~',
                'link'          => 'http://',
                'file'          => 'data/material/article_pic/1482882806091914522.jpg',
                'size'          => '58461',
                'file_name'     => '1461276939912481394.jpg',
                'thumb'         => 'H6E2uaqwtV-Tv4NX-LZTNCeQT05O1uIB7n_wj9osyis',
                'add_time'      => '1482882806',
                'edit_time'     => '0',
                'type'          => 'news',
                'article_id'    => 'NULL',
                'sort'          => '0',
                'media_id'      => 'H6E2uaqwtV-Tv4NX-LZTNE8CJDmZel0M3qnGn3X3IW0',
                'is_material'   => 'material',
                'media_url'     => 'http://mmbiz.qpic.cn/mmbiz_jpg/2nNkHAwhB9ibAHZZeG9vWBBdibMPzOTCaFUG7qsaOKDOMkVl95yOQmg1s9xJrNOTvEYVa8uKd63Ms5wVYtUCD0cA/0?wx_fmt=jpeg',
                'parent_id'     => '0'
            ),
            array(
                'id'            => '9',
                'wechat_id'     => '1',
                'title'         => '大转盘',
                'command'       => '',
                'author'        => '送钱',
                'is_show'       => '0',
                'digest'        => '',
                'content'       => '快来参与活动吧~',
                'link'          => 'http://',
                'file'          => 'data/material/article_pic/1482882832471535442.jpg',
                'size'          => '59336',
                'file_name'     => '59336',
                'thumb'         => 'H6E2uaqwtV-Tv4NX-LZTNOaKH8ZDquIv89U28hsBDtU',
                'add_time'      => '1482882832',
                'edit_time'     => '0',
                'type'          => 'news',
                'article_id'    => 'NULL',
                'sort'          => '0',
                'media_id'      => 'H6E2uaqwtV-Tv4NX-LZTNIe1GoCZrGz-u4DraY-7uco',
                'is_material'   => 'material',
                'media_url'     => 'http://mmbiz.qpic.cn/mmbiz_jpg/2nNkHAwhB9ibAHZZeG9vWBBdibMPzOTCaFcpwoYno9c6FU7c8aAicy2Ly27IuAvtZwLASzaghDPgt6KzVOh8iaBnoQ/0?wx_fmt=jpeg',
                'parent_id'     => '0'
            ),
            array(
                'id'            => '10',
                'wechat_id'     => '1',
                'title'         => '砸金蛋',
                'command'       => '',
                'author'        => '送钱',
                'is_show'       => '0',
                'digest'        => '',
                'content'       => '<p>快来参与活动吧~</p>',
                'link'          => 'http://',
                'file'          => 'data/material/article_pic/1482882850786227357.jpg',
                'size'          => '121246',
                'file_name'     => '1461276892427132174.jpg',
                'thumb'         => 'H6E2uaqwtV-Tv4NX-LZTNAtcdRH6PiYpWQPwI6VoZa4',
                'add_time'      => '1482882850',
                'edit_time'     => '1482945605',
                'type'          => 'news',
                'article_id'    => 'NULL',
                'sort'          => '0',
                'media_id'      => 'H6E2uaqwtV-Tv4NX-LZTNOetcn2GJBsROmiMDohvaZw',
                'is_material'   => 'material',
                'media_url'     => 'http://mmbiz.qpic.cn/mmbiz_jpg/2nNkHAwhB9ibAHZZeG9vWBBdibMPzOTCaFiaSYicIiaO6qaIDv7u4tydWLFNIEBiaoic3OVqkuaLReF9VGicImbIJYy7Rg/0?wx_fmt=jpeg',
                'parent_id'     => '0'
            ),
            array(
                'id'            => '12',
                'wechat_id'     => '1',
                'title'         => '图文',
                'command'       => '',
                'author'        => 'sqq',
                'is_show'       => '0',
                'digest'        => '',
                'content'       => '<p>测试输入图文返回结果<br/></p><br/>',
                'link'          => 'http://',
                'file'          => 'data/material/article_pic/1482883207991092789.jpg',
                'size'          => '155049',
                'file_name'     => '55597e6dN0e85e13a.jpg',
                'thumb'         => 'H6E2uaqwtV-Tv4NX-LZTNOb6h86FXniQiDmbgS1iTWg',
                'add_time'      => '1482883207',
                'edit_time'     => '0',
                'type'          => 'news',
                'article_id'    => 'NULL',
                'sort'          => '0',
                'media_id'      => 'H6E2uaqwtV-Tv4NX-LZTNA7Xl1nqD95me9sNHcpiDQs',
                'is_material'   => 'material',
                'media_url'     => 'http://mmbiz.qpic.cn/mmbiz_jpg/2nNkHAwhB9ibAHZZeG9vWBBdibMPzOTCaFC7r45P76xia6iavtian8ZHicHkRxgiaBKH1jxXWnL8aQiaqrHQxZzLUdf9TQ/0?wx_fmt=jpeg',
                'parent_id'     => '0'
            ),
            array(
                'id'            => '13',
                'wechat_id'     => '1',
                'title'         => '视频',
                'command'       => '',
                'author'        => 'NULL',
                'is_show'       => '0',
                'digest'        => '视频',
                'content'       => '',
                'link'          => 'NULL',
                'file'          => 'data/material/video/1482883351872959231.mp4',
                'size'          => '5251929',
                'file_name'     => 'test1.mp4',
                'thumb'         => 'NULL',
                'add_time'      => '1482883351',
                'edit_time'     => '0',
                'type'          => 'video',
                'article_id'    => 'NULL',
                'sort'          => '0',
                'media_id'      => 'H6E2uaqwtV-Tv4NX-LZTNLqtSGzbbLit0ikEy5wJd_Y',
                'is_material'   => 'material',
                'media_url'     => '',
                'parent_id'     => '0'
            )
        );

        RC_DB::table('wechat_media')->truncate();
        RC_DB::table('wechat_media')->insert($data);
    }
}