<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/23
 * Time: 11:56 AM
 */

namespace Ecjia\App\Market\Activities;


use Ecjia\App\Market\MarketAbstract;

class MobileShake extends MarketAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'mobile_shake';

    /**
     * 名称
     * @var string
     */
    protected $name = '手机摇一摇';

    /**
     * 描述
     * @var string
     */
    protected $description = '通过手机摇一摇参与活动';

    /**
     * 图标
     * @var string
     */
    protected $icon = '/statics/images/icon/mobile_shake.png'; //图片未添加

    /**
     * 支持平台
     * @var int
     */
    protected $support_platform = self::PLATFORM_APP;

    /**
     * 支持帐号类型
     * @var int
     */
    protected $display_type = self::DISPLAY_ADMIN;


    protected $account_type = self::ACCOUNT_ADMIN | self::ACCOUNT_MERCHANT;


    public function run()
    {



    }


}