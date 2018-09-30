<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/9/12
 * Time: 10:47 AM
 */

namespace Ecjia\App\Platform\Frameworks\Platform;

use Ecjia\App\Platform\Models\PlatformAccountModel;

class AccountManager
{

    protected $shopid;

    public function __construct($shopid = 0)
    {
        $this->shopid = $shopid;
    }

    /**
     * 获取指定平台的公众号列表
     * @param string $platform
     */
    public function getAccountList($platform) {

        $accountlist = PlatformAccountModel::where('platform', $platform)
            ->where('shop_id', $this->shopid)
            ->where('status', 1)
            ->orderBy('sort', 'DESC')
            ->orderBy('id', 'DESC')
            ->get();

        return $accountlist;
    }

    /**
     * 判断UUID是否属于账号的
     * @param string $platform
     * @param string $uuid
     * @param number $shopid
     * @return boolean
     */
    public function hasAccountUUID($platform, $uuid) {
        $account_list = $this->getAccountList($platform);
        if(!empty($account_list)) {
            foreach ($account_list as $item => $val) {
                $uuids[] = $val['uuid'];
            }
            if (in_array($uuid, $uuids)) {
                return true;
            }
            return false;
        }
    }

    /**
     * 获取默认的UUID
     * @param $platform
     */
    public function getDefaultUUID($platform)
    {
        $accountlist = $this->getAccountList($platform);
        $default = array_first($accountlist);
        return $default->uuid;
    }




}