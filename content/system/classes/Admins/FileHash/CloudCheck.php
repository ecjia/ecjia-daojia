<?php
/**
 * Created by PhpStorm.
 * User: royalwang
 * Date: 2018/12/3
 * Time: 09:50
 */

namespace Ecjia\System\Admins\FileHash;

use ecjia_cloud;

class CloudCheck
{

    protected $shop_type;

    public function __construct()
    {
        $this->shop_type = config('site.shop_type');

    }

    /**
     * Check current version file hash
     * @param $dir
     * @return array
     */
    public function checkCurrentVersion($dir)
    {
        $dir = trim($dir, '/\\');
        $dir = str_replace(['/', '\\'], '_', $dir);
        $params = [
            'shop_type' => $this->shop_type,
            'version' => config('release.version'),
            'dir' => $dir,
        ];
        $cloud = ecjia_cloud::instance()->api('product/filehash/checkversion')->data($params)->cacheTime(6 * HOUR_IN_SECONDS)->run();
        if ($cloud->getStatus() == ecjia_cloud::STATUS_ERROR) {
            $data = '';
        } else {
            $data = $this->decodeData($cloud->getReturnData());
        }

        return $data;
    }


    /**
     * Check lastest version file hash
     * @param $dir
     * @return array
     */
    public function checklastestVersion($dir)
    {
        $params = [
            'shop_type' => $this->shop_type,
            'version' => 'lastest',
            'dir' => $dir,
        ];
        $cloud = ecjia_cloud::instance()->api('product/filehash/checkversion')->data($params)->cacheTime(6 * HOUR_IN_SECONDS)->run();
        if ($cloud->getStatus() == ecjia_cloud::STATUS_ERROR) {
            $data = '';
        } else {
            $data = $this->decodeData($cloud->getReturnData());
        }

        return $data;
    }

    protected function decodeData($data)
    {
        return gzdecode(base64_decode($data['hashdata']));
    }

}