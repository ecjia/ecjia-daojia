<?php

namespace Ecjia\App\Mobile;

use RC_Uri;
use RC_QrCode;
use RC_Cache;

class UrlTempQrcode 
{
    protected $url;
    
    public function __construct($url = null)
    {
        if (is_null($url)) {
            $this->url = RC_Uri::current_url();
            $this->url = str_replace('&_pjax=.ecjia', '', $this->url);
        } else {
            $this->url = $url;
        }
    }
    
    
    /**
     * 创建二维码
     * @param number $size
     */
    public function getQrcodeBase64($size = 430)
    {
        $cacheKey = md5($this->url);
        $qrcode = RC_Cache::app_cache_get($cacheKey, 'mobile');
        if (empty($qrcode)) {
            $qrcode = RC_QrCode::format('png')->size($size)->margin(1)
                        ->errorCorrection('L')
                        ->generate($this->url);
            $qrcode = base64_encode($qrcode);
            RC_Cache::app_cache_set($cacheKey, $qrcode, 'mobile');
        }
        
        return $qrcode;
    }
    
}

// end