<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-29
 * Time: 16:22
 */

namespace Ecjia\Resources\Components\SettingComponents;


use Ecjia\Component\Config\Component\ComponentAbstract;

class UserSetting extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'user';

    /**
     * 排序
     * @var int
     */
    protected $sort = 18;

    public function __construct()
    {
        $this->name = __('会员设置', 'setting');
    }


    public function handle()
    {
        $config = [

            [
                'cfg_code' => 'user_notice',
                'cfg_name' => __('用户中心公告', 'setting'),
                'cfg_desc' => __('该信息将在用户中心欢迎页面显示', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '用户中心公告！',
                'cfg_type' => 'textarea',
            ],

            [
                'cfg_code' => 'shop_reg_closed',
                'cfg_name' => __('是否关闭注册', 'setting'),
                'cfg_desc' => __('商店需升级或者其他原因临时关闭网站', 'setting'),
                'cfg_range' => array(
                    '0' => __('否', 'setting'),
                    '1' => __('是', 'setting'),
                ),
                'cfg_value' => '用户中心公告！',
                'cfg_type' => 'select',
            ],

            [
                'cfg_code' => 'member_email_validate',
                'cfg_name' => __('是否开启会员邮件验证', 'setting'),
                'cfg_desc' => __('开启后，会员注册时，系统会自动发送验证码到会员的邮箱', 'setting'),
                'cfg_range' => array(
                    '0' => __('关闭', 'setting'),
                    '1' => __('开启', 'setting'),
                ),
                'cfg_value' => '1',
                'cfg_type' => 'select',
            ],

            [
                'cfg_code' => 'send_verify_email',
                'cfg_name' => __('用户注册时自动发送验证邮件', 'setting'),
                'cfg_desc' => __('“是否开启会员邮件验证”设为开启时才可使用此功能', 'setting'),
                'cfg_range' => array(
                    '0' => __('关闭', 'setting'),
                    '1' => __('开启', 'setting'),
                ),
                'cfg_value' => '0',
                'cfg_type' => 'select',
            ],

            [
                'cfg_code' => 'register_points',
                'cfg_name' => __('会员注册赠送积分', 'setting'),
                'cfg_desc' => __('新人注册可获得的积分奖励。', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '20',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'integral_name',
                'cfg_name' => __('消费积分名称', 'setting'),
                'cfg_desc' => __('您可以将消费积分重新命名。例如：烧币<br>消费积分功能本名叫“积分”，未填写直接显示本名，只影响到前台用户端的显示，不会对后台功能名称作影响', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '积分',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'integral_scale',
                'cfg_name' => __('积分换算比例', 'setting'),
                'cfg_desc' => __('每100积分可抵多少元现金', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '1',
                'cfg_type' => 'text',
            ],

            [
                'cfg_code' => 'integral_percent',
                'cfg_name' => __('积分支付比例', 'setting'),
                'cfg_desc' => __('每100元商品最多可以使用多少元积分', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '1',
                'cfg_type' => 'text',
            ],

        ];

        return $config;
    }
}