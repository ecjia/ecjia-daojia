<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/7/23
 * Time: 12:00 PM
 */

namespace Ecjia\App\Market\Activities;

use Ecjia\App\Market\MarketAbstract;

class WechatDaZhuanPan extends MarketAbstract
{

    /**
     * 代号标识
     * @var string
     */
    protected $code = 'wechat_dazhuangpan';

    /**
     * 名称
     * @var string
     */
    protected $name = '微信大转盘';

    /**
     * 描述
     * @var string
     */
    protected $description = '在微信上参与的大转盘抽奖活动';

    /**
     * 图标
     * @var string
     */
    protected $icon = '/statics/images/icon/wechat_dazhuangpan.png'; //图片未添加


    /**
     * 支持平台
     * @var int
     */
    protected $support_platform = self::PLATFORM_WECHAT;

    /**
     * 支持帐号类型
     * @var int
     */
    protected $display_type = self::DISPLAY_PLATFORM;

    protected $account_type = self::ACCOUNT_ADMIN | self::ACCOUNT_MERCHANT;


    public function run()
    {



    }

}