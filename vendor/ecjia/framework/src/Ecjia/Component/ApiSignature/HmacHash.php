<?php


namespace Ecjia\Component\ApiSignature;


class HmacHash
{

    /**
     * hash_hmac的计算，也可使用
     * string hash_hmac ( string $algo , string $data , string $key [, bool $raw_output = false ] )
     * @param string $key
     * @param string $data
     * @return string
     */
    public static function hash($key, $data)
    {
        // 创建 md5的HMAC

        $b = 64; // md5加密字节长度
        if (strlen($key) > $b) {
            $key = pack("H*",md5($key));
        }
        $key  = str_pad($key, $b, chr(0x00));
        $ipad = str_pad('', $b, chr(0x36));
        $opad = str_pad('', $b, chr(0x5c));
        $k_ipad = $key ^ $ipad;
        $k_opad = $key ^ $opad;

        return md5($k_opad  . pack("H*", md5($k_ipad . $data)));
    }

}