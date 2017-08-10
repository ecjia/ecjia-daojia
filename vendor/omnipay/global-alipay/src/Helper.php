<?php

namespace Omnipay\GlobalAlipay;

class Helper
{

    /**
     * @param array  $data
     * @param string $algorithm
     * @param mixed  $key
     *
     * @return null|string
     */
    public static function sign($data, $algorithm, $key)
    {
        $algorithm = strtoupper($algorithm);

        unset($data['sign']);
        unset($data['sign_type']);

        ksort($data);
        reset($data);

        $query = urldecode(http_build_query($data));

        if ($algorithm == 'MD5') {
            return self::signWithMD5($query, $key);
        } elseif ($algorithm == 'RSA' || $algorithm == '0001') {
            return self::signWithRSA($query, $key);
        } else {
            return null;
        }
    }


    public static function signWithMD5($string, $key)
    {
        return md5($string . $key);
    }


    public static function signWithRSA($data, $privateKey)
    {
        $privateKey = self::prefixCertificateKeyPath($privateKey);
        $res        = openssl_pkey_get_private($privateKey);
        openssl_sign($data, $sign, $res);
        openssl_free_key($res);
        $sign = base64_encode($sign);

        return $sign;
    }


    protected static function prefixCertificateKeyPath($key)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) != 'WIN' && is_file($key) && substr($key, 0, 7) != 'file://') {
            $key = 'file://' . $key;
        }

        return $key;
    }
}
