<?php

namespace Ecjia\App\Weapp;

use RC_Cache;
use Ecjia\App\Platform\Frameworks\Platform\AccountManager;

class WxaCode
{
    protected $uuid;

    public function __construct($uuid = null)
    {
        $this->uuid = $uuid;
    }

    public function defaultWeappUUID()
    {
        $uuid = with(new AccountManager())->getDefaultUUID('weapp');

        return $uuid;
    }

    /**
     * @param $scene
     * @param null $uuid
     * @return bool|\ecjia_error|\Psr\Http\Message\StreamInterface|string
     */
    public function defaultWxaCode($scene, $uuid = null)
    {
        $qrimg = $this->getCacheImage($scene);
        if (empty($qrimg)) {
            if (is_null($uuid)) {
                $this->uuid = $this->defaultWeappUUID();
            }

            if (empty($this->uuid)) {
                return new \ecjia_error('not_found_weapp_uuid', __('没有可用的小程序的UUID参数', 'weapp'));
            }

            $weappUUID = new WeappUUID($this->uuid);
            $weapp     = $weappUUID->getWeapp();

            $stream = $weapp->qrcode->getAppCodeUnlimit($scene);

            if ($stream instanceof \Psr\Http\Message\StreamInterface) {
                $qrimg = $this->getStreamContents($stream);
            } else {
                $qrimg = null;
            }

            $this->setCacheImage($scene, $qrimg);
        }

        return $qrimg;
    }

    protected function setCacheImage($key, $img)
    {
        $img = base64_encode($img);
        RC_Cache::app_cache_set($this->uuid . $key, $img, 'weapp', 1296000);
    }

    protected function getCacheImage($key)
    {
        $img = RC_Cache::app_cache_get($this->uuid . $key, 'weapp');
        return base64_decode($img);
    }

    /**
     * 获取店铺小程序二维码
     */
    public function getStoreWxaCode($storeid)
    {
        if (empty($storeid)) {
            $storeid = 0;
        }

        $scene = 'storeid:' . $storeid;
        $qrimg = $this->defaultWxaCode($scene);
        return $qrimg;
    }

    /**
     * @param \Psr\Http\Message\StreamInterface $stream
     * @return mixed
     */
    public function getStreamContents($stream)
    {
        $stream->rewind();
        $contents = $stream->getContents();
        return $contents;
    }

}

// end