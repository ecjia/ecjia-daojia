<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/3
 * Time: 09:50
 */

namespace Ecjia\System\Admins\UpgradeCheck;

use ecjia_cloud;

class CloudCheck
{

    protected $shop_type;

    public function __construct()
    {
        $this->shop_type = config('site.shop_type');

    }

    /**
     * Check current version file update readme
     * @return array | \ecjia_error
     */
    public function checkCurrentVersion()
    {
        $params = [
            'shop_type' => $this->shop_type,
            'version' => config('release.version'),
            'build' => config('release.build'),
        ];
        $cloud = ecjia_cloud::instance()->api('product/upgrade/checkversion')->data($params)->cacheTime(6 * HOUR_IN_SECONDS)->run();
        if ($cloud->getStatus() == ecjia_cloud::STATUS_ERROR) {
            return $cloud->getError();
        } else {
            $data = $cloud->getReturnData();
        }

        return $data;
    }

}