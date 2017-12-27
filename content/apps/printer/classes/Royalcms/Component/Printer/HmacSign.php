<?php

namespace Royalcms\Component\Printer;

class HmacSign
{
    
    /**
     * 生成签名
     * @param  array  $params 待签参数
     * @return string
     */
    public static function generateSign(array $params, $secret)
    {
        return self::generateHmacSign($params, $secret);
    }
    
    
    /**
     * 按hmac方式生成签名
     * @param  array  $params 待签的参数
     * @return string
     */
    protected static function generateHmacSign($params, $secret)
    {
        static::sortParams($params);  // 排序
    
        $arr = [];
        foreach ($params as $k => $v) {
            $arr[] = $k . $v;
        }
    
        $str = implode('', $arr);
    
        return strtolower(hash_hmac('md5', $str, $secret));
    }
    
    
    /**
     * 待签名参数排序
     * @param  array  &$params 参数
     * @return array
     */
    protected static function sortParams(array &$params)
    {
        ksort($params);
    }
    
}

// end