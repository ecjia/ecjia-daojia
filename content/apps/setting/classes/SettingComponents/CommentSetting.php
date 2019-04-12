<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-29
 * Time: 16:22
 */

namespace Ecjia\App\Setting\SettingComponents;

use Ecjia\App\Setting\ComponentAbstract;

class CommentSetting extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'comment';


    public function __construct()
    {
        $this->name = __('评价', 'setting');
    }

    public function handle()
    {
        $data = [
            ['code' => 'comment_award_open', 'value' => '0', 'options' => ['type' => 'hidden']],
            ['code' => 'comment_award', 'value' => '0', 'options' => ['type' => 'hidden']],
            ['code' => 'comment_award_rules', 'value' => '', 'options' => ['type' => 'hidden']],
            ['code' => 'comment_check', 'value' => '1', 'options' => ['type' => 'hidden']],

        ];

        return $data;
    }

    public function getConfigs()
    {
        $config = [

            [
                'cfg_code' => 'comment_check',
                'cfg_name' => __('用户评论是否需要审核', 'setting'),
                'cfg_desc' => '',
                'cfg_range' => array(
                    '0' => __('不需要', 'setting'),
                    '1' => __('需要', 'setting'),
                ),
            ],

            [
                'cfg_code' => 'comment_factor',
                'cfg_name' => __('商品评论的条件', 'setting'),
                'cfg_desc' => __('选取较高的评论条件可以有效的减少垃圾评论的产生。只有用户订单完成后才认为该用户有购买行为', 'setting'),
                'cfg_range' => array(
                    '0' => __('所有用户', 'setting'),
                    '1' => __('仅登录用户', 'setting'),
                    '2' => __('有过一次以上购买行为用户', 'setting'),
                    '3' => __('仅购买过该商品用户', 'setting'),
                ),
            ],



        ];

        return $config;
    }

}