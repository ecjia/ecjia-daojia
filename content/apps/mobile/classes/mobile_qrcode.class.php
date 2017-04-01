<?php

class mobile_qrcode
{
    
    public static function QrSizeCmToPx()
    {
        return [
        	'8cm'  => '258',
            '12cm' => '344',
            '15cm' => '430',
            '30cm' => '860',
            '50cm' => '1280',
        ];
    }
    
    
    public static function getApiUrl()
    {
        RC_Package::package('app::touch')->loadClass('ecjia_touch_manager', false);
        $url = with(new ecjia_touch_manager())->serverHost();
        return $url;
    }
    
    
    public static function makeStreetEcjiaOpenUrl($url)
    {
        $url = base64url_encode($url);
        return 'ecjiaopen://app?open_type=street&key='.$url;
    }
    
    /**
     * 创建二维码并保存
     * @param string $url
     * @param number $size
     */
    public static function createStreetQrcode($url, $size = 430)
    {
        
        $mobile_app_icon = ecjia_config::get('mobile_app_icon');
        $icon_path = RC_Upload::upload_path().$mobile_app_icon;

        $save_dir = RC_Upload::upload_path().'data/qrcodes/';
        
        $save_path = $save_dir.'street_qrcode_'.$size.'.png';
        
        if (! is_dir($save_dir)) {
            RC_File::makeDirectory($save_dir);
        }
        
        $url = self::makeStreetEcjiaOpenUrl($url);
        
        RC_QrCode::format('png')->size($size)->margin(1)
                    ->merge($icon_path, 0.2, true)
                    ->errorCorrection('H')
                    ->generate($url, $save_path);
        
    }
    
    
    /**
     * 获取默认的二维码图片
     * @return string
     */
    public static function getDefaultQrcodeUrl()
    {
        $size = 430;
        $file_path = RC_Upload::upload_path().'data/qrcodes/street_qrcode_'.$size.'.png';
        
        if (! RC_File::exists($file_path))
        {
            self::createStreetQrcode(self::getApiUrl(), $size);
        }
        
        return self::getStreetQrcodeUrl($size);
    }
    
    /**
     * 获取二维码的Url
     * @param number $size
     * @return string
     */
    public static function getStreetQrcodeUrl($size)
    {
        $file_path = RC_Upload::upload_path().'data/qrcodes/street_qrcode_'.$size.'.png';
        
        if (RC_File::exists($file_path))
        {
            $url = RC_Upload::upload_url().'/data/qrcodes/street_qrcode_'.$size.'.png';
        }
        else 
        {
            $url = RC_Upload::upload_url().'/data/qrcodes/street_qrcode_430.png';
        }

        return $url;
    }
    
    
    /**
     * 获取二维码的Path
     * @param number $size
     * @return string
     */
    public static function getStreetQrcodePath($size)
    {
        $file_path = RC_Upload::upload_path().'data/qrcodes/street_qrcode_'.$size.'.png';
    
        if (! RC_File::exists($file_path))
        {
            $file_path = RC_Upload::upload_path().'data/qrcodes/street_qrcode_430.png';
        }
    
        return $file_path;
    }
    
}

// end