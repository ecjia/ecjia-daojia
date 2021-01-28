<?php

namespace Royalcms\Component\Pay\PayVendor\Alipay;

use Royalcms\Component\Pay\Exceptions\GatewayException;
use Royalcms\Component\Pay\Exceptions\InvalidConfigException;
use Royalcms\Component\Pay\Exceptions\InvalidSignException;
use Royalcms\Component\Pay\Log;
use Royalcms\Component\Pay\Traits\HasHttpRequest;
use Royalcms\Component\Support\Arr;
use Royalcms\Component\Support\Collection;
use Royalcms\Component\Support\Str;

class Support
{
    use HasHttpRequest;

    /**
     * Alipay gateway.
     *
     * @var string
     */
    protected $baseUri = 'https://openapi.alipay.com/gateway.do';

    /**
     * Instance.
     *
     * @var Support
     */
    private static $instance;

    /**
     * Bootstrap.
     */
    private function __construct()
    {
    }

    /**
     * Get instance.
     *
     * @return Support
     */
    public static function getInstance()
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Get Alipay API result.
     *
     * @param array  $data
     * @param string $publicKey
     *
     * @throws GatewayException
     * @throws InvalidConfigException
     * @throws InvalidSignException
     *
     * @return Collection
     */
    public static function requestApi(array $data, $publicKey)
    {
        Log::debug('Request To Alipay Api', [self::getInstance()->baseUri(), $data]);

        $data = array_filter($data, function ($value) {
            return ($value == '' || is_null($value)) ? false : true;
        });

        $result = mb_convert_encoding(self::getInstance()->post('', $data), 'utf-8', 'gb2312');
        $result = json_decode($result, true);

        $method = str_replace('.', '_', $data['method']).'_response';

        if (!isset($result['sign']) || !isset($result[$method]['code']) || $result[$method]['code'] != '10000') {
            throw new GatewayException(
                'Get Alipay API Error:'.$result[$method]['msg'].(isset($result[$method]['sub_code']) ? $result[$method]['sub_code'] : ''),
                $result,
                $result[$method]['code']
            );
        }

        if (self::verifySign($result[$method], $publicKey, true, $result['sign'])) {
            return new Collection($result[$method]);
        }

        Log::warning('Alipay Sign Verify FAILED', $result);

        throw new InvalidSignException('Alipay Sign Verify FAILED', $result);
    }

    /**
     * Generate sign.
     *
     * @param array  $params
     * @param string $privateKey
     *
     * @throws InvalidConfigException
     *
     * @return string
     */
    public static function generateSign(array $params, $privateKey = null)
    {
        if (is_null($privateKey)) {
            throw new InvalidConfigException('Missing Alipay Config -- [private_key]');
        }

        if (Str::endsWith($privateKey, '.pem')) {
            $privateKey = openssl_pkey_get_private($privateKey);
        } else {
            $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n".
                wordwrap($privateKey, 64, "\n", true).
                "\n-----END RSA PRIVATE KEY-----";
        }

        openssl_sign(self::getSignContent($params), $sign, $privateKey, OPENSSL_ALGO_SHA256);

        return base64_encode($sign);
    }

    /**
     * Verify sign.
     *
     * @param array       $data
     * @param string      $publicKey
     * @param bool        $sync
     * @param string|null $sign
     *
     * @throws InvalidConfigException
     *
     * @return bool
     */
    public static function verifySign(array $data, $publicKey = null, $sync = false, $sign = null)
    {
        if (is_null($publicKey)) {
            throw new InvalidConfigException('Missing Alipay Config -- [ali_public_key]');
        }

        if (Str::endsWith($publicKey, '.pem')) {
            $publicKey = openssl_pkey_get_public($publicKey);
        } else {
            $publicKey = "-----BEGIN PUBLIC KEY-----\n".
                wordwrap($publicKey, 64, "\n", true).
                "\n-----END PUBLIC KEY-----";
        }

        $sign = isset($sign) ? $sign : $data['sign'];

        $toVerify = $sync ? mb_convert_encoding(json_encode($data, JSON_UNESCAPED_UNICODE), 'gb2312', 'utf-8') :
                            self::getSignContent($data, true);

        return openssl_verify($toVerify, base64_decode($sign), $publicKey, OPENSSL_ALGO_SHA256) === 1;
    }

    /**
     * Get signContent that is to be signed.
     *
     * @param array $data
     * @param bool  $verify
     *
     * @return string
     */
    public static function getSignContent(array $data, $verify = false)
    {
        $data = self::encoding($data, isset($data['charset']) ? $data['charset'] : 'gb2312', 'utf-8');

        ksort($data);

        $stringToBeSigned = '';
        foreach ($data as $k => $v) {
            if ($verify && $k != 'sign' && $k != 'sign_type') {
                $stringToBeSigned .= $k.'='.$v.'&';
            }
            if (!$verify && $v !== '' && !is_null($v) && $k != 'sign' && '@' != substr($v, 0, 1)) {
                $stringToBeSigned .= $k.'='.$v.'&';
            }
        }

        return trim($stringToBeSigned, '&');
    }

    /**
     * Convert encoding.
     *
     * @param string|array $data
     * @param string       $to
     * @param string       $from
     *
     * @return array
     */
    public static function encoding($data, $to = 'utf-8', $from = 'gb2312')
    {
        return Arr::encoding((array) $data, $to, $from);
    }

    /**
     * Alipay gateway.
     *
     * @param string $mode
     *
     * @return string
     */
    public static function baseUri($mode = null)
    {
        switch ($mode) {
            case 'dev':
                self::getInstance()->baseUri = 'https://openapi.alipaydev.com/gateway.do';
                break;

            default:
                break;
        }

        return self::getInstance()->baseUri;
    }
}
