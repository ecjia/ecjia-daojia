<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2019-03-29
 * Time: 16:22
 */

namespace Ecjia\Resources\Components\SettingComponents;


use Ecjia\Component\Config\Component\ComponentAbstract;

class CashierSetting extends ComponentAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'cashier';

    /**
     * 排序
     * @var int
     */
    protected $sort = 20;

    public function __construct()
    {
        $this->name = __('收银台设置', 'setting');
    }


    public function handle()
    {
        $config = [

            [
                'cfg_code' => 'cashier_dscmall_rpc_appid',
                'cfg_name' => __('对接大商创RPC帐号', 'setting'),
                'cfg_desc' => __('从RPC帐号列表中选出对接大商创使用的RPC帐号的AppID填入这里，以便对接大商创使用。', 'setting'),
                'cfg_range' => '',
                'cfg_value' => '',
                'cfg_type' => 'text',
            ],

        ];

        return $config;
    }
}