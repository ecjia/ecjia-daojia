<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/9/29
 * Time: 1:05 PM
 */

defined('IN_ECJIA') or exit('No permission resources.');

/**
 * 获取公众平台列表
 */
class platform_platform_account_list_api extends Component_Event_Api
{

    /**
     * @param shop_id  店铺ID，默认为0
     * @param platform  平台，wechat 微信，weapp 小程序
     */
    public function call(&$options)
    {
        $shop_id  = array_get($options, 'shop_id', 0);
        $platform = array_get($options, 'platform', 'wechat');

        $accountlist = with(new Ecjia\App\Platform\Frameworks\Platform\AccountManager($shop_id))->getAccountList($platform);

        return $accountlist;
    }


}